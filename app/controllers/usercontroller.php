<?php
namespace Controllers;

use Models\Watchlist;
use Models\UserMovie;
use Models\Movie;

class UserController extends BaseController {
    private $watchlistModel;
    private $userMovieModel;
    private $movieModel;

    public function __construct() {
        $this->watchlistModel = new Watchlist();
        $this->userMovieModel = new UserMovie();
        $this->movieModel = new Movie();
    }

    public function dashboard() {
        if (!$this->isLoggedIn()) {
            header('Location: /login');
            exit;
        }

        $userId = $_SESSION['user']['id'];

        // Get user's watchlist
        $watchlist = $this->watchlistModel->getUserWatchlist($userId, 6);

        // Get recently watched movies
        $recentlyWatched = $this->userMovieModel->getUserWatchedMovies($userId, 6);

        // Get recommendations
        $recommendations = $this->watchlistModel->getRecommendations($userId, 6);

        $this->view('user/dashboard', [
            'watchlist' => $watchlist,
            'recently_watched' => $recentlyWatched,
            'recommendations' => $recommendations
        ]);
    }

    public function watchlist() {
        if (!$this->isLoggedIn()) {
            header('Location: /login');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $page = (int)($_GET['page'] ?? 1);
        $limit = 20;
        $offset = ($page - 1) * $limit;

        $watchlist = $this->watchlistModel->getUserWatchlist($userId, $limit, $offset);

        $this->view('user/watchlist', [
            'watchlist' => $watchlist,
            'current_page' => $page
        ]);
    }

    public function watchedMovies() {
        if (!$this->isLoggedIn()) {
            header('Location: /login');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $page = (int)($_GET['page'] ?? 1);
        $limit = 20;
        $offset = ($page - 1) * $limit;

        $watchedMovies = $this->userMovieModel->getUserWatchedMovies($userId, $limit, $offset);

        $this->view('user/watched', [
            'watched_movies' => $watchedMovies,
            'current_page' => $page
        ]);
    }

    public function addToWatchlist() {
        if (!$this->isLoggedIn()) {
            $this->jsonResponse(['error' => 'Please login to add movies to watchlist'], 401);
            return;
        }

        try {
            $movieId = $_POST['movieId'] ?? '';

            if (empty($movieId) || !is_numeric($movieId)) {
                $this->jsonResponse(['error' => 'Invalid movie ID'], 400);
                return;
            }

            $userId = $_SESSION['user']['id'];
            $this->watchlistModel->addToWatchlist($userId, $movieId);

            $this->jsonResponse(['success' => true, 'message' => 'Movie added to watchlist']);

        } catch (\Exception $e) {
            $this->jsonResponse(['error' => $e->getMessage()], 400);
        }
    }

    public function removeFromWatchlist() {
        if (!$this->isLoggedIn()) {
            $this->jsonResponse(['error' => 'Please login to manage watchlist'], 401);
            return;
        }

        try {
            $movieId = $_POST['movieId'] ?? '';

            if (empty($movieId) || !is_numeric($movieId)) {
                $this->jsonResponse(['error' => 'Invalid movie ID'], 400);
                return;
            }

            $userId = $_SESSION['user']['id'];
            $this->watchlistModel->removeFromWatchlist($userId, $movieId);

            $this->jsonResponse(['success' => true, 'message' => 'Movie removed from watchlist']);

        } catch (\Exception $e) {
            $this->jsonResponse(['error' => $e->getMessage()], 500);
        }
    }

    public function markWatched() {
        if (!$this->isLoggedIn()) {
            $this->jsonResponse(['error' => 'Please login to mark movies as watched'], 401);
            return;
        }

        try {
            $movieId = $_POST['movieId'] ?? '';

            if (empty($movieId) || !is_numeric($movieId)) {
                $this->jsonResponse(['error' => 'Invalid movie ID'], 400);
                return;
            }

            $userId = $_SESSION['user']['id'];
            $this->watchlistModel->markAsWatched($userId, $movieId);

            $this->jsonResponse(['success' => true, 'message' => 'Movie marked as watched']);

        } catch (\Exception $e) {
            $this->jsonResponse(['error' => $e->getMessage()], 500);
        }
    }

    public function unmarkWatched() {
        if (!$this->isLoggedIn()) {
            $this->jsonResponse(['error' => 'Please login to manage watched movies'], 401);
            return;
        }

        try {
            $movieId = $_POST['movieId'] ?? '';

            if (empty($movieId) || !is_numeric($movieId)) {
                $this->jsonResponse(['error' => 'Invalid movie ID'], 400);
                return;
            }

            $userId = $_SESSION['user']['id'];
            $this->userMovieModel->unmarkAsWatched($userId, $movieId);

            $this->jsonResponse(['success' => true, 'message' => 'Movie unmarked as watched']);

        } catch (\Exception $e) {
            $this->jsonResponse(['error' => $e->getMessage()], 500);
        }
    }

    public function getMovieStatus() {
        if (!$this->isLoggedIn()) {
            $this->jsonResponse(['in_watchlist' => false, 'is_watched' => false]);
            return;
        }

        try {
            $movieId = $_POST['movieId'] ?? '';

            if (empty($movieId) || !is_numeric($movieId)) {
                $this->jsonResponse(['error' => 'Invalid movie ID'], 400);
                return;
            }

            $userId = $_SESSION['user']['id'];
            $status = $this->userMovieModel->getMovieStatus($userId, $movieId);

            $this->jsonResponse($status);

        } catch (\Exception $e) {
            $this->jsonResponse(['error' => $e->getMessage()], 500);
        }
    }

    protected function isLoggedIn() {
        return isset($_SESSION['user']) && !empty($_SESSION['user']['id']);
    }
}