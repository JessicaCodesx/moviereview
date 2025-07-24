<?php
?>
<div class="regal-watchlist-container">
    <!-- Regal Background Animation -->
    <div class="watchlist-background">
        <div class="regal-gradient"></div>
        <div class="floating-elements">
            <div class="floating-shape shape-1"></div>
            <div class="floating-shape shape-2"></div>
            <div class="floating-shape shape-3"></div>
            <div class="floating-shape shape-4"></div>
            <div class="floating-shape shape-5"></div>
            <div class="floating-shape shape-6"></div>
        </div>
        <div class="regal-particles">
            <span class="particle particle-1">📝</span>
            <span class="particle particle-2">⭐</span>
            <span class="particle particle-3">🎬</span>
            <span class="particle particle-4">✨</span>
            <span class="particle particle-5">👑</span>
            <span class="particle particle-6">🎭</span>
        </div>
    </div>

    <!-- Elite Page Header -->
    <div class="elite-page-header">
        <div class="header-crown-animation">
            <div class="header-crown">📝</div>
            <div class="crown-sparkles">
                <span class="sparkle">⭐</span>
                <span class="sparkle">🎬</span>
                <span class="sparkle">⭐</span>
            </div>
        </div>
        <div class="header-content-royal">
            <h1>Your Royal Watchlist</h1>
            <p class="header-subtitle">Curated cinematic experiences awaiting your distinguished attention</p>
            <div class="wishlist-badge">
                <span class="badge-icon">📋</span>
                <span class="badge-text">Elite Queue</span>
            </div>
        </div>
    </div>

    <?php if (!empty($data['watchlist'])): ?>
        <!-- Royal Statistics Section -->
        <div class="royal-stats-section">
            <div class="stats-crown-header">
                <div class="stats-crown">📊</div>
                <h2>Watchlist Statistics</h2>
            </div>
            <div class="royal-stats-grid">
                <div class="royal-stat-item">
                    <div class="stat-crown">📝</div>
                    <div class="stat-number"><?php echo count($data['watchlist']); ?></div>
                    <div class="stat-label">Queued Films</div>
                </div>
                <div class="royal-stat-item">
                    <div class="stat-crown">🎭</div>
                    <div class="stat-number">
                        <?php 
                        $genres = [];
                        foreach($data['watchlist'] as $movie) {
                            $movieGenres = explode(',', $movie['genre']);
                            foreach($movieGenres as $genre) {
                                $genre = trim($genre);
                                if($genre && !in_array($genre, $genres)) {
                                    $genres[] = $genre;
                                }
                            }
                        }
                        echo count($genres);
                        ?>
                    </div>
                    <div class="stat-label">Genres</div>
                </div>
                <div class="royal-stat-item">
                    <div class="stat-crown">⭐</div>
                    <div class="stat-number">
                        <?php 
                        $totalRating = 0;
                        $ratedCount = 0;
                        foreach($data['watchlist'] as $movie) {
                            if($movie['imdb_rating'] && $movie['imdb_rating'] !== 'N/A') {
                                $totalRating += floatval($movie['imdb_rating']);
                                $ratedCount++;
                            }
                        }
                        echo $ratedCount > 0 ? number_format($totalRating / $ratedCount, 1) : '0';
                        ?>
                    </div>
                    <div class="stat-label">Avg IMDb</div>
                </div>
                <div class="royal-stat-item">
                    <div class="stat-crown">👑</div>
                    <div class="stat-number">Elite</div>
                    <div class="stat-label">Curation</div>
                </div>
            </div>
        </div>

        <div class="elite-movies-grid">
            <?php foreach ($data['watchlist'] as $index => $movie): ?>
                <div class="elite-movie-card watchlist-card animate-card" 
                     data-animation-delay="<?php echo $index * 0.1; ?>"
                     onclick="movieAppInstance.loadMovieDetails('<?php echo $movie['imdb_id']; ?>')">

                    <div class="card-crown-indicator">📝</div>

                    <div class="elite-movie-poster">
                        <img src="<?php echo $movie['poster'] !== 'N/A' ? $movie['poster'] : '/public/assets/images/no-image.png'; ?>" 
                             alt="<?php echo htmlspecialchars($movie['title']); ?>"
                             onerror="this.src='/public/assets/images/no-image.png'">

                        <div class="elite-movie-overlay">
                            <div class="overlay-crown">👑</div>
                            <div class="elite-overlay-actions">
                                <button class="elite-action-btn btn-watch" onclick="event.stopPropagation(); markWatched(<?php echo $movie['movie_id']; ?>)">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="9,11 12,14 22,4"></polyline>
                                        <path d="M21,12v7a2,2 0 0,1 -2,2H5a2,2 0 0,1 -2,-2V5a2,2 0 0,1 2,-2h11"></path>
                                    </svg>
                                    <span>Mark Watched</span>
                                </button>
                                <button class="elite-action-btn btn-remove" onclick="event.stopPropagation(); removeFromWatchlist(<?php echo $movie['movie_id']; ?>)">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3,6 5,6 21,6"></polyline>
                                        <path d="M8,6V4a2,2 0 0,1 2,-2h4a2,2 0 0,1 2,2v2"></path>
                                    </svg>
                                    <span>Remove</span>
                                </button>
                            </div>
                        </div>

                        <div class="elite-movie-status">
                            <?php if ($movie['imdb_rating'] && $movie['imdb_rating'] !== 'N/A'): ?>
                                <span class="elite-imdb-badge">
                                    <span class="imdb-crown">⭐</span>
                                    IMDb <?php echo $movie['imdb_rating']; ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="movie-quality-badge">
                            <span class="badge-crown">📋</span>
                            Queued
                        </div>
                    </div>

                    <div class="elite-movie-info">
                        <div class="movie-title-crown">
                            <h4><?php echo htmlspecialchars($movie['title']); ?></h4>
                            <span class="title-crown">✨</span>
                        </div>
                        <p class="movie-details"><?php echo $movie['year']; ?> • <?php echo htmlspecialchars($movie['genre']); ?></p>

                        <div class="watchlist-priority">
                            <span class="priority-crown">👑</span>
                            <span class="priority-text">Priority Viewing</span>
                        </div>

                        <small class="added-date-royal">
                            <span class="date-crown">📅</span>
                            Added <?php echo date('M j, Y', strtotime($movie['created_at'])); ?>
                        </small>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Royal Pagination -->
        <?php if (count($data['watchlist']) >= 20): ?>
        <div class="royal-pagination">
            <a href="/watchlist?page=<?php echo max(1, $data['current_page'] - 1); ?>" class="btn-royal btn-secondary-royal">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="15,18 9,12 15,6"></polyline>
                </svg>
                <span>Previous</span>
            </a>
            <div class="page-info-royal">
                <span class="page-crown">👑</span>
                <span>Page <?php echo $data['current_page']; ?></span>
            </div>
            <a href="/watchlist?page=<?php echo $data['current_page'] + 1; ?>" class="btn-royal btn-secondary-royal">
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
                <div class="empty-crown">📝</div>
                <div class="empty-particles">
                    <span class="particle">⭐</span>
                    <span class="particle">✨</span>
                    <span class="particle">🏆</span>
                    <span class="particle">👑</span>
                    <span class="particle">🎬</span>
                </div>
            </div>
            <div class="empty-content-elite">
                <h3>Your Royal Watchlist Awaits</h3>
                <p>Begin curating your distinguished queue of cinematic experiences yet to be discovered</p>
                <a href="/" class="btn-royal btn-primary-royal btn-large-royal">
                    <span class="btn-icon">🔍</span>
                    <span class="btn-text">Discover Films</span>
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
/* Elite Cinema Watchlist - Royal Design System */
:root {
    --regal-primary: #1a1f3a;
    --regal-secondary: #0f1419;
    --regal-accent: #daa520;
    --regal-accent-light: #f4d03f;
    --regal-text: #ffffff;
    --regal-text-muted: rgba(255, 255, 255, 0.7);
    --regal-border: rgba(218, 165, 32, 0.3);
    --regal-backdrop: rgba(26, 31, 58, 0.8);
    --regal-glass: rgba(26, 31, 58, 0.9);
    --regal-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
    --regal-glow: 0 0 30px rgba(218, 165, 32, 0.3);
}

.regal-watchlist-container {
    min-height: 100vh;
    background: linear-gradient(135deg, var(--regal-secondary) 0%, var(--regal-primary) 50%, var(--regal-secondary) 100%);
    position: relative;
    overflow-x: hidden;
    width: 100%;
    margin: 0;
    padding: 0;
}

/* Background Animation */
.watchlist-background {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: -1;
    overflow: hidden;
}

.regal-gradient {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(circle at 20% 50%, rgba(218, 165, 32, 0.1), transparent),
        radial-gradient(circle at 80% 20%, rgba(218, 165, 32, 0.08), transparent),
        radial-gradient(circle at 40% 80%, rgba(218, 165, 32, 0.12), transparent);
}

.floating-elements {
    position: absolute;
    width: 100%;
    height: 100%;
    pointer-events: none;
}

.floating-shape {
    position: absolute;
    border-radius: 50%;
    opacity: 0.08;
    animation: regalFloat 30s ease-in-out infinite;
}

.shape-1 {
    width: 300px;
    height: 300px;
    background: linear-gradient(135deg, var(--regal-accent), var(--regal-accent-light));
    top: -10%;
    left: -10%;
    animation-delay: 0s;
}

.shape-2 {
    width: 200px;
    height: 200px;
    background: linear-gradient(135deg, var(--regal-primary), var(--regal-accent));
    top: 70%;
    right: -5%;
    animation-delay: 10s;
}

.shape-3 {
    width: 150px;
    height: 150px;
    background: linear-gradient(135deg, var(--regal-accent-light), var(--regal-accent));
    top: 30%;
    left: 10%;
    animation-delay: 20s;
}

.shape-4 {
    width: 250px;
    height: 250px;
    background: linear-gradient(135deg, var(--regal-accent), var(--regal-primary));
    top: 10%;
    right: 20%;
    animation-delay: 5s;
}

.shape-5 {
    width: 180px;
    height: 180px;
    background: linear-gradient(135deg, var(--regal-accent-light), var(--regal-primary));
    bottom: -10%;
    left: 40%;
    animation-delay: 15s;
}

.shape-6 {
    width: 120px;
    height: 120px;
    background: linear-gradient(135deg, var(--regal-accent), var(--regal-accent-light));
    top: 60%;
    right: 50%;
    animation-delay: 25s;
}

@keyframes regalFloat {
    0%, 100% { 
        transform: translateY(0px) translateX(0px) rotate(0deg) scale(1); 
    }
    25% { 
        transform: translateY(-30px) translateX(20px) rotate(90deg) scale(1.1); 
    }
    50% { 
        transform: translateY(-15px) translateX(-15px) rotate(180deg) scale(0.9); 
    }
    75% { 
        transform: translateY(20px) translateX(-30px) rotate(270deg) scale(1.05); 
    }
}

.regal-particles {
    position: absolute;
    width: 100%;
    height: 100%;
    pointer-events: none;
}

.particle {
    position: absolute;
    font-size: 1.5rem;
    opacity: 0.4;
    animation: particleFloat 20s linear infinite;
    filter: drop-shadow(0 2px 4px rgba(218, 165, 32, 0.3));
}

.particle-1 { animation-delay: 0s; left: 10%; }
.particle-2 { animation-delay: 4s; left: 30%; }
.particle-3 { animation-delay: 8s; left: 60%; }
.particle-4 { animation-delay: 12s; left: 80%; }
.particle-5 { animation-delay: 16s; left: 40%; }
.particle-6 { animation-delay: 20s; left: 70%; }

@keyframes particleFloat {
    0% { 
        transform: translateY(100vh) translateX(0px) rotate(0deg); 
        opacity: 0; 
    }
    10% { 
        opacity: 0.4; 
    }
    90% { 
        opacity: 0.4; 
    }
    100% { 
        transform: translateY(-100px) translateX(50px) rotate(360deg); 
        opacity: 0; 
    }
}

/* Elite Page Header */
.elite-page-header {
    text-align: center;
    padding: 80px 40px 60px;
    margin-bottom: 40px;
    position: relative;
}

.header-crown-animation {
    position: relative;
    margin-bottom: 40px;
}

.header-crown {
    font-size: 5rem;
    filter: drop-shadow(0 4px 12px rgba(218, 165, 32, 0.4));
    animation: crownFloat 6s ease-in-out infinite;
}

@keyframes crownFloat {
    0%, 100% { 
        transform: translateY(0px) rotate(0deg); 
    }
    50% { 
        transform: translateY(-10px) rotate(3deg); 
    }
}

.crown-sparkles {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 300px;
    height: 300px;
}

.sparkle {
    position: absolute;
    font-size: 1.5rem;
    animation: sparkleOrbit 8s linear infinite;
}

.sparkle:nth-child(1) { animation-delay: 0s; }
.sparkle:nth-child(2) { animation-delay: 2.5s; }
.sparkle:nth-child(3) { animation-delay: 5s; }

@keyframes sparkleOrbit {
    0% { transform: rotate(0deg) translateX(120px) rotate(0deg); }
    100% { transform: rotate(360deg) translateX(120px) rotate(-360deg); }
}

.header-content-royal h1 {
    font-size: clamp(3rem, 8vw, 5rem);
    font-weight: 900;
    background: linear-gradient(135deg, var(--regal-accent), var(--regal-accent-light));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 25px;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}

.header-subtitle {
    font-size: clamp(1.2rem, 3vw, 1.5rem);
    color: var(--regal-text-muted);
    margin-bottom: 30px;
    max-width: 800px;
    margin-left: auto;
    margin-right: auto;
    font-weight: 500;
    font-style: italic;
}

.wishlist-badge {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: var(--regal-glass);
    backdrop-filter: blur(20px);
    border: 2px solid var(--regal-border);
    border-radius: 20px;
    padding: 12px 20px;
    color: var(--regal-accent);
    font-weight: 700;
    font-size: 1rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    box-shadow: var(--regal-glow);
}

.badge-icon {
    font-size: 1.2rem;
}

/* Royal Statistics Section */
.royal-stats-section {
    background: var(--regal-glass);
    backdrop-filter: blur(25px);
    border: 2px solid var(--regal-border);
    border-radius: 25px;
    padding: 40px;
    margin: 0 40px 60px;
    box-shadow: var(--regal-shadow);
    position: relative;
    overflow: hidden;
}

.stats-crown-header {
    text-align: center;
    margin-bottom: 40px;
}

.stats-crown {
    font-size: 3rem;
    margin-bottom: 20px;
    filter: drop-shadow(0 4px 12px rgba(218, 165, 32, 0.4));
    animation: crownFloat 6s ease-in-out infinite;
}

.stats-crown-header h2 {
    font-size: 2.5rem;
    font-weight: 900;
    margin: 0;
    background: linear-gradient(135deg, var(--regal-accent), var(--regal-accent-light));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.royal-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 25px;
}

.royal-stat-item {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(15px);
    border: 2px solid var(--regal-border);
    border-radius: 18px;
    padding: 30px 25px;
    text-align: center;
    transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
    position: relative;
    overflow: hidden;
}

.royal-stat-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(218, 165, 32, 0.1), transparent);
    transition: left 0.8s ease;
}

.royal-stat-item:hover::before {
    left: 100%;
}

.royal-stat-item:hover {
    transform: translateY(-8px);
    border-color: var(--regal-accent);
    box-shadow: 0 12px 30px rgba(218, 165, 32, 0.3);
}

.stat-crown {
    font-size: 2rem;
    margin-bottom: 15px;
    filter: drop-shadow(0 2px 8px rgba(218, 165, 32, 0.4));
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 900;
    color: var(--regal-accent);
    margin-bottom: 8px;
    text-shadow: 0 2px 8px rgba(218, 165, 32, 0.3);
}

.stat-label {
    font-size: 1rem;
    color: var(--regal-text-muted);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

/* Elite Movies Grid */
.elite-movies-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 30px;
    padding: 0 40px;
    margin-bottom: 60px;
}

.elite-movie-card {
    background: var(--regal-glass);
    backdrop-filter: blur(25px);
    border: 2px solid var(--regal-border);
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
    cursor: pointer;
    position: relative;
    box-shadow: var(--regal-shadow);
}

.elite-movie-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(218, 165, 32, 0.1), transparent);
    transition: left 0.8s ease;
    z-index: 1;
}

.elite-movie-card:hover::before {
    left: 100%;
}

.elite-movie-card:hover {
    transform: translateY(-10px) scale(1.02);
    border-color: var(--regal-accent);
    box-shadow: 0 20px 40px rgba(218, 165, 32, 0.3);
}

.card-crown-indicator {
    position: absolute;
    top: 15px;
    right: 15px;
    font-size: 1.2rem;
    z-index: 2;
    opacity: 0.8;
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.5));
}

.elite-movie-poster {
    position: relative;
    aspect-ratio: 2/3;
    overflow: hidden;
}

.elite-movie-poster img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.elite-movie-card:hover .elite-movie-poster img {
    transform: scale(1.05);
}

.elite-movie-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(26, 31, 58, 0.9), rgba(15, 20, 25, 0.95));
    backdrop-filter: blur(10px);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 20px;
    opacity: 0;
    transition: all 0.4s ease;
}

.elite-movie-card:hover .elite-movie-overlay {
    opacity: 1;
}

.overlay-crown {
    font-size: 2.5rem;
    filter: drop-shadow(0 4px 12px rgba(218, 165, 32, 0.6));
    animation: crownFloat 6s ease-in-out infinite;
}

.elite-overlay-actions {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.elite-action-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    background: var(--regal-glass);
    backdrop-filter: blur(20px);
    border: 2px solid var(--regal-border);
    border-radius: 12px;
    padding: 12px 16px;
    color: var(--regal-text);
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    min-width: 140px;
    justify-content: center;
}

.elite-action-btn:hover {
    background: rgba(218, 165, 32, 0.2);
    border-color: var(--regal-accent);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(218, 165, 32, 0.3);
}

.btn-watch {
    border-color: rgba(34, 197, 94, 0.5);
}

.btn-watch:hover {
    background: rgba(34, 197, 94, 0.2);
    border-color: #22c55e;
    box-shadow: 0 8px 20px rgba(34, 197, 94, 0.3);
}

.btn-remove {
    border-color: rgba(239, 68, 68, 0.5);
}

.btn-remove:hover {
    background: rgba(239, 68, 68, 0.2);
    border-color: #ef4444;
    box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3);
}

.elite-movie-status {
    position: absolute;
    top: 15px;
    left: 15px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    z-index: 2;
}

.elite-imdb-badge {
    display: flex;
    align-items: center;
    gap: 6px;
    background: var(--regal-glass);
    backdrop-filter: blur(20px);
    border: 1px solid var(--regal-border);
    border-radius: 8px;
    padding: 6px 10px;
    font-size: 0.8rem;
    font-weight: 700;
    color: var(--regal-accent);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
}

.imdb-crown {
    font-size: 0.9rem;
}

.movie-quality-badge {
    position: absolute;
    bottom: 15px;
    right: 15px;
    display: flex;
    align-items: center;
    gap: 6px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: white;
    padding: 8px 12px;
    border-radius: 10px;
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4);
    z-index: 2;
}

.badge-crown {
    font-size: 0.9rem;
}

.elite-movie-info {
    padding: 25px 20px;
    color: var(--regal-text);
}

.movie-title-crown {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 12px;
}

.movie-title-crown h4 {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--regal-text);
    margin: 0;
    line-height: 1.3;
    flex: 1;
}

.title-crown {
    font-size: 1rem;
    margin-left: 8px;
    opacity: 0.8;
    flex-shrink: 0;
}

.movie-details {
    color: var(--regal-text-muted);
    font-size: 0.9rem;
    margin-bottom: 15px;
    font-weight: 500;
}

.watchlist-priority {
    display: flex;
    align-items: center;
    gap: 8px;
    background: rgba(218, 165, 32, 0.1);
    border: 1px solid var(--regal-border);
    border-radius: 8px;
    padding: 8px 12px;
    margin-bottom: 15px;
}

.priority-crown {
    font-size: 1rem;
}

.priority-text {
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--regal-accent);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.added-date-royal {
    display: flex;
    align-items: center;
    gap: 6px;
    color: var(--regal-text-muted);
    font-size: 0.85rem;
    font-weight: 500;
    font-style: italic;
}

.date-crown {
    font-size: 0.9rem;
}

/* Royal Pagination */
.royal-pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 25px;
    padding: 0 40px 60px;
}

.btn-royal {
    display: flex;
    align-items: center;
    gap: 10px;
    background: var(--regal-glass);
    backdrop-filter: blur(25px);
    border: 2px solid var(--regal-border);
    border-radius: 15px;
    padding: 15px 25px;
    color: var(--regal-text);
    text-decoration: none;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.4s ease;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.btn-royal:hover {
    background: rgba(218, 165, 32, 0.2);
    border-color: var(--regal-accent);
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(218, 165, 32, 0.3);
    color: var(--regal-accent);
}

.page-info-royal {
    display: flex;
    align-items: center;
    gap: 10px;
    background: var(--regal-glass);
    backdrop-filter: blur(25px);
    border: 2px solid var(--regal-border);
    border-radius: 15px;
    padding: 15px 25px;
    color: var(--regal-accent);
    font-weight: 700;
    font-size: 1rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.page-crown {
    font-size: 1.2rem;
}

/* Elite Empty State */
.elite-empty-state {
    text-align: center;
    padding: 80px 40px;
    color: var(--regal-text);
}

.empty-crown-animation {
    position: relative;
    margin-bottom: 50px;
}

.empty-crown {
    font-size: 6rem;
    filter: drop-shadow(0 4px 12px rgba(218, 165, 32, 0.4));
    animation: crownFloat 6s ease-in-out infinite;
}

.empty-particles {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 400px;
    height: 400px;
}

.empty-particles .particle {
    position: absolute;
    font-size: 2rem;
    animation: particleOrbit 10s linear infinite;
}

.empty-particles .particle:nth-child(1) { animation-delay: 0s; }
.empty-particles .particle:nth-child(2) { animation-delay: 2s; }
.empty-particles .particle:nth-child(3) { animation-delay: 4s; }
.empty-particles .particle:nth-child(4) { animation-delay: 6s; }
.empty-particles .particle:nth-child(5) { animation-delay: 8s; }

@keyframes particleOrbit {
    0% { transform: rotate(0deg) translateX(150px) rotate(0deg); }
    100% { transform: rotate(360deg) translateX(150px) rotate(-360deg); }
}

.empty-content-elite h3 {
    font-size: 2.5rem;
    font-weight: 900;
    margin-bottom: 20px;
    background: linear-gradient(135deg, var(--regal-accent), var(--regal-accent-light));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.empty-content-elite p {
    font-size: 1.2rem;
    color: var(--regal-text-muted);
    margin-bottom: 40px;
    font-style: italic;
    font-weight: 500;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.btn-primary-royal {
    background: linear-gradient(135deg, var(--regal-accent), var(--regal-accent-light));
    color: var(--regal-primary);
    border-color: var(--regal-accent);
    padding: 18px 30px;
    border-radius: 18px;
    font-size: 1.1rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    box-shadow: 0 8px 25px rgba(218, 165, 32, 0.4);
    text-decoration: none;
}

.btn-primary-royal:hover {
    background: linear-gradient(135deg, var(--regal-accent-light), var(--regal-accent));
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(218, 165, 32, 0.5);
}

.btn-icon {
    font-size: 1.3rem;
}

.btn-text {
    font-weight: 700;
}

/* Responsive Design */
@media (max-width: 768px) {
    .elite-page-header {
        padding: 60px 20px 40px;
    }

    .royal-stats-section {
        margin: 0 20px 40px;
        padding: 30px 20px;
    }

    .royal-stats-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    .elite-movies-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
        padding: 0 20px;
        margin-bottom: 40px;
    }

    .royal-pagination {
        padding: 0 20px 40px;
        gap: 15px;
    }

    .btn-royal {
        padding: 12px 20px;
        font-size: 0.9rem;
    }

    .page-info-royal {
        padding: 12px 20px;
        font-size: 0.9rem;
    }

    .elite-empty-state {
        padding: 60px 20px;
    }
}

@media (max-width: 480px) {
    .elite-page-header {
        padding: 40px 20px;
    }

    .header-content-royal h1 {
        font-size: 2.5rem;
    }

    .header-subtitle {
        font-size: 1.1rem;
    }

    .royal-stats-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }

    .elite-movies-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .royal-pagination {
        flex-direction: column;
        gap: 15px;
    }

    .btn-royal {
        width: 100%;
        justify-content: center;
    }

    .empty-particles {
        width: 250px;
        height: 250px;
    }

    .empty-content-elite h3 {
        font-size: 2rem;
    }

    .elite-overlay-actions {
        gap: 10px;
    }

    .elite-action-btn {
        padding: 10px 14px;
        font-size: 0.8rem;
        min-width: 120px;
    }
}

/* Animation for card entrance */
.animate-card {
    opacity: 0;
    transform: translateY(30px);
    animation: cardEntrance 0.6s ease forwards;
}

@keyframes cardEntrance {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-card:nth-child(1) { animation-delay: 0.1s; }
.animate-card:nth-child(2) { animation-delay: 0.2s; }
.animate-card:nth-child(3) { animation-delay: 0.3s; }
.animate-card:nth-child(4) { animation-delay: 0.4s; }
.animate-card:nth-child(5) { animation-delay: 0.5s; }
.animate-card:nth-child(6) { animation-delay: 0.6s; }
</style>

<script>
// Enhanced Watchlist Manager with Royal Animations
class RoyalWatchlistManager {
    constructor() {
        this.isProcessing = false;
        this.initializeRoyalAnimations();
    }

    initializeRoyalAnimations() {
        const particles = document.querySelectorAll('.particle');
        particles.forEach((particle, index) => {
            particle.style.left = `${Math.random() * 100}%`;
            particle.style.top = `${Math.random() * 100}%`;
        });

        // Initialize card animations
        const cards = document.querySelectorAll('.animate-card');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
        });
    }

    // Enhanced card removal with royal animation
    animateRoyalCardRemoval(cardElement, callback) {
        if (!cardElement) {
            callback?.();
            return;
        }

        // Add royal removal animation
        cardElement.style.transition = 'all 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55)';
        cardElement.style.transform = 'scale(0.8) rotateY(180deg) translateY(-30px)';
        cardElement.style.opacity = '0';
        cardElement.style.filter = 'blur(8px)';
        cardElement.style.borderColor = 'rgba(218, 165, 32, 0.6)';

        // Add sparkle effect
        this.createSparkleEffect(cardElement);

        // Remove card after animation
        setTimeout(() => {
            cardElement.style.height = cardElement.offsetHeight + 'px';
            cardElement.style.overflow = 'hidden';

            setTimeout(() => {
                cardElement.style.height = '0';
                cardElement.style.margin = '0';
                cardElement.style.padding = '0';

                setTimeout(() => {
                    cardElement.remove();
                    this.checkRoyalEmptyState();
                    callback?.();
                }, 400);
            }, 200);
        }, 800);
    }

    createSparkleEffect(element) {
        const rect = element.getBoundingClientRect();
        const sparkles = ['✨', '⭐', '👑', '🎬'];

        for (let i = 0; i < 6; i++) {
            const sparkle = document.createElement('div');
            sparkle.textContent = sparkles[Math.floor(Math.random() * sparkles.length)];
            sparkle.style.position = 'fixed';
            sparkle.style.left = `${rect.left + Math.random() * rect.width}px`;
            sparkle.style.top = `${rect.top + Math.random() * rect.height}px`;
            sparkle.style.fontSize = '1.5rem';
            sparkle.style.pointerEvents = 'none';
            sparkle.style.zIndex = '10000';
            sparkle.style.animation = 'sparkleDisappear 1s ease-out forwards';

            document.body.appendChild(sparkle);

            setTimeout(() => sparkle.remove(), 1000);
        }

        // Add sparkle animation CSS
        if (!document.querySelector('style[data-sparkle-animation]')) {
            const style = document.createElement('style');
            style.setAttribute('data-sparkle-animation', 'true');
            style.textContent = `
                @keyframes sparkleDisappear {
                    0% { 
                        opacity: 1; 
                        transform: translateY(0) scale(1) rotate(0deg); 
                    }
                    100% { 
                        opacity: 0; 
                        transform: translateY(-100px) scale(0.3) rotate(360deg); 
                    }
                }
            `;
            document.head.appendChild(style);
        }
    }

    checkRoyalEmptyState() {
        const moviesGrid = document.querySelector('.elite-movies-grid');
        const remainingCards = moviesGrid?.querySelectorAll('.elite-movie-card').length || 0;

        if (remainingCards === 0) {
            setTimeout(() => {
                const container = document.querySelector('.regal-watchlist-container');
                const statsSection = document.querySelector('.royal-stats-section');
                if (container && statsSection) {
                    // Hide stats section with animation
                    statsSection.style.transition = 'all 0.6s ease';
                    statsSection.style.transform = 'translateY(-50px)';
                    statsSection.style.opacity = '0';

                    setTimeout(() => {
                        statsSection.remove();
                        const emptyState = this.createRoyalEmptyState();
                        moviesGrid.replaceWith(emptyState);
                    }, 600);
                }
            }, 800);
        }
    }

    createRoyalEmptyState() {
        const emptyStateDiv = document.createElement('div');
        emptyStateDiv.className = 'elite-empty-state';
        emptyStateDiv.style.opacity = '0';
        emptyStateDiv.style.transform = 'translateY(50px)';

        emptyStateDiv.innerHTML = `
            <div class="empty-crown-animation">
                <div class="empty-crown">📝</div>
                <div class="empty-particles">
                    <span class="particle">⭐</span>
                    <span class="particle">✨</span>
                    <span class="particle">🏆</span>
                    <span class="particle">👑</span>
                    <span class="particle">🎬</span>
                </div>
            </div>
            <div class="empty-content-elite">
                <h3>Your Royal Watchlist Awaits</h3>
                <p>All queued films have been processed! Your cinematic journey continues with new discoveries.</p>
                <a href="/" class="btn-royal btn-primary-royal btn-large-royal">
                    <span class="btn-icon">🔍</span>
                    <span class="btn-text">Discover Films</span>
                </a>
            </div>
        `;

        // Animate in with royal flourish
        setTimeout(() => {
            emptyStateDiv.style.transition = 'all 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55)';
            emptyStateDiv.style.opacity = '1';
            emptyStateDiv.style.transform = 'translateY(0)';
        }, 200);

        return emptyStateDiv;
    }

    setRoyalButtonLoading(button, loading = true) {
        if (!button) return;

        if (loading) {
            button.disabled = true;
            button.style.opacity = '0.7';
            button.style.transform = 'scale(0.95)';
            const originalHTML = button.innerHTML;
            button.setAttribute('data-original-html', originalHTML);

            if (button.textContent.includes('Mark Watched')) {
                button.innerHTML = `
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                    </svg>
                    <span>Processing...</span>
                `;
                // Add spinning animation to the circle
                const svg = button.querySelector('svg circle');
                if (svg) {
                    svg.style.animation = 'spin 1s linear infinite';
                }
            } else if (button.textContent.includes('Remove')) {
                button.innerHTML = `
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                    </svg>
                    <span>Removing...</span>
                `;
                const svg = button.querySelector('svg circle');
                if (svg) {
                    svg.style.animation = 'spin 1s linear infinite';
                }
            }
        } else {
            button.disabled = false;
            button.style.opacity = '1';
            button.style.transform = 'scale(1)';
            const originalHTML = button.getAttribute('data-original-html');
            if (originalHTML) {
                button.innerHTML = originalHTML;
            }
        }
    }
}

// Initialize royal watchlist manager
const royalWatchlistManager = new RoyalWatchlistManager();

// Enhanced mark watched function with royal treatment
async function markWatched(movieId) {
    if (royalWatchlistManager.isProcessing) return;

    const button = event?.target.closest('.elite-action-btn');
    const card = button?.closest('.elite-movie-card');
    const movieTitle = card?.querySelector('h4')?.textContent || 'Movie';

    try {
        royalWatchlistManager.isProcessing = true;
        royalWatchlistManager.setRoyalButtonLoading(button, true);

        movieAppInstance.showToast(`Adding "${movieTitle}" to your royal collection...`, 'info');

        const formData = new FormData();
        formData.append('movieId', movieId);

        const response = await fetch('/api/movie/watch', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();

        if (data.success) {
            movieAppInstance.showToast(`"${movieTitle}" added to your watched collection! 👑`, 'success');

            // Add royal success animation
            if (card) {
                card.style.backgroundColor = 'rgba(34, 197, 94, 0.1)';
                card.style.borderColor = 'rgba(34, 197, 94, 0.5)';
                card.style.boxShadow = '0 8px 25px rgba(34, 197, 94, 0.3)';

                setTimeout(() => {
                    royalWatchlistManager.animateRoyalCardRemoval(card, () => {
                        movieAppInstance.showToast('Movie transferred to your royal collection!', 'success');
                    });
                }, 1200);
            }
        } else {
            movieAppInstance.showToast('Error: ' + (data.error || 'Unknown error'), 'error');
            royalWatchlistManager.setRoyalButtonLoading(button, false);
        }
    } catch (error) {
        console.error('Mark watched error:', error);
        movieAppInstance.showToast('Error processing your request', 'error');
        royalWatchlistManager.setRoyalButtonLoading(button, false);
    } finally {
        setTimeout(() => {
            royalWatchlistManager.isProcessing = false;
        }, 1500);
    }
}

// Enhanced remove from watchlist with royal confirmation
async function removeFromWatchlist(movieId) {
    if (royalWatchlistManager.isProcessing) return;

    const button = event?.target.closest('.elite-action-btn');
    const card = button?.closest('.elite-movie-card');
    const movieTitle = card?.querySelector('h4')?.textContent || 'Movie';

    // Royal confirmation dialog
    const confirmed = await showRoyalConfirm(
        'Remove from Royal Watchlist', 
        `Are you certain you wish to remove "${movieTitle}" from your distinguished queue?`,
        'Remove',
        'Keep'
    );

    if (!confirmed) return;

    try {
        royalWatchlistManager.isProcessing = true;
        royalWatchlistManager.setRoyalButtonLoading(button, true);

        movieAppInstance.showToast(`Removing "${movieTitle}" from your royal watchlist...`, 'info');

        const formData = new FormData();
        formData.append('movieId', movieId);

        const response = await fetch('/api/watchlist/remove', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();

        if (data.success) {
            movieAppInstance.showToast(`"${movieTitle}" removed from your royal watchlist`, 'success');

            // Animate royal removal
            royalWatchlistManager.animateRoyalCardRemoval(card);
        } else {
            movieAppInstance.showToast('Error: ' + (data.error || 'Unknown error'), 'error');
            royalWatchlistManager.setRoyalButtonLoading(button, false);
        }
    } catch (error) {
        console.error('Remove from watchlist error:', error);
        movieAppInstance.showToast('Error removing movie from watchlist', 'error');
        royalWatchlistManager.setRoyalButtonLoading(button, false);
    } finally {
        setTimeout(() => {
            royalWatchlistManager.isProcessing = false;
        }, 1500);
    }
}

// Royal confirmation dialog with enhanced styling
function showRoyalConfirm(title, message, confirmText = 'Confirm', cancelText = 'Cancel') {
    return new Promise((resolve) => {
        const modal = document.createElement('div');
        modal.className = 'royal-confirm-modal';
        modal.innerHTML = `
            <div class="royal-modal-content">
                <div class="royal-modal-crown">👑</div>
                <h3>${title}</h3>
                <p>${message}</p>
                <div class="royal-modal-actions">
                    <button class="btn-royal btn-secondary-royal" data-action="cancel">${cancelText}</button>
                    <button class="btn-royal btn-danger-royal" data-action="confirm">${confirmText}</button>
                </div>
            </div>
        `;

        // Add royal modal styles
        if (!document.querySelector('style[data-royal-modal]')) {
            const style = document.createElement('style');
            style.setAttribute('data-royal-modal', 'true');
            style.textContent = `
                .royal-confirm-modal {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(26, 31, 58, 0.9);
                    backdrop-filter: blur(10px);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    z-index: 10000;
                    animation: royalModalFadeIn 0.4s ease;
                }
                .royal-modal-content {
                    background: var(--regal-glass);
                    backdrop-filter: blur(25px);
                    border: 2px solid var(--regal-border);
                    border-radius: 25px;
                    padding: 3rem 2.5rem;
                    max-width: 500px;
                    width: 90%;
                    text-align: center;
                    box-shadow: var(--regal-shadow);
                    animation: royalModalSlideIn 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
                    position: relative;
                    overflow: hidden;
                }
                .royal-modal-content::before {
                    content: '';
                    position: absolute;
                    top: 0;
                    left: -100%;
                    width: 100%;
                    height: 100%;
                    background: linear-gradient(90deg, transparent, rgba(218, 165, 32, 0.1), transparent);
                    animation: royalShimmer 2s ease-in-out infinite;
                }
                .royal-modal-crown {
                    font-size: 3rem;
                    margin-bottom: 1.5rem;
                    filter: drop-shadow(0 4px 12px rgba(218, 165, 32, 0.4));
                    animation: crownFloat 6s ease-in-out infinite;
                }
                .royal-modal-content h3 {
                    margin: 0 0 1.5rem 0;
                    color: var(--regal-text);
                    font-size: 1.5rem;
                    font-weight: 900;
                    background: linear-gradient(135deg, var(--regal-accent), var(--regal-accent-light));
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    background-clip: text;
                }
                .royal-modal-content p {
                    margin: 0 0 2.5rem 0;
                    color: var(--regal-text-muted);
                    line-height: 1.6;
                    font-size: 1.1rem;
                    font-weight: 500;
                }
                .royal-modal-actions {
                    display: flex;
                    gap: 1.5rem;
                    justify-content: center;
                }
                .royal-modal-actions .btn-royal {
                    padding: 1rem 2rem;
                    border-radius: 12px;
                    border: 2px solid var(--regal-border);
                    cursor: pointer;
                    font-weight: 700;
                    font-size: 1rem;
                    transition: all 0.3s ease;
                    text-transform: uppercase;
                    letter-spacing: 0.05em;
                    min-width: 120px;
                }
                .btn-secondary-royal {
                    background: rgba(255, 255, 255, 0.1);
                    color: var(--regal-text-muted);
                }
                .btn-secondary-royal:hover {
                    background: rgba(255, 255, 255, 0.2);
                    border-color: var(--regal-accent);
                    transform: translateY(-2px);
                }
                .btn-danger-royal {
                    background: linear-gradient(135deg, #ef4444, #dc2626);
                    color: white;
                    border-color: #ef4444;
                }
                .btn-danger-royal:hover {
                    background: linear-gradient(135deg, #dc2626, #b91c1c);
                    transform: translateY(-2px);
                    box-shadow: 0 8px 20px rgba(239, 68, 68, 0.4);
                }
                @keyframes royalModalFadeIn {
                    from { opacity: 0; }
                    to { opacity: 1; }
                }
                @keyframes royalModalSlideIn {
                    from { 
                        transform: translateY(-100px) scale(0.8); 
                        opacity: 0; 
                    }
                    to { 
                        transform: translateY(0) scale(1); 
                        opacity: 1; 
                    }
                }
                @keyframes royalShimmer {
                    0% { left: -100%; }
                    50% { left: 100%; }
                    100% { left: 100%; }
                }
            `;
            document.head.appendChild(style);
        }

        document.body.appendChild(modal);

        // Handle button clicks
        modal.addEventListener('click', (e) => {
            const action = e.target.getAttribute('data-action');
            if (action === 'confirm') {
                resolve(true);
            } else if (action === 'cancel' || e.target === modal) {
                resolve(false);
            }

            // Add exit animation
            modal.style.animation = 'royalModalFadeIn 0.3s ease reverse';
            setTimeout(() => modal.remove(), 300);
        });

        // Focus the confirm button
        setTimeout(() => {
            modal.querySelector('[data-action="confirm"]')?.focus();
        }, 200);
    });
}

// Add spinning animation for loading states
if (!document.querySelector('style[data-spin-animation]')) {
    const style = document.createElement('style');
    style.setAttribute('data-spin-animation', 'true');
    style.textContent = `
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    `;
    document.head.appendChild(style);
}

// Initialize page with royal enhancements
document.addEventListener('DOMContentLoaded', () => {
    // Add scroll-triggered animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '50px'
    });

    // Observe elements for scroll animations
    document.querySelectorAll('.royal-stats-section, .elite-movies-grid, .royal-pagination').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'all 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55)';
        observer.observe(el);
    });

    // Enhanced hover effects for cards
    document.querySelectorAll('.elite-movie-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.zIndex = '10';
        });

        card.addEventListener('mouseleave', function() {
            this.style.zIndex = '1';
        });
    });

    // Parallax effect for floating shapes
    let ticking = false;

    function updateRoyalParallax() {
        const scrolled = window.pageYOffset;
        const parallaxElements = document.querySelectorAll('.floating-shape');

        parallaxElements.forEach((el, index) => {
            const rate = scrolled * (-0.2 - (index * 0.05));
            el.style.transform = `translateY(${rate}px)`;
        });

        ticking = false;
    }

    function requestRoyalParallaxUpdate() {
        if (!ticking) {
            requestAnimationFrame(updateRoyalParallax);
            ticking = true;
        }
    }

    window.addEventListener('scroll', requestRoyalParallaxUpdate);
});

// Keyboard shortcuts for royal navigation
document.addEventListener('keydown', (e) => {
    // Escape key to close modals
    if (e.key === 'Escape') {
        const modal = document.querySelector('.royal-confirm-modal');
        if (modal) {
            modal.querySelector('[data-action="cancel"]')?.click();
        }
    }

    // Enter key to confirm in modals
    if (e.key === 'Enter') {
        const modal = document.querySelector('.royal-confirm-modal');
        if (modal) {
            modal.querySelector('[data-action="confirm"]')?.click();
        }
    }
});
</script>