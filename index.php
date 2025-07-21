<?php

// start session
session_start();

// root path
define('ROOT_PATH', __DIR__);
define('APP_PATH', ROOT_PATH . '/app');
define('CONFIG_PATH', ROOT_PATH . '/config');

// autoloader
spl_autoload_register(function ($class) {
    // Convert namespace to file path
    $classPath = str_replace('\\', '/', $class);
    $file = APP_PATH . '/' . strtolower($classPath) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

// load configuration
require_once CONFIG_PATH . '/app.php';
require_once CONFIG_PATH . '/database.php';

// load core classes
require_once APP_PATH . '/core/Database.php';
require_once APP_PATH . '/core/Router.php';
require_once APP_PATH . '/core/APIClient.php';

// load base classes
require_once APP_PATH . '/models/BaseModel.php';
require_once APP_PATH . '/controllers/BaseController.php';

try {
    // initialize database
    $database = new Core\Database();
    $database->initializeTables();

    // initialize router
    $router = new Core\Router();

    // define routes
    $router->get('/', 'Controllers\MovieController@index');
    $router->post('/api/search', 'Controllers\MovieController@search');
    $router->post('/api/movie', 'Controllers\MovieController@getMovie');
    $router->post('/api/rate', 'Controllers\RatingController@addRating');
    $router->post('/api/review', 'Controllers\ReviewController@generateReview');

    // process request
    $router->dispatch();

} catch (Exception $e) {
    // log error and show user friendly message
    error_log($e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Internal server error']);
}