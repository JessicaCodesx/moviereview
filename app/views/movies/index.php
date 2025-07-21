<?php
$isLoggedIn = isset($_SESSION['user']) && !empty($_SESSION['user']['id']);
?>

<div class="search-section">
    <div class="search-box">
        <input type="text" id="searchInput" class="search-input" placeholder="Search for a movie..." />
        <button onclick="movieAppInstance.searchMovies()" class="search-btn">🔍 Search</button>
    </div>
    <div id="searchResults" class="search-results"></div>
</div>

<?php if ($isLoggedIn && !empty($data['recent_ratings'])): ?>
<div class="personalized-section">
    <div class="section-header">
        <h3>🎬 Your Recent Ratings</h3>
        <a href="/profile" class="view-all-link">View All</a>
    </div>
    <div class="recent-ratings">
        <?php foreach (array_slice($data['recent_ratings'], 0, 5) as $rating): ?>
            <div class="rating-card" onclick="movieAppInstance.loadMovieDetails('<?php echo $rating['imdb_id']; ?>')">
                <div class="rating-poster">
                    <img src="<?php echo $rating['poster'] !== 'N/A' ? $rating['poster'] : '/public/assets/images/no-image.png'; ?>" 
                         alt="<?php echo htmlspecialchars($rating['title']); ?>"
                         onerror="this.src='/public/assets/images/no-image.png'">
                    <div class="rating-overlay">
                        <span class="rating-badge">⭐ <?php echo $rating['rating']; ?></span>
                    </div>
                </div>
                <div class="rating-info">
                    <h4><?php echo htmlspecialchars($rating['title']); ?></h4>
                    <p><?php echo $rating['year']; ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<?php if (!$isLoggedIn || (!empty($data['popular_movies']) && empty($data['recent_ratings']))): ?>
<div class="popular-section">
    <div class="section-header">
        <h3>⭐ Popular Movies</h3>
        <?php if (!$isLoggedIn): ?>
            <p class="section-subtitle">
                <a href="/register" class="signup-link">Sign up</a> to track your ratings and get personalized recommendations!
            </p>
        <?php endif; ?>
    </div>
    <?php if (!empty($data['popular_movies'])): ?>
        <div class="popular-movies">
            <?php foreach ($data['popular_movies'] as $movie): ?>
                <div class="movie-card popular-card" onclick="movieAppInstance.loadMovieDetails('<?php echo $movie['imdb_id']; ?>')">
                    <div class="movie-poster">
                        <img src="<?php echo $movie['poster'] !== 'N/A' ? $movie['poster'] : '/public/assets/images/no-image.png'; ?>" 
                             alt="<?php echo htmlspecialchars($movie['title']); ?>"
                             onerror="this.src='/public/assets/images/no-image.png'">
                        <div class="movie-badge">
                            <span class="avg-badge">⭐ <?php echo number_format($movie['avg_rating'], 1); ?></span>
                        </div>
                    </div>
                    <div class="movie-card-info">
                        <h4><?php echo htmlspecialchars($movie['title']); ?></h4>
                        <p><?php echo $movie['year']; ?> • <?php echo htmlspecialchars($movie['genre']); ?></p>
                        <small><?php echo $movie['rating_count']; ?> rating<?php echo $movie['rating_count'] !== 1 ? 's' : ''; ?></small>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="popular-placeholder">
            <p>Popular movies will appear here as users rate them!</p>
        </div>
    <?php endif; ?>
</div>
<?php endif; ?>

<div id="movieDetails" class="movie-details"></div>

<?php if ($isLoggedIn): ?>
<div class="quick-actions">
    <h3>Quick Actions</h3>
    <div class="action-grid">
        <a href="/dashboard" class="quick-action-btn">
            <span class="action-icon">📊</span>
            <span class="action-text">Dashboard</span>
        </a>
        <a href="/watchlist" class="quick-action-btn">
            <span class="action-icon">📝</span>
            <span class="action-text">Watchlist</span>
        </a>
        <a href="/watched" class="quick-action-btn">
            <span class="action-icon">✅</span>
            <span class="action-text">Watched</span>
        </a>
        <button onclick="loadRandomMovie()" class="quick-action-btn">
            <span class="action-icon">🎲</span>
            <span class="action-text">Random Movie</span>
        </button>
    </div>
</div>
<?php else: ?>
<div class="guest-cta">
    <div class="cta-content">
        <h3>🎬 Ready to start your movie journey?</h3>
        <p>Join Movie Review Hub to track your watchlist, rate movies, and get personalized recommendations!</p>
        <div class="cta-actions">
            <a href="/register" class="btn btn-primary">Sign Up Free</a>
            <a href="/login" class="btn btn-secondary">Login</a>
        </div>
    </div>
</div>
<?php endif; ?>

<style>
.personalized-section, .popular-section, .quick-actions {
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(10px);
    border-radius: var(--border-radius);
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: var(--card-shadow);
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.section-header h3 {
    color: var(--text-color);
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0;
}

.section-subtitle {
    color: var(--text-light);
    font-size: 14px;
    margin-top: 4px;
}

.signup-link {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
}

.signup-link:hover {
    text-decoration: underline;
}

.view-all-link {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
}

.recent-ratings, .popular-movies {
    display: flex;
    gap: 20px;
    overflow-x: auto;
    padding-bottom: 10px;
}

.recent-ratings::-webkit-scrollbar, .popular-movies::-webkit-scrollbar {
    height: 6px;
}

.recent-ratings::-webkit-scrollbar-track, .popular-movies::-webkit-scrollbar-track {
    background: var(--light-bg);
    border-radius: 3px;
}

.recent-ratings::-webkit-scrollbar-thumb, .popular-movies::-webkit-scrollbar-thumb {
    background: var(--primary-color);
    border-radius: 3px;
}

.rating-card, .popular-card {
    flex: 0 0 150px;
    background: white;
    border-radius: var(--border-radius);
    overflow: hidden;
    cursor: pointer;
    transition: var(--transition);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.rating-card:hover, .popular-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--card-shadow);
}

.rating-poster, .movie-poster {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.rating-poster img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: var(--transition);
}

.rating-card:hover .rating-poster img {
    transform: scale(1.05);
}

.rating-overlay {
    position: absolute;
    top: 8px;
    right: 8px;
}

.rating-badge, .avg-badge {
    background: rgba(0,0,0,0.8);
    color: #ffc107;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 600;
}

.avg-badge {
    color: white;
}

.rating-info, .movie-card-info {
    padding: 12px;
}

.rating-info h4 {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-color);
    margin-bottom: 4px;
    line-height: 1.2;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.rating-info p {
    color: var(--text-light);
    font-size: 12px;
    margin: 0;
}

.popular-placeholder {
    text-align: center;
    padding: 40px 20px;
    color: var(--text-light);
}

.action-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
}

.quick-action-btn {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px 20px;
    background: var(--light-bg);
    border: none;
    border-radius: var(--border-radius);
    text-decoration: none;
    color: var(--text-color);
    font-weight: 600;
    transition: var(--transition);
    cursor: pointer;
}

.quick-action-btn:hover {
    background: var(--primary-color);
    color: white;
    transform: translateY(-2px);
}

.action-icon {
    font-size: 1.2rem;
}

.guest-cta {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
    border: 2px solid rgba(102, 126, 234, 0.2);
    border-radius: var(--border-radius);
    padding: 40px;
    margin-bottom: 30px;
    text-align: center;
}

.cta-content h3 {
    color: var(--text-color);
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 12px;
}

.cta-content p {
    color: var(--text-light);
    font-size: 16px;
    margin-bottom: 24px;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.cta-actions {
    display: flex;
    gap: 16px;
    justify-content: center;
    flex-wrap: wrap;
}

@media (max-width: 768px) {
    .recent-ratings, .popular-movies {
        gap: 16px;
    }

    .rating-card, .popular-card {
        flex: 0 0 130px;
    }

    .action-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .cta-actions {
        flex-direction: column;
        align-items: center;
    }

    .cta-actions .btn {
        width: 100%;
        max-width: 300px;
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

// Auto-focus search on page load
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    if (searchInput && window.innerWidth > 768) {
        searchInput.focus();
    }
});
</script>