<?php
namespace Models;

use Core\APIClient;

class Review extends BaseModel {
    protected $table = 'ai_reviews';

    public function getOrGenerateReview($movieId) {
        // Check if review already exists
        $existingReview = $this->getReviewByMovieId($movieId);
        if ($existingReview) {
            return $existingReview['review'];
        }

        // Generate new review
        $movieModel = new Movie();
        $movie = $movieModel->find($movieId);

        if (!$movie) {
            throw new \Exception("Movie not found");
        }

        $prompt = $this->buildReviewPrompt($movie);
        $apiClient = new APIClient();
        $review = $apiClient->generateReview($prompt);

        if ($review) {
            // Save review to database
            $this->create([
                'movie_id' => $movieId,
                'review' => $review
            ]);

            return $review;
        }

        throw new \Exception("Unable to generate review");
    }

    private function getReviewByMovieId($movieId) {
        $stmt = $this->db->prepare("SELECT * FROM ai_reviews WHERE movie_id = ?");
        $stmt->execute([$movieId]);
        return $stmt->fetch();
    }

    private function buildReviewPrompt($movie) {
        return "Write a professional movie review for '{$movie['title']}' ({$movie['year']}). " .
               "The movie is directed by {$movie['director']}, starring {$movie['actors']}. " .
               "Genre: {$movie['genre']}. Plot: {$movie['plot']}. " .
               "Write a balanced review discussing the plot, performances, direction, and overall quality. " .
               "Keep it around 200-300 words and engaging for movie enthusiasts.";
    }
}