<?php
?>
<div class="user-page-container">
    <div class="page-header">
        <h2>✅ Movies You've Watched</h2>
        <p>Keep track of your movie journey</p>
    </div>

    <?php if (!empty($data['watched_movies'])): ?>
        <div class="movies-grid">
            <?php foreach ($data['watched_movies'] as $movie): ?>
                <div class="movie-card watched-card" onclick="movieAppInstance.loadMovieDetails('<?php echo $movie['imdb_id']; ?>')">
                    <div class="movie-poster">
                        <img src="<?php echo $movie['poster'] !== 'N/A' ? $movie['poster'] : '/public/assets/images/no-image.png'; ?>" 
                             alt="<?php echo htmlspecialchars($movie['title']); ?>"
                             onerror="this.src='/public/assets/images/no-image.png'">

                        <div class="movie-overlay">
                            <div class="overlay-actions">
                                <?php if (!$movie['user_rating']): ?>
                                    <button class="overlay-btn btn-primary" onclick="event.stopPropagation(); movieAppInstance.loadMovieDetails('<?php echo $movie['imdb_id']; ?>')">
                                        ⭐ Rate Movie
                                    </button>
                                <?php endif; ?>
                                <button class="overlay-btn btn-secondary" onclick="event.stopPropagation(); unmarkWatched(<?php echo $movie['movie_id']; ?>)">
                                    ↩️ Unmark Watched
                                </button>
                            </div>
                        </div>

                        <div class="movie-badges">
                            <?php if ($movie['user_rating']): ?>
                                <span class="rating-badge">⭐ <?php echo $movie['user_rating']; ?></span>
                            <?php endif; ?>
                            <?php if ($movie['imdb_rating'] && $movie['imdb_rating'] !== 'N/A'): ?>
                                <span class="imdb-badge">IMDb <?php echo $movie['imdb_rating']; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="movie-card-info">
                        <h4><?php echo htmlspecialchars($movie['title']); ?></h4>
                        <p><?php echo $movie['year']; ?> • <?php echo htmlspecialchars($movie['genre']); ?></p>

                        <?php if ($movie['user_rating']): ?>
                            <div class="user-rating-display">
                                <span class="rating-stars">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <span class="star <?php echo $i <= $movie['user_rating'] ? 'filled' : ''; ?>">⭐</span>
                                    <?php endfor; ?>
                                </span>
                            </div>
                        <?php endif; ?>

                        <small class="watched-date">
                            Watched on <?php echo date('M j, Y', strtotime($movie['watched_at'])); ?>
                        </small>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination if needed -->
        <?php if (count($data['watched_movies']) >= 20): ?>
        <div class="pagination">
            <a href="/watched?page=<?php echo max(1, $data['current_page'] - 1); ?>" class="btn btn-secondary">
                ← Previous
            </a>
            <span class="page-info">Page <?php echo $data['current_page']; ?></span>
            <a href="/watched?page=<?php echo $data['current_page'] + 1; ?>" class="btn btn-secondary">
                Next →
            </a>
        </div>
        <?php endif; ?>

    <?php else: ?>
        <div class="empty-state">
            <div class="empty-state-icon">🎬</div>
            <h3>No Movies Watched Yet</h3>
            <p>Start watching movies and mark them as watched to track your progress!</p>
            <a href="/" class="btn btn-primary">Search Movies</a>
        </div>
    <?php endif; ?>
</div>

<style>
.watched-card .movie-overlay {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 12px;
}

.movie-badges {
    position: absolute;
    top: 12px;
    right: 12px;
    display: flex;
    flex-direction: column;
    gap: 4px;
    z-index: 10;
}

.rating-badge {
    background: rgba(0,0,0,0.8);
    color: #ffc107;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 600;
}

.user-rating-display {
    margin: 8px 0 4px 0;
}

.rating-stars {
    display: flex;
    gap: 2px;
}

.rating-stars .star {
    font-size: 14px;
    color: #ddd;
}

.rating-stars .star.filled {
    color: #ffc107;
}

.watched-date {
    color: var(--text-light);
    font-size: 11px;
    margin-top: 4px;
    display: block;
}

.overlay-btn.btn-primary {
    background: var(--primary-color);
    color: white;
}

.overlay-btn.btn-secondary {
    background: rgba(255,255,255,0.9);
    color: var(--text-color);
}

/* Statistics Section */
.stats-section {
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(10px);
    border-radius: var(--border-radius);
    padding: 24px;
    margin-bottom: 30px;
    box-shadow: var(--card-shadow);
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 20px;
    margin-top: 16px;
}

.stat-item {
    text-align: center;
    padding: 16px;
    background: var(--light-bg);
    border-radius: 8px;
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 4px;
}

.stat-label {
    font-size: 14px;
    color: var(--text-light);
    font-weight: 500;
}
</style>

<script>
async function unmarkWatched(movieId) {
    if (!confirm('Remove this movie from your watched list?')) {
        return;
    }

    try {
        const formData = new FormData();
        formData.append('movieId', movieId);

        const response = await fetch('/api/movie/unwatch', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            movieAppInstance.showToast('Movie unmarked as watched', 'success');
            // Reload page to update the list
            setTimeout(() => location.reload(), 1000);
        } else {
            movieAppInstance.showToast('Error: ' + data.error, 'error');
        }
    } catch (error) {
        movieAppInstance.showToast('Error unmarking movie as watched', 'error');
    }
}
</script>