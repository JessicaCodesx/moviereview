<?php
?>
<div class="dashboard-container">
    <!-- Welcome Section with Enhanced Animation -->
    <div class="dashboard-welcome animate-on-scroll">
        <div class="welcome-content">
            <div class="welcome-text">
                <h2>Welcome back, <?php echo htmlspecialchars($_SESSION['user']['username']); ?>! 🎬</h2>
                <p>Ready to discover your next favorite movie?</p>
            </div>
            <div class="welcome-actions">
                <a href="/" class="btn btn-primary">
                    <span>🔍</span> Search Movies
                </a>
            </div>
        </div>

        <div class="dashboard-stats-preview">
            <div class="stat-preview-item">
                <span class="stat-number"><?php echo count($data['watchlist'] ?? []); ?></span>
                <span class="stat-label">Watchlist</span>
            </div>
            <div class="stat-preview-item">
                <span class="stat-number"><?php echo count($data['recently_watched'] ?? []); ?></span>
                <span class="stat-label">Watched</span>
            </div>
        </div>
    </div>

    <!-- Enhanced Quick Stats -->
    <div class="stats-grid animate-on-scroll">
        <div class="stat-card watchlist-card" onclick="window.location.href='/watchlist'">
            <div class="stat-icon-wrapper">
                <span class="stat-icon">📝</span>
                <div class="stat-icon-bg"></div>
            </div>
            <div class="stat-content">
                <h3><?php echo count($data['watchlist'] ?? []); ?></h3>
                <p>Movies in Watchlist</p>
                <div class="stat-progress">
                    <div class="progress-bar-fill" style="width: <?php echo min(100, count($data['watchlist'] ?? []) * 10); ?>%"></div>
                </div>
            </div>
            <div class="stat-arrow">→</div>
        </div>

        <div class="stat-card watched-card" onclick="window.location.href='/watched'">
            <div class="stat-icon-wrapper">
                <span class="stat-icon">✅</span>
                <div class="stat-icon-bg"></div>
            </div>
            <div class="stat-content">
                <h3><?php echo count($data['recently_watched'] ?? []); ?></h3>
                <p>Recently Watched</p>
                <div class="stat-progress">
                    <div class="progress-bar-fill" style="width: <?php echo min(100, count($data['recently_watched'] ?? []) * 20); ?>%"></div>
                </div>
            </div>
            <div class="stat-arrow">→</div>
        </div>

        <div class="stat-card recommendations-card">
            <div class="stat-icon-wrapper">
                <span class="stat-icon">💡</span>
                <div class="stat-icon-bg"></div>
            </div>
            <div class="stat-content">
                <h3><?php echo count($data['recommendations'] ?? []); ?></h3>
                <p>Recommendations</p>
                <div class="stat-progress">
                    <div class="progress-bar-fill" style="width: <?php echo min(100, count($data['recommendations'] ?? []) * 15); ?>%"></div>
                </div>
            </div>
            <div class="stat-badge">New</div>
        </div>

        <div class="stat-card search-card" onclick="window.location.href='/'">
            <div class="stat-icon-wrapper">
                <span class="stat-icon">🔍</span>
                <div class="stat-icon-bg"></div>
            </div>
            <div class="stat-content">
                <h3>∞</h3>
                <p>Discover Movies</p>
                <small>Millions of titles to explore</small>
            </div>
            <div class="stat-arrow">→</div>
        </div>
    </div>

    <!-- Continue Watching Section -->
    <?php if (!empty($data['recently_watched'])): ?>
    <div class="dashboard-section animate-on-scroll">
        <div class="section-header">
            <div class="section-title">
                <h3>🎬 Continue Your Journey</h3>
                <p class="section-subtitle">Recently watched movies</p>
            </div>
            <a href="/watched" class="view-all-link">
                <span>View All</span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="9,18 15,12 9,6"></polyline>
                </svg>
            </a>
        </div>

        <div class="horizontal-scroll-container">
            <div class="movies-horizontal-grid">
                <?php foreach (array_slice($data['recently_watched'], 0, 8) as $index => $movie): ?>
                    <div class="movie-card-horizontal animate-card" 
                         style="animation-delay: <?php echo $index * 0.1; ?>s"
                         onclick="movieAppInstance.loadMovieDetails('<?php echo $movie['imdb_id']; ?>')">
                        <div class="movie-poster-horizontal">
                            <img src="<?php echo $movie['poster'] !== 'N/A' ? $movie['poster'] : '/public/assets/images/no-image.png'; ?>" 
                                 alt="<?php echo htmlspecialchars($movie['title']); ?>"
                                 onerror="this.src='/public/assets/images/no-image.png'"
                                 loading="lazy">
                            <div class="movie-overlay-horizontal">
                                <button class="play-button">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                        <polygon points="5,3 19,12 5,21"></polygon>
                                    </svg>
                                </button>
                            </div>
                            <div class="movie-status-badge">
                                <?php if ($movie['user_rating']): ?>
                                    <span class="rating-badge-small">⭐ <?php echo $movie['user_rating']; ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="movie-info-horizontal">
                            <h4><?php echo htmlspecialchars($movie['title']); ?></h4>
                            <p><?php echo $movie['year']; ?> • <?php echo htmlspecialchars(substr($movie['genre'], 0, 20)); ?></p>
                            <small class="watched-date">
                                Watched <?php echo $this->timeAgo($movie['watched_at']); ?>
                            </small>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Watchlist Section -->
    <?php if (!empty($data['watchlist'])): ?>
    <div class="dashboard-section animate-on-scroll">
        <div class="section-header">
            <div class="section-title">
                <h3>📝 Your Watchlist</h3>
                <p class="section-subtitle">Movies you want to watch</p>
            </div>
            <a href="/watchlist" class="view-all-link">
                <span>View All</span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="9,18 15,12 9,6"></polyline>
                </svg>
            </a>
        </div>

        <div class="horizontal-scroll-container">
            <div class="movies-horizontal-grid">
                <?php foreach (array_slice($data['watchlist'], 0, 8) as $index => $movie): ?>
                    <div class="movie-card-horizontal animate-card" 
                         style="animation-delay: <?php echo $index * 0.1; ?>s"
                         onclick="movieAppInstance.loadMovieDetails('<?php echo $movie['imdb_id']; ?>')">
                        <div class="movie-poster-horizontal">
                            <img src="<?php echo $movie['poster'] !== 'N/A' ? $movie['poster'] : '/public/assets/images/no-image.png'; ?>" 
                                 alt="<?php echo htmlspecialchars($movie['title']); ?>"
                                 onerror="this.src='/public/assets/images/no-image.png'"
                                 loading="lazy">
                            <div class="movie-overlay-horizontal">
                                <div class="overlay-actions-horizontal">
                                    <button class="action-btn-small btn-success" onclick="event.stopPropagation(); markWatched(<?php echo $movie['movie_id']; ?>)">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="20,6 9,17 4,12"></polyline>
                                        </svg>
                                    </button>
                                    <button class="action-btn-small btn-danger" onclick="event.stopPropagation(); removeFromWatchlist(<?php echo $movie['movie_id']; ?>)">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="3,6 5,6 21,6"></polyline>
                                            <path d="M19,6V20a2,2 0 0,1 -2,2H7a2,2 0 0,1 -2,-2V6M8,6V4a2,2 0 0,1 2,-2h4a2,2 0 0,1 2,2v2"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="movie-status-badge">
                                <?php if ($movie['rating'] && $movie['rating'] !== 'N/A'): ?>
                                    <span class="imdb-badge-small">IMDb <?php echo $movie['rating']; ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="movie-info-horizontal">
                            <h4><?php echo htmlspecialchars($movie['title']); ?></h4>
                            <p><?php echo $movie['year']; ?> • <?php echo htmlspecialchars(substr($movie['genre'], 0, 20)); ?></p>
                            <small class="added-date">
                                Added <?php echo $this->timeAgo($movie['created_at']); ?>
                            </small>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Recommendations Section -->
    <?php if (!empty($data['recommendations'])): ?>
    <div class="dashboard-section animate-on-scroll">
        <div class="section-header">
            <div class="section-title">
                <h3>💡 Recommended for You</h3>
                <p class="section-subtitle">Based on your preferences</p>
            </div>
            <div class="recommendation-refresh">
                <button class="btn btn-secondary btn-small" onclick="refreshRecommendations()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="23,4 23,10 17,10"></polyline>
                        <polyline points="1,20 1,14 7,14"></polyline>
                        <path d="M20.49,9A9,9 0 0,0 5.64,5.64L1,10m22,4a9,9 0 0,1 -14.85,4.36L23,14"></path>
                    </svg>
                    Refresh
                </button>
            </div>
        </div>

        <div class="horizontal-scroll-container">
            <div class="movies-horizontal-grid">
                <?php foreach (array_slice($data['recommendations'], 0, 8) as $index => $movie): ?>
                    <div class="movie-card-horizontal animate-card recommendation-card" 
                         style="animation-delay: <?php echo $index * 0.1; ?>s"
                         onclick="movieAppInstance.loadMovieDetails('<?php echo $movie['imdb_id']; ?>')">
                        <div class="movie-poster-horizontal">
                            <img src="<?php echo $movie['poster'] !== 'N/A' ? $movie['poster'] : '/public/assets/images/no-image.png'; ?>" 
                                 alt="<?php echo htmlspecialchars($movie['title']); ?>"
                                 onerror="this.src='/public/assets/images/no-image.png'"
                                 loading="lazy">
                            <div class="recommendation-badge">
                                <span>Recommended</span>
                            </div>
                            <div class="movie-status-badge">
                                <span class="imdb-badge-small">IMDb <?php echo $movie['rating']; ?></span>
                            </div>
                        </div>
                        <div class="movie-info-horizontal">
                            <h4><?php echo htmlspecialchars($movie['title']); ?></h4>
                            <p><?php echo $movie['year']; ?> • <?php echo htmlspecialchars(substr($movie['genre'], 0, 20)); ?></p>
                            <small class="recommendation-reason">Similar to your favorites</small>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Quick Actions Enhanced -->
    <div class="dashboard-section animate-on-scroll">
        <div class="section-header">
            <div class="section-title">
                <h3>⚡ Quick Actions</h3>
                <p class="section-subtitle">Jump to your favorite features</p>
            </div>
        </div>

        <div class="quick-actions-grid">
            <a href="/profile" class="quick-action-card">
                <div class="action-icon-wrapper">
                    <span class="action-icon">👤</span>
                </div>
                <div class="action-content">
                    <h4>View Profile</h4>
                    <p>See your stats and activity</p>
                </div>
                <div class="action-arrow">→</div>
            </a>

            <button onclick="loadRandomMovie()" class="quick-action-card">
                <div class="action-icon-wrapper">
                    <span class="action-icon">🎲</span>
                </div>
                <div class="action-content">
                    <h4>Random Movie</h4>
                    <p>Discover something new</p>
                </div>
                <div class="action-arrow">→</div>
            </button>

            <a href="/" class="quick-action-card">
                <div class="action-icon-wrapper">
                    <span class="action-icon">🔍</span>
                </div>
                <div class="action-content">
                    <h4>Advanced Search</h4>
                    <p>Find specific movies</p>
                </div>
                <div class="action-arrow">→</div>
            </a>

            <button onclick="showMovieOfTheDay()" class="quick-action-card featured">
                <div class="action-icon-wrapper">
                    <span class="action-icon">🌟</span>
                </div>
                <div class="action-content">
                    <h4>Movie of the Day</h4>
                    <p>Today's featured pick</p>
                </div>
                <div class="featured-badge">Hot</div>
            </button>
        </div>
    </div>

    <!-- Empty State for New Users -->
    <?php if (empty($data['watchlist']) && empty($data['recently_watched'])): ?>
    <div class="empty-state-dashboard animate-on-scroll">
        <div class="empty-state-animation">
            <div class="empty-icon">🎬</div>
            <div class="empty-particles">
                <span class="particle">⭐</span>
                <span class="particle">🍿</span>
                <span class="particle">🎭</span>
            </div>
        </div>
        <div class="empty-content">
            <h3>Start Your Movie Journey!</h3>
            <p>Search for movies, add them to your watchlist, and start rating to get personalized recommendations.</p>
            <div class="empty-actions">
                <a href="/" class="btn btn-primary">
                    <span>🔍</span> Search Movies
                </a>
                <button onclick="showGettingStarted()" class="btn btn-secondary">
                    <span>📖</span> Getting Started
                </button>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Enhanced JavaScript for Dashboard -->
<script>
// Dashboard-specific functionality
async function removeFromWatchlist(movieId) {
    if (!confirm('Remove this movie from your watchlist?')) return;

    try {
        const formData = new FormData();
        formData.append('movieId', movieId);

        const response = await fetch('/api/watchlist/remove', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            movieAppInstance.showToast('Movie removed from watchlist', 'success');
            // Animate out the card
            const card = event.target.closest('.movie-card-horizontal');
            if (card) {
                card.style.transform = 'scale(0)';
                card.style.opacity = '0';
                setTimeout(() => card.remove(), 300);
            }
        } else {
            movieAppInstance.showToast('Error: ' + data.error, 'error');
        }
    } catch (error) {
        movieAppInstance.showToast('Error removing from watchlist', 'error');
    }
}

async function markWatched(movieId) {
    try {
        const formData = new FormData();
        formData.append('movieId', movieId);

        const response = await fetch('/api/movie/watch', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            movieAppInstance.showToast('Movie marked as watched! 🎉', 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            movieAppInstance.showToast('Error: ' + data.error, 'error');
        }
    } catch (error) {
        movieAppInstance.showToast('Error marking movie as watched', 'error');
    }
}

async function loadRandomMovie() {
    movieAppInstance.showToast('Finding a random movie...', 'info');

    try {
        // This would ideally call a dedicated random movie endpoint
        const response = await fetch('/api/movies/trending?limit=50');
        const data = await response.json();

        if (data.success && data.movies.length > 0) {
            const randomMovie = data.movies[Math.floor(Math.random() * data.movies.length)];
            movieAppInstance.loadMovieDetails(randomMovie.imdb_id);
        } else {
            movieAppInstance.showToast('No random movie available', 'warning');
        }
    } catch (error) {
        movieAppInstance.showToast('Failed to load random movie', 'error');
    }
}

function refreshRecommendations() {
    movieAppInstance.showToast('Refreshing recommendations...', 'info');
    // This would ideally refresh the recommendations
    setTimeout(() => {
        movieAppInstance.showToast('Recommendations updated!', 'success');
    }, 1500);
}

function showMovieOfTheDay() {
    movieAppInstance.showToast('Loading movie of the day...', 'info');
    // Implement movie of the day feature
}

function showGettingStarted() {
    // Show a getting started modal or guide
    alert('Getting started guide would go here!');
}

// Animate elements on scroll
function animateOnScroll() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-visible');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.animate-on-scroll').forEach(el => {
        observer.observe(el);
    });
}

// Initialize dashboard animations
document.addEventListener('DOMContentLoaded', () => {
    animateOnScroll();

    // Stagger animate cards
    document.querySelectorAll('.animate-card').forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
    });
});

// Add time ago functionality (PHP helper would be better)
<?php if (!function_exists('timeAgo')): ?>
<?php 
function timeAgo($datetime) {
    $time = time() - strtotime($datetime);

    if ($time < 60) return 'just now';
    if ($time < 3600) return floor($time/60) . 'm ago';
    if ($time < 86400) return floor($time/3600) . 'h ago';
    if ($time < 2592000) return floor($time/86400) . 'd ago';

    return date('M j', strtotime($datetime));
}
?>
<?php endif; ?>
</script>

<!-- Enhanced Dashboard Styles -->
<style>
.dashboard-welcome {
    background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(255,255,255,0.7) 100%);
    backdrop-filter: blur(20px) saturate(180%);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: var(--radius-2xl);
    padding: var(--space-8);
    margin-bottom: var(--space-8);
    box-shadow: var(--shadow-xl);
    position: relative;
    overflow: hidden;
}

.welcome-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: var(--space-6);
}

.welcome-text h2 {
    font-size: var(--font-size-3xl);
    color: var(--neutral-800);
    margin-bottom: var(--space-2);
    font-weight: 900;
}

.welcome-text p {
    color: var(--neutral-600);
    font-size: var(--font-size-lg);
}

.dashboard-stats-preview {
    display: flex;
    gap: var(--space-6);
}

.stat-preview-item {
    text-align: center;
    padding: var(--space-4);
    background: rgba(255,255,255,0.5);
    border-radius: var(--radius-xl);
    border: 1px solid rgba(255,255,255,0.3);
}

.stat-preview-item .stat-number {
    display: block;
    font-size: var(--font-size-2xl);
    font-weight: 800;
    color: var(--primary-600);
}

.stat-preview-item .stat-label {
    font-size: var(--font-size-sm);
    color: var(--neutral-600);
    font-weight: 600;
}

.stat-card {
    position: relative;
    cursor: pointer;
    overflow: hidden;
}

.stat-icon-wrapper {
    position: relative;
    margin-bottom: var(--space-4);
}

.stat-icon-bg {
    position: absolute;
    top: -10px;
    left: -10px;
    width: 60px;
    height: 60px;
    background: var(--gradient-primary);
    opacity: 0.1;
    border-radius: 50%;
    transition: var(--transition-base);
}

.stat-card:hover .stat-icon-bg {
    transform: scale(1.2);
    opacity: 0.2;
}

.stat-progress {
    width: 100%;
    height: 4px;
    background: var(--neutral-200);
    border-radius: var(--radius-full);
    margin-top: var(--space-3);
    overflow: hidden;
}

.progress-bar-fill {
    height: 100%;
    background: var(--gradient-primary);
    border-radius: var(--radius-full);
    transition: width 1s ease-out;
}

.stat-arrow {
    position: absolute;
    top: var(--space-4);
    right: var(--space-4);
    font-size: var(--font-size-lg);
    color: var(--neutral-400);
    transition: var(--transition-base);
}

.stat-card:hover .stat-arrow {
    color: var(--primary-600);
    transform: translateX(4px);
}

.stat-badge {
    position: absolute;
    top: var(--space-3);
    right: var(--space-3);
    background: var(--gradient-primary);
    color: white;
    padding: var(--space-1) var(--space-2);
    border-radius: var(--radius-md);
    font-size: var(--font-size-xs);
    font-weight: 700;
}

.section-title h3 {
    font-size: var(--font-size-2xl);
    color: white;
    font-weight: 800;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    margin-bottom: var(--space-1);
}

.section-subtitle {
    color: rgba(255,255,255,0.8);
    font-size: var(--font-size-sm);
}

.horizontal-scroll-container {
    overflow-x: auto;
    overflow-y: hidden;
    padding-bottom: var(--space-2);
}

.movies-horizontal-grid {
    display: flex;
    gap: var(--space-4);
    padding: var(--space-2) 0;
}

.movie-card-horizontal {
    flex: 0 0 200px;
    background: white;
    border-radius: var(--radius-xl);
    overflow: hidden;
    cursor: pointer;
    transition: var(--transition-base);
    box-shadow: var(--shadow-md);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.movie-card-horizontal:hover {
    transform: translateY(-6px) scale(1.02);
    box-shadow: var(--shadow-xl);
}

.movie-poster-horizontal {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.movie-poster-horizontal img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: var(--transition-base);
}

.movie-card-horizontal:hover .movie-poster-horizontal img {
    transform: scale(1.05);
}

.movie-overlay-horizontal {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: var(--transition-base);
}

.movie-card-horizontal:hover .movie-overlay-horizontal {
    opacity: 1;
}

.play-button {
    background: rgba(255,255,255,0.9);
    border: none;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: var(--transition-base);
}

.play-button:hover {
    background: white;
    transform: scale(1.1);
}

.overlay-actions-horizontal {
    display: flex;
    gap: var(--space-2);
}

.action-btn-small {
    background: rgba(255,255,255,0.9);
    border: none;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: var(--transition-base);
}

.action-btn-small.btn-success {
    background: var(--success-500);
    color: white;
}

.action-btn-small.btn-danger {
    background: var(--error-500);
    color: white;
}

.movie-status-badge {
    position: absolute;
    top: var(--space-2);
    right: var(--space-2);
    z-index: 10;
}

.rating-badge-small,
.imdb-badge-small {
    background: rgba(0,0,0,0.8);
    color: white;
    padding: var(--space-1) var(--space-2);
    border-radius: var(--radius-md);
    font-size: var(--font-size-xs);
    font-weight: 700;
}

.imdb-badge-small {
    background: #f59e0b;
    color: black;
}

.movie-info-horizontal {
    padding: var(--space-3);
}

.movie-info-horizontal h4 {
    font-size: var(--font-size-sm);
    font-weight: 700;
    color: var(--neutral-800);
    margin-bottom: var(--space-1);
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.movie-info-horizontal p {
    color: var(--neutral-500);
    font-size: var(--font-size-xs);
    margin-bottom: var(--space-1);
}

.watched-date,
.added-date,
.recommendation-reason {
    color: var(--neutral-400);
    font-size: var(--font-size-xs);
}

.recommendation-badge {
    position: absolute;
    top: var(--space-2);
    left: var(--space-2);
    background: var(--gradient-primary);
    color: white;
    padding: var(--space-1) var(--space-2);
    border-radius: var(--radius-md);
    font-size: var(--font-size-xs);
    font-weight: 700;
}

.recommendation-card {
    border: 2px solid transparent;
    background: linear-gradient(white, white) padding-box,
                var(--gradient-primary) border-box;
}

.quick-actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: var(--space-4);
}

.quick-action-card {
    display: flex;
    align-items: center;
    gap: var(--space-4);
    padding: var(--space-5);
    background: white;
    border: 2px solid var(--neutral-100);
    border-radius: var(--radius-xl);
    text-decoration: none;
    color: var(--neutral-700);
    transition: var(--transition-base);
    cursor: pointer;
    position: relative;
    overflow: hidden;
}

.quick-action-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-xl);
    border-color: var(--primary-200);
}

.quick-action-card.featured {
    background: var(--gradient-primary);
    color: white;
    border-color: var(--primary-600);
}

.action-icon-wrapper {
    width: 50px;
    height: 50px;
    background: var(--neutral-100);
    border-radius: var(--radius-xl);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.quick-action-card.featured .action-icon-wrapper {
    background: rgba(255,255,255,0.2);
}

.action-icon {
    font-size: var(--font-size-xl);
}

.action-content h4 {
    font-size: var(--font-size-base);
    font-weight: 700;
    margin-bottom: var(--space-1);
}

.action-content p {
    font-size: var(--font-size-sm);
    opacity: 0.8;
}

.action-arrow {
    margin-left: auto;
    font-size: var(--font-size-lg);
    opacity: 0.5;
    transition: var(--transition-base);
}

.quick-action-card:hover .action-arrow {
    opacity: 1;
    transform: translateX(4px);
}

.featured-badge {
    position: absolute;
    top: var(--space-2);
    right: var(--space-2);
    background: rgba(255,255,255,0.2);
    color: white;
    padding: var(--space-1) var(--space-2);
    border-radius: var(--radius-md);
    font-size: var(--font-size-xs);
    font-weight: 700;
}

.empty-state-dashboard {
    background: white;
    border-radius: var(--radius-2xl);
    padding: var(--space-16) var(--space-8);
    text-align: center;
    box-shadow: var(--shadow-xl);
    border: 1px solid var(--neutral-100);
    position: relative;
    overflow: hidden;
}

.empty-state-animation {
    position: relative;
    margin-bottom: var(--space-8);
}

.empty-icon {
    font-size: 5rem;
    margin-bottom: var(--space-4);
    animation: bounce 2s ease-in-out infinite;
}

.empty-particles {
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 200px;
    height: 200px;
}

.particle {
    position: absolute;
    font-size: 1.5rem;
    animation: float 4s ease-in-out infinite;
}

.particle:nth-child(1) { top: 20%; left: 20%; animation-delay: 0s; }
.particle:nth-child(2) { top: 60%; right: 20%; animation-delay: 1s; }
.particle:nth-child(3) { bottom: 20%; left: 30%; animation-delay: 2s; }

.empty-actions {
    display: flex;
    gap: var(--space-4);
    justify-content: center;
    margin-top: var(--space-6);
}

.animate-on-scroll {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.animate-on-scroll.animate-visible {
    opacity: 1;
    transform: translateY(0);
}

.animate-card {
    opacity: 0;
    transform: translateY(20px);
    animation: slideUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
}

@keyframes slideUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
    40% { transform: translateY(-10px); }
    60% { transform: translateY(-5px); }
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.3; }
    50% { transform: translateY(-20px) rotate(180deg); opacity: 0.8; }
}

@media (max-width: 768px) {
    .welcome-content {
        flex-direction: column;
        text-align: center;
        gap: var(--space-4);
    }

    .dashboard-stats-preview {
        justify-content: center;
    }

    .movie-card-horizontal {
        flex: 0 0 160px;
    }

    .quick-actions-grid {
        grid-template-columns: 1fr;
    }

    .empty-actions {
        flex-direction: column;
        align-items: center;
    }
}
</style>