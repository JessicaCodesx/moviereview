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
        $data = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ];

        $options = [
            'http' => [
                'header' => [
                    'Content-Type: application/json',
                    'x-goog-api-key: ' . $this->config['gemini_api_key']
                ],
                'method' => 'POST',
                'content' => json_encode($data),
                'timeout' => 30
            ]
        ];

        $context = stream_context_create($options);
        $response = @file_get_contents($this->config['gemini_api_url'], false, $context);

        if ($response) {
            $result = json_decode($response, true);
            if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                return $result['candidates'][0]['content']['parts'][0]['text'];
            } else if (isset($result['error'])) {
                throw new \Exception("Gemini API error: " . $result['error']['message']);
            }
        }

        return null;
    }

    public function testGemini() {
        try {
            $testPrompt = "Say 'API test successful' in exactly those words.";
            $response = $this->generateReview($testPrompt);

            if ($response && stripos($response, 'API test successful') !== false) {
                return ['status' => 'ok', 'service' => 'Gemini AI'];
            } else {
                return ['status' => 'error', 'service' => 'Gemini AI', 'error' => 'Unexpected response'];
            }
        } catch (\Exception $e) {
            return ['status' => 'error', 'service' => 'Gemini AI', 'error' => $e->getMessage()];
        }
    }

    private function makeRequest($url) {
        $context = stream_context_create([
            'http' => [
                'timeout' => 30,
                'user_agent' => 'Movie Review Hub/1.0'
            ]
        ]);

        $response = @file_get_contents($url, false, $context);

        if ($response === false) {
            throw new \Exception("Failed to make HTTP request to: " . parse_url($url, PHP_URL_HOST));
        }

        return json_decode($response, true);
    }
}