<?php
?>
<div class="regal-watched-container">
    <!-- Regal Background Animation -->
    <div class="watched-background">
        <div class="regal-gradient"></div>
        <div class="floating-elements">
            <div class="floating-shape shape-1"></div>
            <div class="floating-shape shape-2"></div>
            <div class="floating-shape shape-3"></div>
            <div class="floating-shape shape-4"></div>
        </div>
        <div class="regal-particles">
            <span class="particle particle-1">🎬</span>
            <span class="particle particle-2">⭐</span>
            <span class="particle particle-3">🏆</span>
            <span class="particle particle-4">✨</span>
        </div>
    </div>

    <!-- Elite Page Header -->
    <div class="elite-page-header animate-on-scroll">
        <div class="header-crown-animation">
            <div class="header-crown">✨</div>
            <div class="crown-sparkles">
                <span class="sparkle">⭐</span>
                <span class="sparkle">🎬</span>
                <span class="sparkle">⭐</span>
            </div>
        </div>
        <div class="header-content-royal">
            <h1>Your Cinematic Legacy</h1>
            <p class="header-subtitle">A distinguished collection of viewed masterpieces</p>
        </div>
    </div>

    <?php if (!empty($data['watched_movies'])): ?>
        <div class="elite-movies-grid">
            <?php foreach ($data['watched_movies'] as $index => $movie): ?>
                <div class="elite-movie-card watched-card animate-card" 
                     data-animation-delay="<?php echo $index * 0.1; ?>"
                     onclick="movieAppInstance.loadMovieDetails('<?php echo $movie['imdb_id']; ?>')">
                    <div class="elite-movie-poster">
                        <img src="<?php echo $movie['poster'] !== 'N/A' ? $movie['poster'] : '/public/assets/images/no-image.png'; ?>" 
                             alt="<?php echo htmlspecialchars($movie['title']); ?>"
                             onerror="this.src='/public/assets/images/no-image.png'">

                        <div class="elite-movie-overlay">
                            <div class="elite-overlay-actions">
                                <?php if (!$movie['user_rating']): ?>
                                    <button class="elite-action-btn btn-rate" onclick="event.stopPropagation(); movieAppInstance.loadMovieDetails('<?php echo $movie['imdb_id']; ?>')">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                    </button>
                                <?php endif; ?>
                                <button class="elite-action-btn btn-unwatch" onclick="event.stopPropagation(); unmarkWatched(<?php echo $movie['movie_id']; ?>)">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3,6 5,6 21,6"></polyline>
                                        <path d="M8,6V4a2,2 0 0,1 2,-2h4a2,2 0 0,1 2,2v2"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="elite-movie-status">
                            <?php if ($movie['user_rating']): ?>
                                <span class="elite-rating-badge">
                                    <span class="rating-crown">⭐</span>
                                    <?php echo $movie['user_rating']; ?>
                                </span>
                            <?php endif; ?>
                            <?php if ($movie['imdb_rating'] && $movie['imdb_rating'] !== 'N/A'): ?>
                                <span class="elite-imdb-badge">IMDb <?php echo $movie['imdb_rating']; ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="movie-quality-badge">Viewed</div>
                    </div>

                    <div class="elite-movie-info">
                        <h4><?php echo htmlspecialchars($movie['title']); ?></h4>
                        <p><?php echo $movie['year']; ?> • <?php echo htmlspecialchars($movie['genre']); ?></p>

                        <?php if ($movie['user_rating']): ?>
                            <div class="user-rating-display">
                                <span class="rating-stars-royal">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <span class="star-royal <?php echo $i <= $movie['user_rating'] ? 'illuminated' : ''; ?>">⭐</span>
                                    <?php endfor; ?>
                                </span>
                            </div>
                        <?php endif; ?>

                        <small class="viewed-date-royal">
                            Appreciated <?php echo date('M j, Y', strtotime($movie['watched_at'])); ?>
                        </small>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Royal Pagination -->
        <?php if (count($data['watched_movies']) >= 20): ?>
        <div class="royal-pagination">
            <a href="/watched?page=<?php echo max(1, $data['current_page'] - 1); ?>" class="btn-royal btn-secondary-royal">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="15,18 9,12 15,6"></polyline>
                </svg>
                <span>Previous</span>
            </a>
            <span class="page-info-royal">Page <?php echo $data['current_page']; ?></span>
            <a href="/watched?page=<?php echo $data['current_page'] + 1; ?>" class="btn-royal btn-secondary-royal">
                <span>Next</span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="9,18 15,12 9,6"></polyline>
                </svg>
            </a>
        </div>
        <?php endif; ?>

    <?php else: ?>
        <div class="elite-empty-state">
            <div class="empty-crown-animation">
                <div class="empty-crown">🎬</div>
                <div class="empty-particles">
                    <span class="particle">⭐</span>
                    <span class="particle">✨</span>
                    <span class="particle">🏆</span>
                </div>
            </div>
            <div class="empty-content-elite">
                <h3>Your Cinematic Journey Awaits</h3>
                <p>Begin curating your distinguished collection of viewed masterpieces</p>
                <a href="/" class="btn-royal btn-primary-royal btn-large-royal">
                    <span class="btn-icon">🔍</span>
                    <span class="btn-text">Discover Masterpieces</span>
                </a>
            </div>
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