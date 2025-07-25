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

        $prompt = "Write a professional, NON-SPOILER movie review for '{$title}' ({$year}). ";

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

        $prompt .= "Plot summary: {$plot} ";

        $prompt .= "IMPORTANT: Write a completely SPOILER-FREE review that discusses the general premise, performances, direction, cinematography, and overall quality WITHOUT revealing plot twists, endings, or major story developments. ";
        $prompt .= "Focus on the filmmaking craft, acting performances, visual style, and general tone rather than specific plot details. ";
        $prompt .= "Keep it around 400-600 words and make it interesting for movie enthusiasts who haven't seen the film yet. ";
        $prompt .= "Be honest about both strengths and weaknesses while maintaining a professional but accessible tone. ";
        $prompt .= "Do not reveal any surprises, twists, or specific plot points beyond what would be in a trailer.";

        return $prompt;
    }
}