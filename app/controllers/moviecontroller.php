<?php

namespace Controllers;

use Models\Movie;
use Core\APIClient;

class MovieController extends BaseController {
    private $movieModel;
    private $apiClient;

    public function __construct() {
        $this->movieModel = new Movie();
        $this->apiClient = new APIClient();
    }

    public function index() {
        $this->view('movies/index');
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

            // Add user's rating if exists
            $ratingModel = new \Models\Rating();
            $userRating = $ratingModel->getUserRating($movie['id'], $this->getUserIP());
            $movie['user_rating'] = $userRating;

            $this->jsonResponse($movie);

        } catch (\Exception $e) {
            $this->jsonResponse(['error' => 'Failed to get movie: ' . $e->getMessage()], 500);
        }
    }
}