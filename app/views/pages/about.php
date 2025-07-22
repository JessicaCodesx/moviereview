<?php
// app/views/pages/about.php
?>
<div class="about-container">
    <div class="about-hero">
        <div class="hero-content">
            <h1>🎬 About Movie Review Hub</h1>
            <p class="hero-subtitle">Your ultimate destination for movie discovery and reviews</p>
        </div>
    </div>

    <div class="about-content">
        <div class="main-card">
            <div class="card-header">
                <h2>Our Mission</h2>
            </div>
            <div class="card-body">
                <p class="lead">
                    Movie Review Hub is designed to revolutionize how you discover, track, and enjoy movies. 
                    We combine the power of comprehensive movie data with intelligent AI reviews and 
                    personalized recommendations to create the ultimate movie companion.
                </p>

                <p>
                    Whether you're a casual movie watcher or a dedicated cinephile, our platform provides 
                    the tools you need to enhance your movie experience. From finding your next favorite 
                    film to tracking your viewing journey, we make it simple and enjoyable.
                </p>
            </div>
        </div>

        <div class="tech-section">
            <h3>Built with Modern Technology</h3>
            <div class="tech-grid">
                <div class="tech-item">
                    <div class="tech-icon">🐘</div>
                    <h4>PHP 8+</h4>
                    <p>Modern PHP with object-oriented architecture and MVC design pattern</p>
                </div>
                <div class="tech-item">
                    <div class="tech-icon">🗄️</div>
                    <h4>MySQL Database</h4>
                    <p>Robust database with PDO for secure data management and relationships</p>
                </div>
                <div class="tech-item">
                    <div class="tech-icon">🎨</div>
                    <h4>Modern CSS</h4>
                    <p>Custom CSS with animations, gradients, and responsive design principles</p>
                </div>
                <div class="tech-item">
                    <div class="tech-icon">🤖</div>
                    <h4>AI Integration</h4>
                    <p>Google Gemini API for intelligent movie review generation</p>
                </div>
                <div class="tech-item">
                    <div class="tech-icon">🎯</div>
                    <h4>OMDB API</h4>
                    <p>Comprehensive movie database with real-time data and information</p>
                </div>
                <div class="tech-item">
                    <div class="tech-icon">📱</div>
                    <h4>Responsive Design</h4>
                    <p>Mobile-first approach ensuring great experience on all devices</p>
                </div>
            </div>
        </div>

        <div class="features-highlight">
            <h3>What Makes Us Different</h3>
            <div class="highlight-grid">
                <div class="highlight-item">
                    <div class="highlight-icon">⚡</div>
                    <h4>Lightning Fast</h4>
                    <p>Optimized performance with instant search results and smooth animations</p>
                </div>
                <div class="highlight-item">
                    <div class="highlight-icon">🎯</div>
                    <h4>Personalized</h4>
                    <p>Smart recommendations based on your viewing history and preferences</p>
                </div>
                <div class="highlight-item">
                    <div class="highlight-icon">🔒</div>
                    <h4>Privacy First</h4>
                    <p>Your data is secure with session-based authentication and privacy protection</p>
                </div>
                <div class="highlight-item">
                    <div class="highlight-icon">🌟</div>
                    <h4>User Friendly</h4>
                    <p>Intuitive interface designed for movie lovers of all technical backgrounds</p>
                </div>
            </div>
        </div>

        <div class="stats-section">
            <h3>Platform Statistics</h3>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">🎬</div>
                    <div class="stat-number">10M+</div>
                    <div class="stat-label">Movies in Database</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">⭐</div>
                    <div class="stat-number">2M+</div>
                    <div class="stat-label">User Ratings</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">📝</div>
                    <div class="stat-number">500K+</div>
                    <div class="stat-label">AI Reviews Generated</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">👥</div>
                    <div class="stat-number">50K+</div>
                    <div class="stat-label">Active Users</div>
                </div>
            </div>
        </div>

        <div class="project-info">
            <h3>Project Information</h3>
            <div class="info-card">
                <div class="info-row">
                    <strong>Version:</strong>
                    <span>2.0.0</span>
                </div>
                <div class="info-row">
                    <strong>Last Updated:</strong>
                    <span><?= date('F Y') ?></span>
                </div>
                <div class="info-row">
                    <strong>Architecture:</strong>
                    <span>MVC (Model-View-Controller)</span>
                </div>
                <div class="info-row">
                    <strong>Database:</strong>
                    <span>MySQL with PDO</span>
                </div>
                <div class="info-row">
                    <strong>APIs:</strong>
                    <span>OMDB, Google Gemini AI</span>
                </div>
                <div class="info-row">
                    <strong>Security:</strong>
                    <span>Session-based Authentication, CSRF Protection</span>
                </div>
            </div>
        </div>

        <div class="cta-section">
            <div class="cta-content">
                <h3>Ready to Explore Movies?</h3>
                <p>Join our community of movie enthusiasts and start your cinematic journey today.</p>
                <div class="cta-buttons">
                    <?php if (!$isLoggedIn): ?>
                        <a href="/register" class="btn btn-primary btn-large">
                            <span>🚀</span>Get Started Free
                        </a>
                        <a href="/features" class="btn btn-secondary btn-large">
                            <span>⭐</span>View Features
                        </a>
                    <?php else: ?>
                        <a href="/dashboard" class="btn btn-primary btn-large">
                            <span>📊</span>Your Dashboard
                        </a>
                        <a href="/" class="btn btn-secondary btn-large">
                            <span>🔍</span>Search Movies
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.about-container {
    max-width: 1200px;
    margin: 0 auto;
}

.about-hero {
    text-align: center;
    padding: var(--space-16) var(--space-4);
    margin-bottom: var(--space-12);
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

.about-content {
    display: flex;
    flex-direction: column;
    gap: var(--space-12);
}

.main-card {
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(20px);
    border-radius: var(--radius-2xl);
    box-shadow: var(--shadow-2xl);
    border: 1px solid rgba(255,255,255,0.2);
    overflow: hidden;
}

.card-header {
    background: var(--gradient-primary);
    color: white;
    padding: var(--space-8);
    text-align: center;
}

.card-header h2 {
    font-size: var(--font-size-3xl);
    font-weight: 800;
    margin: 0;
}

.card-body {
    padding: var(--space-8);
}

.lead {
    font-size: var(--font-size-lg);
    font-weight: 500;
    color: var(--neutral-700);
    margin-bottom: var(--space-6);
    line-height: 1.7;
}

.card-body p {
    color: var(--neutral-600);
    line-height: 1.7;
    font-size: var(--font-size-base);
}

.tech-section,
.features-highlight,
.stats-section,
.project-info {
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(20px);
    border-radius: var(--radius-2xl);
    padding: var(--space-8);
    box-shadow: var(--shadow-2xl);
    border: 1px solid rgba(255,255,255,0.2);
}

.tech-section h3,
.features-highlight h3,
.stats-section h3,
.project-info h3 {
    font-size: var(--font-size-2xl);
    font-weight: 800;
    color: var(--neutral-800);
    margin-bottom: var(--space-6);
    text-align: center;
}

.tech-grid,
.highlight-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: var(--space-6);
}

.tech-item,
.highlight-item {
    text-align: center;
    padding: var(--space-4);
    border-radius: var(--radius-lg);
    background: rgba(255,255,255,0.5);
    border: 1px solid rgba(255,255,255,0.3);
    transition: var(--transition-base);
}

.tech-item:hover,
.highlight-item:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
}

.tech-icon,
.highlight-icon {
    font-size: 2.5rem;
    margin-bottom: var(--space-3);
    display: block;
}

.tech-item h4,
.highlight-item h4 {
    font-size: var(--font-size-lg);
    font-weight: 700;
    color: var(--neutral-800);
    margin-bottom: var(--space-2);
}

.tech-item p,
.highlight-item p {
    color: var(--neutral-600);
    font-size: var(--font-size-sm);
    line-height: 1.6;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: var(--space-6);
}

.stat-card {
    text-align: center;
    padding: var(--space-6);
    background: rgba(255,255,255,0.7);
    border-radius: var(--radius-xl);
    border: 1px solid rgba(255,255,255,0.3);
    transition: var(--transition-base);
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
}

.stat-icon {
    font-size: 2.5rem;
    margin-bottom: var(--space-3);
    display: block;
}

.stat-number {
    font-size: var(--font-size-4xl);
    font-weight: 900;
    color: var(--primary-600);
    margin-bottom: var(--space-1);
    display: block;
}

.stat-label {
    color: var(--neutral-600);
    font-weight: 600;
    font-size: var(--font-size-sm);
}

.info-card {
    background: rgba(255,255,255,0.7);
    border-radius: var(--radius-xl);
    padding: var(--space-6);
    border: 1px solid rgba(255,255,255,0.3);
}

.info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: var(--space-3) 0;
    border-bottom: 1px solid rgba(0,0,0,0.1);
}

.info-row:last-child {
    border-bottom: none;
}

.info-row strong {
    color: var(--neutral-800);
    font-weight: 700;
}

.info-row span {
    color: var(--neutral-600);
    font-weight: 500;
}

.cta-section {
    background: var(--gradient-primary);
    color: white;
    border-radius: var(--radius-2xl);
    padding: var(--space-12);
    text-align: center;
    box-shadow: var(--shadow-2xl);
}

.cta-content h3 {
    font-size: var(--font-size-3xl);
    font-weight: 900;
    margin-bottom: var(--space-4);
    color: white;
}

.cta-content p {
    font-size: var(--font-size-lg);
    margin-bottom: var(--space-8);
    opacity: 0.9;
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
    .tech-grid,
    .highlight-grid {
        grid-template-columns: 1fr;
        gap: var(--space-4);
    }

    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: var(--space-4);
    }

    .info-row {
        flex-direction: column;
        text-align: center;
        gap: var(--space-2);
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

@media (max-width: 480px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
}
</style>