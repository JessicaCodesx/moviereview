<?php
// Main layout file for all pages
if (!isset($config)) {
    $config = require CONFIG_PATH . '/app.php';
}
if (!isset($currentPath)) {
    $currentPath = $_SERVER['REQUEST_URI'] ?? '/';
}
$isLoggedIn = isset($_SESSION['user']) && !empty($_SESSION['user']['id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $config['app_name']; ?><?php echo isset($page_title) ? ' - ' . htmlspecialchars($page_title) : ($currentPath !== '/' ? ' - ' . ucfirst(trim($currentPath, '/')) : ''); ?></title>
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="icon" type="image/x-icon" href="/public/assets/images/favicon.ico">
    <meta name="theme-color" content="#6366f1">
    <!-- Additional meta tags can be added here -->
</head>
<body class="loaded">
    <?php
    // Include the correct header
    if ($isLoggedIn) {
        include APP_PATH . '/views/layout/header.php';
    } else {
        include APP_PATH . '/views/layout/publicheader.php';
    }
    ?>
    <main>
        <?php echo $content; ?>
    </main>
    <?php include APP_PATH . '/views/layout/footer.php'; ?>
</body>
</html> 