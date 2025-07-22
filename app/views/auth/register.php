<?php
// Complete register page for app/views/auth/register.php
?>

<style>
/* Mobile-first responsive design */
:root {
    --primary-color: #6366f1;
    --primary-hover: #4f46e5;
    --success-color: #10b981;
    --error-color: #ef4444;
    --warning-color: #f59e0b;
    --neutral-50: #f9fafb;
    --neutral-100: #f3f4f6;
    --neutral-200: #e5e7eb;
    --neutral-300: #d1d5db;
    --neutral-600: #4b5563;
    --neutral-800: #1f2937;
    --neutral-900: #111827;

    --space-1: 0.25rem;
    --space-2: 0.5rem;
    --space-3: 0.75rem;
    --space-4: 1rem;
    --space-5: 1.25rem;
    --space-6: 1.5rem;
    --space-8: 2rem;
    --space-12: 3rem;
    --space-16: 4rem;

    --text-sm: 0.875rem;
    --text-base: 1rem;
    --text-lg: 1.125rem;
    --text-xl: 1.25rem;
    --text-2xl: 1.5rem;
    --text-3xl: 1.875rem;
    --text-4xl: 2.25rem;

    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
    --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
}

/* Auth Container - Mobile First */
.auth-container {
    min-height: calc(100vh - 120px);
    display: grid;
    grid-template-columns: 1fr;
    gap: var(--space-8);
    align-items: center;
    padding: var(--space-6);
    max-width: 1400px;
    margin: 0 auto;
}

@media (min-width: 1024px) {
    .auth-container {
        grid-template-columns: 1fr 1fr;
        gap: var(--space-16);
        padding: var(--space-8);
    }
}

/* Floating Background Shapes */
.auth-background {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    z-index: -1;
    pointer-events: none;
}

.floating-shapes {
    position: absolute;
    width: 100%;
    height: 100%;
}

.shape {
    position: absolute;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    animation: float 20s infinite linear;
}

.shape:nth-child(1) {
    width: 80px;
    height: 80px;
    top: 20%;
    left: 10%;
    animation-delay: 0s;
}

.shape:nth-child(2) {
    width: 120px;
    height: 120px;
    top: 60%;
    right: 15%;
    animation-delay: -7s;
}

.shape:nth-child(3) {
    width: 60px;
    height: 60px;
    bottom: 20%;
    left: 20%;
    animation-delay: -14s;
}

@keyframes float {
    0% { transform: translateY(0px) rotate(0deg); opacity: 0.7; }
    33% { transform: translateY(-30px) rotate(120deg); opacity: 0.4; }
    66% { transform: translateY(30px) rotate(240deg); opacity: 0.7; }
    100% { transform: translateY(0px) rotate(360deg); opacity: 0.7; }
}

/* Welcome Section */
.welcome-section {
    text-align: left;
    color: white;
    order: 2;
}

@media (min-width: 1024px) {
    .welcome-section {
        order: 1;
    }
}

@media (max-width: 768px) {
    .welcome-section {
        text-align: center;
    }
}

.welcome-content h2 {
    font-size: var(--text-4xl);
    font-weight: 800;
    margin-bottom: var(--space-6);
    background: linear-gradient(135deg, #ffffff 0%, #e0e7ff 100%);
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    line-height: 1.2;
}

@media (max-width: 768px) {
    .welcome-content h2 {
        font-size: var(--text-3xl);
    }
}

@media (max-width: 480px) {
    .welcome-content h2 {
        font-size: var(--text-2xl);
    }
}

.welcome-content p {
    font-size: var(--text-lg);
    line-height: 1.7;
    margin-bottom: var(--space-8);
    color: rgba(255, 255, 255, 0.9);
}

/* Community Stats */
.community-stats {
    display: grid;
    grid-template-columns: 1fr;
    gap: var(--space-4);
    margin-bottom: var(--space-8);
}

@media (min-width: 768px) {
    .community-stats {
        grid-template-columns: repeat(3, 1fr);
    }
}

.stat-item {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    padding: var(--space-5);
    text-align: center;
    transition: all 0.3s ease;
}

.stat-item:hover {
    transform: translateY(-2px);
    background: rgba(255, 255, 255, 0.2);
}

.stat-number {
    font-size: var(--text-2xl);
    font-weight: 800;
    color: white;
    display: block;
}

@media (max-width: 480px) {
    .stat-number {
        font-size: var(--text-xl);
    }
}

.stat-label {
    font-size: var(--text-sm);
    color: rgba(255, 255, 255, 0.8);
    margin-top: var(--space-1);
}

/* Testimonial */
.testimonial {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    padding: var(--space-6);
    margin-top: var(--space-8);
}

.testimonial blockquote {
    font-style: italic;
    font-size: var(--text-lg);
    line-height: 1.6;
    margin-bottom: var(--space-4);
    color: rgba(255, 255, 255, 0.95);
}

.testimonial cite {
    color: rgba(255, 255, 255, 0.7);
    font-size: var(--text-sm);
}

/* Auth Card */
.auth-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(25px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 24px;
    padding: var(--space-8);
    box-shadow: var(--shadow-xl);
    order: 1;
    width: 100%;
    max-width: 480px;
    margin: 0 auto;
}

@media (min-width: 1024px) {
    .auth-card {
        order: 2;
    }
}

@media (max-width: 480px) {
    .auth-card {
        padding: var(--space-6) var(--space-4);
        border-radius: 20px;
    }
}

.animate-in {
    animation: slideInUp 0.6s ease-out;
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

.shake {
    animation: shake 0.6s ease-in-out;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

/* Brand Header */
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
    font-size: var(--text-4xl);
    animation: brandFloat 4s ease-in-out infinite;
}

@keyframes brandFloat {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-3px) rotate(2deg); }
}

.logo-text {
    font-size: var(--text-2xl);
    font-weight: 900;
    color: var(--primary-color);
}

.brand-tagline {
    color: var(--neutral-600);
    font-size: var(--text-sm);
}

/* Auth Header */
.auth-header {
    text-align: center;
    margin-bottom: var(--space-8);
}

.auth-header h2 {
    font-size: var(--text-3xl);
    font-weight: 800;
    color: var(--neutral-900);
    margin-bottom: var(--space-2);
}

.auth-header p {
    color: var(--neutral-600);
    font-size: var(--text-base);
}

/* Form Styles */
.auth-form {
    width: 100%;
}

.form-group {
    margin-bottom: var(--space-6);
}

.form-label {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    font-weight: 600;
    color: var(--neutral-800);
    margin-bottom: var(--space-2);
    font-size: var(--text-sm);
}

.label-icon {
    font-size: var(--text-base);
}

.required {
    color: var(--error-color);
}

.input-wrapper {
    position: relative;
}

.form-control {
    width: 100%;
    padding: var(--space-4);
    border: 2px solid var(--neutral-200);
    border-radius: 12px;
    font-size: var(--text-base);
    transition: all 0.3s ease;
    background: white;
    position: relative;
    z-index: 1;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
}

.form-control.valid {
    border-color: var(--success-color);
}

.form-control.invalid {
    border-color: var(--error-color);
}

.input-border {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    border: 2px solid transparent;
    border-radius: 12px;
    background: linear-gradient(135deg, var(--primary-color), #8b5cf6);
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: 0;
}

.form-control:focus + .input-border {
    opacity: 1;
}

.input-feedback {
    margin-top: var(--space-2);
    font-size: var(--text-sm);
    min-height: 1.25rem;
}

.input-feedback.success {
    color: var(--success-color);
}

.input-feedback.error {
    color: var(--error-color);
}

.form-hint {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    margin-top: var(--space-2);
    font-size: var(--text-sm);
    color: var(--neutral-600);
}

.hint-icon {
    font-size: var(--text-sm);
}

.password-toggle {
    position: absolute;
    right: var(--space-3);
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    padding: var(--space-2);
    border-radius: 6px;
    transition: background-color 0.2s ease;
    z-index: 2;
}

.password-toggle:hover {
    background: var(--neutral-100);
}

/* Checkbox Styles */
.checkbox-wrapper {
    display: flex;
    align-items: flex-start;
    gap: var(--space-3);
    cursor: pointer;
    line-height: 1.5;
}

.checkbox-wrapper input[type="checkbox"] {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

.checkmark {
    position: relative;
    width: 20px;
    height: 20px;
    background: white;
    border: 2px solid var(--neutral-300);
    border-radius: 4px;
    transition: all 0.3s ease;
    flex-shrink: 0;
    margin-top: 2px;
}

.checkbox-wrapper:hover .checkmark {
    border-color: var(--primary-color);
}

.checkbox-wrapper input:checked ~ .checkmark {
    background: var(--primary-color);
    border-color: var(--primary-color);
}

.checkmark:after {
    content: "";
    position: absolute;
    display: none;
    left: 6px;
    top: 2px;
    width: 6px;
    height: 10px;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}

.checkbox-wrapper input:checked ~ .checkmark:after {
    display: block;
}

.checkbox-label {
    font-size: var(--text-sm);
    color: var(--neutral-700);
}

.agreement-checkbox {
    background: var(--neutral-50);
    border: 1px solid var(--neutral-200);
    border-radius: 8px;
    padding: var(--space-4);
}

.terms-link {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
}

.terms-link:hover {
    text-decoration: underline;
}

/* Button Styles */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: var(--space-2);
    padding: var(--space-4) var(--space-6);
    border: none;
    border-radius: 12px;
    font-weight: 700;
    font-size: var(--text-base);
    text-decoration: none;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary-color), #8b5cf6);
    color: white;
    box-shadow: var(--shadow-md);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.btn-primary:active {
    transform: translateY(0);
}

.btn-full {
    width: 100%;
    padding: var(--space-5) var(--space-6);
    font-size: var(--text-lg);
    border-radius: 16px;
}

.btn-register {
    margin-top: var(--space-4);
}

.btn-loader {
    display: none;
}

.btn.loading .btn-text {
    opacity: 0;
}

.btn.loading .btn-loader {
    display: flex;
}

.btn.success {
    background: linear-gradient(135deg, var(--success-color), #059669);
}

.spinner {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Footer */
.auth-footer {
    text-align: center;
    margin-top: var(--space-8);
    padding-top: var(--space-6);
    border-top: 1px solid var(--neutral-200);
}

.auth-footer p {
    color: var(--neutral-600);
    margin-bottom: var(--space-3);
}

.auth-link {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
    padding: var(--space-2) var(--space-4);
    border-radius: 8px;
    transition: all 0.3s ease;
}

.auth-link:hover {
    background: rgba(99, 102, 241, 0.1);
    text-decoration: none;
}

/* Message Styles */
.message {
    padding: var(--space-4);
    border-radius: 12px;
    margin-bottom: var(--space-6);
    font-weight: 600;
    display: none;
}

.message.show {
    display: block;
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.message.success {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success-color);
    border: 1px solid rgba(16, 185, 129, 0.2);
}

.message.error {
    background: rgba(239, 68, 68, 0.1);
    color: var(--error-color);
    border: 1px solid rgba(239, 68, 68, 0.2);
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
    background-color: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(5px);
}

.modal-content {
    background-color: white;
    margin: 10% auto;
    border-radius: 16px;
    width: 90%;
    max-width: 600px;
    box-shadow: var(--shadow-xl);
    max-height: 80vh;
    overflow-y: auto;
}

@media (max-width: 768px) {
    .modal-content {
        margin: 5% auto;
        width: 95%;
    }
}

.modal-header {
    padding: var(--space-6);
    border-bottom: 1px solid var(--neutral-200);
}

.modal-header h3 {
    margin: 0;
    color: var(--neutral-900);
    font-size: var(--text-xl);
}

.modal-body {
    padding: var(--space-6);
    line-height: 1.6;
    color: var(--neutral-700);
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

.btn-secondary {
    background: var(--neutral-100);
    color: var(--neutral-700);
    border: 1px solid var(--neutral-300);
}

.btn-secondary:hover {
    background: var(--neutral-200);
}

/* Confetti Animation */
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

.confetti {
    position: fixed;
    width: 10px;
    height: 10px;
    background: var(--primary-color);
    animation: confetti-fall 3s linear forwards;
    z-index: 10000;
}
</style>

<!-- Floating Background -->
<div class="auth-background">
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
</div>

<div class="auth-container">
    <!-- Welcome Section -->
    <div class="welcome-section">
        <div class="welcome-content">
            <h2>Join the Movie Community</h2>
            <p>Discover your next favorite film, connect with fellow movie enthusiasts, and build your personal movie collection. Track what you've watched, rate your favorites, and get personalized recommendations.</p>

            <div class="community-stats">
                <div class="stat-item">
                    <span class="stat-number">50K+</span>
                    <span class="stat-label">Movies Rated</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">2K+</span>
                    <span class="stat-label">Active Users</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">15K+</span>
                    <span class="stat-label">Reviews Written</span>
                </div>
            </div>

            <div class="testimonial">
                <blockquote>
                    "This platform completely changed how I discover movies. The recommendations are spot-on!"
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

        <!-- Message Container -->
        <div id="authMessage" class="message"></div>

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
                           placeholder="Create a strong password"
                           minlength="8"
                           autocomplete="new-password">
                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                        👁️
                    </button>
                    <div class="input-border"></div>
                    <div class="input-feedback" id="passwordFeedback"></div>
                </div>
                <small class="form-hint">
                    <span class="hint-icon">🛡️</span>
                    At least 8 characters long
                </small>
            </div>

            <div class="form-group">
                <label for="confirm_password" class="form-label">
                    <span class="label-icon">🔒</span>
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
                        👁️
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

        <div class="auth-footer">
            <p>Already have an account?</p>
            <a href="/login" class="auth-link">Sign In</a>
        </div>
    </div>
</div>

<!-- Terms Modal -->
<div id="termsModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Terms of Service</h3>
        </div>
        <div class="modal-body">
            <p>Welcome to Movie Review Hub. By creating an account, you agree to:</p>
            <ul>
                <li><strong>Account Security:</strong> Keep your password secure and don't share your account</li>
                <li><strong>Content Guidelines:</strong> Write honest, respectful reviews and ratings</li>
                <li><strong>Community Standards:</strong> Be respectful to other users and their opinions</li>
                <li><strong>Service Usage:</strong> Use our platform for personal, non-commercial purposes</li>
                <li><strong>Data Accuracy:</strong> Provide accurate information for your profile</li>
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
        </div>
        <div class="modal-body">
            <p>Your privacy is important to us. Here's what you should know:</p>
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
// Password toggle functionality
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const toggle = field.nextElementSibling;

    if (field.type === 'password') {
        field.type = 'text';
        toggle.textContent = '🙈';
    } else {
        field.type = 'password';
        toggle.textContent = '👁️';
    }
}

// Show/hide modals
function showTerms() {
    document.getElementById('termsModal').style.display = 'block';
}

function showPrivacy() {
    document.getElementById('privacyModal').style.display = 'block';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
};

// Message handling
function showMessage(element, message, type) {
    element.textContent = message;
    element.className = `message ${type} show`;
}

function clearMessage(element) {
    element.className = 'message';
}

// Button loading state
function setButtonLoading(button, loading) {
    if (loading) {
        button.classList.add('loading');
        button.disabled = true;
    } else {
        button.classList.remove('loading');
        button.disabled = false;
    }
}

// Field validation feedback
function highlightField(fieldId, isValid) {
    const field = document.getElementById(fieldId);
    const feedback = document.getElementById(fieldId + 'Feedback');

    field.classList.remove('valid', 'invalid');
    field.classList.add(isValid ? 'valid' : 'invalid');
}

// Real-time password confirmation validation
document.getElementById('confirm_password').addEventListener('input', function() {
    const password = document.getElementById('password').value;
    const confirmPassword = this.value;
    const feedback = document.getElementById('confirmFeedback');

    if (confirmPassword === '') {
        feedback.textContent = '';
        this.classList.remove('valid', 'invalid');
        return;
    }

    if (password === confirmPassword) {
        feedback.textContent = '✓ Passwords match';
        feedback.className = 'input-feedback success';
        this.classList.remove('invalid');
        this.classList.add('valid');
    } else {
        feedback.textContent = '✗ Passwords do not match';
        feedback.className = 'input-feedback error';
        this.classList.remove('valid');
        this.classList.add('invalid');
    }
});

// Real-time username validation
document.getElementById('username').addEventListener('input', function() {
    const username = this.value;
    const feedback = document.getElementById('usernameFeedback');
    const pattern = /^[a-zA-Z0-9_]{3,20}$/;

    if (username === '') {
        feedback.textContent = '';
        this.classList.remove('valid', 'invalid');
        return;
    }

    if (pattern.test(username)) {
        feedback.textContent = '✓ Valid username';
        feedback.className = 'input-feedback success';
        this.classList.remove('invalid');
        this.classList.add('valid');
    } else {
        feedback.textContent = '✗ Username must be 3-20 characters, letters, numbers, and underscores only';
        feedback.className = 'input-feedback error';
        this.classList.remove('valid');
        this.classList.add('invalid');
    }
});

// Real-time password strength validation
document.getElementById('password').addEventListener('input', function() {
    const password = this.value;
    const feedback = document.getElementById('passwordFeedback');

    if (password === '') {
        feedback.textContent = '';
        this.classList.remove('valid', 'invalid');
        return;
    }

    if (password.length >= 8) {
        feedback.textContent = '✓ Password meets minimum length';
        feedback.className = 'input-feedback success';
        this.classList.remove('invalid');
        this.classList.add('valid');
    } else {
        feedback.textContent = '✗ Password must be at least 8 characters';
        feedback.className = 'input-feedback error';
        this.classList.remove('valid');
        this.classList.add('invalid');
    }
});

// Confetti animation
function createConfetti() {
    const colors = ['#6366f1', '#8b5cf6', '#ec4899', '#ef4444', '#f59e0b', '#10b981'];

    for (let i = 0; i < 50; i++) {
        setTimeout(() => {
            const confetti = document.createElement('div');
            confetti.className = 'confetti';
            confetti.style.left = Math.random() * 100 + 'vw';
            confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
            confetti.style.animationDelay = Math.random() * 3 + 's';
            confetti.style.animationDuration = (Math.random() * 3 + 2) + 's';
            document.body.appendChild(confetti);

            // Remove confetti after animation
            setTimeout(() => {
                confetti.remove();
            }, 5000);
        }, i * 50);
    }
}

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

            // Redirect to dashboard
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
        console.error('Registration error:', error);
    } finally {
        setButtonLoading(submitBtn, false);
    }
});
</script>