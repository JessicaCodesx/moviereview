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
            $this->createUsersTable();
            $this->createMoviesTable();
            $this->createRatingsTable();
            $this->createReviewsTable();
            $this->createWatchlistTable();
            $this->createUserMoviesTable();
            $this->createUserPreferencesTable();
            $this->createIndexes();
        } catch (\PDOException $e) {
            throw new \Exception("Failed to initialize database tables: " . $e->getMessage());
        }
    }

    private function createUsersTable() {
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) UNIQUE NOT NULL,
            email VARCHAR(255) NULL,
            password VARCHAR(255) NOT NULL,
            bio TEXT NULL,
            status ENUM('active', 'deactivated') DEFAULT 'active',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            last_login TIMESTAMP NULL,
            deactivated_at TIMESTAMP NULL,
            INDEX idx_username (username),
            INDEX idx_email (email)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        $this->connection->exec($sql);

        // Add columns to existing table if they don't exist
        $this->addColumnIfNotExists('users', 'email', 'VARCHAR(255) NULL AFTER username');
        $this->addColumnIfNotExists('users', 'bio', 'TEXT NULL AFTER password');
        $this->addColumnIfNotExists('users', 'status', 'ENUM(\'active\', \'deactivated\') DEFAULT \'active\' AFTER bio');
        $this->addColumnIfNotExists('users', 'deactivated_at', 'TIMESTAMP NULL AFTER last_login');
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
        // Updated to support both user_id and user_ip for backwards compatibility
        $sql = "CREATE TABLE IF NOT EXISTS ratings (
            id INT AUTO_INCREMENT PRIMARY KEY,
            movie_id INT,
            user_id INT NULL,
            rating INT CHECK (rating >= 1 AND rating <= 5),
            user_ip VARCHAR(45),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            UNIQUE KEY unique_user_movie (movie_id, user_id),
            UNIQUE KEY unique_ip_movie (movie_id, user_ip)
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

    private function createWatchlistTable() {
        $sql = "CREATE TABLE IF NOT EXISTS watchlist (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            movie_id INT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE,
            UNIQUE KEY unique_user_watchlist (user_id, movie_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        $this->connection->exec($sql);
    }

    private function createUserMoviesTable() {
        $sql = "CREATE TABLE IF NOT EXISTS user_movies (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            movie_id INT,
            status ENUM('watched', 'want_to_watch') DEFAULT 'watched',
            watched_at TIMESTAMP NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE,
            UNIQUE KEY unique_user_movie_status (user_id, movie_id, status)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        $this->connection->exec($sql);
    }

    private function createUserPreferencesTable() {
        $sql = "CREATE TABLE IF NOT EXISTS user_preferences (
            user_id INT PRIMARY KEY,
            email_notifications BOOLEAN DEFAULT TRUE,
            movie_recommendations BOOLEAN DEFAULT TRUE,
            rating_privacy ENUM('public', 'private') DEFAULT 'public',
            watchlist_privacy ENUM('public', 'private') DEFAULT 'public',
            theme_preference ENUM('auto', 'light', 'dark') DEFAULT 'auto',
            language VARCHAR(10) DEFAULT 'en',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        $this->connection->exec($sql);
    }

    private function addColumnIfNotExists($table, $column, $definition) {
        try {
            $stmt = $this->connection->prepare("SHOW COLUMNS FROM `{$table}` LIKE ?");
            $stmt->execute([$column]);
            if ($stmt->rowCount() == 0) {
                $sql = "ALTER TABLE `{$table}` ADD COLUMN `{$column}` {$definition}";
                $this->connection->exec($sql);
            }
        } catch (\PDOException $e) {
            // Column might already exist or other issue, log but continue
            error_log("Error adding column {$column} to {$table}: " . $e->getMessage());
        }
    }

    private function createIndexes() {
        $indexes = [
            "CREATE INDEX IF NOT EXISTS idx_movies_imdb_id ON movies(imdb_id)",
            "CREATE INDEX IF NOT EXISTS idx_movies_title ON movies(title)",
            "CREATE INDEX IF NOT EXISTS idx_movies_genre ON movies(genre)",
            "CREATE INDEX IF NOT EXISTS idx_ratings_movie_id ON ratings(movie_id)",
            "CREATE INDEX IF NOT EXISTS idx_ratings_user_id ON ratings(user_id)",
            "CREATE INDEX IF NOT EXISTS idx_ratings_user_ip ON ratings(user_ip)",
            "CREATE INDEX IF NOT EXISTS idx_reviews_movie_id ON ai_reviews(movie_id)",
            "CREATE INDEX IF NOT EXISTS idx_watchlist_user_id ON watchlist(user_id)",
            "CREATE INDEX IF NOT EXISTS idx_watchlist_movie_id ON watchlist(movie_id)",
            "CREATE INDEX IF NOT EXISTS idx_user_movies_user_id ON user_movies(user_id)",
            "CREATE INDEX IF NOT EXISTS idx_user_movies_status ON user_movies(status)",
            "CREATE INDEX IF NOT EXISTS idx_user_movies_watched_at ON user_movies(watched_at)"
        ];

        foreach ($indexes as $sql) {
            try {
                $this->connection->exec($sql);
            } catch (\PDOException $e) {
                // Ignore index creation errors (might already exist)
                continue;
            }
        }
    }
}