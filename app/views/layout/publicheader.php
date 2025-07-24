<?php
// Professional Regal Header - Full Width Design
$config = require CONFIG_PATH . '/app.php';
$currentPath = $_SERVER['REQUEST_URI'] ?? '/';
$isAuthPage = in_array($currentPath, ['/login', '/register']);
?>

<style>
/* Professional Regal Header Styles */
.regal-header-wrapper {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    background: <?php echo $isAuthPage ? 'linear-gradient(135deg, #1a1f3a 0%, #2d3561 50%, #1a1f3a 100%)' : 'linear-gradient(135deg, #0f1419 0%, #1a1f3a 50%, #0f1419 100%)'; ?>;
    backdrop-filter: blur(25px) saturate(200%);
    border-bottom: 2px solid <?php echo $isAuthPage ? 'rgba(218, 165, 32, 0.4)' : 'rgba(218, 165, 32, 0.6)'; ?>;
    box-shadow: 
        0 4px 30px rgba(15, 20, 25, 0.6),
        0 1px 0 rgba(218, 165, 32, 0.2),
        inset 0 1px 0 rgba(255, 255, 255, 0.1);
    transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
}

.regal-header-wrapper::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(218, 165, 32, 0.8), transparent);
}

.regal-header {
    max-width: 1400px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: auto 1fr auto;
    gap: 40px;
    align-items: center;
    padding: 18px 32px;
    min-height: 80px;
    position: relative;
}

.regal-header::after {
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

body {
    padding-top: 96px; /* Account for fixed header */
}

/* Brand Section */
.header-brand {
    display: flex;
    align-items: center;
    gap: 16px;
    position: relative;
}

.brand-link {
    display: flex;
    align-items: center;
    gap: 14px;
    text-decoration: none;
    color: #daa520;
    font-size: 1.75rem;
    font-weight: 800;
    letter-spacing: -0.02em;
    transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
    text-shadow: 
        0 2px 4px rgba(0, 0, 0, 0.4),
        0 0 20px rgba(218, 165, 32, 0.3);
    position: relative;
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
    transform: scale(1.03);
    color: #f4d03f;
    text-shadow: 
        0 4px 8px rgba(0, 0, 0, 0.5),
        0 0 30px rgba(218, 165, 32, 0.5);
}

.brand-icon {
    font-size: 2.2rem;
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
    animation: crownFloat 6s ease-in-out infinite;
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

/* Auth Page Info Section */
.auth-info {
    display: <?php echo $isAuthPage ? 'flex' : 'none'; ?>;
    align-items: center;
    gap: 12px;
    color: #daa520;
    font-weight: 600;
    font-size: 1.1rem;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.4);
    padding: 12px 24px;
    background: rgba(218, 165, 32, 0.1);
    border: 1px solid rgba(218, 165, 32, 0.2);
    border-radius: 25px;
    backdrop-filter: blur(10px);
}

.auth-info-icon {
    font-size: 1.4rem;
    animation: sparkle 3s ease-in-out infinite;
}

@keyframes sparkle {
    0%, 100% { transform: scale(1) rotate(0deg); opacity: 1; }
    50% { transform: scale(1.1) rotate(10deg); opacity: 0.8; }
}

/* Navigation & Actions */
.header-actions {
    display: flex;
    align-items: center;
    gap: 24px;
}

.nav-links {
    display: <?php echo $isAuthPage ? 'none' : 'flex'; ?>;
    gap: 6px;
    align-items: center;
    padding: 8px;
    background: rgba(26, 31, 58, 0.6);
    border-radius: 20px;
    border: 1px solid rgba(218, 165, 32, 0.2);
    backdrop-filter: blur(15px);
}

.nav-link {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 20px;
    border-radius: 16px;
    text-decoration: none;
    color: rgba(255, 255, 255, 0.85);
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
    position: relative;
    overflow: hidden;
    letter-spacing: 0.01em;
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
    background: linear-gradient(135deg, rgba(218, 165, 32, 0.9), rgba(244, 208, 63, 0.9));
    color: #1a1f3a;
    transform: translateY(-2px);
    box-shadow: 
        0 8px 25px rgba(218, 165, 32, 0.4),
        0 2px 8px rgba(0, 0, 0, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.2);
    text-shadow: none;
}

.nav-link.active {
    background: linear-gradient(135deg, #daa520, #f4d03f);
    box-shadow: 
        0 6px 20px rgba(218, 165, 32, 0.5),
        inset 0 1px 0 rgba(255, 255, 255, 0.3),
        inset 0 -1px 0 rgba(0, 0, 0, 0.2);
}

.nav-icon {
    font-size: 1.1rem;
    transition: transform 0.3s ease;
}

.nav-link:hover .nav-icon {
    transform: scale(1.1);
}

/* Auth Buttons */
.auth-buttons {
    display: flex;
    gap: 16px;
    align-items: center;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 14px 24px;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 700;
    font-size: 0.95rem;
    transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
    border: none;
    cursor: pointer;
    letter-spacing: 0.02em;
    position: relative;
    overflow: hidden;
}

.btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
    transition: left 0.6s ease;
}

.btn:hover::before {
    left: 100%;
}

.btn-secondary {
    background: <?php echo $isAuthPage ? 'rgba(218, 165, 32, 0.15)' : 'rgba(218, 165, 32, 0.12)'; ?>;
    color: <?php echo $isAuthPage ? '#daa520' : '#daa520'; ?>;
    border: 2px solid <?php echo $isAuthPage ? 'rgba(218, 165, 32, 0.4)' : 'rgba(218, 165, 32, 0.35)'; ?>;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
}

.btn-secondary:hover {
    background: <?php echo $isAuthPage ? 'rgba(218, 165, 32, 0.25)' : 'rgba(218, 165, 32, 0.22)'; ?>;
    border-color: rgba(218, 165, 32, 0.6);
    transform: translateY(-3px);
    box-shadow: 
        <?php echo $isAuthPage ? '0 10px 30px rgba(218, 165, 32, 0.3)' : '0 10px 30px rgba(218, 165, 32, 0.4)'; ?>,
        0 4px 12px rgba(0, 0, 0, 0.2);
    color: #f4d03f;
}

.btn-primary {
    background: linear-gradient(135deg, #daa520 0%, #f4d03f 50%, #daa520 100%);
    color: #1a1f3a;
    box-shadow: 
        0 6px 20px rgba(218, 165, 32, 0.4),
        inset 0 1px 0 rgba(255, 255, 255, 0.2),
        inset 0 -1px 0 rgba(0, 0, 0, 0.1);
    font-weight: 800;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}

.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 
        0 12px 35px rgba(218, 165, 32, 0.5),
        0 6px 15px rgba(0, 0, 0, 0.2),
        inset 0 1px 0 rgba(255, 255, 255, 0.3);
    background: linear-gradient(135deg, #f4d03f 0%, #fff 50%, #f4d03f 100%);
}

/* Mobile Menu Toggle */
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
    background: <?php echo $isAuthPage ? '#daa520' : '#daa520'; ?>;
    border-radius: 2px;
    transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
}

.mobile-toggle:hover .hamburger-line {
    background: <?php echo $isAuthPage ? '#f4d03f' : '#f4d03f'; ?>;
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

.mobile-auth {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.mobile-auth .btn {
    width: 100%;
    justify-content: center;
    padding: 16px 24px;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .regal-header {
        padding: 16px 24px;
        gap: 32px;
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
    .regal-header {
        grid-template-columns: auto 1fr auto;
        padding: 14px 20px;
        gap: 20px;
    }

    .nav-links,
    .auth-buttons {
        display: none;
    }

    .mobile-toggle {
        display: flex;
    }

    .brand-link {
        font-size: 1.5rem;
    }

    .brand-icon {
        font-size: 2rem;
    }

    body {
        padding-top: 88px;
    }
}

@media (max-width: 480px) {
    .regal-header {
        padding: 12px 16px;
        gap: 16px;
    }

    .brand-link {
        font-size: 1.3rem;
    }

    .brand-icon {
        font-size: 1.8rem;
    }

    .auth-info {
        font-size: 1rem;
        padding: 10px 18px;
    }

    body {
        padding-top: 84px;
    }
}

/* Show mobile menu when active */
.mobile-menu.active {
    display: block;
    animation: regalSlideDown 0.4s cubic-bezier(0.23, 1, 0.32, 1);
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
.regal-header-wrapper.scrolled {
    background: <?php echo $isAuthPage ? 'linear-gradient(135deg, #151a2e 0%, #252952 50%, #151a2e 100%)' : 'linear-gradient(135deg, #0a0f14 0%, #151a2e 50%, #0a0f14 100%)'; ?>;
    box-shadow: 
        0 6px 40px rgba(15, 20, 25, 0.8),
        0 1px 0 rgba(218, 165, 32, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.15);
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

<div class="regal-header-wrapper" id="regalHeader">
    <header class="regal-header">
        <!-- Brand Section -->
        <div class="header-brand">
            <a href="/" class="brand-link" id="brandLink">
                <span class="brand-icon">👑</span>
                <span><?php echo htmlspecialchars($config['app_name']); ?></span>
            </a>
        </div>

        <!-- Auth Page Info (only for auth pages) -->
        <?php if ($isAuthPage): ?>
            <div class="auth-info">
                <span class="auth-info-icon">✨</span>
                <span>Join an exclusive community of cinema enthusiasts</span>
            </div>
        <?php else: ?>
            <div style="display: flex; align-items: center;">
                <!-- This empty div maintains grid layout for non-auth pages -->
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
                        <span class="nav-icon">🏛️</span>
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
                        <span class="nav-icon">📖</span>
                        <span>About</span>
                    </a>
                    <a href="/contact" 
                       class="nav-link <?php echo $currentPath === '/contact' ? 'active' : ''; ?>" 
                       role="menuitem">
                        <span class="nav-icon">📧</span>
                        <span>Contact</span>
                    </a>
                </nav>
            <?php endif; ?>

            <!-- Auth Buttons -->
            <div class="auth-buttons">
                <?php if ($currentPath !== '/login'): ?>
                    <a href="/login" class="btn btn-secondary">
                        <span>🔐</span>Sign In
                    </a>
                <?php endif; ?>
                <?php if ($currentPath !== '/register'): ?>
                    <a href="/register" class="btn btn-primary">
                        <span>👑</span>Join Elite
                    </a>
                <?php endif; ?>
            </div>

            <!-- Mobile Menu Toggle -->
            <button class="mobile-toggle" onclick="toggleMobileMenu()" aria-label="Toggle mobile menu" id="mobileToggle">
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
            </button>
        </div>

        <!-- Mobile Menu -->
        <?php if (!$isAuthPage): ?>
            <div class="mobile-menu" id="mobileMenu">
                <!-- Mobile Navigation -->
                <nav class="mobile-nav" role="navigation" aria-label="Mobile navigation">
                    <a href="/" class="nav-link <?php echo $currentPath === '/' ? 'active' : ''; ?>">
                        <span class="nav-icon">🏛️</span>Home
                    </a>
                    <a href="/features" class="nav-link <?php echo $currentPath === '/features' ? 'active' : ''; ?>">
                        <span class="nav-icon">⭐</span>Features
                    </a>
                    <a href="/about" class="nav-link <?php echo $currentPath === '/about' ? 'active' : ''; ?>">
                        <span class="nav-icon">📖</span>About
                    </a>
                    <a href="/contact" class="nav-link <?php echo $currentPath === '/contact' ? 'active' : ''; ?>">
                        <span class="nav-icon">📧</span>Contact
                    </a>
                </nav>

                <!-- Mobile Auth Buttons -->
                <div class="mobile-auth">
                    <?php if ($currentPath !== '/login'): ?>
                        <a href="/login" class="btn btn-secondary">
                            <span>🔐</span>Sign In
                        </a>
                    <?php endif; ?>
                    <?php if ($currentPath !== '/register'): ?>
                        <a href="/register" class="btn btn-primary">
                            <span>👑</span>Join Elite
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </header>
</div>

<script>
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

// Enhanced scroll effects for regal header
let lastScrollTop = 0;
let isScrolling = false;

function handleScroll() {
    if (!isScrolling) {
        window.requestAnimationFrame(function() {
            const st = window.pageYOffset || document.documentElement.scrollTop;
            const header = document.getElementById('regalHeader');

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

// Throttled scroll listener
window.addEventListener('scroll', handleScroll, { passive: true });

// Close mobile menu when clicking outside
document.addEventListener('click', function(event) {
    const mobileMenu = document.getElementById('mobileMenu');
    const mobileToggle = document.getElementById('mobileToggle');

    if (mobileMenu && mobileToggle && 
        !mobileMenu.contains(event.target) && 
        !mobileToggle.contains(event.target)) {
        mobileMenu.classList.remove('active');
        mobileToggle.classList.remove('active');
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

        // Add hover sound effect simulation
        brandLink.addEventListener('mouseenter', function() {
            // You can add actual sound effects here if needed
            console.log('Royal entrance sound effect');
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

// Keyboard navigation support
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
});

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
    const animatedElements = document.querySelectorAll('.brand-icon, .auth-info-icon');
    animatedElements.forEach(el => {
        headerObserver.observe(el);
    });
});
</script>