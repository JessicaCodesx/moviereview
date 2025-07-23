<?php

namespace Controllers;

use Models\User;

class SettingsController extends BaseController
{
    private $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
    }

    public function index()
    {
        $this->requireAuth();

        $userId = $_SESSION['user']['id'];
        $user = $this->userModel->getUserById($userId);

        if (!$user) {
            header('Location: /login');
            exit;
        }

        // Get user preferences (we'll add this to the user model)
        $preferences = $this->userModel->getUserPreferences($userId);

        $data = [
            'user' => $user,
            'preferences' => $preferences,
            'page_title' => 'Account Settings'
        ];

        $this->view('user/settings', $data);
    }

    public function updateProfile()
    {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'error' => 'Invalid request method']);
            return;
        }

        $userId = $_SESSION['user']['id'];
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $bio = trim($_POST['bio'] ?? '');

        // Validation
        $errors = [];

        if (empty($username)) {
            $errors[] = 'Username is required';
        } elseif (strlen($username) < 3) {
            $errors[] = 'Username must be at least 3 characters';
        }

        if (empty($email)) {
            $errors[] = 'Email is required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format';
        }

        if (!empty($errors)) {
            $this->jsonResponse(['success' => false, 'errors' => $errors]);
            return;
        }

        // Check if username/email already exists (excluding current user)
        if ($this->userModel->usernameExists($username, $userId)) {
            $this->jsonResponse(['success' => false, 'error' => 'Username already taken']);
            return;
        }

        if ($this->userModel->emailExists($email, $userId)) {
            $this->jsonResponse(['success' => false, 'error' => 'Email already in use']);
            return;
        }

        // Update profile
        $success = $this->userModel->updateProfile($userId, [
            'username' => $username,
            'email' => $email,
            'bio' => $bio
        ]);

        if ($success) {
            // Update session
            $_SESSION['user']['username'] = $username;
            $_SESSION['user']['email'] = $email;

            $this->jsonResponse(['success' => true, 'message' => 'Profile updated successfully']);
        } else {
            $this->jsonResponse(['success' => false, 'error' => 'Failed to update profile']);
        }
    }

    public function updatePreferences()
    {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'error' => 'Invalid request method']);
            return;
        }

        $userId = $_SESSION['user']['id'];
        $preferences = [
            'email_notifications' => isset($_POST['email_notifications']) ? 1 : 0,
            'movie_recommendations' => isset($_POST['movie_recommendations']) ? 1 : 0,
            'rating_privacy' => $_POST['rating_privacy'] ?? 'public',
            'watchlist_privacy' => $_POST['watchlist_privacy'] ?? 'public',
            'theme_preference' => $_POST['theme_preference'] ?? 'auto',
            'language' => $_POST['language'] ?? 'en'
        ];

        $success = $this->userModel->updatePreferences($userId, $preferences);

        if ($success) {
            $this->jsonResponse(['success' => true, 'message' => 'Preferences updated successfully']);
        } else {
            $this->jsonResponse(['success' => false, 'error' => 'Failed to update preferences']);
        }
    }

    public function exportData()
    {
        $this->requireAuth();

        $userId = $_SESSION['user']['id'];

        // Get all user data
        $userData = $this->userModel->exportUserData($userId);

        // Set headers for download
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="moviereview_data_' . date('Y-m-d') . '.json"');

        echo json_encode($userData, JSON_PRETTY_PRINT);
        exit;
    }

    public function deactivateAccount()
    {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'error' => 'Invalid request method']);
            return;
        }

        $userId = $_SESSION['user']['id'];
        $password = $_POST['password'] ?? '';

        if (empty($password)) {
            $this->jsonResponse(['success' => false, 'error' => 'Password is required']);
            return;
        }

        // Verify password
        $user = $this->userModel->getUserById($userId);
        if (!password_verify($password, $user['password'])) {
            $this->jsonResponse(['success' => false, 'error' => 'Incorrect password']);
            return;
        }

        // Deactivate account (soft delete)
        $success = $this->userModel->deactivateAccount($userId);

        if ($success) {
            // Log out user
            session_destroy();
            $this->jsonResponse(['success' => true, 'message' => 'Account deactivated successfully', 'redirect' => '/']);
        } else {
            $this->jsonResponse(['success' => false, 'error' => 'Failed to deactivate account']);
        }
    }
}