<?php
// reusable component for movie cards

function renderMovieCard($movie) {
    $poster = $movie['Poster'] !== 'N/A' ? $movie['Poster'] : '/public/assets/images/no-image.png';

    return "
    <div class='movie-card' onclick='MovieApp.loadMovieDetails(\"{$movie['imdbID']}\")'>
        <img src='{$poster}' alt='{$movie['Title']}' onerror='this.src=\"/public/assets/images/no-image.png\"'>
        <div class='movie-card-info'>
            <h3>{$movie['Title']}</h3>
            <p>{$movie['Year']}</p>
        </div>
    </div>";
}