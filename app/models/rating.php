<?php
namespace Models;

class Rating extends BaseModel {
    protected $table = 'ratings';

    public function addRating($movieId, $rating, $userIP = null, $userId = null) {
        try {
            $data = [
                'movie_id' => $movieId,
                'rating' => $rating
            ];

            if ($userId) {
                $data['user_id'] = $userId;
                $data['user_ip'] = $userIP; // Still store IP for logged users
            } else {
                $data['user_ip'] = $userIP;
            }

            // Try to insert new rating
            return $this->create($data);

        } catch (\PDOException $e) {
            // If duplicate, update existing rating
            if ($e->getCode() == 23000) { // Integrity constraint violation
                if ($userId) {
                    // Update by user ID
                    $stmt = $this->db->prepare("UPDATE ratings SET rating = ? WHERE movie_id = ? AND user_id = ?");
                    return $stmt->execute([$rating, $movieId, $userId]);
                } else {
                    // Update by IP (for anonymous users)
                    $stmt = $this->db->prepare("UPDATE ratings SET rating = ? WHERE movie_id = ? AND user_ip = ? AND user_id IS NULL");
                    return $stmt->execute([$rating, $movieId, $userIP]);
                }
            }
            throw $e;
        }
    }

    public function getAverageRating($movieId) {
        $stmt = $this->db->prepare("SELECT AVG(rating) as average, COUNT(*) as count FROM ratings WHERE movie_id = ?");
        $stmt->execute([$movieId]);
        $result = $stmt->fetch();

        return [
            'average' => round($result['average'] ?? 0, 1),
            'count' => (int)($result['count'] ?? 0)
        ];
    }

    public function getUserRating($movieId, $userIP = null, $userId = null) {
        if ($userId) {
            // Get rating by user ID
            $stmt = $this->db->prepare("SELECT rating FROM ratings WHERE movie_id = ? AND user_id = ?");
            $stmt->execute([$movieId, $userId]);
        } else {
            // Get rating by IP for anonymous users
            $stmt = $this->db->prepare("SELECT rating FROM ratings WHERE movie_id = ? AND user_ip = ? AND user_id IS NULL");
            $stmt->execute([$movieId, $userIP]);
        }

        $result = $stmt->fetch();
        return $result ? (int)$result['rating'] : null;
    }

    public function getUserRatings($userId, $limit = 20, $offset = 0) {
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

    public function getTopRatedMovies($limit = 10, $minRatings = 5) {
        $stmt = $this->db->prepare("
            SELECT m.*, AVG(r.rating) as avg_rating, COUNT(r.rating) as rating_count
            FROM movies m
            JOIN ratings r ON m.id = r.movie_id
            GROUP BY m.id
            HAVING rating_count >= ?
            ORDER BY avg_rating DESC, rating_count DESC
            LIMIT ?
        ");
        $stmt->execute([$minRatings, $limit]);
        return $stmt->fetchAll();
    }

    public function getUserRatingStats($userId) {
        $stmt = $this->db->prepare("
            SELECT 
                COUNT(*) as total_ratings,
                AVG(rating) as avg_rating,
                MIN(rating) as min_rating,
                MAX(rating) as max_rating,
                SUM(CASE WHEN rating = 5 THEN 1 ELSE 0 END) as five_star_count,
                SUM(CASE WHEN rating = 4 THEN 1 ELSE 0 END) as four_star_count,
                SUM(CASE WHEN rating = 3 THEN 1 ELSE 0 END) as three_star_count,
                SUM(CASE WHEN rating = 2 THEN 1 ELSE 0 END) as two_star_count,
                SUM(CASE WHEN rating = 1 THEN 1 ELSE 0 END) as one_star_count
            FROM ratings 
            WHERE user_id = ?
        ");
        $stmt->execute([$userId]);
        $result = $stmt->fetch();

        if ($result) {
            $result['avg_rating'] = round($result['avg_rating'] ?? 0, 1);
        }

        return $result;
    }
}