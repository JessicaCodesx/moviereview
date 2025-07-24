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
            <div class="floating-shape shape-5"></div>
            <div class="floating-shape shape-6"></div>
        </div>
        <div class="regal-particles">
            <span class="particle particle-1">🎬</span>
            <span class="particle particle-2">⭐</span>
            <span class="particle particle-3">🏆</span>
            <span class="particle particle-4">✨</span>
            <span class="particle particle-5">👑</span>
            <span class="particle particle-6">🎭</span>
        </div>
    </div>

    <!-- Elite Page Header -->
    <div class="elite-page-header">
        <div class="header-crown-animation">
            <div class="header-crown">👑</div>
            <div class="crown-sparkles">
                <span class="sparkle">⭐</span>
                <span class="sparkle">🎬</span>
                <span class="sparkle">⭐</span>
            </div>
        </div>
        <div class="header-content-royal">
            <h1>Your Cinematic Legacy</h1>
            <p class="header-subtitle">A distinguished collection of viewed masterpieces</p>
            <div class="legacy-badge">
                <span class="badge-icon">🏆</span>
                <span class="badge-text">Elite Collection</span>
            </div>
        </div>
    </div>

    <?php if (!empty($data['watched_movies'])): ?>
        <!-- Statistics Section -->
        <div class="royal-stats-section">
            <div class="stats-crown-header">
                <div class="stats-crown">📊</div>
                <h2>Collection Statistics</h2>
            </div>
            <div class="royal-stats-grid">
                <div class="royal-stat-item">
                    <div class="stat-crown">🎬</div>
                    <div class="stat-number"><?php echo count($data['watched_movies']); ?></div>
                    <div class="stat-label">Films Appreciated</div>
                </div>
                <div class="royal-stat-item">
                    <div class="stat-crown">⭐</div>
                    <div class="stat-number">
                        <?php 
                        $ratedCount = 0;
                        foreach($data['watched_movies'] as $movie) {
                            if($movie['user_rating']) $ratedCount++;
                        }
                        echo $ratedCount;
                        ?>
                    </div>
                    <div class="stat-label">Royal Ratings</div>
                </div>
                <div class="royal-stat-item">
                    <div class="stat-crown">🏆</div>
                    <div class="stat-number">
                        <?php 
                        $avgRating = 0;
                        $totalRated = 0;
                        foreach($data['watched_movies'] as $movie) {
                            if($movie['user_rating']) {
                                $avgRating += $movie['user_rating'];
                                $totalRated++;
                            }
                        }
                        echo $totalRated > 0 ? number_format($avgRating / $totalRated, 1) : '0';
                        ?>
                    </div>
                    <div class="stat-label">Average Score</div>
                </div>
                <div class="royal-stat-item">
                    <div class="stat-crown">👑</div>
                    <div class="stat-number">Elite</div>
                    <div class="stat-label">Status Level</div>
                </div>
            </div>
        </div>

        <div class="elite-movies-grid">
            <?php foreach ($data['watched_movies'] as $index => $movie): ?>
                <div class="elite-movie-card watched-card animate-card" 
                     data-animation-delay="<?php echo $index * 0.1; ?>"
                     onclick="movieAppInstance.loadMovieDetails('<?php echo $movie['imdb_id']; ?>')">

                    <div class="card-crown-indicator">✨</div>

                    <div class="elite-movie-poster">
                        <img src="<?php echo $movie['poster'] !== 'N/A' ? $movie['poster'] : '/public/assets/images/no-image.png'; ?>" 
                             alt="<?php echo htmlspecialchars($movie['title']); ?>"
                             onerror="this.src='/public/assets/images/no-image.png'">

                        <div class="elite-movie-overlay">
                            <div class="overlay-crown">👑</div>
                            <div class="elite-overlay-actions">
                                <?php if (!$movie['user_rating']): ?>
                                    <button class="elite-action-btn btn-rate" onclick="event.stopPropagation(); movieAppInstance.loadMovieDetails('<?php echo $movie['imdb_id']; ?>')">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <span>Rate</span>
                                    </button>
                                <?php endif; ?>
                                <button class="elite-action-btn btn-unwatch" onclick="event.stopPropagation(); unmarkWatched(<?php echo $movie['movie_id']; ?>)">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3,6 5,6 21,6"></polyline>
                                        <path d="M8,6V4a2,2 0 0,1 2,-2h4a2,2 0 0,1 2,2v2"></path>
                                    </svg>
                                    <span>Remove</span>
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
                        <div class="movie-quality-badge">
                            <span class="badge-crown">👑</span>
                            Viewed
                        </div>
                    </div>

                    <div class="elite-movie-info">
                        <div class="movie-title-crown">
                            <h4><?php echo htmlspecialchars($movie['title']); ?></h4>
                            <span class="title-crown">✨</span>
                        </div>
                        <p class="movie-details"><?php echo $movie['year']; ?> • <?php echo htmlspecialchars($movie['genre']); ?></p>

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
                            <span class="date-crown">🏆</span>
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
            <div class="page-info-royal">
                <span class="page-crown">👑</span>
                <span>Page <?php echo $data['current_page']; ?></span>
            </div>
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
                    <span class="particle">👑</span>
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
/* Elite Cinema Watched Movies - Royal Design System */
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

.regal-watched-container {
    min-height: 100vh;
    background: linear-gradient(135deg, var(--regal-secondary) 0%, var(--regal-primary) 50%, var(--regal-secondary) 100%);
    position: relative;
    overflow-x: hidden;
    width: 100%;
    margin: 0;
    padding: 0;
}

/* Background Animation */
.watched-background {
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

.legacy-badge {
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
}

.elite-action-btn:hover {
    background: rgba(218, 165, 32, 0.2);
    border-color: var(--regal-accent);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(218, 165, 32, 0.3);
}

.btn-rate {
    border-color: rgba(34, 197, 94, 0.5);
}

.btn-rate:hover {
    background: rgba(34, 197, 94, 0.2);
    border-color: #22c55e;
}

.btn-unwatch {
    border-color: rgba(239, 68, 68, 0.5);
}

.btn-unwatch:hover {
    background: rgba(239, 68, 68, 0.2);
    border-color: #ef4444;
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

.elite-rating-badge, .elite-imdb-badge {
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

.rating-crown {
    font-size: 0.9rem;
}

.movie-quality-badge {
    position: absolute;
    bottom: 15px;
    right: 15px;
    display: flex;
    align-items: center;
    gap: 6px;
    background: linear-gradient(135deg, var(--regal-accent), var(--regal-accent-light));
    color: var(--regal-primary);
    padding: 8px 12px;
    border-radius: 10px;
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    box-shadow: 0 4px 12px rgba(218, 165, 32, 0.4);
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

.user-rating-display {
    margin: 15px 0;
}

.rating-stars-royal {
    display: flex;
    gap: 3px;
}

.star-royal {
    font-size: 1rem;
    opacity: 0.3;
    transition: all 0.3s ease;
}

.star-royal.illuminated {
    opacity: 1;
    filter: drop-shadow(0 2px 4px rgba(218, 165, 32, 0.4));
}

.viewed-date-royal {
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
.empty-particles .particle:nth-child(2) { animation-delay: 2.5s; }
.empty-particles .particle:nth-child(3) { animation-delay: 5s; }
.empty-particles .particle:nth-child(4) { animation-delay: 7.5s; }

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
// Initialize floating particles and animations
function initializeRoyalAnimations() {
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

// Enhanced unmark watched function
async function unmarkWatched(movieId) {
    if (!confirm('Remove this cinematic masterpiece from your royal collection?')) {
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
            movieAppInstance.showToast('Movie removed from your royal collection', 'success');
            // Add exit animation before reload
            const card = event.target.closest('.elite-movie-card');
            if (card) {
                card.style.transform = 'scale(0.8) translateY(-20px)';
                card.style.opacity = '0';
                setTimeout(() => location.reload(), 500);
            } else {
                setTimeout(() => location.reload(), 1000);
            }
        } else {
            movieAppInstance.showToast('Error: ' + data.error, 'error');
        }
    } catch (error) {
        movieAppInstance.showToast('Error removing movie from collection', 'error');
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    initializeRoyalAnimations();

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
        el.style.transition = 'all 0.6s ease';
        observer.observe(el);
    });

    // Enhanced hover effects
    document.querySelectorAll('.elite-movie-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.zIndex = '10';
        });

        card.addEventListener('mouseleave', function() {
            this.style.zIndex = '1';
        });
    });

    // Parallax effect for floating shapes (optional enhancement)
    let ticking = false;

    function updateParallax() {
        const scrolled = window.pageYOffset;
        const parallaxElements = document.querySelectorAll('.floating-shape');

        parallaxElements.forEach((el, index) => {
            const rate = scrolled * (-0.3 - (index * 0.1));
            el.style.transform = `translateY(${rate}px)`;
        });

        ticking = false;
    }

    function requestParallaxUpdate() {
        if (!ticking) {
            requestAnimationFrame(updateParallax);
            ticking = true;
        }
    }

    window.addEventListener('scroll', requestParallaxUpdate);
});
</script>