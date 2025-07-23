<?php
namespace Models;

class User extends BaseModel {
    protected $table = 'users';

    public function findByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    public function createUser($username, $password) {
        // Check if username already exists
        if ($this->findByUsername($username)) {
            throw new \Exception("Username already exists");
        }

        // Validate username (alphanumeric, 3-20 chars)
        if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
            throw new \Exception("Username must be 3-20 characters long and contain only letters, numbers, and underscores");
        }

        // Validate password (min 6 chars)
        if (strlen($password) < 6) {
            throw new \Exception("Password must be at least 6 characters long");
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        return $this->create([
            'username' => $username,
            'password' => $hashedPassword
        ]);
    }

    public function verifyPassword($userId, $password) {
        $user = $this->find($userId);
        if ($user) {
            return password_verify($password, $user['password']);
        }
        return false;
    }

    public function authenticate($username, $password) {
        $user = $this->findByUsername($username);
        if ($user && password_verify($password, $user['password'])) {
            // Update last login
            $this->update($user['id'], ['last_login' => date('Y-m-d H:i:s')]);
            return $user;
        }
        return false;
    }

    public function getUserStats($userId) {
        $stats = [];

        // Count ratings
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM ratings WHERE user_id = ?");
        $stmt->execute([$userId]);
        $stats['ratings_count'] = $stmt->fetchColumn();

        // Count watchlist items
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM watchlist WHERE user_id = ?");
        $stmt->execute([$userId]);
        $stats['watchlist_count'] = $stmt->fetchColumn();

        // Count watched movies
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM user_movies WHERE user_id = ? AND status = 'watched'");
        $stmt->execute([$userId]);
        $stats['watched_count'] = $stmt->fetchColumn();

        // Average rating given
        $stmt = $this->db->prepare("SELECT AVG(rating) as avg_rating FROM ratings WHERE user_id = ?");
        $stmt->execute([$userId]);
        $stats['avg_rating'] = round($stmt->fetchColumn() ?? 0, 1);

        return $stats;
    }

    public function getUserRatings($userId, $limit = 10, $offset = 0) {
        $stmt = $this->db->prepare("
            SELECT r.*, m.title, m.year, m.poster, m.imdb_id 
            FROM ratings r 
            JOIN movies m ON r.movie_id = m.id 
            WHERE r.user_id = ? 
            ORDER BY r.created_at DESC 
            LIMIT ? OFFSET ?
        ");
        $stmt->execute([$userId, $limit, $offset]);
        return $stmt->fetchAll();
    }

     public function getUserById($userId) {
            return $this->find($userId);
        }

        public function usernameExists($username, $excludeUserId = null) {
            $sql = "SELECT id FROM users WHERE username = ?";
            $params = [$username];

            if ($excludeUserId) {
                $sql .= " AND id != ?";
                $params[] = $excludeUserId;
            }

            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetch() !== false;
        }

        public function emailExists($email, $excludeUserId = null) {
            $sql = "SELECT id FROM users WHERE email = ?";
            $params = [$email];

            if ($excludeUserId) {
                $sql .= " AND id != ?";
                $params[] = $excludeUserId;
            }

            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetch() !== false;
        }

        public function updateProfile($userId, $data) {
            $allowedFields = ['username', 'email', 'bio'];
            $updateData = [];

            foreach ($allowedFields as $field) {
                if (isset($data[$field])) {
                    $updateData[$field] = $data[$field];
                }
            }

            if (empty($updateData)) {
                return false;
            }

            return $this->update($userId, $updateData);
        }

        public function getUserPreferences($userId) {
            $stmt = $this->db->prepare("SELECT * FROM user_preferences WHERE user_id = ?");
            $stmt->execute([$userId]);
            $preferences = $stmt->fetch();

            // Return defaults if no preferences found
            if (!$preferences) {
                return [
                    'email_notifications' => 1,
                    'movie_recommendations' => 1,
                    'rating_privacy' => 'public',
                    'watchlist_privacy' => 'public',
                    'theme_preference' => 'auto',
                    'language' => 'en'
                ];
            }

            return $preferences;
        }

        public function updatePreferences($userId, $preferences) {
            // Check if preferences exist
            $stmt = $this->db->prepare("SELECT user_id FROM user_preferences WHERE user_id = ?");
            $stmt->execute([$userId]);
            $exists = $stmt->fetch();

            $fields = array_keys($preferences);
            $values = array_values($preferences);

            if ($exists) {
                // Update existing preferences
                $setClause = implode(' = ?, ', $fields) . ' = ?';
                $sql = "UPDATE user_preferences SET {$setClause} WHERE user_id = ?";
                $values[] = $userId;
            } else {
                // Insert new preferences
                $fieldsStr = 'user_id, ' . implode(', ', $fields);
                $placeholders = '?, ' . str_repeat('?, ', count($fields) - 1) . '?';
                $sql = "INSERT INTO user_preferences ({$fieldsStr}) VALUES ({$placeholders})";
                array_unshift($values, $userId);
            }

            $stmt = $this->db->prepare($sql);
            return $stmt->execute($values);
        }

        public function exportUserData($userId) {
            $data = [];

            // User profile
            $data['profile'] = $this->find($userId);
            unset($data['profile']['password']); // Don't include password

            // User preferences
            $data['preferences'] = $this->getUserPreferences($userId);

            // User ratings
            $stmt = $this->db->prepare("
                SELECT r.rating, r.created_at, m.title, m.year, m.imdb_id
                FROM ratings r
                JOIN movies m ON r.movie_id = m.id
                WHERE r.user_id = ?
                ORDER BY r.created_at DESC
            ");
            $stmt->execute([$userId]);
            $data['ratings'] = $stmt->fetchAll();

            // Watchlist
            $stmt = $this->db->prepare("
                SELECT w.created_at, m.title, m.year, m.imdb_id
                FROM watchlist w
                JOIN movies m ON w.movie_id = m.id
                WHERE w.user_id = ?
                ORDER BY w.created_at DESC
            ");
            $stmt->execute([$userId]);
            $data['watchlist'] = $stmt->fetchAll();

            // Watched movies
            $stmt = $this->db->prepare("
                SELECT um.watched_at, m.title, m.year, m.imdb_id
                FROM user_movies um
                JOIN movies m ON um.movie_id = m.id
                WHERE um.user_id = ? AND um.status = 'watched'
                ORDER BY um.watched_at DESC
            ");
            $stmt->execute([$userId]);
            $data['watched_movies'] = $stmt->fetchAll();

            return $data;
        }

        public function deactivateAccount($userId) {
            // Mark account as deactivated instead of deleting
            return $this->update($userId, [
                'status' => 'deactivated',
                'deactivated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}