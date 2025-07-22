<?php
$config = require CONFIG_PATH . '/app.php';
$currentPath = $_SERVER['REQUEST_URI'] ?? '/';
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
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Inter', sans-serif !important;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%) !important;
            background-attachment: fixed !important;
            min-height: 100vh !important;
            margin: 0 !important;
            padding: 0 !important;
            color: white !important;
            line-height: 1.6 !important;
        }

        .container {
            max-width: 1400px !important;
            margin: 0 auto !important;
            padding: 20px !important;
        }

        /* Modern Header for Authenticated Users */
        .auth-header {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(25px) saturate(180%) !important;
            border-radius: 24px !important;
            padding: 16px 32px !important;
            margin-bottom: 32px !important;
            box-shadow: 0 25px 50px rgba(0,0,0,0.08), 0 8px 16px rgba(0,0,0,0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
            position: sticky !important;
            top: 20px !important;
            z-index: 1000 !important;
            display: grid !important;
            grid-template-columns: auto 1fr auto !important;
            gap: 24px !important;
            align-items: center !important;
        }

        /* Brand Section */
        .header-brand {
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
        }

        .brand-link {
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
            text-decoration: none !important;
            color: #6366f1 !important;
            font-size: 1.5rem !important;
            font-weight: 900 !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        .brand-link:hover {
            transform: scale(1.02) !important;
            color: #4f46e5 !important;
        }

        .brand-icon {
            font-size: 2rem !important;
            animation: brandFloat 4s ease-in-out infinite !important;
        }

        @keyframes brandFloat {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-3px) rotate(2deg); }
        }

        /* Search Section */
        .header-search {
            display: flex !important;
            align-items: center !important;
            background: rgba(255, 255, 255, 0.7) !important;
            border: 2px solid rgba(99, 102, 241, 0.1) !important;
            border-radius: 50px !important;
            padding: 12px 20px !important;
            gap: 12px !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            min-width: 320px !important;
            max-width: 500px !important;
            width: 100% !important;
        }

        .header-search:focus-within {
            background: white !important;
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1), 0 8px 25px rgba(99, 102, 241, 0.15) !important;
            transform: translateY(-2px) !important;
        }

        .search-input {
            background: none !important;
            border: none !important;
            outline: none !important;
            flex: 1 !important;
            font-size: 1rem !important;
            color: #374151 !important;
            font-weight: 500 !important;
        }

        .search-input::placeholder {
            color: #9ca3af !important;
            font-weight: 400 !important;
        }

        .search-btn {
            background: linear-gradient(135deg, #6366f1, #8b5cf6) !important;
            border: none !important;
            border-radius: 50% !important;
            width: 40px !important;
            height: 40px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: white !important;
            cursor: pointer !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            font-size: 1.1rem !important;
        }

        .search-btn:hover {
            transform: scale(1.1) !important;
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4) !important;
        }

        /* Navigation & User Section */
        .header-actions {
            display: flex !important;
            align-items: center !important;
            gap: 20px !important;
        }

        .nav-links {
            display: flex !important;
            gap: 4px !important;
            align-items: center !important;
        }

        .nav-link {
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
            padding: 10px 16px !important;
            border-radius: 14px !important;
            text-decoration: none !important;
            color: #374151 !important;
            font-weight: 600 !important;
            font-size: 0.95rem !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
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
            background: linear-gradient(90deg, transparent, rgba(99,102,241,0.1), transparent) !important;
            transition: left 0.6s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        .nav-link:hover::before {
            left: 100% !important;
        }

        .nav-link:hover,
        .nav-link.active {
            background: linear-gradient(135deg, #6366f1, #8b5cf6) !important;
            color: white !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.3) !important;
        }

        .nav-icon {
            font-size: 1.1rem !important;
        }

        /* User Menu */
        .user-section {
            position: relative !important;
        }

        .user-trigger {
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
            background: rgba(99, 102, 241, 0.1) !important;
            border: 2px solid rgba(99, 102, 241, 0.15) !important;
            border-radius: 50px !important;
            padding: 8px 16px !important;
            cursor: pointer !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            text-decoration: none !important;
            color: #374151 !important;
        }

        .user-trigger:hover {
            background: rgba(99, 102, 241, 0.15) !important;
            border-color: rgba(99, 102, 241, 0.25) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.15) !important;
        }

        .user-avatar {
            width: 42px !important;
            height: 42px !important;
            background: linear-gradient(135deg, #6366f1, #8b5cf6) !important;
            border-radius: 50% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: white !important;
            font-weight: 800 !important;
            font-size: 1.1rem !important;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3) !important;
        }

        .user-info h4 {
            margin: 0 !important;
            font-size: 0.95rem !important;
            font-weight: 700 !important;
            color: #374151 !important;
        }

        .user-info span {
            font-size: 0.8rem !important;
            color: #6b7280 !important;
            font-weight: 500 !important;
        }

        .dropdown-icon {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            color: #6b7280 !important;
        }

        .user-trigger:hover .dropdown-icon {
            transform: rotate(180deg) !important;
        }

        /* Dropdown Menu */
        .user-dropdown {
            position: absolute !important;
            top: calc(100% + 12px) !important;
            right: 0 !important;
            background: white !important;
            border-radius: 20px !important;
            box-shadow: 0 25px 50px rgba(0,0,0,0.15), 0 0 0 1px rgba(0,0,0,0.05) !important;
            min-width: 280px !important;
            opacity: 0 !important;
            visibility: hidden !important;
            transform: translateY(-10px) scale(0.95) !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            z-index: 1001 !important;
            backdrop-filter: blur(20px) !important;
            overflow: hidden !important;
        }

        .user-dropdown.show {
            opacity: 1 !important;
            visibility: visible !important;
            transform: translateY(0) scale(1) !important;
        }

        .dropdown-header {
            padding: 24px !important;
            background: linear-gradient(135deg, #f8fafc, #f1f5f9) !important;
            border-bottom: 1px solid #e2e8f0 !important;
            text-align: center !important;
        }

        .dropdown-header h4 {
            margin: 0 0 4px 0 !important;
            font-size: 1.1rem !important;
            font-weight: 800 !important;
            color: #1f2937 !important;
        }

        .dropdown-header span {
            font-size: 0.85rem !important;
            color: #6b7280 !important;
            font-weight: 500 !important;
        }

        .dropdown-item {
            display: flex !important;
            align-items: center !important;
            gap: 14px !important;
            padding: 16px 24px !important;
            color: #374151 !important;
            text-decoration: none !important;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
            font-weight: 500 !important;
            border: none !important;
            background: none !important;
            width: 100% !important;
            cursor: pointer !important;
        }

        .dropdown-item:hover {
            background: linear-gradient(135deg, #f8fafc, #f1f5f9) !important;
            color: #6366f1 !important;
            transform: translateX(4px) !important;
        }

        .dropdown-item.logout:hover {
            background: linear-gradient(135deg, #fef2f2, #fee2e2) !important;
            color: #ef4444 !important;
        }

        .dropdown-divider {
            height: 1px !important;
            background: #e2e8f0 !important;
            margin: 8px 0 !important;
        }

        /* Mobile Menu Toggle */
        .mobile-toggle {
            display: none !important;
            flex-direction: column !important;
            gap: 4px !important;
            background: none !important;
            border: none !important;
            cursor: pointer !important;
            padding: 8px !important;
            border-radius: 8px !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        .mobile-toggle:hover {
            background: rgba(99, 102, 241, 0.1) !important;
        }

        .hamburger-line {
            width: 24px !important;
            height: 3px !important;
            background: #374151 !important;
            border-radius: 2px !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        .mobile-toggle.active .hamburger-line:nth-child(1) {
            transform: rotate(45deg) translate(6px, 6px) !important;
        }

        .mobile-toggle.active .hamburger-line:nth-child(2) {
            opacity: 0 !important;
        }

        .mobile-toggle.active .hamburger-line:nth-child(3) {
            transform: rotate(-45deg) translate(6px, -6px) !important;
        }

        /* Mobile Menu */
        .mobile-menu {
            display: none !important;
            position: absolute !important;
            top: calc(100% + 8px) !important;
            left: 0 !important;
            right: 0 !important;
            background: white !important;
            border-radius: 20px !important;
            padding: 24px !important;
            box-shadow: 0 25px 50px rgba(0,0,0,0.15) !important;
            backdrop-filter: blur(20px) !important;
            z-index: 1001 !important;
        }

        .mobile-menu.show {
            display: block !important;
            animation: slideDown 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .mobile-search {
            margin-bottom: 20px !important;
        }

        .mobile-nav-link {
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
            padding: 14px 16px !important;
            color: #374151 !important;
            text-decoration: none !important;
            border-radius: 12px !important;
            margin-bottom: 4px !important;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
            font-weight: 600 !important;
        }

        .mobile-nav-link:hover {
            background: linear-gradient(135deg, #f8fafc, #f1f5f9) !important;
            color: #6366f1 !important;
            transform: translateX(4px) !important;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .header-search {
                min-width: 250px !important;
            }

            .nav-links {
                gap: 2px !important;
            }

            .nav-link {
                padding: 8px 12px !important;
                font-size: 0.9rem !important;
            }
        }

        @media (max-width: 768px) {
            .auth-header {
                grid-template-columns: auto 1fr auto !important;
                gap: 16px !important;
                padding: 12px 20px !important;
            }

            .header-search {
                display: none !important;
            }

            .nav-links {
                display: none !important;
            }

            .mobile-toggle {
                display: flex !important;
            }

            .user-trigger {
                padding: 6px 12px !important;
            }

            .user-info {
                display: none !important;
            }
        }

        @media (max-width: 480px) {
            .auth-header {
                padding: 10px 16px !important;
                border-radius: 16px !important;
            }

            .brand-link {
                font-size: 1.25rem !important;
            }

            .brand-icon {
                font-size: 1.5rem !important;
            }

            .user-avatar {
                width: 36px !important;
                height: 36px !important;
                font-size: 1rem !important;
            }

            .user-dropdown {
                min-width: 250px !important;
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
        <!-- Authenticated User Header -->
        <header class="auth-header" role="banner">
            <!-- Brand Section -->
            <div class="header-brand">
                <a href="/" class="brand-link" aria-label="Movie Review Hub - Home">
                    <span class="brand-icon">🎬</span>
                    <strong><?php echo $config['app_name']; ?></strong>
                </a>
            </div>

            <!-- Search Section -->
            <div class="header-search">
                <input type="text" 
                       id="headerSearchInput" 
                       class="search-input"
                       placeholder="Search movies..." 
                       onkeypress="if(event.key==='Enter') headerSearchMovies()"
                       aria-label="Search movies">
                <button class="search-btn" 
                        onclick="headerSearchMovies()" 
                        aria-label="Search">
                    🔍
                </button>
            </div>

            <!-- Actions Section -->
            <div class="header-actions">
                <!-- Navigation Links -->
                <nav class="nav-links" role="navigation" aria-label="Main navigation">
                    <a href="/dashboard" 
                       class="nav-link <?php echo strpos($currentPath, '/dashboard') === 0 ? 'active' : ''; ?>" 
                       role="menuitem">
                        <span class="nav-icon">📊</span>
                        <span>Dashboard</span>
                    </a>
                    <a href="/watchlist" 
                       class="nav-link <?php echo strpos($currentPath, '/watchlist') === 0 ? 'active' : ''; ?>" 
                       role="menuitem">
                        <span class="nav-icon">📝</span>
                        <span>Watchlist</span>
                    </a>
                    <a href="/watched" 
                       class="nav-link <?php echo strpos($currentPath, '/watched') === 0 ? 'active' : ''; ?>" 
                       role="menuitem">
                        <span class="nav-icon">✅</span>
                        <span>Watched</span>
                    </a>
                </nav>

                <!-- User Menu -->
                <div class="user-section">
                    <button class="user-trigger" 
                            onclick="toggleUserMenu()" 
                            aria-expanded="false" 
                            aria-haspopup="true"
                            aria-label="User menu">
                        <div class="user-avatar">
                            <span><?php echo strtoupper(substr($_SESSION['user']['username'], 0, 1)); ?></span>
                        </div>
                        <div class="user-info">
                            <h4><?php echo htmlspecialchars($_SESSION['user']['username']); ?></h4>
                            <span>Member since <?php echo date('M Y', strtotime($_SESSION['user']['created_at'])); ?></span>
                        </div>
                        <svg class="dropdown-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="6,9 12,15 18,9"></polyline>
                        </svg>
                    </button>

                    <div class="user-dropdown" id="userDropdown">
                        <div class="dropdown-header">
                            <h4><?php echo htmlspecialchars($_SESSION['user']['username']); ?></h4>
                            <span>Welcome back! 👋</span>
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
                        <div class="dropdown-divider"></div>
                        <a href="/logout" class="dropdown-item logout" onclick="return confirmLogout()">
                            <span>🚪</span>Sign Out
                        </a>
                    </div>
                </div>

                <!-- Mobile Menu Toggle -->
                <button class="mobile-toggle" onclick="toggleMobileMenu()" aria-label="Toggle mobile menu">
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div class="mobile-menu" id="mobileMenu">
                <!-- Mobile Search -->
                <div class="mobile-search">
                    <div class="header-search">
                        <input type="text" 
                               id="mobileSearchInput" 
                               class="search-input"
                               placeholder="Search movies..." 
                               onkeypress="if(event.key==='Enter') headerSearchMovies(true)">
                        <button class="search-btn" onclick="headerSearchMovies(true)" aria-label="Search">
                            🔍
                        </button>
                    </div>
                </div>

                <!-- Mobile Navigation -->
                <nav role="navigation" aria-label="Mobile navigation">
                    <a href="/dashboard" class="mobile-nav-link">
                        <span>📊</span>Dashboard
                    </a>
                    <a href="/watchlist" class="mobile-nav-link">
                        <span>📝</span>Watchlist
                    </a>
                    <a href="/watched" class="mobile-nav-link">
                        <span>✅</span>Watched Movies
                    </a>
                    <a href="/profile" class="mobile-nav-link">
                        <span>👤</span>Profile
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="/logout" class="mobile-nav-link logout" onclick="return confirmLogout()">
                        <span>🚪</span>Sign Out
                    </a>
                </nav>
            </div>
        </header>

        <script>
        // Global auth state management
        window.authState = {
            isLoggedIn: true,
            user: <?php echo json_encode($_SESSION['user']); ?>
        };

        // Enhanced UI functionality
        function toggleUserMenu() {
            const dropdown = document.getElementById('userDropdown');
            const trigger = document.querySelector('.user-trigger');
            const isOpen = dropdown.classList.contains('show');

            if (isOpen) {
                dropdown.classList.remove('show');
                trigger.setAttribute('aria-expanded', 'false');
            } else {
                dropdown.classList.add('show');
                trigger.setAttribute('aria-expanded', 'true');
            }
        }

        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            const toggle = document.querySelector('.mobile-toggle');
            const isOpen = mobileMenu.classList.contains('show');

            if (isOpen) {
                mobileMenu.classList.remove('show');
                toggle.classList.remove('active');
            } else {
                mobileMenu.classList.add('show');
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
                const mainSearchInput = document.getElementById('searchInput');
                if (mainSearchInput) {
                    mainSearchInput.value = query;
                    movieAppInstance.searchMovies();
                }
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
            const userSection = document.querySelector('.user-section');
            const mobileToggle = document.querySelector('.mobile-toggle');
            const mobileMenu = document.getElementById('mobileMenu');

            // Close user dropdown
            if (userSection && !userSection.contains(e.target)) {
                document.getElementById('userDropdown')?.classList.remove('show');
                document.querySelector('.user-trigger')?.setAttribute('aria-expanded', 'false');
            }

            // Close mobile menu
            if (mobileMenu && !mobileToggle?.contains(e.target) && !mobileMenu.contains(e.target)) {
                mobileMenu.classList.remove('show');
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

        console.log('🎬 Movie Review Hub - Authenticated Header Loaded');
        </script>