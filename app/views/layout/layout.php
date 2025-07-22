<?php
// Fixed layout file for app/views/layout/layout.php
if (!isset($config)) {
    $config = require CONFIG_PATH . '/app.php';
}
if (!isset($currentPath)) {
    $currentPath = $_SERVER['REQUEST_URI'] ?? '/';
}
$isLoggedIn = isset($_SESSION['user']) && !empty($_SESSION['user']['id']);
$isAuthPage = in_array($currentPath, ['/login', '/register']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $config['app_name']; ?><?php echo isset($page_title) ? ' - ' . htmlspecialchars($page_title) : ($currentPath !== '/' ? ' - ' . ucfirst(trim($currentPath, '/')) : ''); ?></title>

    <!-- Preload critical resources -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Meta tags -->
    <meta name="description" content="Discover, rate, and review your favorite movies. Track your watchlist and get personalized recommendations.">
    <meta name="keywords" content="movies, reviews, ratings, watchlist, recommendations">
    <meta name="author" content="Movie Review Hub">
    <link rel="icon" type="image/x-icon" href="/public/assets/images/favicon.ico">
    <meta name="theme-color" content="#6366f1">

    <!-- Critical CSS for immediate loading -->
    <style>
        /* Critical base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            font-size: 16px;
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            background-attachment: fixed;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            color: white;
            line-height: 1.6;
            overflow-x: hidden;
        }

        body.loaded {
            opacity: 1;
            transition: opacity 0.3s ease;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Ensure main content doesn't conflict with header styles */
        main {
            position: relative;
            z-index: 1;
        }

        /* Loading spinner for initial page load */
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
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }

        .page-loader.hidden {
            opacity: 0;
            visibility: hidden;
        }

        .loader-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top: 4px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Responsive container */
        @media (max-width: 768px) {
            .container {
                padding: 16px;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 12px;
            }
        }
    </style>

    <!-- Load main stylesheet after critical CSS -->
    <link rel="stylesheet" href="/public/css/style.css" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="/public/css/style.css"></noscript>
</head>
<body class="loading">
    <!-- Page loader -->
    <div class="page-loader" id="pageLoader">
        <div class="loader-spinner"></div>
    </div>

    <!-- Header Section -->
    <div class="container">
        <?php
        // Include the correct header based on authentication status
        if ($isLoggedIn) {
            // For authenticated users, include the main header
            include APP_PATH . '/views/layout/header.php';
        } else {
            // For non-authenticated users, include the public header
            include APP_PATH . '/views/layout/publicheader.php';
        }
        ?>
    </div>

    <!-- Main Content -->
    <main>
        <div class="container">
            <?php echo $content; ?>
        </div>
    </main>

    <!-- Footer Section -->
    <div class="container">
        <?php include APP_PATH . '/views/layout/footer.php'; ?>
    </div>

    <!-- Core JavaScript -->
    <script>
        // Page loading management
        document.addEventListener('DOMContentLoaded', function() {
            // Hide loader and show content
            setTimeout(() => {
                const loader = document.getElementById('pageLoader');
                const body = document.body;

                if (loader) {
                    loader.classList.add('hidden');
                }

                body.classList.remove('loading');
                body.classList.add('loaded');

                // Remove loader from DOM after animation
                setTimeout(() => {
                    if (loader && loader.parentNode) {
                        loader.parentNode.removeChild(loader);
                    }
                }, 500);
            }, 300);
        });

        // Enhanced error handling
        window.addEventListener('error', function(e) {
            console.error('Page error:', e.error);
        });

        // Improved mobile menu functionality
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            if (mobileMenu) {
                mobileMenu.classList.toggle('active');

                // Prevent body scroll when menu is open
                if (mobileMenu.classList.contains('active')) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
            }
        }

        // Close mobile menu on outside click
        document.addEventListener('click', function(event) {
            const mobileMenu = document.getElementById('mobileMenu');
            const mobileToggle = document.querySelector('.mobile-toggle');

            if (mobileMenu && mobileToggle && 
                !mobileMenu.contains(event.target) && 
                !mobileToggle.contains(event.target) &&
                mobileMenu.classList.contains('active')) {
                mobileMenu.classList.remove('active');
                document.body.style.overflow = '';
            }
        });

        // Close mobile menu on window resize
        window.addEventListener('resize', function() {
            const mobileMenu = document.getElementById('mobileMenu');
            if (window.innerWidth > 768 && mobileMenu && mobileMenu.classList.contains('active')) {
                mobileMenu.classList.remove('active');
                document.body.style.overflow = '';
            }
        });

        // Enhanced search functionality
        function handleSearchKeypress(event) {
            if (event.key === 'Enter') {
                performSearch();
            }
        }

        function performSearch() {
            const searchInput = document.getElementById('headerSearchInput') || document.getElementById('mobileSearchInput');
            if (searchInput && searchInput.value.trim()) {
                const query = searchInput.value.trim();
                console.log('Searching for:', query);

                // Show loading state
                const searchBtn = searchInput.parentNode.querySelector('.search-btn');
                if (searchBtn) {
                    const originalText = searchBtn.innerHTML;
                    searchBtn.innerHTML = '⏳';

                    // Simulate search - replace with actual search logic
                    setTimeout(() => {
                        searchBtn.innerHTML = originalText;
                        // window.location.href = '/search?q=' + encodeURIComponent(query);
                    }, 1000);
                }
            }
        }

        function performMobileSearch() {
            performSearch();
        }

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add scroll-based animations
        function handleScrollAnimations() {
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-visible');
                    }
                });
            }, observerOptions);

            // Observe elements with animation classes
            document.querySelectorAll('.animate-in, .scroll-reveal').forEach(el => {
                observer.observe(el);
            });
        }

        // Initialize animations when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', handleScrollAnimations);
        } else {
            handleScrollAnimations();
        }

        // Performance monitoring
        window.addEventListener('load', function() {
            // Log page load performance
            if (performance && performance.timing) {
                const loadTime = performance.timing.loadEventEnd - performance.timing.navigationStart;
                console.log('Page loaded in:', loadTime, 'ms');
            }
        });
    </script>

    <!-- Load non-critical JavaScript asynchronously -->
    <script src="/public/js/app.js" defer></script>
</body>
</html>