<?php
namespace Controllers;

abstract class BaseController {
    protected function jsonResponse($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        header('Cache-Control: no-cache, must-revalidate');
        echo json_encode($data);
    }

    protected function view($viewPath, $data = []) {
        // Check if user needs to be logged in for this view
        $protectedViews = [
            'user/dashboard',
            'user/profile', 
            'user/watchlist',
            'user/watched'
        ];

        if (in_array($viewPath, $protectedViews) && !$this->isLoggedIn()) {
            $this->redirectToLogin();
            return;
        }

        extract($data);

        // Start output buffering for the view content
        ob_start();
        $viewFile = APP_PATH . '/views/' . $viewPath . '.php';
        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            throw new \Exception("View file not found: {$viewFile}");
        }
        $content = ob_get_clean();

        // Use a single layout file for all pages
        if (!$this->isAjaxRequest()) {
            include APP_PATH . '/views/layout/layout.php';
        } else {
            echo $content;
        }
    }

    protected function isAjaxRequest() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    protected function getUserIP() {
        // Get real IP address even behind proxies/load balancers
        $ipKeys = ['HTTP_X_FORWARDED_FOR', 'HTTP_X_REAL_IP', 'HTTP_CF_CONNECTING_IP', 'REMOTE_ADDR'];

        foreach ($ipKeys as $key) {
            if (!empty($_SERVER[$key])) {
                $ip = $_SERVER[$key];
                // Handle comma-separated IPs (X-Forwarded-For can have multiple)
                if (strpos($ip, ',') !== false) {
                    $ip = trim(explode(',', $ip)[0]);
                }
                // Validate IP format
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                    return $ip;
                }
            }
        }

        return $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    }

    protected function isLoggedIn() {
        return isset($_SESSION['user']) && !empty($_SESSION['user']['id']);
    }

    protected function getCurrentUser() {
        return $this->isLoggedIn() ? $_SESSION['user'] : null;
    }

    protected function getCurrentUserId() {
        $user = $this->getCurrentUser();
        return $user ? $user['id'] : null;
    }

    protected function requireLogin() {
        if (!$this->isLoggedIn()) {
            if ($this->isAjaxRequest()) {
                $this->jsonResponse(['error' => 'Authentication required'], 401);
            } else {
                $this->redirectToLogin();
            }
            exit;
        }
    }

    protected function redirectToLogin($returnUrl = null) {
        if (!$returnUrl) {
            $returnUrl = $_SERVER['REQUEST_URI'] ?? '/';
        }

        // Store return URL in session
        if ($returnUrl !== '/login' && $returnUrl !== '/register') {
            $_SESSION['return_url'] = $returnUrl;
        }

        header('Location: /login');
        exit;
    }

    protected function redirectAfterLogin() {
        $returnUrl = $_SESSION['return_url'] ?? '/dashboard';
        unset($_SESSION['return_url']);

        header('Location: ' . $returnUrl);
        exit;
    }

    protected function validateCSRF($token) {
        return isset($_SESSION['csrf_token']) && 
               hash_equals($_SESSION['csrf_token'], $token);
    }

    protected function generateCSRF() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    protected function sanitizeInput($input, $type = 'string') {
        if (is_array($input)) {
            return array_map(function($item) use ($type) {
                return $this->sanitizeInput($item, $type);
            }, $input);
        }

        switch ($type) {
            case 'email':
                return filter_var(trim($input), FILTER_SANITIZE_EMAIL);

            case 'int':
                return (int) $input;

            case 'float':
                return (float) $input;

            case 'url':
                return filter_var(trim($input), FILTER_SANITIZE_URL);

            case 'html':
                return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');

            case 'string':
            default:
                return trim($input);
        }
    }

    protected function validateRequired($fields, $data) {
        $missing = [];
        foreach ($fields as $field) {
            if (!isset($data[$field]) || empty(trim($data[$field]))) {
                $missing[] = $field;
            }
        }
        return $missing;
    }

    protected function rateLimitCheck($key, $maxRequests = 60, $timeWindow = 3600) {
        // Simple rate limiting using session
        $now = time();
        $sessionKey = "rate_limit_{$key}";

        if (!isset($_SESSION[$sessionKey])) {
            $_SESSION[$sessionKey] = [];
        }

        // Clean old entries
        $_SESSION[$sessionKey] = array_filter($_SESSION[$sessionKey], function($timestamp) use ($now, $timeWindow) {
            return ($now - $timestamp) < $timeWindow;
        });

        // Check if limit exceeded
        if (count($_SESSION[$sessionKey]) >= $maxRequests) {
            return false;
        }

        // Add current request
        $_SESSION[$sessionKey][] = $now;
        return true;
    }

    protected function logUserActivity($action, $details = null) {
        if (!$this->isLoggedIn()) {
            return;
        }

        $userId = $this->getCurrentUserId();
        $ip = $this->getUserIP();
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';

        // Log to file (you could also log to database)
        $logEntry = [
            'timestamp' => date('Y-m-d H:i:s'),
            'user_id' => $userId,
            'action' => $action,
            'details' => $details,
            'ip' => $ip,
            'user_agent' => $userAgent
        ];

        $logFile = ROOT_PATH . '/logs/user_activity.log';
        $logDir = dirname($logFile);

        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }

        error_log(json_encode($logEntry) . "\n", 3, $logFile);
    }

    protected function handleException(\Exception $e, $userMessage = 'An error occurred') {
        // Log the actual error
        error_log($e->getMessage() . "\n" . $e->getTraceAsString());

        // Return user-friendly error
        if ($this->isAjaxRequest()) {
            $this->jsonResponse(['error' => $userMessage], 500);
        } else {
            // Redirect to error page or show error view
            $this->view('errors/500', ['message' => $userMessage]);
        }
    }

    protected function sendEmail($to, $subject, $message, $headers = []) {
        // Basic email sending - you might want to use a proper email library
        $defaultHeaders = [
            'From' => getenv('APP_EMAIL') ?: 'noreply@moviehub.com',
            'Content-Type' => 'text/html; charset=UTF-8'
        ];

        $headers = array_merge($defaultHeaders, $headers);
        $headerString = '';
        foreach ($headers as $key => $value) {
            $headerString .= "{$key}: {$value}\r\n";
        }

        return mail($to, $subject, $message, $headerString);
    }

    protected function uploadFile($file, $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'], $maxSize = 5242880) {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new \Exception('File upload error: ' . $file['error']);
        }

        if ($file['size'] > $maxSize) {
            throw new \Exception('File too large');
        }

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, $allowedTypes)) {
            throw new \Exception('Invalid file type');
        }

        $filename = uniqid() . '.' . $extension;
        $uploadPath = ROOT_PATH . '/public/uploads/' . $filename;

        if (!is_dir(dirname($uploadPath))) {
            mkdir(dirname($uploadPath), 0755, true);
        }

        if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
            throw new \Exception('Failed to move uploaded file');
        }

        return '/public/uploads/' . $filename;
    }

    // Helper method for time ago functionality
    protected function timeAgo($datetime) {
        $time = time() - strtotime($datetime);

        if ($time < 60) return 'just now';
        if ($time < 3600) return floor($time/60) . 'm ago';
        if ($time < 86400) return floor($time/3600) . 'h ago';
        if ($time < 2592000) return floor($time/86400) . 'd ago';

        return date('M j', strtotime($datetime));
    }
}