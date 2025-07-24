<?php
// Professional Layout Configuration
if (!isset($config)) {
    $config = require CONFIG_PATH . '/app.php';
}
if (!isset($currentPath)) {
    $currentPath = $_SERVER['REQUEST_URI'] ?? '/';
}

// User Authentication Status
$isLoggedIn = isset($_SESSION['user']) && !empty($_SESSION['user']['id']);
$user = $_SESSION['user'] ?? null;

// Page Type Detection
$isAuthPage = in_array($currentPath, ['/login', '/register', '/reset-password', '/verify-email']);
$isDashboardPage = $isLoggedIn && in_array($currentPath, ['/dashboard', '/watchlist', '/watched', '/profile', '/settings']);
$isPublicPage = !$isLoggedIn && !$isAuthPage;

// Dynamic Page Title Generation
$pageTitle = $config['app_name'];
if (isset($page_title)) {
    $pageTitle .= ' - ' . htmlspecialchars($page_title);
} elseif ($currentPath !== '/') {
    $pathSegments = array_filter(explode('/', $currentPath));
    if (!empty($pathSegments)) {
        $pageTitle .= ' - ' . ucwords(str_replace('-', ' ', end($pathSegments)));
    }
}

// SEO and Social Meta Description
$metaDescription = isset($page_description) 
    ? htmlspecialchars($page_description)
    : "Discover, rate, and review exceptional cinema. Join an elite community of movie connoisseurs and curate your personal collection.";

// Canonical URL
$canonicalUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') 
    . '://' . $_SERVER['HTTP_HOST'] . $currentPath;
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <!-- Essential Meta Information -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page Title -->
    <title><?php echo $pageTitle; ?></title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="<?php echo $metaDescription; ?>">
    <meta name="keywords" content="movies, cinema, reviews, ratings, watchlist, film discovery, entertainment">
    <meta name="author" content="<?php echo htmlspecialchars($config['app_name']); ?>">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?php echo $canonicalUrl; ?>">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?php echo $pageTitle; ?>">
    <meta property="og:description" content="<?php echo $metaDescription; ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo $canonicalUrl; ?>">
    <meta property="og:site_name" content="<?php echo htmlspecialchars($config['app_name']); ?>">
    <meta property="og:image" content="/public/assets/images/og-image.jpg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo $pageTitle; ?>">
    <meta name="twitter:description" content="<?php echo $metaDescription; ?>">
    <meta name="twitter:image" content="/public/assets/images/twitter-card.jpg">

    <!-- Favicon and App Icons -->
    <link rel="icon" type="image/x-icon" href="/public/assets/images/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/public/assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/public/assets/images/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/public/assets/images/apple-touch-icon.png">
    <link rel="manifest" href="/public/assets/manifest.json">

    <!-- Theme and Browser Configuration -->
    <meta name="theme-color" content="#1a1f3a">
    <meta name="msapplication-TileColor" content="#1a1f3a">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <!-- Performance and Security -->
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; style-src 'self' 'unsafe-inline'; script-src 'self' 'unsafe-inline'; img-src 'self' data: https:; font-src 'self'; connect-src 'self';">
    <meta name="referrer" content="strict-origin-when-cross-origin">

    <!-- Preload Critical Resources -->
    <link rel="preload" href="/public/css/style.css" as="style">
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="dns-prefetch" href="//fonts.googleapis.com">

    <!-- Critical CSS for Immediate Rendering -->
    <style>
        /* Critical Regal Styles - Inline for Performance */
        :root {
            --regal-primary: #1a1f3a;
            --regal-secondary: #0f1419;
            --regal-accent: #daa520;
            --regal-accent-light: #f4d03f;
            --regal-text: #ffffff;
            --regal-text-muted: rgba(255, 255, 255, 0.7);
            --regal-border: rgba(218, 165, 32, 0.3);
            --regal-backdrop: rgba(26, 31, 58, 0.6);
            --container-max-width: 1400px;
            --container-padding: 32px;
            --border-radius: 16px;
            --transition-smooth: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            -webkit-text-size-adjust: 100%;
        }

        html.no-js {
            /* Fallback styles for when JS is disabled */
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Inter', 'Helvetica Neue', sans-serif;
            background: linear-gradient(135deg, var(--regal-secondary) 0%, var(--regal-primary) 50%, var(--regal-secondary) 100%);
            min-height: 100vh;
            margin: 0;
            padding: 0;
            color: var(--regal-text);
            line-height: 1.6;
            font-size: 16px;
            font-weight: 400;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
            overflow-x: hidden;
        }

        /* Layout Containers */
        .layout-container {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .page-header {
            position: relative;
            z-index: 1000;
        }

        .page-main {
            flex: 1;
            position: relative;
            z-index: 1;
        }

        .page-footer {
            position: relative;
            z-index: 1;
            margin-top: auto;
        }

        /* Content Containers */
        .container {
            max-width: var(--container-max-width);
            margin: 0 auto;
            padding: 0 var(--container-padding);
            width: 100%;
        }

        .content-wrapper {
            padding: 40px 0;
        }

        .auth-content-wrapper {
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Loading States */
        .loading {
            opacity: 0.7;
            pointer-events: none;
            cursor: wait;
        }

        /* Skip Link for Accessibility */
        .skip-link {
            position: absolute;
            top: -40px;
            left: 6px;
            background: var(--regal-accent);
            color: var(--regal-primary);
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 600;
            z-index: 2000;
            transition: top 0.3s ease;
        }

        .skip-link:focus {
            top: 6px;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            :root {
                --container-padding: 24px;
            }
        }

        @media (max-width: 768px) {
            :root {
                --container-padding: 20px;
            }

            .content-wrapper {
                padding: 24px 0;
            }
        }

        @media (max-width: 480px) {
            :root {
                --container-padding: 16px;
            }

            .content-wrapper {
                padding: 20px 0;
            }

            body {
                font-size: 15px;
            }
        }

        /* Reduced Motion Support */
        @media (prefers-reduced-motion: reduce) {
            html {
                scroll-behavior: auto;
            }

            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        /* High Contrast Mode Support */
        @media (prefers-contrast: high) {
            :root {
                --regal-border: rgba(218, 165, 32, 0.8);
                --regal-text-muted: rgba(255, 255, 255, 0.9);
            }
        }

        /* Print Styles */
        @media print {
            body {
                background: white !important;
                color: black !important;
            }

            .page-header,
            .page-footer {
                display: none !important;
            }
        }
    </style>

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="/public/css/style.css">

    <!-- Conditional Stylesheets -->
    <?php if ($isAuthPage): ?>
    <link rel="stylesheet" href="/public/css/auth.css">
    <?php endif; ?>

    <?php if ($isDashboardPage): ?>
    <link rel="stylesheet" href="/public/css/dashboard.css">
    <?php endif; ?>

    <!-- Page-Specific Styles -->
    <?php if (isset($page_styles)): ?>
        <?php foreach ((array)$page_styles as $style): ?>
        <link rel="stylesheet" href="<?php echo htmlspecialchars($style); ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body class="<?php echo $isAuthPage ? 'auth-page' : ($isDashboardPage ? 'dashboard-page' : 'public-page'); ?> <?php echo isset($page_class) ? htmlspecialchars($page_class) : ''; ?>">
    <!-- Skip Link for Accessibility -->
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <!-- Layout Container -->
    <div class="layout-container">
        <!-- Page Header -->
        <div class="page-header">
            <?php if ($isLoggedIn): ?>
                <?php include APP_PATH . '/views/layout/header.php'; ?>
            <?php else: ?>
                <?php include APP_PATH . '/views/layout/publicheader.php'; ?>
            <?php endif; ?>
        </div>

        <!-- Main Content Area -->
        <main class="page-main" id="main-content" role="main">
            <?php if ($isAuthPage): ?>
                <!-- Auth Pages - Full Width -->
                <div class="auth-content-wrapper">
                    <?php echo $content; ?>
                </div>
            <?php else: ?>
                <!-- Regular Pages - Contained -->
                <div class="container">
                    <div class="content-wrapper">
                        <?php echo $content; ?>
                    </div>
                </div>
            <?php endif; ?>
        </main>

        <!-- Page Footer -->
        <div class="page-footer">
            <?php if (!$isAuthPage): ?>
                <?php include APP_PATH . '/views/layout/footer.php'; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Enhanced JavaScript -->
    <script>
        // Modern Browser Detection and Progressive Enhancement
        (function() {
            'use strict';

            // Remove no-js class for progressive enhancement
            document.documentElement.classList.remove('no-js');
            document.documentElement.classList.add('js');

            // Global App Configuration
            window.App = {
                config: {
                    name: <?php echo json_encode($config['app_name']); ?>,
                    isLoggedIn: <?php echo $isLoggedIn ? 'true' : 'false'; ?>,
                    currentPath: <?php echo json_encode($currentPath); ?>,
                    isAuthPage: <?php echo $isAuthPage ? 'true' : 'false'; ?>,
                    isDashboardPage: <?php echo $isDashboardPage ? 'true' : 'false'; ?>,
                    csrf_token: <?php echo json_encode($_SESSION['csrf_token'] ?? ''); ?>
                },

                // Utility Functions
                utils: {
                    // Debounce function for performance
                    debounce: function(func, wait, immediate) {
                        let timeout;
                        return function executedFunction(...args) {
                            const later = () => {
                                timeout = null;
                                if (!immediate) func(...args);
                            };
                            const callNow = immediate && !timeout;
                            clearTimeout(timeout);
                            timeout = setTimeout(later, wait);
                            if (callNow) func(...args);
                        };
                    },

                    // Throttle function for scroll events
                    throttle: function(func, limit) {
                        let inThrottle;
                        return function(...args) {
                            if (!inThrottle) {
                                func.apply(this, args);
                                inThrottle = true;
                                setTimeout(() => inThrottle = false, limit);
                            }
                        };
                    },

                    // Safe DOM selector
                    $: function(selector) {
                        return document.querySelector(selector);
                    },

                    // Safe DOM selector all
                    $$: function(selector) {
                        return document.querySelectorAll(selector);
                    },

                    // Safe localStorage
                    storage: {
                        get: function(key) {
                            try {
                                return localStorage.getItem(key);
                            } catch (e) {
                                return null;
                            }
                        },
                        set: function(key, value) {
                            try {
                                localStorage.setItem(key, value);
                                return true;
                            } catch (e) {
                                return false;
                            }
                        }
                    }
                }
            };

            // Enhanced Mobile Menu Functionality
            function setupMobileMenu() {
                const mobileToggle = App.utils.$('.mobile-toggle, #mobileToggle');
                const mobileMenu = App.utils.$('.mobile-menu, #mobileMenu');

                if (!mobileToggle || !mobileMenu) return;

                function toggleMenu() {
                    const isActive = mobileMenu.classList.contains('active');
                    mobileMenu.classList.toggle('active', !isActive);
                    mobileToggle.classList.toggle('active', !isActive);

                    // Accessibility
                    mobileToggle.setAttribute('aria-expanded', !isActive);
                    mobileMenu.setAttribute('aria-hidden', isActive);

                    // Prevent body scroll when menu is open
                    document.body.style.overflow = !isActive ? 'hidden' : '';
                }

                mobileToggle.addEventListener('click', toggleMenu);

                // Close menu on outside click
                document.addEventListener('click', function(event) {
                    if (!mobileMenu.contains(event.target) && 
                        !mobileToggle.contains(event.target) &&
                        mobileMenu.classList.contains('active')) {
                        toggleMenu();
                    }
                });

                // Close menu on escape key
                document.addEventListener('keydown', function(event) {
                    if (event.key === 'Escape' && mobileMenu.classList.contains('active')) {
                        toggleMenu();
                        mobileToggle.focus();
                    }
                });

                // Close menu on window resize
                window.addEventListener('resize', App.utils.debounce(function() {
                    if (window.innerWidth > 768 && mobileMenu.classList.contains('active')) {
                        toggleMenu();
                    }
                }, 250));
            }

            // Enhanced Search Functionality
            function setupSearch() {
                const searchInputs = App.utils.$$('#headerSearchInput, #mobileSearchInput');
                const searchButtons = App.utils.$$('.search-btn');

                function performSearch(input) {
                    const query = input.value.trim();
                    if (!query) return;

                    // Add loading state
                    input.classList.add('loading');
                    searchButtons.forEach(btn => {
                        btn.disabled = true;
                        btn.innerHTML = '⏳';
                    });

                    // Redirect to search
                    window.location.href = `/search?q=${encodeURIComponent(query)}`;
                }

                searchInputs.forEach(input => {
                    input.addEventListener('keypress', function(event) {
                        if (event.key === 'Enter') {
                            event.preventDefault();
                            performSearch(this);
                        }
                    });
                });

                searchButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const input = this.parentElement.querySelector('.search-input, #headerSearchInput, #mobileSearchInput');
                        if (input) performSearch(input);
                    });
                });

                // Search keyboard shortcut (Ctrl/Cmd + K)
                document.addEventListener('keydown', function(event) {
                    if ((event.ctrlKey || event.metaKey) && event.key === 'k') {
                        event.preventDefault();
                        const headerSearch = App.utils.$('#headerSearchInput');
                        if (headerSearch) {
                            headerSearch.focus();
                            headerSearch.select();
                        }
                    }
                });
            }

            // Performance Monitoring
            function setupPerformanceMonitoring() {
                if ('performance' in window) {
                    window.addEventListener('load', function() {
                        setTimeout(function() {
                            const perfData = performance.timing;
                            const loadTime = perfData.loadEventEnd - perfData.navigationStart;

                            if (loadTime > 3000) {
                                console.warn(`Slow page load: ${loadTime}ms`);
                            }

                            // Report Core Web Vitals if available
                            if ('web-vital' in window) {
                                // Implementation would go here
                            }
                        }, 100);
                    });
                }
            }

            // Accessibility Enhancements
            function setupAccessibility() {
                // Focus management for dynamic content
                document.addEventListener('DOMContentLoaded', function() {
                    const skipLink = App.utils.$('.skip-link');
                    if (skipLink) {
                        skipLink.addEventListener('click', function(e) {
                            e.preventDefault();
                            const target = document.getElementById('main-content');
                            if (target) {
                                target.focus();
                                target.scrollIntoView({ behavior: 'smooth' });
                            }
                        });
                    }
                });

                // Enhanced keyboard navigation
                document.addEventListener('keydown', function(event) {
                    // Handle tab trapping in modals if needed
                    if (event.key === 'Tab') {
                        // Implementation for modal focus trapping would go here
                    }
                });
            }

            // Error Handling
            function setupErrorHandling() {
                window.addEventListener('error', function(event) {
                    console.error('JavaScript Error:', event.error);
                    // Could send to logging service here
                });

                window.addEventListener('unhandledrejection', function(event) {
                    console.error('Unhandled Promise Rejection:', event.reason);
                    // Could send to logging service here
                });
            }

            // Initialize All Functionality
            function init() {
                setupMobileMenu();
                setupSearch();
                setupPerformanceMonitoring();
                setupAccessibility();
                setupErrorHandling();

                // Legacy function support
                window.toggleMobileMenu = function() {
                    const toggle = App.utils.$('.mobile-toggle, #mobileToggle');
                    if (toggle) toggle.click();
                };

                window.performSearch = function() {
                    const input = App.utils.$('#headerSearchInput');
                    if (input) {
                        const event = new KeyboardEvent('keypress', { key: 'Enter' });
                        input.dispatchEvent(event);
                    }
                };

                window.handleSearchKeypress = function(event) {
                    if (event.key === 'Enter') {
                        performSearch(event.target);
                    }
                };

                window.performMobileSearch = function() {
                    const input = App.utils.$('#mobileSearchInput');
                    if (input) {
                        const event = new KeyboardEvent('keypress', { key: 'Enter' });
                        input.dispatchEvent(event);
                    }
                };
            }

            // Initialize when DOM is ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', init);
            } else {
                init();
            }
        })();
    </script>

    <!-- Page-Specific Scripts -->
    <?php if (isset($page_scripts)): ?>
        <?php foreach ((array)$page_scripts as $script): ?>
        <script src="<?php echo htmlspecialchars($script); ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Service Worker Registration -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js')
                    .then(function(registration) {
                        console.log('Service Worker registered successfully:', registration.scope);

                        // Check for updates
                        registration.addEventListener('updatefound', function() {
                            console.log('Service Worker update found');
                        });
                    })
                    .catch(function(error) {
                        console.warn('Service Worker registration failed (this is non-critical):', error.message);
                        // Don't throw or show errors to users - SW is optional enhancement
                    });
            });
        } else {
            console.log('Service Worker not supported in this browser');
        }
    </script>
</body>
</html>