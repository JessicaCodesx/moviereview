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
}