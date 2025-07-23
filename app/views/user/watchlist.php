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
/* Enhanced Watchlist Styles */
.user-page-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 var(--space-4);
}

.page-header {
    background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.85) 100%);
    backdrop-filter: blur(20px) saturate(180%);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: var(--radius-2xl);
    padding: var(--space-8);
    margin-bottom: var(--space-8);
    text-align: center;
    box-shadow: var(--shadow-2xl);
    position: relative;
    overflow: hidden;
}

.page-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-primary);
}

.page-header h2 {
    font-size: var(--font-size-4xl);
    color: var(--neutral-800);
    margin-bottom: var(--space-2);
    font-weight: 900;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.page-header p {
    color: var(--neutral-600);
    font-size: var(--font-size-lg);
    font-weight: 500;
}

.movies-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: var(--space-6);
    margin-bottom: var(--space-8);
}

.watchlist-card {
    background: white;
    border-radius: var(--radius-xl);
    overflow: hidden;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: var(--shadow-md);
    border: 1px solid rgba(255, 255, 255, 0.2);
    position: relative;
    animation: fadeInUp 0.6s ease-out;
}

.watchlist-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: var(--shadow-2xl);
}

.movie-poster {
    position: relative;
    height: 280px;
    overflow: hidden;
}

.movie-poster img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.watchlist-card:hover .movie-poster img {
    transform: scale(1.1);
}

.movie-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.8);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: var(--space-3);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.watchlist-card:hover .movie-overlay {
    opacity: 1;
}

.overlay-actions {
    display: flex;
    flex-direction: column;
    gap: var(--space-2);
}

.overlay-btn {
    background: rgba(255,255,255,0.95);
    color: var(--neutral-800);
    border: none;
    padding: var(--space-2) var(--space-4);
    border-radius: var(--radius-lg);
    font-weight: 600;
    font-size: var(--font-size-sm);
    cursor: pointer;
    transition: all 0.2s ease;
    white-space: nowrap;
    backdrop-filter: blur(10px);
    min-width: 120px;
}

.overlay-btn.btn-success {
    background: var(--success-500);
    color: white;
}

.overlay-btn.btn-danger {
    background: var(--error-500);
    color: white;
}

.overlay-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.overlay-btn.btn-success:hover {
    background: var(--success-600);
}

.overlay-btn.btn-danger:hover {
    background: var(--error-600);
}

.movie-badge {
    position: absolute;
    top: var(--space-3);
    right: var(--space-3);
    z-index: 10;
}

.imdb-badge {
    background: #f59e0b;
    color: black;
    padding: var(--space-1) var(--space-2);
    border-radius: var(--radius-md);
    font-size: var(--font-size-xs);
    font-weight: 700;
    box-shadow: var(--shadow-sm);
}

.movie-card-info {
    padding: var(--space-4);
    background: white;
}

.movie-card-info h4 {
    font-size: var(--font-size-base);
    font-weight: 700;
    color: var(--neutral-800);
    margin-bottom: var(--space-2);
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.movie-card-info p {
    color: var(--neutral-600);
    font-size: var(--font-size-sm);
    margin-bottom: var(--space-2);
    font-weight: 500;
}

.added-date {
    color: var(--neutral-400);
    font-size: var(--font-size-xs);
    font-weight: 500;
    display: block;
}

.empty-state {
    text-align: center;
    padding: var(--space-16) var(--space-8);
    background: white;
    border-radius: var(--radius-2xl);
    box-shadow: var(--shadow-lg);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.empty-state-icon {
    font-size: 4rem;
    margin-bottom: var(--space-4);
    opacity: 0.5;
}

.empty-state h3 {
    font-size: var(--font-size-2xl);
    color: var(--neutral-700);
    margin-bottom: var(--space-3);
    font-weight: 700;
}

.empty-state p {
    color: var(--neutral-500);
    font-size: var(--font-size-lg);
    margin-bottom: var(--space-6);
    max-width: 400px;
    margin-left: auto;
    margin-right: auto;
}

.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: var(--space-6);
    margin-top: var(--space-8);
    padding: var(--space-6);
    background: rgba(255,255,255,0.1);
    border-radius: var(--radius-xl);
    backdrop-filter: blur(10px);
}

.page-info {
    color: white;
    font-weight: 600;
    font-size: var(--font-size-base);
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Stagger animation for cards */
.watchlist-card:nth-child(1) { animation-delay: 0.1s; }
.watchlist-card:nth-child(2) { animation-delay: 0.2s; }
.watchlist-card:nth-child(3) { animation-delay: 0.3s; }
.watchlist-card:nth-child(4) { animation-delay: 0.4s; }
.watchlist-card:nth-child(5) { animation-delay: 0.5s; }
.watchlist-card:nth-child(6) { animation-delay: 0.6s; }

@media (max-width: 768px) {
    .movies-grid {
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: var(--space-4);
    }
    
    .movie-poster {
        height: 240px;
    }
    
    .overlay-btn {
        font-size: var(--font-size-xs);
        padding: var(--space-1) var(--space-3);
        min-width: 100px;
    }
    
    .page-header {
        padding: var(--space-6);
    }
    
    .page-header h2 {
        font-size: var(--font-size-3xl);
    }
}

@media (max-width: 480px) {
    .movies-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .overlay-actions {
        flex-direction: row;
        gap: var(--space-1);
    }
    
    .overlay-btn {
        font-size: var(--font-size-xs);
        padding: var(--space-1) var(--space-2);
        min-width: 80px;
    }
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