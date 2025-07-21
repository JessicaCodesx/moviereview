<?php
// Start session
session_start();

// Define root path
define('ROOT_PATH', __DIR__);
define('APP_PATH', ROOT_PATH . '/app');
define('CONFIG_PATH', ROOT_PATH . '/config');

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

// Autoloader
spl_autoload_register(function ($class) {
    $classPath = str_replace('\\', '/', $class);
    $file = APP_PATH . '/' . strtolower($classPath) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

// Load configuration
require_once CONFIG_PATH . '/app.php';
require_once CONFIG_PATH . '/database.php';

// Load core classes
require_once APP_PATH . '/core/Database.php';
require_once APP_PATH . '/core/Router.php';
require_once APP_PATH . '/core/APIClient.php';

// Load base classes
require_once APP_PATH . '/models/BaseModel.php';
require_once APP_PATH . '/controllers/BaseController.php';

try {
    // Initialize database
    $database = new Core\Database();
    $database->initializeTables();

    // Initialize router
    $router = new Core\Router();

    // Define routes
    $router->get('/', 'Controllers\MovieController@index');
    $router->get('/health', 'Controllers\HealthController@check');
    $router->post('/api/search', 'Controllers\MovieController@search');
    $router->post('/api/movie', 'Controllers\MovieController@getMovie');
    $router->post('/api/rate', 'Controllers\RatingController@addRating');
    $router->post('/api/review', 'Controllers\ReviewController@generateReview');

    // Process request
    $router->dispatch();

} catch (Exception $e) {
    // Log error and show user-friendly message
    error_log($e->getMessage());

    if (getenv('APP_DEBUG')) {
        echo '<pre>Debug Error: ' . $e->getMessage() . "\n" . $e->getTraceAsString() . '</pre>';
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Internal server error']);
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

            <div class="instructions">
                <h3>📋 Required Environment Variables</h3>

                <div class="env-var required">
                    <h4><span class="code">DB_HOST</span></h4>
                    <p>Your filess.io database host (e.g., db-mysql-fra1-12345-do-user-123456-0.db.ondigitalocean.com)</p>
                </div>

                <div class="env-var required">
                    <h4><span class="code">DB_DATABASE</span></h4>
                    <p>Your database name: <code>moviereview</code></p>
                </div>

                <div class="env-var required">
                    <h4><span class="code">DB_USERNAME</span></h4>
                    <p>Your database username</p>
                </div>

                <div class="env-var required">
                    <h4><span class="code">DB_PASSWORD</span></h4>
                    <p>Your database password</p>
                </div>

                <div class="env-var required">
                    <h4><span class="code">OMDB_API_KEY</span></h4>
                    <p>Get your free API key from: <a href="http://www.omdbapi.com/apikey.aspx" target="_blank">http://www.omdbapi.com/apikey.aspx</a></p>
                </div>

                <div class="env-var required">
                    <h4><span class="code">GEMINI_API_KEY</span></h4>
                    <p>Get your free API key from: <a href="https://aistudio.google.com/app/apikey" target="_blank">https://aistudio.google.com/app/apikey</a></p>
                </div>
            </div>

            <div class="instructions">
                <h3>🔍 Optional Environment Variables</h3>
                <?php foreach ($envValidation['optional_vars'] as $varName => $description): ?>
                    <div class="env-var">
                        <h4><span class="code"><?php echo $varName; ?></span></h4>
                        <p><?php echo htmlspecialchars($description); ?></p>
                    </div>
                <?php endforeach; ?>
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