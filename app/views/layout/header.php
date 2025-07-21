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

    <!-- Prevent FOUC (Flash of Unstyled Content) -->
    <style>
        .preload-hidden { opacity: 0; }
        body.loaded .preload-hidden { 
            opacity: 1; 
            transition: opacity 0.3s ease-in-out; 
        }
    </style>
</head>
<body class="preload-hidden">
    <!-- Loading screen -->
    <div id="pageLoader" class="page-loader">
        <div class="loader-content">
            <div class="loader-spinner"></div>
            <h3><?php echo $config['app_name']; ?></h3>
            <p>Loading your movie experience...</p>
        </div>
    </div>

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
                            <span class="nav-badge"><?php echo $_SESSION['watchlist_count']; ?></span>
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
                    <div class="user-profile">
                        <button class="user-menu-toggle" onclick="toggleUserMenu()" aria-expanded="false" aria-haspopup="true">
                            <div class="user-avatar">
                                <span class="user-initial"><?php echo strtoupper(substr($_SESSION['user']['username'], 0, 1)); ?></span>
                            </div>
                            <span class="user-name-display">
                                <?php echo htmlspecialchars($_SESSION['user']['username']); ?>
                            </span>
                            <svg class="user-menu-arrow" width="12" height="8" viewBox="0 0 12 8" fill="none">
                                <path d="M1 1L6 6L11 1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>

                        <div class="user-dropdown" id="userDropdown">
                            <div class="dropdown-header">
                                <div class="user-info">
                                    <strong><?php echo htmlspecialchars($_SESSION['user']['username']); ?></strong>
                                    <small>Member since <?php echo date('M Y', strtotime($_SESSION['user']['created_at'])); ?></small>
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
                            <a href="/logout" class="dropdown-item logout-item" onclick="return confirmLogout()">
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

        <!-- Mobile Navigation Overlay -->
        <div class="mobile-nav-overlay" id="mobileNavOverlay" onclick="toggleMobileMenu()"></div>
        <div class="mobile-nav" id="mobileNav">
            <div class="mobile-nav-header">
                <h3><?php echo $config['app_name']; ?></h3>
                <button class="mobile-nav-close" onclick="toggleMobileMenu()" aria-label="Close mobile menu">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <div class="mobile-nav-content">
                <?php if ($isLoggedIn): ?>
                    <div class="mobile-user-info">
                        <div class="mobile-user-avatar">
                            <span><?php echo strtoupper(substr($_SESSION['user']['username'], 0, 1)); ?></span>
                        </div>
                        <div class="mobile-user-details">
                            <strong><?php echo htmlspecialchars($_SESSION['user']['username']); ?></strong>
                            <small>Member since <?php echo date('M Y', strtotime($_SESSION['user']['created_at'])); ?></small>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="mobile-nav-links">
                    <a href="/" class="mobile-nav-link <?php echo $currentPath === '/' ? 'active' : ''; ?>">
                        <span class="nav-icon">🔍</span>
                        Search Movies
                    </a>

                    <?php if ($isLoggedIn): ?>
                        <a href="/dashboard" class="mobile-nav-link <?php echo strpos($currentPath, '/dashboard') === 0 ? 'active' : ''; ?>">
                            <span class="nav-icon">📊</span>
                            Dashboard
                        </a>
                        <a href="/watchlist" class="mobile-nav-link <?php echo strpos($currentPath, '/watchlist') === 0 ? 'active' : ''; ?>">
                            <span class="nav-icon">📝</span>
                            Watchlist
                            <?php if (isset($_SESSION['watchlist_count']) && $_SESSION['watchlist_count'] > 0): ?>
                                <span class="nav-badge"><?php echo $_SESSION['watchlist_count']; ?></span>
                            <?php endif; ?>
                        </a>
                        <a href="/watched" class="mobile-nav-link <?php echo strpos($currentPath, '/watched') === 0 ? 'active' : ''; ?>">
                            <span class="nav-icon">✅</span>
                            Watched Movies
                        </a>
                        <a href="/profile" class="mobile-nav-link <?php echo strpos($currentPath, '/profile') === 0 ? 'active' : ''; ?>">
                            <span class="nav-icon">👤</span>
                            Profile
                        </a>
                        <div class="mobile-nav-divider"></div>
                        <a href="/logout" class="mobile-nav-link logout-link" onclick="return confirmLogout()">
                            <span class="nav-icon">🚪</span>
                            Logout
                        </a>
                    <?php else: ?>
                        <a href="/login" class="mobile-nav-link">
                            <span class="nav-icon">🔑</span>
                            Login
                        </a>
                        <a href="/register" class="mobile-nav-link">
                            <span class="nav-icon">✨</span>
                            Sign Up Free
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
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
            <div class="header-bg-animation">
                <div class="floating-element floating-element-1">🎭</div>
                <div class="floating-element floating-element-2">🍿</div>
                <div class="floating-element floating-element-3">🎪</div>
                <div class="floating-element floating-element-4">🎨</div>
                <div class="floating-element floating-element-5">🎵</div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Progress Bar for Page Loading -->
        <div class="progress-bar" id="progressBar"></div>

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
            const mobileNav = document.getElementById('mobileNav');
            const overlay = document.getElementById('mobileNavOverlay');
            const toggle = document.querySelector('.mobile-menu-toggle');
            const isOpen = mobileNav.classList.contains('show');

            if (isOpen) {
                mobileNav.classList.remove('show');
                overlay.classList.remove('show');
                toggle.classList.remove('active');
                document.body.style.overflow = '';
            } else {
                mobileNav.classList.add('show');
                overlay.classList.add('show');
                toggle.classList.add('active');
                document.body.style.overflow = 'hidden';
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
                dropdown.classList.remove('show');
                document.querySelector('.user-menu-toggle').setAttribute('aria-expanded', 'false');
            }
        });

        // Enhanced page loading with progress bar
        window.addEventListener('load', () => {
            // Hide page loader
            const loader = document.getElementById('pageLoader');
            if (loader) {
                loader.style.opacity = '0';
                setTimeout(() => {
                    loader.style.display = 'none';
                }, 300);
            }

            // Show main content
            document.body.classList.add('loaded');

            // Hide progress bar
            const progressBar = document.getElementById('progressBar');
            if (progressBar) {
                progressBar.style.width = '100%';
                setTimeout(() => {
                    progressBar.style.opacity = '0';
                }, 200);
            }
        });

        // Show progress bar during page navigation
        window.addEventListener('beforeunload', () => {
            const progressBar = document.getElementById('progressBar');
            if (progressBar) {
                progressBar.style.opacity = '1';
                progressBar.style.width = '30%';
            }
        });

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

        // Add keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            // Alt + M to toggle mobile menu
            if (e.altKey && e.key === 'm') {
                e.preventDefault();
                toggleMobileMenu();
            }

            // Alt + U to toggle user menu (if logged in)
            if (e.altKey && e.key === 'u' && window.authState.isLoggedIn) {
                e.preventDefault();
                toggleUserMenu();
            }
        });

        // Initialize page animations
        document.addEventListener('DOMContentLoaded', () => {
            // Animate navigation elements
            const navElements = document.querySelectorAll('.nav-link, .btn');
            navElements.forEach((el, index) => {
                el.style.animationDelay = `${index * 0.1}s`;
                el.classList.add('animate-in');
            });
        });
        </script>

        <!-- Additional CSS for enhanced header components -->
        <style>
        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.3s ease;
        }

        .loader-content {
            text-align: center;
            color: white;
        }

        .loader-spinner {
            width: 50px;
            height: 50px;
            border: 3px solid rgba(255,255,255,0.3);
            border-top: 3px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 1.5rem;
        }

        .loader-content h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .loader-content p {
            opacity: 0.9;
        }

        .progress-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 3px;
            background: linear-gradient(90deg, #6366f1, #ec4899);
            z-index: 10001;
            transition: width 0.3s ease, opacity 0.3s ease;
            opacity: 0;
        }

        .brand-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.25rem;
            font-weight: 800;
        }

        .brand-icon {
            font-size: 1.5rem;
        }

        .nav-icon {
            font-size: 1.1rem;
        }

        .nav-text {
            margin-left: 0.5rem;
        }

        .nav-badge {
            background: #ef4444;
            color: white;
            font-size: 0.75rem;
            padding: 0.125rem 0.375rem;
            border-radius: 9999px;
            margin-left: 0.5rem;
            font-weight: 600;
        }

        .user-menu-toggle {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.75rem;
            transition: all 0.2s ease;
        }

        .user-menu-toggle:hover {
            background: rgba(0,0,0,0.05);
        }

        .user-avatar {
            width: 2.5rem;
            height: 2.5rem;
            background: linear-gradient(135deg, #6366f1, #ec4899);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.875rem;
        }

        .user-name-display {
            font-weight: 600;
            color: var(--neutral-700);
        }

        .user-menu-arrow {
            transition: transform 0.2s ease;
            color: var(--neutral-500);
        }

        .user-menu-toggle[aria-expanded="true"] .user-menu-arrow {
            transform: rotate(180deg);
        }

        .user-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 0.5rem;
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(0,0,0,0.1);
            min-width: 200px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px) scale(0.95);
            transition: all 0.2s ease;
            z-index: 1000;
        }

        .user-dropdown.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
        }

        .dropdown-header {
            padding: 1rem;
        }

        .dropdown-divider {
            height: 1px;
            background: var(--neutral-200);
            margin: 0.5rem 0;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: var(--neutral-700);
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background: var(--neutral-50);
            color: var(--primary-600);
        }

        .dropdown-item.active {
            background: var(--primary-50);
            color: var(--primary-600);
        }

        .dropdown-item.logout-item:hover {
            background: #fef2f2;
            color: #dc2626;
        }

        .dropdown-icon {
            font-size: 1rem;
        }

        .mobile-menu-toggle {
            display: none;
            flex-direction: column;
            gap: 0.25rem;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.5rem;
        }

        .hamburger-line {
            width: 1.5rem;
            height: 2px;
            background: var(--neutral-700);
            transition: all 0.3s ease;
        }

        .mobile-menu-toggle.active .hamburger-line:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }

        .mobile-menu-toggle.active .hamburger-line:nth-child(2) {
            opacity: 0;
        }

        .mobile-menu-toggle.active .hamburger-line:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -6px);
        }

        .mobile-nav-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(4px);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1001;
        }

        .mobile-nav-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        .mobile-nav {
            position: fixed;
            top: 0;
            right: 0;
            width: 300px;
            height: 100%;
            background: white;
            transform: translateX(100%);
            transition: transform 0.3s ease;
            z-index: 1002;
            overflow-y: auto;
        }

        .mobile-nav.show {
            transform: translateX(0);
        }

        .mobile-nav-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem;
            border-bottom: 1px solid var(--neutral-200);
        }

        .mobile-nav-close {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--neutral-600);
        }

        .mobile-user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.5rem;
            border-bottom: 1px solid var(--neutral-200);
        }

        .mobile-user-avatar {
            width: 3rem;
            height: 3rem;
            background: linear-gradient(135deg, #6366f1, #ec4899);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
        }

        .mobile-nav-links {
            padding: 1rem 0;
        }

        .mobile-nav-link {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 1.5rem;
            color: var(--neutral-700);
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .mobile-nav-link:hover,
        .mobile-nav-link.active {
            background: var(--primary-50);
            color: var(--primary-600);
        }

        .mobile-nav-link.logout-link:hover {
            background: #fef2f2;
            color: #dc2626;
        }

        .mobile-nav-divider {
            height: 1px;
            background: var(--neutral-200);
            margin: 1rem 0;
        }

        .header-content {
            position: relative;
            z-index: 2;
        }

        .header-features {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-top: 2rem;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: rgba(255,255,255,0.9);
            font-weight: 500;
        }

        .feature-icon {
            font-size: 1.25rem;
        }

        .header-bg-animation {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            overflow: hidden;
            z-index: 1;
        }

        .floating-element {
            position: absolute;
            font-size: 2rem;
            opacity: 0.1;
            animation: float 20s ease-in-out infinite;
        }

        .floating-element-1 { top: 20%; left: 10%; animation-delay: 0s; }
        .floating-element-2 { top: 60%; left: 80%; animation-delay: 4s; }
        .floating-element-3 { top: 40%; left: 70%; animation-delay: 8s; }
        .floating-element-4 { top: 80%; left: 20%; animation-delay: 12s; }
        .floating-element-5 { top: 30%; left: 30%; animation-delay: 16s; }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            25% { transform: translateY(-20px) rotate(5deg); }
            50% { transform: translateY(-10px) rotate(-5deg); }
            75% { transform: translateY(-30px) rotate(3deg); }
        }

        @media (max-width: 768px) {
            .mobile-menu-toggle {
                display: flex;
            }

            .nav-links,
            .user-menu {
                display: none;
            }

            .header-features {
                flex-direction: column;
                gap: 1rem;
            }

            .mobile-nav {
                width: 280px;
            }

            .user-name {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .nav-brand .brand-link {
                font-size: 1rem;
            }

            .brand-icon {
                font-size: 1.25rem;
            }

            .mobile-nav {
                width: 100%;
            }
        }
        </style>