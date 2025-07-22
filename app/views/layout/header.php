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

        /* Base Header Styles */
        .header-nav {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(20px) saturate(180%) !important;
            border-radius: 20px !important;
            padding: 15px 30px !important;
            margin-bottom: 30px !important;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
            color: #333 !important;
            opacity: 1 !important;
            visibility: visible !important;
            position: sticky !important;
            top: 20px !important;
            z-index: 1000 !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
        }

        .header-nav.auth-page {
            background: rgba(255, 255, 255, 0.1) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            color: white !important;
        }

        /* Brand Section */
        .nav-brand {
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
        }

        .nav-brand a {
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
            text-decoration: none !important;
            color: #6366f1 !important;
            font-size: 1.5rem !important;
            font-weight: 900 !important;
            transition: all 0.3s ease !important;
        }

        .header-nav.auth-page .nav-brand a {
            color: white !important;
        }

        .nav-brand a:hover {
            transform: scale(1.05) !important;
            text-shadow: 0 4px 8px rgba(99, 102, 241, 0.3) !important;
        }

        .brand-icon {
            font-size: 1.75rem !important;
            animation: float 3s ease-in-out infinite !important;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-4px); }
        }

        /* Navigation Links */
        .nav-links {
            display: flex !important;
            gap: 8px !important;
            align-items: center !important;
        }

        .nav-link {
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
            padding: 12px 18px !important;
            border-radius: 12px !important;
            text-decoration: none !important;
            color: #374151 !important;
            font-weight: 600 !important;
            font-size: 0.95rem !important;
            transition: all 0.3s ease !important;
            position: relative !important;
            overflow: hidden !important;
        }

        .nav-link::before {
            content: '' !important;
            position: absolute !important;
            top: 0 !important;
            left: -100% !important;
            width: 100% !important;
            height: 100% !important;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent) !important;
            transition: left 0.5s ease !important;
        }

        .nav-link:hover::before {
            left: 100% !important;
        }

        .nav-link:hover,
        .nav-link.active {
            background: linear-gradient(135deg, #6366f1, #ec4899) !important;
            color: white !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.3) !important;
        }

        .header-nav.auth-page .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
        }

        .header-nav.auth-page .nav-link:hover,
        .header-nav.auth-page .nav-link.active {
            background: rgba(255, 255, 255, 0.2) !important;
            color: white !important;
        }

        .nav-icon {
            font-size: 1.1rem !important;
        }

        /* User Menu */
        .user-menu {
            display: flex !important;
            align-items: center !important;
            gap: 15px !important;
        }

        .user-profile {
            position: relative !important;
        }

        .user-menu-toggle {
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
            background: none !important;
            border: none !important;
            cursor: pointer !important;
            padding: 8px 16px !important;
            border-radius: 12px !important;
            color: inherit !important;
            transition: all 0.3s ease !important;
        }

        .user-menu-toggle:hover {
            background: rgba(99, 102, 241, 0.1) !important;
            transform: translateY(-2px) !important;
        }

        .user-avatar {
            width: 45px !important;
            height: 45px !important;
            background: linear-gradient(135deg, #6366f1, #ec4899) !important;
            border-radius: 50% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: white !important;
            font-weight: 800 !important;
            font-size: 1rem !important;
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.3) !important;
        }

        .user-name-display {
            font-weight: 700 !important;
            font-size: 1rem !important;
        }

        /* Search Bar */
        .header-search {
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
            background: rgba(255, 255, 255, 0.9) !important;
            border: 2px solid transparent !important;
            border-radius: 25px !important;
            padding: 8px 16px !important;
            min-width: 300px !important;
            transition: all 0.3s ease !important;
        }

        .header-search:focus-within {
            background: white !important;
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1) !important;
            transform: translateY(-2px) !important;
        }

        .header-search input {
            background: none !important;
            border: none !important;
            outline: none !important;
            flex: 1 !important;
            font-size: 0.95rem !important;
            color: #374151 !important;
        }

        .header-search input::placeholder {
            color: #9ca3af !important;
        }

        .search-btn {
            background: linear-gradient(135deg, #6366f1, #ec4899) !important;
            border: none !important;
            border-radius: 50% !important;
            width: 35px !important;
            height: 35px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: white !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
        }

        .search-btn:hover {
            transform: scale(1.1) !important;
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4) !important;
        }

        /* Auth Buttons */
        .auth-buttons {
            display: flex !important;
            gap: 12px !important;
            align-items: center !important;
        }

        .btn {
            display: inline-flex !important;
            align-items: center !important;
            gap: 8px !important;
            padding: 12px 24px !important;
            border-radius: 12px !important;
            text-decoration: none !important;
            font-weight: 700 !important;
            border: none !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            font-size: 0.95rem !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, #6366f1, #ec4899) !important;
            color: white !important;
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.9) !important;
            color: #374151 !important;
            border: 2px solid rgba(99, 102, 241, 0.2) !important;
        }

        .btn:hover {
            transform: translateY(-3px) !important;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2) !important;
        }

        .btn-primary:hover {
            box-shadow: 0 15px 35px rgba(99, 102, 241, 0.4) !important;
        }

        /* Dropdown */
        .user-dropdown {
            position: absolute !important;
            top: 100% !important;
            right: 0 !important;
            margin-top: 12px !important;
            background: white !important;
            border-radius: 16px !important;
            box-shadow: 0 25px 50px rgba(0,0,0,0.15) !important;
            border: 1px solid rgba(0,0,0,0.05) !important;
            min-width: 220px !important;
            opacity: 0 !important;
            visibility: hidden !important;
            transform: translateY(-10px) scale(0.95) !important;
            transition: all 0.3s ease !important;
            z-index: 1000 !important;
            backdrop-filter: blur(20px) !important;
        }

        .user-dropdown.show {
            opacity: 1 !important;
            visibility: visible !important;
            transform: translateY(0) scale(1) !important;
        }

        .dropdown-header {
            padding: 20px !important;
            border-bottom: 1px solid #f3f4f6 !important;
            text-align: center !important;
        }

        .dropdown-item {
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
            padding: 14px 20px !important;
            color: #374151 !important;
            text-decoration: none !important;
            transition: all 0.2s ease !important;
            font-weight: 500 !important;
        }

        .dropdown-item:hover {
            background: linear-gradient(135deg, #f8fafc, #f1f5f9) !important;
            color: #6366f1 !important;
            transform: translateX(4px) !important;
        }

        .dropdown-item.danger:hover {
            background: #fef2f2 !important;
            color: #ef4444 !important;
        }

        /* Mobile Menu */
        .mobile-menu-toggle {
            display: none !important;
            flex-direction: column !important;
            gap: 4px !important;
            background: none !important;
            border: none !important;
            cursor: pointer !important;
            padding: 8px !important;
            border-radius: 8px !important;
            transition: all 0.3s ease !important;
        }

        .mobile-menu-toggle:hover {
            background: rgba(99, 102, 241, 0.1) !important;
        }

        .hamburger-line {
            width: 25px !important;
            height: 3px !important;
            background: #374151 !important;
            border-radius: 2px !important;
            transition: all 0.3s ease !important;
        }

        .header-nav.auth-page .hamburger-line {
            background: white !important;
        }

        .mobile-menu-toggle.active .hamburger-line:nth-child(1) {
            transform: rotate(45deg) translate(6px, 6px) !important;
        }

        .mobile-menu-toggle.active .hamburger-line:nth-child(2) {
            opacity: 0 !important;
        }

        .mobile-menu-toggle.active .hamburger-line:nth-child(3) {
            transform: rotate(-45deg) translate(6px, -6px) !important;
        }

        .mobile-nav {
            display: none !important;
            position: absolute !important;
            top: 100% !important;
            left: 0 !important;
            right: 0 !important;
            background: white !important;
            border-radius: 16px !important;
            margin-top: 8px !important;
            padding: 20px !important;
            box-shadow: 0 25px 50px rgba(0,0,0,0.15) !important;
            backdrop-filter: blur(20px) !important;
        }

        .mobile-nav.show {
            display: block !important;
        }

        .mobile-nav .nav-link {
            width: 100% !important;
            justify-content: flex-start !important;
            margin-bottom: 8px !important;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .header-search {
                min-width: 250px !important;
            }

            .container {
                padding: 15px !important;
            }
        }

        @media (max-width: 768px) {
            .header-nav {
                padding: 12px 20px !important;
                position: relative !important;
            }

            .nav-links {
                display: none !important;
            }

            .header-search {
                display: none !important;
            }

            .mobile-menu-toggle {
                display: flex !important;
            }

            .user-menu {
                gap: 10px !important;
            }

            .nav-brand a {
                font-size: 1.25rem !important;
            }

            .brand-icon {
                font-size: 1.5rem !important;
            }

            .mobile-nav .header-search {
                display: flex !important;
                min-width: auto !important;
                width: 100% !important;
                margin-bottom: 15px !important;
            }
        }

        @media (max-width: 480px) {
            .header-nav {
                padding: 10px 15px !important;
            }

            .nav-brand a {
                font-size: 1.1rem !important;
            }

            .brand-icon {
                font-size: 1.3rem !important;
            }

            .user-avatar {
                width: 40px !important;
                height: 40px !important;
                font-size: 0.9rem !important;
            }

            .btn {
                padding: 10px 16px !important;
                font-size: 0.875rem !important;
            }

            .auth-buttons {
                gap: 8px !important;
            }
        }
    </style>

    <!-- Preload critical resources -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/style.css">

    <!-- Meta tags -->
    <meta name="description" content="Discover, rate, and review your favorite movies. Track your watchlist and get personalized recommendations.">
    <meta name="keywords" content="movies, reviews, ratings, watchlist, cinema, films">
    <meta name="author" content="<?php echo $config['app_name']; ?>">
    <meta property="og:title" content="<?php echo $config['app_name']; ?>">
    <meta property="og:description" content="Your ultimate movie discovery and rating platform">
    <meta property="og:type" content="website">
    <link rel="icon" type="image/x-icon" href="/public/assets/images/favicon.ico">
    <meta name="theme-color" content="#6366f1">
</head>
<body class="loaded">
    <div class="container">
        <!-- Enhanced Navigation Header -->
        <nav class="header-nav <?php echo $isAuthPage ? 'auth-page' : ''; ?>" role="navigation" aria-label="Main navigation">
            <!-- Brand -->
            <div class="nav-brand">
                <a href="/" aria-label="Movie Review Hub - Home">
                    <span class="brand-icon">🎬</span>
                    <strong><?php echo $config['app_name']; ?></strong>
                </a>
            </div>

            <?php if ($isLoggedIn && !$isAuthPage): ?>
                <!-- AUTHENTICATED USER HEADER -->

                <!-- Search Bar -->
                <div class="header-search">
                    <input type="text" id="headerSearchInput" placeholder="Search movies..." 
                           onkeypress="if(event.key==='Enter') headerSearchMovies()">
                    <button class="search-btn" onclick="headerSearchMovies()" aria-label="Search">
                        <span class="nav-icon">🔍</span>
                    </button>
                </div>

                <!-- Navigation Links -->
                <div class="nav-links" role="menubar">
                    <a href="/dashboard" class="nav-link <?php echo strpos($currentPath, '/dashboard') === 0 ? 'active' : ''; ?>" role="menuitem">
                        <span class="nav-icon">📊</span>
                        <span>Dashboard</span>
                    </a>
                    <a href="/watchlist" class="nav-link <?php echo strpos($currentPath, '/watchlist') === 0 ? 'active' : ''; ?>" role="menuitem">
                        <span class="nav-icon">📝</span>
                        <span>Watchlist</span>
                    </a>
                    <a href="/watched" class="nav-link <?php echo strpos($currentPath, '/watched') === 0 ? 'active' : ''; ?>" role="menuitem">
                        <span class="nav-icon">✅</span>
                        <span>Watched</span>
                    </a>
                    <a href="/profile" class="nav-link <?php echo strpos($currentPath, '/profile') === 0 ? 'active' : ''; ?>" role="menuitem">
                        <span class="nav-icon">👤</span>
                        <span>Profile</span>
                    </a>
                </div>

                <!-- User Menu -->
                <div class="user-menu">
                    <div class="user-profile">
                        <button class="user-menu-toggle" onclick="toggleUserMenu()" aria-expanded="false" aria-haspopup="true">
                            <div class="user-avatar">
                                <span><?php echo strtoupper(substr($_SESSION['user']['username'], 0, 1)); ?></span>
                            </div>
                            <span class="user-name-display"><?php echo htmlspecialchars($_SESSION['user']['username']); ?></span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="6,9 12,15 18,9"></polyline>
                            </svg>
                        </button>

                        <div class="user-dropdown" id="userDropdown">
                            <div class="dropdown-header">
                                <strong><?php echo htmlspecialchars($_SESSION['user']['username']); ?></strong>
                                <small style="display: block; opacity: 0.7; color: #6b7280; margin-top: 4px;">
                                    Member since <?php echo date('M Y', strtotime($_SESSION['user']['created_at'])); ?>
                                </small>
                            </div>
                            <a href="/profile" class="dropdown-item">
                                <span>👤</span>My Profile
                            </a>
                            <a href="/dashboard" class="dropdown-item">
                                <span>📊</span>Dashboard
                            </a>
                            <a href="/watchlist" class="dropdown-item">
                                <span>📝</span>My Watchlist
                            </a>
                            <a href="/watched" class="dropdown-item">
                                <span>✅</span>Watched Movies
                            </a>
                            <div style="height: 1px; background: #e5e7eb; margin: 8px 0;"></div>
                            <a href="/logout" class="dropdown-item danger" onclick="return confirmLogout()">
                                <span>🚪</span>Sign Out
                            </a>
                        </div>
                    </div>

                    <button class="mobile-menu-toggle" onclick="toggleMobileMenu()" aria-label="Toggle mobile menu">
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                    </button>
                </div>

            <?php elseif (!$isLoggedIn && !$isAuthPage): ?>
                <!-- PUBLIC USER HEADER -->

                <!-- Search Bar -->
                <div class="header-search">
                    <input type="text" id="headerSearchInput" placeholder="Search movies..." 
                           onkeypress="if(event.key==='Enter') headerSearchMovies()">
                    <button class="search-btn" onclick="headerSearchMovies()" aria-label="Search">
                        <span class="nav-icon">🔍</span>
                    </button>
                </div>

                <!-- Navigation Links -->
                <div class="nav-links" role="menubar">
                    <a href="/" class="nav-link <?php echo $currentPath === '/' ? 'active' : ''; ?>" role="menuitem">
                        <span class="nav-icon">🏠</span>
                        <span>Home</span>
                    </a>
                    <a href="/features" class="nav-link <?php echo $currentPath === '/features' ? 'active' : ''; ?>" role="menuitem">
                        <span class="nav-icon">⭐</span>
                        <span>Features</span>
                    </a>
                    <a href="/about" class="nav-link <?php echo $currentPath === '/about' ? 'active' : ''; ?>" role="menuitem">
                        <span class="nav-icon">ℹ️</span>
                        <span>About</span>
                    </a>
                    <a href="/contact" class="nav-link <?php echo $currentPath === '/contact' ? 'active' : ''; ?>" role="menuitem">
                        <span class="nav-icon">✉️</span>
                        <span>Contact</span>
                    </a>
                </div>

                <!-- Auth Buttons -->
                <div class="user-menu">
                    <div class="auth-buttons">
                        <a href="/login" class="btn btn-secondary">
                            <span class="nav-icon">🔑</span>
                            <span>Sign In</span>
                        </a>
                        <a href="/register" class="btn btn-primary">
                            <span class="nav-icon">✨</span>
                            <span>Get Started</span>
                        </a>
                    </div>

                    <button class="mobile-menu-toggle" onclick="toggleMobileMenu()" aria-label="Toggle mobile menu">
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                    </button>
                </div>

            <?php else: ?>
                <!-- AUTH PAGE HEADER (Login/Register) -->
                <div style="display: flex; align-items: center; gap: 20px; color: rgba(255, 255, 255, 0.8);">
                    <span style="font-size: 1.1rem; font-weight: 600;">
                        <?php echo $currentPath === '/login' ? '🔑 Sign In' : '✨ Create Account'; ?>
                    </span>
                </div>

                <div class="auth-buttons">
                    <?php if ($currentPath !== '/login'): ?>
                        <a href="/login" class="btn btn-secondary">
                            <span>🔑</span>Sign In
                        </a>
                    <?php endif; ?>
                    <?php if ($currentPath !== '/register'): ?>
                        <a href="/register" class="btn btn-primary">
                            <span>✨</span>Get Started
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Mobile Navigation Menu -->
            <div class="mobile-nav" id="mobileNav">
                <?php if (!$isAuthPage): ?>
                    <!-- Mobile Search -->
                    <div class="header-search">
                        <input type="text" id="mobileSearchInput" placeholder="Search movies..." 
                               onkeypress="if(event.key==='Enter') headerSearchMovies(true)">
                        <button class="search-btn" onclick="headerSearchMovies(true)" aria-label="Search">
                            <span class="nav-icon">🔍</span>
                        </button>
                    </div>

                    <!-- Mobile Links -->
                    <?php if ($isLoggedIn): ?>
                        <a href="/dashboard" class="nav-link"><span class="nav-icon">📊</span>Dashboard</a>
                        <a href="/watchlist" class="nav-link"><span class="nav-icon">📝</span>Watchlist</a>
                        <a href="/watched" class="nav-link"><span class="nav-icon">✅</span>Watched</a>
                        <a href="/profile" class="nav-link"><span class="nav-icon">👤</span>Profile</a>
                        <div style="height: 1px; background: #e5e7eb; margin: 15px 0;"></div>
                        <a href="/logout" class="nav-link" onclick="return confirmLogout()"><span class="nav-icon">🚪</span>Sign Out</a>
                    <?php else: ?>
                        <a href="/" class="nav-link"><span class="nav-icon">🏠</span>Home</a>
                        <a href="/features" class="nav-link"><span class="nav-icon">⭐</span>Features</a>
                        <a href="/about" class="nav-link"><span class="nav-icon">ℹ️</span>About</a>
                        <a href="/contact" class="nav-link"><span class="nav-icon">✉️</span>Contact</a>
                        <div style="height: 1px; background: #e5e7eb; margin: 15px 0;"></div>
                        <div style="display: flex; gap: 10px;">
                            <a href="/login" class="btn btn-secondary" style="flex: 1; justify-content: center;"><span>🔑</span>Sign In</a>
                            <a href="/register" class="btn btn-primary" style="flex: 1; justify-content: center;"><span>✨</span>Get Started</a>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </nav>

        <!-- Enhanced Header Section for homepage -->
        <?php if (!$isAuthPage && $currentPath === '/'): ?>
        <div class="hero-header" style="text-align: center; padding: 80px 20px; margin-bottom: 50px; position: relative;">
            <!-- Animated background elements -->
            <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; overflow: hidden; z-index: 1;">
                <div style="position: absolute; top: 20%; left: 10%; font-size: 3rem; opacity: 0.1; animation: float 15s ease-in-out infinite;">🎭</div>
                <div style="position: absolute; top: 60%; right: 15%; font-size: 2.5rem; opacity: 0.1; animation: float 20s ease-in-out infinite; animation-delay: 5s;">🍿</div>
                <div style="position: absolute; top: 40%; left: 75%; font-size: 2rem; opacity: 0.1; animation: float 18s ease-in-out infinite; animation-delay: 10s;">🎪</div>
                <div style="position: absolute; bottom: 30%; left: 20%; font-size: 2.5rem; opacity: 0.1; animation: float 22s ease-in-out infinite; animation-delay: 3s;">🎨</div>
            </div>

            <div style="position: relative; z-index: 2;">
                <h1 style="font-size: clamp(3rem, 8vw, 5.5rem); font-weight: 900; margin-bottom: 24px; text-shadow: 2px 2px 8px rgba(0,0,0,0.3); color: white; line-height: 1.1;">
                    <span style="font-size: 1.2em; display: inline-block; animation: float 3s ease-in-out infinite;">🎬</span><br>
                    Discover Amazing Movies
                </h1>
                <p style="font-size: 1.5rem; opacity: 0.95; margin-bottom: 40px; color: white; max-width: 600px; margin-left: auto; margin-right: auto; line-height: 1.4;">
                    Rate, review, and track your favorite films with our intelligent movie platform
                </p>
                <div style="display: flex; justify-content: center; gap: 40px; flex-wrap: wrap; margin-bottom: 30px;">
                    <div style="display: flex; align-items: center; gap: 12px; color: rgba(255,255,255,0.9); font-weight: 600; font-size: 1.1rem;">
                        <span style="font-size: 1.5rem;">🔍</span>
                        <span>Smart Search</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 12px; color: rgba(255,255,255,0.9); font-weight: 600; font-size: 1.1rem;">
                        <span style="font-size: 1.5rem;">⭐</span>
                        <span>Rate & Review</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 12px; color: rgba(255,255,255,0.9); font-weight: 600; font-size: 1.1rem;">
                        <span style="font-size: 1.5rem;">🤖</span>
                        <span>AI Reviews</span>
                    </div>
                </div>
                <?php if (!$isLoggedIn): ?>
                <div style="display: flex; justify-content: center; gap: 20px; flex-wrap: wrap;">
                    <a href="/register" class="btn btn-primary" style="padding: 18px 36px; font-size: 1.1rem; font-weight: 800;">
                        <span>✨</span>Get Started Free
                    </a>
                    <a href="/features" class="btn btn-secondary" style="padding: 18px 36px; font-size: 1.1rem; font-weight: 800;">
                        <span>⭐</span>Learn More
                    </a>
                </div>
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
            const isOpen = dropdown.classList.contains('show');

            if (isOpen) {
                dropdown.classList.remove('show');
            } else {
                dropdown.classList.add('show');
            }
        }

        function toggleMobileMenu() {
            const mobileNav = document.getElementById('mobileNav');
            const toggle = document.querySelector('.mobile-menu-toggle');
            const isOpen = mobileNav.classList.contains('show');

            if (isOpen) {
                mobileNav.classList.remove('show');
                toggle.classList.remove('active');
            } else {
                mobileNav.classList.add('show');
                toggle.classList.add('active');
            }
        }

        function headerSearchMovies(isMobile = false) {
            const inputId = isMobile ? 'mobileSearchInput' : 'headerSearchInput';
            const query = document.getElementById(inputId).value.trim();

            if (!query) return;

            // Redirect to search page or trigger search
            if (typeof movieAppInstance !== 'undefined' && movieAppInstance.searchMovies) {
                // If on main page, use existing search functionality
                document.getElementById('searchInput').value = query;
                movieAppInstance.searchMovies();
            } else {
                // Redirect to home page with search
                window.location.href = '/?search=' + encodeURIComponent(query);
            }

            // Close mobile menu if open
            if (isMobile) {
                toggleMobileMenu();
            }
        }

        function confirmLogout() {
            return confirm('Are you sure you want to sign out?');
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', (e) => {
            const userMenu = document.querySelector('.user-profile');
            const mobileToggle = document.querySelector('.mobile-menu-toggle');
            const mobileNav = document.getElementById('mobileNav');

            // Close user dropdown
            if (userMenu && !userMenu.contains(e.target)) {
                document.getElementById('userDropdown')?.classList.remove('show');
            }

            // Close mobile menu
            if (mobileNav && !mobileToggle?.contains(e.target) && !mobileNav.contains(e.target)) {
                mobileNav.classList.remove('show');
                mobileToggle?.classList.remove('active');
            }
        });

        // Handle search on Enter key for both inputs
        ['headerSearchInput', 'mobileSearchInput'].forEach(id => {
            const input = document.getElementById(id);
            if (input) {
                input.addEventListener('keypress', (e) => {
                    if (e.key === 'Enter') {
                        headerSearchMovies(id === 'mobileSearchInput');
                    }
                });
            }
        });

        // Initialize URL search parameter
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const searchQuery = urlParams.get('search');
            if (searchQuery) {
                const searchInput = document.getElementById('searchInput');
                if (searchInput) {
                    searchInput.value = searchQuery;
                    if (typeof movieAppInstance !== 'undefined') {
                        movieAppInstance.searchMovies();
                    }
                }
            }
        });

        console.log(' Movie Review Hub - Enhanced Header System Loaded');
        console.log('Auth state:', window.authState);
        </script>