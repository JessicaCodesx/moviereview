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

<script>
// Handle progress bar animations
document.addEventListener('DOMContentLoaded', function() {
    // Set progress bar widths from data attributes
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
});
</script>

<script src="/public/js/app.js"></script>