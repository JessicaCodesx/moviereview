<?php
// FIXED app/core/router.php
namespace Core;

class Router {
    private $routes = [];
    private $currentRoute;

    public function get($path, $handler) {
        $this->addRoute('GET', $path, $handler);
    }

    public function post($path, $handler) {
        $this->addRoute('POST', $path, $handler);
    }

    public function put($path, $handler) {
        $this->addRoute('PUT', $path, $handler);
    }

    public function delete($path, $handler) {
        $this->addRoute('DELETE', $path, $handler);
    }

    public function patch($path, $handler) {
        $this->addRoute('PATCH', $path, $handler);
    }

    private function addRoute($method, $path, $handler) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];

        // Debug: Log route registration
        error_log("Router: Registered $method $path -> $handler");
    }

    public function dispatch() {
        $requestMethod = $this->getRequestMethod();
        $requestPath = $this->getCurrentPath();

        // Debug logging
        error_log("Router: Processing $requestMethod $requestPath");
        error_log("Router: Total routes registered: " . count($this->routes));

        foreach ($this->routes as $route) {
            error_log("Router: Checking route {$route['method']} {$route['path']} against $requestMethod $requestPath");

            if ($route['method'] === $requestMethod && $this->matchPath($route['path'], $requestPath)) {
                error_log("Router: Route matched! Calling handler: {$route['handler']}");
                $this->callHandler($route['handler']);
                return;
            }
        }

        // No route found - Enhanced error response
        error_log("Router: No route found for $requestMethod $requestPath");
        http_response_code(404);

        // Check if it's an AJAX request
        $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode([
                'error' => 'Route not found',
                'debug' => [
                    'method' => $requestMethod,
                    'path' => $requestPath,
                    'available_routes' => array_map(function($r) {
                        return $r['method'] . ' ' . $r['path'];
                    }, $this->routes)
                ]
            ]);
        } else {
            // Show a helpful debug page instead of just "Page not found"
            $this->showDebugNotFound($requestMethod, $requestPath);
        }
    }

    private function showDebugNotFound($method, $path) {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Route Not Found - Movie Review Hub</title>
            <style>
                body { 
                    font-family: -apple-system, BlinkMacSystemFont, sans-serif; 
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    color: white; 
                    padding: 20px; 
                    min-height: 100vh;
                    margin: 0;
                }
                .container { 
                    max-width: 800px; 
                    margin: 0 auto; 
                    background: rgba(255,255,255,0.1);
                    backdrop-filter: blur(20px);
                    padding: 40px;
                    border-radius: 20px;
                    text-align: center;
                }
                .route-list {
                    background: rgba(0,0,0,0.2);
                    padding: 20px;
                    border-radius: 10px;
                    margin: 20px 0;
                    text-align: left;
                }
                .btn {
                    display: inline-block;
                    padding: 12px 24px;
                    background: rgba(255,255,255,0.2);
                    color: white;
                    text-decoration: none;
                    border-radius: 10px;
                    margin: 10px;
                    border: 2px solid rgba(255,255,255,0.3);
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>🎬 Route Not Found</h1>
                <p><strong>Requested:</strong> <?php echo htmlspecialchars("$method $path"); ?></p>

                <div class="route-list">
                    <h3>Available Routes:</h3>
                    <?php foreach ($this->routes as $route): ?>
                        <p><code><?php echo htmlspecialchars($route['method'] . ' ' . $route['path']); ?></code> → <?php echo htmlspecialchars($route['handler']); ?></p>
                    <?php endforeach; ?>
                </div>

                <a href="/" class="btn">🏠 Try Home Page</a>
                <a href="/debug.php" class="btn">🔍 Debug Info</a>
            </div>
        </body>
        </html>
        <?php
    }

    private function getRequestMethod() {
        $method = $_SERVER['REQUEST_METHOD'];

        // Handle method override for browsers that don't support PUT/DELETE
        if ($method === 'POST' && isset($_POST['_method'])) {
            $method = strtoupper($_POST['_method']);
        }

        return $method;
    }

    private function getCurrentPath() {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $path = strtok($path, '?'); // Remove query string

        // Debug
        error_log("Router: Raw REQUEST_URI: " . ($_SERVER['REQUEST_URI'] ?? 'NULL'));
        error_log("Router: Parsed path: $path");

        return $path;
    }

    private function matchPath($routePath, $requestPath) {
        $match = $routePath === $requestPath;
        error_log("Router: Matching '$routePath' === '$requestPath' = " . ($match ? 'TRUE' : 'FALSE'));
        return $match;
    }

    private function callHandler($handler) {
        if (is_string($handler) && strpos($handler, '@') !== false) {
            list($class, $method) = explode('@', $handler);

            error_log("Router: Calling $class->$method()");

            // Load controller file
            $controllerFile = APP_PATH . '/' . strtolower(str_replace('\\', '/', $class)) . '.php';
            error_log("Router: Looking for controller file: $controllerFile");

            if (file_exists($controllerFile)) {
                require_once $controllerFile;
                error_log("Router: Controller file loaded successfully");
            } else {
                error_log("Router: Controller file not found: $controllerFile");
                http_response_code(500);
                echo "Controller file not found: $controllerFile";
                return;
            }

            if (class_exists($class)) {
                error_log("Router: Class $class exists");
                $controller = new $class();
                if (method_exists($controller, $method)) {
                    error_log("Router: Method $method exists, calling it");
                    $controller->$method();
                } else {
                    error_log("Router: Method $method not found in $class");
                    http_response_code(500);
                    echo "Method {$method} not found in {$class}";
                }
            } else {
                error_log("Router: Class $class not found");
                http_response_code(500);
                echo "Controller class {$class} not found";
            }
        } else {
            error_log("Router: Invalid handler format: $handler");
            http_response_code(500);
            echo "Invalid handler format";
        }
    }
}