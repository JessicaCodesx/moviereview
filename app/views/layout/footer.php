</div>
<footer class="regal-site-footer">
    <div class="footer-container">
        <!-- Main Footer Content -->
        <div class="footer-main">
            <div class="footer-grid">
                <!-- Brand Section -->
                <div class="footer-brand-section">
                    <h5 class="footer-brand-title">
                        <span class="footer-brand-icon">👑</span>
                        <?php echo htmlspecialchars($config['app_name'] ?? 'Movie Review Hub'); ?>
                    </h5>
                    <p class="footer-brand-description">
                        An exclusive platform for discerning cinema enthusiasts. Discover exceptional films, 
                        curate your personal collection, and join an elite community of movie connoisseurs.
                    </p>
                    <div class="footer-brand-accent"></div>
                </div>

                <!-- Quick Links -->
                <div class="footer-section">
                    <h6 class="footer-section-title">
                        <span class="section-title-icon">⚡</span>
                        Quick Navigation
                    </h6>
                    <nav class="footer-nav">
                        <?php if ($isLoggedIn): ?>
                            <a href="/dashboard" class="footer-link">
                                <span class="footer-link-icon">🏛️</span>
                                <span>Dashboard</span>
                            </a>
                            <a href="/watchlist" class="footer-link">
                                <span class="footer-link-icon">📜</span>
                                <span>Watchlist</span>
                            </a>
                            <a href="/watched" class="footer-link">
                                <span class="footer-link-icon">✨</span>
                                <span>Watched</span>
                            </a>
                            <a href="/profile" class="footer-link">
                                <span class="footer-link-icon">👤</span>
                                <span>Profile</span>
                            </a>
                            <a href="/about" class="footer-link">
                                <span class="footer-link-icon">📖</span>
                                <span>About</span>
                            </a>
                            <a href="/contact" class="footer-link">
                                <span class="footer-link-icon">📧</span>
                                <span>Contact</span>
                            </a>
                        <?php else: ?>
                            <a href="/" class="footer-link">
                                <span class="footer-link-icon">🏛️</span>
                                <span>Home</span>
                            </a>
                            <a href="/features" class="footer-link">
                                <span class="footer-link-icon">⭐</span>
                                <span>Features</span>
                            </a>
                            <a href="/about" class="footer-link">
                                <span class="footer-link-icon">📖</span>
                                <span>About</span>
                            </a>
                            <a href="/contact" class="footer-link">
                                <span class="footer-link-icon">📧</span>
                                <span>Contact</span>
                            </a>
                            <a href="/login" class="footer-link">
                                <span class="footer-link-icon">🔐</span>
                                <span>Sign In</span>
                            </a>
                            <a href="/register" class="footer-link">
                                <span class="footer-link-icon">👑</span>
                                <span>Join Elite</span>
                            </a>
                        <?php endif; ?>
                    </nav>
                </div>

                <!-- Academic Info -->
                <div class="footer-section">
                    <h6 class="footer-section-title">
                        <span class="section-title-icon">🎓</span>
                        Academic Project
                    </h6>
                    <div class="footer-info-list">
                        <div class="footer-info-item">
                            <span class="footer-info-icon">📚</span>
                            <div class="footer-info-content">
                                <span class="info-label">Course</span>
                                <span class="info-value">COSC 4806 - Web Development</span>
                            </div>
                        </div>
                        <div class="footer-info-item">
                            <span class="footer-info-icon">📅</span>
                            <div class="footer-info-content">
                                <span class="info-label">Term</span>
                                <span class="info-value">Summer 2025</span>
                            </div>
                        </div>
                        <div class="footer-info-item">
                            <span class="footer-info-icon">🎯</span>
                            <div class="footer-info-content">
                                <span class="info-label">Type</span>
                                <span class="info-value">Final Project</span>
                            </div>
                        </div>
                        <div class="footer-info-item">
                            <span class="footer-info-icon">💻</span>
                            <div class="footer-info-content">
                                <span class="info-label">Version</span>
                                <span class="info-value">1.0.0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tech Stack -->
                <div class="footer-section">
                    <h6 class="footer-section-title">
                        <span class="section-title-icon">⚙️</span>
                        Technology Stack
                    </h6>
                    <div class="tech-stack">
                        <div class="tech-category">
                            <span class="tech-category-label">Backend</span>
                            <div class="tech-tags">
                                <span class="tech-tag">PHP 8.2</span>
                                <span class="tech-tag">MySQL</span>
                                <span class="tech-tag">MVC Pattern</span>
                            </div>
                        </div>
                        <div class="tech-category">
                            <span class="tech-category-label">APIs & Integration</span>
                            <div class="tech-tags">
                                <span class="tech-tag">OMDB API</span>
                                <span class="tech-tag">Gemini AI</span>
                                <span class="tech-tag">JavaScript</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Divider -->
        <div class="footer-divider-section">
            <div class="footer-divider"></div>
            <div class="footer-divider-accent"></div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="footer-bottom-left">
                <div class="footer-copyright">
                    <span class="copyright-icon">©</span>
                    <?= date('Y') ?> <?php echo htmlspecialchars($config['app_name'] ?? 'Movie Review Hub'); ?>
                </div>
                <div class="footer-tagline">
                    Crafted with <span class="heart-icon">🤍</span> for COSC 4806
                </div>
            </div>

            <div class="footer-bottom-right">
                <div class="footer-badges">
                    <div class="footer-badge">
                        <span class="badge-icon">🔒</span>
                        <span>Secure Platform</span>
                    </div>
                    <div class="footer-badge">
                        <span class="badge-icon">🌍</span>
                        <span>API Powered</span>
                    </div>
                    <?php if ($isLoggedIn): ?>
                    <div class="footer-badge user-badge">
                        <span class="badge-icon">👋</span>
                        <span>Welcome, <?php echo htmlspecialchars($_SESSION['user']['username']); ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
.regal-site-footer {
    background: linear-gradient(135deg, #0f1419 0%, #1a1f3a 50%, #0f1419 100%);
    border-top: 2px solid rgba(218, 165, 32, 0.3);
    margin-top: 60px;
    position: relative;
    overflow: hidden;
    width: 100vw;
    left: 50%;
    right: 50%;
    margin-left: -50vw;
    margin-right: -50vw;
}

.page-footer {
        width: 100vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
        overflow-x: hidden;
}
    
.regal-site-footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(218, 165, 32, 0.8), transparent);
}

.regal-site-footer::after {
    content: '';
    position: absolute;
    top: -50px;
    left: 50%;
    transform: translateX(-50%);
    width: 200px;
    height: 100px;
    background: radial-gradient(ellipse at center, rgba(218, 165, 32, 0.1), transparent);
    pointer-events: none;
}

.footer-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 32px;
}

.footer-main {
    padding: 48px 0 40px;
}

.footer-grid {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1.2fr;
    gap: 48px;
    align-items: start;
}

/* Brand Section */
.footer-brand-section {
    position: relative;
}

.footer-brand-title {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 1.5rem;
    font-weight: 800;
    color: #daa520;
    margin-bottom: 16px;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.4);
    letter-spacing: -0.02em;
}

.footer-brand-icon {
    font-size: 1.8rem;
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
}

.footer-brand-description {
    color: rgba(255, 255, 255, 0.8);
    font-size: 1rem;
    line-height: 1.7;
    margin-bottom: 20px;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
}

.footer-brand-accent {
    width: 60px;
    height: 3px;
    background: linear-gradient(90deg, #daa520, #f4d03f);
    border-radius: 2px;
    box-shadow: 0 2px 8px rgba(218, 165, 32, 0.3);
}

/* Footer Sections */
.footer-section {
    position: relative;
}

.footer-section-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 1.1rem;
    font-weight: 700;
    color: #daa520;
    margin-bottom: 20px;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
    padding-bottom: 8px;
    border-bottom: 1px solid rgba(218, 165, 32, 0.2);
}

.section-title-icon {
    font-size: 1.2rem;
}

/* Footer Navigation */
.footer-nav {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.footer-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 16px;
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    border-radius: 10px;
    transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
    position: relative;
    overflow: hidden;
    font-weight: 500;
}

.footer-link::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(218, 165, 32, 0.1), transparent);
    transition: left 0.6s ease;
}

.footer-link:hover::before {
    left: 100%;
}

.footer-link:hover {
    color: #daa520;
    background: rgba(218, 165, 32, 0.08);
    transform: translateX(8px);
    box-shadow: 0 4px 12px rgba(218, 165, 32, 0.2);
}

.footer-link-icon {
    font-size: 1rem;
    transition: transform 0.3s ease;
}

.footer-link:hover .footer-link-icon {
    transform: scale(1.1);
}

/* Academic Info */
.footer-info-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.footer-info-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 8px 0;
}

.footer-info-icon {
    font-size: 1rem;
    color: #daa520;
    margin-top: 2px;
    flex-shrink: 0;
}

.footer-info-content {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.info-label {
    font-size: 0.85rem;
    color: rgba(255, 255, 255, 0.5);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.info-value {
    font-size: 0.95rem;
    color: rgba(255, 255, 255, 0.8);
    font-weight: 600;
}

/* Tech Stack */
.tech-stack {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.tech-category {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.tech-category-label {
    font-size: 0.85rem;
    color: rgba(255, 255, 255, 0.6);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.tech-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
}

.tech-tag {
    background: rgba(26, 31, 58, 0.8);
    color: #daa520;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    border: 1px solid rgba(218, 165, 32, 0.3);
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
}

.tech-tag:hover {
    background: rgba(218, 165, 32, 0.15);
    border-color: rgba(218, 165, 32, 0.5);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(218, 165, 32, 0.2);
}

/* Footer Divider */
.footer-divider-section {
    position: relative;
    padding: 0 0 24px;
}

.footer-divider {
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(218, 165, 32, 0.3), transparent);
    margin: 0 auto;
    width: 80%;
}

.footer-divider-accent {
    position: absolute;
    top: -1px;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 3px;
    background: linear-gradient(90deg, transparent, #daa520, transparent);
    border-radius: 2px;
}

/* Footer Bottom */
.footer-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 24px 0 32px;
    border-top: 1px solid rgba(218, 165, 32, 0.1);
}

.footer-bottom-left {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.footer-copyright {
    display: flex;
    align-items: center;
    gap: 8px;
    color: rgba(255, 255, 255, 0.7);
    font-weight: 600;
    font-size: 0.95rem;
}

.copyright-icon {
    color: #daa520;
    font-weight: bold;
}

.footer-tagline {
    display: flex;
    align-items: center;
    gap: 6px;
    color: rgba(255, 255, 255, 0.5);
    font-size: 0.9rem;
    font-weight: 500;
}

.heart-icon {
    color: #daa520;
    animation: heartbeat 2s ease-in-out infinite;
}

@keyframes heartbeat {
    0%, 50%, 100% { transform: scale(1); }
    25%, 75% { transform: scale(1.1); }
}

.footer-bottom-right {
    display: flex;
    align-items: center;
}

.footer-badges {
    display: flex;
    gap: 16px;
}

.footer-badge {
    display: flex;
    align-items: center;
    gap: 6px;
    background: rgba(26, 31, 58, 0.6);
    border: 1px solid rgba(218, 165, 32, 0.3);
    border-radius: 20px;
    padding: 8px 14px;
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
    font-size: 0.85rem;
    font-weight: 500;
    color: rgba(255, 255, 255, 0.8);
}

.footer-badge:hover {
    background: rgba(26, 31, 58, 0.8);
    border-color: rgba(218, 165, 32, 0.5);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(218, 165, 32, 0.2);
}

.badge-icon {
    color: #daa520;
    font-size: 0.9rem;
}

.user-badge {
    background: rgba(218, 165, 32, 0.15);
    border-color: rgba(218, 165, 32, 0.4);
    color: #daa520;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .footer-grid {
        grid-template-columns: 1fr 1fr;
        gap: 32px;
    }

    .footer-container {
        padding: 0 24px;
    }
}

@media (max-width: 768px) {
    .footer-grid {
        grid-template-columns: 1fr;
        gap: 32px;
    }

    .footer-main {
        padding: 32px 0 24px;
    }

    .footer-bottom {
        flex-direction: column;
        gap: 16px;
        align-items: center;
        text-align: center;
    }

    .footer-badges {
        flex-wrap: wrap;
        justify-content: center;
        gap: 8px;
    }

    .footer-container {
        padding: 0 20px;
    }
}

@media (max-width: 480px) {
    .footer-brand-title {
        font-size: 1.3rem;
    }

    .footer-section-title {
        font-size: 1rem;
    }

    .footer-brand-description {
        font-size: 0.95rem;
    }

    .tech-tags {
        gap: 4px;
    }

    .tech-tag {
        font-size: 0.8rem;
        padding: 5px 10px;
    }

    .footer-badge {
        font-size: 0.8rem;
        padding: 6px 12px;
    }

    .footer-container {
        padding: 0 16px;
    }
}

/* Performance Optimizations */
@media (prefers-reduced-motion: reduce) {
    *, *::before, *::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
}
</style>

<script>
// Enhanced footer interactions
document.addEventListener('DOMContentLoaded', function() {
    // Handle progress bar animations
    const progressElements = document.querySelectorAll('[data-progress]');
    progressElements.forEach(element => {
        const progress = element.getAttribute('data-progress');
        element.style.setProperty('--progress-width', progress + '%');
        element.style.width = progress + '%';
    });

    // Set animation delays from data attributes
    const animatedElements = document.querySelectorAll('[data-animation-delay]');
    animatedElements.forEach(element => {
        const delay = element.getAttribute('data-animation-delay');
        element.style.setProperty('--animation-delay', delay + 's');
        element.style.animationDelay = delay + 's';
    });

    // Add intersection observer for footer animations
    const footerObserver = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animationPlayState = 'running';
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });

    // Observe footer sections for scroll animations
    const footerSections = document.querySelectorAll('.footer-section, .footer-brand-section');
    footerSections.forEach(section => {
        section.style.opacity = '0.8';
        section.style.transform = 'translateY(20px)';
        section.style.transition = 'all 0.6s cubic-bezier(0.23, 1, 0.32, 1)';
        footerObserver.observe(section);
    });

    // Enhanced tech tag interactions
    const techTags = document.querySelectorAll('.tech-tag');
    techTags.forEach(tag => {
        tag.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px) scale(1.05)';
        });

        tag.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Add ripple effect to footer links
    const footerLinks = document.querySelectorAll('.footer-link');
    footerLinks.forEach(link => {
        link.addEventListener('click', function(e) {
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
                background: rgba(218, 165, 32, 0.3);
                transform: scale(0);
                animation: footerRipple 0.6s linear;
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

// Add CSS for footer ripple animation
const footerStyle = document.createElement('style');
footerStyle.textContent = `
    @keyframes footerRipple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
`;
document.head.appendChild(footerStyle);
</script>

<script src="/public/js/app.js"></script>