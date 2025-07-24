<?php
$isLoggedIn = isset($_SESSION['user']) && !empty($_SESSION['user']['id']);
?>

<!-- Regal Hero Section -->
<div class="regal-hero-section">
    <div class="hero-background">
        <div class="hero-gradient"></div>
        <div class="hero-pattern"></div>
    </div>
    <div class="hero-content">
        <div class="hero-animation">
            <div class="hero-crown">👑</div>
            <div class="floating-elements">
                <span class="floating-element element-1">⭐</span>
                <span class="floating-element element-2">🎭</span>
                <span class="floating-element element-3">🎪</span>
                <span class="floating-element element-4">🎬</span>
                <span class="floating-element element-5">🍿</span>
            </div>
        </div>
        <div class="hero-text">
            <h1>Discover Cinematic Excellence</h1>
            <p>Your exclusive gateway to exceptional cinema. Curate, rate, and explore the finest films with our elite recommendation engine.</p>
        </div>
        <?php if (!$isLoggedIn): ?>
        <div class="hero-stats">
            <div class="stat-item">
                <span class="stat-number" data-count="10000">0</span>
                <span class="stat-label">Elite Films</span>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <span class="stat-number" data-count="5000">0</span>
                <span class="stat-label">Expert Reviews</span>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <span class="stat-number" data-count="1000">0</span>
                <span class="stat-label">Connoisseurs</span>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Professional Search Section -->
<div class="regal-search-section">
    <div class="search-container">
        <div class="search-header">
            <div class="search-icon-wrapper">
                <span class="search-icon">🔍</span>
            </div>
            <h2>Explore Our Cinematic Collection</h2>
            <p>Search through our curated library of exceptional films, acclaimed directors, and renowned performers</p>
        </div>
        <div class="search-box">
            <div class="search-input-wrapper">
                <div class="search-field">
                    <input type="text" 
                           id="searchInput" 
                           class="search-input" 
                           placeholder="Search for films, directors, or actors..." 
                           autocomplete="off" />
                    <button class="search-btn" aria-label="Search movies">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="21 21l-4.35-4.35"></path>
                        </svg>
                    </button>
                </div>
                <div class="search-enhancement"></div>
            </div>
            <div class="search-suggestions">
                <div class="suggestions-label">Popular Genres:</div>
                <div class="suggestion-tags">
                    <span class="suggestion-tag" onclick="searchSuggestion('Action')">
                        <span class="tag-icon">⚔️</span>Action
                    </span>
                    <span class="suggestion-tag" onclick="searchSuggestion('Comedy')">
                        <span class="tag-icon">😄</span>Comedy
                    </span>
                    <span class="suggestion-tag" onclick="searchSuggestion('Drama')">
                        <span class="tag-icon">🎭</span>Drama
                    </span>
                    <span class="suggestion-tag" onclick="searchSuggestion('Thriller')">
                        <span class="tag-icon">🔪</span>Thriller
                    </span>
                    <span class="suggestion-tag" onclick="searchSuggestion('Sci-Fi')">
                        <span class="tag-icon">🚀</span>Sci-Fi
                    </span>
                </div>
            </div>
        </div>

        <!-- Search Results Container -->
        <div id="searchResults" class="search-results"></div>
    </div>
</div>

<!-- Movie Details Container -->
<div id="movieDetails" class="movie-details"></div>

<?php if ($isLoggedIn && !empty($data['recent_ratings'])): ?>
<div class="regal-personalized-section">
    <div class="section-container">
        <div class="section-header">
            <div class="section-title">
                <div class="title-icon">🎬</div>
                <div class="title-content">
                    <h3>Your Recent Masterpieces</h3>
                    <p class="section-subtitle">Continue your cinematic journey</p>
                </div>
            </div>
            <a href="/profile" class="view-all-link">
                <span>View Collection</span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="9,18 15,12 9,6"></polyline>
                </svg>
            </a>
        </div>
        <div class="recent-ratings">
            <?php foreach (array_slice($data['recent_ratings'], 0, 5) as $index => $rating): ?>
                <div class="rating-card regal-card" 
                     data-animation-delay="<?php echo $index * 0.1; ?>"
                     onclick="movieAppInstance.loadMovieDetails('<?php echo htmlspecialchars($rating['imdb_id']); ?>')">
                    <div class="rating-poster">
                        <img src="<?php echo $rating['poster'] !== 'N/A' ? htmlspecialchars($rating['poster']) : '/public/assets/images/no-image.png'; ?>" 
                             alt="<?php echo htmlspecialchars($rating['title']); ?>"
                             onerror="this.src='/public/assets/images/no-image.png'"
                             loading="lazy">
                        <div class="rating-overlay">
                            <button class="play-button">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <polygon points="5,3 19,12 5,21"></polygon>
                                </svg>
                            </button>
                        </div>
                        <div class="rating-badge-container">
                            <span class="rating-badge">⭐ <?php echo (int)$rating['rating']; ?></span>
                        </div>
                        <div class="regal-frame"></div>
                    </div>
                    <div class="rating-info">
                        <h4><?php echo htmlspecialchars($rating['title']); ?></h4>
                        <p><?php echo htmlspecialchars($rating['year']); ?> • <?php echo htmlspecialchars(substr($rating['genre'] ?? 'Classic', 0, 15)); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if (!$isLoggedIn || (!empty($data['popular_movies']) && empty($data['recent_ratings']))): ?>
<div class="regal-popular-section">
    <div class="section-container">
        <div class="section-header">
            <div class="section-title">
                <div class="title-icon">⭐</div>
                <div class="title-content">
                    <h3>Acclaimed Cinema</h3>
                    <p class="section-subtitle">
                        <?php if (!$isLoggedIn): ?>
                            Films celebrated by our distinguished community • <a href="/register" class="signup-link">Join our elite circle</a> for personalized curation!
                        <?php else: ?>
                            Discover what's captivating our community of connoisseurs
                        <?php endif; ?>
                    </p>
                </div>
            </div>
            <div class="section-actions">
                <button class="category-btn active" data-category="all">All</button>
                <button class="category-btn" data-category="action">Action</button>
                <button class="category-btn" data-category="comedy">Comedy</button>
                <button class="category-btn" data-category="drama">Drama</button>
            </div>
        </div>
        <?php if (!empty($data['popular_movies'])): ?>
            <div class="popular-movies">
                <?php foreach ($data['popular_movies'] as $index => $movie): ?>
                    <div class="movie-card regal-movie-card" 
                         data-animation-delay="<?php echo $index * 0.1; ?>"
                         onclick="movieAppInstance.loadMovieDetails('<?php echo htmlspecialchars($movie['imdb_id']); ?>')">
                        <div class="movie-poster">
                            <img src="<?php echo $movie['poster'] !== 'N/A' ? htmlspecialchars($movie['poster']) : '/public/assets/images/no-image.png'; ?>" 
                                 alt="<?php echo htmlspecialchars($movie['title']); ?>"
                                 onerror="this.src='/public/assets/images/no-image.png'"
                                 loading="lazy">
                            <div class="movie-overlay">
                                <button class="play-button">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                        <polygon points="5,3 19,12 5,21"></polygon>
                                    </svg>
                                </button>
                                <?php if ($isLoggedIn): ?>
                                <div class="movie-actions">
                                    <button class="action-btn" onclick="event.stopPropagation(); addToWatchlist(<?php echo $movie['id']; ?>)" title="Add to Collection">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                                        </svg>
                                    </button>
                                    <button class="action-btn" onclick="event.stopPropagation(); quickRate(<?php echo $movie['id']; ?>)" title="Rate Film">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"></polygon>
                                        </svg>
                                    </button>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="movie-badge">
                                <span class="avg-badge">⭐ <?php echo number_format((float)$movie['avg_rating'], 1); ?></span>
                            </div>
                            <div class="acclaim-indicator">
                                <span class="acclaim-badge">Acclaimed</span>
                            </div>
                            <div class="regal-frame"></div>
                        </div>
                        <div class="movie-card-info">
                            <h4><?php echo htmlspecialchars($movie['title']); ?></h4>
                            <p><?php echo htmlspecialchars($movie['year']); ?> • <?php echo htmlspecialchars(substr($movie['genre'] ?? 'Classic', 0, 20)); ?></p>
                            <div class="movie-stats">
                                <span class="rating-count"><?php echo (int)$movie['rating_count']; ?> review<?php echo $movie['rating_count'] !== '1' ? 's' : ''; ?></span>
                                <span class="popularity-score">96% acclaimed</span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="popular-placeholder">
                <div class="placeholder-icon">🎭</div>
                <h4>Curating Excellence</h4>
                <p>Our acclaimed films collection will showcase here as our distinguished members contribute their expert reviews and ratings.</p>
                <?php if (!$isLoggedIn): ?>
                <a href="/register" class="btn btn-primary regal-btn">Join Our Community</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

<?php if ($isLoggedIn): ?>
<div class="regal-quick-actions">
    <div class="section-container">
        <div class="quick-actions-header">
            <div class="title-icon">⚡</div>
            <div class="title-content">
                <h3>Elite Access</h3>
                <p>Navigate to your exclusive features</p>
            </div>
        </div>
        <div class="action-grid">
            <a href="/dashboard" class="quick-action-btn dashboard-btn">
                <div class="action-icon-wrapper">
                    <span class="action-icon">🏛️</span>
                    <div class="icon-glow"></div>
                </div>
                <div class="action-content">
                    <span class="action-text">Dashboard</span>
                    <span class="action-subtitle">Your cinematic overview</span>
                </div>
                <div class="action-arrow">→</div>
            </a>
            <a href="/watchlist" class="quick-action-btn watchlist-btn">
                <div class="action-icon-wrapper">
                    <span class="action-icon">📜</span>
                    <div class="icon-glow"></div>
                </div>
                <div class="action-content">
                    <span class="action-text">Collection</span>
                    <span class="action-subtitle">Curated watchlist</span>
                </div>
                <div class="action-arrow">→</div>
            </a>
            <a href="/watched" class="quick-action-btn watched-btn">
                <div class="action-icon-wrapper">
                    <span class="action-icon">✨</span>
                    <div class="icon-glow"></div>
                </div>
                <div class="action-content">
                    <span class="action-text">Watched</span>
                    <span class="action-subtitle">Your viewing history</span>
                </div>
                <div class="action-arrow">→</div>
            </a>
            <button onclick="loadRandomMovie()" class="quick-action-btn random-btn">
                <div class="action-icon-wrapper">
                    <span class="action-icon">🎲</span>
                    <div class="icon-glow"></div>
                </div>
                <div class="action-content">
                    <span class="action-text">Surprise Me</span>
                    <span class="action-subtitle">Discover hidden gems</span>
                </div>
                <div class="action-arrow">→</div>
            </button>
            <a href="/profile" class="quick-action-btn profile-btn">
                <div class="action-icon-wrapper">
                    <span class="action-icon">👤</span>
                    <div class="icon-glow"></div>
                </div>
                <div class="action-content">
                    <span class="action-text">Profile</span>
                    <span class="action-subtitle">Your achievements</span>
                </div>
                <div class="action-arrow">→</div>
            </a>
            <a href="/settings" class="quick-action-btn settings-btn">
                <div class="action-icon-wrapper">
                    <span class="action-icon">⚙️</span>
                    <div class="icon-glow"></div>
                </div>
                <div class="action-content">
                    <span class="action-text">Preferences</span>
                    <span class="action-subtitle">Personalize experience</span>
                </div>
                <div class="action-arrow">→</div>
            </a>
        </div>
    </div>
</div>
<?php else: ?>
<!-- Elite Features Section for Guests -->
<div class="regal-features-section">
    <div class="section-container">
        <div class="features-header">
            <div class="title-icon">🌟</div>
            <div class="title-content">
                <h3>Why Choose Our Elite Platform?</h3>
                <p>Discover the privileges that await you in our exclusive cinematic community</p>
            </div>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon-wrapper">
                    <div class="feature-icon">🔍</div>
                    <div class="icon-glow"></div>
                </div>
                <h4>Intelligent Discovery</h4>
                <p>Advanced search algorithms to find exactly what you're seeking in our curated collection</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon-wrapper">
                    <div class="feature-icon">⭐</div>
                    <div class="icon-glow"></div>
                </div>
                <h4>Expert Reviews</h4>
                <p>Share sophisticated critiques and discover thoughtful perspectives from fellow connoisseurs</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon-wrapper">
                    <div class="feature-icon">📜</div>
                    <div class="icon-glow"></div>
                </div>
                <h4>Personal Curation</h4>
                <p>Maintain an exclusive collection of films that match your refined taste</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon-wrapper">
                    <div class="feature-icon">🤖</div>
                    <div class="icon-glow"></div>
                </div>
                <h4>AI Curation</h4>
                <p>Sophisticated recommendations tailored to your unique cinematic preferences</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon-wrapper">
                    <div class="feature-icon">📊</div>
                    <div class="icon-glow"></div>
                </div>
                <h4>Analytics Dashboard</h4>
                <p>Comprehensive insights into your viewing patterns and cinematic journey</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon-wrapper">
                    <div class="feature-icon">🎭</div>
                    <div class="icon-glow"></div>
                </div>
                <h4>Elite Community</h4>
                <p>Connect with discerning film enthusiasts who share your passion for excellence</p>
            </div>
        </div>
    </div>
</div>

<div class="regal-guest-cta">
    <div class="cta-background">
        <div class="cta-gradient"></div>
        <div class="cta-pattern"></div>
        <div class="cta-particles">
            <span class="particle">🎬</span>
            <span class="particle">⭐</span>
            <span class="particle">🍿</span>
            <span class="particle">🎭</span>
            <span class="particle">👑</span>
        </div>
    </div>
    <div class="cta-content">
        <div class="cta-crown">👑</div>
        <h3>Begin Your Elite Cinematic Journey</h3>
        <p>Join our distinguished community of cinema connoisseurs who appreciate the art of exceptional filmmaking. Experience personalized curation and never overlook a masterpiece again.</p>
        <div class="cta-benefits">
            <div class="benefit-item">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="20,6 9,17 4,12"></polyline>
                </svg>
                <span>Lifetime access</span>
            </div>
            <div class="benefit-item">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="20,6 9,17 4,12"></polyline>
                </svg>
                <span>Ad-free experience</span>
            </div>
            <div class="benefit-item">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="20,6 9,17 4,12"></polyline>
                </svg>
                <span>Unlimited collections</span>
            </div>
        </div>
        <div class="cta-actions">
            <a href="/register" class="btn btn-primary btn-large regal-btn">
                <span>👑</span>
                <span>Join Elite Circle</span>
            </a>
            <a href="/login" class="btn btn-secondary btn-large regal-btn">
                <span>🔐</span>
                <span>Member Access</span>
            </a>
        </div>
        <p class="cta-note">Trusted by 1,000+ distinguished cinema enthusiasts worldwide</p>
    </div>
</div>
<?php endif; ?>

<style>
/* Professional Regal Homepage Styles */
:root {
    --regal-primary: #1a1f3a;
    --regal-secondary: #0f1419;
    --regal-accent: #daa520;
    --regal-accent-light: #f4d03f;
    --regal-text: #ffffff;
    --regal-text-muted: rgba(255, 255, 255, 0.7);
    --regal-border: rgba(218, 165, 32, 0.3);
    --regal-backdrop: rgba(26, 31, 58, 0.6);
    --regal-glass: rgba(26, 31, 58, 0.8);
}

/* Regal Hero Section */
.regal-hero-section {
    position: relative;
    padding: 80px 0 60px;
    text-align: center;
    overflow: hidden;
    margin-bottom: 40px;
}

.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: -1;
}

.hero-gradient {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(ellipse at center, rgba(218, 165, 32, 0.15), transparent);
}

.hero-pattern {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: 
        radial-gradient(circle at 20% 50%, rgba(218, 165, 32, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(218, 165, 32, 0.05) 0%, transparent 50%),
        radial-gradient(circle at 40% 80%, rgba(218, 165, 32, 0.08) 0%, transparent 50%);
}

.hero-content {
    position: relative;
    z-index: 2;
    max-width: 800px;
    margin: 0 auto;
    padding: 0 20px;
}

.hero-animation {
    position: relative;
    margin-bottom: 40px;
}

.hero-crown {
    font-size: 4rem;
    margin-bottom: 20px;
    filter: drop-shadow(0 4px 12px rgba(218, 165, 32, 0.4));
    animation: crownFloat 6s ease-in-out infinite;
}

@keyframes crownFloat {
    0%, 100% { 
        transform: translateY(0px) rotate(0deg); 
        filter: drop-shadow(0 4px 12px rgba(218, 165, 32, 0.4));
    }
    50% { 
        transform: translateY(-8px) rotate(2deg); 
        filter: drop-shadow(0 8px 20px rgba(218, 165, 32, 0.6));
    }
}

.floating-elements {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 300px;
    height: 300px;
    pointer-events: none;
}

.floating-element {
    position: absolute;
    font-size: 1.5rem;
    opacity: 0.7;
    animation: float 8s ease-in-out infinite;
}

.element-1 { top: 20%; left: 10%; animation-delay: 0s; }
.element-2 { top: 30%; right: 10%; animation-delay: 1s; }
.element-3 { bottom: 30%; left: 15%; animation-delay: 2s; }
.element-4 { bottom: 20%; right: 15%; animation-delay: 3s; }
.element-5 { top: 50%; left: 5%; animation-delay: 4s; }

@keyframes float {
    0%, 100% { transform: translateY(0px); opacity: 0.7; }
    50% { transform: translateY(-20px); opacity: 1; }
}

.hero-text h1 {
    font-size: 3.5rem;
    font-weight: 800;
    color: var(--regal-accent);
    margin-bottom: 20px;
    text-shadow: 
        0 4px 8px rgba(0, 0, 0, 0.5),
        0 0 30px rgba(218, 165, 32, 0.3);
    letter-spacing: -0.02em;
    line-height: 1.1;
}

.hero-text p {
    font-size: 1.3rem;
    color: var(--regal-text-muted);
    margin-bottom: 40px;
    line-height: 1.6;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.hero-stats {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 30px;
    margin-top: 40px;
    padding: 30px;
    background: var(--regal-glass);
    backdrop-filter: blur(20px);
    border-radius: 25px;
    border: 2px solid var(--regal-border);
    box-shadow: 
        0 10px 30px rgba(0, 0, 0, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.1);
}

.stat-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--regal-accent);
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.stat-label {
    font-size: 0.95rem;
    color: var(--regal-text-muted);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.stat-divider {
    width: 1px;
    height: 40px;
    background: linear-gradient(to bottom, transparent, var(--regal-border), transparent);
}

/* Professional Search Section */
.regal-search-section {
    margin-bottom: 60px;
}

.search-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 0 20px;
}

.search-header {
    text-align: center;
    margin-bottom: 40px;
}

.search-icon-wrapper {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--regal-accent), var(--regal-accent-light));
    border-radius: 50%;
    margin-bottom: 20px;
    box-shadow: 
        0 8px 25px rgba(218, 165, 32, 0.4),
        inset 0 1px 0 rgba(255, 255, 255, 0.2);
}

.search-icon {
    font-size: 1.8rem;
    color: var(--regal-primary);
}

.search-header h2 {
    font-size: 2.2rem;
    font-weight: 700;
    color: var(--regal-accent);
    margin-bottom: 15px;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
}

.search-header p {
    font-size: 1.1rem;
    color: rgba(255, 255, 255, 0.8);
    line-height: 1.6;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
}

.search-box {
    background: var(--regal-glass);
    backdrop-filter: blur(25px);
    border-radius: 25px;
    padding: 30px;
    border: 2px solid var(--regal-border);
    box-shadow: 
        0 15px 35px rgba(0, 0, 0, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.1);
    position: relative;
}

.search-input-wrapper {
    position: relative;
    margin-bottom: 25px;
}

.search-field {
    position: relative;
    display: flex;
    align-items: center;
    background: rgba(0, 0, 0, 0.2);
    border: 2px solid var(--regal-border);
    border-radius: 20px;
    padding: 8px;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.search-field:focus-within {
    border-color: var(--regal-accent);
    box-shadow: 
        0 0 0 4px rgba(218, 165, 32, 0.2),
        0 8px 25px rgba(218, 165, 32, 0.3);
    transform: translateY(-2px);
}

.search-input {
    flex: 1;
    background: rgba(0, 0, 0, 0.3);
    border: none;
    padding: 16px 20px;
    font-size: 1.1rem;
    color: #ffffff;
    font-weight: 500;
    outline: none;
    border-radius: 12px;
}

.search-input::placeholder {
    color: rgba(255, 255, 255, 0.6);
    font-weight: 400;
}

.search-btn {
    background: linear-gradient(135deg, var(--regal-accent), var(--regal-accent-light));
    border: none;
    border-radius: 12px;
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--regal-primary);
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 
        0 4px 12px rgba(218, 165, 32, 0.4),
        inset 0 1px 0 rgba(255, 255, 255, 0.2);
    margin-left: 8px;
}

.search-btn:hover {
    transform: scale(1.05) translateY(-1px);
    box-shadow: 
        0 8px 25px rgba(218, 165, 32, 0.6),
        inset 0 1px 0 rgba(255, 255, 255, 0.3);
}

.search-btn:active {
    transform: scale(0.98);
    box-shadow: 
        0 2px 8px rgba(218, 165, 32, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.2);
}

.search-enhancement {
    position: absolute;
    bottom: -2px;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 2px;
    background: linear-gradient(90deg, transparent, var(--regal-accent), transparent);
    border-radius: 1px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.search-field:focus-within + .search-enhancement {
    opacity: 1;
}

.search-suggestions {
    display: flex;
    flex-direction: column;
    gap: 15px;
    align-items: center;
}

.suggestions-label {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.7);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
}

.suggestion-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: center;
}

.suggestion-tag {
    display: flex;
    align-items: center;
    gap: 8px;
    background: rgba(218, 165, 32, 0.2);
    color: var(--regal-accent);
    padding: 10px 16px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
    border: 1px solid var(--regal-border);
    cursor: pointer;
    transition: all 0.3s ease;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(10px);
}

.suggestion-tag:hover {
    background: rgba(218, 165, 32, 0.25);
    border-color: var(--regal-accent);
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(218, 165, 32, 0.3);
}

.tag-icon {
    font-size: 1rem;
}

/* Section Containers */
.regal-personalized-section,
.regal-popular-section,
.regal-quick-actions,
.regal-features-section {
    margin-bottom: 60px;
}

.section-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
    background: var(--regal-glass);
    backdrop-filter: blur(25px);
    border-radius: 25px;
    border: 2px solid var(--regal-border);
    box-shadow: 
        0 15px 35px rgba(0, 0, 0, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.1);
    position: relative;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.section-title {
    display: flex;
    align-items: center;
    gap: 15px;
}

.title-icon {
    font-size: 2rem;
    filter: drop-shadow(0 2px 4px rgba(218, 165, 32, 0.3));
}

.title-content h3 {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--regal-accent);
    margin: 0 0 5px 0;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.section-subtitle {
    color: var(--regal-text-muted);
    font-size: 1rem;
    margin: 0;
    line-height: 1.5;
}

.signup-link {
    color: var(--regal-accent-light);
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.signup-link:hover {
    text-decoration: underline;
    text-shadow: 0 2px 4px rgba(244, 208, 63, 0.3);
}

.view-all-link {
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--regal-text-muted);
    text-decoration: none;
    font-weight: 600;
    padding: 10px 20px;
    border-radius: 20px;
    background: rgba(218, 165, 32, 0.1);
    border: 1px solid var(--regal-border);
    transition: all 0.3s ease;
}

.view-all-link:hover {
    background: rgba(218, 165, 32, 0.2);
    color: var(--regal-accent);
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(218, 165, 32, 0.2);
}

/* Movie Cards */
.recent-ratings,
.popular-movies {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 25px;
}

.rating-card,
.movie-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 
        0 10px 30px rgba(0, 0, 0, 0.2),
        0 2px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
    cursor: pointer;
    position: relative;
    border: 2px solid transparent;
}

.rating-card:hover,
.movie-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 
        0 20px 40px rgba(0, 0, 0, 0.3),
        0 8px 20px rgba(218, 165, 32, 0.2);
    border-color: var(--regal-border);
}

.rating-poster,
.movie-poster {
    position: relative;
    height: 300px;
    overflow: hidden;
}

.rating-poster img,
.movie-poster img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.rating-card:hover .rating-poster img,
.movie-card:hover .movie-poster img {
    transform: scale(1.05);
}

.regal-frame {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    border: 3px solid var(--regal-accent);
    opacity: 0;
    transition: opacity 0.3s ease;
    pointer-events: none;
}

.rating-card:hover .regal-frame,
.movie-card:hover .regal-frame {
    opacity: 0.7;
}

.rating-overlay,
.movie-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.rating-card:hover .rating-overlay,
.movie-card:hover .movie-overlay {
    opacity: 1;
}

.play-button {
    background: var(--regal-accent);
    border: none;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--regal-primary);
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(218, 165, 32, 0.4);
}

.play-button:hover {
    transform: scale(1.1);
    box-shadow: 0 8px 25px rgba(218, 165, 32, 0.6);
}

.rating-badge-container,
.movie-badge {
    position: absolute;
    top: 12px;
    right: 12px;
}

.rating-badge,
.avg-badge {
    background: rgba(0, 0, 0, 0.8);
    color: var(--regal-accent);
    padding: 6px 12px;
    border-radius: 15px;
    font-size: 0.85rem;
    font-weight: 700;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(218, 165, 32, 0.3);
}

.acclaim-indicator {
    position: absolute;
    top: 12px;
    left: 12px;
}

.acclaim-badge {
    background: linear-gradient(135deg, var(--regal-accent), var(--regal-accent-light));
    color: var(--regal-primary);
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.rating-info,
.movie-card-info {
    padding: 20px;
    text-align: center;
}

.rating-info h4,
.movie-card-info h4 {
    font-size: 1rem;
    font-weight: 700;
    color: var(--regal-primary);
    margin-bottom: 8px;
    line-height: 1.3;
}

.rating-info p,
.movie-card-info p {
    color: #6b7280;
    font-size: 0.85rem;
    margin-bottom: 10px;
}

.movie-stats {
    display: flex;
    justify-content: space-between;
    gap: 10px;
    font-size: 0.75rem;
}

.rating-count,
.popularity-score {
    color: #9ca3af;
    font-weight: 500;
}

/* Quick Actions */
.quick-actions-header,
.features-header {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 30px;
    justify-content: center;
}

.action-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
}

.quick-action-btn {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 25px;
    background: rgba(255, 255, 255, 0.95);
    border: 2px solid rgba(218, 165, 32, 0.2);
    border-radius: 20px;
    text-decoration: none;
    color: var(--regal-primary);
    transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    position: relative;
    overflow: hidden;
}

.quick-action-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(218, 165, 32, 0.1), transparent);
    transition: left 0.6s ease;
}

.quick-action-btn:hover::before {
    left: 100%;
}

.quick-action-btn:hover {
    background: rgba(218, 165, 32, 0.95);
    color: var(--regal-primary);
    border-color: var(--regal-accent);
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(218, 165, 32, 0.3);
}

.action-icon-wrapper {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, var(--regal-accent), var(--regal-accent-light));
    border-radius: 15px;
    flex-shrink: 0;
}

.action-icon {
    font-size: 1.5rem;
    color: var(--regal-primary);
}

.icon-glow {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle, rgba(218, 165, 32, 0.3), transparent);
    border-radius: 15px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.quick-action-btn:hover .icon-glow {
    opacity: 1;
}

.action-content {
    flex: 1;
    text-align: left;
}

.action-text {
    display: block;
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 4px;
}

.action-subtitle {
    font-size: 0.9rem;
    color: #6b7280;
    font-weight: 500;
}

.action-arrow {
    font-size: 1.2rem;
    font-weight: bold;
    color: var(--regal-accent);
    transition: transform 0.3s ease;
}

.quick-action-btn:hover .action-arrow {
    transform: translateX(5px);
}

/* Features Grid */
.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 25px;
}

.feature-card {
    background: rgba(255, 255, 255, 0.95);
    padding: 30px;
    border-radius: 20px;
    text-align: center;
    border: 2px solid rgba(218, 165, 32, 0.2);
    transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.feature-card:hover {
    transform: translateY(-6px);
    border-color: var(--regal-accent);
    box-shadow: 0 15px 35px rgba(218, 165, 32, 0.2);
}

.feature-icon-wrapper {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, var(--regal-accent), var(--regal-accent-light));
    border-radius: 20px;
    margin-bottom: 20px;
}

.feature-icon {
    font-size: 2rem;
    color: var(--regal-primary);
}

.feature-card h4 {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--regal-primary);
    margin-bottom: 15px;
}

.feature-card p {
    color: #6b7280;
    line-height: 1.6;
    font-size: 0.95rem;
}

/* Guest CTA */
.regal-guest-cta {
    position: relative;
    overflow: hidden;
    border-radius: 25px;
    margin-bottom: 60px;
}

.cta-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: -1;
}

.cta-gradient {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, var(--regal-secondary) 0%, var(--regal-primary) 40%, var(--regal-accent) 100%);
}

.cta-pattern {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: 
        radial-gradient(circle at 20% 50%, rgba(218, 165, 32, 0.15) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(218, 165, 32, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 40% 80%, rgba(218, 165, 32, 0.12) 0%, transparent 50%);
}

.cta-particles {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    pointer-events: none;
}

.particle {
    position: absolute;
    font-size: 1.5rem;
    opacity: 0.6;
    animation: particleFloat 12s linear infinite;
}

.particle:nth-child(1) { top: 20%; left: 10%; animation-delay: 0s; }
.particle:nth-child(2) { top: 60%; left: 80%; animation-delay: 2s; }
.particle:nth-child(3) { top: 40%; right: 15%; animation-delay: 4s; }
.particle:nth-child(4) { bottom: 30%; left: 70%; animation-delay: 6s; }
.particle:nth-child(5) { top: 80%; left: 30%; animation-delay: 8s; }

@keyframes particleFloat {
    0% { transform: translateY(0px) rotate(0deg); opacity: 0.6; }
    50% { transform: translateY(-30px) rotate(180deg); opacity: 1; }
    100% { transform: translateY(0px) rotate(360deg); opacity: 0.6; }
}

.cta-content {
    position: relative;
    z-index: 2;
    padding: 60px 40px;
    text-align: center;
    color: var(--regal-text);
}

.cta-crown {
    font-size: 3rem;
    margin-bottom: 20px;
    filter: drop-shadow(0 4px 12px rgba(218, 165, 32, 0.4));
    animation: crownFloat 6s ease-in-out infinite;
}

.cta-content h3 {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 20px;
    text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    color: var(--regal-accent);
}

.cta-content p {
    font-size: 1.2rem;
    margin-bottom: 30px;
    opacity: 0.9;
    line-height: 1.6;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.cta-benefits {
    display: flex;
    justify-content: center;
    gap: 30px;
    margin-bottom: 40px;
    flex-wrap: wrap;
}

.benefit-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--regal-accent-light);
    font-weight: 600;
}

.benefit-item svg {
    color: var(--regal-accent);
}

.cta-actions {
    display: flex;
    gap: 20px;
    justify-content: center;
    flex-wrap: wrap;
    margin-bottom: 20px;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 16px 32px;
    border: none;
    border-radius: 25px;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
    font-size: 1.1rem;
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
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.6s ease;
}

.btn:hover::before {
    left: 100%;
}

.btn-primary {
    background: linear-gradient(135deg, var(--regal-accent), var(--regal-accent-light));
    color: var(--regal-primary);
    box-shadow: 0 8px 25px rgba(218, 165, 32, 0.3);
}

.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(218, 165, 32, 0.4);
    background: linear-gradient(135deg, var(--regal-accent-light), #fff);
}

.btn-secondary {
    background: rgba(255, 255, 255, 0.2);
    color: var(--regal-text);
    border: 2px solid rgba(255, 255, 255, 0.3);
    backdrop-filter: blur(10px);
}

.btn-secondary:hover {
    background: rgba(255, 255, 255, 0.3);
    border-color: rgba(255, 255, 255, 0.5);
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(255, 255, 255, 0.2);
}

.btn-large {
    padding: 18px 36px;
    font-size: 1.15rem;
}

.cta-note {
    font-size: 0.9rem;
    color: var(--regal-text-muted);
    margin: 0;
}

/* Category Buttons */
.section-actions {
    display: flex;
    gap: 8px;
}

.category-btn {
    background: rgba(218, 165, 32, 0.1);
    color: var(--regal-accent);
    border: 1px solid var(--regal-border);
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.category-btn:hover,
.category-btn.active {
    background: var(--regal-accent);
    color: var(--regal-primary);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(218, 165, 32, 0.3);
}

/* Placeholder */
.popular-placeholder {
    text-align: center;
    padding: 60px 40px;
    color: var(--regal-text-muted);
}

.placeholder-icon {
    font-size: 3rem;
    margin-bottom: 20px;
    opacity: 0.7;
}

.popular-placeholder h4 {
    font-size: 1.5rem;
    color: var(--regal-accent);
    margin-bottom: 15px;
}

.popular-placeholder p {
    font-size: 1rem;
    line-height: 1.6;
    max-width: 400px;
    margin: 0 auto 30px;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .hero-text h1 {
        font-size: 2.8rem;
    }

    .section-header {
        flex-direction: column;
        gap: 20px;
        align-items: flex-start;
    }

    .action-grid {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    }
}

@media (max-width: 768px) {
    .hero-text h1 {
        font-size: 2.2rem;
    }

    .hero-text p {
        font-size: 1.1rem;
    }

    .hero-stats {
        flex-direction: column;
        gap: 20px;
        padding: 20px;
    }

    .stat-divider {
        width: 40px;
        height: 1px;
        background: linear-gradient(to right, transparent, var(--regal-border), transparent);
    }

    .section-container {
        padding: 30px 20px;
    }

    .recent-ratings,
    .popular-movies {
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 20px;
    }

    .action-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }

    .quick-action-btn {
        padding: 20px;
    }

    .features-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .cta-content {
        padding: 40px 20px;
    }

    .cta-content h3 {
        font-size: 2rem;
    }

    .cta-benefits {
        flex-direction: column;
        gap: 15px;
    }

    .cta-actions {
        flex-direction: column;
        align-items: center;
    }

    .btn {
        width: 100%;
        max-width: 300px;
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .hero-text h1 {
        font-size: 1.8rem;
    }

    .search-header h2 {
        font-size: 1.8rem;
    }

    .recent-ratings,
    .popular-movies {
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    .suggestion-tags {
        gap: 6px;
    }

    .suggestion-tag {
        padding: 8px 12px;
        font-size: 0.8rem;
    }

    .section-container {
        padding: 20px 15px;
    }

    .title-content h3 {
        font-size: 1.5rem;
    }

    .floating-elements {
        width: 200px;
        height: 200px;
    }

    .floating-element {
        font-size: 1.2rem;
    }
}

/* Performance optimizations */
@media (prefers-reduced-motion: reduce) {
    *, *::before, *::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
}

/* Animation classes */
.animate-card {
    opacity: 0;
    transform: translateY(20px);
    animation: slideInUp 0.6s ease forwards;
}

@keyframes slideInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<script>
// Enhanced Statistics Counter Animation
function animateCounters() {
    const counters = document.querySelectorAll('.stat-number[data-count]');

    counters.forEach(counter => {
        const target = parseInt(counter.dataset.count);
        const duration = 2000; // 2 seconds
        const step = target / (duration / 16); // 60fps
        let current = 0;

        const timer = setInterval(() => {
            current += step;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }

            // Format number with commas
            counter.textContent = Math.floor(current).toLocaleString();
        }, 16);
    });
}

// Enhanced Random Movie Function
async function loadRandomMovie() {
    const randomBtn = document.querySelector('.random-btn');
    const originalContent = randomBtn.innerHTML;

    try {
        // Add loading state
        randomBtn.innerHTML = `
            <div class="action-icon-wrapper">
                <span class="action-icon">⏳</span>
                <div class="icon-glow"></div>
            </div>
            <div class="action-content">
                <span class="action-text">Loading...</span>
                <span class="action-subtitle">Finding perfect film</span>
            </div>
            <div class="action-arrow">→</div>
        `;
        randomBtn.disabled = true;

        // Get a random popular movie to display
        const response = await fetch('/api/movies/trending?limit=50');
        const data = await response.json();

        if (data.success && data.movies.length > 0) {
            const randomMovie = data.movies[Math.floor(Math.random() * data.movies.length)];

            // Add success state briefly
            randomBtn.innerHTML = `
                <div class="action-icon-wrapper">
                    <span class="action-icon">✨</span>
                    <div class="icon-glow"></div>
                </div>
                <div class="action-content">
                    <span class="action-text">Found One!</span>
                    <span class="action-subtitle">Loading masterpiece</span>
                </div>
                <div class="action-arrow">→</div>
            `;

            setTimeout(() => {
                movieAppInstance.loadMovieDetails(randomMovie.imdb_id);
            }, 800);
        } else {
            movieAppInstance.showToast('No films available for discovery', 'info');
        }
    } catch (error) {
        movieAppInstance.showToast('Failed to discover film', 'error');
    } finally {
        // Restore original state after delay
        setTimeout(() => {
            randomBtn.innerHTML = originalContent;
            randomBtn.disabled = false;
        }, 1500);
    }
}

// Enhanced Search Suggestions
function searchSuggestion(genre) {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.value = genre;
        searchInput.focus();

        // Add visual feedback
        const suggestion = event.target;
        suggestion.style.transform = 'scale(1.1)';
        suggestion.style.background = 'rgba(218, 165, 32, 0.4)';

        setTimeout(() => {
            suggestion.style.transform = '';
            suggestion.style.background = '';
        }, 200);

        // Trigger search after brief delay
        setTimeout(() => {
            searchInput.dispatchEvent(new KeyboardEvent('keypress', { key: 'Enter' }));
        }, 300);
    }
}

// Intersection Observer for Animations
function setupAnimations() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const delay = entry.target.dataset.animationDelay || 0;
                setTimeout(() => {
                    entry.target.style.animationDelay = delay + 's';
                    entry.target.classList.add('animate-card');
                }, delay * 1000);
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });

    // Observe all cards
    document.querySelectorAll('.rating-card, .movie-card, .feature-card, .quick-action-btn')
        .forEach(card => observer.observe(card));
}

// Enhanced search input focus
function enhanceSearchExperience() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput && window.innerWidth > 768) {
        // Auto-focus with elegant timing
        setTimeout(() => {
            searchInput.focus();

            // Add subtle pulse effect
            searchInput.parentElement.style.animation = 'pulse 2s ease-in-out';
        }, 1000);
    }

    // Enhanced keyboard shortcuts
    document.addEventListener('keydown', (e) => {
        // Focus search with Ctrl/Cmd + K
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            if (searchInput) {
                searchInput.focus();
                searchInput.select();
            }
        }

        // ESC to clear search
        if (e.key === 'Escape' && searchInput) {
            searchInput.blur();
            searchInput.value = '';
        }
    });
}

// Category button functionality
function setupCategoryButtons() {
    const categoryBtns = document.querySelectorAll('.category-btn');

    categoryBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from all buttons
            categoryBtns.forEach(b => b.classList.remove('active'));

            // Add active class to clicked button
            this.classList.add('active');

            // Add ripple effect
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = event.clientX - rect.left - size / 2;
            const y = event.clientY - rect.top - size / 2;

            ripple.style.cssText = `
                position: absolute;
                left: ${x}px;
                top: ${y}px;
                width: ${size}px;
                height: ${size}px;
                border-radius: 50%;
                background: rgba(218, 165, 32, 0.3);
                transform: scale(0);
                animation: ripple 0.6s linear;
                pointer-events: none;
            `;

            this.style.position = 'relative';
            this.style.overflow = 'hidden';
            this.appendChild(ripple);

            setTimeout(() => ripple.remove(), 600);

            // Filter functionality would go here
            console.log('Filter by category:', this.dataset.category);
        });
    });
}

// Initialize everything
document.addEventListener('DOMContentLoaded', () => {
    animateCounters();
    setupAnimations();
    enhanceSearchExperience();
    setupCategoryButtons();

    // Add CSS for ripple and pulse animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        @keyframes pulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(218, 165, 32, 0.4); }
            50% { box-shadow: 0 0 0 10px rgba(218, 165, 32, 0); }
        }
    `;
    document.head.appendChild(style);
});
</script>