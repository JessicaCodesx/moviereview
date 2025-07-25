<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Homepage</title>
</head>
<body>

<!-- Regal Hero Section -->
<div class="regal-hero-section">
    <div class="hero-background">
        <div class="hero-gradient"></div>
        <div class="hero-pattern"></div>
    </div>
    <div class="hero-content">
        <div class="hero-animation">
            <div class="hero-crown">👑</div>
            <div class="floating-elements">
                <span class="floating-element element-1">⭐</span>
                <span class="floating-element element-2">🎭</span>
                <span class="floating-element element-3">🎪</span>
                <span class="floating-element element-4">🎬</span>
                <span class="floating-element element-5">🍿</span>
            </div>
        </div>
        <div class="hero-text">
            <h1>Discover Cinematic Excellence</h1>
            <p>Your exclusive gateway to exceptional cinema. Curate, rate, and explore the finest films with our elite recommendation engine.</p>
        </div>
        <div class="hero-stats">
            <div class="stat-item">
                <span class="stat-number" data-count="10000">0</span>
                <span class="stat-label">Elite Films</span>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <span class="stat-number" data-count="5000">0</span>
                <span class="stat-label">Expert Reviews</span>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <span class="stat-number" data-count="1000">0</span>
                <span class="stat-label">Connoisseurs</span>
            </div>
        </div>
    </div>
</div>

                    <!-- Professional Search Section -->
                    <div class="regal-search-section">
                        <div class="search-container">
                            <div class="search-header">
                                <div class="search-icon-wrapper">
                                    <span class="search-icon">🔍</span>
                                </div>
                                <h2>Explore Our Cinematic Collection</h2>
                                <p>Search through our curated library of exceptional films, acclaimed directors, and renowned performers</p>
                            </div>
                            <div class="search-box">
                                    <div class="search-input-wrapper">
                                    <form onsubmit="return false;" style="display: contents;">
                                        <div class="search-field">
                                            <input type="text" 
                                                   id="searchInput" 
                                                   class="search-input" 
placeholder="Search for films"
                                                   value="<?php echo isset($search_query) ? htmlspecialchars($search_query) : ''; ?>"
                                                   autocomplete="off" />
                                            <button type="button" class="search-btn" aria-label="Search movies" onclick="performSearch()">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <circle cx="11" cy="11" r="8"></circle>
                                                    <path d="M21 21l-4.35-4.35"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </form>
                <div class="search-enhancement"></div>
            </div>
        </div>

        <!-- Search Results Container -->
        <div id="searchResults" class="search-results"></div>
    </div>
</div>

    <!-- Movie Details Container -->
    <div id="movieDetails" class="movie-details"></div>

    <!-- Recently Rated Films Section -->
    <div class="regal-recent-section">
      <div class="section-container">
        <div class="section-header">
          <div class="section-title">
            <div class="title-icon">🎯</div>
            <div class="title-content">
              <h3>Recently Rated Films</h3>
              <p class="section-subtitle">Fresh perspectives from our community</p>
            </div>
          </div>
          <!-- View All button removed -->
        </div>

        <!-- Recently Rated Movies Grid -->
        <div id="recentlyRatedMovies" class="recent-movies-grid">
          <div class="loading-state">
            <div class="spinner"></div>
            <p>Loading recently rated films...</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Popular Movies Section -->
    <div class="regal-popular-section">
      <div class="section-container">
        <div class="section-header">
          <div class="section-title">
            <div class="title-icon">⭐</div>
            <div class="title-content">
              <h3>Acclaimed Cinema</h3>
              <p class="section-subtitle">Films celebrated by our distinguished community</p>
            </div>
          </div>
          <div class="section-actions">
            <button class="category-btn active" data-category="all">All</button>
            <button class="category-btn" data-category="action">Action</button>
            <button class="category-btn" data-category="comedy">Comedy</button>
            <button class="category-btn" data-category="drama">Drama</button>
          </div>
        </div>

        <!-- Movie Grid -->
        <div class="popular-movies">
          <!-- Lilo & Stitch -->
          <div class="movie-card regal-movie-card" onclick="searchForMovie('Lilo Stitch')">
            <div class="movie-poster">
              <img src="/public/assets/images/lilo.jpg" alt="Lilo & Stitch" loading="lazy">
              <div class="movie-badge"><span class="avg-badge">⭐ 7.8</span></div>
              <div class="acclaim-indicator"><span class="acclaim-badge">Family Favorite</span></div>
              <div class="regal-frame"></div>
            </div>
            <div class="movie-card-info">
              <h4>Lilo &amp; Stitch</h4>
              <p>Animation • Family, Adventure</p>
              <div class="movie-stats">
                <span class="rating-count">900K reviews</span>
                <span class="popularity-score">92% loved</span>
              </div>
            </div>
          </div>

          <!-- Minecraft Movie -->
          <div class="movie-card regal-movie-card" onclick="searchForMovie('Minecraft Movie')">
            <div class="movie-poster">
              <img src="/public/assets/images/minecraft.jpg" alt="Minecraft Movie" loading="lazy">
              <div class="movie-badge"><span class="avg-badge">⭐ 7.4</span></div>
              <div class="acclaim-indicator"><span class="acclaim-badge">Popular</span></div>
              <div class="regal-frame"></div>
            </div>
            <div class="movie-card-info">
              <h4>Minecraft Movie</h4>
              <p>Adventure • Family, Gaming</p>
              <div class="movie-stats">
                <span class="rating-count">800K reviews</span>
                <span class="popularity-score">90% box‑office</span>
              </div>
            </div>
          </div>

          <!-- Mission: Impossible -->
          <div class="movie-card regal-movie-card" onclick="searchForMovie('Mission Impossible')">
            <div class="movie-poster">
              <img src="/public/assets/images/mission.jpeg" alt="Mission: Impossible" loading="lazy">
              <div class="movie-badge"><span class="avg-badge">⭐ 8.3</span></div>
              <div class="acclaim-indicator"><span class="acclaim-badge">Action Packed</span></div>
              <div class="regal-frame"></div>
            </div>
            <div class="movie-card-info">
              <h4>Mission: Impossible</h4>
              <p>Action • Thriller, Spy</p>
              <div class="movie-stats">
                <span class="rating-count">950K reviews</span>
                <span class="popularity-score">94% critics</span>
              </div>
            </div>
          </div>

          <!-- Titanic -->
          <div class="movie-card regal-movie-card" onclick="searchForMovie('Titanic')">
            <div class="movie-poster">
              <img src="/public/assets/images/titanic.png" alt="Titanic" loading="lazy">
              <div class="movie-badge"><span class="avg-badge">⭐ 9.0</span></div>
              <div class="acclaim-indicator"><span class="acclaim-badge">Romantic Epic</span></div>
              <div class="regal-frame"></div>
            </div>
            <div class="movie-card-info">
              <h4>Titanic</h4>
              <p>Drama • Romance, Historical</p>
              <div class="movie-stats">
                <span class="rating-count">1.2M reviews</span>
                <span class="popularity-score">97% audience</span>
              </div>
            </div>
          </div>

          <!-- The Bee Movie -->
          <div class="movie-card regal-movie-card" onclick="searchForMovie('Bee Movie')">
            <div class="movie-poster">
              <img src="/public/assets/images/bee.jpg" alt="The Bee Movie" loading="lazy">
              <div class="movie-badge"><span class="avg-badge">⭐ 6.5</span></div>
              <div class="acclaim-indicator"><span class="acclaim-badge">Cult Classic</span></div>
              <div class="regal-frame"></div>
            </div>
            <div class="movie-card-info">
              <h4>The Bee Movie</h4>
              <p>Animation • Comedy, Family</p>
              <div class="movie-stats">
                <span class="rating-count">500K reviews</span>
                <span class="popularity-score">80% internet icon</span>
              </div>
            </div>
          </div>

          <!-- The Godfather -->
          <div class="movie-card regal-movie-card" onclick="searchForMovie('The Godfather')">
            <div class="movie-poster">
              <img src="/public/assets/images/godfather.jpg" alt="The Godfather" loading="lazy">
              <div class="movie-badge"><span class="avg-badge">⭐ 9.2</span></div>
              <div class="acclaim-indicator"><span class="acclaim-badge">Masterpiece</span></div>
              <div class="regal-frame"></div>
            </div>
            <div class="movie-card-info">
              <h4>The Godfather</h4>
              <p>Crime • Drama, Mafia</p>
              <div class="movie-stats">
                <span class="rating-count">2M reviews</span>
                <span class="popularity-score">99% critics</span>
              </div>
            </div>
          </div>

        </div> <!-- /popular-movies -->
      </div>
    </div>




<style>
/* Professional Regal Homepage Styles - WIDER LAYOUT */
:root {
    --regal-primary: #1a1f3a;
    --regal-secondary: #0f1419;
    --regal-accent: #daa520;
    --regal-accent-light: #f4d03f;
    --regal-text: #ffffff;
    --regal-text-muted: rgba(255, 255, 255, 0.7);
    --regal-border: rgba(218, 165, 32, 0.3);
    --regal-backdrop: rgba(26, 31, 58, 0.6);
    --regal-glass: rgba(26, 31, 58, 0.8);
}

* {
    box-sizing: border-box;
}

body {
    margin: 0;
    padding: 0;
    background: linear-gradient(135deg, var(--regal-secondary) 0%, var(--regal-primary) 100%);
    min-height: 100vh;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
}

/* Regal Hero Section - WIDER */
.regal-hero-section {
    position: relative;
    padding: 80px 0 60px;
    text-align: center;
    overflow: hidden;
    margin-bottom: 40px;
}

.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: -1;
}

.hero-gradient {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(ellipse at center, rgba(218, 165, 32, 0.15), transparent);
}

.hero-pattern {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: 
        radial-gradient(circle at 20% 50%, rgba(218, 165, 32, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(218, 165, 32, 0.05) 0%, transparent 50%),
        radial-gradient(circle at 40% 80%, rgba(218, 165, 32, 0.08) 0%, transparent 50%);
}

.hero-content {
    position: relative;
    z-index: 2;
    max-width: 1200px; /* INCREASED from 800px */
    margin: 0 auto;
    padding: 0 40px; /* INCREASED from 20px */
}

.hero-animation {
    position: relative;
    margin-bottom: 40px;
}

.hero-crown {
    font-size: 4rem;
    margin-bottom: 20px;
    filter: drop-shadow(0 4px 12px rgba(218, 165, 32, 0.4));
    animation: crownFloat 6s ease-in-out infinite;
}

@keyframes crownFloat {
    0%, 100% { 
        transform: translateY(0px) rotate(0deg); 
        filter: drop-shadow(0 4px 12px rgba(218, 165, 32, 0.4));
    }
    50% { 
        transform: translateY(-8px) rotate(2deg); 
        filter: drop-shadow(0 8px 20px rgba(218, 165, 32, 0.6));
    }
}

.floating-elements {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 300px;
    height: 300px;
    pointer-events: none;
}

.floating-element {
    position: absolute;
    font-size: 1.5rem;
    opacity: 0.7;
    animation: float 8s ease-in-out infinite;
}

.element-1 { top: 20%; left: 10%; animation-delay: 0s; }
.element-2 { top: 30%; right: 10%; animation-delay: 1s; }
.element-3 { bottom: 30%; left: 15%; animation-delay: 2s; }
.element-4 { bottom: 20%; right: 15%; animation-delay: 3s; }
.element-5 { top: 50%; left: 5%; animation-delay: 4s; }

@keyframes float {
    0%, 100% { transform: translateY(0px); opacity: 0.7; }
    50% { transform: translateY(-20px); opacity: 1; }
}

.hero-text h1 {
    font-size: 3.5rem;
    font-weight: 800;
    color: var(--regal-accent);
    margin-bottom: 20px;
    text-shadow: 
        0 4px 8px rgba(0, 0, 0, 0.5),
        0 0 30px rgba(218, 165, 32, 0.3);
    letter-spacing: -0.02em;
    line-height: 1.1;
}

.hero-text p {
    font-size: 1.3rem;
    color: var(--regal-text-muted);
    margin-bottom: 40px;
    line-height: 1.6;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    max-width: 800px; /* INCREASED from 600px */
    margin-left: auto;
    margin-right: auto;
}

.hero-stats {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 30px;
    margin-top: 40px;
    padding: 30px 40px; /* INCREASED padding */
    background: var(--regal-glass);
    backdrop-filter: blur(20px);
    border-radius: 25px;
    border: 2px solid var(--regal-border);
    box-shadow: 
        0 10px 30px rgba(0, 0, 0, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.1);
    max-width: 900px; /* INCREASED from none */
    margin-left: auto;
    margin-right: auto;
}

.stat-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--regal-accent);
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.stat-label {
    font-size: 0.95rem;
    color: var(--regal-text-muted);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.stat-divider {
    width: 1px;
    height: 40px;
    background: linear-gradient(to bottom, transparent, var(--regal-border), transparent);
}

    /* Professional Search Section - MUCH WIDER */
    .regal-search-section {
        margin-bottom: 60px;
        padding: 0 20px; /* Add padding to the section itself */
    }

.search-container {
    max-width: 2000px; /* INCREASED from 1400px - EXTRA WIDE */
    margin: 0 auto;
    padding: 0 60px; /* INCREASED from 40px */
    background: transparent; /* Ensure no white background */
}


.search-header {
    text-align: center;
    margin-bottom: 40px;
    background: transparent; /* Ensure no white background */
}

.search-icon-wrapper {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 100px;
    height: 60px;
    background: linear-gradient(135deg, var(--regal-accent), var(--regal-accent-light));
    border-radius: 50%;
    margin-bottom: 20px;
    box-shadow: 
        0 8px 25px rgba(218, 165, 32, 0.4),
        inset 0 1px 0 rgba(255, 255, 255, 0.2);
}

.search-icon {
    font-size: 3rem;
    color: var(--regal-primary);
}

.search-header h2 {
    font-size: 2.2rem;
    font-weight: 700;
    color: var(--regal-accent);
    margin-bottom: 15px;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
}

.search-header p {
    font-size: 1.1rem;
    color: rgba(255, 255, 255, 0.8);
    line-height: 1.6;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
}

.search-box {
    background: rgba(26, 31, 58, 0.8); /* Dark semi-transparent background */
    backdrop-filter: blur(25px);
    border-radius: 25px;
    padding: 40px; /* INCREASED from 30px */
    border: 2px solid var(--regal-border);
    box-shadow: 
        0 15px 35px rgba(0, 0, 0, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.1);
    position: relative;
}

    .search-input-wrapper {
        position: relative;
        margin-bottom: 25px;
        width: 100%; /* Ensure full width */
    }

    .search-field {
        position: relative;
        display: flex;
        align-items: center;
        background: rgba(0, 0, 0, 0.2);
        border: 2px solid var(--regal-border);
        border-radius: 20px;
        padding: 16px; /* INCREASED from 12px */
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
        width: 100%; /* Ensure full width */
        /* Removed max-width to allow full stretch */
        /* Removed margin auto */
    }

.search-field:focus-within {
    border-color: var(--regal-accent);
    box-shadow: 
        0 0 0 4px rgba(218, 165, 32, 0.2),
        0 8px 25px rgba(218, 165, 32, 0.3);
    transform: translateY(-2px);
}

/* Specific override for this page's search input */
.regal-search-section .search-input {
    flex: 1;
    background: rgba(0, 0, 0, 0.3);
    border: none;
    padding: 20px 24px; /* INCREASED from 16px 20px - MAJOR CHANGE */
    font-size: 1.2rem; /* INCREASED from 1.1rem */
    color: #ffffff !important;
    font-weight: 500;
    outline: none;
    border-radius: 12px;
    -webkit-text-fill-color: #ffffff !important; /* Force white text in webkit browsers */
}

/* Additional fix for autofill styling */
.regal-search-section .search-input:-webkit-autofill,
.regal-search-section .search-input:-webkit-autofill:hover,
.regal-search-section .search-input:-webkit-autofill:focus,
.regal-search-section .search-input:-webkit-autofill:active {
    -webkit-text-fill-color: #ffffff !important;
    -webkit-box-shadow: 0 0 0 30px rgba(0, 0, 0, 0.3) inset !important;
    box-shadow: 0 0 0 30px rgba(0, 0, 0, 0.3) inset !important;
    background-color: transparent !important;
    color: #ffffff !important;
}

/* Override placeholder color as well */
.regal-search-section .search-input::placeholder {
    color: rgba(255, 255, 255, 0.6) !important;
    opacity: 1;
}

.search-btn {
    background: linear-gradient(135deg, var(--regal-accent), var(--regal-accent-light));
    border: none;
    border-radius: 12px;
    width: 56px; /* INCREASED from 48px */
    height: 56px; /* INCREASED from 48px */
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--regal-primary);
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 
        0 4px 12px rgba(218, 165, 32, 0.4),
        inset 0 1px 0 rgba(255, 255, 255, 0.2);
    margin-left: 12px; /* INCREASED from 8px */
}

.search-btn:hover {
    transform: scale(1.05) translateY(-1px);
    box-shadow: 
        0 8px 25px rgba(218, 165, 32, 0.6),
        inset 0 1px 0 rgba(255, 255, 255, 0.3);
}

.search-btn:active {
    transform: scale(0.98);
    box-shadow: 
        0 2px 8px rgba(218, 165, 32, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.2);
}

.search-enhancement {
    position: absolute;
    bottom: -2px;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 2px;
    background: linear-gradient(90deg, transparent, var(--regal-accent), transparent);
    border-radius: 1px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.search-field:focus-within + .search-enhancement {
    opacity: 1;
}


/* Section Containers - WIDER */
.regal-popular-section {
    margin-bottom: 60px;
}

.section-container {
    max-width: 1600px; /* INCREASED from 1200px - MAJOR CHANGE */
    margin: 0 auto;
    padding: 40px; /* INCREASED from 40px 20px */
    background: var(--regal-glass);
    backdrop-filter: blur(25px);
    border-radius: 25px;
    border: 2px solid var(--regal-border);
    box-shadow: 
        0 15px 35px rgba(0, 0, 0, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.1);
    position: relative;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 40px; /* INCREASED from 30px */
}

.section-title {
    display: flex;
    align-items: center;
    gap: 15px;
}

.title-icon {
    font-size: 2rem;
    filter: drop-shadow(0 2px 4px rgba(218, 165, 32, 0.3));
}

.title-content h3 {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--regal-accent);
    margin: 0 0 5px 0;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.section-subtitle {
    color: var(--regal-text-muted);
    font-size: 1rem;
    margin: 0;
    line-height: 1.5;
}

/* Movie Cards - IMPROVED GRID */
.popular-movies {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); /* INCREASED from 220px */
    gap: 30px; /* INCREASED from 25px */
}

@media (min-width: 1400px) {
    .popular-movies {
        grid-template-columns: repeat(6, 1fr); /* FORCE 6 columns on large screens */
    }
}

@media (max-width: 1200px) {
    .popular-movies {
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 25px;
    }
}

@media (max-width: 768px) {
    .popular-movies {
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 20px;
    }

    .search-container,
    .section-container {
        padding: 20px;
    }

    .hero-content {
        padding: 0 20px;
    }
}

@media (max-width: 480px) {
    .popular-movies {
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }
}

.movie-card {
    background: var(--regal-glass);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 
        0 10px 30px rgba(0, 0, 0, 0.3),
        0 2px 8px rgba(0, 0, 0, 0.2);
    transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
    cursor: pointer;
    position: relative;
    border: 2px solid var(--regal-border);
}

.movie-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 
        0 20px 40px rgba(0, 0, 0, 0.3),
        0 8px 20px rgba(218, 165, 32, 0.2);
    border-color: var(--regal-border);
}

.movie-poster {
    position: relative;
    height: 320px; /* INCREASED from 300px */
    overflow: hidden;
}

.movie-poster img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.movie-card:hover .movie-poster img {
    transform: scale(1.05);
}

.regal-frame {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    border: 3px solid var(--regal-accent);
    opacity: 0;
    transition: opacity 0.3s ease;
    pointer-events: none;
}

.movie-card:hover .regal-frame {
    opacity: 0.7;
}

.movie-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(26, 31, 58, 0.85) 0%, rgba(218, 165, 32, 0.2) 100%);
    backdrop-filter: blur(8px);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    transform: scale(0.95);
}

.movie-card:hover .movie-overlay {
    opacity: 1;
    transform: scale(1);
}

.play-button {
    background: var(--regal-accent);
    border: none;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--regal-primary);
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(218, 165, 32, 0.4);
}

.play-button:hover {
    transform: scale(1.1);
    box-shadow: 0 8px 25px rgba(218, 165, 32, 0.6);
}

.movie-badge {
    position: absolute;
    top: 12px;
    right: 12px;
}

.avg-badge {
    background: rgba(0, 0, 0, 0.8);
    color: var(--regal-accent);
    padding: 6px 12px;
    border-radius: 15px;
    font-size: 0.85rem;
    font-weight: 700;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(218, 165, 32, 0.3);
}

.acclaim-indicator {
    position: absolute;
    top: 12px;
    left: 12px;
}

.acclaim-badge {
    background: linear-gradient(135deg, var(--regal-accent), var(--regal-accent-light));
    color: var(--regal-primary);
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.movie-card-info {
    padding: 20px;
    text-align: center;
    background: rgba(26, 31, 58, 0.6);
}

.movie-card-info h4 {
    font-size: 1rem;
    font-weight: 700;
    color: var(--regal-accent);
    margin-bottom: 8px;
    line-height: 1.3;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.movie-card-info p {
    color: var(--regal-text-muted);
    font-size: 0.85rem;
    margin-bottom: 10px;
}

.movie-stats {
    display: flex;
    justify-content: space-between;
    gap: 10px;
    font-size: 0.75rem;
}

.rating-count,
.popularity-score {
    color: rgba(218, 165, 32, 0.7);
    font-weight: 500;
}

/* Category Buttons */
.section-actions {
    display: flex;
    gap: 8px;
}

.category-btn {
    background: rgba(218, 165, 32, 0.1);
    color: var(--regal-accent);
    border: 1px solid var(--regal-border);
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.category-btn:hover,
.category-btn.active {
    background: var(--regal-accent);
    color: var(--regal-primary);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(218, 165, 32, 0.3);
}

/* Search Results Styling */
.search-results {
    margin-top: 40px;
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.6s ease;
    background: var(--regal-glass);
    backdrop-filter: blur(25px);
    border-radius: 25px;
    padding: 40px;
    border: 2px solid var(--regal-border);
    box-shadow: 
        0 15px 35px rgba(0, 0, 0, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.1);
}

.search-results.show {
    opacity: 1;
    transform: translateY(0);
}

.results-header {
    text-align: center;
    margin-bottom: 30px;
    padding: 20px;
    background: var(--regal-glass);
    backdrop-filter: blur(25px);
    border-radius: 20px;
    border: 2px solid var(--regal-border);
}

.results-header h3 {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--regal-accent);
    margin-bottom: 10px;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.results-header p {
    color: var(--regal-text-muted);
    font-size: 1rem;
    margin: 0;
}

.movies-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 30px;
    padding: 20px 0;
}

/* Loading and No Results States */
.loading-state {
    text-align: center;
    padding: 60px 20px;
    color: var(--regal-text-muted);
}

.spinner {
    width: 40px;
    height: 40px;
    border: 4px solid rgba(218, 165, 32, 0.2);
    border-left-color: var(--regal-accent);
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto 20px;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

.no-results {
    text-align: center;
    padding: 60px 40px;
    color: var(--regal-text-muted);
}

.no-results-icon {
    font-size: 3rem;
    margin-bottom: 20px;
    opacity: 0.7;
}

.no-results h3 {
    font-size: 1.5rem;
    color: var(--regal-accent);
    margin-bottom: 15px;
}

.no-results p {
    font-size: 1rem;
    line-height: 1.6;
    max-width: 400px;
    margin: 0 auto;
}

/* Overlay Button Styling */
.overlay-btn {
    background: linear-gradient(135deg, var(--regal-accent), var(--regal-accent-light));
    border: 2px solid rgba(255, 255, 255, 0.2);
    border-radius: 30px;
    padding: 12px 28px;
    display: flex;
    align-items: center;
    gap: 10px;
    color: var(--regal-primary);
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 
        0 4px 15px rgba(218, 165, 32, 0.5),
        inset 0 1px 0 rgba(255, 255, 255, 0.3);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    backdrop-filter: blur(10px);
    transform: scale(0.9);
    opacity: 0.9;
}

.overlay-btn:hover {
    background: linear-gradient(135deg, var(--regal-accent-light), var(--regal-accent));
    transform: scale(1);
    opacity: 1;
    box-shadow: 
        0 8px 25px rgba(218, 165, 32, 0.6),
        inset 0 1px 0 rgba(255, 255, 255, 0.4),
        0 0 30px rgba(218, 165, 32, 0.4);
    border-color: rgba(255, 255, 255, 0.3);
}

.overlay-btn:active {
    transform: scale(0.95);
    box-shadow: 
        0 2px 8px rgba(218, 165, 32, 0.4),
        inset 0 1px 0 rgba(255, 255, 255, 0.2);
}

.overlay-btn svg {
    width: 20px;
    height: 20px;
    stroke: var(--regal-primary);
    stroke-width: 2.5;
    filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.2));
    transition: transform 0.3s ease;
}

.overlay-btn:hover svg {
    transform: rotate(5deg) scale(1.1);
}

.overlay-btn span {
    font-size: 0.9rem;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
}


    /* Recently Rated Section Styles */
    .regal-recent-section {
        margin-bottom: 60px;
    }

    .recent-movies-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 30px;
    }

    @media (max-width: 1200px) {
        .recent-movies-grid {
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        }
    }

    @media (max-width: 768px) {
        .recent-movies-grid {
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 20px;
        }
    }

    @media (max-width: 480px) {
        .recent-movies-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
    }

    .recent-movie-card {
        background: var(--regal-glass);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 
            0 10px 30px rgba(0, 0, 0, 0.3),
            0 2px 8px rgba(0, 0, 0, 0.2);
        transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
        cursor: pointer;
        position: relative;
        border: 2px solid var(--regal-border);
    }

    .recent-movie-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 
            0 20px 40px rgba(0, 0, 0, 0.3),
            0 8px 20px rgba(218, 165, 32, 0.2);
        border-color: var(--regal-accent);
    }

    .recent-rating-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        background: linear-gradient(135deg, var(--regal-accent), var(--regal-accent-light));
        color: var(--regal-primary);
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 1.1rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 4px;
        box-shadow: 0 4px 12px rgba(218, 165, 32, 0.4);
    }

    .time-badge {
        position: absolute;
        bottom: 12px;
        left: 12px;
        background: rgba(0, 0, 0, 0.8);
        color: var(--regal-text-muted);
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 0.75rem;
        backdrop-filter: blur(10px);
    }

    .view-all-btn {
        background: transparent;
        color: var(--regal-accent);
        border: 2px solid var(--regal-border);
        padding: 10px 24px;
        border-radius: 25px;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .view-all-btn:hover {
        background: var(--regal-accent);
        color: var(--regal-primary);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(218, 165, 32, 0.4);
    }

    .rating-note {
        margin-top: 10px;
        font-size: 0.85rem;
        color: var(--regal-text-muted);
        font-style: italic;
    }

    .rating-note a {
        color: var(--regal-accent);
        text-decoration: none;
        font-weight: 600;
        transition: opacity 0.3s ease;
    }

    .rating-note a:hover {
        opacity: 0.8;
        text-decoration: underline;
    }

/* Animation classes */
.animate-card {
    opacity: 0;
    transform: translateY(20px);
    animation: slideInUp 0.6s ease forwards;
}

@keyframes slideInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Performance optimizations */
@media (prefers-reduced-motion: reduce) {
    *, *::before, *::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
}

    /* Enhanced Search Section Visual Design */
    @media (min-width: 768px) {
        .regal-search-section {
            position: relative;
            overflow: hidden;
        }

        /* Animated background gradient */
        .regal-search-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(218, 165, 32, 0.12), transparent 40%),
                radial-gradient(circle at 80% 20%, rgba(99, 102, 241, 0.08), transparent 40%),
                radial-gradient(circle at 60% 60%, rgba(30, 58, 95, 0.05), transparent 50%);
            animation: rotateGradient 30s linear infinite;
            pointer-events: none;
            z-index: 0;
        }

        @keyframes rotateGradient {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .search-container {
            position: relative;
            z-index: 1;
        }

        /* Enhanced search header animations */
        .search-header {
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Enhanced icon wrapper */
        .search-icon-wrapper {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #daa520, #f4d03f);
            box-shadow: 
                0 10px 30px rgba(218, 165, 32, 0.5),
                inset 0 2px 4px rgba(255, 255, 255, 0.3),
                0 0 80px rgba(218, 165, 32, 0.3);
            position: relative;
            animation: iconPulse 3s ease-in-out infinite;
        }

        @keyframes iconPulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 
                    0 10px 30px rgba(218, 165, 32, 0.5),
                    inset 0 2px 4px rgba(255, 255, 255, 0.3),
                    0 0 80px rgba(218, 165, 32, 0.3);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 
                    0 15px 40px rgba(218, 165, 32, 0.6),
                    inset 0 2px 4px rgba(255, 255, 255, 0.4),
                    0 0 100px rgba(218, 165, 32, 0.4);
            }
        }

        /* Sparkle effect */
        .search-icon-wrapper::after {
            content: '✨';
            position: absolute;
            top: -10px;
            right: -10px;
            font-size: 1.5rem;
            animation: sparkle 2s ease-in-out infinite;
        }

        @keyframes sparkle {
            0%, 100% { 
                opacity: 0;
                transform: scale(0.5) rotate(0deg);
            }
            50% { 
                opacity: 1;
                transform: scale(1) rotate(180deg);
            }
        }

        /* Enhanced search box */
        .search-box {
            background: rgba(26, 31, 58, 0.85) !important; /* Force dark background */
            backdrop-filter: blur(30px) saturate(150%);
            border-radius: 30px;
            padding: 50px;
            box-shadow: 
                0 20px 60px rgba(0, 0, 0, 0.4),
                inset 0 2px 4px rgba(255, 255, 255, 0.1),
                0 0 120px rgba(218, 165, 32, 0.15);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            animation: slideIn 0.8s ease-out 0.3s both;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(40px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .search-box:hover {
            box-shadow: 
                0 25px 70px rgba(0, 0, 0, 0.45),
                inset 0 2px 4px rgba(255, 255, 255, 0.15),
                0 0 140px rgba(218, 165, 32, 0.2);
            transform: translateY(-2px);
        }

        /* Enhanced search field */
        .search-field {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.25));
            border-radius: 25px;
            padding: 20px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 
                inset 0 2px 8px rgba(0, 0, 0, 0.3),
                0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .search-field:focus-within {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.3));
            box-shadow: 
                0 0 0 4px rgba(218, 165, 32, 0.3),
                0 12px 35px rgba(218, 165, 32, 0.4),
                inset 0 2px 12px rgba(0, 0, 0, 0.3),
                0 0 60px rgba(218, 165, 32, 0.25);
            transform: translateY(-3px) scale(1.01);
        }

        /* Enhanced search button */
        .search-btn {
            width: 64px;
            height: 64px;
            border-radius: 18px;
            background: linear-gradient(135deg, #daa520, #f4d03f);
            box-shadow: 
                0 6px 20px rgba(218, 165, 32, 0.5),
                inset 0 2px 4px rgba(255, 255, 255, 0.3),
                0 0 30px rgba(218, 165, 32, 0.25);
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Shimmer effect */
        .search-btn::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                45deg, 
                transparent 30%, 
                rgba(255, 255, 255, 0.4) 50%, 
                transparent 70%
            );
            transform: rotate(45deg) translateX(-100%);
            transition: transform 0.6s;
        }

        .search-btn:hover {
            transform: scale(1.1) translateY(-2px);
            box-shadow: 
                0 10px 35px rgba(218, 165, 32, 0.6),
                inset 0 2px 4px rgba(255, 255, 255, 0.4),
                0 0 40px rgba(218, 165, 32, 0.35);
            background: linear-gradient(135deg, #f4d03f, #daa520);
        }

        .search-btn:hover::before {
            transform: rotate(45deg) translateX(100%);
        }

        .search-btn:hover svg {
            transform: scale(1.1);
        }

        .search-btn:active {
            transform: scale(0.96);
            box-shadow: 
                0 2px 8px rgba(218, 165, 32, 0.3),
                inset 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .search-btn svg {
            transition: transform 0.3s ease;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
        }

        /* Enhanced search enhancement line */
        .search-enhancement {
            bottom: -3px;
            width: 100px;
            height: 3px;
            background: linear-gradient(90deg, transparent, #daa520, transparent);
            border-radius: 2px;
            opacity: 0;
            transition: all 0.3s ease;
            filter: blur(1px);
            box-shadow: 0 0 15px #daa520;
        }

        .search-field:focus-within + .search-enhancement {
            opacity: 1;
            width: 150px;
            filter: blur(0);
        }


        /* Add floating particles animation */
        .search-box::before,
        .search-box::after {
            content: '';
            position: absolute;
            width: 4px;
            height: 4px;
            background: #daa520;
            border-radius: 50%;
            opacity: 0.6;
            animation: float-particle 10s infinite;
        }

        .search-box::before {
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .search-box::after {
            top: 80%;
            right: 10%;
            animation-delay: 5s;
        }

        @keyframes float-particle {
            0%, 100% {
                transform: translate(0, 0) scale(1);
                opacity: 0.6;
            }
            25% {
                transform: translate(30px, -30px) scale(1.2);
                opacity: 0.8;
            }
            50% {
                transform: translate(-20px, -50px) scale(0.8);
                opacity: 0.4;
            }
            75% {
                transform: translate(-40px, -20px) scale(1.1);
                opacity: 0.7;
            }
        }
    }

    /* Mobile optimizations */
    @media (max-width: 767px) {
        .search-icon-wrapper {
            width: 80px;
            height: 80px;
        }

        .search-box {
            padding: 30px 20px;
        }

        .search-field {
            padding: 14px;
        }

        .search-btn {
            width: 50px;
            height: 50px;
        }

    }

</style>

<script>
// Define all functions in global scope
console.log('Movie page script loading...');

// Movie App Instance - Check if already exists from app.js
if (typeof window.movieAppInstance === 'undefined') {
    console.log('Creating fallback movieAppInstance');
    // Fallback movie app instance if main app.js is not loaded
    window.movieAppInstance = {
        loadMovieDetails: function(imdbId) {
            console.log('Loading movie details for:', imdbId);
            // Your existing movie details functionality
        },

        showToast: function(message, type) {
            console.log(`Toast [${type}]:`, message);
            // Your existing toast functionality
        }
    };
} else {
    console.log('Using existing movieAppInstance from app.js');
}

async function performSearch() {
    const searchInput = document.getElementById('searchInput');
    const searchBtn = document.querySelector('.search-btn');
    const searchResults = document.getElementById('searchResults');

    if (!searchInput || !searchInput.value.trim()) {
        return;
    }

    const query = searchInput.value.trim();

    // Show loading state
    searchBtn.innerHTML = `
        <div class="spinner" style="width: 20px; height: 20px; border-width: 2px;"></div>
    `;
    searchBtn.disabled = true;

    try {
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
                displaySearchResults(data.Search, query);
            } else if (data.Response === 'False') {
                displayNoResults(query, data.Error);
            } else {
                displayError('Unexpected response format');
            }
        } catch (error) {
            console.error('Search error:', error);
            displayError('Failed to search movies. Please try again.');
        } finally {
            // Restore search button
            searchBtn.innerHTML = `
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="21 21l-4.35-4.35"></path>
                </svg>
            `;
            searchBtn.disabled = false;
        }
    }

function displaySearchResults(results, query) {
    const searchResults = document.getElementById('searchResults');

    if (!results || results.length === 0) {
        displayNoResults(query);
        return;
    }

    const resultsHTML = `
        <div class="results-header">
            <h3>Search Results</h3>
            <p>Found ${results.length} films matching "${query}"</p>
        </div>
        <div class="movies-grid">
            ${results.map(movie => {
                // Handle both API response formats (OMDB and database)
                const imdbId = movie.imdbID || movie.imdb_id || movie.imdbId;
                const title = movie.Title || movie.title;
                const year = movie.Year || movie.year;
                const poster = movie.Poster || movie.poster;
                const type = movie.Type || movie.type || 'movie';
                const avgRating = movie.avg_rating ? parseFloat(movie.avg_rating).toFixed(1) : null;

                return `
                <div class="movie-card" onclick="loadMovieDetails('${imdbId}')">
                    <div class="movie-poster">
                        <img src="${poster && poster !== 'N/A' ? poster : '/public/assets/images/no-image.png'}" 
                             alt="${title}" 
                             onerror="this.src='/public/assets/images/no-image.png'"
                             loading="lazy">
                        ${avgRating ? `<div class="movie-badge"><span class="avg-badge">⭐ ${avgRating}</span></div>` : ''}
                        <div class="movie-overlay">
                            <button class="overlay-btn">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="8" x2="12" y2="12"></line>
                                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                </svg>
                                <span>View Details</span>
                            </button>
                        </div>
                        <div class="regal-frame"></div>
                    </div>
                    <div class="movie-card-info">
                        <h4>${title}</h4>
                        <p>${year} • <span class="movie-type">${type}</span></p>
                    </div>
                </div>
                `;
            }).join('')}
        </div>
    `;

    searchResults.innerHTML = resultsHTML;
    searchResults.classList.add('show');

    // Scroll to results
    searchResults.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

    function displayNoResults(query, error = null) {
        const searchResults = document.getElementById('searchResults');

        const errorMessage = error || `We couldn't find any films matching "${query}". Try searching with different keywords or check the spelling.`;

        searchResults.innerHTML = `
            <div class="no-results">
                <div class="no-results-icon">🎭</div>
                <h3>No Films Found</h3>
                <p>${errorMessage}</p>
            </div>
        `;

        searchResults.classList.add('show');
    }

function displayError(message) {
    const searchResults = document.getElementById('searchResults');

    searchResults.innerHTML = `
        <div class="no-results">
            <div class="no-results-icon">⚠️</div>
            <h3>Search Error</h3>
            <p>${message}</p>
        </div>
    `;

    searchResults.classList.add('show');
}

function loadMovieDetails(imdbId) {
    console.log('Loading details for movie:', imdbId);
    if (window.movieAppInstance && typeof window.movieAppInstance.loadMovieDetails === 'function') {
        window.movieAppInstance.loadMovieDetails(imdbId);
    } else {
        console.warn('movieAppInstance not available, redirecting to movie details page');
        window.location.href = `/movie/${imdbId}`;
    }
}

// Enhanced Statistics Counter Animation
function animateCounters() {
    const counters = document.querySelectorAll('.stat-number[data-count]');

    counters.forEach(counter => {
        const target = parseInt(counter.dataset.count);
        const duration = 2000; // 2 seconds
        const step = target / (duration / 16); // 60fps
        let current = 0;

        const timer = setInterval(() => {
            current += step;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }

            // Format number with commas
            counter.textContent = Math.floor(current).toLocaleString();
        }, 16);
    });
}


// Enhanced search input event listeners
function setupSearchFunctionality() {
    const searchInput = document.getElementById('searchInput');

    if (searchInput) {
        // Enter key search
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });

        // Auto-focus on larger screens
        if (window.innerWidth > 768) {
            setTimeout(() => {
                searchInput.focus();
            }, 1000);
        }
    }
}

// Category button functionality
function setupCategoryButtons() {
    const categoryBtns = document.querySelectorAll('.category-btn');

    categoryBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from all buttons
            categoryBtns.forEach(b => b.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');

            console.log('Filter by category:', this.dataset.category);
        });
    });
}

// Search for a specific movie by title
function searchForMovie(title) {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.value = title;
        performSearch();
    }
}

// Load recently rated movies
async function loadRecentlyRatedMovies() {
    console.log('Loading recently rated movies...');
    const container = document.getElementById('recentlyRatedMovies');
    if (!container) {
        console.error('Recently rated movies container not found');
        return;
    }

    try {
        console.log('Fetching from /api/ratings/recent?limit=5');
        const response = await fetch('/api/ratings/recent?limit=5', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        console.log('Response status:', response.status);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        console.log('Response data:', data);

        if (data.success && data.movies && data.movies.length > 0) {
            console.log('Displaying', data.movies.length, 'movies');
            displayRecentlyRatedMovies(data.movies);
        } else {
            console.log('No movies to display');
            displayNoRecentRatings();
        }
    } catch (error) {
        console.error('Error loading recently rated movies:', error);
        displayRecentRatingsError();
    }
}

function displayRecentlyRatedMovies(movies) {
    const container = document.getElementById('recentlyRatedMovies');

    const moviesHTML = movies.map((movie, index) => {
        const poster = movie.poster && movie.poster !== 'N/A' ? movie.poster : '/public/assets/images/no-image.png';
        const avgRating = movie.avg_rating ? parseFloat(movie.avg_rating).toFixed(1) : 'N/A';
        const ratingDate = movie.rated_at ? formatTimeAgo(movie.rated_at) : 'Recently';

        return `
            <div class="recent-movie-card animate-card" style="animation-delay: ${index * 0.1}s;" onclick="loadMovieDetails('${movie.imdb_id}')">
                <div class="movie-poster">
                    <img src="${poster}" 
                         alt="${movie.title}" 
                         onerror="this.src='/public/assets/images/no-image.png'"
                         loading="lazy">
                    <div class="recent-rating-badge">
                        <span>⭐ ${avgRating}</span>
                    </div>
                    <div class="time-badge">${ratingDate}</div>
                    <div class="movie-overlay">
                        <button class="overlay-btn">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                            <span>View Details</span>
                        </button>
                    </div>
                    <div class="regal-frame"></div>
                </div>
                <div class="movie-card-info">
                    <h4>${movie.title}</h4>
                    <p>${movie.year} • ${movie.genre ? movie.genre.split(',')[0] : 'Movie'}</p>
                    <div class="movie-stats">
                        <span class="rating-count">${movie.rating_count || 1} rating${movie.rating_count > 1 ? 's' : ''}</span>
                    </div>
                </div>
            </div>
        `;
    }).join('');

    container.innerHTML = moviesHTML;
}

function displayNoRecentRatings() {
    const container = document.getElementById('recentlyRatedMovies');
    container.innerHTML = `
        <div class="no-results" style="grid-column: 1 / -1;">
            <div class="no-results-icon">🎬</div>
            <h3>No Recent Ratings Yet</h3>
            <p>Be the first to rate a movie! Search for your favorite films and share your ratings.</p>
        </div>
    `;
}

function displayRecentRatingsError() {
    const container = document.getElementById('recentlyRatedMovies');
    container.innerHTML = `
        <div class="no-results" style="grid-column: 1 / -1;">
            <div class="no-results-icon">⚠️</div>
            <h3>Unable to Load Recent Ratings</h3>
            <p>Please try again later.</p>
        </div>
    `;
}

function formatTimeAgo(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const seconds = Math.floor((now - date) / 1000);

    if (seconds < 60) return 'Just now';
    if (seconds < 3600) return Math.floor(seconds / 60) + ' min ago';
    if (seconds < 86400) return Math.floor(seconds / 3600) + ' hours ago';
    if (seconds < 604800) return Math.floor(seconds / 86400) + ' days ago';
    return date.toLocaleDateString();
}

function loadMoreRecentRatings() {
    console.log('Load more recent ratings');
    // For now, just reload with more items
    window.location.href = '/dashboard';
}

// Initialize everything when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM loaded, initializing features...');
    animateCounters();
    setupSearchFunctionality();
    setupCategoryButtons();

    // Add a small delay to ensure all scripts are loaded
    setTimeout(() => {
        console.log('Delayed initialization - loading recent movies...');
        loadRecentlyRatedMovies();
    }, 10); // Increased delay to 500ms
});
</script>

</body>
</html>