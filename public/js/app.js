class MovieApp {
    constructor() {
        this.currentMovieId = null;
        this.isLoading = false;
        this.animationObserver = null;
        this.init();
    }

    init() {
        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.initializeApp());
        } else {
            this.initializeApp();
        }
    }

    initializeApp() {
        this.setupEventListeners();
        this.initializeAnimations();
        this.setupScrollAnimations();
        this.preloadImages();

        // Add smooth reveal animation to existing content
        this.animatePageLoad();
    }

    setupEventListeners() {
        // Search functionality
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    this.searchMovies();
                }
            });

            // Add real-time search suggestions (debounced)
            let searchTimeout;
            searchInput.addEventListener('input', (e) => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    if (e.target.value.length >= 3) {
                        this.showSearchSuggestions(e.target.value);
                    }
                }, 300);
            });

            // Auto-focus search on page load (desktop only)
            if (window.innerWidth > 768) {
                setTimeout(() => searchInput.focus(), 500);
            }
        }

        // Add smooth scroll to anchors
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', (e) => {
                e.preventDefault();
                const target = document.querySelector(anchor.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // Add keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.closeModals();
            }
        });

        // Add intersection observer for scroll animations
        this.setupIntersectionObserver();
    }

    initializeAnimations() {
        // Add stagger animation to existing cards
        const cards = document.querySelectorAll('.movie-card, .stat-card');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            card.classList.add('animate-in');
        });

        // Initialize parallax effect for hero section
        this.initializeParallax();
    }

    initializeParallax() {
        const header = document.querySelector('.header');
        if (header) {
            window.addEventListener('scroll', () => {
                const scrolled = window.pageYOffset;
                const rate = scrolled * -0.5;
                header.style.transform = `translate3d(0, ${rate}px, 0)`;
            });
        }
    }

    setupIntersectionObserver() {
        const options = {
            root: null,
            rootMargin: '0px',
            threshold: 0.1
        };

        this.animationObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-visible');
                }
            });
        }, options);
    }

    setupScrollAnimations() {
        // Add scroll reveal animations to sections
        const sections = document.querySelectorAll('.dashboard-section, .search-section, .card');
        sections.forEach(section => {
            section.classList.add('scroll-reveal');
            if (this.animationObserver) {
                this.animationObserver.observe(section);
            }
        });
    }

    animatePageLoad() {
        // Add entrance animations to main elements
        const elements = document.querySelectorAll('.nav-bar, .header, .search-section');
        elements.forEach((el, index) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';

            setTimeout(() => {
                el.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                el.style.opacity = '1';
                el.style.transform = 'translateY(0)';
            }, index * 200);
        });
    }

    preloadImages() {
        // Preload commonly used images
        const imagesToPreload = [
            '/public/assets/images/no-image.png'
        ];

        imagesToPreload.forEach(src => {
            const img = new Image();
            img.src = src;
        });
    }

    async searchMovies() {
        const query = document.getElementById('searchInput').value.trim();
        if (!query || this.isLoading) return;

        this.isLoading = true;
        const resultsDiv = document.getElementById('searchResults');

        // Clear previous results with animation
        this.fadeOutElement(resultsDiv, () => {
            this.showLoadingWithAnimation(resultsDiv, 'Searching movies...');
        });

        try {
            const response = await this.makeRequest('/api/search', {
                method: 'POST',
                body: this.createFormData({ query })
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.error || 'Search failed');
            }

            // Animate in results
            this.fadeOutElement(resultsDiv, () => {
                this.displaySearchResults(data);
                this.fadeInElement(resultsDiv);
            });

        } catch (error) {
            this.fadeOutElement(resultsDiv, () => {
                this.showError(resultsDiv, error.message);
                this.fadeInElement(resultsDiv);
            });
        } finally {
            this.isLoading = false;
        }
    }

    displaySearchResults(data) {
        const resultsDiv = document.getElementById('searchResults');

        if (data.Response === 'False') {
            resultsDiv.innerHTML = `
                <div class="empty-state animate-in">
                    <div class="empty-state-icon">🔍</div>
                    <h3>No movies found</h3>
                    <p>Try a different search term or check your spelling.</p>
                </div>
            `;
            return;
        }

        resultsDiv.innerHTML = data.Search.map((movie, index) => {
            const poster = movie.Poster !== 'N/A' ? movie.Poster : '/public/assets/images/no-image.png';
            return `
                <div class="movie-card animate-in" 
                     style="animation-delay: ${index * 0.1}s"
                     onclick="movieAppInstance.loadMovieDetails('${movie.imdbID}')">
                    <div class="movie-poster">
                        <img src="${poster}" 
                             alt="${this.escapeHtml(movie.Title)}" 
                             onerror="this.src='/public/assets/images/no-image.png'"
                             loading="lazy">
                        <div class="movie-overlay">
                            <div class="overlay-actions">
                                <button class="overlay-btn btn-primary">
                                    View Details
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="movie-card-info">
                        <h3>${this.escapeHtml(movie.Title)}</h3>
                        <p>${movie.Year} • ${movie.Type}</p>
                    </div>
                </div>
            `;
        }).join('');

        // Trigger animations
        setTimeout(() => {
            resultsDiv.querySelectorAll('.animate-in').forEach(el => {
                el.classList.add('animate-visible');
            });
        }, 100);
    }

    async loadMovieDetails(imdbId) {
        const detailsDiv = document.getElementById('movieDetails');

        // Smooth scroll to details section
        detailsDiv.scrollIntoView({ behavior: 'smooth', block: 'start' });

        detailsDiv.style.display = 'block';

        // Animate in loading state
        this.fadeOutElement(detailsDiv, () => {
            this.showLoadingWithAnimation(detailsDiv, 'Loading movie details...');
            this.fadeInElement(detailsDiv);
        });

        try {
            const response = await this.makeRequest('/api/movie', {
                method: 'POST',
                body: this.createFormData({ imdbId })
            });

            const movie = await response.json();

            if (!response.ok) {
                throw new Error(movie.error || 'Failed to load movie');
            }

            this.currentMovieId = movie.id;

            // Animate in movie details
            this.fadeOutElement(detailsDiv, () => {
                this.displayMovieDetails(movie);
                this.fadeInElement(detailsDiv);
            });

        } catch (error) {
            this.fadeOutElement(detailsDiv, () => {
                this.showError(detailsDiv, error.message);
                this.fadeInElement(detailsDiv);
            });
        }
    }

    async displayMovieDetails(movie) {
        const detailsDiv = document.getElementById('movieDetails');
        const poster = movie.poster !== 'N/A' ? movie.poster : '/public/assets/images/no-image.png';

        // Get movie status if user is logged in
        let movieStatus = { in_watchlist: false, is_watched: false };
        if (window.authState && window.authState.isLoggedIn) {
            try {
                const statusResponse = await this.makeRequest('/api/movie/status', {
                    method: 'POST',
                    body: this.createFormData({ movieId: movie.id })
                });
                if (statusResponse.ok) {
                    movieStatus = await statusResponse.json();
                }
            } catch (error) {
                console.warn('Failed to get movie status:', error);
            }
        }

        detailsDiv.innerHTML = `
            <div class="movie-header animate-in">
                <div class="movie-poster">
                    <img src="${poster}" 
                         alt="${this.escapeHtml(movie.title)}"
                         loading="lazy">
                </div>
                <div class="movie-info">
                    <h2>${this.escapeHtml(movie.title)} (${movie.year})</h2>
                    <div class="movie-meta">
                        <span class="meta-item">📽️ ${this.escapeHtml(movie.director)}</span>
                        <span class="meta-item">🎭 ${this.escapeHtml(movie.genre)}</span>
                        <span class="meta-item">⏱️ ${movie.runtime}</span>
                        <span class="meta-item">⭐ IMDb: ${movie.rating}</span>
                    </div>
                    <p class="movie-plot">${this.escapeHtml(movie.plot)}</p>
                    <p><strong>Starring:</strong> ${this.escapeHtml(movie.actors)}</p>

                    ${window.authState && window.authState.isLoggedIn ? `
                        <div class="movie-actions">
                            <button onclick="movieAppInstance.toggleWatchlist(${movie.id}, ${movieStatus.in_watchlist})" 
                                    class="btn ${movieStatus.in_watchlist ? 'btn-secondary' : 'btn-primary'}" 
                                    id="watchlistBtn">
                                ${movieStatus.in_watchlist ? '📝 Remove from Watchlist' : '📝 Add to Watchlist'}
                            </button>
                            <button onclick="movieAppInstance.toggleWatched(${movie.id}, ${movieStatus.is_watched})" 
                                    class="btn ${movieStatus.is_watched ? 'btn-secondary' : 'btn-success'}" 
                                    id="watchedBtn">
                                ${movieStatus.is_watched ? '✅ Mark as Unwatched' : '✅ Mark as Watched'}
                            </button>
                        </div>
                    ` : ''}
                </div>
            </div>

            <div class="rating-section animate-in">
                <h3>Rate this movie</h3>
                <div class="rating-display">
                    <div class="stars">
                        ${[1,2,3,4,5].map(i => 
                            `<span class="star ${i <= (movie.user_rating || 0) ? 'active' : ''}" 
                                   data-rating="${i}" 
                                   onclick="movieAppInstance.rateMovie(${i})">⭐</span>`
                        ).join('')}
                    </div>
                    <div class="rating-info" id="ratingInfo">
                        Average: ${movie.ratings.average}/5 (${movie.ratings.count} rating${movie.ratings.count !== 1 ? 's' : ''})
                        ${movie.user_rating ? `<br><small>Your rating: ${movie.user_rating}/5</small>` : ''}
                    </div>
                </div>
            </div>

            <div class="review-section animate-in">
                <button onclick="movieAppInstance.generateReview(${movie.id})" class="btn btn-primary">
                    📝 Generate AI Review
                </button>
                <div id="reviewContent" class="review-content"></div>
            </div>
        `;

        // Setup star hover effects with enhanced animations
        this.setupEnhancedStarEffects();

        // Trigger entrance animations
        setTimeout(() => {
            detailsDiv.querySelectorAll('.animate-in').forEach((el, index) => {
                el.style.animationDelay = `${index * 0.2}s`;
                el.classList.add('animate-visible');
            });
        }, 100);
    }

    setupEnhancedStarEffects() {
        const stars = document.querySelectorAll('.star');
        stars.forEach((star, index) => {
            star.addEventListener('mouseenter', () => {
                this.animateStarsHover(index + 1);
            });

            star.addEventListener('mouseleave', () => {
                this.resetStarsAnimation();
            });

            star.addEventListener('click', () => {
                this.animateStarClick(star);
            });
        });
    }

    animateStarsHover(rating) {
        const stars = document.querySelectorAll('.star');
        stars.forEach((star, index) => {
            const shouldHighlight = index < rating;
            star.classList.toggle('hover', shouldHighlight);

            if (shouldHighlight) {
                star.style.transform = 'scale(1.2) rotate(5deg)';
                star.style.filter = 'drop-shadow(0 0 10px #fbbf24)';
            } else {
                star.style.transform = '';
                star.style.filter = '';
            }
        });
    }

    resetStarsAnimation() {
        const stars = document.querySelectorAll('.star');
        stars.forEach(star => {
            star.classList.remove('hover');
            if (!star.classList.contains('active')) {
                star.style.transform = '';
                star.style.filter = '';
            }
        });
    }

    animateStarClick(star) {
        // Create a ripple effect
        star.style.transform = 'scale(1.4) rotate(10deg)';
        star.style.transition = 'all 0.2s cubic-bezier(0.68, -0.55, 0.265, 1.55)';

        setTimeout(() => {
            star.style.transform = star.classList.contains('active') ? 'scale(1.1)' : '';
            star.style.transition = 'all 0.3s ease';
        }, 200);
    }

    async toggleWatchlist(movieId, isInWatchlist) {
        if (!window.authState || !window.authState.isLoggedIn) {
            this.showToast('Please login to manage your watchlist', 'warning');
            return;
        }

        const endpoint = isInWatchlist ? '/api/watchlist/remove' : '/api/watchlist/add';
        const btn = document.getElementById('watchlistBtn');

        // Animate button
        this.animateButtonLoading(btn, isInWatchlist ? 'Removing...' : 'Adding...');

        try {
            const response = await this.makeRequest(endpoint, {
                method: 'POST',
                body: this.createFormData({ movieId })
            });

            const data = await response.json();

            if (data.success) {
                // Update button with animation
                this.animateButtonSuccess(btn, () => {
                    btn.textContent = isInWatchlist ? '📝 Add to Watchlist' : '📝 Remove from Watchlist';
                    btn.className = isInWatchlist ? 'btn btn-primary' : 'btn btn-secondary';
                    btn.onclick = () => this.toggleWatchlist(movieId, !isInWatchlist);
                });

                this.showToast(data.message, 'success');
            } else {
                throw new Error(data.error);
            }
        } catch (error) {
            this.animateButtonError(btn);
            this.showToast(error.message, 'error');
        }
    }

    async toggleWatched(movieId, isWatched) {
        if (!window.authState || !window.authState.isLoggedIn) {
            this.showToast('Please login to track watched movies', 'warning');
            return;
        }

        const endpoint = isWatched ? '/api/movie/unwatch' : '/api/movie/watch';
        const btn = document.getElementById('watchedBtn');

        this.animateButtonLoading(btn, isWatched ? 'Unmarking...' : 'Marking...');

        try {
            const response = await this.makeRequest(endpoint, {
                method: 'POST',
                body: this.createFormData({ movieId })
            });

            const data = await response.json();

            if (data.success) {
                this.animateButtonSuccess(btn, () => {
                    btn.textContent = isWatched ? '✅ Mark as Watched' : '✅ Mark as Unwatched';
                    btn.className = isWatched ? 'btn btn-success' : 'btn btn-secondary';
                    btn.onclick = () => this.toggleWatched(movieId, !isWatched);
                });

                this.showToast(data.message, 'success');
            } else {
                throw new Error(data.error);
            }
        } catch (error) {
            this.animateButtonError(btn);
            this.showToast(error.message, 'error');
        }
    }

    async rateMovie(rating) {
        if (!this.currentMovieId) return;

        // Animate the rating action
        const stars = document.querySelectorAll('.star');
        stars.forEach((star, index) => {
            if (index < rating) {
                star.style.animation = 'starGlow 0.6s ease-in-out';
            }
        });

        try {
            const response = await this.makeRequest('/api/rate', {
                method: 'POST',
                body: this.createFormData({
                    movieId: this.currentMovieId,
                    rating: rating
                })
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.error || 'Rating failed');
            }

            if (data.success) {
                // Update rating display with animation
                const ratingInfo = document.getElementById('ratingInfo');
                this.fadeOutElement(ratingInfo, () => {
                    ratingInfo.innerHTML = 
                        `Average: ${data.ratings.average}/5 (${data.ratings.count} rating${data.ratings.count !== 1 ? 's' : ''})`
                        + (data.user_rating ? `<br><small>Your rating: ${data.user_rating}/5</small>` : '');
                    this.fadeInElement(ratingInfo);
                });

                // Highlight selected stars with animation
                stars.forEach((star, index) => {
                    const isActive = index < rating;
                    star.classList.toggle('active', isActive);

                    if (isActive) {
                        star.style.animation = 'starScale 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55)';
                    }
                });

                this.showToast('Rating saved successfully! ⭐', 'success');
            }

        } catch (error) {
            this.showToast(error.message, 'error');
        }
    }

    async generateReview(movieId) {
        if (!movieId) return;

        const reviewDiv = document.getElementById('reviewContent');

        this.fadeOutElement(reviewDiv, () => {
            this.showLoadingWithAnimation(reviewDiv, 'Generating AI review...');
            this.fadeInElement(reviewDiv);
        });

        try {
            const response = await this.makeRequest('/api/review', {
                method: 'POST',
                body: this.createFormData({ movieId })
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.error || 'Review generation failed');
            }

            if (data.review) {
                this.fadeOutElement(reviewDiv, () => {
                    reviewDiv.innerHTML = `
                        <h4 style="margin-bottom: 1rem; color: var(--neutral-700);">AI-Generated Review:</h4>
                        <p style="line-height: 1.8;">${this.escapeHtml(data.review)}</p>
                    `;
                    this.fadeInElement(reviewDiv);
                });
            }

        } catch (error) {
            this.fadeOutElement(reviewDiv, () => {
                this.showError(reviewDiv, error.message);
                this.fadeInElement(reviewDiv);
            });
        }
    }

    // Enhanced utility methods
    fadeInElement(element, callback) {
        element.style.opacity = '0';
        element.style.transform = 'translateY(20px)';
        element.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';

        setTimeout(() => {
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
            if (callback) callback();
        }, 50);
    }

    fadeOutElement(element, callback) {
        element.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
        element.style.opacity = '0';
        element.style.transform = 'translateY(-10px)';

        setTimeout(() => {
            if (callback) callback();
        }, 300);
    }

    animateButtonLoading(button, text) {
        const originalText = button.textContent;
        button.disabled = true;
        button.textContent = text;
        button.style.animation = 'pulse 1.5s infinite';
        button.originalText = originalText;
    }

    animateButtonSuccess(button, callback) {
        button.style.animation = 'none';
        button.style.transform = 'scale(1.05)';
        button.style.transition = 'all 0.2s ease';

        setTimeout(() => {
            button.style.transform = 'scale(1)';
            button.disabled = false;
            if (callback) callback();
        }, 200);
    }

    animateButtonError(button) {
        button.style.animation = 'shake 0.5s ease-in-out';
        button.textContent = button.originalText || button.textContent;
        button.disabled = false;

        setTimeout(() => {
            button.style.animation = 'none';
        }, 500);
    }

    showLoadingWithAnimation(element, message = 'Loading...') {
        element.innerHTML = `
            <div class="loading animate-in">
                <div class="spinner"></div>
                <p style="margin-top: 1rem; color: var(--neutral-600);">${message}</p>
            </div>
        `;
    }

    showSearchSuggestions(query) {
        // This could be enhanced to show real-time search suggestions
        console.log('Search suggestions for:', query);
    }

    closeModals() {
        document.querySelectorAll('.modal').forEach(modal => {
            modal.style.display = 'none';
        });
    }

    async makeRequest(url, options = {}) {
        const response = await fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                ...options.headers
            },
            ...options
        });

        return response;
    }

    createFormData(data) {
        const formData = new FormData();
        for (const key in data) {
            formData.append(key, data[key]);
        }
        return formData;
    }

    showError(element, message) {
        element.innerHTML = `
            <div class="error animate-in">
                <strong>Oops! Something went wrong</strong><br>
                ${this.escapeHtml(message)}
            </div>
        `;
    }

    showSuccess(element, message) {
        element.innerHTML = `
            <div class="success animate-in">
                ${this.escapeHtml(message)}
            </div>
        `;
    }

    showToast(message, type = 'info') {
        // Remove existing toasts
        document.querySelectorAll('.toast').forEach(toast => toast.remove());

        // Create toast element
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.textContent = message;

        // Add styles for animation
        Object.assign(toast.style, {
            position: 'fixed',
            top: '20px',
            right: '20px',
            padding: '16px 20px',
            borderRadius: '12px',
            color: 'white',
            fontWeight: '600',
            zIndex: '10000',
            transform: 'translateX(400px)',
            transition: 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)',
            maxWidth: '350px',
            wordWrap: 'break-word',
            boxShadow: '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
            backdropFilter: 'blur(10px)',
            border: '1px solid rgba(255, 255, 255, 0.2)'
        });

        // Set background color based on type
        const colors = {
            success: 'linear-gradient(135deg, #10b981, #059669)',
            error: 'linear-gradient(135deg, #ef4444, #dc2626)',
            warning: 'linear-gradient(135deg, #f59e0b, #d97706)',
            info: 'linear-gradient(135deg, #6366f1, #4f46e5)'
        };
        toast.style.background = colors[type] || colors.info;

        // Add to DOM
        document.body.appendChild(toast);

        // Animate in
        setTimeout(() => {
            toast.style.transform = 'translateX(0)';
        }, 100);

        // Add click to dismiss
        toast.addEventListener('click', () => {
            toast.style.transform = 'translateX(400px)';
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 400);
        });

        // Remove after delay
        setTimeout(() => {
            if (toast.parentNode) {
                toast.style.transform = 'translateX(400px)';
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }, 400);
            }
        }, 4000);
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
}

// Initialize the app
const movieAppInstance = new MovieApp();

// For backward compatibility, also expose methods globally
window.MovieApp = {
    searchMovies: () => movieAppInstance.searchMovies(),
    loadMovieDetails: (imdbId) => movieAppInstance.loadMovieDetails(imdbId),
    rateMovie: (rating) => movieAppInstance.rateMovie(rating),
    generateReview: (movieId) => movieAppInstance.generateReview(movieId)
};

// Add custom CSS animations
const styleSheet = document.createElement('style');
styleSheet.textContent = `
    @keyframes starGlow {
        0%, 100% { transform: scale(1); filter: drop-shadow(0 0 0 transparent); }
        50% { transform: scale(1.3); filter: drop-shadow(0 0 15px #fbbf24); }
    }

    @keyframes starScale {
        0% { transform: scale(1); }
        50% { transform: scale(1.4) rotate(5deg); }
        100% { transform: scale(1.1); }
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }

    .animate-in {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .animate-visible {
        opacity: 1;
        transform: translateY(0);
    }

    .scroll-reveal {
        opacity: 0;
        transform: translateY(50px);
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .scroll-reveal.animate-visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* Enhanced button hover effects */
    .btn:hover::before {
        animation: shimmer 0.6s ease-out;
    }

    @keyframes shimmer {
        0% { left: -100%; }
        100% { left: 100%; }
    }

    /* Movie card hover enhancement */
    .movie-card:hover {
        animation: cardFloat 0.6s ease-out;
    }

    @keyframes cardFloat {
        0%, 100% { transform: translateY(0) scale(1); }
        50% { transform: translateY(-8px) scale(1.02); }
    }

    /* Loading spinner enhancement */
    .spinner {
        animation: spin 1s linear infinite, pulse 2s ease-in-out infinite alternate;
    }

    /* Star rating glow effect */
    .star.active {
        filter: drop-shadow(0 0 8px #fbbf24);
    }
`;
document.head.appendChild(styleSheet);

// Add smooth page transitions
window.addEventListener('beforeunload', () => {
    document.body.style.opacity = '0';
});

// Performance optimization: lazy load images
if ('IntersectionObserver' in window) {
    const imageObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                imageObserver.unobserve(img);
            }
        });
    });

    document.querySelectorAll('img[data-src]').forEach(img => {
        imageObserver.observe(img);
    });
}

// Add keyboard shortcuts
document.addEventListener('keydown', (e) => {
    // Ctrl/Cmd + K to focus search
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.focus();
            searchInput.select();
        }
    }
});


}