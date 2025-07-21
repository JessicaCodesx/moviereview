<?php
namespace Controllers;

use Models\User;

class AuthController extends BaseController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function loginPage() {
        if ($this->isLoggedIn()) {
            header('Location: /');
            exit;
        }
        $this->view('auth/login');
    }

    public function registerPage() {
        if ($this->isLoggedIn()) {
            header('Location: /');
            exit;
        }
        $this->view('auth/register');
    }

    public function login() {
        try {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($password)) {
                $this->jsonResponse(['error' => 'Username and password are required'], 400);
                return;
            }

            $user = $this->userModel->authenticate($username, $password);

            if ($user) {
                // Start session and store user data
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'created_at' => $user['created_at']
                ];

                $this->jsonResponse([
                    'success' => true,
                    'message' => 'Login successful',
                    'user' => [
                        'id' => $user['id'],
                        'username' => $user['username']
                    ]
                ]);
            } else {
                $this->jsonResponse(['error' => 'Invalid username or password'], 401);
            }

        } catch (\Exception $e) {
            $this->jsonResponse(['error' => 'Login failed: ' . $e->getMessage()], 500);
        }
    }

    public function register() {
        try {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if (empty($username) || empty($password) || empty($confirmPassword)) {
                $this->jsonResponse(['error' => 'All fields are required'], 400);
                return;
            }

            if ($password !== $confirmPassword) {
                $this->jsonResponse(['error' => 'Passwords do not match'], 400);
                return;
            }

            $userId = $this->userModel->createUser($username, $password);

            if ($userId) {
                // Auto-login after registration
                $user = $this->userModel->find($userId);
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'created_at' => $user['created_at']
                ];

                $this->jsonResponse([
                    'success' => true,
                    'message' => 'Registration successful',
                    'user' => [
                        'id' => $user['id'],
                        'username' => $user['username']
                    ]
                ]);
            }

        } catch (\Exception $e) {
            $this->jsonResponse(['error' => 'Registration failed: ' . $e->getMessage()], 400);
        }
    }

    public function logout() {
        session_destroy();

        if ($this->isAjaxRequest()) {
            $this->jsonResponse(['success' => true, 'message' => 'Logged out successfully']);
        } else {
            header('Location: /');
            exit;
        }
    }

    public function profile() {
        if (!$this->isLoggedIn()) {
            header('Location: /login');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $user = $this->userModel->find($userId);
        $stats = $this->userModel->getUserStats($userId);
        $recentRatings = $this->userModel->getUserRatings($userId, 5);

        $this->view('user/profile', [
            'user' => $user,
            'stats' => $stats,
            'recent_ratings' => $recentRatings
        ]);
    }

    public function checkAuth() {
        $this->jsonResponse([
            'logged_in' => $this->isLoggedIn(),
            'user' => $this->isLoggedIn() ? $_SESSION['user'] : null
        ]);
    }

    private function isLoggedIn() {
        return isset($_SESSION['user']) && !empty($_SESSION['user']['id']);
    }
}