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
                    <div class="progress-bar-fill watchlist-progress" data-progress="<?php echo min(100, count($data['watchlist'] ?? []) * 10); ?>"></div>
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
                    <div class="progress-bar-fill watched-progress" data-progress="<?php echo min(100, count($data['recently_watched'] ?? []) * 20); ?>"></div>
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
                    <div class="progress-bar-fill recommendations-progress" data-progress="<?php echo min(100, count($data['recommendations'] ?? []) * 15); ?>"></div>
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
                     data-animation-delay="<?php echo $index * 0.1; ?>"
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
                     data-animation-delay="<?php echo $index * 0.1; ?>"
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
                     data-animation-delay="<?php echo $index * 0.1; ?>"
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

