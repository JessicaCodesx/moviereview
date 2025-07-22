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
    <title><?php echo $config['app_name']; ?><?php echo $currentPath !== '/' ? ' - ' . ucfirst(trim($currentPath, '/')) : ''; ?></title>

    <!-- CRITICAL FIX: Inline styles to make content visible immediately -->
    <style>
        /* Emergency visibility fix */
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

        .header {
            text-align: center !important;
            padding: 60px 20px !important;
            margin-bottom: 40px !important;
            color: white !important;
            opacity: 1 !important;
            visibility: visible !important;
        }

        .header-title {
            font-size: 3.5rem !important;
            font-weight: 900 !important;
            margin-bottom: 20px !important;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3) !important;
            color: white !important;
        }

        .header-subtitle {
            font-size: 1.25rem !important;
            opacity: 0.9 !important;
            margin-bottom: 30px !important;
            color: white !important;
        }

        .header-features {
            display: flex !important;
            justify-content: center !important;
            gap: 30px !important;
            flex-wrap: wrap !important;
        }

        .feature-item {
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
            color: rgba(255,255,255,0.9) !important;
            font-weight: 500 !important;
        }

        .feature-icon {
            font-size: 1.25rem !important;
        }

        .user-menu-toggle {
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
            background: none !important;
            border: none !important;
            cursor: pointer !important;
            padding: 8px !important;
            border-radius: 10px !important;
            color: #374151 !important;
        }

        .user-avatar {
            width: 40px !important;
            height: 40px !important;
            background: linear-gradient(135deg, #6366f1, #ec4899) !important;
            border-radius: 50% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: white !important;
            font-weight: 700 !important;
            font-size: 0.875rem !important;
        }

        .user-name-display {
            font-weight: 600 !important;
            color: #374151 !important;
        }

        .user-dropdown {
            position: absolute !important;
            top: 100% !important;
            right: 0 !important;
            margin-top: 8px !important;
            background: white !important;
            border-radius: 10px !important;
            box-shadow: 0 20px 30px rgba(0,0,0,0.2) !important;
            min-width: 200px !important;
            opacity: 0 !important;
            visibility: hidden !important;
            transform: translateY(-10px) !important;
            transition: all 0.2s ease !important;
            z-index: 1000 !important;
        }

        .user-dropdown.show {
            opacity: 1 !important;
            visibility: visible !important;
            transform: translateY(0) !important;
        }

        .dropdown-item {
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
            padding: 12px 16px !important;
            color: #374151 !important;
            text-decoration: none !important;
            transition: all 0.2s ease !important;
        }

        .dropdown-item:hover {
            background: #f3f4f6 !important;
            color: #6366f1 !important;
        }

        .dropdown-divider {
            height: 1px !important;
            background: #e5e7eb !important;
            margin: 8px 0 !important;
        }

        /* Hide page loader immediately */
        .page-loader,
        #pageLoader {
            display: none !important;
        }

        .mobile-menu-toggle {
            display: none !important;
            flex-direction: column !important;
            gap: 4px !important;
            background: none !important;
            border: none !important;
            cursor: pointer !important;
            padding: 8px !important;
        }

        .hamburger-line {
            width: 24px !important;
            height: 2px !important;
            background: #374151 !important;
            transition: all 0.3s ease !important;
        }

        /* Mobile responsive */
        @media (max-width: 768px) {
            .mobile-menu-toggle {
                display: flex !important;
            }

            .nav-links,
            .user-menu {
                display: none !important;
            }

            .header-title {
                font-size: 2.5rem !important;
            }

            .header-features {
                flex-direction: column !important;
                gap: 15px !important;
            }

            .nav-bar {
                padding: 15px 20px !important;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 15px !important;
            }

            .header {
                padding: 40px 15px !important;
            }

            .header-title {
                font-size: 2rem !important;
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

    <!-- Meta tags for better SEO and social sharing -->
    <meta name="description" content="Discover, rate, and review your favorite movies. Track your watchlist and get personalized recommendations.">
    <meta name="keywords" content="movies, reviews, ratings, watchlist, cinema, films">
    <meta name="author" content="<?php echo $config['app_name']; ?>">

    <!-- Open Graph tags -->
    <meta property="og:title" content="<?php echo $config['app_name']; ?>">
    <meta property="og:description" content="Your ultimate movie discovery and rating platform">
    <meta property="og:type" content="website">
    <meta property="og:image" content="/public/assets/images/og-image.jpg">

    <!-- Twitter Card tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo $config['app_name']; ?>">
    <meta name="twitter:description" content="Discover, rate, and review your favorite movies">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/public/assets/images/favicon.ico">
    <link rel="apple-touch-icon" href="/public/assets/images/apple-touch-icon.png">

    <!-- Theme color for mobile browsers -->
    <meta name="theme-color" content="#6366f1">
    <meta name="msapplication-TileColor" content="#6366f1">
</head>
<body class="loaded">
    <div class="container">
        <?php if (!in_array($currentPath, ['/login', '/register'])): ?>
        <!-- Enhanced Navigation Bar -->
        <nav class="nav-bar" role="navigation" aria-label="Main navigation">
            <div class="nav-brand">
                <a href="/" class="nav-link brand-link" aria-label="Home">
                    <span class="brand-icon">🎬</span>
                    <strong><?php echo $config['app_name']; ?></strong>
                </a>
            </div>

            <div class="nav-links" role="menubar">
                <a href="/" class="nav-link <?php echo $currentPath === '/' ? 'active' : ''; ?>" 
                   role="menuitem" aria-current="<?php echo $currentPath === '/' ? 'page' : 'false'; ?>">
                    <span class="nav-icon">🔍</span>
                    <span class="nav-text">Search</span>
                </a>

                <?php if ($isLoggedIn): ?>
                    <a href="/dashboard" class="nav-link <?php echo strpos($currentPath, '/dashboard') === 0 ? 'active' : ''; ?>" 
                       role="menuitem" aria-current="<?php echo strpos($currentPath, '/dashboard') === 0 ? 'page' : 'false'; ?>">
                        <span class="nav-icon">📊</span>
                        <span class="nav-text">Dashboard</span>
                    </a>
                    <a href="/watchlist" class="nav-link <?php echo strpos($currentPath, '/watchlist') === 0 ? 'active' : ''; ?>" 
                       role="menuitem" aria-current="<?php echo strpos($currentPath, '/watchlist') === 0 ? 'page' : 'false'; ?>">
                        <span class="nav-icon">📝</span>
                        <span class="nav-text">Watchlist</span>
                        <?php if (isset($_SESSION['watchlist_count']) && $_SESSION['watchlist_count'] > 0): ?>
                            <span class="nav-badge" style="background: #ef4444; color: white; font-size: 0.75rem; padding: 2px 6px; border-radius: 999px; margin-left: 8px;"><?php echo $_SESSION['watchlist_count']; ?></span>
                        <?php endif; ?>
                    </a>
                    <a href="/watched" class="nav-link <?php echo strpos($currentPath, '/watched') === 0 ? 'active' : ''; ?>" 
                       role="menuitem" aria-current="<?php echo strpos($currentPath, '/watched') === 0 ? 'page' : 'false'; ?>">
                        <span class="nav-icon">✅</span>
                        <span class="nav-text">Watched</span>
                    </a>
                <?php endif; ?>
            </div>

            <div class="user-menu">
                <?php if ($isLoggedIn): ?>
                    <div class="user-profile" style="position: relative;">
                        <button class="user-menu-toggle" onclick="toggleUserMenu()" aria-expanded="false" aria-haspopup="true">
                            <div class="user-avatar">
                                <span class="user-initial"><?php echo strtoupper(substr($_SESSION['user']['username'], 0, 1)); ?></span>
                            </div>
                            <span class="user-name-display">
                                <?php echo htmlspecialchars($_SESSION['user']['username']); ?>
                            </span>
                            <svg class="user-menu-arrow" width="12" height="8" viewBox="0 0 12 8" fill="none" style="transition: transform 0.2s ease;">
                                <path d="M1 1L6 6L11 1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>

                        <div class="user-dropdown" id="userDropdown">
                            <div class="dropdown-header" style="padding: 16px;">
                                <div class="user-info">
                                    <strong><?php echo htmlspecialchars($_SESSION['user']['username']); ?></strong>
                                    <small style="display: block; opacity: 0.7;">Member since <?php echo date('M Y', strtotime($_SESSION['user']['created_at'])); ?></small>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a href="/profile" class="dropdown-item <?php echo strpos($currentPath, '/profile') === 0 ? 'active' : ''; ?>">
                                <span class="dropdown-icon">👤</span>
                                Profile
                            </a>
                            <a href="/dashboard" class="dropdown-item">
                                <span class="dropdown-icon">📊</span>
                                Dashboard
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="/logout" class="dropdown-item logout-item" onclick="return confirmLogout()" style="color: #dc2626;">
                                <span class="dropdown-icon">🚪</span>
                                Logout
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="auth-buttons">
                        <a href="/login" class="nav-link login-link">
                            <span class="nav-icon">🔑</span>
                            <span class="nav-text">Login</span>
                        </a>
                        <a href="/register" class="btn btn-primary btn-small signup-btn">
                            <span>Sign Up Free</span>
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Mobile menu toggle -->
            <button class="mobile-menu-toggle" onclick="toggleMobileMenu()" aria-label="Toggle mobile menu">
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
            </button>
        </nav>
        <?php endif; ?>

        <!-- Enhanced Header Section -->
        <?php if (in_array($currentPath, ['/', '/dashboard'])): ?>
        <div class="header">
            <div class="header-content">
                <?php if ($currentPath === '/'): ?>
                    <h1 class="header-title">
                        <span class="title-icon">🎬</span>
                        <?php echo $config['app_name']; ?>
                    </h1>
                    <p class="header-subtitle">Discover, Rate & Review Your Favorite Movies</p>
                    <div class="header-features">
                        <div class="feature-item">
                            <span class="feature-icon">🔍</span>
                            <span>Search Movies</span>
                        </div>
                        <div class="feature-item">
                            <span class="feature-icon">⭐</span>
                            <span>Rate & Review</span>
                        </div>
                        <div class="feature-item">
                            <span class="feature-icon">📝</span>
                            <span>Track Watchlist</span>
                        </div>
                    </div>
                <?php elseif ($currentPath === '/dashboard'): ?>
                    <h1 class="header-title">Your Movie Dashboard</h1>
                    <p class="header-subtitle">Track your watchlist, ratings, and discover new favorites</p>
                <?php endif; ?>
            </div>

            <!-- Animated background elements -->
            <div class="header-bg-animation" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; overflow: hidden; z-index: 1;">
                <div class="floating-element floating-element-1" style="position: absolute; top: 20%; left: 10%; font-size: 2rem; opacity: 0.1; animation: float 20s ease-in-out infinite;">🎭</div>
                <div class="floating-element floating-element-2" style="position: absolute; top: 60%; left: 80%; font-size: 2rem; opacity: 0.1; animation: float 20s ease-in-out infinite; animation-delay: 4s;">🍿</div>
                <div class="floating-element floating-element-3" style="position: absolute; top: 40%; left: 70%; font-size: 2rem; opacity: 0.1; animation: float 20s ease-in-out infinite; animation-delay: 8s;">🎪</div>
                <div class="floating-element floating-element-4" style="position: absolute; top: 80%; left: 20%; font-size: 2rem; opacity: 0.1; animation: float 20s ease-in-out infinite; animation-delay: 12s;">🎨</div>
                <div class="floating-element floating-element-5" style="position: absolute; top: 30%; left: 30%; font-size: 2rem; opacity: 0.1; animation: float 20s ease-in-out infinite; animation-delay: 16s;">🎵</div>
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
            const toggle = document.querySelector('.user-menu-toggle');
            const isOpen = dropdown.classList.contains('show');

            if (isOpen) {
                dropdown.classList.remove('show');
                toggle.setAttribute('aria-expanded', 'false');
            } else {
                dropdown.classList.add('show');
                toggle.setAttribute('aria-expanded', 'true');
            }
        }

        function toggleMobileMenu() {
            alert('Mobile menu feature - coming soon!');
        }

        function confirmLogout() {
            return confirm('Are you sure you want to logout?');
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', (e) => {
            const userMenu = document.querySelector('.user-profile');
            const dropdown = document.getElementById('userDropdown');

            if (userMenu && dropdown && !userMenu.contains(e.target)) {
                dropdown.classList.remove('show');
                document.querySelector('.user-menu-toggle').setAttribute('aria-expanded', 'false');
            }
        });

        // Show that app is working
        console.log('🎬 Movie Review Hub - Header loaded and working!');
        console.log('Auth state:', window.authState);

        // Add floating animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes float {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                25% { transform: translateY(-20px) rotate(5deg); }
                50% { transform: translateY(-10px) rotate(-5deg); }
                75% { transform: translateY(-30px) rotate(3deg); }
            }
        `;
        document.head.appendChild(style);
        </script>