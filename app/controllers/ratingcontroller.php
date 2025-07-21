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

            // Add or update rating
            $success = $this->ratingModel->addRating($movieId, (int)$rating, $userIP);

            if ($success) {
                // Get updated rating statistics
                $ratingStats = $this->ratingModel->getAverageRating($movieId);

                $this->jsonResponse([
                    'success' => true,
                    'ratings' => $ratingStats,
                    'user_rating' => (int)$rating
                ]);
            } else {
                $this->jsonResponse(['error' => 'Failed to save rating'], 500);
            }

        } catch (\Exception $e) {
            $this->jsonResponse(['error' => 'Failed to add rating: ' . $e->getMessage()], 500);
        }
    }
}
