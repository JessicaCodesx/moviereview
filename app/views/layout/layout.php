<?php
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

    <!-- Meta tags -->
    <meta name="description" content="Discover, rate, and review your favorite movies.">
    <link rel="icon" type="image/x-icon" href="/public/assets/images/favicon.ico">
    <meta name="theme-color" content="#6366f1">

    <!-- CSS -->
    <link rel="stylesheet" href="/public/css/style.css">

    <!-- Simple critical CSS -->
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            background-attachment: fixed;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            color: white;
            line-height: 1.6;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        @media (max-width: 768px) {
            .container { padding: 16px; }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <?php
    $isAuthPage = in_array($currentPath, ['/login', '/register']);
    if (!$isAuthPage) {
        echo '<div class="container">';
    }

    if ($isLoggedIn) {
        include APP_PATH . '/views/layout/header.php';
    } else {
        include APP_PATH . '/views/layout/publicheader.php';
    }

    if (!$isAuthPage) {
        echo '</div>';
    }
    ?>

    <!-- Main Content -->
    <main>
        <?php if (!$isAuthPage): ?>
            <div class="container">
                <?php echo $content; ?>
            </div>
        <?php else: ?>
            <?php echo $content; ?>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <div class="container">
        <?php include APP_PATH . '/views/layout/footer.php'; ?>
    </div>

    <!-- Minimal JavaScript -->
    <script>
        // Simple mobile menu toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            if (menu) {
                menu.classList.toggle('active');
            }
        }

        // Simple search function
        function performSearch() {
            const input = document.getElementById('headerSearchInput') || document.getElementById('mobileSearchInput');
            if (input && input.value.trim()) {
                console.log('Search:', input.value.trim());
                // Add your search logic here
            }
        }

        function handleSearchKeypress(event) {
            if (event.key === 'Enter') {
                performSearch();
            }
        }

        function performMobileSearch() {
            performSearch();
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('mobileMenu');
            const toggle = document.querySelector('.mobile-toggle');

            if (menu && toggle && 
                !menu.contains(event.target) && 
                !toggle.contains(event.target)) {
                menu.classList.remove('active');
            }
        });
    </script>
</body>
</html>