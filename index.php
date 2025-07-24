<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

// Start session FIRST before any output - BUT only if headers haven't been sent
if (!headers_sent()) {
    session_start();
} else {
    error_log("Headers already sent, cannot start session");
}

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

        error_log("Autoloader: Trying to load $class from $file");

        if (file_exists($file)) {
            require_once $file;
            error_log("Autoloader: Successfully loaded $class");
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
        error_log("Loaded core file: $file");
    }

    // Initialize database
    error_log("Initializing database...");
    $database = new Core\Database();
    $database->initializeTables();
    error_log("Database initialized successfully");

    // Initialize router
    error_log("Initializing router...");
    $router = new Core\Router();

    // Register routes - CRITICAL: Make sure all routes are registered
    error_log("Registering routes...");

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
    $router->get('/settings', 'Controllers\SettingsController@index');
    $router->get('/profile', 'Controllers\AuthController@profile');
    $router->get('/watchlist', 'Controllers\UserController@watchlist');
    $router->get('/watched', 'Controllers\UserController@watchedMovies');

    // Movie API routes
    $router->get('/api/search', 'Controllers\MovieController@search'); // Support GET for direct access
    $router->post('/api/search', 'Controllers\MovieController@search'); // Support POST for AJAX
    $router->get('/search', 'Controllers\MovieController@searchPage'); // Support direct search page access
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
    $router->post('/api/user/update-profile', 'Controllers\SettingsController@updateProfile');
    $router->post('/api/user/update-preferences', 'Controllers\SettingsController@updatePreferences');
    $router->post('/api/user/deactivate', 'Controllers\SettingsController@deactivateAccount');
    $router->post('/api/watchlist/remove', 'Controllers\UserController@removeFromWatchlist');
    $router->post('/api/movie/watch', 'Controllers\UserController@markWatched');
    $router->post('/api/movie/unwatch', 'Controllers\UserController@unmarkWatched');
    $router->post('/api/movie/status', 'Controllers\UserController@getMovieStatus');

    // Static page routes
    $router->get('/features', 'Controllers\PagesController@features');
    $router->get('/about', 'Controllers\PagesController@about');
    $router->get('/contact', 'Controllers\PagesController@contact');
    $router->post('/api/contact/submit', 'Controllers\PagesController@submitContact');

    error_log("All routes registered successfully");

    // Debug: Log current request details
    $currentMethod = $_SERVER['REQUEST_METHOD'] ?? 'UNKNOWN';
    $currentPath = $_SERVER['REQUEST_URI'] ?? '/unknown';
    error_log("Processing request: $currentMethod $currentPath");

    // Process the request
    error_log("Dispatching router...");
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
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                    color: white;
                    min-height: 100vh;
                }
                .error-container { 
                    max-width: 800px; 
                    margin: 0 auto; 
                    background: rgba(255,255,255,0.1);
                    backdrop-filter: blur(20px);
                    border-radius: 20px; 
                    overflow: hidden;
                    padding: 40px;
                }
                .error-details {
                    background: rgba(0,0,0,0.3);
                    border-radius: 10px;
                    padding: 20px;
                    margin: 20px 0;
                    font-family: monospace;
                    white-space: pre-wrap;
                    overflow-x: auto;
                }
                .btn {
                    display: inline-block;
                    padding: 12px 24px;
                    background: rgba(255,255,255,0.2);
                    color: white;
                    text-decoration: none;
                    border-radius: 10px;
                    margin: 10px 5px;
                    border: 2px solid rgba(255,255,255,0.3);
                }
                .btn:hover { background: rgba(255,255,255,0.3); }
            </style>
        </head>
        <body>
            <div class="error-container">
                <h1>🚨 Application Error</h1>
                <p>Something went wrong while processing your request.</p>

                <div class="error-details">
<strong>Message:</strong> <?php echo htmlspecialchars($e->getMessage()); ?>

<strong>File:</strong> <?php echo htmlspecialchars($e->getFile()); ?>

<strong>Line:</strong> <?php echo $e->getLine(); ?>

<strong>Stack Trace:</strong>
<?php echo htmlspecialchars($e->getTraceAsString()); ?>
                </div>

                <h3>Quick Actions:</h3>
                <a href="/debug.php" class="btn">🔍 Debug Info</a>
                <a href="/test.php" class="btn">🧪 Simple Test</a>
                <a href="/" class="btn">🔄 Try Again</a>
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
                color: white;
            }
            .container {
                max-width: 800px;
                margin: 0 auto;
                background: rgba(255,255,255,0.1);
                backdrop-filter: blur(20px);
                border-radius: 20px;
                padding: 40px;
            }
            .status {
                padding: 15px;
                border-radius: 8px;
                margin-bottom: 20px;
            }
            .status.error {
                background: rgba(239, 68, 68, 0.2);
                border: 1px solid rgba(239, 68, 68, 0.3);
            }
            .env-var {
                background: rgba(255,255,255,0.1);
                padding: 15px;
                margin: 10px 0;
                border-radius: 8px;
                border-left: 4px solid #667eea;
            }
            .refresh-btn {
                background: rgba(255,255,255,0.2);
                color: white;
                border: 2px solid rgba(255,255,255,0.3);
                padding: 15px 30px;
                border-radius: 10px;
                font-size: 16px;
                cursor: pointer;
                margin-top: 20px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>🎬 Movie Review Hub</h1>
            <p>Environment Setup Required</p>

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
                <?php foreach ($envValidation['missing_vars'] as $var): ?>
                    <div class="env-var">
                        <h4><?php echo $var['name']; ?></h4>
                        <p><?php echo htmlspecialchars($var['description']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <button class="refresh-btn" onclick="window.location.reload()">
                🔄 Check Configuration Again
            </button>
        </div>
    </body>
    </html>
    <?php
}
?>