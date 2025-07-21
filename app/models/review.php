<?php
namespace Models;

use Core\APIClient;

class Review extends BaseModel {
    protected $table = 'ai_reviews';

    public function getOrGenerateReview($movieId) {
        try {
            // Check if review already exists
            $existingReview = $this->getReviewByMovieId($movieId);
            if ($existingReview) {
                error_log("Using existing review for movie ID: $movieId");
                return $existingReview['review'];
            }

            // Generate new review
            error_log("Generating new review for movie ID: $movieId");
            $movieModel = new Movie();
            $movie = $movieModel->find($movieId);

            if (!$movie) {
                throw new \Exception("Movie not found with ID: $movieId");
            }

            error_log("Movie found: " . $movie['title'] . " (" . $movie['year'] . ")");

            $prompt = $this->buildReviewPrompt($movie);
            error_log("Generated prompt for review (length: " . strlen($prompt) . ")");

            $apiClient = new APIClient();
            $review = $apiClient->generateReview($prompt);

            if (empty($review)) {
                throw new \Exception("API returned empty review");
            }

            error_log("Review generated successfully (length: " . strlen($review) . ")");

            // Save review to database
            try {
                $reviewId = $this->create([
                    'movie_id' => $movieId,
                    'review' => $review
                ]);
                error_log("Review saved to database with ID: $reviewId");
            } catch (\Exception $e) {
                // Log the error but still return the review
                error_log("Failed to save review to database: " . $e->getMessage());
            }

            return $review;

        } catch (\Exception $e) {
            error_log("Error in getOrGenerateReview: " . $e->getMessage());
            throw $e;
        }
    }

    private function getReviewByMovieId($movieId) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM ai_reviews WHERE movie_id = ? ORDER BY created_at DESC LIMIT 1");
            $stmt->execute([$movieId]);
            return $stmt->fetch();
        } catch (\Exception $e) {
            error_log("Error fetching existing review: " . $e->getMessage());
            return null;
        }
    }

    private function buildReviewPrompt($movie) {
        // Clean up movie data
        $title = $movie['title'] ?? 'Unknown Title';
        $year = $movie['year'] ?? 'Unknown Year';
        $director = $movie['director'] !== 'N/A' ? $movie['director'] : 'Unknown Director';
        $actors = $movie['actors'] !== 'N/A' ? $movie['actors'] : 'Unknown Cast';
        $genre = $movie['genre'] !== 'N/A' ? $movie['genre'] : 'Unknown Genre';
        $plot = $movie['plot'] !== 'N/A' ? $movie['plot'] : 'Plot details not available';
        $rating = $movie['rating'] !== 'N/A' ? $movie['rating'] : 'No rating available';

        $prompt = "Write a professional movie review for '{$title}' ({$year}). ";

        if ($director !== 'Unknown Director') {
            $prompt .= "The movie is directed by {$director}";
            if ($actors !== 'Unknown Cast') {
                $prompt .= " and stars {$actors}";
            }
            $prompt .= ". ";
        }

        if ($genre !== 'Unknown Genre') {
            $prompt .= "Genre: {$genre}. ";
        }

        if ($rating !== 'No rating available') {
            $prompt .= "IMDb Rating: {$rating}. ";
        }

        $prompt .= "Plot: {$plot} ";

        $prompt .= "Write a balanced, engaging review discussing the plot (without major spoilers), performances, direction, cinematography, and overall quality. ";
        $prompt .= "Keep it around 200-300 words and make it interesting for movie enthusiasts. ";
        $prompt .= "Be honest about both strengths and weaknesses. Use a professional but accessible tone.";

        return $prompt;
    }
}