</div>

<!-- Full-width footer outside any container -->
<footer style="background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%) !important; color: white; margin-top: 4rem; width: 100vw; position: relative; left: 50%; right: 50%; margin-left: -50vw; margin-right: -50vw;">
    <div style="max-width: 1200px; margin: 0 auto; padding: 2rem 1.5rem;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-bottom: 2rem;">
            <!-- Brand Section -->
            <div>
                <h5 style="color: white; font-weight: 700; margin-bottom: 1rem; display: flex; align-items: center;">
                    <span style="margin-right: 0.5rem; font-size: 1.25rem;">🎬</span>
                    Movie Review Hub
                </h5>
                <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.875rem; line-height: 1.6; margin: 0;">
                    Discover, rate, and review your favorite movies. Track your watchlist, get personalized recommendations, and join a community of movie enthusiasts.
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h6 style="color: white; font-weight: 600; margin-bottom: 1rem;">Quick Links</h6>
                <nav style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <?php if ($isLoggedIn): ?>
                        <a href="/" style="color: rgba(255, 255, 255, 0.8); text-decoration: none; font-size: 0.875rem; transition: all 0.3s ease; display: flex; align-items: center;">
                            <span style="margin-right: 0.5rem; width: 1rem;">🔍</span>Search Movies
                        </a>
                        <a href="/dashboard" style="color: rgba(255, 255, 255, 0.8); text-decoration: none; font-size: 0.875rem; transition: all 0.3s ease; display: flex; align-items: center;">
                            <span style="margin-right: 0.5rem; width: 1rem;">📊</span>Dashboard
                        </a>
                        <a href="/watchlist" style="color: rgba(255, 255, 255, 0.8); text-decoration: none; font-size: 0.875rem; transition: all 0.3s ease; display: flex; align-items: center;">
                            <span style="margin-right: 0.5rem; width: 1rem;">📝</span>My Watchlist
                        </a>
                        <a href="/watched" style="color: rgba(255, 255, 255, 0.8); text-decoration: none; font-size: 0.875rem; transition: all 0.3s ease; display: flex; align-items: center;">
                            <span style="margin-right: 0.5rem; width: 1rem;">✅</span>Watched Movies
                        </a>
                        <a href="/profile" style="color: rgba(255, 255, 255, 0.8); text-decoration: none; font-size: 0.875rem; transition: all 0.3s ease; display: flex; align-items: center;">
                            <span style="margin-right: 0.5rem; width: 1rem;">👤</span>Profile
                        </a>
                    <?php else: ?>
                        <a href="/" style="color: rgba(255, 255, 255, 0.8); text-decoration: none; font-size: 0.875rem; transition: all 0.3s ease; display: flex; align-items: center;">
                            <span style="margin-right: 0.5rem; width: 1rem;">🏠</span>Home
                        </a>
                        <a href="/login" style="color: rgba(255, 255, 255, 0.8); text-decoration: none; font-size: 0.875rem; transition: all 0.3s ease; display: flex; align-items: center;">
                            <span style="margin-right: 0.5rem; width: 1rem;">🔑</span>Login
                        </a>
                        <a href="/register" style="color: rgba(255, 255, 255, 0.8); text-decoration: none; font-size: 0.875rem; transition: all 0.3s ease; display: flex; align-items: center;">
                            <span style="margin-right: 0.5rem; width: 1rem;">👥</span>Sign Up
                        </a>
                    <?php endif; ?>
                </nav>
            </div>

            <!-- Academic Info -->
            <div>
                <h6 style="color: white; font-weight: 600; margin-bottom: 1rem;">Academic Project</h6>
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <div style="color: rgba(255, 255, 255, 0.8); font-size: 0.875rem; display: flex; align-items: center;">
                        <span style="margin-right: 0.5rem; width: 1rem;">🎓</span>
                        COSC 4806 - Web Development
                    </div>
                    <div style="color: rgba(255, 255, 255, 0.8); font-size: 0.875rem; display: flex; align-items: center;">
                        <span style="margin-right: 0.5rem; width: 1rem;">📅</span>
                        Summer 2025
                    </div>
                    <div style="color: rgba(255, 255, 255, 0.8); font-size: 0.875rem; display: flex; align-items: center;">
                        <span style="margin-right: 0.5rem; width: 1rem;">🎯</span>
                        Final Project
                    </div>
                    <div style="color: rgba(255, 255, 255, 0.8); font-size: 0.875rem; display: flex; align-items: center;">
                        <span style="margin-right: 0.5rem; width: 1rem;">💻</span>
                        Version 1.0.0
                    </div>
                </div>
            </div>

            <!-- Tech Stack & Features -->
            <div>
                <h6 style="color: white; font-weight: 600; margin-bottom: 1rem;">Built With</h6>
                <div style="display: flex; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 1rem;">
                    <span style="background: rgba(255, 255, 255, 0.15); color: white; padding: 0.25rem 0.75rem; border-radius: 1rem; font-size: 0.75rem; font-weight: 500;">PHP 8.2</span>
                    <span style="background: rgba(255, 255, 255, 0.15); color: white; padding: 0.25rem 0.75rem; border-radius: 1rem; font-size: 0.75rem; font-weight: 500;">MySQL</span>
                    <span style="background: rgba(255, 255, 255, 0.15); color: white; padding: 0.25rem 0.75rem; border-radius: 1rem; font-size: 0.75rem; font-weight: 500;">MVC Pattern</span>
                    <span style="background: rgba(255, 255, 255, 0.15); color: white; padding: 0.25rem 0.75rem; border-radius: 1rem; font-size: 0.75rem; font-weight: 500;">OMDB API</span>
                    <span style="background: rgba(255, 255, 255, 0.15); color: white; padding: 0.25rem 0.75rem; border-radius: 1rem; font-size: 0.75rem; font-weight: 500;">Gemini AI</span>
                    <span style="background: rgba(255, 255, 255, 0.15); color: white; padding: 0.25rem 0.75rem; border-radius: 1rem; font-size: 0.75rem; font-weight: 500;">JavaScript</span>
                </div>

                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <div style="color: rgba(255, 255, 255, 0.7); font-size: 0.75rem; display: flex; align-items: center;">
                        <span style="margin-right: 0.25rem;">⚡</span>
                        Real-time Movie Search
                    </div>
                    <div style="color: rgba(255, 255, 255, 0.7); font-size: 0.75rem; display: flex; align-items: center;">
                        <span style="margin-right: 0.25rem;">🤖</span>
                        AI-Generated Reviews
                    </div>
                    <div style="color: rgba(255, 255, 255, 0.7); font-size: 0.75rem; display: flex; align-items: center;">
                        <span style="margin-right: 0.25rem;">📱</span>
                        Mobile Responsive
                    </div>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <hr style="border: none; height: 1px; background: rgba(255, 255, 255, 0.2); margin: 2rem 0;">

        <!-- Bottom Section -->
        <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 1rem;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="color: rgba(255, 255, 255, 0.8); font-size: 0.875rem;">
                    &copy; <?= date('Y') ?> Movie Review Hub
                </div>
                <div style="color: rgba(255, 255, 255, 0.6); font-size: 0.875rem;">
                    Made with <span style="color: #ef4444;">❤️</span> for COSC 4806
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="color: rgba(255, 255, 255, 0.7); font-size: 0.875rem;">
                    <span style="margin-right: 0.25rem;">🔒</span>
                    Secure & Reliable
                </div>
                <div style="color: rgba(255, 255, 255, 0.7); font-size: 0.875rem;">
                    <span style="margin-right: 0.25rem;">🌍</span>
                    API Powered
                </div>
                <?php if ($isLoggedIn): ?>
                <div style="color: rgba(255, 255, 255, 0.7); font-size: 0.875rem;">
                    <span style="margin-right: 0.25rem;">👋</span>
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