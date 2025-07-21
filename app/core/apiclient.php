<?php
namespace Core;

class APIClient {
    private $config;

    public function __construct() {
        $this->config = require CONFIG_PATH . '/app.php';
        $this->validateConfig();
    }

    private function validateConfig() {
        if (empty($this->config['omdb_api_key'])) {
            throw new \Exception("OMDB API key not configured");
        }
        if (empty($this->config['gemini_api_key'])) {
            throw new \Exception("Gemini API key not configured");
        }
    }

    public function searchOMDB($query) {
        $url = $this->config['omdb_api_url'] . "?s=" . urlencode($query) . "&apikey=" . $this->config['omdb_api_key'];
        return $this->makeRequest($url);
    }

    public function getMovieDetails($imdbId) {
        $url = $this->config['omdb_api_url'] . "?i=" . urlencode($imdbId) . "&apikey=" . $this->config['omdb_api_key'];
        return $this->makeRequest($url);
    }

    public function testOMDB() {
        try {
            $testUrl = $this->config['omdb_api_url'] . "?t=test&apikey=" . $this->config['omdb_api_key'];
            $response = $this->makeRequest($testUrl);

            if ($response && (!isset($response['Error']) || strpos($response['Error'], 'Invalid API key') === false)) {
                return ['status' => 'ok', 'service' => 'OMDB'];
            } else {
                return ['status' => 'error', 'service' => 'OMDB', 'error' => $response['Error'] ?? 'Unknown error'];
            }
        } catch (\Exception $e) {
            return ['status' => 'error', 'service' => 'OMDB', 'error' => $e->getMessage()];
        }
    }

    public function generateReview($prompt) {
        // Updated API endpoint for the current Gemini API
        $model = 'gemini-2.5-flash';
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent";

        $data = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.7,
                'maxOutputTokens' => 1024,
                'topP' => 0.8,
                'topK' => 40
            ]
        ];

        $postData = json_encode($data);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("JSON encoding error: " . json_last_error_msg());
        }

        $options = [
            'http' => [
                'header' => [
                    'Content-Type: application/json',
                    'x-goog-api-key: ' . $this->config['gemini_api_key']
                ],
                'method' => 'POST',
                'content' => $postData,
                'timeout' => 30,
                'ignore_errors' => true
            ]
        ];

        $context = stream_context_create($options);
        $response = @file_get_contents($url, false, $context);

        // Log the response for debugging
        error_log("Gemini API Response: " . $response);

        if ($response === false) {
            $error = error_get_last();
            throw new \Exception("Failed to make request to Gemini API: " . ($error['message'] ?? 'Unknown error'));
        }

        // Check HTTP status code
        if (isset($http_response_header)) {
            $statusLine = $http_response_header[0] ?? '';
            if (strpos($statusLine, '200') === false) {
                error_log("Gemini API HTTP Error: " . $statusLine);
                error_log("Gemini API Response Body: " . $response);
                throw new \Exception("Gemini API HTTP Error: " . $statusLine);
            }
        }

        $result = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Invalid JSON response from Gemini API: " . json_last_error_msg());
        }

        // Check for API errors
        if (isset($result['error'])) {
            $errorMessage = $result['error']['message'] ?? 'Unknown API error';
            $errorCode = $result['error']['code'] ?? 'UNKNOWN';
            throw new \Exception("Gemini API error [{$errorCode}]: {$errorMessage}");
        }

        // Extract the generated text
        if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
            return trim($result['candidates'][0]['content']['parts'][0]['text']);
        }

        // Check for blocked content
        if (isset($result['candidates'][0]['finishReason']) && 
            $result['candidates'][0]['finishReason'] === 'SAFETY') {
            throw new \Exception("Content was blocked by safety filters");
        }

        error_log("Unexpected Gemini API response structure: " . $response);
        throw new \Exception("Unexpected response format from Gemini API");
    }

    public function testGemini() {
        try {
            $testPrompt = "Say 'API test successful' in exactly those words.";
            $response = $this->generateReview($testPrompt);

            if ($response && stripos($response, 'API test successful') !== false) {
                return ['status' => 'ok', 'service' => 'Gemini AI'];
            } else {
                return ['status' => 'error', 'service' => 'Gemini AI', 'error' => 'Unexpected response: ' . $response];
            }
        } catch (\Exception $e) {
            return ['status' => 'error', 'service' => 'Gemini AI', 'error' => $e->getMessage()];
        }
    }

    private function makeRequest($url) {
        $context = stream_context_create([
            'http' => [
                'timeout' => 30,
                'user_agent' => 'Movie Review Hub/1.0',
                'ignore_errors' => true
            ]
        ]);

        $response = @file_get_contents($url, false, $context);

        if ($response === false) {
            throw new \Exception("Failed to make HTTP request to: " . parse_url($url, PHP_URL_HOST));
        }

        $result = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Invalid JSON response from API");
        }

        return $result;
    }
}