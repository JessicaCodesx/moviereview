<?php
?>
<div class="user-page-container">
    <div class="page-header">
        <h2>📝 Your Watchlist</h2>
        <p>Movies you want to watch</p>
    </div>

    <?php if (!empty($data['watchlist'])): ?>
        <div class="movies-grid">
            <?php foreach ($data['watchlist'] as $movie): ?>
                <div class="movie-card watchlist-card" onclick="movieAppInstance.loadMovieDetails('<?php echo $movie['imdb_id']; ?>')">
                    <div class="movie-poster">
                        <img src="<?php echo $movie['poster'] !== 'N/A' ? $movie['poster'] : '/public/assets/images/no-image.png'; ?>" 
                             alt="<?php echo htmlspecialchars($movie['title']); ?>"
                             onerror="this.src='/public/assets/images/no-image.png'">

                        <div class="movie-overlay">
                            <div class="overlay-actions">
                                <button class="overlay-btn btn-success" onclick="event.stopPropagation(); markWatched(<?php echo $movie['movie_id']; ?>)">
                                    ✅ Mark Watched
                                </button>
                                <button class="overlay-btn btn-danger" onclick="event.stopPropagation(); removeFromWatchlist(<?php echo $movie['movie_id']; ?>)">
                                    🗑️ Remove
                                </button>
                            </div>
                        </div>

                        <div class="movie-badge">
                            <?php if ($movie['imdb_rating'] && $movie['imdb_rating'] !== 'N/A'): ?>
                                <span class="imdb-badge">IMDb <?php echo $movie['imdb_rating']; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="movie-card-info">
                        <h4><?php echo htmlspecialchars($movie['title']); ?></h4>
                        <p><?php echo $movie['year']; ?> • <?php echo htmlspecialchars($movie['genre']); ?></p>
                        <small class="added-date">Added on <?php echo date('M j, Y', strtotime($movie['created_at'])); ?></small>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination if needed -->
        <?php if (count($data['watchlist']) >= 20): ?>
        <div class="pagination">
            <a href="/watchlist?page=<?php echo max(1, $data['current_page'] - 1); ?>" class="btn btn-secondary">
                ← Previous
            </a>
            <span class="page-info">Page <?php echo $data['current_page']; ?></span>
            <a href="/watchlist?page=<?php echo $data['current_page'] + 1; ?>" class="btn btn-secondary">
                Next →
            </a>
        </div>
        <?php endif; ?>

    <?php else: ?>
        <div class="empty-state">
            <div class="empty-state-icon">📝</div>
            <h3>Your Watchlist is Empty</h3>
            <p>Start adding movies you want to watch to your watchlist.</p>
            <a href="/" class="btn btn-primary">Search Movies</a>
        </div>
    <?php endif; ?>
</div>

<style>
.user-page-container {
    max-width: 1400px;
    margin: 0 auto;
}

.page-header {
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(10px);
    border-radius: var(--border-radius);
    padding: 30px;
    margin-bottom: 30px;
    text-align: center;
    box-shadow: var(--card-shadow);
}

.page-header h2 {
    font-size: 2.2rem;
    color: var(--text-color);
    margin-bottom: 8px;
    font-weight: 700;
}

.page-header p {
    color: var(--text-light);
    font-size: 18px;
}

.watchlist-card .movie-overlay {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 12px;
}

.overlay-actions {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.overlay-btn {
    background: white;
    color: var(--text-color);
    border: none;
    padding: 8px 12px;
    border-radius: 6px;
    font-weight: 600;
    font-size: 12px;
    cursor: pointer;
    transition: var(--transition);
    white-space: nowrap;
}

.overlay-btn.btn-success {
    background: var(--success-color);
    color: white;
}

.overlay-btn.btn-danger {
    background: var(--error-color);
    color: white;
}

.overlay-btn:hover {
    transform: scale(1.05);
}

.added-date {
    color: var(--text-light);
    font-size: 11px;
    margin-top: 4px;
    display: block;
}

.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 20px;
    margin-top: 40px;
    padding: 20px;
}

.page-info {
    color: white;
    font-weight: 600;
}
</style>

<script>
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
            // Reload page to update the list
            setTimeout(() => location.reload(), 1000);
        } else {
            movieAppInstance.showToast('Error: ' + data.error, 'error');
        }
    } catch (error) {
        movieAppInstance.showToast('Error marking movie as watched', 'error');
    }
}

async function removeFromWatchlist(movieId) {
    if (!confirm('Remove this movie from your watchlist?')) {
        return;
    }

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
            // Reload page to update the list
            setTimeout(() => location.reload(), 1000);
        } else {
            movieAppInstance.showToast('Error: ' + data.error, 'error');
        }
    } catch (error) {
        movieAppInstance.showToast('Error removing movie from watchlist', 'error');
    }
}
</script>