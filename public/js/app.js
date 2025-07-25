class MovieSearchApp {
    constructor() {
        this.isLoading = false;
        this.searchTimeout = null;
        this.currentMovieId = null;
        this.init();
    }

    init() {
        this.setupSearchListeners();
        this.createSearchResultsContainer();
        this.setupMovieDetailsContainer();
    }

    setupSearchListeners() {
        // Handle search input events
        const searchInputs = document.querySelectorAll('#searchInput, #headerSearchInput, .search-input');

        searchInputs.forEach(input => {
            // Real-time search on input
            input.addEventListener('input', (e) => {
                clearTimeout(this.searchTimeout);
                const query = e.target.value.trim();

                if (query.length >= 2) {
                    this.searchTimeout = setTimeout(() => {
                        this.searchMovies(query);
                    }, 300);
                } else if (query.length === 0) {
                    this.clearSearchResults();
                }
            });

            // Search on Enter key
            input.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    e.stopPropagation();
                    const query = e.target.value.trim();
                    if (query) {
                        this.searchMovies(query);
                    }
                }
            });
        });

        // Handle search button clicks
        const searchBtns = document.querySelectorAll('.search-btn');
        searchBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const input = btn.previousElementSibling || 
                             document.getElementById('searchInput') || 
                             document.getElementById('headerSearchInput');
                if (input) {
                    const query = input.value.trim();
                    if (query) {
                        this.searchMovies(query);
                    }
                }
            });
        });
    }

    createSearchResultsContainer() {
        if (!document.getElementById('searchResults')) {
            const container = document.createElement('div');
            container.id = 'searchResults';
            container.className = 'search-results';

            // Find a good place to insert it
            const searchSection = document.querySelector('.search-section') || 
                                 document.querySelector('.search-box')?.parentElement ||
                                 document.querySelector('main .container');

            if (searchSection) {
                searchSection.appendChild(container);
            } else {
                document.body.appendChild(container);
            }
        }
    }

    setupMovieDetailsContainer() {
        if (!document.getElementById('movieDetails')) {
            const container = document.createElement('div');
            container.id = 'movieDetails';
            container.className = 'movie-details';

            const resultsContainer = document.getElementById('searchResults');
            if (resultsContainer) {
                resultsContainer.parentElement.appendChild(container);
            } else {
                document.body.appendChild(container);
            }
        }
    }

    async searchMovies(query) {
        if (this.isLoading || !query) return;

        this.isLoading = true;
        this.showLoadingState();

        try {
            // Create FormData to match the expected POST format
            const formData = new FormData();
            formData.append('query', query);

            const response = await fetch('/api/search', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();

            if (data.Response === 'True' && data.Search) {
                this.displaySearchResults(data.Search);
                this.showToast(`Found ${data.Search.length} movies`, 'success');
            } else if (data.Response === 'False') {
                this.showNoResults(data.Error || 'No movies found');
            } else {
                this.showError('Unexpected response format');
            }

        } catch (error) {
            console.error('Search error:', error);
            this.showError('Failed to search movies. Please try again.');
        } finally {
            this.isLoading = false;
            this.hideLoadingState();
        }
    }

    displaySearchResults(movies) {
        const resultsContainer = document.getElementById('searchResults');
        if (!resultsContainer) return;

        const searchTerm = movies.length > 0 ? 'Found' : 'No';
        const resultText = movies.length === 1 ? 'result' : 'results';

        resultsContainer.innerHTML = `
            <div class="results-header">
                <h3>${searchTerm} ${movies.length} ${resultText}</h3>
                <p>Click on any movie to view detailed information and ratings</p>
            </div>
            <div class="movies-grid">
                ${movies.map(movie => this.createMovieCardHTML(movie)).join('')}
            </div>
        `;

        resultsContainer.style.display = 'block';
        resultsContainer.classList.add('show');

        // Add click listeners to movie cards
        this.addMovieCardListeners();

        // Animate results with staggered effect
        this.animateResults();
    }

    createMovieCardHTML(movie) {
        const poster = movie.Poster !== 'N/A' ? movie.Poster : '/public/assets/images/no-image.png';
        const movieType = movie.Type?.charAt(0).toUpperCase() + movie.Type?.slice(1) || 'Movie';

        return `
            <div class="movie-card" data-imdb-id="${movie.imdbID}" style="cursor: pointer;">
                <div class="movie-poster">
                    <img src="${poster}" 
                         alt="${this.escapeHtml(movie.Title)}"
                         onerror="this.src='/public/assets/images/no-image.png'"
                         loading="lazy">
                    <div class="movie-overlay">
                        <button class="overlay-btn">
                            View Details
                        </button>
                    </div>
                </div>
                <div class="movie-card-info">
                    <h4>${this.escapeHtml(movie.Title)}</h4>
                    <p>${movie.Year}</p>
                    <span class="movie-type">${movieType}</span>
                </div>
            </div>
        `;
    }

    addMovieCardListeners() {
        const movieCards = document.querySelectorAll('.movie-card[data-imdb-id]');
        movieCards.forEach(card => {
            card.addEventListener('click', () => {
                const imdbId = card.dataset.imdbId;
                if (imdbId) {
                    this.loadMovieDetails(imdbId);
                }
            });
        });
    }

    async loadMovieDetails(imdbId) {
        if (!imdbId) return;

        this.currentMovieId = imdbId;
        this.showMovieLoading();

        try {
            const formData = new FormData();
            formData.append('imdbId', imdbId);

            const response = await fetch('/api/movie', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const movie = await response.json();

            // Debug: Log the actual movie data structure
            console.log('Movie data received:', movie);

            if (movie && movie.Response !== 'False') {
                this.displayMovieDetails(movie);
                this.scrollToMovieDetails();
            } else {
                this.showError(movie.Error || 'Movie details not found');
            }

        } catch (error) {
            console.error('Movie details error:', error);
            this.showError('Failed to load movie details');
        } finally {
            this.hideMovieLoading();
        }
    }

    displayMovieDetails(movie) {
        const detailsContainer = document.getElementById('movieDetails');
        if (!detailsContainer) return;

        // Check if user is authenticated
        const isAuthenticated = this.isUserAuthenticated();

        const poster = movie.poster !== 'N/A' ? movie.poster : '/public/assets/images/no-image.png';
        const rating = movie.rating || 0;
        const ratingCount = movie.ratings?.count || 0;

        detailsContainer.innerHTML = `
            <div class="movie-card">
                <button class="movie-details-close-btn" onclick="movieAppInstance.closeMovieDetails()" title="Close Details">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
                <div class="movie-poster">
                    <img src="${poster}" 
                         alt="${this.escapeHtml(movie.title || movie.Title)}"
                         onerror="this.src='/public/assets/images/no-image.png'">
                    <div class="movie-overlay">
                        <button class="play-button">👁️ Show Details</button>
                    </div>
                </div>
                <div class="movie-content">
                    <h2>${this.escapeHtml(movie.title || movie.Title)} (${movie.year || movie.Year})</h2>
                    <div class="movie-meta">
                        <span class="meta-item">Rated: ${movie.rated || 'NR'}</span>
                        <span class="meta-item">${movie.runtime || 'Unknown'}</span>
                        <span class="meta-item">⭐ ${movie.rating || 'N/A'}/10</span>
                    </div>
                    <div class="movie-genres">
                        ${movie.genre ? movie.genre.split(',').map(genre => 
                            `<span class="genre-tag">${genre.trim()}</span>`
                        ).join('') : ''}
                    </div>
                    <div class="plot-section">
                        <h4>Plot</h4>
                        <p>${movie.plot && movie.plot !== 'N/A' ? movie.plot : 'No plot available.'}</p>
                    </div>
                    <div class="cast-crew">
                        ${movie.director && movie.director !== 'N/A' ? `<p><strong>Director:</strong> ${movie.director}</p>` : ''}
                        ${movie.actors && movie.actors !== 'N/A' ? `<p><strong>Cast:</strong> ${movie.actors}</p>` : ''}
                    </div>
                    <div class="rating-section">
                        <h4>Rate this movie:</h4>
                        ${this.createRatingHTML(movie.user_rating || 0, movie.id)}
                        ${ratingCount > 0 ? `<p class="rating-info">Average: ${rating}/5 (${ratingCount} ratings)</p>` : ''}
                        ${!isAuthenticated ? `<p class="rating-note">Your rating is saved anonymously. <a href="/login">Login</a> to track your ratings.</p>` : ''}
                    </div>
                    <div class="movie-actions">
                        ${isAuthenticated ? `
                            <button class="btn btn-primary" onclick="movieAppInstance.addToWatchlist(${movie.id})">
                                <span>📝</span> Add to Watchlist
                            </button>
                            <button class="btn btn-secondary" onclick="movieAppInstance.markAsWatched(${movie.id})">
                                <span>✅</span> Mark as Watched
                            </button>
                        ` : `
                            <a href="/login" class="btn btn-primary">
                                <span>🔐</span> Login to Add to Watchlist
                            </a>
                            <a href="/register" class="btn btn-secondary">
                                <span>👑</span> Join to Rate Movies
                            </a>
                        `}
                        <button class="btn btn-secondary" onclick="movieAppInstance.generateReview(${movie.id})">
                            <span>🤖</span> AI Review
                        </button>
                    </div>
                </div>
            </div>
        `;

        detailsContainer.style.display = 'block';
        detailsContainer.classList.add('show');
    }

    createRatingHTML(currentRating, movieId) {
        let starsHTML = '<div class="stars" data-movie-id="' + movieId + '">';

        for (let i = 1; i <= 5; i++) {
            const activeClass = i <= currentRating ? 'active' : '';
            starsHTML += `
                <span class="star ${activeClass}" 
                      data-rating="${i}" 
                      onclick="movieAppInstance.rateMovie(${i}, ${movieId})"
                      onmouseover="movieAppInstance.highlightStars(${i})"
                      onmouseleave="movieAppInstance.resetStarHighlight(${currentRating})"
                      title="Rate ${i} star${i > 1 ? 's' : ''}">⭐</span>
            `;
        }

        starsHTML += '</div>';
        return starsHTML;
    }

    async rateMovie(rating, movieId) {
        if (!movieId || !rating) return;

        try {
            const formData = new FormData();
            formData.append('movieId', movieId);
            formData.append('rating', rating);

            const response = await fetch('/api/rate', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await response.json();

            if (data.success) {
                this.updateStarRating(rating);
                this.showToast('Rating saved successfully!', 'success');
            } else {
                this.showToast(data.error || 'Failed to save rating', 'error');
            }

        } catch (error) {
            console.error('Rating error:', error);
            this.showToast('Failed to save rating', 'error');
        }
    }

    updateStarRating(rating) {
        const stars = document.querySelectorAll('.star');
        stars.forEach((star, index) => {
            star.classList.toggle('active', (index + 1) <= rating);
        });
    }

    highlightStars(rating) {
        const stars = document.querySelectorAll('.star');
        stars.forEach((star, index) => {
            if ((index + 1) <= rating) {
                star.style.color = '#fbbf24';
                star.style.transform = 'scale(1.2)';
            } else {
                star.style.color = '#e2e8f0';
                star.style.transform = 'scale(1)';
            }
        });
    }

    resetStarHighlight(currentRating) {
        const stars = document.querySelectorAll('.star');
        stars.forEach((star, index) => {
            if ((index + 1) <= currentRating) {
                star.style.color = '#f59e0b';
                star.style.transform = 'scale(1.15)';
            } else {
                star.style.color = '#e2e8f0';
                star.style.transform = 'scale(1)';
            }
        });
    }

    closeMovieDetails() {
        const detailsContainer = document.getElementById('movieDetails');
        if (detailsContainer) {
            detailsContainer.classList.remove('show');
            setTimeout(() => {
                detailsContainer.style.display = 'none';
            }, 300);
        }
    }

    scrollToMovieDetails() {
        const detailsContainer = document.getElementById('movieDetails');
        if (detailsContainer) {
            // Add a small delay to ensure the container is fully rendered
            setTimeout(() => {
                // Calculate the offset to account for fixed header and provide some padding
                const headerHeight = 120; // Approximate height of fixed header + padding
                const elementTop = detailsContainer.offsetTop;
                const offsetPosition = elementTop - headerHeight;

                // Smooth scroll to the calculated position
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });

                // Add a subtle highlight effect to draw attention
                detailsContainer.style.boxShadow = '0 0 20px rgba(99, 102, 241, 0.3)';
                detailsContainer.style.transform = 'scale(1.02)';
                detailsContainer.style.transition = 'all 0.3s ease';

                // Remove the highlight effect after a short duration
                setTimeout(() => {
                    detailsContainer.style.boxShadow = '';
                    detailsContainer.style.transform = '';
                }, 800);
            }, 100);
        }
    }

    showLoadingState() {
        const resultsContainer = document.getElementById('searchResults');
        if (resultsContainer) {
            resultsContainer.innerHTML = `
                <div class="loading-state">
                    <div class="spinner"></div>
                    <p>Searching movies...</p>
                </div>
            `;
        }
    }

    hideLoadingState() {
        // Loading is hidden when results are displayed
    }

    showMovieLoading() {
        const detailsContainer = document.getElementById('movieDetails');
        if (detailsContainer) {
            detailsContainer.innerHTML = `
                <div class="loading-state">
                    <div class="spinner"></div>
                    <p>Loading movie details...</p>
                </div>
            `;
            detailsContainer.style.display = 'block';
        }
    }

    hideMovieLoading() {
        // Loading is hidden when movie details are displayed
    }

    showNoResults(message) {
        const resultsContainer = document.getElementById('searchResults');
        if (resultsContainer) {
            resultsContainer.innerHTML = `
                <div class="no-results">
                    <div class="no-results-icon">🎬</div>
                    <h3>No movies found</h3>
                    <p>${message || 'Try searching with different keywords'}</p>
                </div>
            `;
        }
    }

    showError(message) {
        this.showToast(message, 'error');
    }

    clearSearchResults() {
        const resultsContainer = document.getElementById('searchResults');
        if (resultsContainer) {
            resultsContainer.innerHTML = '';
        }
        this.closeMovieDetails();
    }

    animateResults() {
        const movieCards = document.querySelectorAll('.movie-card');
        movieCards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';

            setTimeout(() => {
                card.style.transition = 'all 0.3s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    }

    showToast(message, type = 'info') {
        // Remove existing toasts
        const existingToasts = document.querySelectorAll('.toast');
        existingToasts.forEach(toast => toast.remove());

        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.textContent = message;

        // Use fixed positioning relative to viewport
        const headerHeight = 100; // Account for fixed header height with some padding

        // Styling
        Object.assign(toast.style, {
            position: 'fixed',
            top: `${headerHeight}px`,
            right: '20px',
            padding: '16px 24px',
            borderRadius: '12px',
            color: 'white',
            fontWeight: '500',
            fontSize: '14px',
            letterSpacing: '0.02em',
            zIndex: '10000',
            transform: 'translateX(400px)',
            transition: 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)',
            maxWidth: '350px',
            boxShadow: '0 10px 25px rgba(10, 22, 40, 0.3), 0 6px 12px rgba(10, 22, 40, 0.15)',
            backdropFilter: 'blur(10px)',
            fontFamily: 'Poppins, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif'
        });

        // Set background and styling based on type - matching theme colors
        const styles = {
            success: {
                background: 'linear-gradient(135deg, rgba(212, 165, 116, 0.95) 0%, rgba(196, 130, 27, 0.95) 100%)',
                border: '1px solid rgba(212, 165, 116, 0.3)',
                boxShadow: '0 10px 25px rgba(212, 165, 116, 0.3), 0 6px 12px rgba(212, 165, 116, 0.15), inset 0 1px 0 rgba(255, 255, 255, 0.1)'
            },
            error: {
                background: 'linear-gradient(135deg, rgba(198, 40, 40, 0.95) 0%, rgba(183, 28, 28, 0.95) 100%)',
                border: '1px solid rgba(198, 40, 40, 0.3)',
                boxShadow: '0 10px 25px rgba(198, 40, 40, 0.2), 0 6px 12px rgba(198, 40, 40, 0.1)'
            },
            warning: {
                background: 'linear-gradient(135deg, rgba(249, 168, 37, 0.95) 0%, rgba(245, 127, 23, 0.95) 100%)',
                border: '1px solid rgba(249, 168, 37, 0.3)',
                boxShadow: '0 10px 25px rgba(249, 168, 37, 0.2), 0 6px 12px rgba(249, 168, 37, 0.1)'
            },
            info: {
                background: 'linear-gradient(135deg, rgba(30, 58, 95, 0.95) 0%, rgba(42, 78, 122, 0.95) 100%)',
                border: '1px solid rgba(99, 102, 241, 0.3)',
                boxShadow: '0 10px 25px rgba(30, 58, 95, 0.3), 0 6px 12px rgba(30, 58, 95, 0.15)'
            }
        };

        const selectedStyle = styles[type] || styles.info;
        Object.assign(toast.style, selectedStyle);

        document.body.appendChild(toast);

        // Animate in
        requestAnimationFrame(() => {
            toast.style.transform = 'translateX(0)';
        });

        // Auto dismiss
        setTimeout(() => {
            toast.style.transform = 'translateX(400px)';
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        }, 4000);
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text || '';
        return div.innerHTML;
    }

    // Check if user is authenticated
    isUserAuthenticated() {
        // Check if there's a session or auth token
        // This can be improved based on your authentication system
        return document.body.classList.contains('authenticated') || 
               document.querySelector('meta[name="user-authenticated"]')?.content === 'true' ||
               localStorage.getItem('isAuthenticated') === 'true' ||
               document.cookie.includes('user_session') ||
               window.location.pathname.includes('/dashboard') ||
               document.querySelector('.user-info, .user-avatar, .authenticated') !== null;
    }

    // Additional methods for user actions
    async addToWatchlist(movieId) {
        if (!movieId) return;

        this.showToast('Adding to watchlist...', 'info');

        try {
            const formData = new FormData();
            formData.append('movieId', movieId);

            const response = await fetch('/api/watchlist/add', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await response.json();

            if (data.success) {
                this.showToast('Movie added to watchlist! 📝', 'success');
            } else {
                this.showToast(data.error || 'Failed to add to watchlist', 'error');
            }

        } catch (error) {
            console.error('Watchlist error:', error);
            this.showToast('Failed to add to watchlist', 'error');
        }
    }

    async markAsWatched(movieId) {
        if (!movieId) return;

        this.showToast('Marking as watched...', 'info');

        try {
            const formData = new FormData();
            formData.append('movieId', movieId);

            const response = await fetch('/api/movie/watch', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await response.json();

            if (data.success) {
                this.showToast('Movie marked as watched! ✅', 'success');
            } else {
                this.showToast(data.error || 'Failed to mark as watched', 'error');
            }

        } catch (error) {
            console.error('Mark watched error:', error);
            this.showToast('Failed to mark as watched', 'error');
        }
    }

    async generateReview(movieId) {
        if (!movieId) return;

        this.showToast('Generating AI review...', 'info');

        try {
            const formData = new FormData();
            formData.append('movieId', movieId);

            const response = await fetch('/api/review', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await response.json();

            if (data.success && data.review) {
                this.showReviewModal(data.review);
                this.showToast('AI review generated! 🤖', 'success');
            } else {
                this.showToast(data.error || 'Failed to generate review', 'error');
            }

        } catch (error) {
            console.error('Review generation error:', error);
            this.showToast('Failed to generate review', 'error');
        }
    }

    showReviewModal(review) {
        // Create modal for displaying the AI review
        const modal = document.createElement('div');
        modal.className = 'review-modal';
        modal.innerHTML = `
            <div class="review-modal-content">
                <div class="review-modal-header">
                    <h3>👑 AI Movie Review</h3>
                    <button class="review-close-btn" onclick="this.parentElement.parentElement.parentElement.remove()">✖️</button>
                </div>
                <div class="review-modal-body">
                    <div class="review-text">${this.escapeHtml(review).replace(/\n/g, '<br>')}</div>
                </div>
            </div>
        `;

        // Add modal styles
        const style = document.createElement('style');
        style.textContent = `
            .review-modal {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(10, 22, 40, 0.95);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 10000;
                animation: fadeIn 0.3s ease;
                backdrop-filter: blur(10px);
            }
            .review-modal-content {
                background: linear-gradient(145deg, #1e3a5f 0%, #142343 100%);
                border-radius: 24px;
                max-width: 900px;
                width: 95%;
                max-height: 90vh;
                overflow-y: auto;
                box-shadow: 0 30px 60px rgba(10, 22, 40, 0.5), 
                           0 0 40px rgba(212, 165, 116, 0.2),
                           inset 0 1px 0 rgba(212, 165, 116, 0.3);
                border: 1px solid rgba(212, 165, 116, 0.2);
            }
            .review-modal-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 2rem;
                border-bottom: 2px solid rgba(212, 165, 116, 0.3);
                background: linear-gradient(135deg, #0a1628 0%, #1e3a5f 50%, rgba(212, 165, 116, 0.2) 100%);
                color: #d4a574;
                border-radius: 24px 24px 0 0;
                position: relative;
            }
            .review-modal-header::after {
                content: '';
                position: absolute;
                bottom: -2px;
                left: 0;
                right: 0;
                height: 2px;
                background: linear-gradient(90deg, transparent, #d4a574, transparent);
                animation: shimmer 3s infinite;
            }
            .review-modal-header h3 {
                margin: 0;
                font-size: 1.75rem;
                font-weight: 700;
                font-family: 'Playfair Display', serif;
                letter-spacing: 0.5px;
                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            }
            .review-close-btn {
                background: rgba(212, 165, 116, 0.1);
                border: 1px solid rgba(212, 165, 116, 0.3);
                color: #d4a574;
                font-size: 1.5rem;
                cursor: pointer;
                padding: 0.75rem;
                border-radius: 50%;
                transition: all 0.3s ease;
                width: 48px;
                height: 48px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .review-close-btn:hover {
                background: rgba(212, 165, 116, 0.2);
                transform: rotate(90deg) scale(1.1);
                box-shadow: 0 0 20px rgba(212, 165, 116, 0.4);
            }
            .review-modal-body {
                padding: 3rem;
                overflow-y: auto;
                max-height: calc(90vh - 120px);
            }
            .review-modal-body::-webkit-scrollbar {
                width: 8px;
            }
            .review-modal-body::-webkit-scrollbar-track {
                background: rgba(212, 165, 116, 0.1);
                border-radius: 4px;
            }
            .review-modal-body::-webkit-scrollbar-thumb {
                background: rgba(212, 165, 116, 0.4);
                border-radius: 4px;
            }
            .review-modal-body::-webkit-scrollbar-thumb:hover {
                background: rgba(212, 165, 116, 0.6);
            }
            .review-text {
                line-height: 1.8;
                color: #f0f3f7;
                font-size: 1.125rem;
                font-family: 'Poppins', sans-serif;
                text-align: justify;
                white-space: pre-wrap;
            }
            .review-text br {
                display: block;
                margin-bottom: 1rem;
            }
            @keyframes fadeIn {
                from {
                    opacity: 0;
                }
                to {
                    opacity: 1;
                }
            }
            @keyframes shimmer {
                0% { opacity: 0.3; }
                50% { opacity: 1; }
                100% { opacity: 0.3; }
            }
            @media (max-width: 768px) {
                .review-modal-content {
                    max-width: 95%;
                    max-height: 95vh;
                }
                .review-modal-header {
                    padding: 1.5rem;
                }
                .review-modal-header h3 {
                    font-size: 1.25rem;
                }
                .review-modal-body {
                    padding: 1.5rem;
                }
                .review-text {
                    font-size: 1rem;
                }
            }
        `;

        if (!document.querySelector('style[data-review-modal]')) {
            style.setAttribute('data-review-modal', 'true');
            document.head.appendChild(style);
        }

        document.body.appendChild(modal);

        // Close modal when clicking outside
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.remove();
            }
        });
    }
}

// Initialize the app
const movieAppInstance = new MovieSearchApp();

// Export for global access
window.movieAppInstance = movieAppInstance;