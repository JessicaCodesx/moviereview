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

    private function addRoute($method, $path, $handler) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }

    public function dispatch() {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestPath = $this->getCurrentPath();

        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && $this->matchPath($route['path'], $requestPath)) {
                $this->callHandler($route['handler']);
                return;
            }
        }

        // No route found
        http_response_code(404);
        echo "Page not found";
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

            $controller = new $class();
            $controller->$method();
        }
    }
}