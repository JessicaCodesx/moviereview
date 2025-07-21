<?php
namespace Controllers;

use Models\Review;

class ReviewController extends BaseController {
    private $reviewModel;

    public function __construct() {
        $this->reviewModel = new Review();
    }

    public function generateReview() {
        try {
            $movieId = $_POST['movieId'] ?? '';

            if (empty($movieId)) {
                $this->jsonResponse(['error' => 'Movie ID is required'], 400);
                return;
            }

            if (!is_numeric($movieId)) {
                $this->jsonResponse(['error' => 'Invalid movie ID'], 400);
                return;
            }

            $review = $this->reviewModel->getOrGenerateReview((int)$movieId);

            $this->jsonResponse(['review' => $review]);

        } catch (\Exception $e) {
            $this->jsonResponse(['error' => 'Failed to generate review: ' . $e->getMessage()], 500);
        }
    }
}