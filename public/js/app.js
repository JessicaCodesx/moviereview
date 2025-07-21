
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
            resultsDiv.innerHTML = '<p>No movies found. Try a different search term.</p>';
            return;
        }

        resultsDiv.innerHTML = data.Search.map(movie => {
            const poster = movie.Poster !== 'N/A' ? movie.Poster : '/public/assets/images/no-image.png';
            return `
                <div class="movie-card" onclick="MovieApp.loadMovieDetails('${movie.imdbID}')">
                    <img src="${poster}" alt="${movie.Title}" onerror="this.src='/public/assets/images/no-image.png'">
                    <div class="movie-card-info">
                        <h3>${movie.Title}</h3>
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
            this.displayMovieDetails(movie);

        } catch (error) {
            this.showError(detailsDiv, error.message);
        }
    }

    displayMovieDetails(movie) {
        const detailsDiv = document.getElementById('movieDetails');
        const poster = movie.poster !== 'N/A' ? movie.poster : '/public/assets/images/no-image.png';

        detailsDiv.innerHTML = `
            <div class="movie-header">
                <div class="movie-poster">
                    <img src="${poster}" alt="${movie.title}">
                </div>
                <div class="movie-info">
                    <h2>${movie.title} (${movie.year})</h2>
                    <div class="movie-meta">
                        <span class="meta-item">📽️ ${movie.director}</span>
                        <span class="meta-item">🎭 ${movie.genre}</span>
                        <span class="meta-item">⏱️ ${movie.runtime}</span>
                        <span class="meta-item">⭐ IMDB: ${movie.rating}</span>
                    </div>
                    <p class="movie-plot">${movie.plot}</p>
                    <p><strong>Starring:</strong> ${movie.actors}</p>
                </div>
            </div>

            <div class="rating-section">
                <h3>Rate this movie</h3>
                <div class="rating-display">
                    <div class="stars">
                        ${[1,2,3,4,5].map(i => 
                            `<span class="star ${i <= (movie.user_rating || 0) ? 'active' : ''}" 
                                   data-rating="${i}" onclick="MovieApp.rateMovie(${i})">⭐</span>`
                        ).join('')}
                    </div>
                    <div class="rating-info" id="ratingInfo">
                        Average: ${movie.ratings.average}/5 (${movie.ratings.count} rating${movie.ratings.count !== 1 ? 's' : ''})
                    </div>
                </div>
            </div>

            <div class="review-section">
                <button onclick="MovieApp.generateReview(${movie.id})" class="btn">📝 Get AI Review</button>
                <div id="reviewContent" class="review-content"></div>
            </div>
        `;

        // Add hover effects to stars
        this.setupStarHoverEffects();
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
                document.getElementById('ratingInfo').innerHTML = 
                    `Average: ${data.ratings.average}/5 (${data.ratings.count} rating${data.ratings.count !== 1 ? 's' : ''})`;

                // Highlight selected stars
                const stars = document.querySelectorAll('.star');
                stars.forEach((star, index) => {
                    star.classList.toggle('active', index < rating);
                });
            }

        } catch (error) {
            this.showError(document.getElementById('ratingInfo'), error.message);
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
                reviewDiv.innerHTML = `<h4>AI-Generated Review:</h4><p>${data.review}</p>`;
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
        element.innerHTML = `<div class="error">Error: ${message}</div>`;
    }

    showSuccess(element, message) {
        element.innerHTML = `<div class="success">${message}</div>`;
    }
}

// Initialize the app
const MovieApp = new MovieApp();