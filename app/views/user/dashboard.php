<?php
?>
<div class="regal-dashboard-container">
    <!-- Background Animation -->
    <div class="dashboard-background">
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
            <span class="particle particle-1">👑</span>
            <span class="particle particle-2">⭐</span>
            <span class="particle particle-3">🎭</span>
            <span class="particle particle-4">🎬</span>
        </div>
    </div>

    <!-- Welcome Section -->
    <div class="elite-welcome animate-on-scroll">
        <div class="welcome-content-regal">
            <div class="welcome-crown">👑</div>
            <div class="welcome-text-regal">
                <h1>Welcome back, <span class="username-highlight"><?php echo htmlspecialchars($_SESSION['user']['username']); ?></span></h1>
                <p class="welcome-subtitle">Your distinguished cinema sanctuary awaits</p>
            </div>
            <div class="welcome-actions-regal">
                <a href="/" class="btn-regal btn-primary-regal">
                    <span class="btn-icon">🔍</span>
                    <span class="btn-text">Explore Masterpieces</span>
                </a>
            </div>
        </div>

        <div class="elite-stats-preview">
            <div class="stat-preview-regal">
                <span class="stat-number-regal"><?php echo count($data['watchlist'] ?? []); ?></span>
                <span class="stat-label-regal">Curated Collection</span>
            </div>
            <div class="stat-divider-regal"></div>
            <div class="stat-preview-regal">
                <span class="stat-number-regal"><?php echo count($data['recently_watched'] ?? []); ?></span>
                <span class="stat-label-regal">Viewed Classics</span>
            </div>
        </div>
    </div>

    <!-- Recently Watched Section -->
    <?php if (!empty($data['recently_watched'])): ?>
    <div class="elite-section animate-on-scroll">
        <div class="elite-section-header">
            <div class="section-title-regal">
                <div class="section-crown">🎬</div>
                <h3>Continue Your Cinematic Journey</h3>
                <p class="section-subtitle-regal">Recently appreciated masterpieces</p>
            </div>
            <a href="/watched" class="view-all-link-regal">
                <span>View Royal Collection</span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="9,18 15,12 9,6"></polyline>
                </svg>
            </a>
        </div>

        <div class="elite-scroll-container">
            <div class="elite-movies-grid">
                <?php foreach (array_slice($data['recently_watched'], 0, 8) as $index => $movie): ?>
                <div class="elite-movie-card animate-card" 
                     data-animation-delay="<?php echo $index * 0.1; ?>"
                     onclick="movieAppInstance.loadMovieDetails('<?php echo $movie['imdb_id']; ?>')">
                        <div class="elite-movie-poster">
                            <img src="<?php echo $movie['poster'] !== 'N/A' ? $movie['poster'] : '/public/assets/images/no-image.png'; ?>" 
                                 alt="<?php echo htmlspecialchars($movie['title']); ?>"
                                 onerror="this.src='/public/assets/images/no-image.png'"
                                 loading="lazy">
                            <div class="elite-movie-overlay">
                                <button class="elite-play-button">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                        <polygon points="5,3 19,12 5,21"></polygon>
                                    </svg>
                                </button>
                            </div>
                            <div class="elite-movie-status">
                                <?php if ($movie['user_rating']): ?>
                                    <span class="elite-rating-badge">⭐ <?php echo $movie['user_rating']; ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="movie-quality-badge">Elite</div>
                        </div>
                        <div class="elite-movie-info">
                            <h4><?php echo htmlspecialchars($movie['title']); ?></h4>
                            <p><?php echo $movie['year']; ?> • <?php echo htmlspecialchars(substr($movie['genre'], 0, 20)); ?></p>
                            <small class="viewed-date-regal">
                                Viewed <?php echo $this->timeAgo($movie['watched_at']); ?>
                            </small>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Watchlist Section -->
    <?php if (!empty($data['watchlist'])): ?>
    <div class="elite-section animate-on-scroll">
        <div class="elite-section-header">
            <div class="section-title-regal">
                <div class="section-crown">📜</div>
                <h3>Your Distinguished Collection</h3>
                <p class="section-subtitle-regal">Masterpieces awaiting your attention</p>
            </div>
            <a href="/watchlist" class="view-all-link-regal">
                <span>View Complete Collection</span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="9,18 15,12 9,6"></polyline>
                </svg>
            </a>
        </div>

        <div class="elite-scroll-container">
            <div class="elite-movies-grid">
                <?php foreach (array_slice($data['watchlist'], 0, 8) as $index => $movie): ?>
                <div class="elite-movie-card animate-card" 
                     data-animation-delay="<?php echo $index * 0.1; ?>"
                     onclick="movieAppInstance.loadMovieDetails('<?php echo $movie['imdb_id']; ?>')">
                        <div class="elite-movie-poster">
                            <img src="<?php echo $movie['poster'] !== 'N/A' ? $movie['poster'] : '/public/assets/images/no-image.png'; ?>" 
                                 alt="<?php echo htmlspecialchars($movie['title']); ?>"
                                 onerror="this.src='/public/assets/images/no-image.png'"
                                 loading="lazy">
                            <div class="elite-movie-overlay">
                                <div class="elite-overlay-actions">
                                    <button class="elite-action-btn btn-approve" onclick="event.stopPropagation(); markWatched(<?php echo $movie['movie_id']; ?>)">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="20,6 9,17 4,12"></polyline>
                                        </svg>
                                    </button>
                                    <button class="elite-action-btn btn-remove" onclick="event.stopPropagation(); removeFromWatchlist(<?php echo $movie['movie_id']; ?>)">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="3,6 5,6 21,6"></polyline>
                                            <path d="M19,6V20a2,2 0 0,1 -2,2H7a2,2 0 0,1 -2,-2V6M8,6V4a2,2 0 0,1 2,-2h4a2,2 0 0,1 2,2v2"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="elite-movie-status">
                                <?php if ($movie['rating'] && $movie['rating'] !== 'N/A'): ?>
                                    <span class="elite-imdb-badge">IMDb <?php echo $movie['rating']; ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="movie-quality-badge">Curated</div>
                        </div>
                        <div class="elite-movie-info">
                            <h4><?php echo htmlspecialchars($movie['title']); ?></h4>
                            <p><?php echo $movie['year']; ?> • <?php echo htmlspecialchars(substr($movie['genre'], 0, 20)); ?></p>
                            <small class="added-date-regal">
                                Curated <?php echo $this->timeAgo($movie['created_at']); ?>
                            </small>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
// Dashboard functionality
async function removeFromWatchlist(movieId) {
    if (!confirm('Remove this masterpiece from your distinguished collection?')) return;

    try {
        const formData = new FormData();
        formData.append('movieId', movieId);

        const response = await fetch('/api/watchlist/remove', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            movieAppInstance.showToast('Masterpiece removed from collection', 'success');
            const card = event.target.closest('.elite-movie-card');
            if (card) {
                card.style.transform = 'scale(0) rotate(5deg)';
                card.style.opacity = '0';
                setTimeout(() => card.remove(), 400);
            }
        } else {
            movieAppInstance.showToast('Error: ' + data.error, 'error');
        }
    } catch (error) {
        movieAppInstance.showToast('Error removing from collection', 'error');
    }
}

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
            movieAppInstance.showToast('Masterpiece added to viewed classics! 👑', 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            movieAppInstance.showToast('Error: ' + data.error, 'error');
        }
    } catch (error) {
        movieAppInstance.showToast('Error marking masterpiece as viewed', 'error');
    }
}

// Scroll animations
function animateOnScroll() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-visible');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.animate-on-scroll').forEach(el => {
        observer.observe(el);
    });
}

function initializeFloatingParticles() {
    const particles = document.querySelectorAll('.particle');
    particles.forEach((particle, index) => {
        particle.style.animationDelay = `${index * 2.5}s`;
        particle.style.left = `${Math.random() * 100}%`;
        particle.style.top = `${Math.random() * 100}%`;
    });
}

// Initialize dashboard
document.addEventListener('DOMContentLoaded', () => {
    animateOnScroll();
    initializeFloatingParticles();

    document.querySelectorAll('.animate-card').forEach((card, index) => {
        card.style.animationDelay = `${index * 0.15}s`;
    });
});
</script>

<style>
:root {
    --regal-primary: #1a1f3a;
    --regal-secondary: #0f1419;
    --regal-accent: #daa520;
    --regal-accent-light: #f4d03f;
    --regal-text: #ffffff;
    --regal-text-muted: rgba(255, 255, 255, 0.7);
    --regal-border: rgba(218, 165, 32, 0.3);
    --regal-glass: rgba(26, 31, 58, 0.9);
    --regal-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
}

.regal-dashboard-container {
    min-height: 100vh;
    background: linear-gradient(135deg, var(--regal-secondary) 0%, var(--regal-primary) 50%, var(--regal-secondary) 100%);
    padding: 80px 20px 20px; /* Added top padding to move content down from header */
    position: relative;
    overflow-x: hidden;
    max-width: 1400px;
    margin: 0 auto;
}

/* Background Animation */
.dashboard-background {
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

/* Welcome Section */
.elite-welcome {
    background: var(--regal-glass);
    backdrop-filter: blur(25px) saturate(200%);
    border: 2px solid var(--regal-border);
    border-radius: 25px;
    padding: 40px;
    margin-bottom: 40px;
    box-shadow: var(--regal-shadow);
    position: relative;
    overflow: hidden;
}

.elite-welcome::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--regal-accent), var(--regal-accent-light), var(--regal-accent));
}

.welcome-content-regal {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    flex-wrap: wrap;
    gap: 20px;
}

.welcome-crown {
    font-size: 3rem;
    position: absolute;
    top: -10px;
    right: 30px;
    filter: drop-shadow(0 4px 12px rgba(218, 165, 32, 0.4));
    animation: crownFloat 6s ease-in-out infinite;
}

@keyframes crownFloat {
    0%, 100% { 
        transform: translateY(0px) rotate(0deg); 
    }
    50% { 
        transform: translateY(-8px) rotate(3deg); 
    }
}

.welcome-text-regal h1 {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--regal-text);
    margin-bottom: 10px;
}

.username-highlight {
    background: linear-gradient(135deg, var(--regal-accent), var(--regal-accent-light));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.welcome-subtitle {
    font-size: 1.2rem;
    color: var(--regal-text-muted);
    font-style: italic;
    font-weight: 500;
}

.welcome-actions-regal {
    flex-shrink: 0;
}

.elite-stats-preview {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 30px;
    padding: 25px;
    background: rgba(218, 165, 32, 0.1);
    border-radius: 16px;
    backdrop-filter: blur(10px);
}

.stat-preview-regal {
    text-align: center;
}

.stat-number-regal {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--regal-accent);
    display: block;
    line-height: 1;
}

.stat-label-regal {
    font-size: 0.9rem;
    color: var(--regal-text-muted);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.stat-divider-regal {
    width: 2px;
    height: 40px;
    background: linear-gradient(180deg, transparent, var(--regal-accent), transparent);
}

/* Sections */
.elite-section {
    margin-bottom: 50px;
}

.elite-section-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 30px;
    flex-wrap: wrap;
    gap: 20px;
}

.section-title-regal {
    display: flex;
    align-items: center;
    gap: 15px;
}

.section-crown {
    font-size: 2rem;
    filter: drop-shadow(0 2px 8px rgba(218, 165, 32, 0.4));
}

.section-title-regal h3 {
    font-size: 1.8rem;
    font-weight: 800;
    color: var(--regal-accent);
    margin-bottom: 5px;
}

.section-subtitle-regal {
    font-size: 1rem;
    color: var(--regal-text-muted);
    font-weight: 500;
    font-style: italic;
}

.view-all-link-regal {
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--regal-accent);
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    padding: 8px 16px;
    border-radius: 12px;
    border: 1px solid var(--regal-border);
    background: rgba(218, 165, 32, 0.1);
}

.view-all-link-regal:hover {
    background: rgba(218, 165, 32, 0.2);
    transform: translateX(3px);
    text-shadow: 0 2px 4px rgba(218, 165, 32, 0.3);
}

/* Movie Cards */
.elite-scroll-container {
    overflow-x: auto;
    padding-bottom: 10px;
    -webkit-overflow-scrolling: touch;
    scroll-behavior: smooth;
}

.elite-movies-grid {
    display: flex;
    gap: 20px;
    padding: 5px;
    min-width: min-content;
}

.elite-movie-card {
    min-width: 200px;
    flex-shrink: 0;
    background: var(--regal-glass);
    backdrop-filter: blur(20px);
    border: 2px solid var(--regal-border);
    border-radius: 18px;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
    cursor: pointer;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    position: relative;
}

.elite-movie-card:hover {
    transform: translateY(-10px) scale(1.02);
    border-color: var(--regal-accent);
    box-shadow: 0 15px 35px rgba(218, 165, 32, 0.3);
}

.elite-movie-poster {
    position: relative;
    height: 280px;
    overflow: hidden;
}

.elite-movie-poster img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.elite-movie-card:hover .elite-movie-poster img {
    transform: scale(1.1);
}

.elite-movie-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(180deg, transparent 40%, rgba(0, 0, 0, 0.8));
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.elite-movie-card:hover .elite-movie-overlay {
    opacity: 1;
}

.elite-play-button {
    background: var(--regal-accent);
    border: none;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--regal-primary);
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(218, 165, 32, 0.4);
}

.elite-play-button:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(218, 165, 32, 0.6);
}

.elite-overlay-actions {
    display: flex;
    gap: 10px;
}

.elite-action-btn {
    background: rgba(255, 255, 255, 0.9);
    border: none;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.btn-approve {
    color: #10b981;
}

.btn-remove {
    color: #ef4444;
}

.elite-action-btn:hover {
    transform: scale(1.1);
    background: rgba(255, 255, 255, 1);
}

.elite-movie-status {
    position: absolute;
    top: 10px;
    right: 10px;
}

.elite-rating-badge,
.elite-imdb-badge {
    background: rgba(0, 0, 0, 0.8);
    color: var(--regal-accent);
    padding: 4px 8px;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
    backdrop-filter: blur(10px);
}

.movie-quality-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    background: linear-gradient(135deg, var(--regal-accent), var(--regal-accent-light));
    color: var(--regal-primary);
    padding: 4px 8px;
    border-radius: 8px;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.elite-movie-info {
    padding: 20px;
}

.elite-movie-info h4 {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--regal-text);
    margin-bottom: 8px;
    line-height: 1.3;
}

.elite-movie-info p {
    font-size: 0.9rem;
    color: var(--regal-text-muted);
    margin-bottom: 8px;
    font-weight: 500;
}

.viewed-date-regal,
.added-date-regal {
    font-size: 0.8rem;
    color: var(--regal-accent);
    font-weight: 600;
    font-style: italic;
}

/* Buttons */
.btn-regal {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 15px 25px;
    border: none;
    border-radius: 12px;
    font-weight: 700;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
    text-decoration: none;
    position: relative;
    overflow: hidden;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.btn-primary-regal {
    background: linear-gradient(135deg, var(--regal-accent), var(--regal-accent-light));
    color: var(--regal-primary);
    box-shadow: 0 8px 25px rgba(218, 165, 32, 0.4);
}

.btn-primary-regal:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(218, 165, 32, 0.5);
    background: linear-gradient(135deg, var(--regal-accent-light), #fff);
}

.btn-icon {
    font-size: 1.1rem;
}

/* Animations */
.animate-on-scroll {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.6s ease;
}

.animate-on-scroll.animate-visible {
    opacity: 1;
    transform: translateY(0);
}

.animate-card {
    opacity: 0;
    transform: translateY(20px);
    animation: cardSlideIn 0.6s ease forwards;
}

@keyframes cardSlideIn {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .regal-dashboard-container {
        padding: 60px 15px 15px; /* Adjusted top padding for mobile */
    }

    .elite-welcome {
        padding: 20px 15px;
    }

    .welcome-content-regal {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }

    .welcome-crown {
        position: static;
        margin-bottom: 15px;
        font-size: 2.5rem;
    }

    .welcome-text-regal h1 {
        font-size: 1.8rem;
        line-height: 1.3;
    }

    .elite-stats-preview {
        flex-direction: column;
        gap: 15px;
        padding: 20px;
    }

    .stat-divider-regal {
        width: 40px;
        height: 2px;
    }

    .elite-section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }

    .section-title-regal h3 {
        font-size: 1.5rem;
    }

    .elite-movies-grid {
        gap: 15px;
    }

    .elite-movie-card {
        min-width: 180px;
    }
}

@media (max-width: 480px) {
    .regal-dashboard-container {
        padding: 50px 10px 10px; /* Further adjusted for small screens */
    }

    .elite-welcome {
        padding: 15px 10px;
    }

    .welcome-text-regal h1 {
        font-size: 1.6rem;
        margin-bottom: 8px;
    }

    .welcome-subtitle {
        font-size: 1rem;
    }

    .section-title-regal h3 {
        font-size: 1.3rem;
    }

    .btn-regal {
        padding: 12px 20px;
        font-size: 0.9rem;
    }

    .elite-movie-card {
        min-width: 160px;
    }
}

/* Scrollbar Styling */
.elite-scroll-container::-webkit-scrollbar {
    height: 8px;
}

.elite-scroll-container::-webkit-scrollbar-track {
    background: rgba(218, 165, 32, 0.1);
    border-radius: 4px;
}

.elite-scroll-container::-webkit-scrollbar-thumb {
    background: linear-gradient(90deg, var(--regal-accent), var(--regal-accent-light));
    border-radius: 4px;
}

.elite-scroll-container::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(90deg, var(--regal-accent-light), var(--regal-accent));
}
</style>