<?php
namespace Controllers;

class PagesController extends BaseController {

    public function features() {
        $this->view('pages/features', [
            'page_title' => 'Features - Movie Review Hub',
            'isLoggedIn' => $this->isLoggedIn()
        ]);
    }

    public function about() {
        $this->view('pages/about', [
            'page_title' => 'About Us - Movie Review Hub',
            'isLoggedIn' => $this->isLoggedIn()
        ]);
    }

    public function contact() {
        $this->view('pages/contact', [
            'page_title' => 'Contact Us - Movie Review Hub',
            'isLoggedIn' => $this->isLoggedIn()
        ]);
    }

    public function submitContact() {
        // Handle contact form submission
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Method not allowed'], 405);
            return;
        }

        try {
            // Validate required fields
            $requiredFields = ['name', 'email', 'subject', 'message'];
            $missing = $this->validateRequired($requiredFields, $_POST);

            if (!empty($missing)) {
                $this->jsonResponse([
                    'error' => 'Missing required fields: ' . implode(', ', $missing)
                ], 400);
                return;
            }

            // Sanitize input
            $name = $this->sanitizeInput($_POST['name']);
            $email = $this->sanitizeInput($_POST['email'], 'email');
            $subject = $this->sanitizeInput($_POST['subject']);
            $message = $this->sanitizeInput($_POST['message']);
            $newsletter = isset($_POST['newsletter']) ? 1 : 0;

            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->jsonResponse(['error' => 'Invalid email format'], 400);
                return;
            }

            // Rate limiting check
            if (!$this->rateLimitCheck('contact_form', 5, 3600)) {
                $this->jsonResponse([
                    'error' => 'Too many contact form submissions. Please try again later.'
                ], 429);
                return;
            }

            // Log the contact submission
            $this->logContactSubmission($name, $email, $subject, $message, $newsletter);

            // In a real application, you might:
            // 1. Save to database
            // 2. Send email notification
            // 3. Add to CRM system
            // 4. Send auto-reply email

            $this->jsonResponse([
                'success' => true,
                'message' => 'Thank you for your message! We\'ll get back to you within 24-48 hours.'
            ]);

        } catch (\Exception $e) {
            $this->handleException($e, 'Failed to submit contact form');
        }
    }

    private function logContactSubmission($name, $email, $subject, $message, $newsletter) {
        $logEntry = [
            'timestamp' => date('Y-m-d H:i:s'),
            'type' => 'contact_form',
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'message_length' => strlen($message),
            'newsletter_signup' => $newsletter,
            'ip' => $this->getUserIP(),
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
            'user_id' => $this->isLoggedIn() ? $this->getCurrentUserId() : null
        ];

        $logFile = ROOT_PATH . '/logs/contact_submissions.log';
        $logDir = dirname($logFile);

        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }

        error_log(json_encode($logEntry) . "\n", 3, $logFile);
    }

    // Additional utility methods for future expansion

    public function privacy() {
        $this->view('pages/privacy', [
            'page_title' => 'Privacy Policy - Movie Review Hub',
            'isLoggedIn' => $this->isLoggedIn()
        ]);
    }

    public function terms() {
        $this->view('pages/terms', [
            'page_title' => 'Terms of Service - Movie Review Hub',
            'isLoggedIn' => $this->isLoggedIn()
        ]);
    }

    public function help() {
        $this->view('pages/help', [
            'page_title' => 'Help & Support - Movie Review Hub',
            'isLoggedIn' => $this->isLoggedIn()
        ]);
    }

    public function changelog() {
        $this->view('pages/changelog', [
            'page_title' => 'What\'s New - Movie Review Hub',
            'isLoggedIn' => $this->isLoggedIn()
        ]);
    }
}