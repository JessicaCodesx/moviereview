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
        try {
            $query = $_POST['query'] ?? '';

            if (empty($query)) {
                $this->jsonResponse(['error' => 'Search query is required'], 400);
                return;
            }

            $results = $this->apiClient->searchOMDB($query);

            if (!$results) {
                $this->jsonResponse(['error' => 'Failed to search movies'], 500);
                return;
            }

            $this->jsonResponse($results);

        } catch (\Exception $e) {
            $this->jsonResponse(['error' => 'Search failed: ' . $e->getMessage()], 500);
        }
    }

    public function getMovie() {
        try {
            $imdbId = $_POST['imdbId'] ?? '';

            if (empty($imdbId)) {
                $this->jsonResponse(['error' => 'IMDb ID is required'], 400);
                return;
            }

            // Check if movie exists in database
            $movie = $this->movieModel->findByImdbId($imdbId);

            if (!$movie) {
                // Fetch from OMDB API
                $movieData = $this->apiClient->getMovieDetails($imdbId);

                if (!$movieData || $movieData['Response'] === 'False') {
                    $this->jsonResponse(['error' => 'Movie not found'], 404);
                    return;
                }

                // Save to database
                $movieId = $this->movieModel->saveFromOMDB($movieData);
                $movie = $this->movieModel->getWithRatings($movieId);
            } else {
                $movie = $this->movieModel->getWithRatings($movie['id']);
            }

            // Add user's rating if user is logged in
            $ratingModel = new \Models\Rating();

            if ($this->isLoggedIn()) {
                $userId = $_SESSION['user']['id'];
                $userRating = $ratingModel->getUserRating($movie['id'], $this->getUserIP(), $userId);
            } else {
                $userRating = $ratingModel->getUserRating($movie['id'], $this->getUserIP());
            }

            $movie['user_rating'] = $userRating;

            // Add additional movie data for better display
            $movie = $this->enhanceMovieData($movie);

            $this->jsonResponse($movie);

        } catch (\Exception $e) {
            $this->jsonResponse(['error' => 'Failed to get movie: ' . $e->getMessage()], 500);
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
            $this->jsonResponse(['error' => 'Failed to get trending movies: ' . $e->getMessage()], 500);
        }
    }

    public function recommendations() {
        if (!$this->isLoggedIn()) {
            $this->jsonResponse(['error' => 'Login required for recommendations'], 401);
            return;
        }

        try {
            $userId = $_SESSION['user']['id'];

            // Get user's rating history to generate recommendations
            $ratingModel = new Rating();
            $userRatings = $ratingModel->getUserRatings($userId, 50);

            if (empty($userRatings)) {
                // If user has no ratings, return popular movies
                $recommendations = $ratingModel->getTopRatedMovies(10);
            } else {
                // Simple recommendation based on user's highly rated movies
                $recommendations = $this->generateRecommendations($userId, $userRatings);
            }

            $this->jsonResponse([
                'success' => true,
                'recommendations' => $recommendations,
                'count' => count($recommendations)
            ]);

        } catch (\Exception $e) {
            $this->jsonResponse(['error' => 'Failed to get recommendations: ' . $e->getMessage()], 500);
        }
    }

    private function generateRecommendations($userId, $userRatings) {
        // Simple recommendation algorithm:
        // 1. Find genres of highly rated movies (4+ stars)
        // 2. Find other movies in those genres that user hasn't rated

        $highlyRated = array_filter($userRatings, function($rating) {
            return $rating['rating'] >= 4;
        });

        if (empty($highlyRated)) {
            // Fall back to popular movies
            $ratingModel = new Rating();
            return $ratingModel->getTopRatedMovies(10);
        }

        // Extract preferred genres
        $preferredGenres = [];
        foreach ($highlyRated as $rating) {
            $genres = explode(',', $rating['genre'] ?? '');
            foreach ($genres as $genre) {
                $genre = trim($genre);
                if (!empty($genre)) {
                    $preferredGenres[$genre] = ($preferredGenres[$genre] ?? 0) + 1;
                }
            }
        }

        // Sort genres by preference
        arsort($preferredGenres);
        $topGenres = array_slice(array_keys($preferredGenres), 0, 3);

        if (empty($topGenres)) {
            $ratingModel = new Rating();
            return $ratingModel->getTopRatedMovies(10);
        }

        // Find movies in preferred genres that user hasn't rated
        $genreCondition = implode("' OR genre LIKE '%", $topGenres);
        $genreCondition = "genre LIKE '%" . $genreCondition . "%'";

        $userRatedIds = array_column($userRatings, 'movie_id');
        $userRatedIdsStr = implode(',', array_map('intval', $userRatedIds));

        $sql = "SELECT DISTINCT m.*, AVG(r.rating) as avg_rating, COUNT(r.id) as rating_count
                FROM movies m 
                LEFT JOIN ratings r ON m.id = r.movie_id 
                WHERE ({$genreCondition})";

        if (!empty($userRatedIds)) {
            $sql .= " AND m.id NOT IN ({$userRatedIdsStr})";
        }

        $sql .= " GROUP BY m.id
                  HAVING rating_count >= 2
                  ORDER BY avg_rating DESC, rating_count DESC 
                  LIMIT 10";

        $stmt = $this->movieModel->getDB()->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
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

        return $movie;
    }
}