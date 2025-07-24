<?php

namespace Controllers;

use Models\Movie;
use Models\Rating;
use Core\APIClient;

class MovieController extends BaseController {
    private $movieModel;
    private $apiClient;

    public function __construct() {
        $this->movieModel = new Movie();
        $this->apiClient = new APIClient();
    }

    public function index() {
        // Show different content based on login status
        $data = [];

        if ($this->isLoggedIn()) {
            // Get some personalized data for logged-in users
            $userId = $_SESSION['user']['id'];

            // Get recent ratings
            $ratingModel = new Rating();
            $data['recent_ratings'] = $ratingModel->getUserRatings($userId, 5);

            // Get some popular movies if no recent activity
            if (empty($data['recent_ratings'])) {
                $data['popular_movies'] = $ratingModel->getTopRatedMovies(6);
            }
        }

        $this->view('movies/index', $data);
    }

    public function search() {
        // Enhanced error logging for debugging
        error_log("MovieController::search() called");
        error_log("Request method: " . $_SERVER['REQUEST_METHOD']);
        error_log("POST data: " . print_r($_POST, true));
        error_log("Raw input: " . file_get_contents('php://input'));

        try {
            // Get query from POST data, GET parameters, or JSON input
            $query = $_POST['query'] ?? $_GET['q'] ?? $_GET['query'] ?? '';

            // Also check for JSON input (in case frontend sends JSON)
            if (empty($query)) {
                $jsonInput = json_decode(file_get_contents('php://input'), true);
                $query = $jsonInput['query'] ?? '';
            }

            error_log("Search query: " . $query);

            if (empty($query)) {
                error_log("Search failed: Empty query");
                $this->jsonResponse(['Response' => 'False', 'Error' => 'Search query is required'], 400);
                return;
            }

            // Validate query length
            if (strlen(trim($query)) < 2) {
                error_log("Search failed: Query too short");
                $this->jsonResponse(['Response' => 'False', 'Error' => 'Query must be at least 2 characters long'], 400);
                return;
            }

            // Call OMDB API
            error_log("Calling OMDB API for query: " . $query);
            $results = $this->apiClient->searchOMDB($query);

            error_log("OMDB API response: " . print_r($results, true));

            if (!$results) {
                error_log("Search failed: No results from OMDB API");
                $this->jsonResponse(['Response' => 'False', 'Error' => 'Failed to search movies'], 500);
                return;
            }

            // Check if OMDB returned an error
            if (isset($results['Response']) && $results['Response'] === 'False') {
                error_log("OMDB API error: " . ($results['Error'] ?? 'Unknown error'));
                $this->jsonResponse($results);
                return;
            }

            // Success - return the results
            error_log("Search successful, returning " . count($results['Search'] ?? []) . " results");
            $this->jsonResponse($results);

        } catch (\Exception $e) {
            error_log("MovieController::search() exception: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            $this->jsonResponse(['Response' => 'False', 'Error' => 'Search failed: ' . $e->getMessage()], 500);
        }
    }

    public function getMovie() {
        error_log("MovieController::getMovie() called");
        error_log("POST data: " . print_r($_POST, true));

        try {
            $imdbId = $_POST['imdbId'] ?? '';

            // Also check for JSON input
            if (empty($imdbId)) {
                $jsonInput = json_decode(file_get_contents('php://input'), true);
                $imdbId = $jsonInput['imdbId'] ?? '';
            }

            error_log("Movie IMDB ID: " . $imdbId);

            if (empty($imdbId)) {
                error_log("getMovie failed: Empty IMDB ID");
                $this->jsonResponse(['Response' => 'False', 'Error' => 'IMDb ID is required'], 400);
                return;
            }

            // Check if movie exists in database
            $movie = $this->movieModel->findByImdbId($imdbId);

            if (!$movie) {
                error_log("Movie not found in database, fetching from OMDB API");
                // Fetch from OMDB API
                $movieData = $this->apiClient->getMovieDetails($imdbId);
                error_log("OMDB movie data: " . print_r($movieData, true));

                if (!$movieData || $movieData['Response'] === 'False') {
                    error_log("OMDB API error: " . ($movieData['Error'] ?? 'Movie not found'));
                    $this->jsonResponse(['Response' => 'False', 'Error' => 'Movie not found'], 404);
                    return;
                }

                // Save to database
                $movieId = $this->movieModel->saveFromOMDB($movieData);
                $movie = $this->movieModel->getWithRatings($movieId);
                error_log("Movie saved to database with ID: " . $movieId);
            } else {
                error_log("Movie found in database with ID: " . $movie['id']);
                $movie = $this->movieModel->getWithRatings($movie['id']);
            }

            // Add user's rating if user is logged in
            $ratingModel = new \Models\Rating();

            if ($this->isLoggedIn()) {
                $userId = $_SESSION['user']['id'];
                $userRating = $ratingModel->getUserRating($movie['id'], $this->getUserIP(), $userId);
                error_log("User rating: " . ($userRating ?? 'none'));
            } else {
                $userRating = $ratingModel->getUserRating($movie['id'], $this->getUserIP());
                error_log("Anonymous user rating: " . ($userRating ?? 'none'));
            }

            $movie['user_rating'] = $userRating;

            // Add additional movie data for better display
            $movie = $this->enhanceMovieData($movie);

            error_log("Returning enhanced movie data");
            $this->jsonResponse($movie);

        } catch (\Exception $e) {
            error_log("MovieController::getMovie() exception: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            $this->jsonResponse(['Response' => 'False', 'Error' => 'Failed to get movie: ' . $e->getMessage()], 500);
        }
    }

    public function trending() {
        try {
            // Get top-rated movies from our database
            $ratingModel = new Rating();
            $trending = $ratingModel->getTopRatedMovies(20, 3); // At least 3 ratings

            $this->jsonResponse([
                'success' => true,
                'movies' => $trending
            ]);

        } catch (\Exception $e) {
            error_log("MovieController::trending() exception: " . $e->getMessage());
            $this->jsonResponse(['error' => 'Failed to get trending movies: ' . $e->getMessage()], 500);
        }
    }

    public function popular() {
        try {
            // Get popular movies (highest rated with most ratings)
            $ratingModel = new Rating();
            $popular = $ratingModel->getTopRatedMovies(20, 5); // At least 5 ratings

            $this->jsonResponse([
                'success' => true,
                'movies' => $popular
            ]);

        } catch (\Exception $e) {
            error_log("MovieController::popular() exception: " . $e->getMessage());
            $this->jsonResponse(['error' => 'Failed to get popular movies: ' . $e->getMessage()], 500);
        }
    }

    public function recentlyAdded() {
        try {
            // Get recently added movies
            $stmt = $this->movieModel->getDB()->prepare("
                SELECT *, AVG(r.rating) as avg_rating, COUNT(r.rating) as rating_count
                FROM movies m
                LEFT JOIN ratings r ON m.id = r.movie_id
                GROUP BY m.id
                ORDER BY m.created_at DESC
                LIMIT 20
            ");
            $stmt->execute();
            $recent = $stmt->fetchAll();

            $this->jsonResponse([
                'success' => true,
                'movies' => $recent
            ]);

        } catch (\Exception $e) {
            error_log("MovieController::recentlyAdded() exception: " . $e->getMessage());
            $this->jsonResponse(['error' => 'Failed to get recent movies: ' . $e->getMessage()], 500);
        }
    }

    public function byGenre() {
        try {
            $genre = $_GET['genre'] ?? '';
            if (empty($genre)) {
                $this->jsonResponse(['error' => 'Genre parameter is required'], 400);
                return;
            }

            $stmt = $this->movieModel->getDB()->prepare("
                SELECT *, AVG(r.rating) as avg_rating, COUNT(r.rating) as rating_count
                FROM movies m
                LEFT JOIN ratings r ON m.id = r.movie_id
                WHERE m.genre LIKE ?
                GROUP BY m.id
                HAVING rating_count >= 1
                ORDER BY avg_rating DESC, rating_count DESC
                LIMIT 20
            ");
            $stmt->execute(['%' . $genre . '%']);
            $movies = $stmt->fetchAll();

            $this->jsonResponse([
                'success' => true,
                'movies' => $movies,
                'genre' => $genre
            ]);

        } catch (\Exception $e) {
            error_log("MovieController::byGenre() exception: " . $e->getMessage());
            $this->jsonResponse(['error' => 'Failed to get movies by genre: ' . $e->getMessage()], 500);
        }
    }

    public function searchAdvanced() {
        try {
            $params = json_decode(file_get_contents('php://input'), true) ?: $_POST;

            $title = $params['title'] ?? '';
            $year = $params['year'] ?? '';
            $genre = $params['genre'] ?? '';
            $minRating = $params['min_rating'] ?? '';

            $sql = "
                SELECT m.*, AVG(r.rating) as avg_rating, COUNT(r.rating) as rating_count
                FROM movies m
                LEFT JOIN ratings r ON m.id = r.movie_id
                WHERE 1=1
            ";
            $sqlParams = [];

            if (!empty($title)) {
                $sql .= " AND m.title LIKE ?";
                $sqlParams[] = '%' . $title . '%';
            }

            if (!empty($year)) {
                $sql .= " AND m.year = ?";
                $sqlParams[] = $year;
            }

            if (!empty($genre)) {
                $sql .= " AND m.genre LIKE ?";
                $sqlParams[] = '%' . $genre . '%';
            }

            $sql .= " GROUP BY m.id";

            if (!empty($minRating)) {
                $sql .= " HAVING avg_rating >= ?";
                $sqlParams[] = $minRating;
            }

            $sql .= " ORDER BY avg_rating DESC, rating_count DESC LIMIT 50";

            $stmt = $this->movieModel->getDB()->prepare($sql);
            $stmt->execute($sqlParams);
            $movies = $stmt->fetchAll();

            $this->jsonResponse([
                'success' => true,
                'movies' => $movies,
                'count' => count($movies)
            ]);

        } catch (\Exception $e) {
            error_log("MovieController::searchAdvanced() exception: " . $e->getMessage());
            $this->jsonResponse(['error' => 'Advanced search failed: ' . $e->getMessage()], 500);
        }
    }

    private function enhanceMovieData($movie) {
        // Add any additional processing needed for movie display
        if (empty($movie['plot']) || $movie['plot'] === 'N/A') {
            $movie['plot'] = 'Plot information not available.';
        }

        if (empty($movie['poster']) || $movie['poster'] === 'N/A') {
            $movie['poster'] = '/public/assets/images/no-image.png';
        }

        // Ensure numeric rating
        if (!is_numeric($movie['rating']) || $movie['rating'] === 'N/A') {
            $movie['rating'] = 'N/A';
        }

        // Add additional fields that might be missing
        $movie['Response'] = 'True'; // Mark as successful response

        return $movie;
    }

    // Helper method to check database connection
    private function testDatabaseConnection() {
        try {
            $stmt = $this->movieModel->getDB()->query('SELECT 1');
            return $stmt !== false;
        } catch (\Exception $e) {
            error_log("Database connection test failed: " . $e->getMessage());
            return false;
        }
    }

    // Debug endpoint (remove in production)
    public function debug() {
        if (!getenv('APP_DEBUG')) {
            $this->jsonResponse(['error' => 'Debug mode disabled'], 403);
            return;
        }

        $debug = [
            'controller' => 'MovieController',
            'timestamp' => date('Y-m-d H:i:s'),
            'request_method' => $_SERVER['REQUEST_METHOD'],
            'request_uri' => $_SERVER['REQUEST_URI'],
            'post_data' => $_POST,
            'session_user' => $_SESSION['user'] ?? null,
            'database_connected' => $this->testDatabaseConnection(),
            'api_client_loaded' => class_exists('Core\APIClient'),
            'movie_model_loaded' => class_exists('Models\Movie'),
            'rating_model_loaded' => class_exists('Models\Rating'),
            'omdb_api_key_set' => !empty(getenv('OMDB_API_KEY')),
            'gemini_api_key_set' => !empty(getenv('GEMINI_API_KEY'))
        ];

        $this->jsonResponse($debug);
    }
}