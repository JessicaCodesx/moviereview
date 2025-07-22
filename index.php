<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

// Start session FIRST before any output
session_start();

// Define root path
define('ROOT_PATH', __DIR__);
define('APP_PATH', ROOT_PATH . '/app');
define('CONFIG_PATH', ROOT_PATH . '/config');

try {
    // Load environment validator first
    require_once CONFIG_PATH . '/env.php';

    // Check if we're accessing the setup page
    $requestUri = $_SERVER['REQUEST_URI'] ?? '/';
    $isSetupPage = strpos($requestUri, '/setup') !== false;

    // Validate environment variables
    $envValidation = EnvValidator::validate();

    // If environment is invalid and we're not on setup page, show setup
    if (!$envValidation['is_valid'] && !$isSetupPage) {
        showSetupPage($envValidation);
        exit;
    }

    // If accessing setup page directly and env is valid, redirect to home
    if ($isSetupPage && $envValidation['is_valid']) {
        header('Location: /');
        exit;
    }

    // If on setup page, show it
    if ($isSetupPage) {
        showSetupPage($envValidation);
        exit;
    }

    // Autoloader with better error handling
    spl_autoload_register(function ($class) {
        $classPath = str_replace('\\', '/', $class);
        $file = APP_PATH . '/' . strtolower($classPath) . '.php';

        if (file_exists($file)) {
            require_once $file;
            return true;
        }

        // Log missing class files
        error_log("Autoloader: Could not find class file: $file for class: $class");
        return false;
    });

    // Load configuration files
    if (!file_exists(CONFIG_PATH . '/app.php')) {
        throw new Exception('App configuration file missing: ' . CONFIG_PATH . '/app.php');
    }
    if (!file_exists(CONFIG_PATH . '/database.php')) {
        throw new Exception('Database configuration file missing: ' . CONFIG_PATH . '/database.php');
    }

    require_once CONFIG_PATH . '/app.php';
    require_once CONFIG_PATH . '/database.php';

    // Load core classes with error checking
    $coreFiles = [
        APP_PATH . '/core/database.php',
        APP_PATH . '/core/router.php',
        APP_PATH . '/core/apiclient.php',
        APP_PATH . '/models/basemodel.php',
        APP_PATH . '/controllers/basecontroller.php'
    ];

    foreach ($coreFiles as $file) {
        if (!file_exists($file)) {
            throw new Exception("Core file missing: $file");
        }
        require_once $file;
    }

    // Initialize database
    $database = new Core\Database();
    $database->initializeTables();

    // Initialize router
    $router = new Core\Router();

    // Register routes
    // Public routes
    $router->get('/', 'Controllers\MovieController@index');
    $router->get('/health', 'Controllers\HealthController@check');

    // Authentication routes
    $router->get('/login', 'Controllers\AuthController@loginPage');
    $router->get('/register', 'Controllers\AuthController@registerPage');
    $router->post('/api/auth/login', 'Controllers\AuthController@login');
    $router->post('/api/auth/register', 'Controllers\AuthController@register');
    $router->post('/api/auth/logout', 'Controllers\AuthController@logout');
    $router->get('/api/auth/check', 'Controllers\AuthController@checkAuth');
    $router->get('/logout', 'Controllers\AuthController@logout');
    $router->post('/api/auth/change-password', 'Controllers\AuthController@changePassword');
    $router->post('/api/auth/delete-account', 'Controllers\AuthController@deleteAccount');
    $router->get('/api/auth/stats', 'Controllers\AuthController@getUserStats');

    // Rating routes
    $router->get('/api/ratings/user', 'Controllers\RatingController@getUserRatings');
    $router->put('/api/ratings/update', 'Controllers\RatingController@updateRating');
    $router->delete('/api/ratings/delete', 'Controllers\RatingController@deleteRating');
    $router->get('/api/ratings/stats', 'Controllers\RatingController@getRatingStats');
    $router->get('/api/ratings/top', 'Controllers\RatingController@getTopRated');

    // User dashboard routes
    $router->get('/dashboard', 'Controllers\UserController@dashboard');
    $router->get('/profile', 'Controllers\AuthController@profile');
    $router->get('/watchlist', 'Controllers\UserController@watchlist');
    $router->get('/watched', 'Controllers\UserController@watchedMovies');

    // Movie API routes
    $router->post('/api/search', 'Controllers\MovieController@search');
    $router->post('/api/movie', 'Controllers\MovieController@getMovie');
    $router->post('/api/rate', 'Controllers\RatingController@addRating');
    $router->post('/api/review', 'Controllers\ReviewController@generateReview');
    $router->get('/api/movies/trending', 'Controllers\MovieController@trending');
    $router->get('/api/movies/popular', 'Controllers\MovieController@popular');
    $router->get('/api/movies/recent', 'Controllers\MovieController@recentlyAdded');
    $router->get('/api/movies/genre', 'Controllers\MovieController@byGenre');
    $router->post('/api/movies/search-advanced', 'Controllers\MovieController@searchAdvanced');

    // User functionality API routes
    $router->post('/api/watchlist/add', 'Controllers\UserController@addToWatchlist');
    $router->post('/api/watchlist/remove', 'Controllers\UserController@removeFromWatchlist');
    $router->post('/api/movie/watch', 'Controllers\UserController@markWatched');
    $router->post('/api/movie/unwatch', 'Controllers\UserController@unmarkWatched');
    $router->post('/api/movie/status', 'Controllers\UserController@getMovieStatus');

    // Process the request
    $router->dispatch();

} catch (Exception $e) {
    // Enhanced error logging and display
    error_log("Application Fatal Error: " . $e->getMessage());
    error_log("File: " . $e->getFile() . " Line: " . $e->getLine());
    error_log("Stack trace: " . $e->getTraceAsString());

    // Display detailed error information
    http_response_code(500);

    // Check if it's an AJAX request
    $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
              strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode([
            'error' => 'Internal server error',
            'debug' => [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]
        ]);
    } else {
        // Show detailed error page for debugging
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Application Error - Movie Review Hub</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <style>
                body { 
                    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; 
                    margin: 0; 
                    padding: 20px; 
                    background: #f8f9fa; 
                    color: #333;
                }
                .error-container { 
                    max-width: 800px; 
                    margin: 0 auto; 
                    background: white; 
                    border-radius: 8px; 
                    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                    overflow: hidden;
                }
                .error-header {
                    background: #dc3545;
                    color: white;
                    padding: 20px;
                }
                .error-body {
                    padding: 20px;
                }
                .error-details {
                    background: #f8f9fa;
                    border: 1px solid #dee2e6;
                    border-radius: 4px;
                    padding: 15px;
                    margin: 15px 0;
                    font-family: monospace;
                    white-space: pre-wrap;
                }
                .btn {
                    display: inline-block;
                    padding: 10px 20px;
                    background: #007bff;
                    color: white;
                    text-decoration: none;
                    border-radius: 4px;
                    margin-top: 15px;
                }
                .btn:hover { background: #0056b3; }
            </style>
        </head>
        <body>
            <div class="error-container">
                <div class="error-header">
                    <h1>🚨 Application Error</h1>
                    <p>Something went wrong while processing your request.</p>
                </div>
                <div class="error-body">
                    <h3>Error Details:</h3>
                    <div class="error-details">
                        <strong>Message:</strong> <?php echo htmlspecialchars($e->getMessage()); ?>

                        <strong>File:</strong> <?php echo htmlspecialchars($e->getFile()); ?>

                        <strong>Line:</strong> <?php echo $e->getLine(); ?>

                        <strong>Stack Trace:</strong>
                        <?php echo htmlspecialchars($e->getTraceAsString()); ?>
                    </div>

                    <h3>Possible Solutions:</h3>
                    <ul>
                        <li>Check that all required files exist in the correct directories</li>
                        <li>Verify your environment variables are set correctly</li>
                        <li>Ensure your database connection details are correct</li>
                        <li>Check file permissions (especially for logs directory)</li>
                    </ul>

                    <a href="/debug.php" class="btn">Run Debug Check</a>
                    <a href="/" class="btn">Try Again</a>
                </div>
            </div>
        </body>
        </html>
        <?php
    }
}

function showSetupPage($envValidation) {
    $instructions = EnvValidator::getSetupInstructions();
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Setup - Movie Review Hub</title>
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                padding: 20px;
            }
            .container {
                max-width: 800px;
                margin: 0 auto;
                background: white;
                border-radius: 15px;
                padding: 40px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            }
            .header {
                text-align: center;
                margin-bottom: 40px;
                color: #333;
            }
            .header h1 {
                font-size: 2.5rem;
                margin-bottom: 10px;
                color: #667eea;
            }
            .status {
                padding: 15px;
                border-radius: 8px;
                margin-bottom: 20px;
            }
            .status.error {
                background: #f8d7da;
                border: 1px solid #f5c6cb;
                color: #721c24;
            }
            .status.warning {
                background: #fff3cd;
                border: 1px solid #ffeaa7;
                color: #856404;
            }
            .status.success {
                background: #d4edda;
                border: 1px solid #c3e6cb;
                color: #155724;
            }
            .env-var {
                background: #f8f9fa;
                padding: 15px;
                margin: 10px 0;
                border-radius: 8px;
                border-left: 4px solid #667eea;
            }
            .env-var.required {
                border-left-color: #dc3545;
            }
            .env-var h4 {
                color: #333;
                margin-bottom: 5px;
            }
            .env-var p {
                color: #666;
                font-size: 14px;
            }
            .instructions {
                margin-top: 30px;
            }
            .instructions h3 {
                color: #667eea;
                margin-bottom: 15px;
            }
            .instructions ol {
                margin-left: 20px;
            }
            .instructions li {
                margin-bottom: 8px;
                line-height: 1.5;
            }
            .refresh-btn {
                background: linear-gradient(45deg, #667eea, #764ba2);
                color: white;
                border: none;
                padding: 15px 30px;
                border-radius: 8px;
                font-size: 16px;
                cursor: pointer;
                margin-top: 20px;
                transition: transform 0.2s;
            }
            .refresh-btn:hover {
                transform: translateY(-2px);
            }
            .code {
                background: #f1f3f4;
                padding: 2px 6px;
                border-radius: 4px;
                font-family: monospace;
                font-size: 90%;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>🎬 Movie Review Hub</h1>
                <p>Environment Setup Required</p>
            </div>

            <?php if (!empty($envValidation['errors'])): ?>
                <div class="status error">
                    <h3>❌ Configuration Errors</h3>
                    <ul>
                        <?php foreach ($envValidation['errors'] as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (!empty($envValidation['missing_vars'])): ?>
                <div class="status warning">
                    <h3>⚠️ Missing Required Environment Variables</h3>
                    <p>The following environment variables need to be configured:</p>
                </div>

                <?php foreach ($envValidation['missing_vars'] as $var): ?>
                    <div class="env-var required">
                        <h4><span class="code"><?php echo $var['name']; ?></span></h4>
                        <p><?php echo htmlspecialchars($var['description']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <div class="instructions">
                <h3>🔧 <?php echo $instructions['replit']['title']; ?></h3>
                <ol>
                    <?php foreach ($instructions['replit']['steps'] as $step): ?>
                        <li><?php echo htmlspecialchars($step); ?></li>
                    <?php endforeach; ?>
                </ol>
            </div>

            <button class="refresh-btn" onclick="window.location.reload()">
                🔄 Check Configuration Again
            </button>

            <?php if ($envValidation['is_valid']): ?>
                <div class="status success">
                    <h3>✅ Configuration Valid!</h3>
                    <p>All required environment variables are set. <a href="/">Go to Movie Review Hub</a></p>
                </div>
            <?php endif; ?>
        </div>
    </body>
    </html>
    <?php
}
?>