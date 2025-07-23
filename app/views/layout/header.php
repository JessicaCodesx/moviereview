<?php
// PERFORMANCE-OPTIMIZED header.php for authenticated users
$config = require CONFIG_PATH . '/app.php';
$currentPath = $_SERVER['REQUEST_URI'] ?? '/';

// Get user info if available
$user = $_SESSION['user'] ?? null;
$userName = $user['username'] ?? $user['email'] ?? 'User';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $config['app_name']; ?><?php echo $currentPath !== '/' ? ' - ' . ucfirst(trim($currentPath, '/')) : ''; ?></title>

    <!-- Essential Meta Tags -->
    <meta name="description" content="Discover, rate, and review your favorite movies. Track your watchlist and get personalized recommendations.">
    <meta name="keywords" content="movies, reviews, ratings, watchlist, cinema, films">
    <meta name="author" content="<?php echo $config['app_name']; ?>">
    <meta property="og:title" content="<?php echo $config['app_name']; ?>">
    <meta property="og:description" content="Your ultimate movie discovery and rating platform">
    <meta property="og:type" content="website">
    <link rel="icon" type="image/x-icon" href="/public/assets/images/favicon.ico">
    <meta name="theme-color" content="#6366f1">

    <!-- PERFORMANCE-OPTIMIZED Critical CSS -->
    <style>
        /* CRITICAL: Inline essential styles for immediate rendering */
        * {
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Inter', sans-serif !important;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%) !important;
            /* REMOVED: background-attachment: fixed - Major performance issue */
            min-height: 100vh !important;
            margin: 0 !important;
            padding: 0 !important;
            color: white !important;
            line-height: 1.6 !important;
            /* ADD: Hardware acceleration */
            transform: translate3d(0, 0, 0) !important;
        }

        .container {
            max-width: 1400px !important;
            margin: 0 auto !important;
            padding: 20px !important;
        }

        /* OPTIMIZED: Modern Header for Authenticated Users */
        .auth-header {
            background: rgba(255, 255, 255, 0.95) !important;
            /* REMOVED: backdrop-filter - Very expensive on mobile */
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
            /* FASTER: Reduced animation time */
            animation: slideIn 0.3s ease-out !important;
            /* ADD: Hardware acceleration */
            transform: translate3d(0, 0, 0) !important;
        }

        /* SIMPLIFIED: Faster slide animation */
        @keyframes slideIn {
            from {
                transform: translateY(-20px) !important;
                opacity: 0 !important;
            }
            to {
                transform: translateY(0) !important;
                opacity: 1 !important;
            }
        }

        /* Brand Section - optimized */
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
            /* FASTER: Reduced transition time */
            transition: all 0.2s ease !important;
            /* ADD: Hardware acceleration */
            transform: translate3d(0, 0, 0) !important;
        }

        .brand-link:hover {
            color: #4f46e5 !important;
            /* REMOVED: transform: scale() - can cause layout shifts */
        }

        .brand-icon {
            font-size: 2rem !important;
            /* SIMPLIFIED: Reduced animation complexity */
            animation: brandFloat 4s ease-in-out infinite !important;
        }

        @keyframes brandFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-2px); }
        }

        /* Search Section - optimized */
        .header-search {
            display: flex !important;
            align-items: center !important;
            background: rgba(248, 250, 252, 0.8) !important;
            border: 2px solid rgba(226, 232, 240, 0.6) !important;
            border-radius: 14px !important;
            padding: 4px !important;
            /* FASTER: Reduced transition */
            transition: all 0.2s ease !important;
            min-width: 280px !important;
            max-width: 400px !important;
        }

        .header-search:focus-within {
            background: white !important;
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1) !important;
        }

        .search-input {
            border: none !important;
            background: transparent !important;
            padding: 10px 16px !important;
            font-size: 0.95rem !important;
            color: #334155 !important;
            width: 100% !important;
            /* FASTER: Reduced transition */
            transition: all 0.2s ease !important;
            outline: none !important;
        }

        .search-input::placeholder {
            color: #94a3b8 !important;
        }

        .search-btn {
            background: linear-gradient(135deg, #6366f1, #8b5cf6) !important;
            border: none !important;
            border-radius: 10px !important;
            padding: 10px 12px !important;
            color: white !important;
            cursor: pointer !important;
            font-size: 1rem !important;
            /* FASTER: Reduced transition */
            transition: all 0.2s ease !important;
            /* ADD: Hardware acceleration */
            transform: translate3d(0, 0, 0) !important;
        }

        .search-btn:hover {
            /* SIMPLIFIED: Remove complex transforms */
            background: linear-gradient(135deg, #4f46e5, #7c3aed) !important;
            transform: translate3d(0, -1px, 0) !important;
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
            /* FASTER: Simplified transition */
            transition: all 0.2s ease !important;
            /* ADD: Hardware acceleration */
            transform: translate3d(0, 0, 0) !important;
        }

        /* REMOVED: Complex ::before pseudo-element animations */

        .nav-link:hover,
        .nav-link.active {
            background: linear-gradient(135deg, #6366f1, #8b5cf6) !important;
            color: white !important;
            /* SIMPLIFIED: Remove translateY transform to avoid reflows */
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3) !important;
        }

        .nav-icon {
            font-size: 1.1rem !important;
        }

        /* User section - optimized */
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
            /* FASTER: Simplified transition */
            transition: all 0.2s ease !important;
            /* ADD: Hardware acceleration */
            transform: translate3d(0, 0, 0) !important;
            text-decoration: none !important;
        }

        .user-trigger:hover {
            background: rgba(99, 102, 241, 0.15) !important;
            border-color: rgba(99, 102, 241, 0.25) !important;
            /* SIMPLIFIED: Remove complex transforms */
            transform: translate3d(0, -1px, 0) !important;
        }

        .user-avatar {
            width: 32px !important;
            height: 32px !important;
            background: linear-gradient(135deg, #6366f1, #8b5cf6) !important;
            border-radius: 50% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: white !important;
            font-weight: 700 !important;
            font-size: 0.9rem !important;
        }

        .user-name {
            color: #374151 !important;
            font-weight: 600 !important;
            font-size: 0.95rem !important;
        }

        .dropdown-icon {
            color: #94a3b8 !important;
            font-size: 0.8rem !important;
            /* SIMPLIFIED: Remove rotation animation */
            transition: color 0.2s ease !important;
        }

        .user-trigger:hover .dropdown-icon {
            color: #6366f1 !important;
        }

        /* CRITICAL: Mobile Performance Optimization */
        @media (max-width: 768px) {
            /* Disable animations on mobile for better performance */
            .auth-header {
                animation: none !important;
            }

            * {
                transition-duration: 0.1s !important;
            }

            .auth-header {
                grid-template-columns: 1fr !important;
                gap: 16px !important;
                padding: 16px !important;
                text-align: center !important;
            }

            .header-search {
                order: 3 !important;
                min-width: 100% !important;
                max-width: 100% !important;
            }

            .header-actions {
                order: 2 !important;
                width: 100% !important;
                justify-content: space-between !important;
            }

            .nav-links {
                gap: 2px !important;
                flex-wrap: wrap !important;
                justify-content: center !important;
            }

            .nav-link {
                padding: 8px 12px !important;
                font-size: 0.9rem !important;
            }

            .container {
                padding: 16px !important;
            }

            /* Hide complex elements on mobile */
            .brand-icon {
                animation: none !important;
            }
        }

        /* Performance hints */
        .will-change-transform {
            will-change: transform !important;
        }

        /* Reduced motion for accessibility */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
</head>
<body class="loaded">
    <div class="container">
        <!-- OPTIMIZED: Authenticated User Header -->
        <header class="auth-header" role="banner">
            <!-- Brand Section -->
            <div class="header-brand">
                <a href="/dashboard" class="brand-link" aria-label="<?php echo $config['app_name']; ?> - Dashboard">
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
                       aria-label="Search movies"
                       autocomplete="off">
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
                    <a href="/profile" 
                       class="nav-link <?php echo strpos($currentPath, '/profile') === 0 ? 'active' : ''; ?>" 
                       role="menuitem">
                        <span class="nav-icon">👤</span>
                        <span>Profile</span>
                    </a>
                </nav>

                <!-- User Menu -->
                <div class="user-section">
                    <a href="/profile" class="user-trigger" aria-label="User menu">
                        <div class="user-avatar">
                            <?php echo strtoupper(substr($userName, 0, 1)); ?>
                        </div>
                        <span class="user-name"><?php echo htmlspecialchars($userName); ?></span>
                        <span class="dropdown-icon">▼</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- OPTIMIZED: Search Functionality -->
        <script>
            // Performance-optimized search functions
            let searchTimeout;

            function headerSearchMovies() {
                const query = document.getElementById('headerSearchInput').value.trim();
                if (!query) return;

                // Redirect to search results or trigger search
                window.location.href = `/search?q=${encodeURIComponent(query)}`;
            }

            // Debounced search suggestions (optional)
            function setupSearchSuggestions() {
                const searchInput = document.getElementById('headerSearchInput');
                if (!searchInput) return;

                searchInput.addEventListener('input', function(e) {
                    clearTimeout(searchTimeout);
                    const query = e.target.value.trim();

                    if (query.length >= 2) {
                        searchTimeout = setTimeout(() => {
                            // Show search suggestions if implemented
                            console.log('Search suggestions for:', query);
                        }, 300);
                    }
                });
            }

            // Initialize when DOM is ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', setupSearchSuggestions);
            } else {
                setupSearchSuggestions();
            }

            // Keyboard shortcut for search
            document.addEventListener('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                    e.preventDefault();
                    const searchInput = document.getElementById('headerSearchInput');
                    if (searchInput) {
                        searchInput.focus();
                        searchInput.select();
                    }
                }
            });

            // Add hardware acceleration class after load
            window.addEventListener('load', function() {
                document.querySelectorAll('.nav-link, .user-trigger, .brand-link').forEach(el => {
                    el.classList.add('will-change-transform');
                });

                // Remove will-change after transitions complete for better performance
                setTimeout(() => {
                    document.querySelectorAll('.will-change-transform').forEach(el => {
                        el.style.willChange = 'auto';
                    });
                }, 1000);
            });

            // Performance monitoring
            if ('performance' in window) {
                window.addEventListener('load', function() {
                    const loadTime = performance.timing.loadEventEnd - performance.timing.navigationStart;
                    if (loadTime > 2000) {
                        console.warn('Header load time is high:', loadTime + 'ms');
                    }
                });
            }
        </script>
    </div>
</body>
</html>