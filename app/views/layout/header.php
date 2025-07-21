<?php
$config = require CONFIG_PATH . '/app.php';
$isLoggedIn = isset($_SESSION['user']) && !empty($_SESSION['user']['id']);
$currentPath = $_SERVER['REQUEST_URI'] ?? '/';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $config['app_name']; ?></title>
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <?php if (!in_array($currentPath, ['/login', '/register'])): ?>
        <!-- Navigation Bar -->
        <nav class="nav-bar">
            <div class="nav-brand">
                <a href="/" class="nav-link">
                    <strong>🎬 <?php echo $config['app_name']; ?></strong>
                </a>
            </div>

            <div class="nav-links">
                <a href="/" class="nav-link <?php echo $currentPath === '/' ? 'active' : ''; ?>">
                    🔍 Search
                </a>

                <?php if ($isLoggedIn): ?>
                    <a href="/dashboard" class="nav-link <?php echo strpos($currentPath, '/dashboard') === 0 ? 'active' : ''; ?>">
                        📊 Dashboard
                    </a>
                    <a href="/watchlist" class="nav-link <?php echo strpos($currentPath, '/watchlist') === 0 ? 'active' : ''; ?>">
                        📝 Watchlist
                    </a>
                    <a href="/watched" class="nav-link <?php echo strpos($currentPath, '/watched') === 0 ? 'active' : ''; ?>">
                        ✅ Watched
                    </a>
                <?php endif; ?>
            </div>

            <div class="user-menu">
                <?php if ($isLoggedIn): ?>
                    <span class="user-name">
                        👋 <?php echo htmlspecialchars($_SESSION['user']['username']); ?>
                    </span>
                    <a href="/profile" class="nav-link <?php echo strpos($currentPath, '/profile') === 0 ? 'active' : ''; ?>">
                        Profile
                    </a>
                    <a href="/logout" class="btn btn-secondary btn-small" onclick="return confirmLogout()">
                        Logout
                    </a>
                <?php else: ?>
                    <a href="/login" class="nav-link">
                        Login
                    </a>
                    <a href="/register" class="btn btn-primary btn-small">
                        Sign Up
                    </a>
                <?php endif; ?>
            </div>
        </nav>
        <?php endif; ?>

        <!-- Header Section (only show on main pages) -->
        <?php if (in_array($currentPath, ['/', '/dashboard'])): ?>
        <div class="header">
            <?php if ($currentPath === '/'): ?>
                <h1>🎬 <?php echo $config['app_name']; ?></h1>
                <p>Search, Rate & Review Your Favorite Movies</p>
            <?php elseif ($currentPath === '/dashboard'): ?>
                <h1>Your Movie Dashboard</h1>
                <p>Track your watchlist, ratings, and discover new favorites</p>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <script>
        // Global auth state management
        window.authState = {
            isLoggedIn: <?php echo $isLoggedIn ? 'true' : 'false'; ?>,
            user: <?php echo $isLoggedIn ? json_encode($_SESSION['user']) : 'null'; ?>
        };

        function confirmLogout() {
            return confirm('Are you sure you want to logout?');
        }

        // Check auth status periodically (useful for session timeouts)
        if (window.authState.isLoggedIn) {
            setInterval(async () => {
                try {
                    const response = await fetch('/api/auth/check');
                    const data = await response.json();

                    if (!data.logged_in && window.authState.isLoggedIn) {
                        // Session expired
                        alert('Your session has expired. Please login again.');
                        window.location.href = '/login';
                    }
                } catch (error) {
                    // Ignore network errors
                }
            }, 300000); // Check every 5 minutes
        }
        </script>