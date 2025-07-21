<?php

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
    }

    public function dispatch() {
        $requestMethod = $this->getRequestMethod();
        $requestPath = $this->getCurrentPath();

        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && $this->matchPath($route['path'], $requestPath)) {
                $this->callHandler($route['handler']);
                return;
            }
        }

        // No route found
        http_response_code(404);

        // Check if it's an AJAX request
        $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Route not found']);
        } else {
            echo "Page not found";
        }
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
        return $path;
    }

    private function matchPath($routePath, $requestPath) {
        return $routePath === $requestPath;
    }

    private function callHandler($handler) {
        if (is_string($handler) && strpos($handler, '@') !== false) {
            list($class, $method) = explode('@', $handler);

            // Load controller file
            $controllerFile = APP_PATH . '/' . strtolower(str_replace('\\', '/', $class)) . '.php';
            if (file_exists($controllerFile)) {
                require_once $controllerFile;
            }

            if (class_exists($class)) {
                $controller = new $class();
                if (method_exists($controller, $method)) {
                    $controller->$method();
                } else {
                    http_response_code(500);
                    echo "Method {$method} not found in {$class}";
                }
            } else {
                http_response_code(500);
                echo "Controller class {$class} not found";
            }
        }
    }
}