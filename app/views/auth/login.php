<?php
?>
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h2>🎬 Welcome Back</h2>
            <p>Sign in to your account to continue</p>
        </div>

        <form id="loginForm" class="auth-form">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required 
                       class="form-control" placeholder="Enter your username">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required 
                       class="form-control" placeholder="Enter your password">
            </div>

            <button type="submit" class="btn btn-primary btn-full">
                Sign In
            </button>
        </form>

        <div class="auth-footer">
            <p>Don't have an account? <a href="/register" class="auth-link">Sign up here</a></p>
        </div>

        <div id="authMessage" class="auth-message"></div>
    </div>
</div>

<script>
document.getElementById('loginForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(e.target);
    const messageDiv = document.getElementById('authMessage');
    const submitBtn = e.target.querySelector('button[type="submit"]');

    submitBtn.disabled = true;
    submitBtn.textContent = 'Signing in...';

    try {
        const response = await fetch('/api/auth/login', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            messageDiv.innerHTML = '<div class="success">Login successful! Redirecting...</div>';
            // Update global auth state and redirect
            window.location.href = '/dashboard';
        } else {
            messageDiv.innerHTML = `<div class="error">${data.error}</div>`;
        }
    } catch (error) {
        messageDiv.innerHTML = '<div class="error">Login failed. Please try again.</div>';
    } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Sign In';
    }
});
</script>