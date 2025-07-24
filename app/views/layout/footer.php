</div>

<!-- Full-width footer outside any container -->
<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-grid">
            <!-- Brand Section -->
            <div>
                <h5 class="footer-brand-title">
                    <span class="footer-brand-icon">🎬</span>
                    Movie Review Hub
                </h5>
                <p class="footer-brand-description">
                    Discover, rate, and review your favorite movies. Track your watchlist, get personalized recommendations, and join a community of movie enthusiasts.
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h6 class="footer-section-title">Quick Links</h6>
                <nav class="footer-nav">
                    <?php if ($isLoggedIn): ?>
                        <a href="/" class="footer-link">
                            <span class="footer-link-icon">🔍</span>Search Movies
                        </a>
                        <a href="/dashboard" class="footer-link">
                            <span class="footer-link-icon">📊</span>Dashboard
                        </a>
                        <a href="/watchlist" class="footer-link">
                            <span class="footer-link-icon">📝</span>My Watchlist
                        </a>
                        <a href="/watched" class="footer-link">
                            <span class="footer-link-icon">✅</span>Watched Movies
                        </a>
                        <a href="/profile" class="footer-link">
                            <span class="footer-link-icon">👤</span>Profile
                        </a>
                    <?php else: ?>
                        <a href="/" class="footer-link">
                            <span class="footer-link-icon">🏠</span>Home
                        </a>
                        <a href="/login" class="footer-link">
                            <span class="footer-link-icon">🔑</span>Login
                        </a>
                        <a href="/register" class="footer-link">
                            <span class="footer-link-icon">👥</span>Sign Up
                        </a>
                    <?php endif; ?>
                </nav>
            </div>

            <!-- Academic Info -->
            <div>
                <h6 class="footer-section-title">Academic Project</h6>
                <div class="footer-info-list">
                    <div class="footer-info-item">
                        <span class="footer-link-icon">🎓</span>
                        COSC 4806 - Web Development
                    </div>
                    <div class="footer-info-item">
                        <span class="footer-link-icon">📅</span>
                        Summer 2025
                    </div>
                    <div class="footer-info-item">
                        <span class="footer-link-icon">🎯</span>
                        Final Project
                    </div>
                    <div class="footer-info-item">
                        <span class="footer-link-icon">💻</span>
                        Version 1.0.0
                    </div>
                </div>
            </div>

            <!-- Tech Stack & Features -->
            <div>
                <h6 class="footer-section-title">Built With</h6>
                <div class="tech-tags">
                    <span class="tech-tag">PHP 8.2</span>
                    <span class="tech-tag">MySQL</span>
                    <span class="tech-tag">MVC Pattern</span>
                    <span class="tech-tag">OMDB API</span>
                    <span class="tech-tag">Gemini AI</span>
                    <span class="tech-tag">JavaScript</span>
                </div>

                <div class="feature-list">
                    <div class="feature-item">
                        <span class="feature-icon">⚡</span>
                        Real-time Movie Search
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">🤖</span>
                        AI-Generated Reviews
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">📱</span>
                        Mobile Responsive
                    </div>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <hr class="footer-divider">

        <!-- Bottom Section -->
        <div class="footer-bottom">
            <div class="footer-bottom-left">
                <div class="footer-copyright">
                    &copy; <?= date('Y') ?> Movie Review Hub
                </div>
                <div class="footer-tagline">
                    Made with <span class="heart-icon">❤️</span> for COSC 4806
                </div>
            </div>

            <div class="footer-bottom-right">
                <div class="footer-info-item">
                    <span class="feature-icon">🔒</span>
                    Secure & Reliable
                </div>
                <div class="footer-info-item">
                    <span class="feature-icon">🌍</span>
                    API Powered
                </div>
                <?php if ($isLoggedIn): ?>
                <div class="footer-info-item">
                    <span class="feature-icon">👋</span>
                    Welcome, <?php echo htmlspecialchars($_SESSION['user']['username']); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</footer>

<!-- Add hover effects and responsive styles for footer -->
<style>
footer a:hover {
    color: white !important;
    text-decoration: underline !important;
    transform: translateX(2px);
}

footer a {
    transition: all 0.3s ease;
}

/* Responsive footer adjustments */
@media (max-width: 768px) {
    footer > div {
        padding: 1.5rem 1rem !important;
    }

    footer > div > div:first-child {
        grid-template-columns: 1fr !important;
        gap: 1.5rem !important;
    }

    footer > div > div:last-child {
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 1rem !important;
    }

    footer > div > div:last-child > div:last-child {
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 0.5rem !important;
    }

    footer h5, footer h6 {
        font-size: 1rem !important;
    }

    footer div[style*="gap: 0.5rem"] {
        gap: 0.25rem !important;
    }
}

@media (max-width: 480px) {
    footer > div {
        padding: 1rem !important;
    }

    footer h5 {
        font-size: 1.125rem !important;
    }

    footer h6 {
        font-size: 0.875rem !important;
    }

    footer p, footer a, footer div {
        font-size: 0.8125rem !important;
    }

    footer span[style*="border-radius: 1rem"] {
        font-size: 0.6875rem !important;
        padding: 0.1875rem 0.5rem !important;
    }
}
</style>

<script src="/public/js/app.js"></script>