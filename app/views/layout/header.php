<?php
$config = require CONFIG_PATH . '/app.php';
$isLoggedIn = isset($_SESSION['user']) && !empty($_SESSION['user']['id']);
$currentPath = $_SERVER['REQUEST_URI'] ?? '/';
$isAuthPage = in_array($currentPath, ['/login', '/register']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $config['app_name']; ?><?php echo $currentPath !== '/' ? ' - ' . ucfirst(trim($currentPath, '/')) : ''; ?></title>

    <!-- Critical styles for immediate visibility -->
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%) !important;
            background-attachment: fixed !important;
            min-height: 100vh !important;
            margin: 0 !important;
            padding: 0 !important;
            color: white !important;
            opacity: 1 !important;
            visibility: visible !important;
        }

        .container {
            max-width: 1400px !important;
            margin: 0 auto !important;
            padding: 20px !important;
            opacity: 1 !important;
            visibility: visible !important;
        }

        .nav-bar {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(20px) !important;
            border-radius: 20px !important;
            padding: 15px 25px !important;
            margin-bottom: 30px !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2) !important;
            color: #333 !important;
            opacity: 1 !important;
            visibility: visible !important;
            position: sticky !important;
            top: 20px !important;
            z-index: 1000 !important;
        }

        .nav-bar.auth-page {
            background: rgba(255, 255, 255, 0.1) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            color: white !important;
        }

        .nav-bar.auth-page .nav-link,
        .nav-bar.auth-page .user-name-display {
            color: rgba(255, 255, 255, 0.9) !important;
        }

        .nav-bar.auth-page .nav-link:hover {
            background: rgba(255, 255, 255, 0.1) !important;
            color: white !important;
        }

        .nav-brand a {
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
            text-decoration: none !important;
            color: #6366f1 !important;
            font-size: 1.25rem !important;
            font-weight: 800 !important;
        }

        .nav-bar.auth-page .nav-brand a {
            color: white !important;
        }

        .brand-icon {
            font-size: 1.5rem !important;
        }

        .nav-links {
            display: flex !important;
            gap: 10px !important;
            align-items: center !important;
        }

        .nav-link {
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
            padding: 10px 15px !important;
            border-radius: 10px !important;
            text-decoration: none !important;
            color: #374151 !important;
            font-weight: 500 !important;
            transition: all 0.2s ease !important;
        }

        .nav-link:hover,
        .nav-link.active {
            background: #6366f1 !important;
            color: white !important;
        }

        .nav-bar.auth-page .nav-link:hover,
        .nav-bar.auth-page .nav-link.active {
            background: rgba(255, 255, 255, 0.2) !important;
            color: white !important;
        }

        .nav-icon {
            font-size: 1.1rem !important;
        }

        .user-menu {
            display: flex !important;
            align-items: center !important;
            gap: 15px !important;
        }

        .auth-buttons {
            display: flex !important;
            gap: 10px !important;
            align-items: center !important;
        }

        .btn {
            display: inline-flex !important;
            align-items: center !important;
            padding: 10px 20px !important;
            border-radius: 10px !important;
            text-decoration: none !important;
            font-weight: 600 !important;
            border: none !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
        }

        .btn-primary {
            background: #6366f1 !important;
            color: white !important;
        }

        .btn-primary:hover {
            background: #4f46e5 !important;
            transform: translateY(-2px) !important;
        }

        .btn-small {
            padding: 8px 16px !important;
            font-size: 0.9rem !important;
        }

        .auth-page-indicator {
            background: rgba(255, 255, 255, 0.1) !important;
            padding: 8px 16px !important;
            border-radius: 20px !important;
            font-size: 0.875rem !important;
            color: rgba(255, 255, 255, 0.8) !important;
        }

        /* Mobile responsive */
        @media (max-width: 768px) {
            .nav-bar {
                padding: 15px 20px !important;
                flex-wrap: wrap !important;
                gap: 10px !important;
            }

            .nav-links {
                display: none !important;
            }

            .mobile-nav-toggle {
                display: block !important;
                background: none !important;
                border: none !important;
                color: inherit !important;
                font-size: 1.25rem !important;
                cursor: pointer !important;
            }

            .container {
                padding: 15px !important;
            }
        }

        @media (max-width: 480px) {
            .nav-brand a {
                font-size: 1.1rem !important;
            }

            .brand-icon {
                font-size: 1.25rem !important;
            }
        }
    </style>

    <!-- Preload critical resources -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="/public/css/style.css">

    <!-- Meta tags -->
    <meta name="description" content="Discover, rate, and review your favorite movies. Track your watchlist and get personalized recommendations.">
    <meta name="keywords" content="movies, reviews, ratings, watchlist, cinema, films">
    <meta name="author" content="<?php echo $config['app_name']; ?>">

    <!-- Open Graph tags -->
    <meta property="og:title" content="<?php echo $config['app_name']; ?>">
    <meta property="og:description" content="Your ultimate movie discovery and rating platform">
    <meta property="og:type" content="website">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/public/assets/images/favicon.ico">

    <!-- Theme color -->
    <meta name="theme-color" content="#6366f1">
</head>
<body class="loaded">
    <div class="container">
        <!-- Always-visible Navigation Bar -->
        <nav class="nav-bar <?php echo $isAuthPage ? 'auth-page' : ''; ?>" role="navigation" aria-label="Main navigation">
            <div class="nav-brand">
                <a href="/" class="nav-link brand-link" aria-label="Home">
                    <span class="brand-icon">🎬</span>
                    <strong><?php echo $config['app_name']; ?></strong>
                </a>
            </div>

            <div class="nav-links" role="menubar">
                <?php if (!$isAuthPage): ?>
                    <a href="/" class="nav-link <?php echo $currentPath === '/' ? 'active' : ''; ?>" 
                       role="menuitem">
                        <span class="nav-icon">🔍</span>
                        <span class="nav-text">Search</span>
                    </a>

                    <?php if ($isLoggedIn): ?>
                        <a href="/dashboard" class="nav-link <?php echo strpos($currentPath, '/dashboard') === 0 ? 'active' : ''; ?>" 
                           role="menuitem">
                            <span class="nav-icon">📊</span>
                            <span class="nav-text">Dashboard</span>
                        </a>
                        <a href="/watchlist" class="nav-link <?php echo strpos($currentPath, '/watchlist') === 0 ? 'active' : ''; ?>" 
                           role="menuitem">
                            <span class="nav-icon">📝</span>
                            <span class="nav-text">Watchlist</span>
                        </a>
                        <a href="/watched" class="nav-link <?php echo strpos($currentPath, '/watched') === 0 ? 'active' : ''; ?>" 
                           role="menuitem">
                            <span class="nav-icon">✅</span>
                            <span class="nav-text">Watched</span>
                        </a>
                    <?php endif; ?>
                <?php else: ?>
                    <!-- Show simplified nav for auth pages -->
                    <div class="auth-page-indicator">
                        <?php echo $currentPath === '/login' ? 'Sign In' : 'Create Account'; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="user-menu">
                <?php if ($isLoggedIn && !$isAuthPage): ?>
                    <div class="user-profile" style="position: relative;">
                        <button class="user-menu-toggle" onclick="toggleUserMenu()" aria-expanded="false" aria-haspopup="true"
                                style="display: flex; align-items: center; gap: 10px; background: none; border: none; cursor: pointer; padding: 8px; border-radius: 10px; color: inherit;">
                            <div class="user-avatar" style="width: 40px; height: 40px; background: linear-gradient(135deg, #6366f1, #ec4899); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.875rem;">
                                <span class="user-initial"><?php echo strtoupper(substr($_SESSION['user']['username'], 0, 1)); ?></span>
                            </div>
                            <span class="user-name-display" style="font-weight: 600;">
                                <?php echo htmlspecialchars($_SESSION['user']['username']); ?>
                            </span>
                        </button>

                        <div class="user-dropdown" id="userDropdown" style="position: absolute; top: 100%; right: 0; margin-top: 8px; background: white; border-radius: 10px; box-shadow: 0 20px 30px rgba(0,0,0,0.2); min-width: 200px; opacity: 0; visibility: hidden; transform: translateY(-10px); transition: all 0.2s ease; z-index: 1000;">
                            <div class="dropdown-header" style="padding: 16px; border-bottom: 1px solid #e5e7eb;">
                                <div class="user-info">
                                    <strong style="color: #374151;"><?php echo htmlspecialchars($_SESSION['user']['username']); ?></strong>
                                    <small style="display: block; opacity: 0.7; color: #6b7280;">Member since <?php echo date('M Y', strtotime($_SESSION['user']['created_at'])); ?></small>
                                </div>
                            </div>
                            <a href="/profile" class="dropdown-item" style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; color: #374151; text-decoration: none; transition: all 0.2s ease;">
                                <span class="dropdown-icon">👤</span>
                                Profile
                            </a>
                            <a href="/dashboard" class="dropdown-item" style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; color: #374151; text-decoration: none; transition: all 0.2s ease;">
                                <span class="dropdown-icon">📊</span>
                                Dashboard
                            </a>
                            <div style="height: 1px; background: #e5e7eb; margin: 8px 0;"></div>
                            <a href="/logout" class="dropdown-item logout-item" onclick="return confirmLogout()" style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; color: #dc2626; text-decoration: none; transition: all 0.2s ease;">
                                <span class="dropdown-icon">🚪</span>
                                Logout
                            </a>
                        </div>
                    </div>
                <?php elseif (!$isLoggedIn): ?>
                    <div class="auth-buttons">
                        <?php if ($currentPath !== '/login'): ?>
                            <a href="/login" class="nav-link login-link">
                                <span class="nav-icon">🔑</span>
                                <span class="nav-text">Login</span>
                            </a>
                        <?php endif; ?>
                        <?php if ($currentPath !== '/register'): ?>
                            <a href="/register" class="btn btn-primary btn-small signup-btn">
                                <span>Sign Up Free</span>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Mobile menu toggle -->
                <button class="mobile-nav-toggle" onclick="toggleMobileMenu()" aria-label="Toggle mobile menu" style="display: none;">
                    <span>☰</span>
                </button>
            </div>
        </nav>

        <!-- Enhanced Header Section for non-auth pages -->
        <?php if (!$isAuthPage && in_array($currentPath, ['/', '/dashboard'])): ?>
        <div class="header" style="text-align: center; padding: 60px 20px; margin-bottom: 40px;">
            <div class="header-content">
                <?php if ($currentPath === '/'): ?>
                    <h1 style="font-size: 3.5rem; font-weight: 900; margin-bottom: 20px; text-shadow: 2px 2px 4px rgba(0,0,0,0.3); color: white;">
                        <span style="font-size: 1.2em;">🎬</span>
                        <?php echo $config['app_name']; ?>
                    </h1>
                    <p style="font-size: 1.25rem; opacity: 0.9; margin-bottom: 30px; color: white;">Discover, Rate & Review Your Favorite Movies</p>
                    <div style="display: flex; justify-content: center; gap: 30px; flex-wrap: wrap;">
                        <div style="display: flex; align-items: center; gap: 8px; color: rgba(255,255,255,0.9); font-weight: 500;">
                            <span style="font-size: 1.25rem;">🔍</span>
                            <span>Search Movies</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px; color: rgba(255,255,255,0.9); font-weight: 500;">
                            <span style="font-size: 1.25rem;">⭐</span>
                            <span>Rate & Review</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px; color: rgba(255,255,255,0.9); font-weight: 500;">
                            <span style="font-size: 1.25rem;">📝</span>
                            <span>Track Watchlist</span>
                        </div>
                    </div>
                <?php elseif ($currentPath === '/dashboard'): ?>
                    <h1 style="font-size: 3.5rem; font-weight: 900; margin-bottom: 20px; text-shadow: 2px 2px 4px rgba(0,0,0,0.3); color: white;">Your Movie Dashboard</h1>
                    <p style="font-size: 1.25rem; opacity: 0.9; color: white;">Track your watchlist, ratings, and discover new favorites</p>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <script>
        // Global auth state management
        window.authState = {
            isLoggedIn: <?php echo $isLoggedIn ? 'true' : 'false'; ?>,
            user: <?php echo $isLoggedIn ? json_encode($_SESSION['user']) : 'null'; ?>
        };

        // Enhanced UI functionality
        function toggleUserMenu() {
            const dropdown = document.getElementById('userDropdown');
            const isOpen = dropdown.style.opacity === '1';

            if (isOpen) {
                dropdown.style.opacity = '0';
                dropdown.style.visibility = 'hidden';
                dropdown.style.transform = 'translateY(-10px)';
            } else {
                dropdown.style.opacity = '1';
                dropdown.style.visibility = 'visible';
                dropdown.style.transform = 'translateY(0)';
            }
        }

        function toggleMobileMenu() {
            // Simple mobile menu toggle - could be enhanced
            const navLinks = document.querySelector('.nav-links');
            if (navLinks) {
                navLinks.style.display = navLinks.style.display === 'flex' ? 'none' : 'flex';
            }
        }

        function confirmLogout() {
            return confirm('Are you sure you want to logout?');
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', (e) => {
            const userMenu = document.querySelector('.user-profile');
            const dropdown = document.getElementById('userDropdown');

            if (userMenu && dropdown && !userMenu.contains(e.target)) {
                dropdown.style.opacity = '0';
                dropdown.style.visibility = 'hidden';
                dropdown.style.transform = 'translateY(-10px)';
            }
        });

        // Add hover effects to dropdown items
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.dropdown-item').forEach(item => {
                item.addEventListener('mouseenter', () => {
                    item.style.background = '#f3f4f6';
                });
                item.addEventListener('mouseleave', () => {
                    item.style.background = 'transparent';
                });
            });
        });

        console.log('🎬 Movie Review Hub - Header loaded successfully!');
        console.log('Auth state:', window.authState);
        console.log('Current path:', '<?php echo $currentPath; ?>');
        </script>