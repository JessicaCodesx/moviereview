<?php
$config = require CONFIG_PATH . '/app.php';
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

        /* Modern Header for Public Users */
        .public-header {
            background: <?php echo $isAuthPage ? 'rgba(255, 255, 255, 0.1)' : 'rgba(255, 255, 255, 0.95)'; ?> !important;
            backdrop-filter: blur(25px) saturate(180%) !important;
            border: 1px solid <?php echo $isAuthPage ? 'rgba(255, 255, 255, 0.2)' : 'rgba(255, 255, 255, 0.3)'; ?> !important;
            border-radius: 24px !important;
            padding: 16px 32px !important;
            margin-bottom: 32px !important;
            box-shadow: <?php echo $isAuthPage ? '0 25px 50px rgba(0,0,0,0.15)' : '0 25px 50px rgba(0,0,0,0.08), 0 8px 16px rgba(0,0,0,0.05)'; ?> !important;
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
            color: <?php echo $isAuthPage ? 'white' : '#6366f1'; ?> !important;
            font-size: 1.5rem !important;
            font-weight: 900 !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        .brand-link:hover {
            transform: scale(1.02) !important;
            color: <?php echo $isAuthPage ? 'rgba(255, 255, 255, 0.8)' : '#4f46e5'; ?> !important;
        }

        .brand-icon {
            font-size: 2rem !important;
            animation: brandFloat 4s ease-in-out infinite !important;
        }

        @keyframes brandFloat {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-3px) rotate(2deg); }
        }

        /* Search Section (for non-auth pages) */
        .header-search {
            display: <?php echo $isAuthPage ? 'none' : 'flex'; ?> !important;
            align-items: center !important;
            background: rgba(255, 255, 255, 0.9) !important;
            border: 2px solid rgba(99, 102, 241, 0.1) !important;
            border-radius: 50px !important;
            padding: 12px 20px !important;
            gap: 12px !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            min-width: 300px !important;
            max-width: 450px !important;
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
            width: 38px !important;
            height: 38px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: white !important;
            cursor: pointer !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            font-size: 1rem !important;
        }

        .search-btn:hover {
            transform: scale(1.1) !important;
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4) !important;
        }

        /* Auth Page Header Info */
        .auth-info {
            display: <?php echo $isAuthPage ? 'flex' : 'none'; ?> !important;
            align-items: center !important;
            gap: 12px !important;
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 600 !important;
            font-size: 1.1rem !important;
        }

        .auth-info-icon {
            font-size: 1.3rem !important;
        }

        /* Navigation & Actions */
        .header-actions {
            display: flex !important;
            align-items: center !important;
            gap: 20px !important;
        }

        .nav-links {
            display: <?php echo $isAuthPage ? 'none' : 'flex'; ?> !important;
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
            padding: 12px 20px !important;
            border-radius: 50px !important;
            text-decoration: none !important;
            font-weight: 700 !important;
            border: none !important;
            cursor: pointer !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            font-size: 0.95rem !important;
            position: relative !important;
            overflow: hidden !important;
        }

        .btn::before {
            content: '' !important;
            position: absolute !important;
            top: 0 !important;
            left: -100% !important;
            width: 100% !important;
            height: 100% !important;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent) !important;
            transition: left 0.6s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        .btn:hover::before {
            left: 100% !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, #6366f1, #8b5cf6) !important;
            color: white !important;
        }

        .btn-secondary {
            background: <?php echo $isAuthPage ? 'rgba(255, 255, 255, 0.15)' : 'rgba(255, 255, 255, 0.9)'; ?> !important;
            color: <?php echo $isAuthPage ? 'white' : '#374151'; ?> !important;
            border: 2px solid <?php echo $isAuthPage ? 'rgba(255, 255, 255, 0.25)' : 'rgba(99, 102, 241, 0.2)'; ?> !important;
        }

        .btn:hover {
            transform: translateY(-3px) !important;
            box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important;
        }

        .btn-primary:hover {
            box-shadow: 0 15px 35px rgba(99, 102, 241, 0.4) !important;
        }

        .btn-secondary:hover {
            background: <?php echo $isAuthPage ? 'rgba(255, 255, 255, 0.25)' : 'white'; ?> !important;
            border-color: <?php echo $isAuthPage ? 'rgba(255, 255, 255, 0.4)' : '#6366f1'; ?> !important;
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
            background: <?php echo $isAuthPage ? 'rgba(255, 255, 255, 0.1)' : 'rgba(99, 102, 241, 0.1)'; ?> !important;
        }

        .hamburger-line {
            width: 24px !important;
            height: 3px !important;
            background: <?php echo $isAuthPage ? 'white' : '#374151'; ?> !important;
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
            display: <?php echo $isAuthPage ? 'none' : 'block'; ?> !important;
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

        .mobile-auth-buttons {
            display: flex !important;
            flex-direction: column !important;
            gap: 12px !important;
            margin-top: 16px !important;
        }

        .mobile-auth-buttons .btn {
            width: 100% !important;
            justify-content: center !important;
        }

        /* Hero Section for Home Page */
        .hero-section {
            display: <?php echo ($currentPath === '/' && !$isAuthPage) ? 'block' : 'none'; ?> !important;
            text-align: center !important;
            padding: 60px 20px !important;
            margin-bottom: 40px !important;
            position: relative !important;
        }

        .hero-bg-elements {
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            overflow: hidden !important;
            pointer-events: none !important;
        }

        .floating-element {
            position: absolute !important;
            font-size: 2.5rem !important;
            opacity: 0.15 !important;
            animation: heroFloat 15s ease-in-out infinite !important;
        }

        .floating-element:nth-child(1) { top: 20%; left: 10%; animation-delay: 0s; }
        .floating-element:nth-child(2) { top: 60%; right: 15%; animation-delay: 3s; }
        .floating-element:nth-child(3) { top: 40%; left: 75%; animation-delay: 6s; }
        .floating-element:nth-child(4) { bottom: 30%; left: 20%; animation-delay: 9s; }

        @keyframes heroFloat {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-20px) rotate(120deg); }
            66% { transform: translateY(10px) rotate(240deg); }
        }

        .hero-content {
            position: relative !important;
            z-index: 2 !important;
        }

        .hero-title {
            font-size: clamp(2.5rem, 8vw, 4.5rem) !important;
            font-weight: 900 !important;
            margin-bottom: 20px !important;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.3) !important;
            color: white !important;
            line-height: 1.1 !important;
        }

        .hero-subtitle {
            font-size: 1.3rem !important;
            opacity: 0.95 !important;
            margin-bottom: 32px !important;
            color: white !important;
            max-width: 600px !important;
            margin-left: auto !important;
            margin-right: auto !important;
            line-height: 1.5 !important;
        }

        .hero-features {
            display: flex !important;
            justify-content: center !important;
            gap: 32px !important;
            flex-wrap: wrap !important;
            margin-bottom: 32px !important;
        }

        .hero-feature {
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
            color: rgba(255,255,255,0.9) !important;
            font-weight: 600 !important;
            font-size: 1rem !important;
        }

        .hero-feature-icon {
            font-size: 1.3rem !important;
        }

        .hero-cta {
            display: flex !important;
            justify-content: center !important;
            gap: 16px !important;
            flex-wrap: wrap !important;
        }

        .hero-cta .btn {
            padding: 16px 32px !important;
            font-size: 1.1rem !important;
            font-weight: 800 !important;
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
            .public-header {
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

            .hero-features {
                gap: 20px !important;
            }

            .hero-feature {
                font-size: 0.9rem !important;
            }

            .hero-cta {
                flex-direction: column !important;
                align-items: center !important;
            }

            .hero-cta .btn {
                width: 100% !important;
                max-width: 280px !important;
            }
        }

        @media (max-width: 480px) {
            .public-header {
                padding: 10px 16px !important;
                border-radius: 16px !important;
            }

            .brand-link {
                font-size: 1.25rem !important;
            }

            .brand-icon {
                font-size: 1.5rem !important;
            }

            .auth-buttons {
                gap: 8px !important;
            }

            .btn {
                padding: 10px 16px !important;
                font-size: 0.9rem !important;
            }

            .hero-section {
                padding: 40px 15px !important;
            }

            .hero-features {
                flex-direction: column !important;
                gap: 16px !important;
                align-items: center !important;
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
        <!-- Public User Header -->
        <header class="public-header" role="banner">
            <!-- Brand Section -->
            <div class="header-brand">
                <a href="/" class="brand-link" aria-label="Movie Review Hub - Home">
                    <span class="brand-icon">🎬</span>
                    <strong><?php echo $config['app_name']; ?></strong>
                </a>
            </div>

            <!-- Search Section (non-auth pages) -->
            <?php if (!$isAuthPage): ?>
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
            <?php else: ?>
                <div class="auth-info">
                    <span class="auth-info-icon"><?php echo $currentPath === '/login' ? '🔑' : '✨'; ?></span>
                    <span><?php echo $currentPath === '/login' ? 'Welcome Back' : 'Join Our Community'; ?></span>
                </div>
            <?php endif; ?>

            <!-- Actions Section -->
            <div class="header-actions">
                <!-- Navigation Links -->
                <?php if (!$isAuthPage): ?>
                    <nav class="nav-links" role="navigation" aria-label="Main navigation">
                        <a href="/" 
                           class="nav-link <?php echo $currentPath === '/' ? 'active' : ''; ?>" 
                           role="menuitem">
                            <span class="nav-icon">🏠</span>
                            <span>Home</span>
                        </a>
                        <a href="/features" 
                           class="nav-link <?php echo $currentPath === '/features' ? 'active' : ''; ?>" 
                           role="menuitem">
                            <span class="nav-icon">⭐</span>
                            <span>Features</span>
                        </a>
                        <a href="/about" 
                           class="nav-link <?php echo $currentPath === '/about' ? 'active' : ''; ?>" 
                           role="menuitem">
                            <span class="nav-icon">ℹ️</span>
                            <span>About</span>
                        </a>
                        <a href="/contact" 
                           class="nav-link <?php echo $currentPath === '/contact' ? 'active' : ''; ?>" 
                           role="menuitem">
                            <span class="nav-icon">✉️</span>
                            <span>Contact</span>
                        </a>
                    </nav>
                <?php endif; ?>

                <!-- Auth Buttons -->
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

                <!-- Mobile Menu Toggle -->
                <button class="mobile-toggle" onclick="toggleMobileMenu()" aria-label="Toggle mobile menu">
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                </button>
            </div>

            <!-- Mobile Menu -->
            <?php if (!$isAuthPage): ?>
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
                        <a href="/" class="mobile-nav-link">
                            <span>🏠</span>Home
                        </a>
                        <a href="/features" class="mobile-nav-link">
                            <span>⭐</span>Features
                        </a>
                        <a href="/about" class="mobile-nav-link">
                            <span>ℹ️</span>About
                        </a>
                        <a href="/contact" class="mobile-nav-link">
                            <span>✉️</span>Contact
                        </a>
                    </nav>

                    <!-- Mobile Auth Buttons -->
                    <div class="mobile-auth-buttons">
                        <a href="/login" class="btn btn-secondary">
                            <span>🔑</span>Sign In
                        </a>
                        <a href="/register" class="btn btn-primary">
                            <span>✨</span>Get Started Free
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </header>

        <!-- Hero Section for Homepage -->
        <section class="hero-section">
            <div class="hero-bg-elements">
                <div class="floating-element">🎭</div>
                <div class="floating-element">🍿</div>
                <div class="floating-element">🎪</div>
                <div class="floating-element">🎨</div>
            </div>

            <div class="hero-content">
                <h1 class="hero-title">
                    <span class="brand-icon">🎬</span><br>
                    Discover Amazing Movies
                </h1>
                <p class="hero-subtitle">
                    Rate, review, and track your favorite films with our intelligent movie platform
                </p>

                <div class="hero-features">
                    <div class="hero-feature">
                        <span class="hero-feature-icon">🔍</span>
                        <span>Smart Search</span>
                    </div>
                    <div class="hero-feature">
                        <span class="hero-feature-icon">⭐</span>
                        <span>Rate & Review</span>
                    </div>
                    <div class="hero-feature">
                        <span class="hero-feature-icon">🤖</span>
                        <span>AI Reviews</span>
                    </div>
                    <div class="hero-feature">
                        <span class="hero-feature-icon">📝</span>
                        <span>Track Progress</span>
                    </div>
                </div>

                <div class="hero-cta">
                    <a href="/register" class="btn btn-primary">
                        <span>✨</span>Get Started Free
                    </a>
                    <a href="/features" class="btn btn-secondary">
                        <span>⭐</span>Learn More
                    </a>
                </div>
            </div>
        </section>

        <script>
        // Global auth state management
        window.authState = {
            isLoggedIn: false,
            user: null
        };

        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            const toggle = document.querySelector('.mobile-toggle');

            if (!mobileMenu) return; // Auth pages don't have mobile menu

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
            const query = document.getElementById(inputId)?.value.trim();

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

        // Close mobile menu when clicking outside
        document.addEventListener('click', (e) => {
            const mobileToggle = document.querySelector('.mobile-toggle');
            const mobileMenu = document.getElementById('mobileMenu');

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

        console.log('🎬 Movie Review Hub - Public Header Loaded');
        </script>