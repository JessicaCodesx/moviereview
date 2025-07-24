<?php
// Professional Regal Authenticated User Header - Full Width Design
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
    <meta name="theme-color" content="#1a1f3a">

    <!-- Professional Regal Header CSS -->
    <style>
        /* CRITICAL: Inline essential styles for immediate rendering */
        * {
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Inter', sans-serif !important;
            background: linear-gradient(135deg, #0f1419 0%, #1a1f3a 50%, #0f1419 100%) !important;
            min-height: 100vh !important;
            margin: 0 !important;
            padding: 0 !important;
            padding-top: 96px !important; /* Account for fixed header */
            color: white !important;
            line-height: 1.6 !important;
            transform: translate3d(0, 0, 0) !important;
        }

        .container {
            max-width: 1400px !important;
            margin: 0 auto !important;
            padding: 20px !important;
        }

        /* Professional Regal Header Wrapper */
        .regal-auth-header-wrapper {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            z-index: 1000 !important;
            background: linear-gradient(135deg, #0f1419 0%, #1a1f3a 50%, #0f1419 100%) !important;
            backdrop-filter: blur(25px) saturate(200%) !important;
            border-bottom: 2px solid rgba(218, 165, 32, 0.6) !important;
            box-shadow: 
                0 4px 30px rgba(15, 20, 25, 0.6),
                0 1px 0 rgba(218, 165, 32, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.1) !important;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1) !important;
        }

        .regal-auth-header-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(218, 165, 32, 0.8), transparent);
        }

        .regal-auth-header {
            max-width: 1400px !important;
            margin: 0 auto !important;
            display: grid !important;
            grid-template-columns: auto 1fr auto !important;
            gap: 40px !important;
            align-items: center !important;
            padding: 18px 32px !important;
            min-height: 80px !important;
            position: relative !important;
            transform: translate3d(0, 0, 0) !important;
        }

        .regal-auth-header::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 2px;
            background: linear-gradient(90deg, transparent, #daa520, transparent);
            border-radius: 1px;
        }

        /* Brand Section */
        .header-brand {
            display: flex !important;
            align-items: center !important;
            gap: 16px !important;
            position: relative !important;
        }

        .brand-link {
            display: flex !important;
            align-items: center !important;
            gap: 14px !important;
            text-decoration: none !important;
            color: #daa520 !important;
            font-size: 1.75rem !important;
            font-weight: 800 !important;
            letter-spacing: -0.02em !important;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1) !important;
            text-shadow: 
                0 2px 4px rgba(0, 0, 0, 0.4),
                0 0 20px rgba(218, 165, 32, 0.3) !important;
            position: relative !important;
            transform: translate3d(0, 0, 0) !important;
        }

        .brand-link::before {
            content: '';
            position: absolute;
            top: -8px;
            left: -8px;
            right: -8px;
            bottom: -8px;
            background: radial-gradient(circle at center, rgba(218, 165, 32, 0.1), transparent);
            border-radius: 12px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .brand-link:hover::before {
            opacity: 1;
        }

        .brand-link:hover {
            transform: scale(1.03) !important;
            color: #f4d03f !important;
            text-shadow: 
                0 4px 8px rgba(0, 0, 0, 0.5),
                0 0 30px rgba(218, 165, 32, 0.5) !important;
        }

        .brand-icon {
            font-size: 2.2rem !important;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3)) !important;
            animation: crownFloat 6s ease-in-out infinite !important;
        }

        @keyframes crownFloat {
            0%, 100% { 
                transform: translateY(0px) rotate(0deg); 
                filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
            }
            50% { 
                transform: translateY(-4px) rotate(1deg); 
                filter: drop-shadow(0 6px 12px rgba(218, 165, 32, 0.4));
            }
        }

        /* Professional Search Section */
        .header-search {
            display: flex !important;
            align-items: center !important;
            background: rgba(26, 31, 58, 0.6) !important;
            border: 2px solid rgba(218, 165, 32, 0.3) !important;
            border-radius: 25px !important;
            padding: 6px !important;
            backdrop-filter: blur(15px) !important;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1) !important;
            min-width: 350px !important;
            max-width: 450px !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2) !important;
        }

        .header-search:focus-within {
            background: rgba(26, 31, 58, 0.8) !important;
            border-color: #daa520 !important;
            box-shadow: 
                0 0 0 4px rgba(218, 165, 32, 0.2),
                0 8px 25px rgba(218, 165, 32, 0.3) !important;
            transform: translateY(-2px) !important;
        }

        .search-input {
            border: none !important;
            background: transparent !important;
            padding: 12px 20px !important;
            font-size: 1rem !important;
            color: white !important;
            font-weight: 500 !important;
            width: 100% !important;
            transition: all 0.3s ease !important;
            outline: none !important;
        }

        .search-input::placeholder {
            color: rgba(255, 255, 255, 0.7) !important;
            font-weight: 400 !important;
        }

        .search-btn {
            background: linear-gradient(135deg, #daa520, #f4d03f) !important;
            border: none !important;
            border-radius: 50% !important;
            width: 40px !important;
            height: 40px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: #1a1f3a !important;
            cursor: pointer !important;
            font-size: 1rem !important;
            font-weight: bold !important;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1) !important;
            transform: translate3d(0, 0, 0) !important;
            box-shadow: 
                0 2px 8px rgba(218, 165, 32, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.2) !important;
        }

        .search-btn:hover {
            transform: scale(1.1) translate3d(0, -1px, 0) !important;
            box-shadow: 
                0 8px 25px rgba(218, 165, 32, 0.5),
                inset 0 1px 0 rgba(255, 255, 255, 0.3) !important;
            background: linear-gradient(135deg, #f4d03f, #fff) !important;
        }

        /* Navigation & User Section */
        .header-actions {
            display: flex !important;
            align-items: center !important;
            gap: 24px !important;
        }

        .nav-links {
            display: flex !important;
            gap: 6px !important;
            align-items: center !important;
            padding: 8px !important;
            background: rgba(26, 31, 58, 0.6) !important;
            border-radius: 20px !important;
            border: 1px solid rgba(218, 165, 32, 0.2) !important;
            backdrop-filter: blur(15px) !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2) !important;
        }

        .nav-link {
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
            padding: 12px 18px !important;
            border-radius: 16px !important;
            text-decoration: none !important;
            color: rgba(255, 255, 255, 0.85) !important;
            font-weight: 600 !important;
            font-size: 0.95rem !important;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1) !important;
            position: relative !important;
            overflow: hidden !important;
            letter-spacing: 0.01em !important;
            transform: translate3d(0, 0, 0) !important;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, 
                transparent, 
                rgba(218, 165, 32, 0.15), 
                rgba(218, 165, 32, 0.25),
                rgba(218, 165, 32, 0.15), 
                transparent);
            transition: left 0.8s cubic-bezier(0.23, 1, 0.32, 1);
        }

        .nav-link:hover::before {
            left: 100%;
        }

        .nav-link:hover,
        .nav-link.active {
            background: linear-gradient(135deg, rgba(218, 165, 32, 0.9), rgba(244, 208, 63, 0.9)) !important;
            color: #1a1f3a !important;
            transform: translateY(-2px) !important;
            box-shadow: 
                0 8px 25px rgba(218, 165, 32, 0.4),
                0 2px 8px rgba(0, 0, 0, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.2) !important;
            text-shadow: none !important;
        }

        .nav-link.active {
            background: linear-gradient(135deg, #daa520, #f4d03f) !important;
            box-shadow: 
                0 6px 20px rgba(218, 165, 32, 0.5),
                inset 0 1px 0 rgba(255, 255, 255, 0.3),
                inset 0 -1px 0 rgba(0, 0, 0, 0.2) !important;
        }

        .nav-icon {
            font-size: 1.1rem !important;
            transition: transform 0.3s ease !important;
        }

        .nav-link:hover .nav-icon {
            transform: scale(1.1) !important;
        }

        /* Professional User Section */
        .user-section {
            position: relative !important;
        }

        .user-trigger {
            display: flex !important;
            align-items: center !important;
            gap: 14px !important;
            background: rgba(26, 31, 58, 0.6) !important;
            border: 2px solid rgba(218, 165, 32, 0.3) !important;
            border-radius: 25px !important;
            padding: 10px 20px !important;
            cursor: pointer !important;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1) !important;
            transform: translate3d(0, 0, 0) !important;
            text-decoration: none !important;
            backdrop-filter: blur(15px) !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2) !important;
            position: relative !important;
            overflow: hidden !important;
            border: none !important;
            background: transparent !important;
        }

        .user-trigger::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(218, 165, 32, 0.1), transparent);
            transition: left 0.6s ease;
        }

        .user-trigger:hover::before {
            left: 100%;
        }

        .user-trigger:hover {
            background: rgba(26, 31, 58, 0.8) !important;
            border-color: rgba(218, 165, 32, 0.6) !important;
            transform: translateY(-3px) !important;
            box-shadow: 
                0 12px 30px rgba(218, 165, 32, 0.3),
                0 4px 12px rgba(0, 0, 0, 0.2) !important;
        }

        .user-avatar {
            width: 36px !important;
            height: 36px !important;
            background: linear-gradient(135deg, #daa520, #f4d03f) !important;
            border-radius: 50% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: #1a1f3a !important;
            font-weight: 800 !important;
            font-size: 1rem !important;
            box-shadow: 
                0 2px 8px rgba(218, 165, 32, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.2) !important;
            border: 2px solid rgba(255, 255, 255, 0.1) !important;
        }

        .user-name {
            color: #daa520 !important;
            font-weight: 600 !important;
            font-size: 1rem !important;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3) !important;
        }

        .dropdown-icon {
            color: rgba(218, 165, 32, 0.7) !important;
            font-size: 0.8rem !important;
            transition: all 0.3s ease !important;
            margin-left: 4px !important;
        }

        .user-trigger:hover .dropdown-icon {
            color: #f4d03f !important;
            transform: translateY(1px) !important;
        }

        .user-trigger:hover .user-name {
            color: #f4d03f !important;
        }

        /* User Dropdown Menu */
        .user-dropdown {
            position: absolute !important;
            top: calc(100% + 10px) !important;
            right: 0 !important;
            background: linear-gradient(135deg, rgba(26, 31, 58, 0.98), rgba(15, 20, 25, 0.98)) !important;
            backdrop-filter: blur(25px) saturate(180%) !important;
            border: 2px solid rgba(218, 165, 32, 0.4) !important;
            border-radius: 18px !important;
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.5),
                0 8px 25px rgba(218, 165, 32, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.1) !important;
            min-width: 220px !important;
            z-index: 1001 !important;
            opacity: 0 !important;
            visibility: hidden !important;
            transform: translateY(-10px) scale(0.95) !important;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1) !important;
        }

        .user-dropdown::before {
            content: '';
            position: absolute;
            top: -8px;
            right: 24px;
            width: 16px;
            height: 16px;
            background: linear-gradient(135deg, rgba(26, 31, 58, 0.98), rgba(15, 20, 25, 0.98));
            border: 2px solid rgba(218, 165, 32, 0.4);
            border-bottom: none;
            border-right: none;
            transform: rotate(45deg);
            backdrop-filter: blur(25px);
        }

        .user-section:hover .user-dropdown,
        .user-dropdown:hover {
            opacity: 1 !important;
            visibility: visible !important;
            transform: translateY(0) scale(1) !important;
        }

        .dropdown-header {
            padding: 20px 20px 15px 20px !important;
            border-bottom: 1px solid rgba(218, 165, 32, 0.2) !important;
            text-align: center !important;
        }

        .dropdown-user-avatar {
            width: 48px !important;
            height: 48px !important;
            background: linear-gradient(135deg, #daa520, #f4d03f) !important;
            border-radius: 50% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: #1a1f3a !important;
            font-weight: 800 !important;
            font-size: 1.2rem !important;
            margin: 0 auto 12px auto !important;
            box-shadow: 
                0 4px 12px rgba(218, 165, 32, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.2) !important;
            border: 2px solid rgba(255, 255, 255, 0.1) !important;
        }

        .dropdown-user-name {
            color: #daa520 !important;
            font-weight: 700 !important;
            font-size: 1rem !important;
            margin-bottom: 5px !important;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3) !important;
        }

        .dropdown-user-role {
            color: rgba(255, 255, 255, 0.7) !important;
            font-size: 0.85rem !important;
            font-weight: 500 !important;
        }

        .dropdown-menu {
            padding: 8px !important;
        }

        .dropdown-item {
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
            padding: 12px 16px !important;
            border-radius: 12px !important;
            text-decoration: none !important;
            color: rgba(255, 255, 255, 0.85) !important;
            font-weight: 600 !important;
            font-size: 0.95rem !important;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1) !important;
            position: relative !important;
            overflow: hidden !important;
            border: none !important;
            background: transparent !important;
            width: 100% !important;
            cursor: pointer !important;
        }

        .dropdown-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(218, 165, 32, 0.1), transparent);
            transition: left 0.6s ease;
        }

        .dropdown-item:hover::before {
            left: 100%;
        }

        .dropdown-item:hover {
            background: rgba(218, 165, 32, 0.15) !important;
            color: #f4d03f !important;
            transform: translateX(4px) !important;
        }

        .dropdown-item-icon {
            font-size: 1.1rem !important;
            opacity: 0.8 !important;
            transition: all 0.3s ease !important;
        }

        .dropdown-item:hover .dropdown-item-icon {
            opacity: 1 !important;
            transform: scale(1.1) !important;
        }

        .dropdown-divider {
            height: 1px !important;
            background: linear-gradient(90deg, transparent, rgba(218, 165, 32, 0.3), transparent) !important;
            margin: 8px 12px !important;
            border: none !important;
        }

        .dropdown-item.danger {
            color: rgba(255, 107, 107, 0.9) !important;
        }

        .dropdown-item.danger:hover {
            background: rgba(255, 107, 107, 0.15) !important;
            color: #ff6b6b !important;
        }

        .dropdown-item.danger .dropdown-item-icon {
            color: rgba(255, 107, 107, 0.8) !important;
        }

        .dropdown-item.danger:hover .dropdown-item-icon {
            color: #ff6b6b !important;
        }

        /* Mobile Toggle */
        .mobile-toggle {
            display: none;
            background: rgba(26, 31, 58, 0.8);
            border: 2px solid rgba(218, 165, 32, 0.3);
            cursor: pointer;
            flex-direction: column;
            gap: 5px;
            padding: 12px;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
            backdrop-filter: blur(10px);
        }

        .mobile-toggle:hover {
            background: rgba(26, 31, 58, 0.9);
            border-color: rgba(218, 165, 32, 0.5);
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(218, 165, 32, 0.3);
        }

        .hamburger-line {
            width: 26px;
            height: 3px;
            background: #daa520;
            border-radius: 2px;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        }

        .mobile-toggle:hover .hamburger-line {
            background: #f4d03f;
            box-shadow: 0 2px 6px rgba(218, 165, 32, 0.4);
        }

        .mobile-toggle.active .hamburger-line:nth-child(1) {
            transform: rotate(45deg) translate(8px, 8px);
        }

        .mobile-toggle.active .hamburger-line:nth-child(2) {
            opacity: 0;
        }

        .mobile-toggle.active .hamburger-line:nth-child(3) {
            transform: rotate(-45deg) translate(8px, -8px);
        }

        /* Mobile Menu */
        .mobile-menu {
            display: none;
            grid-column: 1 / -1;
            margin-top: 24px;
            background: linear-gradient(135deg, rgba(26, 31, 58, 0.95), rgba(15, 20, 25, 0.95));
            backdrop-filter: blur(25px);
            border-radius: 20px;
            padding: 24px;
            box-shadow: 
                0 15px 35px rgba(0, 0, 0, 0.4),
                0 5px 15px rgba(0, 0, 0, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(218, 165, 32, 0.3);
            position: relative;
        }

        .mobile-menu::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 3px;
            background: linear-gradient(90deg, transparent, #daa520, transparent);
            border-radius: 2px;
        }

        .mobile-search {
            margin-bottom: 20px;
        }

        .mobile-nav {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 24px;
        }

        .mobile-nav .nav-link {
            width: 100%;
            justify-content: flex-start;
            padding: 16px 20px;
            border-radius: 14px;
            background: rgba(26, 31, 58, 0.5);
            border: 1px solid rgba(218, 165, 32, 0.2);
        }

        .mobile-user {
            padding-top: 20px;
            border-top: 1px solid rgba(218, 165, 32, 0.2);
        }

        .mobile-user .user-trigger {
            width: 100%;
            justify-content: center;
            padding: 16px 24px;
        }

        /* CRITICAL: Mobile Performance Optimization */
        @media (max-width: 1024px) {
            .regal-auth-header {
                padding: 16px 24px;
                gap: 32px;
            }

            .header-search {
                min-width: 300px;
                max-width: 350px;
            }

            .nav-links {
                gap: 4px;
            }

            .nav-link {
                padding: 10px 16px;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 768px) {
            /* Disable animations on mobile for better performance */
            .regal-auth-header {
                animation: none !important;
                grid-template-columns: auto auto auto !important;
                gap: 16px !important;
                padding: 14px 20px !important;
            }

            * {
                transition-duration: 0.1s !important;
            }

            .header-search,
            .nav-links {
                display: none !important;
            }

            .mobile-toggle {
                display: flex !important;
            }

            .brand-link {
                font-size: 1.5rem !important;
            }

            .brand-icon {
                font-size: 2rem !important;
                animation: none !important;
            }

            .user-trigger {
                padding: 8px 12px !important;
                gap: 10px !important;
            }

            .user-avatar {
                width: 32px !important;
                height: 32px !important;
                font-size: 0.9rem !important;
            }

            .user-name {
                font-size: 0.9rem !important;
            }

            body {
                padding-top: 88px !important;
            }
        }

        @media (max-width: 480px) {
            .regal-auth-header {
                padding: 12px 16px !important;
                gap: 12px !important;
            }

            .brand-link {
                font-size: 1.3rem !important;
            }

            .brand-icon {
                font-size: 1.8rem !important;
            }

            .user-name {
                display: none !important;
            }

            .dropdown-icon {
                display: none !important;
            }

            body {
                padding-top: 84px !important;
            }
        }

        /* Show mobile menu when active */
        .mobile-menu.active {
            display: block !important;
            animation: regalSlideDown 0.4s cubic-bezier(0.23, 1, 0.32, 1) !important;
        }

        @keyframes regalSlideDown {
            from {
                opacity: 0;
                transform: translateY(-20px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Elegant scroll effects */
        .regal-auth-header-wrapper.scrolled {
            background: linear-gradient(135deg, #0a0f14 0%, #151a2e 50%, #0a0f14 100%) !important;
            box-shadow: 
                0 6px 40px rgba(15, 20, 25, 0.8),
                0 1px 0 rgba(218, 165, 32, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.15) !important;
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

        /* Loading animation for brand */
        @keyframes brandGlow {
            0%, 100% { text-shadow: 0 2px 4px rgba(0, 0, 0, 0.4), 0 0 20px rgba(218, 165, 32, 0.3); }
            50% { text-shadow: 0 4px 8px rgba(0, 0, 0, 0.5), 0 0 40px rgba(218, 165, 32, 0.6); }
        }

        .brand-link.loading {
            animation: brandGlow 2s ease-in-out infinite;
        }
    </style>
</head>
<body class="loaded">
    <div class="regal-auth-header-wrapper" id="regalAuthHeader">
        <header class="regal-auth-header" role="banner">
            <!-- Brand Section -->
            <div class="header-brand">
                <a href="/dashboard" class="brand-link" id="brandLink" aria-label="<?php echo $config['app_name']; ?> - Dashboard">
                    <span class="brand-icon">👑</span>
                    <strong><?php echo htmlspecialchars($config['app_name']); ?></strong>
                </a>
            </div>

            <!-- Professional Search Section -->
            <div class="header-search">
                <input type="text" 
                       id="headerSearchInput" 
                       class="search-input"
                       placeholder="Search elite cinema collection..." 
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
                        <span class="nav-icon">🏛️</span>
                        <span>Dashboard</span>
                    </a>
                    <a href="/watchlist" 
                       class="nav-link <?php echo strpos($currentPath, '/watchlist') === 0 ? 'active' : ''; ?>" 
                       role="menuitem">
                        <span class="nav-icon">📜</span>
                        <span>Watchlist</span>
                    </a>
                    <a href="/watched" 
                       class="nav-link <?php echo strpos($currentPath, '/watched') === 0 ? 'active' : ''; ?>" 
                       role="menuitem">
                        <span class="nav-icon">✨</span>
                        <span>Watched</span>
                    </a>
                    <a href="/profile" 
                       class="nav-link <?php echo strpos($currentPath, '/profile') === 0 ? 'active' : ''; ?>" 
                       role="menuitem">
                        <span class="nav-icon">👤</span>
                        <span>Profile</span>
                    </a>
                    <a href="/settings" 
                       class="nav-link <?php echo strpos($currentPath, '/settings') === 0 ? 'active' : ''; ?>" 
                       role="menuitem">
                        <span class="nav-icon">⚙️</span>
                        <span>Settings</span>
                    </a>
                </nav>

                <!-- Elite User Menu -->
                <div class="user-section">
                    <button class="user-trigger" aria-label="User menu" onclick="toggleUserDropdown(event)">
                        <div class="user-avatar">
                            <?php echo strtoupper(substr($userName, 0, 1)); ?>
                        </div>
                        <span class="user-name"><?php echo htmlspecialchars($userName); ?></span>
                        <span class="dropdown-icon">▼</span>
                    </button>

                    <!-- User Dropdown Menu -->
                    <div class="user-dropdown" id="userDropdown">
                        <div class="dropdown-header">
                            <div class="dropdown-user-avatar">
                                <?php echo strtoupper(substr($userName, 0, 1)); ?>
                            </div>
                            <div class="dropdown-user-name"><?php echo htmlspecialchars($userName); ?></div>
                            <div class="dropdown-user-role">Elite Member</div>
                        </div>

                        <div class="dropdown-menu">
                            <a href="/profile" class="dropdown-item">
                                <span class="dropdown-item-icon">👤</span>
                                <span>My Profile</span>
                            </a>
                            <a href="/watchlist" class="dropdown-item">
                                <span class="dropdown-item-icon">📜</span>
                                <span>My Watchlist</span>
                            </a>
                            <a href="/watched" class="dropdown-item">
                                <span class="dropdown-item-icon">✨</span>
                                <span>Watched Movies</span>
                            </a>
                            <a href="/settings" class="dropdown-item">
                                <span class="dropdown-item-icon">⚙️</span>
                                <span>Settings</span>
                            </a>

                            <hr class="dropdown-divider">

                            <button onclick="signOut()" class="dropdown-item danger">
                                <span class="dropdown-item-icon">🚪</span>
                                <span>Sign Out</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu Toggle -->
                <button class="mobile-toggle" onclick="toggleMobileMenu()" aria-label="Toggle mobile menu" id="mobileToggle">
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
                               class="search-input" 
                               placeholder="Search elite cinema..." 
                               id="mobileSearchInput"
                               onkeypress="if(event.key==='Enter') performMobileSearch()">
                        <button class="search-btn" onclick="performMobileSearch()" aria-label="Search">
                            🔍
                        </button>
                    </div>
                </div>

                <!-- Mobile Navigation -->
                <nav class="mobile-nav" role="navigation" aria-label="Mobile navigation">
                    <a href="/dashboard" class="nav-link <?php echo strpos($currentPath, '/dashboard') === 0 ? 'active' : ''; ?>">
                        <span class="nav-icon">🏛️</span>Dashboard
                    </a>
                    <a href="/watchlist" class="nav-link <?php echo strpos($currentPath, '/watchlist') === 0 ? 'active' : ''; ?>">
                        <span class="nav-icon">📜</span>Watchlist
                    </a>
                    <a href="/watched" class="nav-link <?php echo strpos($currentPath, '/watched') === 0 ? 'active' : ''; ?>">
                        <span class="nav-icon">✨</span>Watched
                    </a>
                    <a href="/profile" class="nav-link <?php echo strpos($currentPath, '/profile') === 0 ? 'active' : ''; ?>">
                        <span class="nav-icon">👤</span>Profile
                    </a>
                    <a href="/settings" class="nav-link <?php echo strpos($currentPath, '/settings') === 0 ? 'active' : ''; ?>">
                        <span class="nav-icon">⚙️</span>Settings
                    </a>
                </nav>

                <!-- Mobile User -->
                <div class="mobile-user">
                    <a href="/profile" class="user-trigger">
                        <div class="user-avatar">
                            <?php echo strtoupper(substr($userName, 0, 1)); ?>
                        </div>
                        <span class="user-name"><?php echo htmlspecialchars($userName); ?></span>
                    </a>

                    <!-- Mobile Sign Out -->
                    <button onclick="signOut()" class="nav-link" style="color: rgba(255, 107, 107, 0.9); margin-top: 12px; border: 1px solid rgba(255, 107, 107, 0.3);">
                        <span class="nav-icon">🚪</span>Sign Out
                    </button>
                </div>
            </div>
        </header>
    </div>

    <div class="container">
        <!-- Enhanced Search Functionality -->
        <script>
            // Performance-optimized search functions
            let searchTimeout;

            function headerSearchMovies() {
                const query = document.getElementById('headerSearchInput').value.trim();
                if (!query) return;

                // Add loading effect to search button
                const searchBtn = document.querySelector('.search-btn');
                const originalText = searchBtn.innerHTML;
                searchBtn.innerHTML = '⏳';
                searchBtn.disabled = true;

                // Redirect to search results
                window.location.href = `/search?q=${encodeURIComponent(query)}`;

                // Reset button after a short delay (in case of errors)
                setTimeout(() => {
                    searchBtn.innerHTML = originalText;
                    searchBtn.disabled = false;
                }, 1000);
            }

            function performMobileSearch() {
                const mobileSearchInput = document.getElementById('mobileSearchInput');
                if (mobileSearchInput && mobileSearchInput.value.trim()) {
                    const query = mobileSearchInput.value.trim();
                    window.location.href = `/search?q=${encodeURIComponent(query)}`;
                }
            }

            // Enhanced mobile menu toggle with animations
            function toggleMobileMenu() {
                const mobileMenu = document.getElementById('mobileMenu');
                const mobileToggle = document.getElementById('mobileToggle');

                if (mobileMenu && mobileToggle) {
                    const isActive = mobileMenu.classList.contains('active');

                    if (isActive) {
                        mobileMenu.classList.remove('active');
                        mobileToggle.classList.remove('active');
                    } else {
                        mobileMenu.classList.add('active');
                        mobileToggle.classList.add('active');
                    }
                }
            }

            // User dropdown toggle functionality
            function toggleUserDropdown(event) {
                event.preventDefault();
                event.stopPropagation();

                const dropdown = document.getElementById('userDropdown');
                const isVisible = dropdown.style.opacity === '1' || dropdown.classList.contains('show');

                if (isVisible) {
                    dropdown.style.opacity = '0';
                    dropdown.style.visibility = 'hidden';
                    dropdown.style.transform = 'translateY(-10px) scale(0.95)';
                    dropdown.classList.remove('show');
                } else {
                    dropdown.style.opacity = '1';
                    dropdown.style.visibility = 'visible';
                    dropdown.style.transform = 'translateY(0) scale(1)';
                    dropdown.classList.add('show');
                }
            }

            // Sign out functionality
            async function signOut() {
                if (confirm('Are you sure you want to sign out?')) {
                    try {
                        // Show loading state
                        const signOutBtn = event.target.closest('.dropdown-item');
                        const originalText = signOutBtn.innerHTML;
                        signOutBtn.innerHTML = '<span class="dropdown-item-icon">⏳</span><span>Signing out...</span>';
                        signOutBtn.style.pointerEvents = 'none';

                        // Make logout request
                        const response = await fetch('/logout', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            credentials: 'same-origin'
                        });

                        if (response.ok) {
                            // Redirect to login page
                            window.location.href = '/login';
                        } else {
                            throw new Error('Logout failed');
                        }
                    } catch (error) {
                        console.error('Logout error:', error);
                        alert('Error signing out. Please try again.');

                        // Reset button
                        const signOutBtn = event.target.closest('.dropdown-item');
                        signOutBtn.innerHTML = '<span class="dropdown-item-icon">🚪</span><span>Sign Out</span>';
                        signOutBtn.style.pointerEvents = 'auto';
                    }
                }
            }

            // Debounced search suggestions
            function setupSearchSuggestions() {
                const searchInput = document.getElementById('headerSearchInput');
                if (!searchInput) return;

                searchInput.addEventListener('input', function(e) {
                    clearTimeout(searchTimeout);
                    const query = e.target.value.trim();

                    if (query.length >= 2) {
                        searchTimeout = setTimeout(() => {
                            // Show search suggestions if implemented
                            console.log('Elite search suggestions for:', query);
                        }, 300);
                    }
                });
            }

            // Enhanced scroll effects for regal header
            let lastScrollTop = 0;
            let isScrolling = false;

            function handleScroll() {
                if (!isScrolling) {
                    window.requestAnimationFrame(function() {
                        const st = window.pageYOffset || document.documentElement.scrollTop;
                        const header = document.getElementById('regalAuthHeader');

                        if (header) {
                            if (st > 50) {
                                header.classList.add('scrolled');
                            } else {
                                header.classList.remove('scrolled');
                            }
                        }

                        lastScrollTop = st <= 0 ? 0 : st;
                        isScrolling = false;
                    });
                }
                isScrolling = true;
            }

            // Initialize when DOM is ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', setupSearchSuggestions);
            } else {
                setupSearchSuggestions();
            }

            // Throttled scroll listener
            window.addEventListener('scroll', handleScroll, { passive: true });

            // Close mobile menu and user dropdown when clicking outside
            document.addEventListener('click', function(event) {
                const mobileMenu = document.getElementById('mobileMenu');
                const mobileToggle = document.getElementById('mobileToggle');
                const userDropdown = document.getElementById('userDropdown');
                const userSection = document.querySelector('.user-section');

                // Close mobile menu
                if (mobileMenu && mobileToggle && 
                    !mobileMenu.contains(event.target) && 
                    !mobileToggle.contains(event.target)) {
                    mobileMenu.classList.remove('active');
                    mobileToggle.classList.remove('active');
                }

                // Close user dropdown
                if (userDropdown && userSection && 
                    !userSection.contains(event.target)) {
                    userDropdown.style.opacity = '0';
                    userDropdown.style.visibility = 'hidden';
                    userDropdown.style.transform = 'translateY(-10px) scale(0.95)';
                    userDropdown.classList.remove('show');
                }
            });

            // Close mobile menu when window resizes to desktop
            window.addEventListener('resize', function() {
                const mobileMenu = document.getElementById('mobileMenu');
                const mobileToggle = document.getElementById('mobileToggle');

                if (window.innerWidth > 768 && mobileMenu && mobileToggle) {
                    mobileMenu.classList.remove('active');
                    mobileToggle.classList.remove('active');
                }
            });

            // Enhanced brand link interactions
            document.addEventListener('DOMContentLoaded', function() {
                const brandLink = document.getElementById('brandLink');

                if (brandLink) {
                    // Add loading effect on click
                    brandLink.addEventListener('click', function() {
                        this.classList.add('loading');
                        setTimeout(() => {
                            this.classList.remove('loading');
                        }, 1000);
                    });
                }

                // Add smooth transitions to all navigation links
                const navLinks = document.querySelectorAll('.nav-link');
                navLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        // Add ripple effect
                        const ripple = document.createElement('span');
                        const rect = this.getBoundingClientRect();
                        const size = Math.max(rect.width, rect.height);
                        const x = e.clientX - rect.left - size / 2;
                        const y = e.clientY - rect.top - size / 2;

                        ripple.style.cssText = `
                            position: absolute;
                            left: ${x}px;
                            top: ${y}px;
                            width: ${size}px;
                            height: ${size}px;
                            border-radius: 50%;
                            background: rgba(255, 255, 255, 0.3);
                            transform: scale(0);
                            animation: ripple 0.6s linear;
                            pointer-events: none;
                        `;

                        this.style.position = 'relative';
                        this.style.overflow = 'hidden';
                        this.appendChild(ripple);

                        setTimeout(() => {
                            ripple.remove();
                        }, 600);
                    });
                });
            });

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Close mobile menu with Escape key
                if (e.key === 'Escape') {
                    const mobileMenu = document.getElementById('mobileMenu');
                    const mobileToggle = document.getElementById('mobileToggle');

                    if (mobileMenu && mobileMenu.classList.contains('active')) {
                        mobileMenu.classList.remove('active');
                        mobileToggle.classList.remove('active');
                    }
                }

                // Search shortcut (Ctrl/Cmd + K)
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

            // Add CSS for ripple animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes ripple {
                    to {
                        transform: scale(4);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);

            // Performance optimization: Intersection Observer for animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const headerObserver = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animationPlayState = 'running';
                    } else {
                        entry.target.style.animationPlayState = 'paused';
                    }
                });
            }, observerOptions);

            // Observe animated elements
            document.addEventListener('DOMContentLoaded', function() {
                const animatedElements = document.querySelectorAll('.brand-icon');
                animatedElements.forEach(el => {
                    headerObserver.observe(el);
                });
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