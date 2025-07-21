// template for movie details (used by JavaScript)

function renderMovieDetails($movie) {
    $poster = $movie['poster'] !== 'N/A' ? $movie['poster'] : '/public/assets/images/no-image.png';
    $userRating = $movie['user_rating'] ?? 0;

    return "
    <div class='movie-header'>
        <div class='movie-poster'>
            <img src='{$poster}' alt='{$movie['title']}'>
        </div>
        <div class='movie-info'>
            <h2>{$movie['title']} ({$movie['year']})</h2>
            <div class='movie-meta'>
                <span class='meta-item'>📽️ {$movie['director']}</span>
                <span class='meta-item'>🎭 {$movie['genre']}</span>
                <span class='meta-item'>⏱️ {$movie['runtime']}</span>
                <span class='meta-item'>⭐ IMDB: {$movie['rating']}</span>
            </div>
            <p class='movie-plot'>{$movie['plot']}</p>
            <p><strong>Starring:</strong> {$movie['actors']}</p>
        </div>
    </div>

    <div class='rating-section'>
        <h3>Rate this movie</h3>
        <div class='rating-display'>
            <div class='stars' data-movie-id='{$movie['id']}'>
                " . renderRatingStars($userRating, $movie['id']) . "
            </div>
            <div class='rating-info' id='ratingInfo'>
                Average: {$movie['ratings']['average']}/5 ({$movie['ratings']['count']} rating" . 
                ($movie['ratings']['count'] !== 1 ? 's' : '') . ")
            </div>
        </div>
    </div>

    <div class='review-section'>
        <button onclick='MovieApp.generateReview({$movie['id']})' class='btn'>📝 Get AI Review</button>
        <div id='reviewContent' class='review-content'></div>
    </div>";
}
?>