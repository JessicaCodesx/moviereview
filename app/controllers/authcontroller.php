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


    
    public function changePassword() {
        if (!$this->isLoggedIn()) {
            $this->jsonResponse(['error' => 'Authentication required'], 401);
            return;
        }

        try {
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // Validation
            if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
                $this->jsonResponse(['error' => 'All fields are required'], 400);
                return;
            }

            if ($newPassword !== $confirmPassword) {
                $this->jsonResponse(['error' => 'New passwords do not match'], 400);
                return;
            }

            if (strlen($newPassword) < 6) {
                $this->jsonResponse(['error' => 'New password must be at least 6 characters long'], 400);
                return;
            }

            $userId = $_SESSION['user']['id'];

            // Verify current password
            if (!$this->userModel->verifyPassword($userId, $currentPassword)) {
                $this->jsonResponse(['error' => 'Current password is incorrect'], 400);
                return;
            }

            // Update password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $success = $this->userModel->update($userId, ['password' => $hashedPassword]);

            if ($success) {
                // Log the activity
                $this->logUserActivity('password_changed');

                $this->jsonResponse([
                    'success' => true,
                    'message' => 'Password updated successfully'
                ]);
            } else {
                $this->jsonResponse(['error' => 'Failed to update password'], 500);
            }

        } catch (\Exception $e) {
            $this->jsonResponse(['error' => 'Password change failed: ' . $e->getMessage()], 500);
        }
    }

    public function deleteAccount() {
        if (!$this->isLoggedIn()) {
            $this->jsonResponse(['error' => 'Authentication required'], 401);
            return;
        }

        try {
            $password = $_POST['password'] ?? '';
            $confirmation = $_POST['confirmation'] ?? '';

            if (empty($password) || $confirmation !== 'DELETE') {
                $this->jsonResponse(['error' => 'Invalid confirmation'], 400);
                return;
            }

            $userId = $_SESSION['user']['id'];

            // Verify password
            if (!$this->userModel->verifyPassword($userId, $password)) {
                $this->jsonResponse(['error' => 'Incorrect password'], 400);
                return;
            }

            // Delete user account (cascade will handle related data)
            $success = $this->userModel->delete($userId);

            if ($success) {
                // Log the activity before destroying session
                $this->logUserActivity('account_deleted');

                // Destroy session
                session_destroy();

                $this->jsonResponse([
                    'success' => true,
                    'message' => 'Account deleted successfully'
                ]);
            } else {
                $this->jsonResponse(['error' => 'Failed to delete account'], 500);
            }

        } catch (\Exception $e) {
            $this->jsonResponse(['error' => 'Account deletion failed: ' . $e->getMessage()], 500);
        }
    }

    public function getUserStats() {
        if (!$this->isLoggedIn()) {
            $this->jsonResponse(['error' => 'Authentication required'], 401);
            return;
        }

        try {
            $userId = $_SESSION['user']['id'];
            $stats = $this->userModel->getUserStats($userId);

            $this->jsonResponse([
                'success' => true,
                'stats' => $stats
            ]);

        } catch (\Exception $e) {
            $this->jsonResponse(['error' => 'Failed to get user stats: ' . $e->getMessage()], 500);
        }
    }