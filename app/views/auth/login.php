<?php
?>
<div class="auth-container">
    <!-- Background Animation -->
    <div class="auth-background">
        <div class="floating-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
            <div class="shape shape-4"></div>
            <div class="shape shape-5"></div>
        </div>
    </div>

    <div class="auth-card animate-in">
        <!-- Brand Header -->
        <div class="auth-brand">
            <div class="brand-logo">
                <span class="logo-icon">🎬</span>
                <span class="logo-text">Movie Hub</span>
            </div>
            <div class="brand-tagline">Your movie journey continues</div>
        </div>

        <div class="auth-header">
            <h2>Welcome Back!</h2>
            <p>Sign in to continue your movie discovery</p>
        </div>

        <form id="loginForm" class="auth-form">
            <div class="form-group">
                <label for="username" class="form-label">
                    <span class="label-icon">👤</span>
                    Username
                </label>
                <div class="input-wrapper">
                    <input type="text" 
                           id="username" 
                           name="username" 
                           required 
                           class="form-control" 
                           placeholder="Enter your username"
                           autocomplete="username">
                    <div class="input-border"></div>
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">
                    <span class="label-icon">🔒</span>
                    Password
                </label>
                <div class="input-wrapper">
                    <input type="password" 
                           id="password" 
                           name="password" 
                           required 
                           class="form-control" 
                           placeholder="Enter your password"
                           autocomplete="current-password">
                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                        <svg class="eye-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        <svg class="eye-off-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: none;">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                    </button>
                    <div class="input-border"></div>
                </div>
            </div>

            <div class="form-options">
                <label class="checkbox-wrapper">
                    <input type="checkbox" id="remember" name="remember">
                    <span class="checkmark"></span>
                    <span class="checkbox-label">Remember me</span>
                </label>
            </div>

            <button type="submit" class="btn btn-primary btn-full btn-login">
                <span class="btn-text">Sign In</span>
                <span class="btn-loader">
                    <svg class="spinner" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 12a9 9 0 11-6.219-8.56"/>
                    </svg>
                </span>
            </button>
        </form>

        <div class="auth-footer">
            <p>Don't have an account? 
                <a href="/register" class="auth-link">
                    <span>Create one now</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="7" y1="17" x2="17" y2="7"></line>
                        <polyline points="7,7 17,7 17,17"></polyline>
                    </svg>
                </a>
            </p>
        </div>

        <div id="authMessage" class="auth-message"></div>
    </div>

    <!-- Feature Showcase -->
    <div class="features-showcase animate-in">
        <h3>Welcome to Movie Hub</h3>
        <div class="features-grid">
            <div class="feature-item">
                <div class="feature-icon">🔍</div>
                <h4>Discover</h4>
                <p>Search millions of movies and find your next favorite</p>
            </div>
            <div class="feature-item">
                <div class="feature-icon">⭐</div>
                <h4>Rate & Review</h4>
                <p>Share your opinions and help others discover great films</p>
            </div>
            <div class="feature-item">
                <div class="feature-icon">📝</div>
                <h4>Track Progress</h4>
                <p>Build your watchlist and track your movie journey</p>
            </div>
            <div class="feature-item">
                <div class="feature-icon">🤖</div>
                <h4>AI Recommendations</h4>
                <p>Get personalized suggestions based on your taste</p>
            </div>
        </div>
    </div>
</div>

<script>
// Enhanced login functionality
document.getElementById('loginForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(e.target);
    const messageDiv = document.getElementById('authMessage');
    const submitBtn = e.target.querySelector('button[type="submit"]');

    // Show loading state
    setButtonLoading(submitBtn, true);
    clearMessage(messageDiv);

    try {
        const response = await fetch('/api/auth/login', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            showMessage(messageDiv, 'Login successful! Redirecting...', 'success');

            // Add success animation
            submitBtn.classList.add('success');

            // Redirect to dashboard or return URL
            setTimeout(() => {
                window.location.href = '/dashboard';
            }, 1500);
        } else {
            showMessage(messageDiv, data.error, 'error');
            // Shake the form on error
            document.querySelector('.auth-card').classList.add('shake');
            setTimeout(() => {
                document.querySelector('.auth-card').classList.remove('shake');
            }, 600);
        }
    } catch (error) {
        showMessage(messageDiv, 'Login failed. Please check your connection and try again.', 'error');
    } finally {
        setButtonLoading(submitBtn, false);
    }
});

function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const button = input.nextElementSibling;
    const eyeIcon = button.querySelector('.eye-icon');
    const eyeOffIcon = button.querySelector('.eye-off-icon');

    if (input.type === 'password') {
        input.type = 'text';
        eyeIcon.style.display = 'none';
        eyeOffIcon.style.display = 'block';
    } else {
        input.type = 'password';
        eyeIcon.style.display = 'block';
        eyeOffIcon.style.display = 'none';
    }
}

function setButtonLoading(button, loading) {
    const text = button.querySelector('.btn-text');
    const loader = button.querySelector('.btn-loader');

    if (loading) {
        button.disabled = true;
        button.classList.add('loading');
        text.style.opacity = '0';
        loader.style.opacity = '1';
    } else {
        button.disabled = false;
        button.classList.remove('loading');
        text.style.opacity = '1';
        loader.style.opacity = '0';
    }
}

function showMessage(element, message, type) {
    element.innerHTML = `<div class="message message-${type}">${message}</div>`;
    element.querySelector('.message').classList.add('show');
}

function clearMessage(element) {
    element.innerHTML = '';
}

// Auto-focus first input
document.addEventListener('DOMContentLoaded', () => {
    const firstInput = document.getElementById('username');
    if (firstInput && window.innerWidth > 768) {
        setTimeout(() => firstInput.focus(), 500);
    }

    // Add animation delays
    document.querySelectorAll('.animate-in').forEach((el, index) => {
        el.style.animationDelay = `${index * 0.2}s`;
    });
});

// Enhanced input interactions
document.querySelectorAll('.form-control').forEach(input => {
    input.addEventListener('focus', () => {
        input.parentElement.classList.add('focused');
    });

    input.addEventListener('blur', () => {
        if (!input.value) {
            input.parentElement.classList.remove('focused');
        }
    });

    input.addEventListener('input', () => {
        if (input.value) {
            input.parentElement.classList.add('has-value');
        } else {
            input.parentElement.classList.remove('has-value');
        }
    });
});
</script>

<style>
/* Enhanced Authentication Styles */
.auth-container {
    min-height: calc(100vh - 140px);
    display: grid;
    grid-template-columns: 1fr auto;
    align-items: center;
    gap: var(--space-16);
    padding: var(--space-8);
    position: relative;
    overflow: hidden;
}

.auth-background {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: -1;
}

.floating-shapes {
    position: absolute;
    width: 100%;
    height: 100%;
}

.shape {
    position: absolute;
    border-radius: 50%;
    opacity: 0.1;
    animation: floatShape 20s ease-in-out infinite;
}

.shape-1 {
    width: 300px;
    height: 300px;
    background: var(--gradient-primary);
    top: 10%;
    left: -10%;
    animation-delay: 0s;
}

.shape-2 {
    width: 200px;
    height: 200px;
    background: var(--secondary-500);
    top: 70%;
    right: -5%;
    animation-delay: 5s;
}

.shape-3 {
    width: 150px;
    height: 150px;
    background: var(--primary-500);
    top: 50%;
    left: 20%;
    animation-delay: 10s;
}

.shape-4 {
    width: 100px;
    height: 100px;
    background: var(--secondary-500);
    top: 20%;
    right: 30%;
    animation-delay: 15s;
}

.shape-5 {
    width: 250px;
    height: 250px;
    background: var(--gradient-primary);
    bottom: -10%;
    left: 60%;
    animation-delay: 8s;
}

@keyframes floatShape {
    0%, 100% { transform: translateY(0px) translateX(0px) rotate(0deg); }
    33% { transform: translateY(-30px) translateX(20px) rotate(120deg); }
    66% { transform: translateY(20px) translateX(-20px) rotate(240deg); }
}

.auth-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px) saturate(180%);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: var(--radius-2xl);
    padding: var(--space-12);
    width: 100%;
    max-width: 480px;
    box-shadow: var(--shadow-2xl);
    position: relative;
    overflow: hidden;
    animation: slideInRight 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}

.auth-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-primary);
}

.auth-card.shake {
    animation: shake 0.6s ease-in-out;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-10px); }
    75% { transform: translateX(10px); }
}

.auth-brand {
    text-align: center;
    margin-bottom: var(--space-8);
}

.brand-logo {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: var(--space-3);
    margin-bottom: var(--space-2);
}

.logo-icon {
    font-size: 2.5rem;
}

.logo-text {
    font-size: var(--font-size-2xl);
    font-weight: 900;
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.brand-tagline {
    color: var(--neutral-600);
    font-size: var(--font-size-sm);
    font-style: italic;
}

.auth-header {
    text-align: center;
    margin-bottom: var(--space-8);
}

.auth-header h2 {
    color: var(--neutral-800);
    font-size: var(--font-size-3xl);
    margin-bottom: var(--space-2);
    font-weight: 900;
}

.auth-header p {
    color: var(--neutral-600);
    font-size: var(--font-size-base);
}

.form-label {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    margin-bottom: var(--space-2);
    font-weight: 600;
    color: var(--neutral-700);
    font-size: var(--font-size-sm);
}

.label-icon {
    font-size: var(--font-size-base);
}

.input-wrapper {
    position: relative;
    margin-bottom: var(--space-5);
}

.form-control {
    width: 100%;
    padding: var(--space-4) var(--space-4);
    border: 2px solid var(--neutral-200);
    border-radius: var(--radius-lg);
    font-size: var(--font-size-base);
    background: white;
    transition: var(--transition-base);
    box-shadow: var(--shadow-sm);
}

.form-control:focus {
    outline: none;
    border-color: var(--primary-500);
    box-shadow: var(--shadow-lg), 0 0 0 4px rgba(99, 102, 241, 0.1);
}

.input-wrapper.focused .input-border {
    transform: scaleX(1);
}

.input-border {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 2px;
    width: 100%;
    background: var(--gradient-primary);
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.password-toggle {
    position: absolute;
    right: var(--space-3);
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    color: var(--neutral-500);
    transition: var(--transition-base);
}

.password-toggle:hover {
    color: var(--neutral-700);
}

.form-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: var(--space-6);
}

.checkbox-wrapper {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    cursor: pointer;
    font-size: var(--font-size-sm);
}

.checkbox-wrapper input[type="checkbox"] {
    display: none;
}

.checkmark {
    width: 18px;
    height: 18px;
    border: 2px solid var(--neutral-300);
    border-radius: var(--radius-sm);
    position: relative;
    transition: var(--transition-base);
}

.checkbox-wrapper input:checked + .checkmark {
    background: var(--gradient-primary);
    border-color: var(--primary-500);
}

.checkbox-wrapper input:checked + .checkmark::after {
    content: '✓';
    position: absolute;
    top: -2px;
    left: 2px;
    color: white;
    font-size: 12px;
    font-weight: bold;
}

.btn-login {
    position: relative;
    overflow: hidden;
    margin-bottom: var(--space-6);
}

.btn-text,
.btn-loader {
    transition: opacity 0.3s ease;
}

.btn-loader {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    opacity: 0;
}

.spinner {
    animation: spin 1s linear infinite;
}

.btn-login.success {
    background: var(--success-500);
    transform: scale(1.02);
}

.auth-footer {
    text-align: center;
    margin-bottom: var(--space-4);
}

.auth-link {
    color: var(--primary-600);
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: var(--space-1);
    transition: var(--transition-base);
}

.auth-link:hover {
    color: var(--primary-700);
    transform: translateX(2px);
}

.features-showcase {
    max-width: 500px;
    animation: slideInLeft 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}

.features-showcase h3 {
    color: white;
    font-size: var(--font-size-2xl);
    font-weight: 800;
    text-align: center;
    margin-bottom: var(--space-8);
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.features-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--space-6);
}

.feature-item {
    text-align: center;
    color: white;
    padding: var(--space-4);
    background: rgba(255, 255, 255, 0.1);
    border-radius: var(--radius-xl);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: var(--transition-base);
}

.feature-item:hover {
    transform: translateY(-4px);
    background: rgba(255, 255, 255, 0.15);
}

.feature-icon {
    font-size: 2.5rem;
    margin-bottom: var(--space-3);
    display: block;
}

.feature-item h4 {
    font-size: var(--font-size-lg);
    font-weight: 700;
    margin-bottom: var(--space-2);
}

.feature-item p {
    font-size: var(--font-size-sm);
    opacity: 0.9;
    line-height: 1.5;
}

.message {
    padding: var(--space-4) var(--space-5);
    border-radius: var(--radius-lg);
    margin-top: var(--space-4);
    font-weight: 500;
    opacity: 0;
    transform: translateY(10px);
    transition: var(--transition-base);
}

.message.show {
    opacity: 1;
    transform: translateY(0);
}

.message-error {
    background: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.2);
    color: var(--error-600);
    border-left: 4px solid var(--error-500);
}

.message-success {
    background: rgba(16, 185, 129, 0.1);
    border: 1px solid rgba(16, 185, 129, 0.2);
    color: var(--success-600);
    border-left: 4px solid var(--success-500);
}

@keyframes slideInRight {
    from {
        transform: translateX(50px);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideInLeft {
    from {
        transform: translateX(-50px);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.animate-in {
    opacity: 0;
    transform: translateY(30px);
    animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
}

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

@media (max-width: 1024px) {
    .auth-container {
        grid-template-columns: 1fr;
        justify-items: center;
        gap: var(--space-8);
        padding: var(--space-4);
    }

    .features-showcase {
        order: -1;
    }

    .features-grid {
        grid-template-columns: repeat(4, 1fr);
        gap: var(--space-4);
    }

    .feature-item {
        padding: var(--space-3);
    }

    .feature-icon {
        font-size: 2rem;
        margin-bottom: var(--space-2);
    }
}

@media (max-width: 768px) {
    .auth-card {
        padding: var(--space-8) var(--space-6);
        margin: var(--space-4);
    }

    .features-grid {
        grid-template-columns: 1fr 1fr;
        gap: var(--space-4);
    }

    .form-options {
        flex-direction: column;
        gap: var(--space-3);
        align-items: flex-start;
    }

    .auth-container {
        min-height: calc(100vh - 100px);
    }
}

@media (max-width: 480px) {
    .auth-container {
        padding: var(--space-2);
        min-height: calc(100vh - 80px);
    }

    .auth-card {
        padding: var(--space-6) var(--space-4);
    }

    .features-showcase h3 {
        font-size: var(--font-size-xl);
    }

    .features-grid {
        grid-template-columns: 1fr;
        gap: var(--space-4);
    }

    .feature-item {
        padding: var(--space-3);
    }
}
</style>