<?php
?>
<div class="profile-container">
    <div class="profile-header">
        <div class="profile-info">
            <div class="profile-avatar">
                <span class="avatar-icon">👤</span>
            </div>
            <div class="profile-details">
                <h2><?php echo htmlspecialchars($data['user']['username']); ?></h2>
                <p>Member since <?php echo date('F Y', strtotime($data['user']['created_at'])); ?></p>
                <?php if ($data['user']['last_login']): ?>
                    <small>Last login: <?php echo date('M j, Y g:i A', strtotime($data['user']['last_login'])); ?></small>
                <?php endif; ?>
            </div>
        </div>

        <div class="profile-actions">
            <button class="btn btn-secondary" onclick="showChangePasswordModal()">
                🔒 Change Password
            </button>
        </div>
    </div>

    <!-- User Statistics -->
    <div class="stats-section">
        <h3>Your Movie Stats</h3>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?php echo $data['stats']['ratings_count'] ?? 0; ?></div>
                <div class="stat-label">Movies Rated</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $data['stats']['watchlist_count'] ?? 0; ?></div>
                <div class="stat-label">In Watchlist</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $data['stats']['watched_count'] ?? 0; ?></div>
                <div class="stat-label">Movies Watched</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo number_format($data['stats']['avg_rating'] ?? 0, 1); ?></div>
                <div class="stat-label">Avg Rating</div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <?php if (!empty($data['recent_ratings'])): ?>
    <div class="activity-section">
        <div class="section-header">
            <h3>Recent Ratings</h3>
            <a href="/api/ratings/user" class="view-all-link" target="_blank">View All</a>
        </div>

        <div class="activity-list">
            <?php foreach ($data['recent_ratings'] as $rating): ?>
                <div class="activity-item" onclick="movieAppInstance.loadMovieDetails('<?php echo $rating['imdb_id']; ?>')">
                    <div class="activity-poster">
                        <img src="<?php echo $rating['poster'] !== 'N/A' ? $rating['poster'] : '/public/assets/images/no-image.png'; ?>" 
                             alt="<?php echo htmlspecialchars($rating['title']); ?>"
                             onerror="this.src='/public/assets/images/no-image.png'">
                    </div>
                    <div class="activity-details">
                        <h4><?php echo htmlspecialchars($rating['title']); ?> (<?php echo $rating['year']; ?>)</h4>
                        <div class="activity-rating">
                            <span class="rating-stars">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <span class="star <?php echo $i <= $rating['rating'] ? 'filled' : ''; ?>">⭐</span>
                                <?php endfor; ?>
                            </span>
                            <span class="rating-text"><?php echo $rating['rating']; ?>/5</span>
                        </div>
                        <small class="activity-date">
                            Rated on <?php echo date('M j, Y', strtotime($rating['created_at'])); ?>
                        </small>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Quick Actions -->
    <div class="actions-section">
        <h3>Quick Actions</h3>
        <div class="action-buttons">
            <a href="/" class="action-btn">
                <span class="action-icon">🔍</span>
                <span class="action-text">Search Movies</span>
            </a>
            <a href="/watchlist" class="action-btn">
                <span class="action-icon">📝</span>
                <span class="action-text">My Watchlist</span>
            </a>
            <a href="/watched" class="action-btn">
                <span class="action-icon">✅</span>
                <span class="action-text">Watched Movies</span>
            </a>
            <a href="/dashboard" class="action-btn">
                <span class="action-icon">📊</span>
                <span class="action-text">Dashboard</span>
            </a>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div id="passwordModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeChangePasswordModal()">&times;</span>
        <h3>Change Password</h3>
        <form id="changePasswordForm">
            <div class="form-group">
                <label for="currentPassword">Current Password</label>
                <input type="password" id="currentPassword" name="current_password" required class="form-control">
            </div>
            <div class="form-group">
                <label for="newPassword">New Password</label>
                <input type="password" id="newPassword" name="new_password" required class="form-control" minlength="6">
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm New Password</label>
                <input type="password" id="confirmPassword" name="confirm_password" required class="form-control">
            </div>
            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="closeChangePasswordModal()">Cancel</button>
                <button type="submit" class="btn btn-primary">Update Password</button>
            </div>
        </form>
        <div id="passwordMessage" class="auth-message"></div>
    </div>
</div>

<style>
.profile-container {
    max-width: 1000px;
    margin: 0 auto;
}

.profile-header {
    background: white;
    border-radius: var(--border-radius);
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: var(--card-shadow);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.profile-info {
    display: flex;
    align-items: center;
    gap: 20px;
}

.profile-avatar {
    width: 80px;
    height: 80px;
    background: var(--primary-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.avatar-icon {
    font-size: 2rem;
    color: white;
}

.profile-details h2 {
    font-size: 2rem;
    color: var(--text-color);
    margin-bottom: 4px;
    font-weight: 700;
}

.profile-details p {
    color: var(--text-light);
    margin-bottom: 4px;
}

.profile-details small {
    color: var(--text-light);
    font-size: 12px;
}

.stats-section, .activity-section, .actions-section {
    background: white;
    border-radius: var(--border-radius);
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: var(--card-shadow);
}

.stats-section h3, .activity-section h3, .actions-section h3 {
    color: var(--text-color);
    margin-bottom: 20px;
    font-weight: 700;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}

.stat-card {
    text-align: center;
    padding: 20px;
    background: var(--light-bg);
    border-radius: var(--border-radius);
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 8px;
}

.stat-label {
    color: var(--text-light);
    font-weight: 500;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.view-all-link {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
}

.activity-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.activity-item {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px;
    background: var(--light-bg);
    border-radius: var(--border-radius);
    cursor: pointer;
    transition: var(--transition);
}

.activity-item:hover {
    transform: translateY(-2px);
    box-shadow: var(--card-shadow);
}

.activity-poster {
    width: 60px;
    height: 90px;
    flex-shrink: 0;
    border-radius: 6px;
    overflow: hidden;
}

.activity-poster img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.activity-details h4 {
    color: var(--text-color);
    margin-bottom: 8px;
    font-weight: 600;
}

.activity-rating {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 4px;
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

.rating-text {
    font-weight: 600;
    color: var(--text-color);
}

.activity-date {
    color: var(--text-light);
    font-size: 12px;
}

.action-buttons {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
}

.action-btn {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 20px;
    background: var(--light-bg);
    border-radius: var(--border-radius);
    text-decoration: none;
    color: var(--text-color);
    transition: var(--transition);
}

.action-btn:hover {
    background: var(--primary-color);
    color: white;
    transform: translateY(-2px);
}

.action-icon {
    font-size: 1.5rem;
}

.action-text {
    font-weight: 600;
}

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
    backdrop-filter: blur(5px);
}

.modal-content {
    background: white;
    margin: 5% auto;
    padding: 30px;
    border-radius: var(--border-radius);
    width: 90%;
    max-width: 500px;
    position: relative;
    box-shadow: var(--card-shadow-hover);
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
    position: absolute;
    top: 15px;
    right: 20px;
}

.close:hover {
    color: var(--text-color);
}

.form-actions {
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    margin-top: 24px;
}

@media (max-width: 768px) {
    .profile-header {
        flex-direction: column;
        gap: 20px;
        text-align: center;
    }

    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .action-buttons {
        grid-template-columns: 1fr;
    }

    .activity-item {
        flex-direction: column;
        text-align: center;
    }
}
</style>

<script>
function showChangePasswordModal() {
    document.getElementById('passwordModal').style.display = 'block';
}

function closeChangePasswordModal() {
    document.getElementById('passwordModal').style.display = 'none';
    document.getElementById('changePasswordForm').reset();
    document.getElementById('passwordMessage').innerHTML = '';
}

document.getElementById('changePasswordForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(e.target);
    const newPassword = formData.get('new_password');
    const confirmPassword = formData.get('confirm_password');
    const messageDiv = document.getElementById('passwordMessage');

    if (newPassword !== confirmPassword) {
        messageDiv.innerHTML = '<div class="error">New passwords do not match</div>';
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
            messageDiv.innerHTML = '<div class="success">Password updated successfully!</div>';
            setTimeout(() => {
                closeChangePasswordModal();
            }, 2000);
        } else {
            messageDiv.innerHTML = `<div class="error">${data.error}</div>`;
        }
    } catch (error) {
        messageDiv.innerHTML = '<div class="error">Password update failed. Please try again.</div>';
    } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Update Password';
    }
});

// Close modal when clicking outside of it
window.onclick = function(event) {
    const modal = document.getElementById('passwordModal');
    if (event.target === modal) {
        closeChangePasswordModal();
    }
}
</script>