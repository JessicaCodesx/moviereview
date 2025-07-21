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

    <!-- Welcome Section -->
    <div class="welcome-section animate-in">
        <div class="welcome-content">
            <h2>Join the Movie Community</h2>
            <p>Connect with fellow movie enthusiasts and discover your next favorite film</p>

            <div class="community-stats">
                <div class="stat-item">
                    <div class="stat-number">50K+</div>
                    <div class="stat-label">Active Users</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">2M+</div>
                    <div class="stat-label">Movies Rated</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">100K+</div>
                    <div class="stat-label">Reviews Written</div>
                </div>
            </div>

            <div class="testimonial">
                <blockquote>
                    "This platform changed how I discover movies. The recommendations are spot-on!"
                </blockquote>
                <cite>— Sarah M., Movie Enthusiast</cite>
            </div>
        </div>
    </div>

    <div class="auth-card animate-in">
        <!-- Brand Header -->
        <div class="auth-brand">
            <div class="brand-logo">
                <span class="logo-icon">🎬</span>
                <span class="logo-text">Movie Hub</span>
            </div>
            <div class="brand-tagline">Create your movie profile</div>
        </div>

        <div class="auth-header">
            <h2>Create Account</h2>
            <p>Start your personalized movie journey today</p>
        </div>

        <form id="registerForm" class="auth-form">
            <div class="form-group">
                <label for="username" class="form-label">
                    <span class="label-icon">👤</span>
                    Username
                    <span class="required">*</span>
                </label>
                <div class="input-wrapper">
                    <input type="text" 
                           id="username" 
                           name="username" 
                           required 
                           class="form-control" 
                           placeholder="Choose a unique username"
                           pattern="[a-zA-Z0-9_]{3,20}" 
                           title="Username must be 3-20 characters long and contain only letters, numbers, and underscores"
                           autocomplete="username">
                    <div class="input-border"></div>
                    <div class="input-feedback" id="usernameFeedback"></div>
                </div>
                <small class="form-hint">
                    <span class="hint-icon">💡</span>
                    3-20 characters, letters, numbers, and underscores only
                </small>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">
                    <span class="label-icon">🔒</span>
                    Password
                    <span class="required">*</span>
                </label>
                <div class="input-wrapper">
                    <input type="password" 
                           id="password" 
                           name="password" 
                           required 
                           class="form-control" 
                           placeholder="Create a secure password"
                           minlength="6"
                           autocomplete="new-password">
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
                <div class="password-strength" id="passwordStrength">
                    <div class="strength-bar">
                        <div class="strength-fill"></div>
                    </div>
                    <div class="strength-text">Password strength: <span id="strengthText">Weak</span></div>
                </div>
            </div>

            <div class="form-group">
                <label for="confirm_password" class="form-label">
                    <span class="label-icon">🔐</span>
                    Confirm Password
                    <span class="required">*</span>
                </label>
                <div class="input-wrapper">
                    <input type="password" 
                           id="confirm_password" 
                           name="confirm_password" 
                           required 
                           class="form-control" 
                           placeholder="Confirm your password"
                           autocomplete="new-password">
                    <button type="button" class="password-toggle" onclick="togglePassword('confirm_password')">
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
                    <div class="input-feedback" id="confirmFeedback"></div>
                </div>
            </div>

            <div class="form-group">
                <label class="checkbox-wrapper agreement-checkbox">
                    <input type="checkbox" id="terms" name="terms" required>
                    <span class="checkmark"></span>
                    <span class="checkbox-label">
                        I agree to the 
                        <a href="#" onclick="showTerms()" class="terms-link">Terms of Service</a> 
                        and 
                        <a href="#" onclick="showPrivacy()" class="terms-link">Privacy Policy</a>
                        <span class="required">*</span>
                    </span>
                </label>
            </div>

            <div class="form-group">
                <label class="checkbox-wrapper">
                    <input type="checkbox" id="newsletter" name="newsletter">
                    <span class="checkmark"></span>
                    <span class="checkbox-label">
                        Send me movie recommendations and updates via email
                    </span>
                </label>
            </div>

            <button type="submit" class="btn btn-primary btn-full btn-register">
                <span class="btn-text">Create Account</span>
                <span class="btn-loader">
                    <svg class="spinner" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 12a9 9 0 11-6.219-8.56"/>
                    </svg>
                </span>
            </button>
        </form>

        <div class="auth-divider">
            <span>or continue with</span>
        </div>

        <div class="social-login">
            <button class="social-btn" onclick="showComingSoon('Google')">
                <svg width="20" height="20" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                Google
            </button>
            <button class="social-btn" onclick="showComingSoon('Apple')">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/>
                </svg>
                Apple
            </button>
        </div>

        <div class="auth-footer">
            <p>Already have an account? 
                <a href="/login" class="auth-link">
                    <span>Sign in here</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="7" y1="17" x2="17" y2="7"></line>
                        <polyline points="7,7 17,7 17,17"></polyline>
                    </svg>
                </a>
            </p>
        </div>

        <div id="authMessage" class="auth-message"></div>
    </div>
</div>

<!-- Terms Modal -->
<div id="termsModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Terms of Service</h3>
            <button class="modal-close" onclick="closeModal('termsModal')">&times;</button>
        </div>
        <div class="modal-body">
            <p>By using Movie Hub, you agree to:</p>
            <ul>
                <li>Use the service respectfully and lawfully</li>
                <li>Provide accurate information in your reviews</li>
                <li>Respect other users' opinions and reviews</li>
                <li>Not spam or abuse the rating system</li>
                <li>Keep your account credentials secure</li>
            </ul>
            <p>We reserve the right to suspend accounts that violate these terms.</p>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('termsModal')">Close</button>
        </div>
    </div>
</div>

<!-- Privacy Modal -->
<div id="privacyModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Privacy Policy</h3>
            <button class="modal-close" onclick="closeModal('privacyModal')">&times;</button>
        </div>
        <div class="modal-body">
            <p>Your privacy is important to us. We collect:</p>
            <ul>
                <li><strong>Account Information:</strong> Username and password</li>
                <li><strong>Usage Data:</strong> Movies you rate and review</li>
                <li><strong>Preferences:</strong> Your watchlist and recommendations</li>
            </ul>
            <p>We do not sell your personal information and use it only to improve your experience.</p>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('privacyModal')">Close</button>
        </div>
    </div>
</div>

<script>
// Enhanced registration functionality
document.getElementById('registerForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(e.target);
    const password = formData.get('password');
    const confirmPassword = formData.get('confirm_password');
    const messageDiv = document.getElementById('authMessage');
    const submitBtn = e.target.querySelector('button[type="submit"]');

    // Client-side validation
    if (password !== confirmPassword) {
        showMessage(messageDiv, 'Passwords do not match', 'error');
        highlightField('confirm_password', false);
        return;
    }

    if (!document.getElementById('terms').checked) {
        showMessage(messageDiv, 'Please agree to the Terms of Service and Privacy Policy', 'error');
        return;
    }

    // Show loading state
    setButtonLoading(submitBtn, true);
    clearMessage(messageDiv);

    try {
        const response = await fetch('/api/auth/register', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            showMessage(messageDiv, 'Account created successfully! Redirecting...', 'success');

            // Add success animation
            submitBtn.classList.add('success');

            // Celebrate with confetti effect
            createConfetti();

            // Update global auth state and redirect
            setTimeout(() => {
                window.location.href = '/dashboard';
            }, 2000);
        } else {
            showMessage(messageDiv, data.error, 'error');
            // Shake the form on error
            document.querySelector('.auth-card').classList.add('shake');
            setTimeout(() => {
                document.querySelector('.auth-card').classList.remove('shake');
            }, 600);
        }
    } catch (error) {
        showMessage(messageDiv, 'Registration failed. Please check your connection and try again.', 'error');
    } finally {
        setButtonLoading(submitBtn, false);
    }
});

// Password strength checker
document.getElementById('password').addEventListener('input', (e) => {
    const password = e.target.value;
    const strength = calculatePasswordStrength(password);
    updatePasswordStrength(strength);
});

// Real-time password confirmation validation
document.getElementById('confirm_password').addEventListener('input', (e) => {
    const password = document.getElementById('password').value;
    const confirmPassword = e.target.value;

    if (confirmPassword) {
        const isMatch = password === confirmPassword;
        highlightField('confirm_password', isMatch);
        updateConfirmFeedback(isMatch);
    }
});

// Username availability check (debounced)
let usernameTimeout;
document.getElementById('username').addEventListener('input', (e) => {
    clearTimeout(usernameTimeout);
    const username = e.target.value;

    if (username.length >= 3) {
        usernameTimeout = setTimeout(() => {
            checkUsernameAvailability(username);
        }, 500);
    } else {
        document.getElementById('usernameFeedback').innerHTML = '';
    }
});

function calculatePasswordStrength(password) {
    let score = 0;
    const checks = {
        length: password.length >= 8,
        lowercase: /[a-z]/.test(password),
        uppercase: /[A-Z]/.test(password),
        numbers: /\d/.test(password),
        symbols: /[^A-Za-z0-9]/.test(password)
    };

    score = Object.values(checks).filter(Boolean).length;

    if (password.length >= 12) score += 1;
    if (password.length >= 16) score += 1;

    return Math.min(score, 5);
}

function updatePasswordStrength(score) {
    const strengthBar = document.querySelector('.strength-fill');
    const strengthText = document.getElementById('strengthText');

    const levels = ['Very Weak', 'Weak', 'Fair', 'Good', 'Strong', 'Very Strong'];
    const colors = ['#ef4444', '#f97316', '#eab308', '#22c55e', '#16a34a', '#15803d'];

    const level = Math.min(score, 5);
    const percentage = (level / 5) * 100;

    strengthBar.style.width = `${percentage}%`;
    strengthBar.style.backgroundColor = colors[level];
    strengthText.textContent = levels[level];
    strengthText.style.color = colors[level];
}

function highlightField(fieldId, isValid) {
    const field = document.getElementById(fieldId);
    const wrapper = field.parentElement;

    wrapper.classList.remove('valid', 'invalid');
    wrapper.classList.add(isValid ? 'valid' : 'invalid');
}

function updateConfirmFeedback(isMatch) {
    const feedback = document.getElementById('confirmFeedback');

    if (isMatch) {
        feedback.innerHTML = '<span class="feedback-success">✓ Passwords match</span>';
    } else {
        feedback.innerHTML = '<span class="feedback-error">✗ Passwords do not match</span>';
    }
}

async function checkUsernameAvailability(username) {
    const feedback = document.getElementById('usernameFeedback');

    try {
        // This would be a real API call
        // For now, simulate availability check
        const isAvailable = !['admin', 'user', 'test', 'demo'].includes(username.toLowerCase());

        if (isAvailable) {
            feedback.innerHTML = '<span class="feedback-success">✓ Username available</span>';
            highlightField('username', true);
        } else {
            feedback.innerHTML = '<span class="feedback-error">✗ Username not available</span>';
            highlightField('username', false);
        }
    } catch (error) {
        feedback.innerHTML = '<span class="feedback-error">Unable to check availability</span>';
    }
}

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

function showTerms() {
    document.getElementById('termsModal').style.display = 'block';
}

function showPrivacy() {
    document.getElementById('privacyModal').style.display = 'block';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

function showComingSoon(provider) {
    alert(`${provider} registration coming soon! Please use email/password for now.`);
}

function createConfetti() {
    const colors = ['#6366f1', '#ec4899', '#10b981', '#f59e0b', '#ef4444'];

    for (let i = 0; i < 50; i++) {
        const confetti = document.createElement('div');
        confetti.className = 'confetti';
        confetti.style.left = Math.random() * 100 + '%';
        confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
        confetti.style.animationDelay = Math.random() * 3 + 's';
        document.body.appendChild(confetti);

        setTimeout(() => confetti.remove(), 3000);
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    // Add animation delays
    document.querySelectorAll('.animate-in').forEach((el, index) => {
        el.style.animationDelay = `${index * 0.3}s`;
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
});

// Close modals when clicking outside
window.onclick = function(event) {
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
}
</script>

<style>
/* Enhanced Registration Styles */
.welcome-section {
    max-width: 500px;
    color: white;
    animation: slideInLeft 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}

.welcome-content h2 {
    font-size: var(--font-size-4xl);
    font-weight: 900;
    margin-bottom: var(--space-4);
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.welcome-content p {
    font-size: var(--font-size-lg);
    margin-bottom: var(--space-8);
    opacity: 0.9;
    line-height: 1.6;
}

.community-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: var(--space-4);
    margin-bottom: var(--space-8);
}

.stat-item {
    text-align: center;
    padding: var(--space-4);
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(10px);
    border-radius: var(--radius-xl);
    border: 1px solid rgba(255,255,255,0.2);
}

.stat-number {
    font-size: var(--font-size-2xl);
    font-weight: 900;
    color: white;
    margin-bottom: var(--space-1);
}

.stat-label {
    font-size: var(--font-size-sm);
    opacity: 0.8;
}

.testimonial {
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(10px);
    border-radius: var(--radius-xl);
    padding: var(--space-6);
    border: 1px solid rgba(255,255,255,0.2);
    text-align: center;
}

.testimonial blockquote {
    font-size: var(--font-size-lg);
    font-style: italic;
    margin-bottom: var(--space-3);
    line-height: 1.6;
}

.testimonial cite {
    font-size: var(--font-size-sm);
    opacity: 0.8;
}

.required {
    color: var(--error-500);
    margin-left: var(--space-1);
}

.form-hint {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    font-size: var(--font-size-xs);
    color: var(--neutral-500);
    margin-top: var(--space-1);
}

.hint-icon {
    font-size: var(--font-size-sm);
}

.input-feedback {
    position: absolute;
    bottom: -20px;
    left: 0;
    font-size: var(--font-size-xs);
    font-weight: 600;
}

.feedback-success {
    color: var(--success-600);
}

.feedback-error {
    color: var(--error-600);
}

.input-wrapper.valid .form-control {
    border-color: var(--success-500);
    box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
}

.input-wrapper.invalid .form-control {
    border-color: var(--error-500);
    box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
}

.password-strength {
    margin-top: var(--space-3);
}

.strength-bar {
    width: 100%;
    height: 4px;
    background: var(--neutral-200);
    border-radius: var(--radius-full);
    overflow: hidden;
    margin-bottom: var(--space-2);
}

.strength-fill {
    height: 100%;
    width: 0%;
    background: var(--error-500);
    border-radius: var(--radius-full);
    transition: all 0.3s ease;
}

.strength-text {
    font-size: var(--font-size-xs);
    color: var(--neutral-600);
    font-weight: 600;
}

.agreement-checkbox {
    margin-bottom: var(--space-4);
}

.agreement-checkbox .checkbox-label {
    line-height: 1.5;
}

.terms-link {
    color: var(--primary-600);
    text-decoration: none;
    font-weight: 600;
    transition: var(--transition-base);
}

.terms-link:hover {
    color: var(--primary-700);
    text-decoration: underline;
}

.btn-register.success {
    background: var(--success-500);
    transform: scale(1.02);
}

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 10000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.6);
    backdrop-filter: blur(8px);
    animation: fadeIn 0.3s ease;
}

.modal-content {
    background: white;
    margin: 10% auto;
    border-radius: var(--radius-2xl);
    width: 90%;
    max-width: 500px;
    box-shadow: var(--shadow-2xl);
    animation: slideIn 0.3s ease;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: var(--space-6);
    border-bottom: 1px solid var(--neutral-200);
}

.modal-header h3 {
    color: var(--neutral-800);
    font-weight: 700;
    margin: 0;
}

.modal-close {
    background: none;
    border: none;
    font-size: 2rem;
    cursor: pointer;
    color: var(--neutral-500);
    transition: var(--transition-base);
}

.modal-close:hover {
    color: var(--neutral-800);
}

.modal-body {
    padding: var(--space-6);
    line-height: 1.6;
}

.modal-body ul {
    margin: var(--space-4) 0;
    padding-left: var(--space-5);
}

.modal-body li {
    margin-bottom: var(--space-2);
}

.modal-footer {
    padding: var(--space-6);
    border-top: 1px solid var(--neutral-200);
    text-align: right;
}

/* Confetti Animation */
.confetti {
    position: fixed;
    width: 10px;
    height: 10px;
    top: -10px;
    z-index: 10001;
    animation: confetti-fall 3s linear forwards;
}

@keyframes confetti-fall {
    0% {
        transform: translateY(0) rotate(0deg);
        opacity: 1;
    }
    100% {
        transform: translateY(100vh) rotate(720deg);
        opacity: 0;
    }
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideIn {
    from {
        transform: translateY(-50px) scale(0.9);
        opacity: 0;
    }
    to {
        transform: translateY(0) scale(1);
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

@media (max-width: 1024px) {
    .auth-container {
        grid-template-columns: 1fr;
        gap: var(--space-8);
    }

    .welcome-section {
        order: -1;
        text-align: center;
    }

    .community-stats {
        grid-template-columns: repeat(3, 1fr);
        gap: var(--space-3);
    }
}

@media (max-width: 768px) {
    .welcome-content h2 {
        font-size: var(--font-size-3xl);
    }

    .community-stats {
        grid-template-columns: 1fr;
        gap: var(--space-3);
    }

    .social-login {
        grid-template-columns: 1fr;
    }

    .modal-content {
        margin: 5% auto;
        width: 95%;
    }
}

@media (max-width: 480px) {
    .auth-card {
        padding: var(--space-6) var(--space-4);
    }

    .welcome-content h2 {
        font-size: var(--font-size-2xl);
    }

    .stat-item {
        padding: var(--space-3);
    }

    .stat-number {
        font-size: var(--font-size-xl);
    }
}
</style>