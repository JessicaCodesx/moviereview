<?php

namespace Controllers;

use Models\Rating;

class RatingController extends BaseController {
    private $ratingModel;

    public function __construct() {
        $this->ratingModel = new Rating();
    }

    public function addRating() {
        try {
            $movieId = $_POST['movieId'] ?? '';
            $rating = $_POST['rating'] ?? '';

            // Validation
            if (empty($movieId) || empty($rating)) {
                $this->jsonResponse(['error' => 'Movie ID and rating are required'], 400);
                return;
            }

            if (!is_numeric($rating) || $rating < 1 || $rating > 5) {
                $this->jsonResponse(['error' => 'Rating must be between 1 and 5'], 400);
                return;
            }

            $userIP = $this->getUserIP();
            $userId = $this->isLoggedIn() ? $_SESSION['user']['id'] : null;

            // Add or update rating
            $success = $this->ratingModel->addRating($movieId, (int)$rating, $userIP, $userId);

            if ($success) {
                // Get updated rating statistics
                $ratingStats = $this->ratingModel->getAverageRating($movieId);

                $response = [
                    'success' => true,
                    'ratings' => $ratingStats,
                    'message' => 'Rating saved successfully!'
                ];

                // Add user rating to response if user is logged in
                if ($userId) {
                    $response['user_rating'] = (int)$rating;
                }

                $this->jsonResponse($response);
            } else {
                $this->jsonResponse(['error' => 'Failed to save rating'], 500);
            }

        } catch (\Exception $e) {
            $this->jsonResponse(['error' => 'Failed to add rating: ' . $e->getMessage()], 500);
        }
    }

    public function getUserRatings() {
        if (!$this->isLoggedIn()) {
            $this->jsonResponse(['error' => 'Login required'], 401);
            return;
        }

        try {
            $userId = $_SESSION['user']['id'];
            $page = (int)($_GET['page'] ?? 1);
            $limit = (int)($_GET['limit'] ?? 20);
            $offset = ($page - 1) * $limit;

            $ratings = $this->ratingModel->getUserRatings($userId, $limit, $offset);

            $this->jsonResponse([
                'success' => true,
                'ratings' => $ratings,
                'page' => $page,
                'count' => count($ratings)
            ]);

        } catch (\Exception $e) {
            $this->jsonResponse(['error' => 'Failed to get user ratings: ' . $e->getMessage()], 500);
        }
    }

    public function updateRating() {
        if (!$this->isLoggedIn()) {
            $this->jsonResponse(['error' => 'Login required to update ratings'], 401);
            return;
        }

        try {
            $movieId = $_POST['movieId'] ?? '';
            $newRating = $_POST['rating'] ?? '';

            if (empty($movieId) || empty($newRating)) {
                $this->jsonResponse(['error' => 'Movie ID and rating are required'], 400);
                return;
            }

            if (!is_numeric($newRating) || $newRating < 1 || $newRating > 5) {
                $this->jsonResponse(['error' => 'Rating must be between 1 and 5'], 400);
                return;
            }

            $userId = $_SESSION['user']['id'];
            $userIP = $this->getUserIP();

            // This will update existing rating due to unique constraint handling
            $success = $this->ratingModel->addRating($movieId, (int)$newRating, $userIP, $userId);

            if ($success) {
                $ratingStats = $this->ratingModel->getAverageRating($movieId);

                $this->jsonResponse([
                    'success' => true,
                    'ratings' => $ratingStats,
                    'user_rating' => (int)$newRating,
                    'message' => 'Rating updated successfully!'
                ]);
            } else {
                $this->jsonResponse(['error' => 'Failed to update rating'], 500);
            }

        } catch (\Exception $e) {
            $this->jsonResponse(['error' => 'Failed to update rating: ' . $e->getMessage()], 500);
        }
    }

    public function deleteRating() {
        if (!$this->isLoggedIn()) {
            $this->jsonResponse(['error' => 'Login required to delete ratings'], 401);
            return;
        }

        try {
            $movieId = $_POST['movieId'] ?? '';

            if (empty($movieId)) {
                $this->jsonResponse(['error' => 'Movie ID is required'], 400);
                return;
            }

            $userId = $_SESSION['user']['id'];

            $stmt = $this->ratingModel->getDB()->prepare("DELETE FROM ratings WHERE movie_id = ? AND user_id = ?");
            $success = $stmt->execute([$movieId, $userId]);

            if ($success) {
                $ratingStats = $this->ratingModel->getAverageRating($movieId);

                $this->jsonResponse([
                    'success' => true,
                    'ratings' => $ratingStats,
                    'message' => 'Rating deleted successfully!'
                ]);
            } else {
                $this->jsonResponse(['error' => 'Failed to delete rating'], 500);
            }

        } catch (\Exception $e) {
            $this->jsonResponse(['error' => 'Failed to delete rating: ' . $e->getMessage()], 500);
        }
    }

    public function getRatingStats() {
        if (!$this->isLoggedIn()) {
            $this->jsonResponse(['error' => 'Login required'], 401);
            return;
        }

        try {
            $userId = $_SESSION['user']['id'];
            $stats = $this->ratingModel->getUserRatingStats($userId);

            $this->jsonResponse([
                'success' => true,
                'stats' => $stats
            ]);

        } catch (\Exception $e) {
            $this->jsonResponse(['error' => 'Failed to get rating stats: ' . $e->getMessage()], 500);
        }
    }

    public function getTopRated() {
        try {
            $limit = (int)($_GET['limit'] ?? 10);
            $minRatings = (int)($_GET['min_ratings'] ?? 5);

            $topRated = $this->ratingModel->getTopRatedMovies($limit, $minRatings);

            $this->jsonResponse([
                'success' => true,
                'movies' => $topRated,
                'count' => count($topRated)
            ]);

        } catch (\Exception $e) {
            $this->jsonResponse(['error' => 'Failed to get top rated movies: ' . $e->getMessage()], 500);
        }
    }

        public function getRecentlyRated() {
            try {
                $limit = (int)($_GET['limit'] ?? 5);

                $recentlyRated = $this->ratingModel->getRecentlyRatedMovies($limit);

                $this->jsonResponse([
                    'success' => true,
                    'movies' => $recentlyRated,
                    'count' => count($recentlyRated)
                ]);

            } catch (\Exception $e) {
                $this->jsonResponse(['error' => 'Failed to get recently rated movies: ' . $e->getMessage()], 500);
            }
        }
    }