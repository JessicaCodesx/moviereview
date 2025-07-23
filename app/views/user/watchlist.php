<?php
?>
<div class="user-page-container">
    <div class="page-header">
        <h2>📝 Your Watchlist</h2>
        <p>Movies you want to watch</p>
    </div>

    <?php if (!empty($data['watchlist'])): ?>
        <div class="movies-grid">
            <?php foreach ($data['watchlist'] as $movie): ?>
                <div class="movie-card watchlist-card" onclick="movieAppInstance.loadMovieDetails('<?php echo $movie['imdb_id']; ?>')">
                    <div class="movie-poster">
                        <img src="<?php echo $movie['poster'] !== 'N/A' ? $movie['poster'] : '/public/assets/images/no-image.png'; ?>" 
                             alt="<?php echo htmlspecialchars($movie['title']); ?>"
                             onerror="this.src='/public/assets/images/no-image.png'">

                        <div class="movie-overlay">
                            <div class="overlay-actions">
                                <button class="overlay-btn btn-success" onclick="event.stopPropagation(); markWatched(<?php echo $movie['movie_id']; ?>)">
                                    ✅ Mark Watched
                                </button>
                                <button class="overlay-btn btn-danger" onclick="event.stopPropagation(); removeFromWatchlist(<?php echo $movie['movie_id']; ?>)">
                                    🗑️ Remove
                                </button>
                            </div>
                        </div>

                        <div class="movie-badge">
                            <?php if ($movie['imdb_rating'] && $movie['imdb_rating'] !== 'N/A'): ?>
                                <span class="imdb-badge">IMDb <?php echo $movie['imdb_rating']; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="movie-card-info">
                        <h4><?php echo htmlspecialchars($movie['title']); ?></h4>
                        <p><?php echo $movie['year']; ?> • <?php echo htmlspecialchars($movie['genre']); ?></p>
                        <small class="added-date">Added on <?php echo date('M j, Y', strtotime($movie['created_at'])); ?></small>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination if needed -->
        <?php if (count($data['watchlist']) >= 20): ?>
        <div class="pagination">
            <a href="/watchlist?page=<?php echo max(1, $data['current_page'] - 1); ?>" class="btn btn-secondary">
                ← Previous
            </a>
            <span class="page-info">Page <?php echo $data['current_page']; ?></span>
            <a href="/watchlist?page=<?php echo $data['current_page'] + 1; ?>" class="btn btn-secondary">
                Next →
            </a>
        </div>
        <?php endif; ?>

    <?php else: ?>
        <div class="empty-state">
            <div class="empty-state-icon">📝</div>
            <h3>Your Watchlist is Empty</h3>
            <p>Start adding movies you want to watch to your watchlist.</p>
            <a href="/" class="btn btn-primary">Search Movies</a>
        </div>
    <?php endif; ?>
</div>

<style>
/* Enhanced Watchlist Styles */
.user-page-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 var(--space-4);
}

.page-header {
    background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.85) 100%);
    backdrop-filter: blur(20px) saturate(180%);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: var(--radius-2xl);
    padding: var(--space-8);
    margin-bottom: var(--space-8);
    text-align: center;
    box-shadow: var(--shadow-2xl);
    position: relative;
    overflow: hidden;
}

.page-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-primary);
}

.page-header h2 {
    font-size: var(--font-size-4xl);
    color: var(--neutral-800);
    margin-bottom: var(--space-2);
    font-weight: 900;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.page-header p {
    color: var(--neutral-600);
    font-size: var(--font-size-lg);
    font-weight: 500;
}

.movies-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: var(--space-6);
    margin-bottom: var(--space-8);
}

.watchlist-card {
    background: white;
    border-radius: var(--radius-xl);
    overflow: hidden;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: var(--shadow-md);
    border: 1px solid rgba(255, 255, 255, 0.2);
    position: relative;
    animation: fadeInUp 0.6s ease-out;
}

.watchlist-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: var(--shadow-2xl);
}

.movie-poster {
    position: relative;
    height: 280px;
    overflow: hidden;
}

.movie-poster img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.watchlist-card:hover .movie-poster img {
    transform: scale(1.1);
}

.movie-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.8);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: var(--space-3);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.watchlist-card:hover .movie-overlay {
    opacity: 1;
}

.overlay-actions {
    display: flex;
    flex-direction: column;
    gap: var(--space-2);
}

.overlay-btn {
    background: rgba(255,255,255,0.95);
    color: var(--neutral-800);
    border: none;
    padding: var(--space-2) var(--space-4);
    border-radius: var(--radius-lg);
    font-weight: 600;
    font-size: var(--font-size-sm);
    cursor: pointer;
    transition: all 0.2s ease;
    white-space: nowrap;
    backdrop-filter: blur(10px);
    min-width: 120px;
}

.overlay-btn.btn-success {
    background: var(--success-500);
    color: white;
}

.overlay-btn.btn-danger {
    background: var(--error-500);
    color: white;
}

.overlay-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.overlay-btn.btn-success:hover {
    background: var(--success-600);
}

.overlay-btn.btn-danger:hover {
    background: var(--error-600);
}

.movie-badge {
    position: absolute;
    top: var(--space-3);
    right: var(--space-3);
    z-index: 10;
}

.imdb-badge {
    background: #f59e0b;
    color: black;
    padding: var(--space-1) var(--space-2);
    border-radius: var(--radius-md);
    font-size: var(--font-size-xs);
    font-weight: 700;
    box-shadow: var(--shadow-sm);
}

.movie-card-info {
    padding: var(--space-4);
    background: white;
}

.movie-card-info h4 {
    font-size: var(--font-size-base);
    font-weight: 700;
    color: var(--neutral-800);
    margin-bottom: var(--space-2);
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.movie-card-info p {
    color: var(--neutral-600);
    font-size: var(--font-size-sm);
    margin-bottom: var(--space-2);
    font-weight: 500;
}

.added-date {
    color: var(--neutral-400);
    font-size: var(--font-size-xs);
    font-weight: 500;
    display: block;
}

.empty-state {
    text-align: center;
    padding: var(--space-16) var(--space-8);
    background: white;
    border-radius: var(--radius-2xl);
    box-shadow: var(--shadow-lg);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.empty-state-icon {
    font-size: 4rem;
    margin-bottom: var(--space-4);
    opacity: 0.5;
}

.empty-state h3 {
    font-size: var(--font-size-2xl);
    color: var(--neutral-700);
    margin-bottom: var(--space-3);
    font-weight: 700;
}

.empty-state p {
    color: var(--neutral-500);
    font-size: var(--font-size-lg);
    margin-bottom: var(--space-6);
    max-width: 400px;
    margin-left: auto;
    margin-right: auto;
}

.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: var(--space-6);
    margin-top: var(--space-8);
    padding: var(--space-6);
    background: rgba(255,255,255,0.1);
    border-radius: var(--radius-xl);
    backdrop-filter: blur(10px);
}

.page-info {
    color: white;
    font-weight: 600;
    font-size: var(--font-size-base);
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Stagger animation for cards */
.watchlist-card:nth-child(1) { animation-delay: 0.1s; }
.watchlist-card:nth-child(2) { animation-delay: 0.2s; }
.watchlist-card:nth-child(3) { animation-delay: 0.3s; }
.watchlist-card:nth-child(4) { animation-delay: 0.4s; }
.watchlist-card:nth-child(5) { animation-delay: 0.5s; }
.watchlist-card:nth-child(6) { animation-delay: 0.6s; }

@media (max-width: 768px) {
    .movies-grid {
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: var(--space-4);
    }
    
    .movie-poster {
        height: 240px;
    }
    
    .overlay-btn {
        font-size: var(--font-size-xs);
        padding: var(--space-1) var(--space-3);
        min-width: 100px;
    }
    
    .page-header {
        padding: var(--space-6);
    }
    
    .page-header h2 {
        font-size: var(--font-size-3xl);
    }
}

@media (max-width: 480px) {
    .movies-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .overlay-actions {
        flex-direction: row;
        gap: var(--space-1);
    }
    
    .overlay-btn {
        font-size: var(--font-size-xs);
        padding: var(--space-1) var(--space-2);
        min-width: 80px;
    }
}
</style>

<script>
// Enhanced watchlist functionality with smooth animations
class WatchlistManager {
    constructor() {
        this.isProcessing = false;
    }

    // Animate card removal with smooth transitions
    animateCardRemoval(cardElement, callback) {
        if (!cardElement) {
            callback?.();
            return;
        }

        // Add removal animation class
        cardElement.style.transition = 'all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55)';
        cardElement.style.transform = 'scale(0.8) rotateY(90deg)';
        cardElement.style.opacity = '0';
        cardElement.style.filter = 'blur(5px)';

        // Remove card after animation
        setTimeout(() => {
            cardElement.style.height = cardElement.offsetHeight + 'px';
            cardElement.style.overflow = 'hidden';
            
            setTimeout(() => {
                cardElement.style.height = '0';
                cardElement.style.margin = '0';
                cardElement.style.padding = '0';
                
                setTimeout(() => {
                    cardElement.remove();
                    this.checkEmptyState();
                    callback?.();
                }, 300);
            }, 100);
        }, 500);
    }

    // Check if watchlist is empty and show empty state
    checkEmptyState() {
        const moviesGrid = document.querySelector('.movies-grid');
        const remainingCards = moviesGrid?.querySelectorAll('.watchlist-card').length || 0;
        
        if (remainingCards === 0) {
            // Show empty state with animation
            setTimeout(() => {
                const container = document.querySelector('.user-page-container');
                if (container) {
                    const emptyState = this.createEmptyStateHTML();
                    moviesGrid.replaceWith(emptyState);
                }
            }, 600);
        }
    }

    // Create empty state HTML
    createEmptyStateHTML() {
        const emptyStateDiv = document.createElement('div');
        emptyStateDiv.className = 'empty-state';
        emptyStateDiv.style.opacity = '0';
        emptyStateDiv.style.transform = 'translateY(20px)';
        
        emptyStateDiv.innerHTML = `
            <div class="empty-state-icon">📝</div>
            <h3>Your Watchlist is Empty</h3>
            <p>All movies have been processed! Start adding new movies you want to watch.</p>
            <a href="/" class="btn btn-primary">Search Movies</a>
        `;
        
        // Animate in
        setTimeout(() => {
            emptyStateDiv.style.transition = 'all 0.6s ease';
            emptyStateDiv.style.opacity = '1';
            emptyStateDiv.style.transform = 'translateY(0)';
        }, 100);
        
        return emptyStateDiv;
    }

    // Show loading state on button
    setButtonLoading(button, loading = true) {
        if (!button) return;
        
        if (loading) {
            button.disabled = true;
            button.style.opacity = '0.7';
            button.style.transform = 'scale(0.95)';
            const originalText = button.textContent;
            button.setAttribute('data-original-text', originalText);
            
            if (button.textContent.includes('Mark Watched')) {
                button.innerHTML = '⏳ Processing...';
            } else if (button.textContent.includes('Remove')) {
                button.innerHTML = '⏳ Removing...';
            }
        } else {
            button.disabled = false;
            button.style.opacity = '1';
            button.style.transform = 'scale(1)';
            const originalText = button.getAttribute('data-original-text');
            if (originalText) {
                button.textContent = originalText;
            }
        }
    }
}

// Initialize watchlist manager
const watchlistManager = new WatchlistManager();

// Enhanced mark watched function
async function markWatched(movieId) {
    if (watchlistManager.isProcessing) return;
    
    const button = event?.target;
    const card = button?.closest('.watchlist-card');
    const movieTitle = card?.querySelector('h4')?.textContent || 'Movie';
    
    try {
        watchlistManager.isProcessing = true;
        watchlistManager.setButtonLoading(button, true);
        
        movieAppInstance.showToast(`Marking "${movieTitle}" as watched...`, 'info');
        
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
            movieAppInstance.showToast(`"${movieTitle}" marked as watched! 🎉`, 'success');
            
            // Add success animation
            if (card) {
                card.style.backgroundColor = '#d4edda';
                card.style.borderColor = '#c3e6cb';
                
                setTimeout(() => {
                    watchlistManager.animateCardRemoval(card, () => {
                        // Show completion message
                        movieAppInstance.showToast('Movie moved to watched list!', 'success');
                    });
                }, 800);
            }
        } else {
            movieAppInstance.showToast('Error: ' + (data.error || 'Unknown error'), 'error');
            watchlistManager.setButtonLoading(button, false);
        }
    } catch (error) {
        console.error('Mark watched error:', error);
        movieAppInstance.showToast('Error marking movie as watched', 'error');
        watchlistManager.setButtonLoading(button, false);
    } finally {
        setTimeout(() => {
            watchlistManager.isProcessing = false;
        }, 1000);
    }
}

// Enhanced remove from watchlist function
async function removeFromWatchlist(movieId) {
    if (watchlistManager.isProcessing) return;
    
    const button = event?.target;
    const card = button?.closest('.watchlist-card');
    const movieTitle = card?.querySelector('h4')?.textContent || 'Movie';
    
    // Custom confirmation dialog with better styling
    const confirmed = await showCustomConfirm(
        'Remove from Watchlist', 
        `Are you sure you want to remove "${movieTitle}" from your watchlist?`,
        'Remove',
        'Cancel'
    );
    
    if (!confirmed) return;

    try {
        watchlistManager.isProcessing = true;
        watchlistManager.setButtonLoading(button, true);
        
        movieAppInstance.showToast(`Removing "${movieTitle}" from watchlist...`, 'info');
        
        const formData = new FormData();
        formData.append('movieId', movieId);

        const response = await fetch('/api/watchlist/remove', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();

        if (data.success) {
            movieAppInstance.showToast(`"${movieTitle}" removed from watchlist`, 'success');
            
            // Animate removal
            watchlistManager.animateCardRemoval(card);
        } else {
            movieAppInstance.showToast('Error: ' + (data.error || 'Unknown error'), 'error');
            watchlistManager.setButtonLoading(button, false);
        }
    } catch (error) {
        console.error('Remove from watchlist error:', error);
        movieAppInstance.showToast('Error removing movie from watchlist', 'error');
        watchlistManager.setButtonLoading(button, false);
    } finally {
        setTimeout(() => {
            watchlistManager.isProcessing = false;
        }, 1000);
    }
}

// Custom confirmation dialog
function showCustomConfirm(title, message, confirmText = 'Confirm', cancelText = 'Cancel') {
    return new Promise((resolve) => {
        const modal = document.createElement('div');
        modal.className = 'custom-confirm-modal';
        modal.innerHTML = `
            <div class="confirm-modal-content">
                <h3>${title}</h3>
                <p>${message}</p>
                <div class="confirm-actions">
                    <button class="btn btn-secondary" data-action="cancel">${cancelText}</button>
                    <button class="btn btn-danger" data-action="confirm">${confirmText}</button>
                </div>
            </div>
        `;
        
        // Add styles
        const style = document.createElement('style');
        style.textContent = `
            .custom-confirm-modal {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.7);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 10000;
                animation: fadeIn 0.3s ease;
            }
            .confirm-modal-content {
                background: white;
                border-radius: 16px;
                padding: 2rem;
                max-width: 400px;
                width: 90%;
                text-align: center;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
                animation: slideIn 0.3s ease;
            }
            .confirm-modal-content h3 {
                margin: 0 0 1rem 0;
                color: #333;
                font-size: 1.25rem;
            }
            .confirm-modal-content p {
                margin: 0 0 2rem 0;
                color: #666;
                line-height: 1.5;
            }
            .confirm-actions {
                display: flex;
                gap: 1rem;
                justify-content: center;
            }
            .confirm-actions .btn {
                padding: 0.75rem 1.5rem;
                border-radius: 8px;
                border: none;
                cursor: pointer;
                font-weight: 600;
                transition: all 0.2s ease;
            }
            .confirm-actions .btn-secondary {
                background: #f3f4f6;
                color: #374151;
            }
            .confirm-actions .btn-secondary:hover {
                background: #e5e7eb;
            }
            .confirm-actions .btn-danger {
                background: #ef4444;
                color: white;
            }
            .confirm-actions .btn-danger:hover {
                background: #dc2626;
                transform: translateY(-1px);
            }
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }
            @keyframes slideIn {
                from { transform: translateY(-50px) scale(0.9); opacity: 0; }
                to { transform: translateY(0) scale(1); opacity: 1; }
            }
        `;
        
        if (!document.querySelector('style[data-confirm-modal]')) {
            style.setAttribute('data-confirm-modal', 'true');
            document.head.appendChild(style);
        }
        
        document.body.appendChild(modal);
        
        // Handle button clicks
        modal.addEventListener('click', (e) => {
            const action = e.target.getAttribute('data-action');
            if (action === 'confirm') {
                resolve(true);
            } else if (action === 'cancel' || e.target === modal) {
                resolve(false);
            }
            modal.remove();
        });
        
        // Focus the confirm button
        setTimeout(() => {
            modal.querySelector('[data-action="confirm"]')?.focus();
        }, 100);
    });
}

// Add some enhancement styles for better interactions
const enhancementStyles = document.createElement('style');
enhancementStyles.textContent = `
    .watchlist-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    
    .watchlist-card:hover {
        transform: translateY(-8px) scale(1.02) !important;
    }
    
    .overlay-btn {
        transition: all 0.2s ease !important;
        position: relative;
        overflow: hidden;
    }
    
    .overlay-btn:hover {
        transform: translateY(-2px) scale(1.05) !important;
    }
    
    .overlay-btn:active {
        transform: translateY(0) scale(0.98) !important;
    }
    
    .overlay-btn:disabled {
        cursor: not-allowed !important;
        transform: scale(0.95) !important;
    }
    
    /* Pulse animation for processing */
    .overlay-btn:disabled::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        animation: shimmer 1.5s infinite;
    }
    
    @keyframes shimmer {
        0% { left: -100%; }
        100% { left: 100%; }
    }
`;
document.head.appendChild(enhancementStyles);

// Add keyboard shortcuts
document.addEventListener('keydown', (e) => {
    // Escape key to close any modals
    if (e.key === 'Escape') {
        const modal = document.querySelector('.custom-confirm-modal');
        if (modal) {
            modal.querySelector('[data-action="cancel"]')?.click();
        }
    }
});

// Initialize page enhancements
document.addEventListener('DOMContentLoaded', () => {
    // Add loading states to buttons on page load
    const overlayBtns = document.querySelectorAll('.overlay-btn');
    overlayBtns.forEach(btn => {
        btn.style.transition = 'all 0.2s ease';
    });
    
    // Add hover effects to cards
    const cards = document.querySelectorAll('.watchlist-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateY(-8px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', () => {
            if (!card.style.transform.includes('scale(0.8)')) {
                card.style.transform = 'translateY(0) scale(1)';
            }
        });
    });
});
</script>