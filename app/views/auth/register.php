<?php
?>
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h2>🎬 Join Movie Hub</h2>
            <p>Create your account to start rating and reviewing movies</p>
        </div>

        <form id="registerForm" class="auth-form">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required 
                       class="form-control" placeholder="Choose a username (3-20 characters)"
                       pattern="[a-zA-Z0-9_]{3,20}" title="Username must be 3-20 characters long and contain only letters, numbers, and underscores">
                <small class="form-hint">Letters, numbers, and underscores only</small>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required 
                       class="form-control" placeholder="Create a secure password"
                       minlength="6">
                <small class="form-hint">At least 6 characters</small>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required 
                       class="form-control" placeholder="Confirm your password">
            </div>

            <button type="submit" class="btn btn-primary btn-full">
                Create Account
            </button>
        </form>

        <div class="auth-footer">
            <p>Already have an account? <a href="/login" class="auth-link">Sign in here</a></p>
        </div>

        <div id="authMessage" class="auth-message"></div>
    </div>
</div>

<script>
document.getElementById('registerForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(e.target);
    const password = formData.get('password');
    const confirmPassword = formData.get('confirm_password');
    const messageDiv = document.getElementById('authMessage');
    const submitBtn = e.target.querySelector('button[type="submit"]');

    // Client-side validation
    if (password !== confirmPassword) {
        messageDiv.innerHTML = '<div class="error">Passwords do not match</div>';
        return;
    }

    submitBtn.disabled = true;
    submitBtn.textContent = 'Creating Account...';

    try {
        const response = await fetch('/api/auth/register', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            messageDiv.innerHTML = '<div class="success">Account created successfully! Redirecting...</div>';
            // Update global auth state and redirect
            window.location.href = '/dashboard';
        } else {
            messageDiv.innerHTML = `<div class="error">${data.error}</div>`;
        }
    } catch (error) {
        messageDiv.innerHTML = '<div class="error">Registration failed. Please try again.</div>';
    } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Create Account';
    }
});

// Real-time password confirmation validation
document.getElementById('confirm_password').addEventListener('input', (e) => {
    const password = document.getElementById('password').value;
    const confirmPassword = e.target.value;

    if (confirmPassword && password !== confirmPassword) {
        e.target.setCustomValidity('Passwords do not match');
    } else {
        e.target.setCustomValidity('');
    }
});
</script>