<?php
// config/env.php - Environment Variable Validator

class EnvValidator {
    private static $requiredVars = [
        'DB_HOST' => 'Database host (e.g., your-filess-io-host)',
        'DB_DATABASE' => 'Database name (e.g., moviereview)',
        'DB_USERNAME' => 'Database username',
        'DB_PASSWORD' => 'Database password',
        'OMDB_API_KEY' => 'OMDB API key from http://www.omdbapi.com/apikey.aspx',
        'GEMINI_API_KEY' => 'Google Gemini API key from https://aistudio.google.com/app/apikey'
    ];

    private static $optionalVars = [
        'APP_NAME' => 'Application name (default: Movie Review Hub)',
        'APP_DEBUG' => 'Debug mode (true/false, default: false)',
        'APP_TIMEZONE' => 'Application timezone (default: UTC)',
        'DB_PORT' => 'Database port (default: 3306)',
        'DB_CHARSET' => 'Database charset (default: utf8mb4)',
        'MAX_RATINGS_PER_IP' => 'Max ratings per IP per movie (default: 1)',
        'CACHE_REVIEWS' => 'Cache AI reviews (true/false, default: true)',
        'DEFAULT_POSTER' => 'Default poster URL for movies without images'
    ];

    public static function validate() {
        $missingVars = [];
        $errors = [];

        // Check required variables
        foreach (self::$requiredVars as $var => $description) {
            $value = getenv($var);
            if (empty($value)) {
                $missingVars[] = [
                    'name' => $var,
                    'description' => $description,
                    'required' => true
                ];
            }
        }

        // Validate database connection if credentials are provided
        if (!empty(getenv('DB_HOST')) && !empty(getenv('DB_USERNAME'))) {
            try {
                $dbConfig = require __DIR__ . '/database.php';
                $dsn = "mysql:host={$dbConfig['host']};port={$dbConfig['port']};charset={$dbConfig['charset']}";

                // Try to connect without specifying database first
                $pdo = new PDO($dsn, $dbConfig['username'], $dbConfig['password'], $dbConfig['options']);

                // Try to use the specified database
                $pdo->exec("USE `{$dbConfig['database']}`");

            } catch (PDOException $e) {
                $errors[] = "Database connection failed: " . $e->getMessage();
            }
        }

        // Validate API keys by making test requests
        if (!empty(getenv('OMDB_API_KEY'))) {
            $testUrl = "http://www.omdbapi.com/?t=test&apikey=" . getenv('OMDB_API_KEY');
            $response = @file_get_contents($testUrl);
            $data = $response ? json_decode($response, true) : null;

            if (!$data || (isset($data['Error']) && strpos($data['Error'], 'Invalid API key') !== false)) {
                $errors[] = "OMDB API key appears to be invalid";
            }
        }

        return [
            'missing_vars' => $missingVars,
            'optional_vars' => self::$optionalVars,
            'errors' => $errors,
            'is_valid' => empty($missingVars) && empty($errors)
        ];
    }

    public static function getSetupInstructions() {
        return [
            'replit' => [
                'title' => 'Setting up Environment Variables in Replit',
                'steps' => [
                    '1. Open your Replit project',
                    '2. Click on the "Secrets" tab in the left sidebar (lock icon)',
                    '3. Add each required environment variable:',
                    '   - Key: Variable name (e.g., DB_HOST)',
                    '   - Value: Your actual value (e.g., your-filess-io-host)',
                    '4. Click "Add new secret" for each variable',
                    '5. Restart your Replit after adding all secrets'
                ]
            ],
            'local' => [
                'title' => 'Setting up Environment Variables Locally',
                'steps' => [
                    '1. Create a .env file in your project root',
                    '2. Add your environment variables in KEY=VALUE format',
                    '3. Load the .env file in your application',
                    '4. Never commit the .env file to version control'
                ]
            ]
        ];
    }
}