<?php
// Elite Cinema - Reusable component for distinguished movie cards
function renderEliteMovieCard($movie, $cardType = 'standard', $additionalInfo = []) {
    $poster = $movie['Poster'] !== 'N/A' ? $movie['Poster'] : '/public/assets/images/no-image.png';
    $title = htmlspecialchars($movie['Title']);
    $year = $movie['Year'];
    $imdbID = $movie['imdbID'];

    // Determine card styling based on type
    $cardClasses = 'elite-movie-card';
    $crownIcon = '🎭';
    $qualityBadge = 'Curated';

    switch($cardType) {
        case 'premium':
            $cardClasses .= ' premium-card';
            $crownIcon = '👑';
            $qualityBadge = 'Royal Selection';
            break;
        case 'recommendation':
            $cardClasses .= ' recommendation-card';
            $crownIcon = '💎';
            $qualityBadge = 'AI Curated';
            break;
        case 'watchlist':
            $cardClasses .= ' watchlist-card';
            $crownIcon = '📜';
            $qualityBadge = 'In Collection';
            break;
        case 'watched':
            $cardClasses .= ' watched-card';
            $crownIcon = '⭐';
            $qualityBadge = 'Appreciated';
            break;
        default:
            $cardClasses .= ' standard-card';
            break;
    }

    // Additional info for enhanced cards
    $ratingDisplay = '';
    $extraInfo = '';

    if (isset($additionalInfo['rating']) && $additionalInfo['rating'] !== 'N/A') {
        $ratingDisplay = "
            <div class='elite-rating-badge'>
                <span class='rating-crown'>⭐</span>
                <span class='rating-value'>{$additionalInfo['rating']}</span>
            </div>";
    }

    if (isset($additionalInfo['genre'])) {
        $genre = htmlspecialchars(substr($additionalInfo['genre'], 0, 20));
        $extraInfo = "<p class='movie-genre-elite'>{$genre}</p>";
    }

    if (isset($additionalInfo['user_rating'])) {
        $userStars = '';
        for ($i = 1; $i <= 5; $i++) {
            $starClass = $i <= $additionalInfo['user_rating'] ? 'illuminated' : '';
            $userStars .= "<span class='user-star {$starClass}'>⭐</span>";
        }
        $extraInfo .= "
            <div class='user-rating-display'>
                <span class='rating-label'>Your Critique:</span>
                <div class='user-stars'>{$userStars}</div>
            </div>";
    }

    return "
    <div class='{$cardClasses}' onclick='MovieApp.loadMovieDetails(\"{$imdbID}\")' data-movie-id='{$imdbID}'>
        <div class='elite-movie-poster'>
            <img src='{$poster}' 
                 alt='{$title}' 
                 onerror='this.src=\"/public/assets/images/no-image.png\"'
                 loading='lazy'>
            <div class='elite-movie-overlay'>
                <div class='overlay-crown'>{$crownIcon}</div>
                <button class='elite-play-button'>
                    <svg width='20' height='20' viewBox='0 0 24 24' fill='currentColor'>
                        <polygon points='5,3 19,12 5,21'></polygon>
                    </svg>
                </button>
            </div>
            <div class='quality-badge-elite'>{$qualityBadge}</div>
            {$ratingDisplay}
            <div class='poster-glow-effect'></div>
        </div>
        <div class='elite-movie-info'>
            <h3 class='movie-title-elite'>{$title}</h3>
            <p class='movie-year-elite'>{$year}</p>
            {$extraInfo}
        </div>
        <div class='card-shimmer-effect'></div>
    </div>";
}

// Enhanced component for different movie card variants
function renderEliteMovieGrid($movies, $cardType = 'standard', $additionalData = []) {
    if (empty($movies)) {
        return renderEliteEmptyState();
    }

    $html = "<div class='elite-movies-grid'>";

    foreach ($movies as $index => $movie) {
        $additionalInfo = isset($additionalData[$index]) ? $additionalData[$index] : [];
        $html .= renderEliteMovieCard($movie, $cardType, $additionalInfo);
    }

    $html .= "</div>";
    return $html;
}

// Empty state component for when no movies are found
function renderEliteEmptyState($message = "No cinematic treasures found", $subtitle = "Refine your search to discover masterpieces") {
    return "
    <div class='elite-empty-state'>
        <div class='empty-crown-animation'>
            <div class='empty-crown'>👑</div>
            <div class='empty-particles'>
                <span class='particle'>⭐</span>
                <span class='particle'>🎭</span>
                <span class='particle'>🎬</span>
            </div>
        </div>
        <div class='empty-content-elite'>
            <h3>{$message}</h3>
            <p>{$subtitle}</p>
        </div>
    </div>";
}

// Specialized movie card for search results
function renderEliteSearchCard($movie, $isInWatchlist = false, $isWatched = false) {
    $additionalInfo = [];
    $cardType = 'standard';

    if (isset($movie['imdbRating'])) {
        $additionalInfo['rating'] = $movie['imdbRating'];
    }

    if (isset($movie['Genre'])) {
        $additionalInfo['genre'] = $movie['Genre'];
    }

    if ($isWatched) {
        $cardType = 'watched';
    } elseif ($isInWatchlist) {
        $cardType = 'watchlist';
    }

    return renderEliteMovieCard($movie, $cardType, $additionalInfo);
}

// Movie card with action buttons (for watchlist/library pages)
function renderEliteActionCard($movie, $actions = []) {
    $poster = $movie['Poster'] !== 'N/A' ? $movie['Poster'] : '/public/assets/images/no-image.png';
    $title = htmlspecialchars($movie['Title']);
    $year = $movie['Year'];
    $imdbID = $movie['imdbID'];

    $actionButtons = '';
    foreach ($actions as $action) {
        $actionButtons .= "
            <button class='elite-action-btn {$action['class']}' 
                    onclick='event.stopPropagation(); {$action['onclick']}' 
                    title='{$action['title']}'>
                {$action['icon']}
            </button>";
    }

    return "
    <div class='elite-movie-card action-card' onclick='MovieApp.loadMovieDetails(\"{$imdbID}\")'>
        <div class='elite-movie-poster'>
            <img src='{$poster}' 
                 alt='{$title}' 
                 onerror='this.src=\"/public/assets/images/no-image.png\"'
                 loading='lazy'>
            <div class='elite-movie-overlay'>
                <div class='elite-overlay-actions'>
                    {$actionButtons}
                </div>
            </div>
            <div class='quality-badge-elite'>Elite</div>
            <div class='poster-glow-effect'></div>
        </div>
        <div class='elite-movie-info'>
            <h3 class='movie-title-elite'>{$title}</h3>
            <p class='movie-year-elite'>{$year}</p>
        </div>
        <div class='card-shimmer-effect'></div>
    </div>";
}

?>

<style>
/* Elite Cinema Movie Card Styles */
.elite-movie-card {
    background: var(--regal-glass, rgba(26, 31, 58, 0.9));
    backdrop-filter: blur(20px) saturate(200%);
    border: 2px solid var(--regal-border, rgba(218, 165, 32, 0.3));
    border-radius: 18px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
    cursor: pointer;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    position: relative;
    min-width: 200px;
    max-width: 280px;
}

.elite-movie-card:hover {
    transform: translateY(-12px) scale(1.02);
    border-color: var(--regal-accent, #daa520);
    box-shadow: 0 20px 40px rgba(218, 165, 32, 0.4);
}

.elite-movie-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--regal-accent, #daa520), var(--regal-accent-light, #f4d03f), var(--regal-accent, #daa520));
    opacity: 0;
    transition: opacity 0.3s ease;
}

.elite-movie-card:hover::before {
    opacity: 1;
}

/* Card Variants */
.premium-card {
    border-color: var(--regal-accent, #daa520);
    background: linear-gradient(135deg, rgba(218, 165, 32, 0.1), var(--regal-glass, rgba(26, 31, 58, 0.9)));
}

.recommendation-card {
    border-color: #8b5cf6;
    background: linear-gradient(135deg, rgba(139, 92, 246, 0.1), var(--regal-glass, rgba(26, 31, 58, 0.9)));
}

.watchlist-card {
    border-color: #10b981;
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), var(--regal-glass, rgba(26, 31, 58, 0.9)));
}

.watched-card {
    border-color: #f59e0b;
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), var(--regal-glass, rgba(26, 31, 58, 0.9)));
}

/* Movie Poster */
.elite-movie-poster {
    position: relative;
    height: 300px;
    overflow: hidden;
}

.elite-movie-poster img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.elite-movie-card:hover .elite-movie-poster img {
    transform: scale(1.1);
}

/* Movie Overlay */
.elite-movie-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(180deg, transparent 40%, rgba(0, 0, 0, 0.8));
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.elite-movie-card:hover .elite-movie-overlay {
    opacity: 1;
}

.overlay-crown {
    position: absolute;
    top: 20px;
    left: 20px;
    font-size: 1.5rem;
    filter: drop-shadow(0 2px 8px rgba(218, 165, 32, 0.4));
    animation: crownFloat 4s ease-in-out infinite;
}

@keyframes crownFloat {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-4px) rotate(2deg); }
}

.elite-play-button {
    background: linear-gradient(135deg, var(--regal-accent, #daa520), var(--regal-accent-light, #f4d03f));
    border: none;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--regal-primary, #1a1f3a);
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(218, 165, 32, 0.4);
}

.elite-play-button:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(218, 165, 32, 0.6);
}

/* Quality Badge */
.quality-badge-elite {
    position: absolute;
    top: 15px;
    right: 15px;
    background: linear-gradient(135deg, var(--regal-accent, #daa520), var(--regal-accent-light, #f4d03f));
    color: var(--regal-primary, #1a1f3a);
    padding: 4px 8px;
    border-radius: 8px;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    box-shadow: 0 2px 8px rgba(218, 165, 32, 0.3);
}

/* Rating Badge */
.elite-rating-badge {
    position: absolute;
    bottom: 15px;
    right: 15px;
    background: rgba(0, 0, 0, 0.8);
    color: var(--regal-accent, #daa520);
    padding: 6px 10px;
    border-radius: 10px;
    font-size: 0.8rem;
    font-weight: 600;
    backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    gap: 4px;
}

.rating-crown {
    font-size: 0.9rem;
}

/* Poster Glow Effect */
.poster-glow-effect {
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at center, rgba(218, 165, 32, 0.1), transparent);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.elite-movie-card:hover .poster-glow-effect {
    opacity: 1;
}

/* Movie Info */
.elite-movie-info {
    padding: 20px;
    color: var(--regal-text, #ffffff);
}

.movie-title-elite {
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 8px;
    line-height: 1.3;
    color: var(--regal-text, #ffffff);
}

.movie-year-elite {
    font-size: 0.9rem;
    color: var(--regal-text-muted, rgba(255, 255, 255, 0.7));
    margin-bottom: 8px;
    font-weight: 500;
}

.movie-genre-elite {
    font-size: 0.8rem;
    color: var(--regal-accent, #daa520);
    font-weight: 600;
    margin-bottom: 8px;
}

/* User Rating Display */
.user-rating-display {
    margin-top: 10px;
}

.rating-label {
    font-size: 0.8rem;
    color: var(--regal-text-muted, rgba(255, 255, 255, 0.7));
    display: block;
    margin-bottom: 4px;
    font-weight: 500;
}

.user-stars {
    display: flex;
    gap: 2px;
}

.user-star {
    font-size: 0.8rem;
    color: rgba(218, 165, 32, 0.3);
    transition: color 0.3s ease;
}

.user-star.illuminated {
    color: var(--regal-accent, #daa520);
    text-shadow: 0 0 4px rgba(218, 165, 32, 0.6);
}

/* Card Shimmer Effect */
.card-shimmer-effect {
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(218, 165, 32, 0.1), transparent);
    transition: left 0.8s ease;
    pointer-events: none;
}

.elite-movie-card:hover .card-shimmer-effect {
    left: 100%;
}

/* Action Card Specific Styles */
.elite-overlay-actions {
    display: flex;
    gap: 10px;
}

.elite-action-btn {
    background: rgba(255, 255, 255, 0.9);
    border: none;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    font-size: 1rem;
}

.elite-action-btn:hover {
    transform: scale(1.1);
    background: rgba(255, 255, 255, 1);
}

.elite-action-btn.btn-success {
    color: #10b981;
}

.elite-action-btn.btn-danger {
    color: #ef4444;
}

.elite-action-btn.btn-primary {
    color: #6366f1;
}

/* Movies Grid */
.elite-movies-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 25px;
    padding: 20px 0;
}

@media (max-width: 768px) {
    .elite-movies-grid {
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 20px;
    }

    .elite-movie-card {
        min-width: 180px;
    }

    .elite-movie-poster {
        height: 250px;
    }
}

@media (max-width: 480px) {
    .elite-movies-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    .elite-movie-card {
        min-width: 150px;
    }

    .elite-movie-poster {
        height: 220px;
    }

    .elite-movie-info {
        padding: 15px;
    }
}

/* Elite Empty State */
.elite-empty-state {
    text-align: center;
    padding: 60px 40px;
    color: var(--regal-text, #ffffff);
}

.empty-crown-animation {
    position: relative;
    margin-bottom: 40px;
}

.empty-crown {
    font-size: 4rem;
    filter: drop-shadow(0 4px 12px rgba(218, 165, 32, 0.4));
    animation: crownFloat 6s ease-in-out infinite;
}

.empty-particles {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 200px;
    height: 200px;
}

.empty-particles .particle {
    position: absolute;
    font-size: 1.5rem;
    animation: particleOrbit 8s linear infinite;
}

.empty-particles .particle:nth-child(1) { animation-delay: 0s; }
.empty-particles .particle:nth-child(2) { animation-delay: 2.5s; }
.empty-particles .particle:nth-child(3) { animation-delay: 5s; }

@keyframes particleOrbit {
    0% { transform: rotate(0deg) translateX(80px) rotate(0deg); }
    100% { transform: rotate(360deg) translateX(80px) rotate(-360deg); }
}

.empty-content-elite h3 {
    font-size: 1.8rem;
    font-weight: 800;
    color: var(--regal-accent, #daa520);
    margin-bottom: 15px;
}

.empty-content-elite p {
    font-size: 1.1rem;
    color: var(--regal-text-muted, rgba(255, 255, 255, 0.7));
    font-style: italic;
}
</style>