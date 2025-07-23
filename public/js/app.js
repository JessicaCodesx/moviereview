// Fixed Movie Search Functionality
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
                            <span>👁️</span> View Details
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

        const poster = movie.Poster !== 'N/A' ? movie.Poster : '/public/assets/images/no-image.png';
        const rating = movie.ratings?.average || 0;
        const ratingCount = movie.ratings?.count || 0;

        detailsContainer.innerHTML = `
            <div class="movie-detail-card">
                <button class="close-btn" onclick="movieAppInstance.closeMovieDetails()">✖️</button>

                <div class="movie-detail-content">
                    <div class="movie-detail-poster">
                        <img src="${poster}" 
                             alt="${this.escapeHtml(movie.Title)}"
                             onerror="this.src='/public/assets/images/no-image.png'">
                    </div>

                    <div class="movie-detail-info">
                        <h2>${this.escapeHtml(movie.Title)} (${movie.Year})</h2>

                        <div class="movie-meta">
                            <span class="meta-badge">${movie.Rated}</span>
                            <span class="meta-badge">${movie.Runtime}</span>
                            <span class="meta-badge">⭐ ${movie.imdbRating}/10</span>
                        </div>

                        <div class="movie-genres">
                            ${movie.Genre ? movie.Genre.split(',').map(genre => 
                                `<span class="genre-tag">${genre.trim()}</span>`
                            ).join('') : ''}
                        </div>

                        <div class="plot-section">
                            <h4>Plot</h4>
                            <p>${movie.Plot !== 'N/A' ? movie.Plot : 'No plot available.'}</p>
                        </div>

                        <div class="cast-crew">
                            ${movie.Director !== 'N/A' ? `<p><strong>Director:</strong> ${movie.Director}</p>` : ''}
                            ${movie.Actors !== 'N/A' ? `<p><strong>Cast:</strong> ${movie.Actors}</p>` : ''}
                        </div>

                        <div class="rating-section">
                            <h4>Rate this movie:</h4>
                            ${this.createRatingHTML(movie.user_rating || 0, movie.id)}
                            ${ratingCount > 0 ? `<p class="rating-info">Average: ${rating}/5 (${ratingCount} ratings)</p>` : ''}
                        </div>

                        <div class="movie-actions">
                            <button class="btn btn-primary" onclick="movieAppInstance.addToWatchlist(${movie.id})">
                                <span>📝</span> Add to Watchlist
                            </button>
                            <button class="btn btn-secondary" onclick="movieAppInstance.markAsWatched(${movie.id})">
                                <span>✅</span> Mark as Watched
                            </button>
                            <button class="btn btn-secondary" onclick="movieAppInstance.generateReview(${movie.id})">
                                <span>🤖</span> AI Review
                            </button>
                        </div>
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
            detailsContainer.scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start' 
            });
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

        // Styling
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
            boxShadow: '0 10px 25px rgba(0,0,0,0.2)'
        });

        // Set background based on type
        const colors = {
            success: '#10b981',
            error: '#ef4444',
            warning: '#f59e0b',
            info: '#6366f1'
        };
        toast.style.backgroundColor = colors[type] || colors.info;

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

    // Additional methods for user actions
    async addToWatchlist(movieId) {
        this.showToast('Adding to watchlist...', 'info');
        // Implementation would go here
    }

    async markAsWatched(movieId) {
        this.showToast('Marking as watched...', 'info');
        // Implementation would go here
    }

    async generateReview(movieId) {
        this.showToast('Generating AI review...', 'info');
        // Implementation would go here
    }
}

// Initialize the app
const movieAppInstance = new MovieSearchApp();

// Export for global access
window.movieAppInstance = movieAppInstance;