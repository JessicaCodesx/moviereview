<?php
// Elite Cinema Profile - app/views/profile/index.php
?>
<div class="regal-profile-container">
    <!-- Regal Background Animation -->
    <div class="profile-background">
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

    <!-- Elite Profile Header -->
    <div class="elite-profile-header animate-on-scroll">
        <div class="royal-banner">
            <div class="banner-crown-pattern"></div>
            <div class="elite-profile-content">
                <div class="royal-avatar-section">
                    <div class="elite-avatar-wrapper">
                        <div class="royal-avatar">
                            <span class="avatar-monogram"><?php echo strtoupper(substr($data['user']['username'], 0, 2)); ?></span>
                            <div class="avatar-crown-ring"></div>
                            <div class="avatar-glow"></div>
                        </div>
                        <div class="distinguished-status">
                            <span class="status-crown">👑</span>
                            <span class="status-text">Distinguished Member</span>
                        </div>
                    </div>

                    <div class="elite-profile-info">
                        <h1 class="royal-name">
                            <span class="name-text"><?php echo htmlspecialchars($data['user']['username']); ?></span>
                            <span class="name-crown">👑</span>
                        </h1>
                        <p class="distinguished-title">Cinematic Connoisseur</p>
                        <div class="royal-meta">
                            <div class="meta-item-royal">
                                <span class="meta-icon-royal">🏛️</span>
                                <span>Joined the Elite Circle <?php echo date('F Y', strtotime($data['user']['created_at'])); ?></span>
                            </div>
                            <?php if ($data['user']['last_login']): ?>
                            <div class="meta-item-royal">
                                <span class="meta-icon-royal">⏰</span>
                                <span>Last graced our presence <?php echo $this->timeAgo($data['user']['last_login']); ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Distinguished Metrics Dashboard -->
    <div class="distinguished-metrics animate-on-scroll">
        <div class="metrics-header-royal">
            <div class="section-crown">👑</div>
            <h2>Your Distinguished Journey</h2>
            <p>A testament to your refined cinematic taste</p>
        </div>

        <div class="elite-metrics-grid">
            <div class="elite-metric-card ratings-royal">
                <div class="metric-crown">⭐</div>
                <div class="metric-icon-royal-wrapper">
                    <span class="metric-icon-royal">🏆</span>
                    <div class="icon-glow-royal"></div>
                </div>
                <div class="metric-content-royal">
                    <div class="metric-number-royal"><?php echo $data['stats']['ratings_count'] ?? 0; ?></div>
                    <div class="metric-label-royal">Masterpieces Critiqued</div>
                    <div class="metric-progress-royal">
                        <div class="progress-bar-royal ratings-progress-royal" data-progress="<?php echo min(100, ($data['stats']['ratings_count'] ?? 0) * 2); ?>"></div>
                    </div>
                </div>
                <div class="metric-trend-royal">
                    <span class="trend-icon-royal">📈</span>
                </div>
            </div>

            <div class="elite-metric-card collection-royal">
                <div class="metric-crown">📜</div>
                <div class="metric-icon-royal-wrapper">
                    <span class="metric-icon-royal">📚</span>
                    <div class="icon-glow-royal"></div>
                </div>
                <div class="metric-content-royal">
                    <div class="metric-number-royal"><?php echo $data['stats']['watchlist_count'] ?? 0; ?></div>
                    <div class="metric-label-royal">Curated Collection</div>
                    <div class="metric-progress-royal">
                        <div class="progress-bar-royal collection-progress-royal" data-progress="<?php echo min(100, ($data['stats']['watchlist_count'] ?? 0) * 5); ?>"></div>
                    </div>
                </div>
                <div class="metric-action-royal">
                    <a href="/watchlist" class="action-link-royal">View Treasury</a>
                </div>
            </div>

            <div class="elite-metric-card classics-royal">
                <div class="metric-crown">🎭</div>
                <div class="metric-icon-royal-wrapper">
                    <span class="metric-icon-royal">🎪</span>
                    <div class="icon-glow-royal"></div>
                </div>
                <div class="metric-content-royal">
                    <div class="metric-number-royal"><?php echo $data['stats']['watched_count'] ?? 0; ?></div>
                    <div class="metric-label-royal">Classics Appreciated</div>
                    <div class="metric-progress-royal">
                        <div class="progress-bar-royal classics-progress-royal" data-progress="<?php echo min(100, ($data['stats']['watched_count'] ?? 0) * 3); ?>"></div>
                    </div>
                </div>
                <div class="metric-action-royal">
                    <a href="/watched" class="action-link-royal">View Gallery</a>
                </div>
            </div>

            <div class="elite-metric-card refinement-royal">
                <div class="metric-crown">💎</div>
                <div class="metric-icon-royal-wrapper">
                    <span class="metric-icon-royal">🎯</span>
                    <div class="icon-glow-royal"></div>
                </div>
                <div class="metric-content-royal">
                    <div class="metric-number-royal"><?php echo number_format($data['stats']['avg_rating'] ?? 0, 1); ?></div>
                    <div class="metric-label-royal">Refinement Index</div>
                    <div class="metric-visual-royal">
                        <div class="rating-constellation">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <span class="star-constellation <?php echo $i <= round($data['stats']['avg_rating'] ?? 0) ? 'illuminated' : ''; ?>">⭐</span>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
                <div class="royal-badge">
                    <?php if (($data['stats']['avg_rating'] ?? 0) >= 4): ?>
                        <span class="badge-royal badge-excellence">Exceptional Taste</span>
                    <?php elseif (($data['stats']['avg_rating'] ?? 0) >= 3): ?>
                        <span class="badge-royal badge-distinguished">Distinguished Palate</span>
                    <?php else: ?>
                        <span class="badge-royal badge-discerning">Discerning Eye</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Cinematic Chronicles -->
    <?php if (!empty($data['recent_ratings'])): ?>
    <div class="cinematic-chronicles animate-on-scroll">
        <div class="chronicles-header-royal">
            <div class="section-crown">📖</div>
            <h2>Recent Cinematic Chronicles</h2>
        </div>

        <div class="royal-chronicles-scroll">
            <?php foreach ($data['recent_ratings'] as $index => $rating): ?>
                <div class="chronicle-entry-royal" data-animation-delay="<?php echo $index * 0.1; ?>">
                    <div class="chronicle-avatar-royal">
                        <span class="chronicle-icon-royal">⭐</span>
                    </div>
                    <div class="chronicle-content-royal" onclick="movieAppInstance.loadMovieDetails('<?php echo $rating['imdb_id']; ?>')">
                        <div class="chronicle-header-royal">
                            <h4>Critiqued "<?php echo htmlspecialchars($rating['title']); ?>"</h4>
                            <span class="chronicle-time-royal"><?php echo $this->timeAgo($rating['created_at']); ?></span>
                        </div>
                        <div class="chronicle-details-royal">
                            <div class="royal-poster-mini">
                                <img src="<?php echo $rating['poster'] !== 'N/A' ? $rating['poster'] : '/public/assets/images/no-image.png'; ?>" 
                                     alt="<?php echo htmlspecialchars($rating['title']); ?>"
                                     onerror="this.src='/public/assets/images/no-image.png'">
                                <div class="poster-glow-mini"></div>
                            </div>
                            <div class="chronicle-info-royal">
                                <p><?php echo $rating['year']; ?> • <?php echo htmlspecialchars($rating['genre']); ?></p>
                                <div class="royal-rating-display">
                                    <span class="royal-constellation-mini">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <span class="star-mini-royal <?php echo $i <= $rating['rating'] ? 'illuminated' : ''; ?>">⭐</span>
                                        <?php endfor; ?>
                                    </span>
                                    <span class="rating-score-royal"><?php echo $rating['rating']; ?>/5 Stars</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chronicle-actions-royal">
                        <button class="royal-action-btn" onclick="editRating(<?php echo $rating['movie_id']; ?>)" title="Refine critique">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="m18.5 2.5 3 3L12 15l-4 1 1-4z"></path>
                            </svg>
                        </button>
                        <button class="royal-action-btn danger-royal" onclick="deleteRating(<?php echo $rating['movie_id']; ?>)" title="Remove critique">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="3,6 5,6 21,6"></polyline>
                                <path d="M19,6v14a2,2 0 0,1-2,2H7a2,2 0 0,1-2,-2V6m3,0V4a2,2 0 0,1 2,-2h4a2,2 0 0,1 2,2v2"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
// Initialize royal scroll animations
function initRoyalScrollAnimations() {
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

// Enhanced elite functionality
async function editRating(movieId) {
    console.log('Refining critique for masterpiece:', movieId);
    movieAppInstance.showToast('Critique refinement feature coming soon to the royal court!', 'info');
}

async function deleteRating(movieId) {
    if (!confirm('Remove this critique from your distinguished records?')) return;

    try {
        const response = await fetch('/api/ratings/delete', {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ movieId })
        });

        const data = await response.json();

        if (data.success) {
            movieAppInstance.showToast('Critique removed from royal records', 'success');
            location.reload();
        } else {
            movieAppInstance.showToast('Error: ' + data.error, 'error');
        }
    } catch (error) {
        movieAppInstance.showToast('Error removing critique', 'error');
    }
}

// Initialize floating particles
function initializeFloatingParticles() {
    const particles = document.querySelectorAll('.particle');
    particles.forEach((particle, index) => {
        particle.style.animationDelay = `${index * 2.5}s`;
        particle.style.left = `${Math.random() * 100}%`;
        particle.style.top = `${Math.random() * 100}%`;
    });
}

// Initialize when royal court loads
document.addEventListener('DOMContentLoaded', () => {
    initRoyalScrollAnimations();
    initializeFloatingParticles();

    // Royal stagger animation for chronicles
    document.querySelectorAll('.chronicle-entry-royal').forEach((item, index) => {
        item.style.animationDelay = `${index * 0.15}s`;
    });

    // Initialize progress bars with royal timing
    setTimeout(() => {
        document.querySelectorAll('.progress-bar-royal, .progress-advancement-royal').forEach(bar => {
            const progress = bar.getAttribute('data-progress');
            bar.style.width = progress + '%';
        });
    }, 800);
});
</script>

<style>
/* Elite Cinema Profile Styles */
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

.regal-profile-container {
    min-height: 100vh;
    background: linear-gradient(135deg, var(--regal-secondary) 0%, var(--regal-primary) 50%, var(--regal-secondary) 100%);
    padding: 30px;
    position: relative;
    overflow-x: hidden;
    max-width: 1400px;
    margin: 0 auto;
}

@media (max-width: 768px) {
    .regal-profile-container {
        padding: 20px 15px;
    }
}

/* Background Animation */
.profile-background {
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

/* Elite Profile Header */
.elite-profile-header {
    margin-bottom: 50px;
}

.royal-banner {
    background: var(--regal-glass);
    backdrop-filter: blur(25px) saturate(200%);
    border: 2px solid var(--regal-border);
    border-radius: 25px;
    overflow: hidden;
    position: relative;
    box-shadow: var(--regal-shadow);
}

.banner-crown-pattern {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--regal-accent), var(--regal-accent-light), var(--regal-accent));
}

.elite-profile-content {
    position: relative;
    padding: 50px;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 40px;
    flex-wrap: wrap;
}

@media (max-width: 768px) {
    .elite-profile-content {
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 30px;
        padding: 30px 25px;
    }
}

.royal-avatar-section {
    display: flex;
    align-items: center;
    gap: 40px;
}

@media (max-width: 768px) {
    .royal-avatar-section {
        flex-direction: column;
        align-items: center;
        gap: 25px;
    }
}

.elite-avatar-wrapper {
    text-align: center;
}

.royal-avatar {
    width: 140px;
    height: 140px;
    background: linear-gradient(135deg, var(--regal-accent), var(--regal-accent-light));
    border: 4px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    margin-bottom: 20px;
    box-shadow: var(--regal-shadow);
}

.avatar-crown-ring {
    position: absolute;
    inset: -12px;
    border: 3px solid var(--regal-accent);
    border-radius: 50%;
    border-top-color: var(--regal-accent-light);
    border-right-color: transparent;
    animation: rotate 4s linear infinite;
}

@keyframes rotate {
    to { transform: rotate(360deg); }
}

.avatar-glow {
    position: absolute;
    inset: -20px;
    background: radial-gradient(circle, rgba(218, 165, 32, 0.3), transparent);
    border-radius: 50%;
    animation: pulse 3s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 0.5; }
    50% { opacity: 1; }
}

.avatar-monogram {
    font-size: 3rem;
    font-weight: 900;
    color: var(--regal-primary);
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}

.distinguished-status {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    color: var(--regal-text);
    font-size: 0.9rem;
    font-weight: 600;
}

.status-crown {
    font-size: 1.2rem;
    animation: crownFloat 4s ease-in-out infinite;
}

@keyframes crownFloat {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-4px); }
}

.elite-profile-info {
    color: var(--regal-text);
    text-align: center;
}

.royal-name {
    font-size: 3rem;
    font-weight: 900;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}

.name-text {
    background: linear-gradient(135deg, var(--regal-text), var(--regal-accent-light));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.name-crown {
    font-size: 2rem;
    filter: drop-shadow(0 2px 8px rgba(218, 165, 32, 0.4));
}

.distinguished-title {
    font-size: 1.3rem;
    margin-bottom: 25px;
    opacity: 0.9;
    font-style: italic;
    font-weight: 500;
}

.royal-meta {
    display: flex;
    flex-direction: column;
    gap: 15px;
    align-items: center;
}

.meta-item-royal {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 1rem;
    opacity: 0.9;
    font-weight: 500;
}

.meta-icon-royal {
    font-size: 1.2rem;
    filter: drop-shadow(0 1px 2px rgba(218, 165, 32, 0.3));
}

/* Distinguished Metrics */
.distinguished-metrics {
    margin-bottom: 60px;
}

.metrics-header-royal {
    text-align: center;
    margin-bottom: 40px;
    color: var(--regal-text);
}

.section-crown {
    font-size: 3rem;
    margin-bottom: 20px;
    filter: drop-shadow(0 4px 12px rgba(218, 165, 32, 0.4));
    animation: crownFloat 6s ease-in-out infinite;
}

.metrics-header-royal h2 {
    font-size: 2.5rem;
    font-weight: 900;
    margin-bottom: 15px;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    background: linear-gradient(135deg, var(--regal-accent), var(--regal-accent-light));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.metrics-header-royal p {
    font-size: 1.2rem;
    opacity: 0.9;
    font-style: italic;
}

.elite-metrics-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
}

.elite-metric-card {
    background: var(--regal-glass);
    backdrop-filter: blur(25px);
    border: 2px solid var(--regal-border);
    border-radius: 20px;
    padding: 35px 30px;
    transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    position: relative;
    overflow: hidden;
}

.elite-metric-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(218, 165, 32, 0.1), transparent);
    transition: left 0.8s ease;
}

.elite-metric-card:hover::before {
    left: 100%;
}

.elite-metric-card:hover {
    transform: translateY(-10px);
    border-color: var(--regal-accent);
    box-shadow: 0 15px 35px rgba(218, 165, 32, 0.3);
}

.metric-crown {
    position: absolute;
    top: 20px;
    right: 25px;
    font-size: 1.8rem;
    opacity: 0.6;
    filter: drop-shadow(0 2px 4px rgba(218, 165, 32, 0.3));
}

.metric-icon-royal-wrapper {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, var(--regal-accent), var(--regal-accent-light));
    border-radius: 16px;
    margin-bottom: 25px;
    box-shadow: 0 4px 15px rgba(218, 165, 32, 0.3);
}

.metric-icon-royal {
    font-size: 2rem;
    color: var(--regal-primary);
}

.icon-glow-royal {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle, rgba(218, 165, 32, 0.3), transparent);
    border-radius: 16px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.elite-metric-card:hover .icon-glow-royal {
    opacity: 1;
}

.metric-number-royal {
    font-size: 3rem;
    font-weight: 900;
    color: var(--regal-accent);
    margin-bottom: 10px;
    line-height: 1;
}

.metric-label-royal {
    color: var(--regal-text);
    font-weight: 700;
    margin-bottom: 20px;
    font-size: 1.1rem;
}

.metric-progress-royal {
    width: 100%;
    height: 6px;
    background: rgba(218, 165, 32, 0.2);
    border-radius: 3px;
    overflow: hidden;
    margin-bottom: 20px;
}

.progress-bar-royal {
    height: 100%;
    background: linear-gradient(90deg, var(--regal-accent), var(--regal-accent-light));
    border-radius: 3px;
    width: 0%;
    transition: width 1.5s ease-out;
    box-shadow: 0 0 15px rgba(218, 165, 32, 0.5);
}

.metric-trend-royal {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.9rem;
    color: #34d399;
    font-weight: 600;
}

.trend-icon-royal {
    font-size: 1rem;
}

.metric-action-royal {
    margin-top: 15px;
}

.action-link-royal {
    color: var(--regal-accent);
    text-decoration: none;
    font-weight: 700;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    padding: 5px 10px;
    border-radius: 8px;
}

.action-link-royal:hover {
    background: rgba(218, 165, 32, 0.1);
    transform: translateX(3px);
}

.metric-visual-royal {
    margin-top: 15px;
}

.rating-constellation {
    display: flex;
    gap: 3px;
    justify-content: center;
}

.star-constellation {
    font-size: 1rem;
    color: rgba(218, 165, 32, 0.3);
    transition: color 0.3s ease;
}

.star-constellation.illuminated {
    color: var(--regal-accent);
    text-shadow: 0 0 8px rgba(218, 165, 32, 0.6);
}

.royal-badge {
    margin-top: 15px;
    text-align: center;
}

.badge-royal {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.badge-excellence {
    background: linear-gradient(135deg, #10b981, #34d399);
    color: white;
}

.badge-distinguished {
    background: linear-gradient(135deg, var(--regal-accent), var(--regal-accent-light));
    color: var(--regal-primary);
}

.badge-discerning {
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: white;
}

/* Royal Accomplishments */
.royal-accomplishments {
    margin-bottom: 60px;
}

.accomplishments-header-royal {
    text-align: center;
    margin-bottom: 40px;
    color: var(--regal-text);
}

.accomplishments-header-royal h2 {
    font-size: 2.5rem;
    font-weight: 900;
    margin-bottom: 15px;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    background: linear-gradient(135deg, var(--regal-accent), var(--regal-accent-light));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.accomplishments-header-royal p {
    font-size: 1.2rem;
    opacity: 0.9;
    font-style: italic;
}

.accomplishments-gallery {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 25px;
}

.accomplishment-card-royal {
    background: var(--regal-glass);
    backdrop-filter: blur(25px);
    border: 2px solid var(--regal-border);
    border-radius: 18px;
    padding: 30px;
    display: flex;
    align-items: center;
    gap: 20px;
    transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    position: relative;
    overflow: hidden;
}

.accomplishment-card-royal.bestowed {
    border-color: var(--regal-accent);
    background: linear-gradient(135deg, rgba(218, 165, 32, 0.1), var(--regal-glass));
}

.accomplishment-card-royal.pending {
    opacity: 0.7;
    filter: grayscale(0.3);
}

.accomplishment-card-royal:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 30px rgba(218, 165, 32, 0.3);
}

.accomplishment-crown {
    position: absolute;
    top: 15px;
    right: 20px;
    font-size: 1.5rem;
    opacity: 0.6;
}

.accomplishment-icon-royal {
    font-size: 3rem;
    flex-shrink: 0;
    filter: drop-shadow(0 2px 8px rgba(218, 165, 32, 0.3));
}

.accomplishment-info-royal h4 {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--regal-accent);
    margin-bottom: 8px;
}

.accomplishment-info-royal p {
    color: var(--regal-text-muted);
    margin-bottom: 20px;
    font-weight: 500;
}

.accomplishment-progress-royal {
    display: flex;
    align-items: center;
    gap: 15px;
}

.progress-track-royal {
    flex: 1;
    height: 8px;
    background: rgba(218, 165, 32, 0.2);
    border-radius: 4px;
    overflow: hidden;
}

.progress-advancement-royal {
    height: 100%;
    background: linear-gradient(90deg, var(--regal-accent), var(--regal-accent-light));
    border-radius: 4px;
    width: 0%;
    transition: width 1.5s ease-out;
    box-shadow: 0 0 10px rgba(218, 165, 32, 0.5);
}

.progress-notation-royal {
    font-size: 0.9rem;
    font-weight: 700;
    color: var(--regal-text-muted);
}

.bestowed-seal {
    position: absolute;
    top: 15px;
    left: 20px;
    background: linear-gradient(135deg, #10b981, #34d399);
    color: white;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 900;
    font-size: 1.2rem;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
}

/* Cinematic Chronicles */
.cinematic-chronicles {
    margin-bottom: 60px;
}

.chronicles-header-royal {
    text-align: center;
    margin-bottom: 30px;
    color: var(--regal-text);
}

.chronicles-header-royal h2 {
    font-size: 2.5rem;
    font-weight: 900;
    margin-bottom: 15px;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    background: linear-gradient(135deg, var(--regal-accent), var(--regal-accent-light));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.royal-chronicles-scroll {
    background: var(--regal-glass);
    backdrop-filter: blur(25px);
    border: 2px solid var(--regal-border);
    border-radius: 20px;
    padding: 30px;
    box-shadow: var(--regal-shadow);
}

.chronicle-entry-royal {
    display: flex;
    gap: 20px;
    padding: 20px;
    border-radius: 16px;
    transition: all 0.3s ease;
    animation: slideInUp 0.6s ease-out;
    animation-fill-mode: both;
    position: relative;
}

.chronicle-entry-royal:hover {
    background: rgba(218, 165, 32, 0.1);
    transform: translateX(8px);
}

.chronicle-avatar-royal {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, var(--regal-accent), var(--regal-accent-light));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 4px 15px rgba(218, 165, 32, 0.3);
}

.chronicle-icon-royal {
    color: var(--regal-primary);
    font-size: 1.3rem;
}

.chronicle-content-royal {
    flex: 1;
    cursor: pointer;
}

.chronicle-header-royal {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.chronicle-header-royal h4 {
    font-weight: 700;
    color: var(--regal-text);
    font-size: 1.1rem;
}

.chronicle-time-royal {
    font-size: 0.9rem;
    color: var(--regal-text-muted);
    font-weight: 500;
}

.chronicle-details-royal {
    display: flex;
    gap: 15px;
}

.royal-poster-mini {
    width: 50px;
    height: 75px;
    border-radius: 8px;
    overflow: hidden;
    flex-shrink: 0;
    position: relative;
}

.royal-poster-mini img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.poster-glow-mini {
    position: absolute;
    inset: 0;
    background: linear-gradient(45deg, transparent, rgba(218, 165, 32, 0.1), transparent);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.chronicle-entry-royal:hover .poster-glow-mini {
    opacity: 1;
}

.chronicle-info-royal p {
    color: var(--regal-text-muted);
    font-size: 0.9rem;
    margin-bottom: 10px;
    font-weight: 500;
}

.royal-rating-display {
    display: flex;
    align-items: center;
    gap: 10px;
}

.royal-constellation-mini {
    display: flex;
    gap: 2px;
}

.star-mini-royal {
    font-size: 0.8rem;
    color: rgba(218, 165, 32, 0.3);
}

.star-mini-royal.illuminated {
    color: var(--regal-accent);
    text-shadow: 0 0 4px rgba(218, 165, 32, 0.6);
}

.rating-score-royal {
    font-weight: 700;
    color: var(--regal-accent);
    font-size: 0.9rem;
}

.chronicle-actions-royal {
    display: flex;
    gap: 10px;
    flex-shrink: 0;
}

.royal-action-btn {
    background: rgba(218, 165, 32, 0.1);
    border: 1px solid var(--regal-border);
    border-radius: 8px;
    padding: 8px;
    cursor: pointer;
    color: var(--regal-accent);
    transition: all 0.3s ease;
}

.royal-action-btn:hover {
    background: rgba(218, 165, 32, 0.2);
    color: var(--regal-accent-light);
    transform: scale(1.1);
}

.royal-action-btn.danger-royal:hover {
    background: rgba(239, 68, 68, 0.2);
    color: #f87171;
    border-color: rgba(239, 68, 68, 0.3);
}

/* Animations */
.animate-on-scroll {
    opacity: 0;
    transform: translateY(40px);
    transition: all 0.8s ease;
}

.animate-on-scroll.animate-visible {
    opacity: 1;
    transform: translateY(0);
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .elite-metrics-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .accomplishments-gallery {
        grid-template-columns: 1fr;
    }

    .accomplishment-card-royal {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }

    .chronicle-details-royal {
        flex-direction: column;
        gap: 10px;
    }

    .royal-name {
        font-size: 2rem;
        flex-direction: column;
        gap: 10px;
    }
}

@media (max-width: 480px) {
    .elite-profile-content {
        padding: 25px 20px;
    }

    .royal-avatar {
        width: 120px;
        height: 120px;
    }

    .avatar-monogram {
        font-size: 2.5rem;
    }

    .royal-name {
        font-size: 1.8rem;
    }

    .metrics-header-royal h2,
    .accomplishments-header-royal h2,
    .chronicles-header-royal h2 {
        font-size: 2rem;
    }

    .chronicle-entry-royal {
        flex-direction: column;
        gap: 15px;
    }

    .chronicle-actions-royal {
        align-self: flex-start;
    }
}
</style>