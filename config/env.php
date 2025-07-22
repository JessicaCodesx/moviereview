<?php
// config/env.php - Environment Variable Validator for Replit

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

        // Check if we're in Replit environment
        $isReplit = !empty(getenv('REPL_ID')) || !empty(getenv('REPLIT_DB_URL'));

        // Check required variables
        foreach (self::$requiredVars as $var => $description) {
            $value = self::getEnvVar($var);
            if (empty($value)) {
                $missingVars[] = [
                    'name' => $var,
                    'description' => $description,
                    'required' => true
                ];
            }
        }

        // Validate database connection if credentials are provided
        if (!empty(self::getEnvVar('DB_HOST')) && !empty(self::getEnvVar('DB_USERNAME'))) {
            try {
                $dbConfig = [
                    'host' => self::getEnvVar('DB_HOST'),
                    'port' => self::getEnvVar('DB_PORT') ?: 3306,
                    'username' => self::getEnvVar('DB_USERNAME'),
                    'password' => self::getEnvVar('DB_PASSWORD'),
                    'database' => self::getEnvVar('DB_DATABASE'),
                    'charset' => self::getEnvVar('DB_CHARSET') ?: 'utf8mb4'
                ];

                $dsn = "mysql:host={$dbConfig['host']};port={$dbConfig['port']};charset={$dbConfig['charset']}";
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_TIMEOUT => 30
                ];

                // Try to connect without specifying database first
                $pdo = new PDO($dsn, $dbConfig['username'], $dbConfig['password'], $options);

                // Try to use the specified database
                $pdo->exec("USE `{$dbConfig['database']}`");

            } catch (PDOException $e) {
                $errors[] = "Database connection failed: " . $e->getMessage();
            }
        }

        // Validate OMDB API key
        if (!empty(self::getEnvVar('OMDB_API_KEY'))) {
            try {
                $testUrl = "http://www.omdbapi.com/?t=test&apikey=" . self::getEnvVar('OMDB_API_KEY');
                $context = stream_context_create([
                    'http' => [
                        'timeout' => 10,
                        'ignore_errors' => true
                    ]
                ]);
                $response = @file_get_contents($testUrl, false, $context);
                $data = $response ? json_decode($response, true) : null;

                if (!$data || (isset($data['Error']) && strpos($data['Error'], 'Invalid API key') !== false)) {
                    $errors[] = "OMDB API key appears to be invalid";
                }
            } catch (Exception $e) {
                $errors[] = "Unable to validate OMDB API key: " . $e->getMessage();
            }
        }

        return [
            'missing_vars' => $missingVars,
            'optional_vars' => self::$optionalVars,
            'errors' => $errors,
            'is_valid' => empty($missingVars) && empty($errors),
            'is_replit' => $isReplit,
            'debug_info' => self::getDebugInfo()
        ];
    }

    /**
     * Get environment variable with fallback methods for Replit
     */
    private static function getEnvVar($key) {
        // Try getenv first (should work in Replit)
        $value = getenv($key);
        if ($value !== false) {
            return $value;
        }

        // Try $_ENV superglobal
        if (isset($_ENV[$key])) {
            return $_ENV[$key];
        }

        // Try $_SERVER superglobal
        if (isset($_SERVER[$key])) {
            return $_SERVER[$key];
        }

        return null;
    }

    private static function getDebugInfo() {
        return [
            'repl_id' => self::getEnvVar('REPL_ID'),
            'repl_slug' => self::getEnvVar('REPL_SLUG'),
            'repl_owner' => self::getEnvVar('REPL_OWNER'),
            'env_count' => count($_ENV),
            'server_count' => count($_SERVER),
            'available_vars' => array_keys($_ENV)
        ];
    }

    public static function getSetupInstructions() {
        $isReplit = !empty(getenv('REPL_ID')) || !empty(getenv('REPLIT_DB_URL'));

        if ($isReplit) {
            return [
                'replit' => [
                    'title' => 'Setting up Secrets in Replit',
                    'steps' => [
                        '1. In your Replit workspace, look for the "Secrets" tab in the left sidebar (🔒 lock icon)',
                        '2. If you don\'t see it, click on "Tools" and then "Secrets"',
                        '3. For each required variable, click "New Secret" and add:',
                        '   • Key: The exact variable name (case-sensitive)',
                        '   • Value: Your actual secret value',
                        '4. Required secrets to add:',
                        '   • DB_HOST: Your database host (filess.io host)',
                        '   • DB_DATABASE: moviereview',
                        '   • DB_USERNAME: Your database username',
                        '   • DB_PASSWORD: Your database password',
                        '   • OMDB_API_KEY: Get from http://www.omdbapi.com/apikey.aspx',
                        '   • GEMINI_API_KEY: Get from https://aistudio.google.com/app/apikey',
                        '5. After adding all secrets, restart your Repl (Stop → Run)',
                        '6. Refresh this page to check the configuration'
                    ]
                ]
            ];
        } else {
            return [
                'local' => [
                    'title' => 'Setting up Environment Variables Locally',
                    'steps' => [
                        '1. Create a .env file in your project root',
                        '2. Add your environment variables in KEY=VALUE format',
                        '3. Install a library like vlucas/phpdotenv to load the .env file',
                        '4. Never commit the .env file to version control'
                    ]
                ]
            ];
        }
    }

    /**
     * Helper method to check if specific required vars are missing
     */
    public static function getMissingRequiredVars() {
        $missing = [];
        foreach (self::$requiredVars as $var => $description) {
            if (empty(self::getEnvVar($var))) {
                $missing[] = $var;
            }
        }
        return $missing;
    }

    /**
     * Helper method for quick validation
     */
    public static function isConfigured() {
        return empty(self::getMissingRequiredVars());
    }
}