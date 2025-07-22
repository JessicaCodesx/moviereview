<?php
// app/views/pages/features.php
?>
<div class="features-container">
    <div class="features-hero">
        <div class="hero-content">
            <h1>🌟 Powerful Features</h1>
            <p class="hero-subtitle">Everything you need to discover, track, and enjoy movies</p>
        </div>
        <div class="hero-animation">
            <div class="floating-icons">
                <span class="float-icon" style="animation-delay: 0s;">🎬</span>
                <span class="float-icon" style="animation-delay: 2s;">⭐</span>
                <span class="float-icon" style="animation-delay: 4s;">🍿</span>
                <span class="float-icon" style="animation-delay: 6s;">🎭</span>
            </div>
        </div>
    </div>

    <div class="features-grid">
        <!-- Movie Discovery -->
        <div class="feature-card discover-card">
            <div class="feature-icon">
                <span>🔍</span>
            </div>
            <div class="feature-content">
                <h3>Smart Movie Discovery</h3>
                <p>Search through millions of movies with our powerful search engine. Find exactly what you're looking for with advanced filters and intelligent suggestions.</p>
                <ul class="feature-list">
                    <li>✨ Instant search results</li>
                    <li>📊 Advanced filtering options</li>
                    <li>🎯 Personalized suggestions</li>
                    <li>🌍 Global movie database</li>
                </ul>
            </div>
        </div>

        <!-- Rating System -->
        <div class="feature-card rating-card">
            <div class="feature-icon">
                <span>⭐</span>
            </div>
            <div class="feature-content">
                <h3>Rate & Review Movies</h3>
                <p>Share your opinion with our intuitive 5-star rating system. Help others discover great movies and build your personal movie profile.</p>
                <ul class="feature-list">
                    <li>🌟 Simple 5-star ratings</li>
                    <li>📝 Personal movie history</li>
                    <li>📈 Rating statistics</li>
                    <li>🎭 Genre preferences</li>
                </ul>
            </div>
        </div>

        <!-- AI Reviews -->
        <div class="feature-card ai-card">
            <div class="feature-icon">
                <span>🤖</span>
            </div>
            <div class="feature-content">
                <h3>AI-Generated Reviews</h3>
                <p>Get professional-quality movie reviews instantly with our AI system. Perfect for when you need a quick overview of any film.</p>
                <ul class="feature-list">
                    <li>🚀 Instant review generation</li>
                    <li>📖 Professional writing style</li>
                    <li>🎯 Balanced perspectives</li>
                    <li>💡 Insightful analysis</li>
                </ul>
            </div>
        </div>

        <!-- Watchlist -->
        <div class="feature-card watchlist-card">
            <div class="feature-icon">
                <span>📝</span>
            </div>
            <div class="feature-content">
                <h3>Personal Watchlist</h3>
                <p>Never forget a movie recommendation again. Build and manage your personal watchlist with easy organization and tracking tools.</p>
                <ul class="feature-list">
                    <li>📋 Unlimited movie lists</li>
                    <li>🏷️ Custom organization</li>
                    <li>⚡ Quick add/remove</li>
                    <li>📱 Mobile-friendly access</li>
                </ul>
            </div>
        </div>

        <!-- Progress Tracking -->
        <div class="feature-card tracking-card">
            <div class="feature-icon">
                <span>✅</span>
            </div>
            <div class="feature-content">
                <h3>Track Your Journey</h3>
                <p>Monitor your movie-watching progress with detailed statistics and achievements. See your viewing patterns and discover new preferences.</p>
                <ul class="feature-list">
                    <li>📊 Viewing statistics</li>
                    <li>🏆 Achievement system</li>
                    <li>📅 Watch history</li>
                    <li>🎨 Visual progress tracking</li>
                </ul>
            </div>
        </div>

        <!-- Social Features -->
        <div class="feature-card social-card">
            <div class="feature-icon">
                <span>👥</span>
            </div>
            <div class="feature-content">
                <h3>Community Features</h3>
                <p>Connect with fellow movie enthusiasts. Share recommendations, compare tastes, and discover movies through our community-driven features.</p>
                <ul class="feature-list">
                    <li>🌐 Community ratings</li>
                    <li>🔗 Share your profile</li>
                    <li>💬 Rating comparisons</li>
                    <li>🎪 Trending movies</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Pricing/CTA Section -->
    <div class="features-cta">
        <div class="cta-content">
            <h2>Ready to Start Your Movie Journey?</h2>
            <p>Join thousands of movie lovers who use Movie Review Hub to discover, track, and enjoy films.</p>
            <div class="cta-stats">
                <div class="stat-item">
                    <span class="stat-number">50K+</span>
                    <span class="stat-label">Happy Users</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">2M+</span>
                    <span class="stat-label">Movies Rated</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">100K+</span>
                    <span class="stat-label">Reviews Generated</span>
                </div>
            </div>
            <div class="cta-buttons">
                <?php if (!$isLoggedIn): ?>
                    <a href="/register" class="btn btn-primary btn-large">
                        <span>🚀</span>Get Started Free
                    </a>
                    <a href="/login" class="btn btn-secondary btn-large">
                        <span>🔑</span>Sign In
                    </a>
                <?php else: ?>
                    <a href="/dashboard" class="btn btn-primary btn-large">
                        <span>📊</span>Go to Dashboard
                    </a>
                    <a href="/" class="btn btn-secondary btn-large">
                        <span>🔍</span>Start Searching
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
.features-container {
    max-width: 1400px;
    margin: 0 auto;
}

.features-hero {
    text-align: center;
    padding: var(--space-16) var(--space-4);
    margin-bottom: var(--space-12);
    position: relative;
}

.hero-content h1 {
    font-size: clamp(2.5rem, 6vw, 4rem);
    font-weight: 900;
    color: white;
    margin-bottom: var(--space-4);
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.hero-subtitle {
    font-size: var(--font-size-xl);
    color: rgba(255,255,255,0.9);
    margin-bottom: var(--space-8);
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.floating-icons {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    pointer-events: none;
}

.float-icon {
    position: absolute;
    font-size: 2rem;
    opacity: 0.2;
    animation: floatAround 8s ease-in-out infinite;
}

.float-icon:nth-child(1) { top: 20%; left: 10%; }
.float-icon:nth-child(2) { top: 60%; right: 15%; }
.float-icon:nth-child(3) { top: 30%; left: 75%; }
.float-icon:nth-child(4) { bottom: 40%; right: 30%; }

@keyframes floatAround {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(180deg); }
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: var(--space-8);
    margin-bottom: var(--space-16);
}

.feature-card {
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(20px);
    border-radius: var(--radius-2xl);
    padding: var(--space-8);
    box-shadow: var(--shadow-2xl);
    border: 1px solid rgba(255,255,255,0.2);
    transition: var(--transition-base);
    position: relative;
    overflow: hidden;
}

.feature-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-primary);
}

.feature-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-2xl), 0 25px 50px rgba(99, 102, 241, 0.15);
}

.feature-icon {
    width: 80px;
    height: 80px;
    background: var(--gradient-primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: var(--space-6);
    font-size: 2rem;
    box-shadow: var(--shadow-lg);
}

.feature-content h3 {
    font-size: var(--font-size-2xl);
    font-weight: 800;
    color: var(--neutral-800);
    margin-bottom: var(--space-4);
}

.feature-content p {
    color: var(--neutral-600);
    font-size: var(--font-size-base);
    line-height: 1.7;
    margin-bottom: var(--space-6);
}

.feature-list {
    list-style: none;
    padding: 0;
}

.feature-list li {
    padding: var(--space-2) 0;
    color: var(--neutral-700);
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: var(--space-2);
}

.features-cta {
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(20px);
    border-radius: var(--radius-2xl);
    padding: var(--space-16) var(--space-8);
    text-align: center;
    box-shadow: var(--shadow-2xl);
    border: 1px solid rgba(255,255,255,0.2);
    position: relative;
    overflow: hidden;
}

.features-cta::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-primary);
}

.cta-content h2 {
    font-size: var(--font-size-4xl);
    font-weight: 900;
    color: var(--neutral-800);
    margin-bottom: var(--space-4);
}

.cta-content p {
    font-size: var(--font-size-lg);
    color: var(--neutral-600);
    margin-bottom: var(--space-8);
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.cta-stats {
    display: flex;
    justify-content: center;
    gap: var(--space-12);
    margin-bottom: var(--space-8);
    flex-wrap: wrap;
}

.stat-item {
    text-align: center;
}

.stat-number {
    display: block;
    font-size: var(--font-size-4xl);
    font-weight: 900;
    color: var(--primary-600);
    margin-bottom: var(--space-1);
}

.stat-label {
    font-size: var(--font-size-sm);
    color: var(--neutral-600);
    font-weight: 600;
}

.cta-buttons {
    display: flex;
    justify-content: center;
    gap: var(--space-4);
    flex-wrap: wrap;
}

.btn-large {
    padding: var(--space-4) var(--space-8);
    font-size: var(--font-size-lg);
    font-weight: 800;
}

@media (max-width: 768px) {
    .features-grid {
        grid-template-columns: 1fr;
        gap: var(--space-6);
    }

    .feature-card {
        padding: var(--space-6);
    }

    .features-cta {
        padding: var(--space-12) var(--space-6);
    }

    .cta-stats {
        gap: var(--space-6);
    }

    .cta-buttons {
        flex-direction: column;
        align-items: center;
    }

    .btn-large {
        width: 100%;
        max-width: 300px;
    }
}
</style>