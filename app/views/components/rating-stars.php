// Reusable rating component

function renderRatingStars($currentRating = 0, $movieId = null, $interactive = true) {
    $html = '<div class="stars">';

    for ($i = 1; $i <= 5; $i++) {
        $activeClass = $i <= $currentRating ? 'active' : '';
        $clickHandler = $interactive && $movieId ? "onclick='MovieApp.rateMovie({$i})'" : '';
        $dataRating = $interactive ? "data-rating='{$i}'" : '';

        $html .= "<span class='star {$activeClass}' {$dataRating} {$clickHandler}>⭐</span>";
    }

    $html .= '</div>';
    return $html;
}
