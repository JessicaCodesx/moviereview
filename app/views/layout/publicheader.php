<?php
// Professional Public Header - Full Width Design
$config = require CONFIG_PATH . '/app.php';
$currentPath = $_SERVER['REQUEST_URI'] ?? '/';
$isAuthPage = in_array($currentPath, ['/login', '/register']);
?>

<style>
/* Professional Full-Width Public Header */
.public-header-wrapper {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    background: <?php echo $isAuthPage ? 'rgba(25, 35, 96, 0.95)' : 'rgba(25, 35, 96, 0.98)'; ?>;
    backdrop-filter: blur(20px) saturate(180%);
    border-bottom: 1px solid <?php echo $isAuthPage ? 'rgba(255, 215, 0, 0.3)' : 'rgba(255, 215, 0, 0.4)'; ?>;
    box-shadow: 0 2px 20px rgba(25, 35, 96, 0.3);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.public-header {
    max-width: 1400px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: auto 1fr auto;
    gap: 32px;
    align-items: center;
    padding: 16px 24px;
    min-height: 70px;
}

body {
    padding-top: 86px; /* Account for fixed header */
}

/* Brand Section */
.header-brand {
    display: flex;
    align-items: center;
    gap: 12px;
}

.brand-link {
    display: flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    color: <?php echo $isAuthPage ? '#FFD700' : '#FFD700'; ?>;
    font-size: 1.5rem;
    font-weight: 900;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.brand-link:hover {
    transform: scale(1.02);
    color: <?php echo $isAuthPage ? '#FFF8DC' : '#FFF8DC'; ?>;
    text-shadow: 0 4px 8px rgba(255, 215, 0, 0.3);
}

.brand-icon {
    font-size: 2rem;
    animation: brandFloat 4s ease-in-out infinite;
}

@keyframes brandFloat {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-3px) rotate(2deg); }
}

/* Search Section (for non-auth pages) */
.header-search {
    display: <?php echo $isAuthPage ? 'none' : 'flex'; ?>;
    align-items: center;
    background: rgba(255, 255, 255, 0.15);
    border: 2px solid rgba(255, 215, 0, 0.3);
    border-radius: 50px;
    padding: 12px 20px;
    gap: 12px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    min-width: 300px;
    max-width: 450px;
    width: 100%;
    backdrop-filter: blur(10px);
}

.header-search:focus-within {
    background: rgba(255, 255, 255, 0.25);
    border-color: #FFD700;
    box-shadow: 0 0 0 4px rgba(255, 215, 0, 0.2), 0 8px 25px rgba(255, 215, 0, 0.3);
    transform: translateY(-2px);
}

.search-input {
    background: none;
    border: none;
    outline: none;
    flex: 1;
    font-size: 1rem;
    color: white;
    font-weight: 500;
}

.search-input::placeholder {
    color: rgba(255, 255, 255, 0.7);
    font-weight: 400;
}

.search-btn {
    background: linear-gradient(135deg, #FFD700, #DAA520);
    border: none;
    border-radius: 50%;
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #192360;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    font-size: 1rem;
    font-weight: bold;
}

.search-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 8px 25px rgba(255, 215, 0, 0.5);
    background: linear-gradient(135deg, #FFF8DC, #FFD700);
}

/* Auth Page Header Info */
.auth-info {
    display: <?php echo $isAuthPage ? 'flex' : 'none'; ?>;
    align-items: center;
    gap: 12px;
    color: #FFD700;
    font-weight: 600;
    font-size: 1.1rem;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.auth-info-icon {
    font-size: 1.3rem;
}

/* Navigation & Actions */
.header-actions {
    display: flex;
    align-items: center;
    gap: 20px;
}

.nav-links {
    display: <?php echo $isAuthPage ? 'none' : 'flex'; ?>;
    gap: 4px;
    align-items: center;
}

.nav-link {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    border-radius: 14px;
    text-decoration: none;
    color: rgba(255, 255, 255, 0.9);
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.nav-link::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,215,0,0.2), transparent);
    transition: left 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.nav-link:hover::before {
    left: 100%;
}

.nav-link:hover,
.nav-link.active {
    background: linear-gradient(135deg, #FFD700, #DAA520);
    color: #192360;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255, 215, 0, 0.4);
}

.nav-icon {
    font-size: 1.1rem;
}

/* Auth Buttons */
.auth-buttons {
    display: flex;
    gap: 12px;
    align-items: center;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 20px;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 700;
    font-size: 0.95rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: none;
    cursor: pointer;
}

.btn-secondary {
    background: <?php echo $isAuthPage ? 'rgba(255, 215, 0, 0.15)' : 'rgba(255, 215, 0, 0.1)'; ?>;
    color: <?php echo $isAuthPage ? '#FFD700' : '#FFD700'; ?>;
    border: 2px solid <?php echo $isAuthPage ? 'rgba(255, 215, 0, 0.4)' : 'rgba(255, 215, 0, 0.3)'; ?>;
}

.btn-secondary:hover {
    background: <?php echo $isAuthPage ? 'rgba(255, 215, 0, 0.25)' : 'rgba(255, 215, 0, 0.2)'; ?>;
    transform: translateY(-2px);
    box-shadow: <?php echo $isAuthPage ? '0 8px 25px rgba(255, 215, 0, 0.3)' : '0 8px 25px rgba(255, 215, 0, 0.4)'; ?>;
}

.btn-primary {
    background: linear-gradient(135deg, #FFD700, #DAA520);
    color: #192360;
    box-shadow: 0 4px 15px rgba(255, 215, 0, 0.4);
    font-weight: 700;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255, 215, 0, 0.5);
    background: linear-gradient(135deg, #FFF8DC, #FFD700);
}

/* Mobile Menu Toggle */
.mobile-toggle {
    display: none;
    background: none;
    border: none;
    cursor: pointer;
    flex-direction: column;
    gap: 4px;
    padding: 8px;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.hamburger-line {
    width: 24px;
    height: 3px;
    background: <?php echo $isAuthPage ? '#FFD700' : '#FFD700'; ?>;
    border-radius: 2px;
    transition: all 0.3s ease;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
}

.mobile-toggle:hover .hamburger-line {
    background: <?php echo $isAuthPage ? '#FFF8DC' : '#FFF8DC'; ?>;
    box-shadow: 0 2px 4px rgba(255, 215, 0, 0.3);
}

/* Mobile Menu */
.mobile-menu {
    display: none;
    grid-column: 1 / -1;
    margin-top: 20px;
    background: rgba(25, 35, 96, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    border: 1px solid rgba(255, 215, 0, 0.2);
}

.mobile-search {
    margin-bottom: 20px;
}

.mobile-nav {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-bottom: 20px;
}

.mobile-nav .nav-link {
    width: 100%;
    justify-content: flex-start;
    padding: 12px 16px;
    border-radius: 12px;
}

.mobile-auth {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.mobile-auth .btn {
    width: 100%;
    justify-content: center;
}

/* Responsive Design */
@media (max-width: 768px) {
    .public-header {
        grid-template-columns: auto 1fr auto;
        padding: 12px 20px;
        margin-bottom: 20px;
        border-radius: 20px;
    }

    .header-search,
    .nav-links,
    .auth-buttons {
        display: none;
    }

    .mobile-toggle {
        display: flex;
    }

    .brand-link {
        font-size: 1.3rem;
    }

    .brand-icon {
        font-size: 1.8rem;
    }
}

@media (max-width: 480px) {
    .public-header {
        padding: 10px 16px;
        margin-bottom: 16px;
        border-radius: 16px;
    }

    .brand-link {
        font-size: 1.2rem;
    }

    .brand-icon {
        font-size: 1.6rem;
    }
}

/* Show mobile menu when active */
.mobile-menu.active {
    display: block;
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<div class="public-header-wrapper">
    <header class="public-header">
    <!-- Brand Section -->
    <div class="header-brand">
        <a href="/" class="brand-link">
            <span class="brand-icon">🎬</span>
            <span><?php echo htmlspecialchars($config['app_name']); ?></span>
        </a>
    </div>

    <!-- Search Section (only for non-auth pages) -->
    <?php if (!$isAuthPage): ?>
        <div class="header-search">
            <input type="text" 
                   class="search-input" 
                   placeholder="Search movies..." 
                   id="headerSearchInput"
                   onkeypress="handleSearchKeypress(event)">
            <button class="search-btn" onclick="performSearch()" aria-label="Search">
                🔍
            </button>
        </div>
    <?php else: ?>
        <!-- Auth Page Info -->
        <div class="auth-info">
            <span class="auth-info-icon">✨</span>
            <span>Join thousands of movie lovers</span>
        </div>
    <?php endif; ?>

    <!-- Navigation & Actions -->
    <div class="header-actions">
        <!-- Navigation Links (only for non-auth pages) -->
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
                           class="search-input" 
                           placeholder="Search movies..." 
                           id="mobileSearchInput"
                           onkeypress="handleSearchKeypress(event)">
                    <button class="search-btn" onclick="performMobileSearch()" aria-label="Search">
                        🔍
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation -->
            <nav class="mobile-nav" role="navigation" aria-label="Mobile navigation">
                <a href="/" class="nav-link <?php echo $currentPath === '/' ? 'active' : ''; ?>">
                    <span class="nav-icon">🏠</span>Home
                </a>
                <a href="/features" class="nav-link <?php echo $currentPath === '/features' ? 'active' : ''; ?>">
                    <span class="nav-icon">⭐</span>Features
                </a>
                <a href="/about" class="nav-link <?php echo $currentPath === '/about' ? 'active' : ''; ?>">
                    <span class="nav-icon">ℹ️</span>About
                </a>
                <a href="/contact" class="nav-link <?php echo $currentPath === '/contact' ? 'active' : ''; ?>">
                    <span class="nav-icon">✉️</span>Contact
                </a>
            </nav>

            <!-- Mobile Auth Buttons -->
            <div class="mobile-auth">
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
        </div>
    <?php endif; ?>
    </header>
</div>

<script>
// Mobile menu toggle
function toggleMobileMenu() {
    const mobileMenu = document.getElementById('mobileMenu');
    if (mobileMenu) {
        mobileMenu.classList.toggle('active');
    }
}

// Search functionality
function handleSearchKeypress(event) {
    if (event.key === 'Enter') {
        performSearch();
    }
}

function performSearch() {
    const searchInput = document.getElementById('headerSearchInput');
    if (searchInput && searchInput.value.trim()) {
        // Implement search functionality here
        console.log('Searching for:', searchInput.value.trim());
        // You can redirect to search results or trigger AJAX search
        // window.location.href = '/search?q=' + encodeURIComponent(searchInput.value.trim());
    }
}

function performMobileSearch() {
    const mobileSearchInput = document.getElementById('mobileSearchInput');
    if (mobileSearchInput && mobileSearchInput.value.trim()) {
        console.log('Mobile searching for:', mobileSearchInput.value.trim());
        // Implement mobile search functionality here
    }
}

// Close mobile menu when clicking outside
document.addEventListener('click', function(event) {
    const mobileMenu = document.getElementById('mobileMenu');
    const mobileToggle = document.querySelector('.mobile-toggle');

    if (mobileMenu && mobileToggle && 
        !mobileMenu.contains(event.target) && 
        !mobileToggle.contains(event.target)) {
        mobileMenu.classList.remove('active');
    }
});

// Close mobile menu when window resizes to desktop
window.addEventListener('resize', function() {
    const mobileMenu = document.getElementById('mobileMenu');
    if (window.innerWidth > 768 && mobileMenu) {
        mobileMenu.classList.remove('active');
    }
});
</script>