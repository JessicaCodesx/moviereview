
namespace Core;

class APIClient {
    private $config;

    public function __construct() {
        $this->config = require CONFIG_PATH . '/app.php';
    }

    public function searchOMDB($query) {
        $url = $this->config['omdb_api_url'] . "?s=" . urlencode($query) . "&apikey=" . $this->config['omdb_api_key'];
        return $this->makeRequest($url);
    }

    public function getMovieDetails($imdbId) {
        $url = $this->config['omdb_api_url'] . "?i=" . urlencode($imdbId) . "&apikey=" . $this->config['omdb_api_key'];
        return $this->makeRequest($url);
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
                'content' => json_encode($data)
            ]
        ];

        $context = stream_context_create($options);
        $response = file_get_contents($this->config['gemini_api_url'], false, $context);

        if ($response) {
            $result = json_decode($response, true);
            if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                return $result['candidates'][0]['content']['parts'][0]['text'];
            }
        }

        return null;
    }

    private function makeRequest($url) {
        $response = file_get_contents($url);
        return $response ? json_decode($response, true) : null;
    }
}