<?php
namespace Controllers;

use Models\Review;
use Models\Movie;

class ReviewController extends BaseController {
    private $reviewModel;

    public function __construct() {
        $this->reviewModel = new Review();
    }

    public function generateReview() {
        try {
            // Debug: Log the start of the request
            error_log("AI Review request started - POST data: " . json_encode($_POST));

            // Validate input
            $movieId = $_POST['movieId'] ?? '';

            if (empty($movieId)) {
                error_log("AI Review error: Movie ID is empty");
                $this->jsonResponse(['error' => 'Movie ID is required'], 400);
                return;
            }

            if (!is_numeric($movieId)) {
                error_log("AI Review error: Movie ID is not numeric: $movieId");
                $this->jsonResponse(['error' => 'Invalid movie ID'], 400);
                return;
            }

            $movieId = (int)$movieId;
            error_log("AI Review processing movie ID: $movieId");

            // Check API configuration first
            $geminiKey = getenv('GEMINI_API_KEY');
            if (empty($geminiKey)) {
                error_log("AI Review error: GEMINI_API_KEY not configured");
                $this->jsonResponse(['error' => 'AI service not configured. Please contact administrator.'], 500);
                return;
            }
            error_log("AI Review: Gemini API key is configured (length: " . strlen($geminiKey) . ")");

            // Check if movie exists
            $movieModel = new Movie();
            $movie = $movieModel->find($movieId);

            if (!$movie) {
                error_log("AI Review error: Movie not found with ID: $movieId");
                $this->jsonResponse(['error' => 'Movie not found'], 404);
                return;
            }

            // Debug: Log the movie info
            error_log("AI Review: Generating review for movie: " . $movie['title'] . " (ID: $movieId)");

            // Generate or get existing review
            $review = $this->reviewModel->getOrGenerateReview($movieId);

            if ($review) {
                error_log("AI Review: Successfully generated/retrieved review (length: " . strlen($review) . ")");
                $this->jsonResponse([
                    'success' => true,
                    'review' => $review
                ]);
            } else {
                error_log("AI Review error: Review generation returned empty result");
                $this->jsonResponse(['error' => 'Failed to generate review'], 500);
            }

        } catch (\Exception $e) {
            // Log the full error for debugging
            error_log("AI Review generation error: " . $e->getMessage());
            error_log("AI Review stack trace: " . $e->getTraceAsString());

            // Return user-friendly error
            $this->jsonResponse([
                'error' => 'Failed to generate review: ' . $e->getMessage(),
                'debug' => getenv('APP_DEBUG') ? [
                    'exception' => get_class($e),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ] : null
            ], 500);
        }
    }

    public function testApi() {
        // Debug endpoint to test API connectivity
        if (!getenv('APP_DEBUG')) {
            $this->jsonResponse(['error' => 'Debug mode required'], 403);
            return;
        }

        try {
            $apiClient = new \Core\APIClient();

            // Test OMDB
            $omdbTest = $apiClient->testOMDB();

            // Test Gemini
            $geminiTest = $apiClient->testGemini();

            $this->jsonResponse([
                'success' => true,
                'tests' => [
                    'omdb' => $omdbTest,
                    'gemini' => $geminiTest
                ],
                'environment' => [
                    'gemini_api_key_set' => !empty(getenv('GEMINI_API_KEY')),
                    'omdb_api_key_set' => !empty(getenv('OMDB_API_KEY')),
                    'php_version' => PHP_VERSION,
                    'curl_available' => function_exists('curl_init'),
                    'openssl_available' => extension_loaded('openssl')
                ]
            ]);

        } catch (\Exception $e) {
            $this->jsonResponse([
                'error' => 'API test failed: ' . $e->getMessage(),
                'debug' => [
                    'exception' => get_class($e),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ]
            ], 500);
        }
    }
}