// PERFORMANCE-OPTIMIZED Movie App JavaScript

class PerformanceOptimizedMovieApp {
    constructor() {
        this.isLoading = false;
        this.searchTimeout = null;
        this.intersectionObserver = null;
        this.prefetchedPages = new Set();

        // Bind methods for better performance
        this.handleScroll = this.throttle(this.handleScroll.bind(this), 16); // 60fps
        this.handleResize = this.debounce(this.handleResize.bind(this), 150);

        this.init();
    }

    init() {
        this.setupDOMContentLoaded();
        this.setupOptimizedEventListeners();
        this.setupIntersectionObserver();
        this.setupPrefetching();
        this.addOptimizedStyles();
        this.setupPerformanceMonitoring();
    }

    setupDOMContentLoaded() {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => {
                this.initializeAfterDOM();
            });
        } else {
            this.initializeAfterDOM();
        }
    }

    initializeAfterDOM() {
        this.setupSearchOptimization();
        this.setupAnimationOptimizations();
        this.setupImageLazyLoading();
        this.setupAccessibility();
    }

    // OPTIMIZED: Add performance-friendly dynamic styles
    addOptimizedStyles() {
        const styleSheet = document.createElement('style');
        styleSheet.textContent = `
            /* SIMPLIFIED ANIMATIONS - Much faster */
            @keyframes starGlow {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.1); }
            }

            @keyframes starScale {
                0% { transform: scale(1); }
                100% { transform: scale(1.05); }
            }

            @keyframes pulse {
                0%, 100% { opacity: 1; }
                50% { opacity: 0.8; }
            }

            .animate-in {
                opacity: 0;
                transform: translateY(20px);
                transition: all 0.3s ease;
            }

            .animate-visible {
                opacity: 1;
                transform: translateY(0);
            }

            .scroll-reveal {
                opacity: 0;
                transform: translateY(30px);
                transition: all 0.4s ease;
            }

            .scroll-reveal.animate-visible {
                opacity: 1;
                transform: translateY(0);
            }

            /* SIMPLIFIED button effects */
            .btn:hover::before {
                animation: shimmer 0.4s ease-out;
            }

            @keyframes shimmer {
                0% { left: -100%; }
                100% { left: 100%; }
            }

            /* OPTIMIZED movie card hover */
            .movie-card:hover {
                transform: translate3d(0, -2px, 0);
                transition: transform 0.2s ease;
            }

            /* Loading spinner */
            .loading-spinner {
                animation: spin 1s linear infinite;
            }

            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }

            /* Performance optimizations */
            .hardware-accelerated {
                transform: translate3d(0, 0, 0);
                backface-visibility: hidden;
                perspective: 1000px;
            }
        `;
        document.head.appendChild(styleSheet);
    }

    // OPTIMIZED: Throttled scroll handler
    setupOptimizedEventListeners() {
        // Use passive listeners for better performance
        window.addEventListener('scroll', this.handleScroll, { passive: true });
        window.addEventListener('resize', this.handleResize, { passive: true });

        // Optimize beforeunload
        window.addEventListener('beforeunload', () => {
            this.cleanup();
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                this.focusSearch();
            }
            if (e.key === 'Escape') {
                this.closeModals();
            }
        });
    }

    handleScroll() {
        // Only handle critical scroll animations
        this.updateParallax();
        this.updateScrollIndicators();
    }

    handleResize() {
        // Handle responsive behavior
        this.updateResponsiveElements();
    }

    // OPTIMIZED: Intersection Observer with single instance
    setupIntersectionObserver() {
        const options = {
            root: null,
            rootMargin: '50px',
            threshold: 0.1
        };

        this.intersectionObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-visible');
                    // Stop observing once animated for better performance
                    this.intersectionObserver.unobserve(entry.target);
                }
            });
        }, options);

        // Observe all animation targets
        this.observeAnimationElements();
    }

    observeAnimationElements() {
        const elementsToAnimate = document.querySelectorAll('.animate-in, .scroll-reveal, .movie-card');
        elementsToAnimate.forEach(el => {
            this.intersectionObserver.observe(el);
        });
    }

    // OPTIMIZED: Setup prefetching for faster navigation
    setupPrefetching() {
        const navLinks = document.querySelectorAll('.nav-link, a[href^="/"]');

        navLinks.forEach(link => {
            // Prefetch on hover for faster navigation
            link.addEventListener('mouseenter', (e) => {
                this.prefetchPage(e.target.href);
            }, { passive: true });

            // Add smooth transition for navigation
            link.addEventListener('click', (e) => {
                if (this.shouldInterceptNavigation(e.target.href)) {
                    e.preventDefault();
                    this.smoothNavigate(e.target.href);
                }
            });
        });
    }

    prefetchPage(url) {
        if (!url || this.prefetchedPages.has(url) || this.isCurrentPage(url)) {
            return;
        }

        const link = document.createElement('link');
        link.rel = 'prefetch';
        link.href = url;
        document.head.appendChild(link);
        this.prefetchedPages.add(url);
    }

    shouldInterceptNavigation(url) {
        // Only intercept internal URLs
        return url && url.startsWith(window.location.origin);
    }

    isCurrentPage(url) {
        return url === window.location.href;
    }

    smoothNavigate(url) {
        // Add loading state
        document.body.style.opacity = '0.9';

        // Navigate after brief transition
        setTimeout(() => {
            window.location.href = url;
        }, 100);
    }

    // OPTIMIZED: Debounced search with caching
    setupSearchOptimization() {
        const searchInputs = document.querySelectorAll('#searchInput, #headerSearchInput, .search-input');

        searchInputs.forEach(input => {
            input.addEventListener('input', (e) => {
                this.handleSearchInput(e.target.value);
            }, { passive: true });

            input.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    this.performSearch(e.target.value);
                }
            });
        });
    }

    handleSearchInput(query) {
        clearTimeout(this.searchTimeout);

        // Debounce search for better performance
        this.searchTimeout = setTimeout(() => {
            if (query.length >= 2) {
                this.showSearchSuggestions(query);
            } else {
                this.hideSearchSuggestions();
            }
        }, 300);
    }

    // OPTIMIZED: Animation setup with staggering
    setupAnimationOptimizations() {
        // Stagger animate cards with reduced delay
        const cards = document.querySelectorAll('.movie-card, .stat-card, .animate-card');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.05}s`; // Reduced from 0.1s
            card.classList.add('animate-in');
            // Add hardware acceleration
            card.classList.add('hardware-accelerated');
        });

        // Setup parallax with reduced intensity
        this.setupOptimizedParallax();
    }

    setupOptimizedParallax() {
        const parallaxElements = document.querySelectorAll('.header, .parallax-element');

        if (parallaxElements.length === 0) return;

        // Only enable parallax on desktop for performance
        if (window.innerWidth > 768) {
            this.parallaxElements = parallaxElements;
        }
    }

    updateParallax() {
        if (!this.parallaxElements || window.innerWidth <= 768) return;

        const scrolled = window.pageYOffset;

        this.parallaxElements.forEach(element => {
            const rate = scrolled * -0.2; // Reduced intensity
            element.style.transform = `translate3d(0, ${rate}px, 0)`;
        });
    }

    // OPTIMIZED: Lazy loading with intersection observer
    setupImageLazyLoading() {
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                            img.classList.remove('lazy');
                            imageObserver.unobserve(img);
                        }
                    }
                });
            }, {
                rootMargin: '50px'
            });

            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }
    }

    // Enhanced movie search with performance optimizations
    async searchMovies(query = null) {
        if (!query) {
            const searchInput = document.getElementById('searchInput') || document.getElementById('headerSearchInput');
            query = searchInput?.value?.trim();
        }

        if (!query || this.isLoading) return;

        this.isLoading = true;
        this.showSearchLoading();

        try {
            const response = await this.optimizedFetch(`/api/movies/search?query=${encodeURIComponent(query)}`);
            const data = await response.json();

            if (data.success) {
                this.displaySearchResults(data.movies);
                this.updateBrowserHistory(query);
            } else {
                this.showSearchError(data.error || 'Search failed');
            }
        } catch (error) {
            console.error('Search error:', error);
            this.showSearchError('Network error occurred');
        } finally {
            this.isLoading = false;
            this.hideSearchLoading();
        }
    }

    // OPTIMIZED: Fetch with timeout and caching headers
    async optimizedFetch(url, options = {}) {
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), 10000); // 10s timeout

        try {
            const response = await fetch(url, {
                ...options,
                signal: controller.signal,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Cache-Control': 'max-age=300', // 5 minute cache
                    ...options.headers
                }
            });

            clearTimeout(timeoutId);
            return response;
        } catch (error) {
            clearTimeout(timeoutId);
            throw error;
        }
    }

    displaySearchResults(movies) {
        const resultsContainer = document.getElementById('searchResults') || this.createResultsContainer();

        if (!movies || movies.length === 0) {
            resultsContainer.innerHTML = this.getEmptyResultsHTML();
            return;
        }

        // Use document fragment for better performance
        const fragment = document.createDocumentFragment();

        movies.forEach(movie => {
            const movieCard = this.createMovieCard(movie);
            fragment.appendChild(movieCard);
        });

        resultsContainer.innerHTML = '';
        resultsContainer.appendChild(fragment);

        // Animate new results
        this.animateSearchResults();
    }

    createMovieCard(movie) {
        const card = document.createElement('div');
        card.className = 'movie-card animate-in';
        card.innerHTML = `
            <div class="movie-poster">
                <img src="${movie.poster || '/public/assets/images/no-image.png'}" 
                     alt="${this.escapeHtml(movie.title)}"
                     loading="lazy">
            </div>
            <div class="movie-content">
                <h3 class="movie-title">${this.escapeHtml(movie.title)}</h3>
                <div class="movie-meta">
                    <span class="meta-item">${movie.year || 'N/A'}</span>
                    <span class="meta-item">${movie.genre || 'Unknown'}</span>
                    ${movie.rating ? `<span class="meta-item">⭐ ${movie.rating}/10</span>` : ''}
                </div>
                <div class="movie-actions">
                    <button class="btn btn-primary" onclick="movieApp.loadMovieDetails('${movie.imdb_id}')">
                        View Details
                    </button>
                </div>
            </div>
        `;
        return card;
    }

    // OPTIMIZED: Star rating with better performance
    createStarRating(rating, isInteractive = true) {
        const container = document.createElement('div');
        container.className = 'stars';

        for (let i = 1; i <= 5; i++) {
            const star = document.createElement('span');
            star.className = `star ${i <= rating ? 'active' : ''}`;
            star.textContent = '⭐';
            star.dataset.rating = i;

            if (isInteractive) {
                star.addEventListener('click', () => this.handleStarClick(i), { passive: true });
                star.addEventListener('mouseenter', () => this.handleStarHover(i), { passive: true });
            }

            container.appendChild(star);
        }

        return container;
    }

    handleStarClick(rating) {
        this.currentRating = rating;
        this.updateStarDisplay(rating);
        this.rateMovie(rating);
    }

    handleStarHover(rating) {
        this.updateStarDisplay(rating, true);
    }

    updateStarDisplay(rating, isHover = false) {
        const stars = document.querySelectorAll('.star');
        stars.forEach((star, index) => {
            const starRating = index + 1;
            star.classList.toggle('active', starRating <= rating);
            star.classList.toggle('hover', isHover && starRating <= rating);
        });
    }

    // OPTIMIZED: Toast notifications with better performance
    showToast(message, type = 'info') {
        // Remove existing toasts efficiently
        const existingToasts = document.querySelectorAll('.toast');
        existingToasts.forEach(toast => toast.remove());

        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.textContent = message;

        // Optimized styling
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
            transition: 'transform 0.3s ease',
            maxWidth: '350px',
            wordWrap: 'break-word',
            boxShadow: '0 20px 25px -5px rgba(0, 0, 0, 0.1)',
            backdropFilter: 'blur(10px)',
            border: '1px solid rgba(255, 255, 255, 0.2)'
        });

        // Set background based on type
        const colors = {
            success: 'linear-gradient(135deg, #10b981, #059669)',
            error: 'linear-gradient(135deg, #ef4444, #dc2626)',
            warning: 'linear-gradient(135deg, #f59e0b, #d97706)',
            info: 'linear-gradient(135deg, #6366f1, #4f46e5)'
        };
        toast.style.background = colors[type] || colors.info;

        document.body.appendChild(toast);

        // Animate in
        requestAnimationFrame(() => {
            toast.style.transform = 'translateX(0)';
        });

        // Click to dismiss
        toast.addEventListener('click', () => {
            this.dismissToast(toast);
        });

        // Auto dismiss
        setTimeout(() => {
            this.dismissToast(toast);
        }, 4000);
    }

    dismissToast(toast) {
        if (toast.parentNode) {
            toast.style.transform = 'translateX(400px)';
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        }
    }

    // OPTIMIZED: Modal handling
    closeModals() {
        const modals = document.querySelectorAll('.modal, .overlay');
        modals.forEach(modal => {
            modal.classList.remove('show');
            modal.style.display = 'none';
        });
    }

    // Utility functions
    focusSearch() {
        const searchInput = document.querySelector('#searchInput, #headerSearchInput, .search-input');
        if (searchInput) {
            searchInput.focus();
            searchInput.select();
        }
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Performance monitoring
    setupPerformanceMonitoring() {
        if ('performance' in window) {
            window.addEventListener('load', () => {
                const loadTime = performance.timing.loadEventEnd - performance.timing.navigationStart;
                console.log('Page load time:', loadTime + 'ms');

                if (loadTime > 3000) {
                    console.warn('Page load time is high:', loadTime + 'ms');
                }
            });
        }
    }

    // OPTIMIZED: Throttle function
    throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    }

    // OPTIMIZED: Debounce function
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Cleanup for better memory management
    cleanup() {
        if (this.intersectionObserver) {
            this.intersectionObserver.disconnect();
        }

        clearTimeout(this.searchTimeout);

        // Remove event listeners
        window.removeEventListener('scroll', this.handleScroll);
        window.removeEventListener('resize', this.handleResize);
    }

    // Additional utility methods for backward compatibility
    showSearchLoading() {
        const loadingEl = document.getElementById('searchLoading');
        if (loadingEl) {
            loadingEl.style.display = 'block';
        }
    }

    hideSearchLoading() {
        const loadingEl = document.getElementById('searchLoading');
        if (loadingEl) {
            loadingEl.style.display = 'none';
        }
    }

    showSearchError(message) {
        this.showToast(message, 'error');
    }

    createResultsContainer() {
        let container = document.getElementById('searchResults');
        if (!container) {
            container = document.createElement('div');
            container.id = 'searchResults';
            container.className = 'search-results grid grid-4';

            const searchSection = document.querySelector('.search-section');
            if (searchSection) {
                searchSection.appendChild(container);
            }
        }
        return container;
    }

    getEmptyResultsHTML() {
        return `
            <div class="empty-state">
                <div class="empty-state-icon">🎬</div>
                <h3>No movies found</h3>
                <p>Try searching with different keywords</p>
            </div>
        `;
    }

    animateSearchResults() {
        const newCards = document.querySelectorAll('.movie-card.animate-in');
        newCards.forEach((card, index) => {
            setTimeout(() => {
                card.classList.add('animate-visible');
            }, index * 50);
        });
    }

    updateBrowserHistory(query) {
        if (history.pushState && query) {
            const newUrl = `${window.location.pathname}?search=${encodeURIComponent(query)}`;
            history.pushState({ search: query }, '', newUrl);
        }
    }

    updateScrollIndicators() {
        // Update any scroll-based progress indicators
        const indicators = document.querySelectorAll('.scroll-indicator');
        if (indicators.length === 0) return;

        const scrollPercent = (window.scrollY / (document.body.scrollHeight - window.innerHeight)) * 100;
        indicators.forEach(indicator => {
            indicator.style.width = `${Math.min(scrollPercent, 100)}%`;
        });
    }

    updateResponsiveElements() {
        // Handle responsive behavior on resize
        const isMobile = window.innerWidth <= 768;

        // Disable parallax on mobile
        if (isMobile && this.parallaxElements) {
            this.parallaxElements.forEach(el => {
                el.style.transform = 'none';
            });
        }
    }

    setupAccessibility() {
        // Add focus management
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Tab') {
                document.body.classList.add('keyboard-navigation');
            }
        });

        document.addEventListener('mousedown', () => {
            document.body.classList.remove('keyboard-navigation');
        });
    }

    showSearchSuggestions(query) {
        // Implement search suggestions if needed
        console.log('Search suggestions for:', query);
    }

    hideSearchSuggestions() {
        const suggestions = document.querySelector('.search-suggestions');
        if (suggestions) {
            suggestions.style.display = 'none';
        }
    }

    // Methods for backward compatibility
    async loadMovieDetails(imdbId) {
        this.showToast('Loading movie details...', 'info');

        try {
            const response = await this.optimizedFetch(`/api/movies/details/${imdbId}`);
            const data = await response.json();

            if (data.success) {
                this.displayMovieDetails(data.movie);
            } else {
                this.showToast('Failed to load movie details', 'error');
            }
        } catch (error) {
            this.showToast('Network error occurred', 'error');
        }
    }

    async rateMovie(rating) {
        this.showToast(`Rating movie ${rating}/5 stars...`, 'info');

        try {
            const response = await this.optimizedFetch('/api/movies/rate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ rating })
            });

            const data = await response.json();

            if (data.success) {
                this.showToast('Movie rated successfully!', 'success');
            } else {
                this.showToast('Failed to rate movie', 'error');
            }
        } catch (error) {
            this.showToast('Rating failed', 'error');
        }
    }

    displayMovieDetails(movie) {
        // Implementation for displaying movie details
        console.log('Displaying movie:', movie);
    }
}

// Initialize the optimized app
const movieApp = new PerformanceOptimizedMovieApp();

// Export for global access (backward compatibility)
window.movieApp = movieApp;
window.MovieApp = {
    searchMovies: (query) => movieApp.searchMovies(query),
    loadMovieDetails: (imdbId) => movieApp.loadMovieDetails(imdbId),
    rateMovie: (rating) => movieApp.rateMovie(rating),
    showToast: (message, type) => movieApp.showToast(message, type)
};