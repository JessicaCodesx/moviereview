<?php
$isLoggedIn = isset($_SESSION['user']) && !empty($_SESSION['user']['id']);
?>

<div class="search-section">
    <div class="search-box">
        <input type="text" 
               id="searchInput" 
               class="search-input" 
               placeholder="Search for movies..." 
               autocomplete="off" />
        <button class="search-btn" aria-label="Search movies">
            🔍
        </button>
    </div>
    
    <!-- Search Results Container -->
    <div id="searchResults" class="search-results"></div>
</div>

<!-- Movie Details Container -->
<div id="movieDetails" class="movie-details"></div>

<?php if ($isLoggedIn && !empty($data['recent_ratings'])): ?>
<div class="personalized-section">
    <div class="section-header">
        <h3>🎬 Your Recent Ratings</h3>
        <a href="/profile" class="view-all-link">View All</a>
    </div>
    <div class="recent-ratings">
        <?php foreach (array_slice($data['recent_ratings'], 0, 5) as $rating): ?>
            <div class="rating-card" onclick="movieAppInstance.loadMovieDetails('<?php echo htmlspecialchars($rating['imdb_id']); ?>')">
                <div class="rating-poster">
                    <img src="<?php echo $rating['poster'] !== 'N/A' ? htmlspecialchars($rating['poster']) : '/public/assets/images/no-image.png'; ?>" 
                         alt="<?php echo htmlspecialchars($rating['title']); ?>"
                         onerror="this.src='/public/assets/images/no-image.png'"
                         loading="lazy">
                    <div class="rating-overlay">
                        <span class="rating-badge">⭐ <?php echo (int)$rating['rating']; ?></span>
                    </div>
                </div>
                <div class="rating-info">
                    <h4><?php echo htmlspecialchars($rating['title']); ?></h4>
                    <p><?php echo htmlspecialchars($rating['year']); ?></p>
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
                <div class="movie-card popular-card" onclick="movieAppInstance.loadMovieDetails('<?php echo htmlspecialchars($movie['imdb_id']); ?>')">
                    <div class="movie-poster">
                        <img src="<?php echo $movie['poster'] !== 'N/A' ? htmlspecialchars($movie['poster']) : '/public/assets/images/no-image.png'; ?>" 
                             alt="<?php echo htmlspecialchars($movie['title']); ?>"
                             onerror="this.src='/public/assets/images/no-image.png'"
                             loading="lazy">
                        <div class="movie-badge">
                            <span class="avg-badge">⭐ <?php echo number_format((float)$movie['avg_rating'], 1); ?></span>
                        </div>
                    </div>
                    <div class="movie-card-info">
                        <h4><?php echo htmlspecialchars($movie['title']); ?></h4>
                        <p><?php echo htmlspecialchars($movie['year']); ?> • <?php echo htmlspecialchars($movie['genre']); ?></p>
                        <small><?php echo (int)$movie['rating_count']; ?> rating<?php echo $movie['rating_count'] !== '1' ? 's' : ''; ?></small>
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