<?php
$isLoggedIn = isset($_SESSION['user']) && !empty($_SESSION['user']['id']);
?>

<!-- Hero Section -->
<div class="hero-section">
    <div class="hero-content">
        <div class="hero-animation">
            <div class="hero-icon">🎬</div>
            <div class="floating-elements">
                <span class="floating-element element-1">⭐</span>
                <span class="floating-element element-2">🍿</span>
                <span class="floating-element element-3">🎭</span>
                <span class="floating-element element-4">🎪</span>
            </div>
        </div>
        <div class="hero-text">
            <h1>Discover Your Next Favorite Movie</h1>
            <p>Search, rate, and explore thousands of movies with our intelligent recommendation system</p>
        </div>
        <?php if (!$isLoggedIn): ?>
        <div class="hero-stats">
            <div class="stat-item">
                <span class="stat-number">10K+</span>
                <span class="stat-label">Movies</span>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <span class="stat-number">5K+</span>
                <span class="stat-label">Reviews</span>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <span class="stat-number">1K+</span>
                <span class="stat-label">Users</span>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Enhanced Search Section -->
<div class="search-section">
    <div class="search-container">
        <div class="search-header">
            <h2>🔍 Search Movies</h2>
            <p>Find any movie from our extensive database</p>
        </div>
        <div class="search-box">
            <div class="search-input-wrapper">
                <input type="text" 
                       id="searchInput" 
                       class="search-input" 
                       placeholder="Search for movies, actors, or directors..." 
                       autocomplete="off" />
                <button class="search-btn" aria-label="Search movies">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="21 21l-4.35-4.35"></path>
                    </svg>
                </button>
            </div>
            <div class="search-suggestions">
                <span class="suggestion-tag" onclick="searchSuggestion('Action')">Action</span>
                <span class="suggestion-tag" onclick="searchSuggestion('Comedy')">Comedy</span>
                <span class="suggestion-tag" onclick="searchSuggestion('Drama')">Drama</span>
                <span class="suggestion-tag" onclick="searchSuggestion('Thriller')">Thriller</span>
                <span class="suggestion-tag" onclick="searchSuggestion('Sci-Fi')">Sci-Fi</span>
            </div>
        </div>

        <!-- Search Results Container -->
        <div id="searchResults" class="search-results"></div>
    </div>
</div>

<!-- Movie Details Container -->
<div id="movieDetails" class="movie-details"></div>

<?php if ($isLoggedIn && !empty($data['recent_ratings'])): ?>
<div class="personalized-section">
    <div class="section-header">
        <div class="section-title">
            <h3>🎬 Your Recent Ratings</h3>
            <p class="section-subtitle">Continue your movie journey</p>
        </div>
        <a href="/profile" class="view-all-link">
            <span>View All</span>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="9,18 15,12 9,6"></polyline>
            </svg>
        </a>
    </div>
    <div class="recent-ratings">
        <?php foreach (array_slice($data['recent_ratings'], 0, 5) as $index => $rating): ?>
            <div class="rating-card animate-card" 
                 data-animation-delay="<?php echo $index * 0.1; ?>"
                 onclick="movieAppInstance.loadMovieDetails('<?php echo htmlspecialchars($rating['imdb_id']); ?>')">
                <div class="rating-poster">
                    <img src="<?php echo $rating['poster'] !== 'N/A' ? htmlspecialchars($rating['poster']) : '/public/assets/images/no-image.png'; ?>" 
                         alt="<?php echo htmlspecialchars($rating['title']); ?>"
                         onerror="this.src='/public/assets/images/no-image.png'"
                         loading="lazy">
                    <div class="rating-overlay">
                        <button class="play-button">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <polygon points="5,3 19,12 5,21"></polygon>
                            </svg>
                        </button>
                    </div>
                    <div class="rating-badge-container">
                        <span class="rating-badge">⭐ <?php echo (int)$rating['rating']; ?></span>
                    </div>
                </div>
                <div class="rating-info">
                    <h4><?php echo htmlspecialchars($rating['title']); ?></h4>
                    <p><?php echo htmlspecialchars($rating['year']); ?> • <?php echo htmlspecialchars(substr($rating['genre'] ?? 'Unknown', 0, 15)); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<?php if (!$isLoggedIn || (!empty($data['popular_movies']) && empty($data['recent_ratings']))): ?>
<div class="popular-section">
    <div class="section-header">
        <div class="section-title">
            <h3>⭐ Popular Movies</h3>
            <p class="section-subtitle">
                <?php if (!$isLoggedIn): ?>
                    Trending movies loved by our community • <a href="/register" class="signup-link">Join us</a> for personalized recommendations!
                <?php else: ?>
                    Discover what's trending in our community
                <?php endif; ?>
            </p>
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
                <div class="movie-card popular-card animate-card" 
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
                                <button class="action-btn" onclick="event.stopPropagation(); addToWatchlist(<?php echo $movie['id']; ?>)" title="Add to Watchlist">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                                    </svg>
                                </button>
                                <button class="action-btn" onclick="event.stopPropagation(); quickRate(<?php echo $movie['id']; ?>)" title="Quick Rate">
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
                        <div class="trending-indicator">
                            <span class="trending-badge">Trending</span>
                        </div>
                    </div>
                    <div class="movie-card-info">
                        <h4><?php echo htmlspecialchars($movie['title']); ?></h4>
                        <p><?php echo htmlspecialchars($movie['year']); ?> • <?php echo htmlspecialchars(substr($movie['genre'] ?? 'Unknown', 0, 20)); ?></p>
                        <div class="movie-stats">
                            <span class="rating-count"><?php echo (int)$movie['rating_count']; ?> rating<?php echo $movie['rating_count'] !== '1' ? 's' : ''; ?></span>
                            <span class="popularity-score">95% liked</span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="popular-placeholder">
            <div class="placeholder-icon">📊</div>
            <h4>Building Our Community</h4>
            <p>Popular movies will appear here as our users rate and review them. Be one of the first to contribute!</p>
            <?php if (!$isLoggedIn): ?>
            <a href="/register" class="btn btn-primary">Join the Community</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
<?php endif; ?>

<?php if ($isLoggedIn): ?>
<div class="quick-actions">
    <div class="quick-actions-header">
        <h3>⚡ Quick Actions</h3>
        <p>Jump to your favorite features</p>
    </div>
    <div class="action-grid">
        <a href="/dashboard" class="quick-action-btn dashboard-btn">
            <div class="action-icon-wrapper">
                <span class="action-icon">📊</span>
            </div>
            <div class="action-content">
                <span class="action-text">Dashboard</span>
                <span class="action-subtitle">Your overview</span>
            </div>
            <div class="action-arrow">→</div>
        </a>
        <a href="/watchlist" class="quick-action-btn watchlist-btn">
            <div class="action-icon-wrapper">
                <span class="action-icon">📝</span>
            </div>
            <div class="action-content">
                <span class="action-text">Watchlist</span>
                <span class="action-subtitle">Movies to watch</span>
            </div>
            <div class="action-arrow">→</div>
        </a>
        <a href="/watched" class="quick-action-btn watched-btn">
            <div class="action-icon-wrapper">
                <span class="action-icon">✅</span>
            </div>
            <div class="action-content">
                <span class="action-text">Watched</span>
                <span class="action-subtitle">Your history</span>
            </div>
            <div class="action-arrow">→</div>
        </a>
        <button onclick="loadRandomMovie()" class="quick-action-btn random-btn">
            <div class="action-icon-wrapper">
                <span class="action-icon">🎲</span>
            </div>
            <div class="action-content">
                <span class="action-text">Random Movie</span>
                <span class="action-subtitle">Discover something new</span>
            </div>
            <div class="action-arrow">→</div>
        </button>
        <a href="/profile" class="quick-action-btn profile-btn">
            <div class="action-icon-wrapper">
                <span class="action-icon">👤</span>
            </div>
            <div class="action-content">
                <span class="action-text">Profile</span>
                <span class="action-subtitle">Your stats</span>
            </div>
            <div class="action-arrow">→</div>
        </a>
        <a href="/settings" class="quick-action-btn settings-btn">
            <div class="action-icon-wrapper">
                <span class="action-icon">⚙️</span>
            </div>
            <div class="action-content">
                <span class="action-text">Settings</span>
                <span class="action-subtitle">Preferences</span>
            </div>
            <div class="action-arrow">→</div>
        </a>
    </div>
</div>
<?php else: ?>
<!-- Features Section for Non-Logged In Users -->
<div class="features-section">
    <div class="features-header">
        <h3>🌟 Why Choose Movie Review Hub?</h3>
        <p>Discover what makes us the perfect companion for your movie journey</p>
    </div>
    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon">🔍</div>
            <h4>Smart Search</h4>
            <p>Find any movie instantly with our powerful search engine</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">⭐</div>
            <h4>Rate & Review</h4>
            <p>Share your thoughts and discover what others think</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">📝</div>
            <h4>Personal Watchlist</h4>
            <p>Keep track of movies you want to watch</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">🤖</div>
            <h4>AI Recommendations</h4>
            <p>Get personalized suggestions based on your taste</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">📊</div>
            <h4>Detailed Analytics</h4>
            <p>Track your movie watching habits and preferences</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">🌐</div>
            <h4>Community Driven</h4>
            <p>Join a community of passionate movie lovers</p>
        </div>
    </div>
</div>

<div class="guest-cta">
    <div class="cta-background">
        <div class="cta-particles">
            <span class="particle">🎬</span>
            <span class="particle">⭐</span>
            <span class="particle">🍿</span>
            <span class="particle">🎭</span>
        </div>
    </div>
    <div class="cta-content">
        <div class="cta-icon">🎬</div>
        <h3>Ready to Start Your Movie Journey?</h3>
        <p>Join thousands of movie lovers who trust Movie Review Hub to discover, track, and rate their favorite films. Get personalized recommendations and never miss a great movie again!</p>
        <div class="cta-benefits">
            <div class="benefit-item">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="20,6 9,17 4,12"></polyline>
                </svg>
                <span>Free forever</span>
            </div>
            <div class="benefit-item">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="20,6 9,17 4,12"></polyline>
                </svg>
                <span>No ads, ever</span>
            </div>
            <div class="benefit-item">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="20,6 9,17 4,12"></polyline>
                </svg>
                <span>Unlimited watchlist</span>
            </div>
        </div>
        <div class="cta-actions">
            <a href="/register" class="btn btn-primary btn-large">
                <span>🚀</span>
                <span>Sign Up Free</span>
            </a>
            <a href="/login" class="btn btn-secondary btn-large">
                <span>👋</span>
                <span>Welcome Back</span>
            </a>
        </div>
        <p class="cta-note">Join over 1,000+ movie enthusiasts already using Movie Review Hub</p>
    </div>
</div>
<?php endif; ?>

<style>
/* Search Section Styles */
.search-section {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.2);
    text-align: center;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.section-header h3 {
    color: white;
    font-size: 1.5rem;
    font-weight: 700;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.view-all-link {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    font-weight: 600;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    background: rgba(255, 255, 255, 0.1);
    transition: all 0.3s ease;
}

.view-all-link:hover {
    background: rgba(255, 255, 255, 0.2);
    color: white;
}

/* Personalized Section */
.personalized-section {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.recent-ratings {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1rem;
}

.rating-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    cursor: pointer;
}

.rating-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.rating-poster {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.rating-poster img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.rating-overlay {
    position: absolute;
    top: 10px;
    right: 10px;
}

.rating-badge {
    background: rgba(0, 0, 0, 0.8);
    color: #fbbf24;
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
}

.rating-info {
    padding: 1rem;
    text-align: center;
}

.rating-info h4 {
    font-size: 0.9rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.25rem;
    line-height: 1.3;
}

.rating-info p {
    color: #6b7280;
    font-size: 0.8rem;
}

/* Popular Section */
.popular-section {
    margin-bottom: 2rem;
}

.section-subtitle {
    color: rgba(255, 255, 255, 0.8);
    font-size: 1rem;
    margin-top: 0.5rem;
}

.signup-link {
    color: #fbbf24;
    text-decoration: none;
    font-weight: 600;
}

.signup-link:hover {
    text-decoration: underline;
}

.popular-movies {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 1.5rem;
}

.popular-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    cursor: pointer;
}

.popular-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.movie-badge {
    position: absolute;
    top: 12px;
    right: 12px;
}

.avg-badge {
    background: rgba(0, 0, 0, 0.8);
    color: #fbbf24;
    padding: 0.5rem;
    border-radius: 12px;
    font-size: 0.875rem;
    font-weight: 600;
}

.popular-placeholder {
    text-align: center;
    padding: 3rem;
    color: rgba(255, 255, 255, 0.8);
}

/* Quick Actions */
.quick-actions {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.quick-actions h3 {
    color: #1f2937;
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    text-align: center;
}

.action-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.quick-action-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    padding: 1.5rem;
    background: white;
    border: 2px solid #e5e7eb;
    border-radius: 16px;
    text-decoration: none;
    color: #374151;
    transition: all 0.3s ease;
    cursor: pointer;
}

.quick-action-btn:hover {
    background: #6366f1;
    color: white;
    border-color: #6366f1;
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(99, 102, 241, 0.3);
}

.action-icon {
    font-size: 2rem;
}

.action-text {
    font-weight: 600;
    font-size: 1rem;
}

/* Guest CTA */
.guest-cta {
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    border-radius: 24px;
    padding: 3rem 2rem;
    text-align: center;
    color: white;
    margin-bottom: 2rem;
}

.cta-content h3 {
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 1rem;
}

.cta-content p {
    font-size: 1.125rem;
    margin-bottom: 2rem;
    opacity: 0.9;
}

.cta-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 2rem;
    border: none;
    border-radius: 25px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 1rem;
}

.btn-primary {
    background: white;
    color: #6366f1;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255, 255, 255, 0.3);
}

.btn-secondary {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.btn-secondary:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .search-section,
    .personalized-section,
    .quick-actions {
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .recent-ratings {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 0.75rem;
    }

    .popular-movies {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
    }

    .action-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
    }

    .quick-action-btn {
        padding: 1rem;
    }

    .action-icon {
        font-size: 1.5rem;
    }

    .action-text {
        font-size: 0.875rem;
    }

    .guest-cta {
        padding: 2rem 1.5rem;
    }

    .cta-content h3 {
        font-size: 1.5rem;
    }

    .cta-content p {
        font-size: 1rem;
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
    .recent-ratings {
        grid-template-columns: repeat(2, 1fr);
    }

    .popular-movies {
        grid-template-columns: 1fr;
    }

    .action-grid {
        grid-template-columns: 1fr;
    }

    .section-header {
        flex-direction: column;
        gap: 0.5rem;
        text-align: center;
    }
}
</style>

<script>
async function loadRandomMovie() {
    try {
        // Get a random popular movie to display
        const response = await fetch('/api/movies/trending?limit=50');
        const data = await response.json();

        if (data.success && data.movies.length > 0) {
            const randomMovie = data.movies[Math.floor(Math.random() * data.movies.length)];
            movieAppInstance.loadMovieDetails(randomMovie.imdb_id);
        } else {
            movieAppInstance.showToast('No random movie available', 'info');
        }
    } catch (error) {
        movieAppInstance.showToast('Failed to load random movie', 'error');
    }
}

// Auto-focus search on page load (desktop only)
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    if (searchInput && window.innerWidth > 768) {
        // Small delay to ensure page is fully loaded
        setTimeout(() => {
            searchInput.focus();
        }, 500);
    }
});
</script>