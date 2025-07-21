<?php
?>
<div class="profile-container">
    <!-- Enhanced Profile Header -->
    <div class="profile-header animate-on-scroll">
        <div class="profile-banner">
            <div class="banner-gradient"></div>
            <div class="profile-content">
                <div class="profile-avatar-section">
                    <div class="profile-avatar-wrapper">
                        <div class="profile-avatar">
                            <span class="avatar-text"><?php echo strtoupper(substr($data['user']['username'], 0, 2)); ?></span>
                            <div class="avatar-ring"></div>
                        </div>
                        <div class="avatar-status">
                            <span class="status-dot"></span>
                            <span class="status-text">Active</span>
                        </div>
                    </div>

                    <div class="profile-info">
                        <h1 class="profile-name"><?php echo htmlspecialchars($data['user']['username']); ?></h1>
                        <p class="profile-title">Movie Enthusiast</p>
                        <div class="profile-meta">
                            <div class="meta-item">
                                <span class="meta-icon">📅</span>
                                <span>Joined <?php echo date('F Y', strtotime($data['user']['created_at'])); ?></span>
                            </div>
                            <?php if ($data['user']['last_login']): ?>
                            <div class="meta-item">
                                <span class="meta-icon">🕒</span>
                                <span>Last seen <?php echo $this->timeAgo($data['user']['last_login']); ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="profile-actions">
                    <button class="btn btn-primary" onclick="showEditProfile()">
                        <span class="btn-icon">✏️</span>
                        Edit Profile
                    </button>
                    <button class="btn btn-secondary" onclick="showChangePasswordModal()">
                        <span class="btn-icon">🔒</span>
                        Change Password
                    </button>
                    <div class="action-dropdown">
                        <button class="btn btn-secondary dropdown-toggle" onclick="toggleActionMenu()">
                            <span class="btn-icon">⚙️</span>
                            <svg class="dropdown-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="6,9 12,15 18,9"></polyline>
                            </svg>
                        </button>
                        <div class="dropdown-menu" id="actionMenu">
                            <a href="#" onclick="exportData()" class="dropdown-item">
                                <span class="item-icon">📊</span>
                                Export Data
                            </a>
                            <a href="#" onclick="showAccountSettings()" class="dropdown-item">
                                <span class="item-icon">⚙️</span>
                                Account Settings
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" onclick="showDeleteAccount()" class="dropdown-item danger">
                                <span class="item-icon">🗑️</span>
                                Delete Account
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Statistics Grid -->
    <div class="stats-dashboard animate-on-scroll">
        <div class="stats-header">
            <h2>Your Movie Journey</h2>
            <p>Track your progress and achievements</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card-enhanced ratings-stat">
                <div class="stat-icon-container">
                    <span class="stat-icon">⭐</span>
                    <div class="icon-glow"></div>
                </div>
                <div class="stat-content">
                    <div class="stat-number"><?php echo $data['stats']['ratings_count'] ?? 0; ?></div>
                    <div class="stat-label">Movies Rated</div>
                    <div class="stat-progress">
                        <div class="progress-line" style="width: <?php echo min(100, ($data['stats']['ratings_count'] ?? 0) * 2); ?>%"></div>
                    </div>
                </div>
                <div class="stat-trend">
                    <span class="trend-icon">📈</span>
                    <span class="trend-text">+12 this month</span>
                </div>
            </div>

            <div class="stat-card-enhanced watchlist-stat">
                <div class="stat-icon-container">
                    <span class="stat-icon">📝</span>
                    <div class="icon-glow"></div>
                </div>
                <div class="stat-content">
                    <div class="stat-number"><?php echo $data['stats']['watchlist_count'] ?? 0; ?></div>
                    <div class="stat-label">In Watchlist</div>
                    <div class="stat-progress">
                        <div class="progress-line" style="width: <?php echo min(100, ($data['stats']['watchlist_count'] ?? 0) * 5); ?>%"></div>
                    </div>
                </div>
                <div class="stat-action">
                    <a href="/watchlist" class="action-link">View All</a>
                </div>
            </div>

            <div class="stat-card-enhanced watched-stat">
                <div class="stat-icon-container">
                    <span class="stat-icon">✅</span>
                    <div class="icon-glow"></div>
                </div>
                <div class="stat-content">
                    <div class="stat-number"><?php echo $data['stats']['watched_count'] ?? 0; ?></div>
                    <div class="stat-label">Movies Watched</div>
                    <div class="stat-progress">
                        <div class="progress-line" style="width: <?php echo min(100, ($data['stats']['watched_count'] ?? 0) * 3); ?>%"></div>
                    </div>
                </div>
                <div class="stat-action">
                    <a href="/watched" class="action-link">View All</a>
                </div>
            </div>

            <div class="stat-card-enhanced rating-stat">
                <div class="stat-icon-container">
                    <span class="stat-icon">🎯</span>
                    <div class="icon-glow"></div>
                </div>
                <div class="stat-content">
                    <div class="stat-number"><?php echo number_format($data['stats']['avg_rating'] ?? 0, 1); ?></div>
                    <div class="stat-label">Avg Rating</div>
                    <div class="stat-visual">
                        <div class="rating-stars-small">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <span class="star-small <?php echo $i <= round($data['stats']['avg_rating'] ?? 0) ? 'filled' : ''; ?>">⭐</span>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
                <div class="stat-badge">
                    <?php if (($data['stats']['avg_rating'] ?? 0) >= 4): ?>
                        <span class="badge badge-success">High Standards</span>
                    <?php elseif (($data['stats']['avg_rating'] ?? 0) >= 3): ?>
                        <span class="badge badge-warning">Balanced</span>
                    <?php else: ?>
                        <span class="badge badge-info">Critical Eye</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Achievement System -->
    <div class="achievements-section animate-on-scroll">
        <div class="section-header">
            <h2>🏆 Achievements</h2>
            <p>Unlock badges as you explore more movies</p>
        </div>

        <div class="achievements-grid">
            <div class="achievement-card <?php echo ($data['stats']['ratings_count'] ?? 0) >= 10 ? 'unlocked' : 'locked'; ?>">
                <div class="achievement-icon">🎬</div>
                <div class="achievement-info">
                    <h4>Movie Critic</h4>
                    <p>Rate 10 movies</p>
                    <div class="achievement-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: <?php echo min(100, (($data['stats']['ratings_count'] ?? 0) / 10) * 100); ?>%"></div>
                        </div>
                        <span class="progress-text"><?php echo min(10, $data['stats']['ratings_count'] ?? 0); ?>/10</span>
                    </div>
                </div>
            </div>

            <div class="achievement-card <?php echo ($data['stats']['watchlist_count'] ?? 0) >= 5 ? 'unlocked' : 'locked'; ?>">
                <div class="achievement-icon">📚</div>
                <div class="achievement-info">
                    <h4>List Curator</h4>
                    <p>Add 5 movies to watchlist</p>
                    <div class="achievement-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: <?php echo min(100, (($data['stats']['watchlist_count'] ?? 0) / 5) * 100); ?>%"></div>
                        </div>
                        <span class="progress-text"><?php echo min(5, $data['stats']['watchlist_count'] ?? 0); ?>/5</span>
                    </div>
                </div>
            </div>

            <div class="achievement-card <?php echo ($data['stats']['watched_count'] ?? 0) >= 20 ? 'unlocked' : 'locked'; ?>">
                <div class="achievement-icon">🎪</div>
                <div class="achievement-info">
                    <h4>Movie Buff</h4>
                    <p>Watch 20 movies</p>
                    <div class="achievement-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: <?php echo min(100, (($data['stats']['watched_count'] ?? 0) / 20) * 100); ?>%"></div>
                        </div>
                        <span class="progress-text"><?php echo min(20, $data['stats']['watched_count'] ?? 0); ?>/20</span>
                    </div>
                </div>
            </div>

            <div class="achievement-card locked">
                <div class="achievement-icon">👑</div>
                <div class="achievement-info">
                    <h4>Cinema Master</h4>
                    <p>Rate 100 movies</p>
                    <div class="achievement-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: <?php echo min(100, (($data['stats']['ratings_count'] ?? 0) / 100) * 100); ?>%"></div>
                        </div>
                        <span class="progress-text"><?php echo min(100, $data['stats']['ratings_count'] ?? 0); ?>/100</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Enhanced -->
    <?php if (!empty($data['recent_ratings'])): ?>
    <div class="activity-section animate-on-scroll">
        <div class="section-header">
            <h2>🎬 Recent Activity</h2>
            <div class="activity-filters">
                <button class="filter-btn active" data-filter="all">All</button>
                <button class="filter-btn" data-filter="ratings">Ratings</button>
                <button class="filter-btn" data-filter="watchlist">Watchlist</button>
            </div>
        </div>

        <div class="activity-timeline">
            <?php foreach ($data['recent_ratings'] as $index => $rating): ?>
                <div class="activity-item" style="animation-delay: <?php echo $index * 0.1; ?>s">
                    <div class="activity-avatar">
                        <span class="activity-icon">⭐</span>
                    </div>
                    <div class="activity-content" onclick="movieAppInstance.loadMovieDetails('<?php echo $rating['imdb_id']; ?>')">
                        <div class="activity-header">
                            <h4>Rated "<?php echo htmlspecialchars($rating['title']); ?>"</h4>
                            <span class="activity-time"><?php echo $this->timeAgo($rating['created_at']); ?></span>
                        </div>
                        <div class="activity-details">
                            <div class="movie-poster-mini">
                                <img src="<?php echo $rating['poster'] !== 'N/A' ? $rating['poster'] : '/public/assets/images/no-image.png'; ?>" 
                                     alt="<?php echo htmlspecialchars($rating['title']); ?>"
                                     onerror="this.src='/public/assets/images/no-image.png'">
                            </div>
                            <div class="activity-info">
                                <p><?php echo $rating['year']; ?> • <?php echo htmlspecialchars($rating['genre']); ?></p>
                                <div class="rating-display-mini">
                                    <span class="rating-stars-mini">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <span class="star-mini <?php echo $i <= $rating['rating'] ? 'filled' : ''; ?>">⭐</span>
                                        <?php endfor; ?>
                                    </span>
                                    <span class="rating-score"><?php echo $rating['rating']; ?>/5</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="activity-actions">
                        <button class="action-btn" onclick="editRating(<?php echo $rating['movie_id']; ?>)" title="Edit rating">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="m18.5 2.5 3 3L12 15l-4 1 1-4z"></path>
                            </svg>
                        </button>
                        <button class="action-btn danger" onclick="deleteRating(<?php echo $rating['movie_id']; ?>)" title="Delete rating">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="3,6 5,6 21,6"></polyline>
                                <path d="M19,6v14a2,2 0 0,1-2,2H7a2,2 0 0,1-2,-2V6m3,0V4a2,2 0 0,1 2,-2h4a2,2 0 0,1 2,2v2"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="activity-footer">
            <a href="/api/ratings/user" class="btn btn-secondary" target="_blank">
                <span class="btn-icon">📊</span>
                View All Activity
            </a>
        </div>
    </div>
    <?php endif; ?>

    <!-- Quick Actions Enhanced -->
    <div class="quick-actions-section animate-on-scroll">
        <div class="section-header">
            <h2>⚡ Quick Actions</h2>
            <p>Jump to your favorite features</p>
        </div>

        <div class="quick-actions-enhanced">
            <a href="/" class="quick-action-enhanced">
                <div class="action-icon-bg">
                    <span class="action-icon">🔍</span>
                </div>
                <div class="action-content">
                    <h4>Discover Movies</h4>
                    <p>Find your next favorite film</p>
                </div>
                <div class="action-arrow">→</div>
            </a>

            <a href="/dashboard" class="quick-action-enhanced">
                <div class="action-icon-bg">
                    <span class="action-icon">📊</span>
                </div>
                <div class="action-content">
                    <h4>Dashboard</h4>
                    <p>Overview of your activity</p>
                </div>
                <div class="action-arrow">→</div>
            </a>

            <button onclick="loadRandomMovie()" class="quick-action-enhanced">
                <div class="action-icon-bg">
                    <span class="action-icon">🎲</span>
                </div>
                <div class="action-content">
                    <h4>Random Movie</h4>
                    <p>Feeling adventurous?</p>
                </div>
                <div class="action-arrow">→</div>
            </button>

            <button onclick="shareProfile()" class="quick-action-enhanced">
                <div class="action-icon-bg">
                    <span class="action-icon">🔗</span>
                </div>
                <div class="action-content">
                    <h4>Share Profile</h4>
                    <p>Show off your taste</p>
                </div>
                <div class="action-arrow">→</div>
            </button>
        </div>
    </div>
</div>

<!-- Enhanced Modals -->
<div id="passwordModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Change Password</h3>
            <button class="modal-close" onclick="closeChangePasswordModal()">&times;</button>
        </div>
        <div class="modal-body">
            <form id="changePasswordForm">
                <div class="form-group">
                    <label for="currentPassword" class="form-label">Current Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="currentPassword" name="current_password" required class="form-control">
                        <div class="input-border"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="newPassword" class="form-label">New Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="newPassword" name="new_password" required class="form-control" minlength="6">
                        <div class="input-border"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="confirmNewPassword" class="form-label">Confirm New Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="confirmNewPassword" name="confirm_password" required class="form-control">
                        <div class="input-border"></div>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeChangePasswordModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Password</button>
                </div>
            </form>
        </div>
        <div id="passwordMessage" class="auth-message"></div>
    </div>
</div>

<style>
/* Enhanced Profile Styles */
.profile-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 var(--space-4);
}

.profile-header {
    margin-bottom: var(--space-12);
}

.profile-banner {
    background: var(--gradient-primary);
    border-radius: var(--radius-2xl);
    overflow: hidden;
    position: relative;
    box-shadow: var(--shadow-2xl);
}

.banner-gradient {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(0,0,0,0.1) 0%, rgba(255,255,255,0.1) 100%);
}

.profile-content {
    position: relative;
    padding: var(--space-8);
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    gap: var(--space-6);
}

.profile-avatar-section {
    display: flex;
    align-items: flex-end;
    gap: var(--space-6);
}

.profile-avatar-wrapper {
    text-align: center;
}

.profile-avatar {
    width: 120px;
    height: 120px;
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
    border: 4px solid rgba(255,255,255,0.3);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    margin-bottom: var(--space-3);
    box-shadow: var(--shadow-xl);
}

.avatar-ring {
    position: absolute;
    inset: -8px;
    border: 2px solid rgba(255,255,255,0.5);
    border-radius: 50%;
    border-top-color: white;
    animation: rotate 3s linear infinite;
}

@keyframes rotate {
    to { transform: rotate(360deg); }
}

.avatar-text {
    font-size: 2.5rem;
    font-weight: 900;
    color: white;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.avatar-status {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: var(--space-1);
    color: rgba(255,255,255,0.9);
    font-size: var(--font-size-sm);
}

.status-dot {
    width: 8px;
    height: 8px;
    background: #10b981;
    border-radius: 50%;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

.profile-info {
    color: white;
}

.profile-name {
    font-size: var(--font-size-4xl);
    font-weight: 900;
    margin-bottom: var(--space-2);
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.profile-title {
    font-size: var(--font-size-lg);
    margin-bottom: var(--space-4);
    opacity: 0.9;
}

.profile-meta {
    display: flex;
    flex-wrap: wrap;
    gap: var(--space-4);
}

.meta-item {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    font-size: var(--font-size-sm);
    opacity: 0.9;
}

.meta-icon {
    font-size: var(--font-size-base);
}

.profile-actions {
    display: flex;
    gap: var(--space-3);
    align-items: flex-end;
}

.action-dropdown {
    position: relative;
}

.dropdown-toggle {
    display: flex;
    align-items: center;
    gap: var(--space-2);
}

.dropdown-arrow {
    transition: transform 0.2s ease;
}

.action-dropdown.open .dropdown-arrow {
    transform: rotate(180deg);
}

.dropdown-menu {
    position: absolute;
    top: 100%;
    right: 0;
    margin-top: var(--space-2);
    background: white;
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-2xl);
    border: 1px solid rgba(0,0,0,0.1);
    min-width: 200px;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.2s ease;
    z-index: 1000;
}

.action-dropdown.open .dropdown-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown-item {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    padding: var(--space-3) var(--space-4);
    color: var(--neutral-700);
    text-decoration: none;
    transition: var(--transition-base);
    border-radius: var(--radius-lg);
    margin: var(--space-1);
}

.dropdown-item:hover {
    background: var(--neutral-50);
}

.dropdown-item.danger:hover {
    background: #fef2f2;
    color: var(--error-600);
}

.dropdown-divider {
    height: 1px;
    background: var(--neutral-200);
    margin: var(--space-2) var(--space-4);
}

.stats-dashboard {
    margin-bottom: var(--space-12);
}

.stats-header {
    text-align: center;
    margin-bottom: var(--space-8);
    color: white;
}

.stats-header h2 {
    font-size: var(--font-size-3xl);
    font-weight: 900;
    margin-bottom: var(--space-2);
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.stats-header p {
    font-size: var(--font-size-lg);
    opacity: 0.9;
}

.stat-card-enhanced {
    background: white;
    border-radius: var(--radius-2xl);
    padding: var(--space-6);
    box-shadow: var(--shadow-xl);
    border: 1px solid rgba(255,255,255,0.2);
    transition: var(--transition-base);
    position: relative;
    overflow: hidden;
}

.stat-card-enhanced:hover {
    transform: translateY(-6px);
    box-shadow: var(--shadow-2xl);
}

.stat-card-enhanced::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-primary);
}

.stat-icon-container {
    position: relative;
    margin-bottom: var(--space-4);
}

.stat-icon {
    font-size: 2.5rem;
    position: relative;
    z-index: 2;
}

.icon-glow {
    position: absolute;
    inset: -10px;
    background: var(--gradient-primary);
    opacity: 0.1;
    border-radius: 50%;
    transition: var(--transition-base);
}

.stat-card-enhanced:hover .icon-glow {
    opacity: 0.2;
    transform: scale(1.2);
}

.stat-number {
    font-size: var(--font-size-4xl);
    font-weight: 900;
    color: var(--neutral-800);
    margin-bottom: var(--space-1);
}

.stat-label {
    color: var(--neutral-600);
    font-weight: 600;
    margin-bottom: var(--space-3);
}

.stat-progress {
    width: 100%;
    height: 4px;
    background: var(--neutral-200);
    border-radius: var(--radius-full);
    overflow: hidden;
    margin-bottom: var(--space-3);
}

.progress-line {
    height: 100%;
    background: var(--gradient-primary);
    border-radius: var(--radius-full);
    transition: width 1s ease-out;
}

.stat-trend {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    font-size: var(--font-size-sm);
    color: var(--success-600);
}

.action-link {
    color: var(--primary-600);
    text-decoration: none;
    font-weight: 600;
    font-size: var(--font-size-sm);
}

.action-link:hover {
    color: var(--primary-700);
}

.rating-stars-small {
    display: flex;
    gap: 2px;
}

.star-small {
    font-size: var(--font-size-sm);
    color: var(--neutral-300);
}

.star-small.filled {
    color: #fbbf24;
}

.badge {
    display: inline-block;
    padding: var(--space-1) var(--space-2);
    border-radius: var(--radius-md);
    font-size: var(--font-size-xs);
    font-weight: 700;
}

.badge-success {
    background: var(--success-100);
    color: var(--success-700);
}

.badge-warning {
    background: var(--warning-100);
    color: var(--warning-700);
}

.badge-info {
    background: var(--primary-100);
    color: var(--primary-700);
}

.achievements-section {
    margin-bottom: var(--space-12);
}

.achievements-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: var(--space-6);
}

.achievement-card {
    background: white;
    border-radius: var(--radius-xl);
    padding: var(--space-6);
    box-shadow: var(--shadow-lg);
    border: 2px solid var(--neutral-200);
    display: flex;
    align-items: center;
    gap: var(--space-4);
    transition: var(--transition-base);
}

.achievement-card.unlocked {
    border-color: var(--primary-500);
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.05), rgba(236, 72, 153, 0.05));
}

.achievement-card.locked {
    opacity: 0.6;
    filter: grayscale(0.5);
}

.achievement-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-xl);
}

.achievement-icon {
    font-size: 3rem;
    flex-shrink: 0;
}

.achievement-info h4 {
    font-size: var(--font-size-lg);
    font-weight: 700;
    color: var(--neutral-800);
    margin-bottom: var(--space-1);
}

.achievement-info p {
    color: var(--neutral-600);
    margin-bottom: var(--space-3);
}

.achievement-progress {
    display: flex;
    align-items: center;
    gap: var(--space-3);
}

.progress-bar {
    flex: 1;
    height: 6px;
    background: var(--neutral-200);
    border-radius: var(--radius-full);
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: var(--gradient-primary);
    border-radius: var(--radius-full);
    transition: width 1s ease-out;
}

.progress-text {
    font-size: var(--font-size-sm);
    font-weight: 600;
    color: var(--neutral-600);
}

.activity-section {
    margin-bottom: var(--space-12);
}

.activity-filters {
    display: flex;
    gap: var(--space-2);
}

.filter-btn {
    background: none;
    border: 2px solid rgba(255,255,255,0.3);
    color: rgba(255,255,255,0.8);
    padding: var(--space-2) var(--space-4);
    border-radius: var(--radius-lg);
    cursor: pointer;
    transition: var(--transition-base);
    font-weight: 600;
}

.filter-btn.active,
.filter-btn:hover {
    background: rgba(255,255,255,0.2);
    color: white;
    border-color: rgba(255,255,255,0.5);
}

.activity-timeline {
    background: white;
    border-radius: var(--radius-2xl);
    padding: var(--space-6);
    box-shadow: var(--shadow-xl);
}

.activity-item {
    display: flex;
    gap: var(--space-4);
    padding: var(--space-4);
    border-radius: var(--radius-xl);
    transition: var(--transition-base);
    animation: slideInUp 0.6s ease-out;
    animation-fill-mode: both;
}

.activity-item:hover {
    background: var(--neutral-50);
    transform: translateX(4px);
}

.activity-avatar {
    width: 40px;
    height: 40px;
    background: var(--gradient-primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.activity-icon {
    color: white;
    font-size: var(--font-size-lg);
}

.activity-content {
    flex: 1;
    cursor: pointer;
}

.activity-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: var(--space-2);
}

.activity-header h4 {
    font-weight: 700;
    color: var(--neutral-800);
}

.activity-time {
    font-size: var(--font-size-sm);
    color: var(--neutral-500);
}

.activity-details {
    display: flex;
    gap: var(--space-3);
}

.movie-poster-mini {
    width: 40px;
    height: 60px;
    border-radius: var(--radius-md);
    overflow: hidden;
    flex-shrink: 0;
}

.movie-poster-mini img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.activity-info p {
    color: var(--neutral-600);
    font-size: var(--font-size-sm);
    margin-bottom: var(--space-1);
}

.rating-display-mini {
    display: flex;
    align-items: center;
    gap: var(--space-2);
}

.rating-stars-mini {
    display: flex;
    gap: 1px;
}

.star-mini {
    font-size: var(--font-size-xs);
    color: var(--neutral-300);
}

.star-mini.filled {
    color: #fbbf24;
}

.rating-score {
    font-weight: 600;
    color: var(--neutral-700);
    font-size: var(--font-size-sm);
}

.activity-actions {
    display: flex;
    gap: var(--space-2);
    flex-shrink: 0;
}

.action-btn {
    background: none;
    border: 1px solid var(--neutral-300);
    border-radius: var(--radius-md);
    padding: var(--space-2);
    cursor: pointer;
    color: var(--neutral-600);
    transition: var(--transition-base);
}

.action-btn:hover {
    background: var(--neutral-100);
    color: var(--neutral-800);
}

.action-btn.danger:hover {
    background: #fef2f2;
    color: var(--error-600);
    border-color: var(--error-300);
}

.activity-footer {
    text-align: center;
    margin-top: var(--space-6);
}

.quick-actions-enhanced {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: var(--space-4);
}

.quick-action-enhanced {
    display: flex;
    align-items: center;
    gap: var(--space-4);
    padding: var(--space-5);
    background: white;
    border: 2px solid var(--neutral-100);
    border-radius: var(--radius-xl);
    text-decoration: none;
    color: var(--neutral-700);
    transition: var(--transition-base);
    cursor: pointer;
    box-shadow: var(--shadow-md);
}

.quick-action-enhanced:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-xl);
    border-color: var(--primary-200);
}

.action-icon-bg {
    width: 60px;
    height: 60px;
    background: var(--neutral-100);
    border-radius: var(--radius-xl);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: var(--transition-base);
}

.quick-action-enhanced:hover .action-icon-bg {
    background: var(--primary-100);
    transform: scale(1.1);
}

.action-icon {
    font-size: var(--font-size-xl);
}

.action-content h4 {
    font-weight: 700;
    margin-bottom: var(--space-1);
}

.action-content p {
    font-size: var(--font-size-sm);
    color: var(--neutral-600);
}

.action-arrow {
    margin-left: auto;
    font-size: var(--font-size-lg);
    opacity: 0.5;
    transition: var(--transition-base);
}

.quick-action-enhanced:hover .action-arrow {
    opacity: 1;
    transform: translateX(4px);
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@media (max-width: 768px) {
    .profile-content {
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: var(--space-4);
    }

    .profile-avatar-section {
        flex-direction: column;
        align-items: center;
        gap: var(--space-4);
    }

    .profile-actions {
        flex-wrap: wrap;
        justify-content: center;
    }

    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .achievements-grid {
        grid-template-columns: 1fr;
    }

    .activity-details {
        flex-direction: column;
        gap: var(--space-2);
    }

    .quick-actions-enhanced {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }

    .profile-avatar {
        width: 100px;
        height: 100px;
    }

    .avatar-text {
        font-size: 2rem;
    }

    .profile-name {
        font-size: var(--font-size-3xl);
    }

    .activity-item {
        flex-direction: column;
        gap: var(--space-2);
    }

    .activity-actions {
        align-self: flex-start;
    }
}
</style>

<script>
// Enhanced profile functionality
function showChangePasswordModal() {
    document.getElementById('passwordModal').style.display = 'block';
}

function closeChangePasswordModal() {
    document.getElementById('passwordModal').style.display = 'none';
    document.getElementById('changePasswordForm').reset();
    document.getElementById('passwordMessage').innerHTML = '';
}

function toggleActionMenu() {
    const dropdown = document.querySelector('.action-dropdown');
    dropdown.classList.toggle('open');
}

// Close dropdown when clicking outside
document.addEventListener('click', (e) => {
    const dropdown = document.querySelector('.action-dropdown');
    if (dropdown && !dropdown.contains(e.target)) {
        dropdown.classList.remove('open');
    }
});

// Initialize scroll animations
function initScrollAnimations() {
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

// Activity filter functionality
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        // Filter logic would go here
        const filter = btn.dataset.filter;
        console.log('Filtering by:', filter);
    });
});

// Enhanced functionality
async function editRating(movieId) {
    // This would open an edit rating modal
    console.log('Edit rating for movie:', movieId);
    movieAppInstance.showToast('Edit rating feature coming soon!', 'info');
}

async function deleteRating(movieId) {
    if (!confirm('Are you sure you want to delete this rating?')) return;

    try {
        const response = await fetch('/api/ratings/delete', {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ movieId })
        });

        const data = await response.json();

        if (data.success) {
            movieAppInstance.showToast('Rating deleted successfully', 'success');
            location.reload();
        } else {
            movieAppInstance.showToast('Error: ' + data.error, 'error');
        }
    } catch (error) {
        movieAppInstance.showToast('Error deleting rating', 'error');
    }
}

function loadRandomMovie() {
    movieAppInstance.showToast('Finding a random movie...', 'info');
    // Use the existing random movie function from main app
    if (window.movieAppInstance && window.movieAppInstance.loadRandomMovie) {
        window.movieAppInstance.loadRandomMovie();
    }
}

function shareProfile() {
    if (navigator.share) {
        navigator.share({
            title: 'Check out my movie profile!',
            text: 'See what movies I\'ve been watching and rating',
            url: window.location.href
        });
    } else {
        // Fallback: copy to clipboard
        navigator.clipboard.writeText(window.location.href);
        movieAppInstance.showToast('Profile link copied to clipboard!', 'success');
    }
}

function exportData() {
    movieAppInstance.showToast('Preparing your data export...', 'info');
    // This would trigger a data export
    setTimeout(() => {
        movieAppInstance.showToast('Export feature coming soon!', 'info');
    }, 1500);
}

function showAccountSettings() {
    movieAppInstance.showToast('Account settings feature coming soon!', 'info');
}

function showDeleteAccount() {
    if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
        const confirmed = confirm('This will permanently delete all your ratings, watchlist, and profile data. Are you absolutely sure?');
        if (confirmed) {
            // This would call the delete account API
            movieAppInstance.showToast('Account deletion feature available in settings', 'info');
        }
    }
}

function showEditProfile() {
    movieAppInstance.showToast('Profile editing feature coming soon!', 'info');
}

// Password change form
document.getElementById('changePasswordForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(e.target);
    const newPassword = formData.get('new_password');
    const confirmPassword = formData.get('confirm_password');
    const messageDiv = document.getElementById('passwordMessage');

    if (newPassword !== confirmPassword) {
        messageDiv.innerHTML = '<div class="message message-error">New passwords do not match</div>';
        return;
    }

    const submitBtn = e.target.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.textContent = 'Updating...';

    try {
        const response = await fetch('/api/auth/change-password', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            messageDiv.innerHTML = '<div class="message message-success">Password updated successfully!</div>';
            setTimeout(() => {
                closeChangePasswordModal();
            }, 2000);
        } else {
            messageDiv.innerHTML = `<div class="message message-error">${data.error}</div>`;
        }
    } catch (error) {
        messageDiv.innerHTML = '<div class="message message-error">Password update failed. Please try again.</div>';
    } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Update Password';
    }
});

// Initialize when page loads
document.addEventListener('DOMContentLoaded', () => {
    initScrollAnimations();

    // Add stagger animation to activity items
    document.querySelectorAll('.activity-item').forEach((item, index) => {
        item.style.animationDelay = `${index * 0.1}s`;
    });
});

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('passwordModal');
    if (event.target === modal) {
        closeChangePasswordModal();
    }
}
</script>