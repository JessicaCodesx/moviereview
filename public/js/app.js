class MovieApp {
    constructor() {
        this.currentMovieId = null;
        this.init();
    }

    init() {
        // Add event listeners
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('keypress', (e) => {
                    if (e.key === 'Enter') {
                        this.searchMovies();
                    }
                });
            }
        });
    }

    async searchMovies() {
        const query = document.getElementById('searchInput').value.trim();
        if (!query) return;

        const resultsDiv = document.getElementById('searchResults');
        this.showLoading(resultsDiv, 'Searching movies...');

        try {
            const response = await this.makeRequest('/api/search', {
                method: 'POST',
                body: this.createFormData({ query })
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.error || 'Search failed');
            }

            this.displaySearchResults(data);

        } catch (error) {
            this.showError(resultsDiv, error.message);
        }
    }

    displaySearchResults(data) {
        const resultsDiv = document.getElementById('searchResults');

        if (data.Response === 'False') {
            resultsDiv.innerHTML = '<div class="empty-state"><p>No movies found. Try a different search term.</p></div>';
            return;
        }

        resultsDiv.innerHTML = data.Search.map(movie => {
            const poster = movie.Poster !== 'N/A' ? movie.Poster : '/public/assets/images/no-image.png';
            return `
                <div class="movie-card" onclick="movieAppInstance.loadMovieDetails('${movie.imdbID}')">
                    <div class="movie-poster">
                        <img src="${poster}" alt="${movie.Title}" onerror="this.src='/public/assets/images/no-image.png'">
                    </div>
                    <div class="movie-card-info">
                        <h3>${this.escapeHtml(movie.Title)}</h3>
                        <p>${movie.Year}</p>
                    </div>
                </div>
            `;
        }).join('');
    }

    async loadMovieDetails(imdbId) {
        const detailsDiv = document.getElementById('movieDetails');
        detailsDiv.style.display = 'block';
        this.showLoading(detailsDiv, 'Loading movie details...');

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
            await this.displayMovieDetails(movie);

        } catch (error) {
            this.showError(detailsDiv, error.message);
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
            <div class="movie-header">
                <div class="movie-poster">
                    <img src="${poster}" alt="${this.escapeHtml(movie.title)}">
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

            <div class="rating-section">
                <h3>Rate this movie</h3>
                <div class="rating-display">
                    <div class="stars">
                        ${[1,2,3,4,5].map(i => 
                            `<span class="star ${i <= (movie.user_rating || 0) ? 'active' : ''}" 
                                   data-rating="${i}" onclick="movieAppInstance.rateMovie(${i})">⭐</span>`
                        ).join('')}
                    </div>
                    <div class="rating-info" id="ratingInfo">
                        Average: ${movie.ratings.average}/5 (${movie.ratings.count} rating${movie.ratings.count !== 1 ? 's' : ''})
                        ${movie.user_rating ? `<br><small>Your rating: ${movie.user_rating}/5</small>` : ''}
                    </div>
                </div>
            </div>

            <div class="review-section">
                <button onclick="movieAppInstance.generateReview(${movie.id})" class="btn">📝 Get AI Review</button>
                <div id="reviewContent" class="review-content"></div>
            </div>
        `;

        // Add hover effects to stars
        this.setupStarHoverEffects();
    }

    async toggleWatchlist(movieId, isInWatchlist) {
        if (!window.authState || !window.authState.isLoggedIn) {
            alert('Please login to manage your watchlist');
            return;
        }

        const endpoint = isInWatchlist ? '/api/watchlist/remove' : '/api/watchlist/add';
        const btn = document.getElementById('watchlistBtn');
        const originalText = btn.textContent;

        btn.disabled = true;
        btn.textContent = isInWatchlist ? 'Removing...' : 'Adding...';

        try {
            const response = await this.makeRequest(endpoint, {
                method: 'POST',
                body: this.createFormData({ movieId })
            });

            const data = await response.json();

            if (data.success) {
                btn.textContent = isInWatchlist ? '📝 Add to Watchlist' : '📝 Remove from Watchlist';
                btn.className = isInWatchlist ? 'btn btn-primary' : 'btn btn-secondary';
                btn.onclick = () => this.toggleWatchlist(movieId, !isInWatchlist);

                this.showToast(data.message, 'success');
            } else {
                throw new Error(data.error);
            }
        } catch (error) {
            btn.textContent = originalText;
            this.showToast(error.message, 'error');
        } finally {
            btn.disabled = false;
        }
    }

    async toggleWatched(movieId, isWatched) {
        if (!window.authState || !window.authState.isLoggedIn) {
            alert('Please login to track watched movies');
            return;
        }

        const endpoint = isWatched ? '/api/movie/unwatch' : '/api/movie/watch';
        const btn = document.getElementById('watchedBtn');
        const originalText = btn.textContent;

        btn.disabled = true;
        btn.textContent = isWatched ? 'Unmarking...' : 'Marking...';

        try {
            const response = await this.makeRequest(endpoint, {
                method: 'POST',
                body: this.createFormData({ movieId })
            });

            const data = await response.json();

            if (data.success) {
                btn.textContent = isWatched ? '✅ Mark as Watched' : '✅ Mark as Unwatched';
                btn.className = isWatched ? 'btn btn-success' : 'btn btn-secondary';
                btn.onclick = () => this.toggleWatched(movieId, !isWatched);

                this.showToast(data.message, 'success');
            } else {
                throw new Error(data.error);
            }
        } catch (error) {
            btn.textContent = originalText;
            this.showToast(error.message, 'error');
        } finally {
            btn.disabled = false;
        }
    }

    setupStarHoverEffects() {
        const stars = document.querySelectorAll('.star');
        stars.forEach((star, index) => {
            star.addEventListener('mouseenter', () => {
                this.highlightStars(index + 1);
            });
            star.addEventListener('mouseleave', () => {
                this.resetStars();
            });
        });
    }

    highlightStars(rating) {
        const stars = document.querySelectorAll('.star');
        stars.forEach((star, index) => {
            star.classList.toggle('hover', index < rating);
        });
    }

    resetStars() {
        const stars = document.querySelectorAll('.star');
        stars.forEach(star => star.classList.remove('hover'));
    }

    async rateMovie(rating) {
        if (!this.currentMovieId) return;

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
                // Update rating display
                const ratingInfo = document.getElementById('ratingInfo');
                ratingInfo.innerHTML = 
                    `Average: ${data.ratings.average}/5 (${data.ratings.count} rating${data.ratings.count !== 1 ? 's' : ''})`
                    + (data.user_rating ? `<br><small>Your rating: ${data.user_rating}/5</small>` : '');

                // Highlight selected stars
                const stars = document.querySelectorAll('.star');
                stars.forEach((star, index) => {
                    star.classList.toggle('active', index < rating);
                });

                this.showToast('Rating saved successfully!', 'success');
            }

        } catch (error) {
            this.showToast(error.message, 'error');
        }
    }

    async generateReview(movieId) {
        if (!movieId) return;

        const reviewDiv = document.getElementById('reviewContent');
        this.showLoading(reviewDiv, 'Generating AI review...');

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
                reviewDiv.innerHTML = `<h4>AI-Generated Review:</h4><p>${this.escapeHtml(data.review)}</p>`;
            }

        } catch (error) {
            this.showError(reviewDiv, error.message);
        }
    }

    // Utility methods
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

    showLoading(element, message = 'Loading...') {
        element.innerHTML = `
            <div class="loading">
                <div class="spinner"></div>
                ${message}
            </div>
        `;
    }

    showError(element, message) {
        element.innerHTML = `<div class="error">Error: ${this.escapeHtml(message)}</div>`;
    }

    showSuccess(element, message) {
        element.innerHTML = `<div class="success">${this.escapeHtml(message)}</div>`;
    }

    showToast(message, type = 'info') {
        // Create toast element
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.textContent = message;

        // Add styles
        Object.assign(toast.style, {
            position: 'fixed',
            top: '20px',
            right: '20px',
            padding: '16px 20px',
            borderRadius: '8px',
            color: 'white',
            fontWeight: '600',
            zIndex: '10000',
            transform: 'translateX(400px)',
            transition: 'transform 0.3s ease',
            maxWidth: '300px',
            wordWrap: 'break-word'
        });

        // Set background color based on type
        const colors = {
            success: '#48bb78',
            error: '#f56565',
            warning: '#ed8936',
            info: '#4299e1'
        };
        toast.style.backgroundColor = colors[type] || colors.info;

        // Add to DOM
        document.body.appendChild(toast);

        // Animate in
        setTimeout(() => {
            toast.style.transform = 'translateX(0)';
        }, 100);

        // Remove after delay
        setTimeout(() => {
            toast.style.transform = 'translateX(400px)';
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        }, 3000);
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