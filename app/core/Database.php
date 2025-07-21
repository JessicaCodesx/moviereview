<?php

namespace Core;

class Database {
    private static $instance = null;
    private $connection;
    private $config;

    public function __construct() {
        $this->config = require CONFIG_PATH . '/database.php';
        $this->connect();
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function connect() {
        try {
            $dsn = "mysql:host={$this->config['host']};dbname={$this->config['database']};charset={$this->config['charset']}";
            $this->connection = new \PDO($dsn, $this->config['username'], $this->config['password'], $this->config['options']);
        } catch (\PDOException $e) {
            throw new \Exception("Database connection failed: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->connection;
    }

    public function initializeTables() {
        $this->createMoviesTable();
        $this->createRatingsTable();
        $this->createReviewsTable();
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
        )";
        $this->connection->exec($sql);
    }

    private function createRatingsTable() {
        $sql = "CREATE TABLE IF NOT EXISTS ratings (
            id INT AUTO_INCREMENT PRIMARY KEY,
            movie_id INT,
            rating INT CHECK (rating >= 1 AND rating <= 5),
            user_ip VARCHAR(45),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (movie_id) REFERENCES movies(id),
            UNIQUE KEY unique_user_movie (movie_id, user_ip)
        )";
        $this->connection->exec($sql);
    }

    private function createReviewsTable() {
        $sql = "CREATE TABLE IF NOT EXISTS ai_reviews (
            id INT AUTO_INCREMENT PRIMARY KEY,
            movie_id INT,
            review TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (movie_id) REFERENCES movies(id)
        )";
        $this->connection->exec($sql);
    }
}