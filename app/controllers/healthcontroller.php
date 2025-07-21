<?php
namespace Controllers;

use Core\Database;
use Core\APIClient;

class HealthController extends BaseController {

    public function check() {
        $health = [
            'status' => 'ok',
            'timestamp' => date('Y-m-d H:i:s'),
            'services' => []
        ];

        // Check database
        try {
            $db = Database::getInstance();
            $dbStatus = $db->testConnection();
            $health['services']['database'] = $dbStatus;

            if ($dbStatus['status'] !== 'connected') {
                $health['status'] = 'error';
            }
        } catch (\Exception $e) {
            $health['services']['database'] = [
                'status' => 'error',
                'error' => $e->getMessage()
            ];
            $health['status'] = 'error';
        }

        // Check APIs
        try {
            $apiClient = new APIClient();

            // Test OMDB
            $omdbStatus = $apiClient->testOMDB();
            $health['services']['omdb'] = $omdbStatus;

            if ($omdbStatus['status'] !== 'ok') {
                $health['status'] = $health['status'] === 'ok' ? 'warning' : 'error';
            }

            // Test Gemini (optional, as it might be slow)
            if (isset($_GET['full']) && $_GET['full'] === 'true') {
                $geminiStatus = $apiClient->testGemini();
                $health['services']['gemini'] = $geminiStatus;

                if ($geminiStatus['status'] !== 'ok') {
                    $health['status'] = $health['status'] === 'ok' ? 'warning' : 'error';
                }
            } else {
                $health['services']['gemini'] = ['status' => 'skipped', 'note' => 'Use ?full=true to test'];
            }

        } catch (\Exception $e) {
            $health['services']['apis'] = [
                'status' => 'error',
                'error' => $e->getMessage()
            ];
            $health['status'] = 'error';
        }

        // Environment check
        $health['environment'] = [
            'php_version' => PHP_VERSION,
            'app_debug' => getenv('APP_DEBUG') ? 'enabled' : 'disabled',
            'timezone' => date_default_timezone_get(),
            'memory_limit' => ini_get('memory_limit'),
            'max_execution_time' => ini_get('max_execution_time')
        ];

        // Set appropriate HTTP status code
        $statusCode = 200;
        if ($health['status'] === 'warning') {
            $statusCode = 200; // Still OK but with warnings
        } elseif ($health['status'] === 'error') {
            $statusCode = 503; // Service unavailable
        }

        $this->jsonResponse($health, $statusCode);
    }
}