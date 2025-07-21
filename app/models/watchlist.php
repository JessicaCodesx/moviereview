<?php
namespace Models;

class Watchlist extends BaseModel {
    protected $table = 'watchlist';

    public function addToWatchlist($userId, $movieId) {
        try {
            return $this->create([
                'user_id' => $userId,
                'movie_id' => $movieId
            ]);
        } catch (\PDOException $e) {
            // Handle duplicate entry
            if ($e->getCode() == 23000) {
                throw new \Exception("Movie is already in your watchlist");
            }
            throw $e;
        }
    }

    public function removeFromWatchlist($userId, $movieId) {
        $stmt = $this->db->prepare("DELETE FROM watchlist WHERE user_id = ? AND movie_id = ?");
        return $stmt->execute([$userId, $movieId]);
    }

    public function isInWatchlist($userId, $movieId) {
        $stmt = $this->db->prepare("SELECT id FROM watchlist WHERE user_id = ? AND movie_id = ?");
        $stmt->execute([$userId, $movieId]);
        return $stmt->fetch() !== false;
    }

    public function getUserWatchlist($userId, $limit = 20, $offset = 0) {
        $stmt = $this->db->prepare("
            SELECT w.*, m.title, m.year, m.poster, m.imdb_id, m.genre, m.rating as imdb_rating
            FROM watchlist w 
            JOIN movies m ON w.movie_id = m.id 
            WHERE w.user_id = ? 
            ORDER BY w.created_at DESC 
            LIMIT ? OFFSET ?
        ");
        $stmt->execute([$userId, $limit, $offset]);
        return $stmt->fetchAll();
    }

    public function markAsWatched($userId, $movieId) {
        // Remove from watchlist if it's there
        $this->removeFromWatchlist($userId, $movieId);

        // Add to watched movies
        $userMovieModel = new UserMovie();
        return $userMovieModel->markAsWatched($userId, $movieId);
    }

    public function getRecommendations($userId, $limit = 10) {
        // Simple recommendation based on genres of movies in watchlist
        $stmt = $this->db->prepare("
            SELECT DISTINCT m2.* 
            FROM movies m2
            WHERE m2.genre IN (
                SELECT DISTINCT m.genre 
                FROM watchlist w 
                JOIN movies m ON w.movie_id = m.id 
                WHERE w.user_id = ?
            )
            AND m2.id NOT IN (
                SELECT movie_id FROM watchlist WHERE user_id = ?
                UNION
                SELECT movie_id FROM user_movies WHERE user_id = ? AND status = 'watched'
            )
            AND m2.rating IS NOT NULL 
            AND m2.rating != 'N/A'
            ORDER BY CAST(m2.rating AS DECIMAL(3,1)) DESC
            LIMIT ?
        ");
        $stmt->execute([$userId, $userId, $userId, $limit]);
        return $stmt->fetchAll();
    }
}

class UserMovie extends BaseModel {
    protected $table = 'user_movies';

    public function markAsWatched($userId, $movieId) {
        try {
            return $this->create([
                'user_id' => $userId,
                'movie_id' => $movieId,
                'status' => 'watched',
                'watched_at' => date('Y-m-d H:i:s')
            ]);
        } catch (\PDOException $e) {
            // Handle duplicate entry
            if ($e->getCode() == 23000) {
                // Update existing record
                $stmt = $this->db->prepare("
                    UPDATE user_movies 
                    SET status = 'watched', watched_at = ? 
                    WHERE user_id = ? AND movie_id = ?
                ");
                return $stmt->execute([date('Y-m-d H:i:s'), $userId, $movieId]);
            }
            throw $e;
        }
    }

    public function unmarkAsWatched($userId, $movieId) {
        $stmt = $this->db->prepare("DELETE FROM user_movies WHERE user_id = ? AND movie_id = ? AND status = 'watched'");
        return $stmt->execute([$userId, $movieId]);
    }

    public function isWatched($userId, $movieId) {
        $stmt = $this->db->prepare("SELECT id FROM user_movies WHERE user_id = ? AND movie_id = ? AND status = 'watched'");
        $stmt->execute([$userId, $movieId]);
        return $stmt->fetch() !== false;
    }

    public function getUserWatchedMovies($userId, $limit = 20, $offset = 0) {
        $stmt = $this->db->prepare("
            SELECT um.*, m.title, m.year, m.poster, m.imdb_id, m.genre, m.rating as imdb_rating,
                   r.rating as user_rating
            FROM user_movies um 
            JOIN movies m ON um.movie_id = m.id 
            LEFT JOIN ratings r ON m.id = r.movie_id AND r.user_id = ?
            WHERE um.user_id = ? AND um.status = 'watched'
            ORDER BY um.watched_at DESC 
            LIMIT ? OFFSET ?
        ");
        $stmt->execute([$userId, $userId, $limit, $offset]);
        return $stmt->fetchAll();
    }

    public function getMovieStatus($userId, $movieId) {
        $watchlistModel = new Watchlist();

        $status = [
            'in_watchlist' => $watchlistModel->isInWatchlist($userId, $movieId),
            'is_watched' => $this->isWatched($userId, $movieId)
        ];

        return $status;
    }
}