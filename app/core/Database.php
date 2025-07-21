<?php

namespace Core;

class Database {
    private static $instance = null;
    private $connection;
    private $config;

    public function __construct() {
        $this->config = require CONFIG_PATH . '/database.php';
        $this->validateConfig();
        $this->connect();
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function validateConfig() {
        $required = ['host', 'database', 'username', 'password'];
        foreach ($required as $key) {
            if (empty($this->config[$key])) {
                throw new \Exception("Database configuration missing: {$key}");
            }
        }
    }

    private function connect() {
        try {
            $dsn = "mysql:host={$this->config['host']};port={$this->config['port']};dbname={$this->config['database']};charset={$this->config['charset']}";
            $this->connection = new \PDO($dsn, $this->config['username'], $this->config['password'], $this->config['options']);

            // Test the connection
            $this->connection->query('SELECT 1');

        } catch (\PDOException $e) {
            throw new \Exception("Database connection failed: " . $e->getMessage());
        }
    }

    public function getConnection() {
        // Ensure connection is still alive
        try {
            $this->connection->query('SELECT 1');
        } catch (\PDOException $e) {
            // Reconnect if connection is lost
            $this->connect();
        }

        return $this->connection;
    }

    public function testConnection() {
        try {
            $stmt = $this->connection->query('SELECT VERSION() as version');
            $result = $stmt->fetch();
            return [
                'status' => 'connected',
                'version' => $result['version'] ?? 'unknown',
                'host' => $this->config['host'],
                'database' => $this->config['database']
            ];
        } catch (\PDOException $e) {
            return [
                'status' => 'error',
                'error' => $e->getMessage(),
                'host' => $this->config['host'],
                'database' => $this->config['database']
            ];
        }
    }

    public function initializeTables() {
        try {
            $this->createMoviesTable();
            $this->createRatingsTable();
            $this->createReviewsTable();
            $this->createIndexes();
        } catch (\PDOException $e) {
            throw new \Exception("Failed to initialize database tables: " . $e->getMessage());
        }
    }

    private function createMoviesTable() {
        $sql = "CREATE TABLE IF NOT EXISTS movies (
            id INT AUTO_INCREMENT PRIMARY KEY,
            imdb_id VARCHAR(20) UNIQUE,
            title VARCHAR(255),
            year VARCHAR(10),
            plot TEXT,
            poster VARCHAR(500),
            director VARCHAR(255),
            actors VARCHAR(500),
            genre VARCHAR(255),
            runtime VARCHAR(50),
            rating VARCHAR(10),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        $this->connection->exec($sql);
    }

    private function createRatingsTable() {
        $sql = "CREATE TABLE IF NOT EXISTS ratings (
            id INT AUTO_INCREMENT PRIMARY KEY,
            movie_id INT,
            rating INT CHECK (rating >= 1 AND rating <= 5),
            user_ip VARCHAR(45),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE,
            UNIQUE KEY unique_user_movie (movie_id, user_ip)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        $this->connection->exec($sql);
    }

    private function createReviewsTable() {
        $sql = "CREATE TABLE IF NOT EXISTS ai_reviews (
            id INT AUTO_INCREMENT PRIMARY KEY,
            movie_id INT,
            review TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        $this->connection->exec($sql);
    }

    private function createIndexes() {
        $indexes = [
            "CREATE INDEX IF NOT EXISTS idx_movies_imdb_id ON movies(imdb_id)",
            "CREATE INDEX IF NOT EXISTS idx_movies_title ON movies(title)",
            "CREATE INDEX IF NOT EXISTS idx_ratings_movie_id ON ratings(movie_id)",
            "CREATE INDEX IF NOT EXISTS idx_ratings_user_ip ON ratings(user_ip)",
            "CREATE INDEX IF NOT EXISTS idx_reviews_movie_id ON ai_reviews(movie_id)"
        ];

        foreach ($indexes as $sql) {
            $this->connection->exec($sql);
        }
    }
}