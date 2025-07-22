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