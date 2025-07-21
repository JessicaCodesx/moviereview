<?php
?>
<div class="dashboard-container">
    <!-- Welcome Section -->
    <div class="dashboard-welcome">
        <h2>Welcome back, <?php echo htmlspecialchars($_SESSION['user']['username']); ?>! 🎬</h2>
        <p>Discover, rate, and track your favorite movies</p>
    </div>

    <!-- Quick Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">📝</div>
            <div class="stat-content">
                <h3><?php echo count($data['watchlist'] ?? []); ?></h3>
                <p>In Watchlist</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">✅</div>
            <div class="stat-content">
                <h3><?php echo count($data['recently_watched'] ?? []); ?></h3>
                <p>Recently Watched</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">⭐</div>
            <div class="stat-content">
                <h3><?php echo count($data['recommendations'] ?? []); ?></h3>
                <p>Recommendations</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🔍</div>
            <div class="stat-content">
                <h3><a href="/" class="stat-link">Search Movies</a></h3>
                <p>Find New Movies</p>
            </div>
        </div>
    </div>

    <!-- Watchlist Section -->
    <?php if (!empty($data['watchlist'])): ?>
    <div class="dashboard-section">
        <div class="section-header">
            <h3>🎬 Your Watchlist</h3>
            <a href="/watchlist" class="view-all-link">View All</a>
        </div>
        <div class="movies-grid">
            <?php foreach (array_slice($data['watchlist'], 0, 6) as $movie): ?>
                <div class="movie-card" onclick="movieAppInstance.loadMovieDetails('<?php echo $movie['imdb_id']; ?>')">
                    <div class="movie-poster">
                        <img src="<?php echo $movie['poster'] !== 'N/A' ? $movie['poster'] : '/public/assets/images/no-image.png'; ?>" 
                             alt="<?php echo htmlspecialchars($movie['title']); ?>"
                             onerror="this.src='/public/assets/images/no-image.png'">
                        <div class="movie-overlay">
                            <button class="overlay-btn" onclick="event.stopPropagation(); removeFromWatchlist(<?php echo $movie['movie_id']; ?>)">
                                Remove
                            </button>
                        </div>
                    </div>
                    <div class="movie-card-info">
                        <h4><?php echo htmlspecialchars($movie['title']); ?></h4>
                        <p><?php echo $movie['year']; ?> • <?php echo $movie['genre']; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Recently Watched Section -->
    <?php if (!empty($data['recently_watched'])): ?>
    <div class="dashboard-section">
        <div class="section-header">
            <h3>✅ Recently Watched</h3>
            <a href="/watched" class="view-all-link">View All</a>
        </div>
        <div class="movies-grid">
            <?php foreach (array_slice($data['recently_watched'], 0, 6) as $movie): ?>
                <div class="movie-card" onclick="movieAppInstance.loadMovieDetails('<?php echo $movie['imdb_id']; ?>')">
                    <div class="movie-poster">
                        <img src="<?php echo $movie['poster'] !== 'N/A' ? $movie['poster'] : '/public/assets/images/no-image.png'; ?>" 
                             alt="<?php echo htmlspecialchars($movie['title']); ?>"
                             onerror="this.src='/public/assets/images/no-image.png'">
                        <div class="movie-badge">
                            <?php if ($movie['user_rating']): ?>
                                <span class="rating-badge">⭐ <?php echo $movie['user_rating']; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="movie-card-info">
                        <h4><?php echo htmlspecialchars($movie['title']); ?></h4>
                        <p><?php echo $movie['year']; ?> • <?php echo $movie['genre']; ?></p>
                        <small>Watched on <?php echo date('M j, Y', strtotime($movie['watched_at'])); ?></small>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Recommendations Section -->
    <?php if (!empty($data['recommendations'])): ?>
    <div class="dashboard-section">
        <div class="section-header">
            <h3>💡 Recommended for You</h3>
            <p class="section-subtitle">Based on your watchlist preferences</p>
        </div>
        <div class="movies-grid">
            <?php foreach (array_slice($data['recommendations'], 0, 6) as $movie): ?>
                <div class="movie-card" onclick="movieAppInstance.loadMovieDetails('<?php echo $movie['imdb_id']; ?>')">
                    <div class="movie-poster">
                        <img src="<?php echo $movie['poster'] !== 'N/A' ? $movie['poster'] : '/public/assets/images/no-image.png'; ?>" 
                             alt="<?php echo htmlspecialchars($movie['title']); ?>"
                             onerror="this.src='/public/assets/images/no-image.png'">
                        <div class="movie-badge">
                            <span class="imdb-badge">IMDb <?php echo $movie['rating']; ?></span>
                        </div>
                    </div>
                    <div class="movie-card-info">
                        <h4><?php echo htmlspecialchars($movie['title']); ?></h4>
                        <p><?php echo $movie['year']; ?> • <?php echo $movie['genre']; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Empty State -->
    <?php if (empty($data['watchlist']) && empty($data['recently_watched'])): ?>
    <div class="empty-state">
        <div class="empty-state-icon">🎬</div>
        <h3>Start Your Movie Journey!</h3>
        <p>Search for movies to add them to your watchlist and start rating them.</p>
        <a href="/" class="btn btn-primary">Search Movies</a>
    </div>
    <?php endif; ?>
</div>

<script>
async function removeFromWatchlist(movieId) {
    try {
        const formData = new FormData();
        formData.append('movieId', movieId);

        const response = await fetch('/api/watchlist/remove', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            location.reload(); // Simple refresh for now
        } else {
            alert('Error: ' + data.error);
        }
    } catch (error) {
        alert('Error removing from watchlist');
    }
}
</script>