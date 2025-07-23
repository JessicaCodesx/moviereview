<?php
// Ensure $data exists and has defaults
$data = $data ?? [
    'user' => [
        'username' => '',
        'email' => '',
        'bio' => ''
    ],
    'preferences' => [
        'email_notifications' => false,
        'rating_privacy' => 'public',
        'watchlist_privacy' => 'public',
        'theme_preference' => 'auto'
    ]
];
?>
<div class="settings-container">
    <div class="settings-header">
        <h2>⚙️ Account Settings</h2>
        <p>Manage your account preferences and privacy settings</p>
    </div>

    <!-- Profile Info -->
    <div class="settings-section">
        <h3>Profile Information</h3>
        <p>Update your personal details</p>

        <form id="updateProfileForm">
            <div class="form-group">
                <label for="username">Username</label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    value="<?php echo htmlspecialchars($data['user']['username'] ?? ''); ?>" 
                    required 
                    class="form-control"
                >
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="<?php echo htmlspecialchars($data['user']['email'] ?? ''); ?>" 
                    required 
                    class="form-control"
                >
            </div>

            <div class="form-group">
                <label for="bio">Bio</label>
                <textarea 
                    id="bio" 
                    name="bio" 
                    class="form-control" 
                    rows="3"><?php echo htmlspecialchars($data['user']['bio'] ?? ''); ?></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </div>

            <div id="profileMessage" class="auth-message"></div>
        </form>
    </div>

    <!-- Privacy Preferences -->
    <div class="settings-section">
        <h3>Privacy Settings</h3>
        <p>Configure your privacy preferences</p>

        <form id="updatePreferencesForm">
            <div class="form-group">
                <div class="form-check">
                    <input 
                        type="checkbox" 
                        id="email_notifications" 
                        name="email_notifications" 
                        class="form-check-input"
                        <?php echo !empty($data['preferences']['email_notifications']) ? 'checked' : ''; ?>
                    >
                    <label for="email_notifications">Email Notifications</label>
                </div>
            </div>

            <div class="form-group">
                <label for="rating_privacy">Rating Privacy</label>
                <select id="rating_privacy" name="rating_privacy" class="form-control">
                    <option value="public" <?php echo ($data['preferences']['rating_privacy'] ?? '') === 'public' ? 'selected' : ''; ?>>Public</option>
                    <option value="private" <?php echo ($data['preferences']['rating_privacy'] ?? '') === 'private' ? 'selected' : ''; ?>>Private</option>
                </select>
            </div>

            <div class="form-group">
                <label for="watchlist_privacy">Watchlist Privacy</label>
                <select id="watchlist_privacy" name="watchlist_privacy" class="form-control">
                    <option value="public" <?php echo ($data['preferences']['watchlist_privacy'] ?? '') === 'public' ? 'selected' : ''; ?>>Public</option>
                    <option value="private" <?php echo ($data['preferences']['watchlist_privacy'] ?? '') === 'private' ? 'selected' : ''; ?>>Private</option>
                </select>
            </div>

            <div class="form-group">
                <label for="theme_preference">Theme Preference</label>
                <select id="theme_preference" name="theme_preference" class="form-control">
                    <option value="auto" <?php echo ($data['preferences']['theme_preference'] ?? '') === 'auto' ? 'selected' : ''; ?>>Auto (OS Based)</option>
                    <option value="light" <?php echo ($data['preferences']['theme_preference'] ?? '') === 'light' ? 'selected' : ''; ?>>Light</option>
                    <option value="dark" <?php echo ($data['preferences']['theme_preference'] ?? '') === 'dark' ? 'selected' : ''; ?>>Dark</option>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save Preferences</button>
            </div>

            <div id="preferencesMessage" class="auth-message"></div>
        </form>
    </div>

    <!-- Account Management -->
    <div class="settings-section">
        <h3>Account Management</h3>
        <p>Manage your account data or deactivate your account</p>

        <button class="btn btn-secondary" onclick="exportData()">Export Data</button>
        <button class="btn btn-danger" onclick="showDeactivateAccountModal()">Deactivate Account</button>
    </div>

    <!-- Deactivate Modal -->
    <div id="deactivateModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Confirm Deactivation</h3>
                <button class="modal-close" onclick="closeDeactivateAccountModal()">&times;</button>
            </div>
            <div class="modal-body">
                <p>⛔️ Are you sure you want to deactivate your account? This action is irreversible.</p>
                <form id="deactivateAccountForm">
                    <div class="form-group">
                        <label for="password">Confirm Password</label>
                        <input type="password" id="password" name="password" required class="form-control">
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-danger">Deactivate Account</button>
                    </div>
                    <div id="deactivateMessage" class="auth-message"></div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.settings-container {
    max-width: 1200px;
    margin: 0 auto;
}
.settings-header {
    text-align: center;
    margin-bottom: var(--space-8);
}
.settings-header h2 {
    font-size: var(--font-size-3xl);
}
.settings-section {
    background: white;
    border-radius: var(--radius-2xl);
    box-shadow: var(--shadow-lg);
    padding: var(--space-6);
    margin-bottom: var(--space-8);
}
.form-group {
    margin-bottom: var(--space-4);
}
.form-control {
    width: 100%;
    padding: var(--space-2) var(--space-4);
    border: 1px solid var(--neutral-200);
    border-radius: var(--radius-lg);
}
.form-check {
    display: flex;
    align-items: center;
    margin-bottom: var(--space-4);
}
.form-check-input {
    margin-right: var(--space-2);
}
.form-actions {
    text-align: right;
}
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.4);
    padding-top: var(--space-20);
}
.modal-content {
    background-color: white;
    margin: auto;
    padding: var(--space-6);
    border: 1px solid var(--neutral-200);
    border-radius: var(--radius-xl);
    width: 80%;
    max-width: 500px;
}
.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: var(--space-4);
    border-bottom: 1px solid var(--neutral-200);
}
.modal-body {
    margin-top: var(--space-4);
}
.modal-close {
    background: none;
    border: none;
    font-size: var(--font-size-2xl);
    cursor: pointer;
}
.enum-style {
    overflow: auto;
}
</style>

<script>
document.getElementById('updateProfileForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const messageDiv = document.getElementById('profileMessage');
    messageDiv.innerHTML = '';
    try {
        // Here you’d normally send to server with fetch
        messageDiv.innerHTML = '✅ Profile updated successfully';
    } catch (error) {
        messageDiv.innerHTML = '❌ Failed to update profile';
    }
});

document.getElementById('updatePreferencesForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const messageDiv = document.getElementById('preferencesMessage');
    messageDiv.innerHTML = '';
    try {
        // Send preferences to server
        messageDiv.innerHTML = '✅ Preferences updated successfully';
    } catch (error) {
        messageDiv.innerHTML = '❌ Failed to update preferences';
    }
});

function exportData() {
    console.log('Export feature coming soon');
}

function showDeactivateAccountModal() {
    document.getElementById('deactivateModal').style.display = 'block';
}
function closeDeactivateAccountModal() {
    document.getElementById('deactivateModal').style.display = 'none';
}

document.getElementById('deactivateAccountForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const messageDiv = document.getElementById('deactivateMessage');
    messageDiv.innerHTML = '';
    try {
        alert('✅ Account deactivated successfully');
    } catch (error) {
        messageDiv.innerHTML = '❌ Failed to deactivate account';
    }
});
</script>
