<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elite Cinema - Join the Elite</title>
</head>
<body>

<div class="regal-auth-container">
    <!-- Background Animation -->
    <div class="auth-background">
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

    <!-- Main Content Container -->
    <div class="auth-content">
        <!-- Registration Card -->
        <div class="auth-card regal-card animate-in">
            <!-- Brand Header -->
            <div class="auth-brand">
                <div class="brand-logo">
                    <span class="logo-crown">👑</span>
                    <span class="logo-text">Elite Cinema</span>
                </div>
                <div class="brand-tagline">Join our distinguished community</div>
                <div class="brand-accent"></div>
            </div>

            <div class="auth-header">
                <h2>Become a Connoisseur</h2>
                <p>Begin your exclusive cinematic journey</p>
            </div>

            <!-- Message Container -->
            <div id="authMessage" class="auth-message"></div>

            <form id="registerForm" class="auth-form" action="/api/auth/register" method="POST">
                <div class="form-group">
                    <label for="username" class="form-label">
                        <span class="label-icon">👤</span>
                        Distinguished Username
                    </label>
                    <div class="input-wrapper">
                        <input type="text" 
                               id="username" 
                               name="username" 
                               required 
                               class="form-control regal-input" 
                               placeholder="Choose your distinguished handle"
                               pattern="[a-zA-Z0-9_]{3,20}" 
                               title="Username must be 3-20 characters long and contain only letters, numbers, and underscores"
                               autocomplete="username">
                        <div class="input-enhancement"></div>
                        <div class="input-glow"></div>
                    </div>
                    <div class="input-feedback" id="usernameFeedback"></div>
                    <small class="form-hint">
                        <span class="hint-icon">💡</span>
                        3-20 characters, letters, numbers, and underscores only
                    </small>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">
                        <span class="label-icon">🔐</span>
                        Private Access Key
                    </label>
                    <div class="input-wrapper">
                        <input type="password" 
                               id="password" 
                               name="password" 
                               required 
                               class="form-control regal-input" 
                               placeholder="Create your secure key"
                               minlength="8"
                               autocomplete="new-password">
                        <button type="button" class="password-toggle regal-toggle" onclick="togglePassword('password')">
                            <svg class="eye-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                            <svg class="eye-off-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: none;">
                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                <line x1="1" y1="1" x2="23" y2="23"></line>
                            </svg>
                        </button>
                        <div class="input-enhancement"></div>
                        <div class="input-glow"></div>
                    </div>
                    <div class="input-feedback" id="passwordFeedback"></div>
                    <small class="form-hint">
                        <span class="hint-icon">🛡️</span>
                        At least 8 characters for optimal security
                    </small>
                </div>

                <div class="form-group">
                    <label for="confirm_password" class="form-label">
                        <span class="label-icon">🔐</span>
                        Confirm Access Key
                    </label>
                    <div class="input-wrapper">
                        <input type="password" 
                               id="confirm_password" 
                               name="confirm_password" 
                               required 
                               class="form-control regal-input" 
                               placeholder="Confirm your secure key"
                               autocomplete="new-password">
                        <button type="button" class="password-toggle regal-toggle" onclick="togglePassword('confirm_password')">
                            <svg class="eye-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                            <svg class="eye-off-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: none;">
                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                <line x1="1" y1="1" x2="23" y2="23"></line>
                            </svg>
                        </button>
                        <div class="input-enhancement"></div>
                        <div class="input-glow"></div>
                    </div>
                    <div class="input-feedback" id="confirmFeedback"></div>
                </div>

                <div class="form-options">
                    <label class="checkbox-wrapper regal-checkbox agreement-checkbox">
                        <input type="checkbox" id="terms" name="terms" required>
                        <span class="checkmark"></span>
                        <span class="checkbox-label">
                            I accept the 
                            <a href="#" onclick="showTerms()" class="terms-link regal-link">Elite Code of Conduct</a> 
                            and 
                            <a href="#" onclick="showPrivacy()" class="terms-link regal-link">Privacy Covenant</a>
                        </span>
                    </label>
                </div>

                <div class="form-options">
                    <label class="checkbox-wrapper regal-checkbox">
                        <input type="checkbox" id="newsletter" name="newsletter">
                        <span class="checkmark"></span>
                        <span class="checkbox-label">
                            Receive curated recommendations and elite updates
                        </span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-full regal-btn btn-register">
                    <span class="btn-content">
                        <span class="btn-icon">👑</span>
                        <span class="btn-text">Join the Elite Circle</span>
                    </span>
                    <span class="btn-loader">
                        <svg class="spinner" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 12a9 9 0 11-6.219-8.56"/>
                        </svg>
                    </span>
                    <div class="btn-glow"></div>
                </button>
            </form>

            <div class="auth-footer">
                <p>Already a distinguished member? 
                    <a href="/login" class="auth-link regal-link">
                        <span>Access Elite Portal</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="7" y1="17" x2="17" y2="7"></line>
                            <polyline points="7,7 17,7 17,17"></polyline>
                        </svg>
                    </a>
                </p>
            </div>
        </div>

        <!-- Community Showcase -->
        <div class="features-showcase regal-showcase animate-in">
            <div class="showcase-header">
                <div class="showcase-crown">👑</div>
                <h3>Join Our Elite Community</h3>
                <p>Experience the pinnacle of cinematic excellence</p>
            </div>

            <div class="community-stats">
                <div class="stat-item regal-stat">
                    <span class="stat-number">50,000+</span>
                    <span class="stat-label">Movies Curated</span>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item regal-stat">
                    <span class="stat-number">2,500+</span>
                    <span class="stat-label">Elite Members</span>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item regal-stat">
                    <span class="stat-number">100,000+</span>
                    <span class="stat-label">Expert Reviews</span>
                </div>
            </div>

            <div class="membership-benefits">
                <div class="benefit-item regal-benefit">
                    <div class="benefit-icon-wrapper">
                        <div class="benefit-icon">🎯</div>
                        <div class="icon-glow"></div>
                    </div>
                    <h4>Exclusive Access</h4>
                    <p>First access to rare films and exclusive premieres from our curated collection</p>
                </div>
                <div class="benefit-item regal-benefit">
                    <div class="benefit-icon-wrapper">
                        <div class="benefit-icon">🎭</div>
                        <div class="icon-glow"></div>
                    </div>
                    <h4>Elite Community</h4>
                    <p>Connect with fellow connoisseurs and film critics in our distinguished society</p>
                </div>
            </div>

            <div class="testimonial-regal">
                <div class="testimonial-crown">👑</div>
                <blockquote>
                    "This platform has completely transformed my approach to cinema. The community here truly understands the art of film."
                </blockquote>
                <cite>— Victoria Sterling, Film Critic & Elite Member</cite>
            </div>
        </div>
    </div>
</div>

<!-- Terms Modal -->
<div id="termsModal" class="modal regal-modal">
    <div class="modal-content regal-modal-content">
        <div class="modal-header">
            <h3>Elite Code of Conduct</h3>
        </div>
        <div class="modal-body">
            <p>By joining our distinguished community, you agree to uphold our standards of excellence:</p>
            <ul>
                <li><strong>Account Integrity:</strong> Maintain the security and dignity of your elite profile</li>
                <li><strong>Scholarly Discourse:</strong> Contribute thoughtful, well-reasoned critiques and reviews</li>
                <li><strong>Respectful Engagement:</strong> Honor diverse perspectives within our refined community</li>
                <li><strong>Exclusive Usage:</strong> Utilize our platform for personal enrichment and cultural appreciation</li>
                <li><strong>Authentic Participation:</strong> Provide genuine insights based on your cinematic experience</li>
            </ul>
            <p>Failure to maintain these standards may result in revocation of membership privileges.</p>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary regal-btn-secondary" onclick="closeModal('termsModal')">Understood</button>
        </div>
    </div>
</div>

<!-- Privacy Modal -->
<div id="privacyModal" class="modal regal-modal">
    <div class="modal-content regal-modal-content">
        <div class="modal-header">
            <h3>Privacy Covenant</h3>
        </div>
        <div class="modal-body">
            <p>Your privacy is paramount to our exclusive service. We safeguard:</p>
            <ul>
                <li><strong>Identity Information:</strong> Your distinguished username and secure credentials</li>
                <li><strong>Preference Data:</strong> Your curated watchlist and refined recommendations</li>
                <li><strong>Engagement Metrics:</strong> Your contributions to our scholarly discourse</li>
                <li><strong>Communication Records:</strong> Your correspondence within our elite circle</li>
            </ul>
            <p>We never commercialize your personal data and use it solely to enhance your distinguished experience.</p>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary regal-btn-secondary" onclick="closeModal('privacyModal')">Acknowledged</button>
        </div>
    </div>
</div>

<style>
/* Color Variables */
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

/* Reset & Base */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
    overflow-x: hidden;
}

/* Main Container */
.regal-auth-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    background: linear-gradient(135deg, var(--regal-secondary) 0%, var(--regal-primary) 50%, var(--regal-secondary) 100%);
    padding: 20px;
}

.auth-content {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 60px;
    width: 100%;
    max-width: 1400px;
}

/* Background Animation */
.auth-background {
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
        radial-gradient(circle at 20% 50%, rgba(218, 165, 32, 0.15), transparent),
        radial-gradient(circle at 80% 20%, rgba(218, 165, 32, 0.1), transparent),
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
    opacity: 0.1;
    animation: regalFloat 25s ease-in-out infinite;
}

.shape-1 { width: 400px; height: 400px; background: linear-gradient(135deg, var(--regal-accent), var(--regal-accent-light)); top: -10%; left: -15%; animation-delay: 0s; }
.shape-2 { width: 300px; height: 300px; background: linear-gradient(135deg, var(--regal-primary), var(--regal-accent)); top: 60%; right: -10%; animation-delay: 8s; }
.shape-3 { width: 200px; height: 200px; background: linear-gradient(135deg, var(--regal-accent-light), var(--regal-accent)); top: 30%; left: 15%; animation-delay: 16s; }
.shape-4 { width: 150px; height: 150px; background: linear-gradient(135deg, var(--regal-accent), var(--regal-primary)); top: 10%; right: 25%; animation-delay: 4s; }
.shape-5 { width: 350px; height: 350px; background: linear-gradient(135deg, var(--regal-accent-light), var(--regal-primary)); bottom: -15%; left: 50%; animation-delay: 12s; }
.shape-6 { width: 250px; height: 250px; background: linear-gradient(135deg, var(--regal-accent), var(--regal-accent-light)); top: 50%; right: 60%; animation-delay: 20s; }

.regal-particles {
    position: absolute;
    width: 100%;
    height: 100%;
    pointer-events: none;
}

.particle {
    position: absolute;
    font-size: 1.8rem;
    opacity: 0.6;
    animation: particleFloat 15s linear infinite;
    filter: drop-shadow(0 2px 4px rgba(218, 165, 32, 0.3));
}

.particle-1 { animation-delay: 0s; }
.particle-2 { animation-delay: 3s; }
.particle-3 { animation-delay: 6s; }
.particle-4 { animation-delay: 9s; }

/* Animations */
@keyframes regalFloat {
    0%, 100% { transform: translateY(0px) translateX(0px) rotate(0deg) scale(1); opacity: 0.1; }
    25% { transform: translateY(-40px) translateX(30px) rotate(90deg) scale(1.1); opacity: 0.15; }
    50% { transform: translateY(-20px) translateX(-20px) rotate(180deg) scale(0.9); opacity: 0.2; }
    75% { transform: translateY(30px) translateX(-40px) rotate(270deg) scale(1.05); opacity: 0.12; }
}

@keyframes particleFloat {
    0% { transform: translateY(100vh) translateX(0px) rotate(0deg); opacity: 0; }
    10% { opacity: 0.6; }
    90% { opacity: 0.6; }
    100% { transform: translateY(-100px) translateX(100px) rotate(360deg); opacity: 0; }
}

@keyframes regalSlideIn {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes regalSlideInRight {
    from { opacity: 0; transform: translateX(30px); }
    to { opacity: 1; transform: translateX(0); }
}

@keyframes crownFloat {
    0%, 100% { transform: translateY(0px) rotate(0deg); filter: drop-shadow(0 4px 12px rgba(218, 165, 32, 0.4)); }
    50% { transform: translateY(-6px) rotate(2deg); filter: drop-shadow(0 8px 20px rgba(218, 165, 32, 0.6)); }
}

@keyframes regalShake {
    0%, 100% { transform: translateX(0) rotateZ(0deg); }
    25% { transform: translateX(-10px) rotateZ(-1deg); }
    75% { transform: translateX(10px) rotateZ(1deg); }
}

.animate-in {
    animation: regalSlideIn 1s cubic-bezier(0.23, 1, 0.32, 1);
}

/* Auth Card */
.regal-card {
    background: var(--regal-glass);
    backdrop-filter: blur(25px) saturate(200%);
    border: 2px solid var(--regal-border);
    border-radius: 25px;
    padding: 50px;
    width: 100%;
    max-width: 520px;
    box-shadow: var(--regal-shadow), inset 0 1px 0 rgba(255, 255, 255, 0.1);
    position: relative;
    overflow: hidden;
}

.regal-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--regal-accent), var(--regal-accent-light), var(--regal-accent));
}

.regal-card::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 2px;
    background: linear-gradient(90deg, transparent, var(--regal-accent), transparent);
    border-radius: 1px;
}

.regal-card.regal-shake {
    animation: regalShake 0.8s ease-in-out;
}

/* Brand Section */
.auth-brand {
    text-align: center;
    margin-bottom: 40px;
    position: relative;
}

.brand-logo {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
    margin-bottom: 12px;
}

.logo-crown {
    font-size: 3rem;
    filter: drop-shadow(0 4px 12px rgba(218, 165, 32, 0.4));
    animation: crownFloat 6s ease-in-out infinite;
}

.logo-text {
    font-size: 2rem;
    font-weight: 800;
    background: linear-gradient(135deg, var(--regal-accent), var(--regal-accent-light));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    letter-spacing: -0.02em;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.brand-tagline {
    color: var(--regal-text-muted);
    font-size: 1rem;
    font-style: italic;
    font-weight: 500;
    margin-bottom: 15px;
}

.brand-accent {
    width: 60px;
    height: 3px;
    background: linear-gradient(90deg, var(--regal-accent), var(--regal-accent-light));
    border-radius: 2px;
    margin: 0 auto;
    box-shadow: 0 2px 8px rgba(218, 165, 32, 0.3);
}

/* Auth Header */
.auth-header {
    text-align: center;
    margin-bottom: 40px;
}

.auth-header h2 {
    color: var(--regal-accent);
    font-size: 2.2rem;
    font-weight: 800;
    margin-bottom: 12px;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    letter-spacing: -0.01em;
}

.auth-header p {
    color: var(--regal-text-muted);
    font-size: 1.1rem;
    font-weight: 500;
}

/* Form Elements */
.form-group {
    margin-bottom: 25px;
}

.form-label {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 12px;
    font-weight: 700;
    color: var(--regal-accent);
    font-size: 0.95rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.label-icon {
    font-size: 1.1rem;
    filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.3));
}

.input-wrapper {
    position: relative;
    margin-bottom: 8px;
}

.regal-input {
    width: 100%;
    padding: 18px 20px;
    border: 2px solid var(--regal-border);
    border-radius: 16px;
    font-size: 1rem;
    background: rgba(255, 255, 255, 0.05);
    color: var(--regal-text);
    backdrop-filter: blur(10px);
    transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    font-weight: 500;
}

.regal-input::placeholder {
    color: var(--regal-text-muted);
    opacity: 0.7;
}

.regal-input:focus {
    outline: none;
    border-color: var(--regal-accent);
    background: rgba(255, 255, 255, 0.1);
    box-shadow: 0 0 0 4px rgba(218, 165, 32, 0.2), 0 8px 25px rgba(218, 165, 32, 0.3);
    transform: translateY(-2px);
}

.regal-input.valid {
    border-color: #10b981;
    box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.2);
}

.regal-input.invalid {
    border-color: #ef4444;
    box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.2);
}

.input-enhancement {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 2px;
    width: 100%;
    background: linear-gradient(90deg, var(--regal-accent), var(--regal-accent-light));
    transform: scaleX(0);
    transition: transform 0.4s cubic-bezier(0.23, 1, 0.32, 1);
    border-radius: 1px;
}

.input-wrapper.focused .input-enhancement {
    transform: scaleX(1);
}

.input-glow {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at center, rgba(218, 165, 32, 0.1), transparent);
    border-radius: 16px;
    opacity: 0;
    transition: opacity 0.3s ease;
    pointer-events: none;
}

.password-toggle {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(218, 165, 32, 0.1);
    border: 1px solid var(--regal-border);
    border-radius: 10px;
    cursor: pointer;
    color: var(--regal-accent);
    transition: all 0.3s ease;
    padding: 8px;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.password-toggle:hover {
    background: rgba(218, 165, 32, 0.2);
    border-color: var(--regal-accent);
    transform: translateY(-50%) scale(1.05);
    box-shadow: 0 4px 12px rgba(218, 165, 32, 0.3);
}

.password-toggle.revealed {
    background: rgba(218, 165, 32, 0.25);
    color: var(--regal-accent-light);
}

.input-feedback {
    margin-top: 8px;
    font-size: 0.85rem;
    min-height: 1.2rem;
    font-weight: 500;
}

.form-hint {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 6px;
    font-size: 0.85rem;
    color: var(--regal-text-muted);
    font-weight: 500;
}

.hint-icon {
    font-size: 0.9rem;
}

/* Form Options */
.form-options {
    margin-bottom: 25px;
}

.regal-checkbox {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    cursor: pointer;
    font-size: 0.95rem;
    color: var(--regal-text-muted);
    font-weight: 500;
    transition: all 0.3s ease;
}

.regal-checkbox:hover {
    color: var(--regal-accent);
}

.regal-checkbox input[type="checkbox"] {
    display: none;
}

.checkmark {
    width: 20px;
    height: 20px;
    border: 2px solid var(--regal-border);
    border-radius: 6px;
    position: relative;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
    flex-shrink: 0;
    margin-top: 2px;
}

.regal-checkbox input:checked + .checkmark {
    background: linear-gradient(135deg, var(--regal-accent), var(--regal-accent-light));
    border-color: var(--regal-accent);
    box-shadow: 0 4px 12px rgba(218, 165, 32, 0.3);
}

.regal-checkbox input:checked + .checkmark::after {
    content: '✓';
    position: absolute;
    top: -1px;
    left: 3px;
    color: var(--regal-primary);
    font-size: 14px;
    font-weight: bold;
}

.agreement-checkbox {
    background: rgba(218, 165, 32, 0.05);
    border: 1px solid var(--regal-border);
    border-radius: 12px;
    padding: 20px;
    backdrop-filter: blur(10px);
    margin-bottom: 20px;
}

.terms-link {
    color: var(--regal-accent);
    text-decoration: none;
    font-weight: 700;
    transition: all 0.3s ease;
}

.terms-link:hover {
    color: var(--regal-accent-light);
    text-decoration: underline;
}

/* Button */
.regal-btn {
    position: relative;
    overflow: hidden;
    margin-bottom: 30px;
    background: linear-gradient(135deg, var(--regal-accent), var(--regal-accent-light));
    border: none;
    border-radius: 16px;
    padding: 18px 32px;
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--regal-primary);
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
    box-shadow: 0 8px 25px rgba(218, 165, 32, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.2);
    width: 100%;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.regal-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.6s ease;
}

.regal-btn:hover::before {
    left: 100%;
}

.regal-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(218, 165, 32, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.3);
    background: linear-gradient(135deg, var(--regal-accent-light), #fff);
}

.regal-btn:active {
    transform: translateY(-1px);
}

.btn-content {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: opacity 0.3s ease;
}

.btn-icon {
    font-size: 1.1rem;
}

.btn-loader {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.btn-glow {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at center, rgba(255, 255, 255, 0.2), transparent);
    border-radius: 16px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.regal-btn.loading .btn-glow {
    opacity: 1;
    animation: pulse 1.5s ease-in-out infinite;
}

.regal-btn.success {
    background: linear-gradient(135deg, #10b981, #34d399);
    transform: scale(1.02);
    box-shadow: 0 15px 35px rgba(16, 185, 129, 0.4);
}

.spinner {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

@keyframes pulse {
    0%, 100% { opacity: 0.5; }
    50% { opacity: 1; }
}

/* Auth Footer */
.auth-footer {
    text-align: center;
    margin-bottom: 20px;
}

.auth-footer p {
    color: var(--regal-text-muted);
    font-size: 0.95rem;
    font-weight: 500;
}

.regal-link {
    color: var(--regal-accent);
    text-decoration: none;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.3s ease;
    padding: 4px 8px;
    border-radius: 8px;
}

.regal-link:hover {
    color: var(--regal-accent-light);
    background: rgba(218, 165, 32, 0.1);
    transform: translateX(3px);
    text-shadow: 0 2px 4px rgba(218, 165, 32, 0.3);
}

/* Community Showcase */
.regal-showcase {
    max-width: 600px;
    animation: regalSlideInRight 1s cubic-bezier(0.23, 1, 0.32, 1);
}

.showcase-header {
    text-align: center;
    margin-bottom: 40px;
}

.showcase-crown {
    font-size: 3rem;
    margin-bottom: 15px;
    filter: drop-shadow(0 4px 12px rgba(218, 165, 32, 0.4));
    animation: crownFloat 6s ease-in-out infinite;
}

.showcase-header h3 {
    color: var(--regal-accent);
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 10px;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.showcase-header p {
    color: var(--regal-text-muted);
    font-size: 1.1rem;
    font-weight: 500;
}

.community-stats {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 25px;
    margin-bottom: 40px;
    flex-wrap: wrap;
}

.regal-stat {
    text-align: center;
    color: var(--regal-text);
    padding: 20px;
    background: var(--regal-glass);
    border-radius: 16px;
    backdrop-filter: blur(20px);
    border: 2px solid var(--regal-border);
    transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    min-width: 120px;
}

.regal-stat:hover {
    transform: translateY(-5px);
    border-color: var(--regal-accent);
    box-shadow: 0 12px 30px rgba(218, 165, 32, 0.3);
}

.stat-number {
    font-size: 1.8rem;
    font-weight: 800;
    color: var(--regal-accent);
    display: block;
    margin-bottom: 5px;
}

.stat-label {
    font-size: 0.9rem;
    color: var(--regal-text-muted);
    font-weight: 600;
}

.stat-divider {
    width: 2px;
    height: 40px;
    background: linear-gradient(180deg, transparent, var(--regal-accent), transparent);
}

.membership-benefits {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 25px;
    margin-bottom: 40px;
}

.regal-benefit {
    text-align: center;
    color: var(--regal-text);
    padding: 25px 20px;
    background: var(--regal-glass);
    border-radius: 20px;
    backdrop-filter: blur(20px);
    border: 2px solid var(--regal-border);
    transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    position: relative;
    overflow: hidden;
}

.regal-benefit::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(218, 165, 32, 0.1), transparent);
    transition: left 0.8s ease;
}

.regal-benefit:hover::before {
    left: 100%;
}

.regal-benefit:hover {
    transform: translateY(-8px);
    border-color: var(--regal-accent);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4), 0 5px 15px rgba(218, 165, 32, 0.3);
}

.benefit-icon-wrapper {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, var(--regal-accent), var(--regal-accent-light));
    border-radius: 12px;
    margin-bottom: 15px;
    box-shadow: 0 4px 15px rgba(218, 165, 32, 0.3);
}

.benefit-icon {
    font-size: 1.5rem;
    color: var(--regal-primary);
}

.icon-glow {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle, rgba(218, 165, 32, 0.3), transparent);
    border-radius: 12px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.regal-benefit:hover .icon-glow {
    opacity: 1;
}

.regal-benefit h4 {
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 10px;
    color: var(--regal-accent);
}

.regal-benefit p {
    font-size: 0.85rem;
    opacity: 0.9;
    line-height: 1.5;
    font-weight: 500;
}

.testimonial-regal {
    background: var(--regal-glass);
    backdrop-filter: blur(25px);
    border: 2px solid var(--regal-border);
    border-radius: 20px;
    padding: 30px;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3), inset 0 1px 0 rgba(255, 255, 255, 0.1);
}

.testimonial-crown {
    font-size: 2rem;
    margin-bottom: 15px;
    filter: drop-shadow(0 2px 8px rgba(218, 165, 32, 0.4));
}

.testimonial-regal blockquote {
    font-style: italic;
    font-size: 1.1rem;
    line-height: 1.6;
    margin-bottom: 20px;
    color: var(--regal-text);
    font-weight: 500;
}

.testimonial-regal cite {
    color: var(--regal-accent);
    font-size: 0.9rem;
    font-weight: 600;
}

/* Modal Styles */
.regal-modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8);
    backdrop-filter: blur(10px);
}

.regal-modal-content {
    background: var(--regal-glass);
    backdrop-filter: blur(25px);
    border: 2px solid var(--regal-border);
    margin: 10% auto;
    border-radius: 20px;
    width: 90%;
    max-width: 600px;
    box-shadow: var(--regal-shadow);
    max-height: 80vh;
    overflow-y: auto;
    color: var(--regal-text);
}

.modal-header {
    padding: 30px;
    border-bottom: 1px solid var(--regal-border);
}

.modal-header h3 {
    margin: 0;
    color: var(--regal-accent);
    font-size: 1.5rem;
    font-weight: 800;
}

.modal-body {
    padding: 30px;
    line-height: 1.6;
    color: var(--regal-text-muted);
}

.modal-body ul {
    margin: 20px 0;
    padding-left: 25px;
}

.modal-body li {
    margin-bottom: 12px;
    font-weight: 500;
}

.modal-body strong {
    color: var(--regal-accent);
}

.modal-footer {
    padding: 30px;
    border-top: 1px solid var(--regal-border);
    text-align: right;
}

.regal-btn-secondary {
    background: rgba(218, 165, 32, 0.1);
    color: var(--regal-accent);
    border: 1px solid var(--regal-border);
    border-radius: 12px;
    padding: 12px 24px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.regal-btn-secondary:hover {
    background: rgba(218, 165, 32, 0.2);
    border-color: var(--regal-accent);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(218, 165, 32, 0.3);
}

/* Messages */
.auth-message {
    margin-bottom: 25px;
}

.message {
    padding: 15px 20px;
    border-radius: 12px;
    margin-bottom: 20px;
    font-weight: 600;
    display: none;
    align-items: center;
    gap: 10px;
    backdrop-filter: blur(20px);
    border: 1px solid transparent;
}

.message.show {
    display: flex;
    animation: messageSlideDown 0.4s ease;
}

@keyframes messageSlideDown {
    from { opacity: 0; transform: translateY(-15px); }
    to { opacity: 1; transform: translateY(0); }
}

.message-success {
    background: rgba(16, 185, 129, 0.15);
    color: #34d399;
    border-color: rgba(16, 185, 129, 0.3);
}

.message-error {
    background: rgba(239, 68, 68, 0.15);
    color: #f87171;
    border-color: rgba(239, 68, 68, 0.3);
}

.message-icon {
    font-size: 1.2rem;
}

/* Crown Celebration Effect */
.crown-celebration {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 10000;
}

.crown-particle {
    position: absolute;
    font-size: 2rem;
    animation: crownCelebrate 3s ease-out forwards;
}

.crown-particle:nth-child(1) { left: 10%; animation-delay: 0s; }
.crown-particle:nth-child(2) { left: 20%; animation-delay: 0.2s; }
.crown-particle:nth-child(3) { left: 30%; animation-delay: 0.4s; }
.crown-particle:nth-child(4) { left: 40%; animation-delay: 0.6s; }
.crown-particle:nth-child(5) { left: 50%; animation-delay: 0.8s; }
.crown-particle:nth-child(6) { left: 60%; animation-delay: 1s; }
.crown-particle:nth-child(7) { left: 70%; animation-delay: 1.2s; }
.crown-particle:nth-child(8) { left: 80%; animation-delay: 1.4s; }

@keyframes crownCelebrate {
    0% { top: -50px; opacity: 1; transform: rotate(0deg); }
    50% { top: 50%; opacity: 1; transform: rotate(180deg); }
    100% { top: 100vh; opacity: 0; transform: rotate(360deg); }
}

/* Responsive Design */
@media (max-width: 1200px) {
    .auth-content {
        flex-direction: column;
        gap: 40px;
    }

    .regal-showcase {
        max-width: 520px;
    }
}

@media (max-width: 768px) {
    .regal-auth-container {
        padding: 20px;
    }

    .regal-card {
        padding: 30px;
        max-width: 100%;
    }

    .logo-text {
        font-size: 1.6rem;
    }

    .auth-header h2 {
        font-size: 1.8rem;
    }

    .community-stats {
        flex-direction: column;
        gap: 20px;
    }

    .stat-divider {
        display: none;
    }

    .membership-benefits {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .regal-modal-content {
        margin: 5% auto;
        width: 95%;
    }
}

@media (max-width: 480px) {
    .regal-card {
        padding: 25px;
        border-radius: 20px;
    }

    .brand-logo {
        flex-direction: column;
        gap: 10px;
    }

    .logo-crown {
        font-size: 2.5rem;
    }

    .logo-text {
        font-size: 1.4rem;
    }

    .form-group {
        margin-bottom: 20px;
    }
}
</style>

<script>
// Registration Form Handler
document.getElementById('registerForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(e.target);
    const password = formData.get('password');
    const confirmPassword = formData.get('confirm_password');
    const messageDiv = document.getElementById('authMessage');
    const submitBtn = e.target.querySelector('button[type="submit"]');

    // Client-side validation
    if (password !== confirmPassword) {
        showMessage(messageDiv, '⚠️ Your access keys do not align. Please verify and try again.', 'error');
        highlightField('confirm_password', false);
        return;
    }

    if (!document.getElementById('terms').checked) {
        showMessage(messageDiv, '📜 Please accept our Elite Code of Conduct to proceed.', 'error');
        return;
    }

    setButtonLoading(submitBtn, true);
    clearMessage(messageDiv);

    try {
        const response = await fetch('/api/auth/register', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            showMessage(messageDiv, '🎉 Welcome to the elite circle! Preparing your royal dashboard...', 'success');
            submitBtn.classList.add('success');
            createCrownCelebration();

            setTimeout(() => {
                window.location.href = '/dashboard';
            }, 2500);
        } else {
            showMessage(messageDiv, data.error, 'error');
            document.querySelector('.auth-card').classList.add('regal-shake');
            setTimeout(() => {
                document.querySelector('.auth-card').classList.remove('regal-shake');
            }, 800);
        }
    } catch (error) {
        showMessage(messageDiv, 'Registration denied. Please verify your connection and credentials.', 'error');
        console.error('Registration error:', error);
    } finally {
        setTimeout(() => setButtonLoading(submitBtn, false), 1000);
    }
});

// Crown Celebration Effect
function createCrownCelebration() {
    const celebration = document.createElement('div');
    celebration.className = 'crown-celebration';
    celebration.innerHTML = `
        <span class="crown-particle">👑</span>
        <span class="crown-particle">⭐</span>
        <span class="crown-particle">🎭</span>
        <span class="crown-particle">👑</span>
        <span class="crown-particle">⭐</span>
        <span class="crown-particle">🎬</span>
        <span class="crown-particle">👑</span>
        <span class="crown-particle">🎪</span>
    `;

    document.body.appendChild(celebration);
    setTimeout(() => celebration.remove(), 3000);
}

// Password Toggle
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const button = input.parentElement.querySelector('.password-toggle');
    const eyeIcon = button.querySelector('.eye-icon');
    const eyeOffIcon = button.querySelector('.eye-off-icon');

    if (input.type === 'password') {
        input.type = 'text';
        eyeIcon.style.display = 'none';
        eyeOffIcon.style.display = 'block';
        button.classList.add('revealed');
    } else {
        input.type = 'password';
        eyeIcon.style.display = 'block';
        eyeOffIcon.style.display = 'none';
        button.classList.remove('revealed');
    }

    addRippleEffect(button);
}

// Ripple Effect
function addRippleEffect(element) {
    const ripple = document.createElement('span');
    const rect = element.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);

    ripple.style.cssText = `
        position: absolute;
        left: 50%;
        top: 50%;
        width: ${size}px;
        height: ${size}px;
        border-radius: 50%;
        background: rgba(218, 165, 32, 0.3);
        transform: translate(-50%, -50%) scale(0);
        animation: ripple 0.6s linear;
        pointer-events: none;
    `;

    element.style.position = 'relative';
    element.style.overflow = 'hidden';
    element.appendChild(ripple);
    setTimeout(() => ripple.remove(), 600);
}

// Button Loading State
function setButtonLoading(button, loading) {
    const content = button.querySelector('.btn-content');
    const loader = button.querySelector('.btn-loader');
    const glow = button.querySelector('.btn-glow');

    if (loading) {
        button.disabled = true;
        button.classList.add('loading');
        content.style.opacity = '0';
        loader.style.opacity = '1';
        glow.style.opacity = '1';
    } else {
        button.disabled = false;
        button.classList.remove('loading');
        content.style.opacity = '1';
        loader.style.opacity = '0';
        glow.style.opacity = '0';
    }
}

// Message Display
function showMessage(element, message, type) {
    const icon = type === 'success' ? '✨' : '⚠️';
    element.innerHTML = `<div class="message message-${type}"><span class="message-icon">${icon}</span>${message}</div>`;
    element.querySelector('.message').classList.add('show');
}

function clearMessage(element) {
    element.innerHTML = '';
}

// Field Validation Feedback
function highlightField(fieldId, isValid) {
    const field = document.getElementById(fieldId);
    field.classList.remove('valid', 'invalid');
    field.classList.add(isValid ? 'valid' : 'invalid');
}

// Real-time Validation
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
        feedback.innerHTML = '<span style="color: var(--regal-accent);">✓ Keys are aligned</span>';
        this.classList.remove('invalid');
        this.classList.add('valid');
    } else {
        feedback.innerHTML = '<span style="color: #ef4444;">✗ Keys do not match</span>';
        this.classList.remove('valid');
        this.classList.add('invalid');
    }
});

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
        feedback.innerHTML = '<span style="color: var(--regal-accent);">✓ Distinguished handle approved</span>';
        this.classList.remove('invalid');
        this.classList.add('valid');
    } else {
        feedback.innerHTML = '<span style="color: #ef4444;">✗ Handle must be 3-20 characters, letters, numbers, and underscores only</span>';
        this.classList.remove('valid');
        this.classList.add('invalid');
    }
});

document.getElementById('password').addEventListener('input', function() {
    const password = this.value;
    const feedback = document.getElementById('passwordFeedback');

    if (password === '') {
        feedback.textContent = '';
        this.classList.remove('valid', 'invalid');
        return;
    }

    if (password.length >= 8) {
        feedback.innerHTML = '<span style="color: var(--regal-accent);">✓ Access key meets security standards</span>';
        this.classList.remove('invalid');
        this.classList.add('valid');
    } else {
        feedback.innerHTML = '<span style="color: #ef4444;">✗ Access key must be at least 8 characters</span>';
        this.classList.remove('valid');
        this.classList.add('invalid');
    }
});

// Modal Functions
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

// Initialize Page
document.addEventListener('DOMContentLoaded', () => {
    // Focus first input
    const firstInput = document.getElementById('username');
    if (firstInput && window.innerWidth > 768) {
        setTimeout(() => {
            firstInput.focus();
            firstInput.parentElement.classList.add('focused');
        }, 800);
    }

    // Staggered animations
    document.querySelectorAll('.animate-in').forEach((el, index) => {
        el.style.animationDelay = `${index * 0.3}s`;
    });

    initializeFloatingParticles();
    setupEnhancedInputs();
});

// Initialize floating particles
function initializeFloatingParticles() {
    const particles = document.querySelectorAll('.particle');
    particles.forEach((particle, index) => {
        particle.style.animationDelay = `${index * 2}s`;
        particle.style.left = `${Math.random() * 100}%`;
        particle.style.top = `${Math.random() * 100}%`;
    });
}

// Enhanced input interactions
function setupEnhancedInputs() {
    document.querySelectorAll('.regal-input').forEach(input => {
        input.addEventListener('focus', () => {
            input.parentElement.classList.add('focused');
            input.parentElement.querySelector('.input-glow').style.opacity = '1';
        });

        input.addEventListener('blur', () => {
            if (!input.value) {
                input.parentElement.classList.remove('focused');
            }
            input.parentElement.querySelector('.input-glow').style.opacity = '0';
        });

        input.addEventListener('input', () => {
            if (input.value) {
                input.parentElement.classList.add('has-value');
            } else {
                input.parentElement.classList.remove('has-value');
            }
        });
    });

    // Ripple effects
    document.querySelectorAll('.regal-btn, .regal-checkbox').forEach(element => {
        element.addEventListener('click', (e) => {
            addRippleEffect(e.currentTarget);
        });
    });
}

// Keyboard shortcuts
document.addEventListener('keydown', (e) => {
    if (e.key === 'Enter' && e.target.tagName === 'INPUT') {
        const form = document.getElementById('registerForm');
        const submitBtn = form.querySelector('button[type="submit"]');
        if (!submitBtn.disabled) {
            form.dispatchEvent(new Event('submit'));
        }
    }

    // Close modals with Escape key
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal').forEach(modal => {
            modal.style.display = 'none';
        });
    }
});

// Add ripple animation to CSS
const style = document.createElement('style');
style.textContent = `
    @keyframes ripple {
        to {
            transform: translate(-50%, -50%) scale(4);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
</script>

</body>
</html>