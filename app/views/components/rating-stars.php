<?php
// Elite Cinema - Reusable distinguished rating component
function renderRoyalRatingStars($currentRating = 0, $movieId = null, $interactive = true, $variant = 'standard', $options = []) {
    $containerClasses = 'royal-rating-constellation';
    $starIcon = '⭐';
    $crownAccent = '';

    // Determine styling variant
    switch($variant) {
        case 'elite':
            $containerClasses .= ' elite-constellation';
            $crownAccent = '<div class="rating-crown">👑</div>';
            break;
        case 'premium':
            $containerClasses .= ' premium-constellation';
            $starIcon = '✨';
            break;
        case 'compact':
            $containerClasses .= ' compact-constellation';
            break;
        case 'large':
            $containerClasses .= ' large-constellation';
            $crownAccent = '<div class="rating-crown large">👑</div>';
            break;
        default:
            $containerClasses .= ' standard-constellation';
            break;
    }

    if ($interactive) {
        $containerClasses .= ' interactive-constellation';
    }

    // Rating label
    $ratingLabel = isset($options['label']) ? $options['label'] : 'Your Distinguished Critique';
    $showLabel = isset($options['showLabel']) ? $options['showLabel'] : $interactive;

    // Current rating display
    $showCurrentRating = isset($options['showCurrentRating']) ? $options['showCurrentRating'] : true;
    $ratingText = $currentRating > 0 ? "{$currentRating}/5 Stars" : "Awaiting Your Critique";

    $html = "<div class='{$containerClasses}' data-movie-id='{$movieId}' data-current-rating='{$currentRating}'>";

    // Crown accent for elite variants
    if ($crownAccent) {
        $html .= $crownAccent;
    }

    // Rating label
    if ($showLabel) {
        $html .= "<div class='rating-label-royal'>{$ratingLabel}</div>";
    }

    // Stars container
    $html .= '<div class="stars-container-royal">';

    for ($i = 1; $i <= 5; $i++) {
        $starClasses = 'royal-star';
        $starClasses .= $i <= $currentRating ? ' illuminated' : ' dormant';

        if ($interactive) {
            $starClasses .= ' interactive-star';
            $clickHandler = "onclick='MovieApp.rateMovie({$i}, {$movieId})'";
            $hoverHandler = "onmouseover='highlightStars(this, {$i})' onmouseout='resetStarHighlight(this)'";
            $dataAttributes = "data-rating='{$i}' data-interactive='true'";
        } else {
            $clickHandler = '';
            $hoverHandler = '';
            $dataAttributes = "data-rating='{$i}'";
        }

        $html .= "<span class='{$starClasses}' {$dataAttributes} {$clickHandler} {$hoverHandler} title='Rate {$i} star" . ($i > 1 ? 's' : '') . "'>";
        $html .= $starIcon;
        $html .= "<div class='star-glow-effect'></div>";
        $html .= "</span>";
    }

    $html .= '</div>';

    // Current rating display
    if ($showCurrentRating) {
        $html .= "<div class='current-rating-display'>";
        $html .= "<span class='rating-text-royal'>{$ratingText}</span>";
        if ($currentRating > 0) {
            $html .= "<div class='rating-quality-badge'>" . getRatingQualityText($currentRating) . "</div>";
        }
        $html .= "</div>";
    }

    // Interactive feedback area
    if ($interactive) {
        $html .= "<div class='rating-feedback-royal' id='rating-feedback-{$movieId}'></div>";
    }

    $html .= '</div>';

    return $html;
}

// Get quality text based on rating
function getRatingQualityText($rating) {
    switch($rating) {
        case 5: return 'Masterpiece';
        case 4: return 'Exceptional';
        case 3: return 'Distinguished';
        case 2: return 'Adequate';
        case 1: return 'Disappointing';
        default: return '';
    }
}

// Compact rating display for lists and cards
function renderCompactRoyalRating($rating, $showValue = true) {
    if ($rating <= 0) return '';

    $html = '<div class="compact-royal-rating">';
    $html .= '<div class="compact-stars">';

    for ($i = 1; $i <= 5; $i++) {
        $starClass = $i <= $rating ? 'illuminated' : 'dormant';
        $html .= "<span class='compact-star {$starClass}'>⭐</span>";
    }

    $html .= '</div>';

    if ($showValue) {
        $html .= "<span class='compact-rating-value'>{$rating}/5</span>";
    }

    $html .= '</div>';

    return $html;
}

// Average rating display with distribution
function renderAverageRoyalRating($averageRating, $totalRatings = 0, $distribution = []) {
    $html = '<div class="average-royal-rating">';

    // Average score display
    $html .= '<div class="average-score-section">';
    $html .= '<div class="average-crown">👑</div>';
    $html .= '<div class="average-score">' . number_format($averageRating, 1) . '</div>';
    $html .= '<div class="average-stars">';

    for ($i = 1; $i <= 5; $i++) {
        $filled = $i <= round($averageRating);
        $starClass = $filled ? 'illuminated' : 'dormant';
        $html .= "<span class='avg-star {$starClass}'>⭐</span>";
    }

    $html .= '</div>';
    $html .= "<div class='total-critiques'>{$totalRatings} Distinguished Critiques</div>";
    $html .= '</div>';

    // Rating distribution (if provided)
    if (!empty($distribution)) {
        $html .= '<div class="rating-distribution">';
        $html .= '<div class="distribution-title">Critique Distribution</div>';

        for ($i = 5; $i >= 1; $i--) {
            $count = isset($distribution[$i]) ? $distribution[$i] : 0;
            $percentage = $totalRatings > 0 ? ($count / $totalRatings) * 100 : 0;

            $html .= '<div class="distribution-row">';
            $html .= "<span class='distribution-stars'>{$i} ⭐</span>";
            $html .= '<div class="distribution-bar">';
            $html .= "<div class='distribution-fill' style='width: {$percentage}%'></div>";
            $html .= '</div>';
            $html .= "<span class='distribution-count'>{$count}</span>";
            $html .= '</div>';
        }

        $html .= '</div>';
    }

    $html .= '</div>';

    return $html;
}

// Quick rating buttons for rapid rating
function renderQuickRoyalRating($movieId, $currentRating = 0) {
    $html = '<div class="quick-royal-rating" data-movie-id="' . $movieId . '">';
    $html .= '<div class="quick-rating-label">Quick Critique:</div>';
    $html .= '<div class="quick-rating-buttons">';

    $ratings = [
        1 => ['icon' => '👎', 'label' => 'Poor', 'class' => 'poor'],
        2 => ['icon' => '😐', 'label' => 'Fair', 'class' => 'fair'],
        3 => ['icon' => '👍', 'label' => 'Good', 'class' => 'good'],
        4 => ['icon' => '😍', 'label' => 'Great', 'class' => 'great'],
        5 => ['icon' => '👑', 'label' => 'Masterpiece', 'class' => 'masterpiece']
    ];

    foreach ($ratings as $rating => $data) {
        $activeClass = $rating == $currentRating ? ' active' : '';
        $html .= "<button class='quick-rating-btn {$data['class']}{$activeClass}' ";
        $html .= "onclick='MovieApp.quickRate({$rating}, {$movieId})' ";
        $html .= "title='{$data['label']}' data-rating='{$rating}'>";
        $html .= "<span class='quick-icon'>{$data['icon']}</span>";
        $html .= "<span class='quick-label'>{$data['label']}</span>";
        $html .= "</button>";
    }

    $html .= '</div>';
    $html .= '</div>';

    return $html;
}

?>

<script>
// Enhanced rating interaction functions
function highlightStars(starElement, rating) {
    const container = starElement.closest('.royal-rating-constellation');
    const stars = container.querySelectorAll('.royal-star');

    stars.forEach((star, index) => {
        if (index < rating) {
            star.classList.add('highlighted');
        } else {
            star.classList.remove('highlighted');
        }
    });

    // Show preview rating
    const feedback = container.querySelector('.rating-feedback-royal');
    if (feedback) {
        const qualityText = getRatingQualityTextJS(rating);
        feedback.innerHTML = `<span class="preview-rating">${rating}/5 - ${qualityText}</span>`;
        feedback.classList.add('show');
    }
}

function resetStarHighlight(starElement) {
    const container = starElement.closest('.royal-rating-constellation');
    const stars = container.querySelectorAll('.royal-star');
    const currentRating = parseInt(container.dataset.currentRating) || 0;

    stars.forEach((star, index) => {
        star.classList.remove('highlighted');
        if (index < currentRating) {
            star.classList.add('illuminated');
        } else {
            star.classList.remove('illuminated');
        }
    });

    // Hide preview
    const feedback = container.querySelector('.rating-feedback-royal');
    if (feedback) {
        feedback.classList.remove('show');
    }
}

function getRatingQualityTextJS(rating) {
    const qualities = {
        5: 'Masterpiece',
        4: 'Exceptional', 
        3: 'Distinguished',
        2: 'Adequate',
        1: 'Disappointing'
    };
    return qualities[rating] || '';
}

// Animation for successful rating
function animateRatingSuccess(container) {
    container.classList.add('rating-success');

    // Create sparkle effect
    for (let i = 0; i < 6; i++) {
        setTimeout(() => {
            createSparkle(container);
        }, i * 100);
    }

    setTimeout(() => {
        container.classList.remove('rating-success');
    }, 2000);
}

function createSparkle(container) {
    const sparkle = document.createElement('div');
    sparkle.className = 'rating-sparkle';
    sparkle.innerHTML = '✨';

    const rect = container.getBoundingClientRect();
    sparkle.style.left = Math.random() * rect.width + 'px';
    sparkle.style.top = Math.random() * rect.height + 'px';

    container.appendChild(sparkle);

    setTimeout(() => {
        sparkle.remove();
    }, 1000);
}
</script>

<style>
/* Elite Cinema Royal Rating Styles */
.royal-rating-constellation {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
    padding: 20px;
    background: var(--regal-glass, rgba(26, 31, 58, 0.9));
    backdrop-filter: blur(20px);
    border: 2px solid var(--regal-border, rgba(218, 165, 32, 0.3));
    border-radius: 16px;
    position: relative;
    transition: all 0.3s ease;
}

.royal-rating-constellation.interactive-constellation:hover {
    border-color: var(--regal-accent, #daa520);
    box-shadow: 0 8px 25px rgba(218, 165, 32, 0.3);
}

/* Constellation Variants */
.elite-constellation {
    background: linear-gradient(135deg, rgba(218, 165, 32, 0.1), var(--regal-glass, rgba(26, 31, 58, 0.9)));
    border-color: var(--regal-accent, #daa520);
}

.premium-constellation {
    background: linear-gradient(135deg, rgba(139, 92, 246, 0.1), var(--regal-glass, rgba(26, 31, 58, 0.9)));
    border-color: #8b5cf6;
}

.compact-constellation {
    padding: 10px;
    flex-direction: row;
    align-items: center;
    gap: 8px;
}

.large-constellation {
    padding: 30px;
    gap: 20px;
}

/* Rating Crown */
.rating-crown {
    position: absolute;
    top: -15px;
    right: 20px;
    font-size: 1.5rem;
    filter: drop-shadow(0 2px 8px rgba(218, 165, 32, 0.4));
    animation: crownFloat 4s ease-in-out infinite;
}

.rating-crown.large {
    font-size: 2rem;
    top: -20px;
}

@keyframes crownFloat {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-4px) rotate(2deg); }
}

/* Rating Label */
.rating-label-royal {
    font-size: 1rem;
    font-weight: 700;
    color: var(--regal-accent, #daa520);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    text-align: center;
}

/* Stars Container */
.stars-container-royal {
    display: flex;
    gap: 8px;
    align-items: center;
}

.large-constellation .stars-container-royal {
    gap: 12px;
}

.compact-constellation .stars-container-royal {
    gap: 4px;
}

/* Royal Stars */
.royal-star {
    font-size: 1.8rem;
    position: relative;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
}

.large-constellation .royal-star {
    font-size: 2.5rem;
}

.compact-constellation .royal-star {
    font-size: 1.2rem;
}

.royal-star.illuminated {
    color: var(--regal-accent, #daa520);
    text-shadow: 0 0 8px rgba(218, 165, 32, 0.6);
    transform: scale(1.1);
}

.royal-star.dormant {
    color: rgba(218, 165, 32, 0.3);
}

.royal-star.interactive-star:hover,
.royal-star.highlighted {
    color: var(--regal-accent-light, #f4d03f);
    text-shadow: 0 0 12px rgba(244, 208, 63, 0.8);
    transform: scale(1.2);
}

/* Star Glow Effect */
.star-glow-effect {
    position: absolute;
    inset: -10px;
    background: radial-gradient(circle, rgba(218, 165, 32, 0.3), transparent);
    border-radius: 50%;
    opacity: 0;
    transition: opacity 0.3s ease;
    pointer-events: none;
}

.royal-star.illuminated .star-glow-effect,
.royal-star:hover .star-glow-effect {
    opacity: 1;
}

/* Current Rating Display */
.current-rating-display {
    text-align: center;
    color: var(--regal-text, #ffffff);
}

.rating-text-royal {
    font-size: 1rem;
    font-weight: 600;
    color: var(--regal-text-muted, rgba(255, 255, 255, 0.7));
    display: block;
    margin-bottom: 8px;
}

.rating-quality-badge {
    background: linear-gradient(135deg, var(--regal-accent, #daa520), var(--regal-accent-light, #f4d03f));
    color: var(--regal-primary, #1a1f3a);
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    display: inline-block;
}

/* Rating Feedback */
.rating-feedback-royal {
    min-height: 20px;
    opacity: 0;
    transition: opacity 0.3s ease;
    text-align: center;
}

.rating-feedback-royal.show {
    opacity: 1;
}

.preview-rating {
    color: var(--regal-accent, #daa520);
    font-weight: 600;
    font-size: 0.9rem;
}

/* Compact Rating */
.compact-royal-rating {
    display: flex;
    align-items: center;
    gap: 8px;
}

.compact-stars {
    display: flex;
    gap: 2px;
}

.compact-star {
    font-size: 0.9rem;
    color: rgba(218, 165, 32, 0.3);
}

.compact-star.illuminated {
    color: var(--regal-accent, #daa520);
    text-shadow: 0 0 4px rgba(218, 165, 32, 0.6);
}

.compact-rating-value {
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--regal-accent, #daa520);
}

/* Average Rating */
.average-royal-rating {
    display: flex;
    gap: 30px;
    align-items: flex-start;
    padding: 25px;
    background: var(--regal-glass, rgba(26, 31, 58, 0.9));
    backdrop-filter: blur(20px);
    border: 2px solid var(--regal-border, rgba(218, 165, 32, 0.3));
    border-radius: 16px;
}

.average-score-section {
    text-align: center;
    position: relative;
}

.average-crown {
    font-size: 2rem;
    margin-bottom: 10px;
    filter: drop-shadow(0 2px 8px rgba(218, 165, 32, 0.4));
}

.average-score {
    font-size: 3rem;
    font-weight: 900;
    color: var(--regal-accent, #daa520);
    line-height: 1;
    margin-bottom: 10px;
}

.average-stars {
    display: flex;
    gap: 4px;
    justify-content: center;
    margin-bottom: 10px;
}

.avg-star {
    font-size: 1.2rem;
    color: rgba(218, 165, 32, 0.3);
}

.avg-star.illuminated {
    color: var(--regal-accent, #daa520);
    text-shadow: 0 0 6px rgba(218, 165, 32, 0.6);
}

.total-critiques {
    font-size: 0.9rem;
    color: var(--regal-text-muted, rgba(255, 255, 255, 0.7));
    font-weight: 600;
}

/* Rating Distribution */
.rating-distribution {
    flex: 1;
    min-width: 200px;
}

.distribution-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--regal-accent, #daa520);
    margin-bottom: 15px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.distribution-row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 8px;
}

.distribution-stars {
    font-size: 0.8rem;
    min-width: 40px;
    color: var(--regal-text, #ffffff);
}

.distribution-bar {
    flex: 1;
    height: 8px;
    background: rgba(218, 165, 32, 0.2);
    border-radius: 4px;
    overflow: hidden;
}

.distribution-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--regal-accent, #daa520), var(--regal-accent-light, #f4d03f));
    transition: width 1s ease-out;
}

.distribution-count {
    font-size: 0.8rem;
    min-width: 30px;
    text-align: right;
    color: var(--regal-text-muted, rgba(255, 255, 255, 0.7));
    font-weight: 600;
}

/* Quick Rating */
.quick-royal-rating {
    display: flex;
    flex-direction: column;
    gap: 15px;
    padding: 20px;
    background: var(--regal-glass, rgba(26, 31, 58, 0.9));
    backdrop-filter: blur(20px);
    border: 2px solid var(--regal-border, rgba(218, 165, 32, 0.3));
    border-radius: 16px;
}

.quick-rating-label {
    font-size: 1rem;
    font-weight: 700;
    color: var(--regal-accent, #daa520);
    text-align: center;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.quick-rating-buttons {
    display: flex;
    gap: 10px;
    justify-content: center;
    flex-wrap: wrap;
}

.quick-rating-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 5px;
    padding: 15px 10px;
    background: rgba(255, 255, 255, 0.05);
    border: 2px solid var(--regal-border, rgba(218, 165, 32, 0.3));
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    min-width: 80px;
    color: var(--regal-text, #ffffff);
}

.quick-rating-btn:hover {
    background: rgba(218, 165, 32, 0.1);
    border-color: var(--regal-accent, #daa520);
    transform: translateY(-2px);
}

.quick-rating-btn.active {
    background: rgba(218, 165, 32, 0.2);
    border-color: var(--regal-accent, #daa520);
    box-shadow: 0 4px 15px rgba(218, 165, 32, 0.3);
}

.quick-icon {
    font-size: 1.5rem;
}

.quick-label {
    font-size: 0.8rem;
    font-weight: 600;
}

/* Success Animation */
.rating-success {
    animation: ratingPulse 0.6s ease;
}

@keyframes ratingPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.rating-sparkle {
    position: absolute;
    font-size: 1rem;
    animation: sparkle 1s ease-out forwards;
    pointer-events: none;
    z-index: 10;
}

@keyframes sparkle {
    0% {
        opacity: 1;
        transform: scale(0) rotate(0deg);
    }
    100% {
        opacity: 0;
        transform: scale(1.5) rotate(180deg) translateY(-20px);
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .average-royal-rating {
        flex-direction: column;
        gap: 20px;
    }

    .quick-rating-buttons {
        gap: 8px;
    }

    .quick-rating-btn {
        min-width: 60px;
        padding: 12px 8px;
    }

    .royal-star {
        font-size: 1.5rem;
    }

    .large-constellation .royal-star {
        font-size: 2rem;
    }
}

@media (max-width: 480px) {
    .royal-rating-constellation {
        padding: 15px;
    }

    .stars-container-royal {
        gap: 6px;
    }

    .quick-rating-buttons {
        gap: 5px;
    }

    .quick-rating-btn {
        min-width: 50px;
        padding: 10px 5px;
    }

    .quick-icon {
        font-size: 1.2rem;
    }

    .quick-label {
        font-size: 0.7rem;
    }
}
</style>