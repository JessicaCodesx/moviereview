
namespace Controllers;

abstract class BaseController {
    protected function jsonResponse($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    protected function view($viewPath, $data = []) {
        extract($data);

        // Start output buffering
        ob_start();

        // Include the view file
        $viewFile = APP_PATH . '/views/' . $viewPath . '.php';
        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            throw new \Exception("View file not found: {$viewFile}");
        }

        // Get the content
        $content = ob_get_clean();

        // Include layout if it's not an AJAX request
        if (!$this->isAjaxRequest()) {
            include APP_PATH . '/views/layout/header.php';
            echo $content;
            include APP_PATH . '/views/layout/footer.php';
        } else {
            echo $content;
        }
    }

    protected function isAjaxRequest() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    protected function getUserIP() {
        return $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    }
}
