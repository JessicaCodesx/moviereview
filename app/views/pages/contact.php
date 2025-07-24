                   <div class="faq-question" onclick="toggleFAQ(this)">
                        <h4>How do I report a bug or issue?</h4>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>You can report bugs using the contact form above (select "Bug Report" as the subject) or email us directly at bugs@moviehub.com. Please include as much detail as possible.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFAQ(this)">
                        <h4>Can I suggest new features?</h4>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Absolutely! We love hearing from our users. Use the contact form with "Feature Request" as the subject, or reach out on our social media channels.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.contact-container {
    max-width: 1400px;
    margin: 0 auto;
}

.contact-hero {
    text-align: center;
    padding: var(--space-16) var(--space-4);
    margin-bottom: var(--space-12);
}

.hero-content h1 {
    font-size: clamp(2.5rem, 6vw, 4rem);
    font-weight: 900;
    color: white;
    margin-bottom: var(--space-4);
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.hero-subtitle {
    font-size: var(--font-size-xl);
    color: rgba(255,255,255,0.9);
    margin-bottom: var(--space-8);
    max-width: 700px;
    margin-left: auto;
    margin-right: auto;
}

.contact-content {
    display: flex;
    flex-direction: column;
    gap: var(--space-16);
}

.contact-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: var(--space-12);
    align-items: start;
}

.form-card {
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(20px);
    border-radius: var(--radius-2xl);
    padding: var(--space-8);
    box-shadow: var(--shadow-2xl);
    border: 1px solid rgba(255,255,255,0.2);
    position: relative;
    overflow: hidden;
}

.form-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-primary);
}

.form-header {
    margin-bottom: var(--space-8);
    text-align: center;
}

.form-header h2 {
    font-size: var(--font-size-3xl);
    font-weight: 800;
    color: var(--neutral-800);
    margin-bottom: var(--space-3);
}

.form-header p {
    color: var(--neutral-600);
    font-size: var(--font-size-base);
}

.contact-form {
    display: flex;
    flex-direction: column;
    gap: var(--space-6);
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--space-6);
}

.form-group label {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    margin-bottom: var(--space-2);
    font-weight: 600;
    color: var(--neutral-700);
}

.label-icon {
    font-size: var(--font-size-base);
}

.required {
    color: var(--error-500);
}

.form-control {
    width: 100%;
    padding: var(--space-4);
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

.checkbox-wrapper {
    display: flex;
    align-items: flex-start;
    gap: var(--space-3);
    cursor: pointer;
    font-size: var(--font-size-sm);
    line-height: 1.5;
}

.checkbox-wrapper input[type="checkbox"] {
    display: none;
}

.checkmark {
    width: 20px;
    height: 20px;
    border: 2px solid var(--neutral-300);
    border-radius: var(--radius-sm);
    position: relative;
    transition: var(--transition-base);
    flex-shrink: 0;
    margin-top: 2px;
}

.checkbox-wrapper input:checked + .checkmark {
    background: var(--gradient-primary);
    border-color: var(--primary-500);
}

.checkbox-wrapper input:checked + .checkmark::after {
    content: '✓';
    position: absolute;
    top: -3px;
    left: 3px;
    color: white;
    font-size: 14px;
    font-weight: bold;
}

.btn-large {
    padding: var(--space-4) var(--space-8);
    font-size: var(--font-size-lg);
    font-weight: 800;
    position: relative;
}

.btn-loader {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    opacity: 0;
}

.btn.loading .btn-text {
    opacity: 0;
}

.btn.loading .btn-loader {
    opacity: 1;
}

.spinner {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.contact-message {
    margin-top: var(--space-6);
    padding: var(--space-4);
    border-radius: var(--radius-lg);
    font-weight: 500;
    display: none;
}

.contact-message.success {
    background: rgba(16, 185, 129, 0.1);
    border: 1px solid rgba(16, 185, 129, 0.2);
    color: var(--success-600);
    border-left: 4px solid var(--success-500);
}

.contact-message.error {
    background: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.2);
    color: var(--error-600);
    border-left: 4px solid var(--error-500);
}

.info-cards {
    display: flex;
    flex-direction: column;
    gap: var(--space-6);
}

.info-card {
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(20px);
    border-radius: var(--radius-xl);
    padding: var(--space-6);
    box-shadow: var(--shadow-lg);
    border: 1px solid rgba(255,255,255,0.2);
    text-align: center;
    transition: var(--transition-base);
}

.info-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-xl);
}

.info-icon {
    font-size: 2.5rem;
    margin-bottom: var(--space-3);
    display: block;
}

.info-card h3 {
    font-size: var(--font-size-xl);
    font-weight: 700;
    color: var(--neutral-800);
    margin-bottom: var(--space-3);
}

.info-card p {
    color: var(--neutral-600);
    font-size: var(--font-size-sm);
    line-height: 1.6;
}

.social-links {
    display: flex;
    flex-direction: column;
    gap: var(--space-2);
    margin-top: var(--space-3);
}

.social-link {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: var(--space-2);
    padding: var(--space-2) var(--space-3);
    border-radius: var(--radius-lg);
    background: rgba(255,255,255,0.5);
    color: var(--neutral-700);
    text-decoration: none;
    font-weight: 600;
    transition: var(--transition-base);
}

.social-link:hover {
    background: var(--primary-100);
    color: var(--primary-700);
    transform: translateY(-2px);
}

.faq-section {
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(20px);
    border-radius: var(--radius-2xl);
    padding: var(--space-8);
    box-shadow: var(--shadow-2xl);
    border: 1px solid rgba(255,255,255,0.2);
}

.faq-header {
    text-align: center;
    margin-bottom: var(--space-8);
}

.faq-header h2 {
    font-size: var(--font-size-3xl);
    font-weight: 800;
    color: var(--neutral-800);
    margin-bottom: var(--space-3);
}

.faq-header p {
    color: var(--neutral-600);
    font-size: var(--font-size-base);
}

.faq-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: var(--space-4);
}

.faq-item {
    border: 1px solid var(--neutral-200);
    border-radius: var(--radius-lg);
    overflow: hidden;
    background: white;
}

.faq-question {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: var(--space-4) var(--space-5);
    cursor: pointer;
    background: var(--neutral-50);
    transition: var(--transition-base);
}

.faq-question:hover {
    background: var(--neutral-100);
}

.faq-question h4 {
    font-size: var(--font-size-base);
    font-weight: 600;
    color: var(--neutral-800);
    margin: 0;
}

.faq-toggle {
    font-size: 1.5rem;
    color: var(--primary-600);
    font-weight: bold;
    transition: var(--transition-base);
}

.faq-item.active .faq-toggle {
    transform: rotate(45deg);
}

.faq-answer {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
}

.faq-item.active .faq-answer {
    max-height: 200px;
}

.faq-answer p {
    padding: var(--space-4) var(--space-5);
    margin: 0;
    color: var(--neutral-600);
    font-size: var(--font-size-sm);
    line-height: 1.6;
}

@media (max-width: 1024px) {
    .contact-grid {
        grid-template-columns: 1fr;
        gap: var(--space-8);
    }
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
        gap: var(--space-4);
    }

    .faq-grid {
        grid-template-columns: 1fr;
        gap: var(--space-3);
    }

    .contact-form {
        gap: var(--space-4);
    }
}

@media (max-width: 480px) {
    .form-card,
    .faq-section {
        padding: var(--space-6);
    }
}
</style>

<script>
// Contact form functionality
document.getElementById('contactForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(e.target);
    const submitBtn = e.target.querySelector('button[type="submit"]');
    const messageDiv = document.getElementById('contactMessage');

    // Show loading state
    submitBtn.classList.add('loading');
    submitBtn.disabled = true;
    messageDiv.style.display = 'none';

    try {
        // Simulate API call (replace with actual endpoint)
        await new Promise(resolve => setTimeout(resolve, 2000));

        // Show success message
        messageDiv.className = 'contact-message success';
        messageDiv.textContent = 'Thank you! Your message has been sent successfully. We\'ll get back to you soon.';
        messageDiv.style.display = 'block';

        // Reset form
        e.target.reset();

    } catch (error) {
        // Show error message
        messageDiv.className = 'contact-message error';
        messageDiv.textContent = 'Sorry, there was an error sending your message. Please try again or email us directly.';
        messageDiv.style.display = 'block';
    } finally {
        // Reset button state
        submitBtn.classList.remove('loading');
        submitBtn.disabled = false;
    }
});

// FAQ toggle functionality
function toggleFAQ(element) {
    const faqItem = element.parentElement;
    const isActive = faqItem.classList.contains('active');

    // Close all other FAQ items
    document.querySelectorAll('.faq-item').forEach(item => {
        item.classList.remove('active');
    });

    // Toggle current item
    if (!isActive) {
        faqItem.classList.add('active');
    }
}

// Enhanced form validation
document.querySelectorAll('.form-control').forEach(input => {
    input.addEventListener('blur', validateField);
    input.addEventListener('input', clearFieldError);
});

function validateField(e) {
    const field = e.target;
    const value = field.value.trim();

    // Remove existing error styling
    field.classList.remove('error');

    // Basic validation
    if (field.hasAttribute('required') && !value) {
        showFieldError(field, 'This field is required');
        return false;
    }

    if (field.type === 'email' && value && !isValidEmail(value)) {
        showFieldError(field, 'Please enter a valid email address');
        return false;
    }

    return true;
}

function showFieldError(field, message) {
    field.classList.add('error');

    // Remove existing error message
    const existingError = field.parentElement.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }

    // Add error message
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.textContent = message;
    errorDiv.style.cssText = `
        color: var(--error-600);
        font-size: var(--font-size-xs);
        margin-top: var(--space-1);
        font-weight: 500;
    `;

    field.parentElement.appendChild(errorDiv);
}

function clearFieldError(e) {
    const field = e.target;
    field.classList.remove('error');

    const errorDiv = field.parentElement.querySelector('.field-error');
    if (errorDiv) {
        errorDiv.remove();
    }
}

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Add error styling to CSS
const errorStyles = document.createElement('style');
errorStyles.textContent = `
    .form-control.error {
        border-color: var(--error-500) !important;
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1) !important;
    }
`;
document.head.appendChild(errorStyles);
</script>