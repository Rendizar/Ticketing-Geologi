{{-- resources/views/games/memory.blade.php --}}
@extends('layouts.app')

@section('title', 'Fossil Memory Match')

@section('content')
<section class="min-vh-100 d-flex align-items-center py-5">
    <div class="container py-4">

        <!-- Judul Utama -->
        <div class="text-center mb-5">
            <h1 class="display-2 fw-bold mb-4 memory-title" style="font-family: 'Merriweather', serif !important; color: #1F2933;" data-lang-key="memory_title">
                Fossil Memory Match
            </h1>
            <p class="fs-4 memory-subtitle" style="color: #6c6c6c; font-weight: 500;" data-lang-key="memory_subtitle">
                Find matching pairs of ancient fossils!
            </p>
            
            <!-- Score & Timer -->
            <div class="d-flex justify-content-center gap-3 mt-4 flex-wrap" role="status" aria-live="polite">
                <div class="badge bg-white border-2 fs-6 px-4 py-2 shadow-sm" style="border-color: #FACC15 !important;">
                    <i class="fas fa-shoe-prints me-2" style="color: #FACC15;" aria-hidden="true"></i>
                    <span style="color: #1F2933; font-weight: 600;" data-lang-key="memory_moves">Moves:</span> <span id="moves" class="fw-bold" style="color: #FACC15;" aria-label="Number of moves">0</span>
                </div>
                <div class="badge bg-white border-2 border-danger fs-6 px-4 py-2 shadow-sm">
                    <i class="fas fa-clock text-danger me-2" aria-hidden="true"></i>
                    <span style="color: #1F2933; font-weight: 600;" data-lang-key="memory_time">Time:</span> <span id="timer" class="text-danger fw-bold" aria-label="Elapsed time">00:00</span>
                </div>
                <div class="badge bg-white border-2 fs-6 px-4 py-2 shadow-sm" style="border-color: #FACC15 !important;">
                    <i class="fas fa-trophy me-2" style="color: #FACC15;" aria-hidden="true"></i>
                    <span style="color: #1F2933; font-weight: 600;" data-lang-key="memory_pairs">Pairs:</span> <span id="pairs" class="fw-bold" style="color: #FACC15;" aria-label="Matched pairs">0</span> <span style="color: #1F2933; font-weight: 600;">/</span> <span id="totalPairs" style="color: #FACC15;">6</span>
                </div>
            </div>
        </div>

        <!-- Card Game Utama -->
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                <div class="card bg-white border-0 shadow-lg rounded-4 overflow-hidden memory-card">
                    <div class="card-body p-4 p-xl-5">

                        <!-- Game Board -->
                        <div id="gameBoard" class="game-board mx-auto mb-4" role="group" aria-label="Memory game cards"></div>

                        <!-- Progress Bar -->
                        <div class="mt-4 mb-4">
                            <label class="form-label fw-bold mb-2" style="color: #1F2933;">
                                <i class="fas fa-chart-line me-2" style="color: #FACC15;"></i><span data-lang-key="memory_progress">Progress Bar</span>
                            </label>
                            <div class="progress memory-progress">
                                <div id="progressBar" class="progress-bar bg-success progress-bar-striped progress-bar-animated" 
                                     role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                    <span class="fw-bold fs-6" id="progressText">0% <span data-lang-key="memory_complete">Complete</span></span>
                                </div>
                            </div>
                        </div>

                        <!-- Difficulty Selection -->
                        <div class="text-center mb-4">
                            <h4 class="mb-3" style="color: #1F2933; font-weight: 600;">
                                <i class="fas fa-sliders-h me-2" style="color: #FACC15;" aria-hidden="true"></i><span data-lang-key="memory_difficulty">Difficulty Level</span>
                            </h4>
                            <div class="btn-group" role="group" aria-label="Difficulty level selection">
                                <button type="button" class="btn btn-outline-success difficulty-btn active" onclick="setDifficulty('easy')" aria-label="Easy mode with 6 pairs">
                                    <i class="fas fa-smile me-2" aria-hidden="true"></i><span data-lang-key="memory_easy">Easy (6 pairs)</span>
                                </button>
                                <button type="button" class="btn btn-outline-warning difficulty-btn" onclick="setDifficulty('medium')" aria-label="Medium mode with 8 pairs">
                                    <i class="fas fa-meh me-2" aria-hidden="true"></i><span data-lang-key="memory_medium">Medium (8 pairs)</span>
                                </button>
                                <button type="button" class="btn btn-outline-danger difficulty-btn" onclick="setDifficulty('hard')" aria-label="Hard mode with 10 pairs">
                                    <i class="fas fa-fire me-2" aria-hidden="true"></i><span data-lang-key="memory_hard">Hard (10 pairs)</span>
                                </button>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="text-center mt-4">
                            <button onclick="startGame()" 
                                    class="btn btn-new-game px-4 py-2 me-2 fw-bold"
                                    aria-label="Start a new game">
                                <i class="fas fa-play me-2" aria-hidden="true"></i><span data-lang-key="memory_new_game">New Game</span>
                            </button>
                            <button onclick="resetGame()" 
                                    class="btn btn-reset-game px-4 py-2 fw-bold"
                                    aria-label="Reset current game">
                                <i class="fas fa-redo me-2" aria-hidden="true"></i><span data-lang-key="memory_reset">Reset</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Kembali -->
        <div class="text-center mt-5">
            <a href="{{ route('games.index') }}" 
               class="btn btn-back-home px-4 py-2 fw-bold"
               aria-label="Go back to mini games menu">
                <i class="fas fa-arrow-left me-2" aria-hidden="true"></i><span data-lang-key="games_back_menu">Back to Mini Games</span>
            </a>
        </div>
    </div>
</section>
@endsection

{{-- STYLE KHUSUS MEMORY GAME --}}
@section('styles')
<style>
    /* ========================================
       CSS Variables & Theme
       ======================================== */
    :root {
        --memory-yellow: #FACC15;
        --memory-dark: #1F2933;
        --memory-muted: #6c6c6c;
        --memory-light: #f8f9fa;
    }

    /* Title Styles */
    .memory-title {
        letter-spacing: 2px;
        text-shadow: none;
    }

    .memory-subtitle {
        text-shadow: none;
    }

    /* Memory Card */
    .memory-card {
        transition: all 0.3s ease;
    }

    /* Progress Bar */
    .memory-progress {
        height: 30px;
        background: #e9ecef;
        border-radius: 12px;
    }

    /* ========================================
       Game Board Grid
       ======================================== */
    .game-board {
        display: grid;
        gap: 15px;
        padding: 30px;
        background: #ffffff;
        border-radius: 20px;
        border: 2px solid var(--memory-yellow);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        max-width: 800px;
    }

    .game-board.easy {
        grid-template-columns: repeat(4, 1fr);
    }

    .game-board.medium {
        grid-template-columns: repeat(4, 1fr);
    }

    .game-board.hard {
        grid-template-columns: repeat(5, 1fr);
    }

    /* Flip Card */
    .flip-card {
        aspect-ratio: 1;
        perspective: 1000px;
        cursor: pointer;
        transition: transform 0.2s ease;
    }

    .flip-card:hover:not(.matched) {
        transform: scale(1.05);
    }

    .flip-card-inner {
        position: relative;
        width: 100%;
        height: 100%;
        transition: transform 0.6s;
        transform-style: preserve-3d;
    }

    .flip-card.flipped .flip-card-inner,
    .flip-card.matched .flip-card-inner {
        transform: rotateY(180deg);
    }

    .flip-card-front,
    .flip-card-back {
        position: absolute;
        width: 100%;
        height: 100%;
        backface-visibility: hidden;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 3px solid var(--memory-yellow);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }

    .flip-card-front {
        background: linear-gradient(135deg, var(--memory-yellow) 0%, #FFC107 100%);
        color: #1F2933;
        font-size: 3rem;
        font-weight: bold;
    }

    .flip-card-back {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        transform: rotateY(180deg);
        color: var(--memory-yellow);
    }

    .flip-card-back i {
        font-size: 3.5rem;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
        animation: float 3s ease-in-out infinite;
    }

    .flip-card.matched .flip-card-back {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border-color: #28a745;
        animation: matchPulse 0.6s ease;
    }

    .flip-card.matched .flip-card-back i {
        color: white;
        animation: matchSpin 0.8s ease;
    }

    /* ========================================
       Animations
       ======================================== */
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    @keyframes matchPulse {
        0%, 100% { transform: rotateY(180deg) scale(1); }
        50% { transform: rotateY(180deg) scale(1.15); }
    }

    @keyframes matchSpin {
        0% { transform: rotate(0deg) scale(1); }
        50% { transform: rotate(180deg) scale(1.3); }
        100% { transform: rotate(360deg) scale(1); }
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-10px); }
        75% { transform: translateX(10px); }
    }

    .flip-card.wrong .flip-card-inner {
        animation: shake 0.5s ease;
    }

    /* Button Styles - Selaras dengan Home */
    .btn-new-game,
    .btn-reset-game,
    .btn-back-home {
        background: var(--memory-yellow) !important;
        color: #000 !important;
        border: 2px solid var(--memory-yellow) !important;
        font-weight: 700;
        letter-spacing: 0.5px;
        border-radius: 25px;
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .btn-new-game:hover,
    .btn-reset-game:hover,
    .btn-back-home:hover {
        background: transparent !important;
        color: var(--memory-yellow) !important;
        border-color: var(--memory-yellow) !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(250, 204, 21, 0.3);
    }

    /* Difficulty Buttons */
    .difficulty-btn {
        transition: all 0.3s ease;
        border: 2px solid;
        font-weight: 600;
        border-radius: 20px;
    }

    .difficulty-btn.active {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(250, 204, 21, 0.3);
    }

    /* ========================================
       Responsive Design
       ======================================== */
    @media (max-width: 992px) {
        .game-board {
            gap: 10px;
            padding: 20px;
        }
        
        .flip-card-front { font-size: 2rem; }
        .flip-card-back i { font-size: 2.5rem; }
    }

    @media (max-width: 576px) {
        .game-board {
            gap: 8px;
            padding: 15px;
        }
        
        .game-board.medium,
        .game-board.hard {
            grid-template-columns: repeat(4, 1fr);
        }
        
        .flip-card-front { font-size: 1.5rem; }
        .flip-card-back i { font-size: 2rem; }
        
        .memory-title { 
            font-size: 2rem !important;
            letter-spacing: 1px;
        }
        .memory-subtitle {
            font-size: 1.1rem !important;
        }
    }

    /* ========================================
       Accessibility - Focus States
       ======================================== */
    .flip-card:focus {
        outline: 3px solid var(--memory-yellow);
        outline-offset: 3px;
    }

    .difficulty-btn:focus,
    button:focus,
    a:focus {
        outline: 3px solid var(--memory-yellow);
        outline-offset: 3px;
    }
</style>
@endsection

{{-- SCRIPT GAME --}}
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
<script>
// Helper function to get translation
function getTrans(key) {
    const lang = localStorage.getItem('language') || 'en';
    return window.translations?.[lang]?.[key] || key;
}

// Game Configuration
const GAME_CONFIG = {
    CONFETTI_COLORS: ['#FACC15', '#FFC107', '#28a745'],
    SWAL_THEME: {
        background: '#ffffff',
        color: '#1F2933',
        confirmButtonColor: '#FACC15'
    },
    RATING_THRESHOLDS: {
        EXCELLENT: 5,
        GOOD: 10
    },
    FLIP_DELAY: 800,
    WRONG_CARD_DELAY: 600
};

// Fossil cards data dengan icon FontAwesome yang lebih relevan
const fossilIcons = {
    easy: [
        { name: 'trilobite', icon: 'fa-bug' },
        { name: 'ammonite', icon: 'fa-compact-disc' },
        { name: 'dinosaur', icon: 'fa-dragon' },
        { name: 'mammoth', icon: 'fa-hippo' },
        { name: 'fern', icon: 'fa-leaf' },
        { name: 'shark-tooth', icon: 'fa-fish' }
    ],
    medium: [
        { name: 'trilobite', icon: 'fa-bug' },
        { name: 'ammonite', icon: 'fa-compact-disc' },
        { name: 'dinosaur', icon: 'fa-dragon' },
        { name: 'mammoth', icon: 'fa-hippo' },
        { name: 'fern', icon: 'fa-leaf' },
        { name: 'shark-tooth', icon: 'fa-fish' },
        { name: 'shell', icon: 'fa-fan' },
        { name: 'bone', icon: 'fa-bone' }
    ],
    hard: [
        { name: 'trilobite', icon: 'fa-bug' },
        { name: 'ammonite', icon: 'fa-compact-disc' },
        { name: 'dinosaur', icon: 'fa-dragon' },
        { name: 'mammoth', icon: 'fa-hippo' },
        { name: 'fern', icon: 'fa-leaf' },
        { name: 'shark-tooth', icon: 'fa-fish' },
        { name: 'shell', icon: 'fa-fan' },
        { name: 'bone', icon: 'fa-bone' },
        { name: 'crab', icon: 'fa-spider' },
        { name: 'coral', icon: 'fa-fire-alt' }
    ]
};

let gameState = {
    cards: [],
    flipped: [],
    matched: [],
    moves: 0,
    timer: 0,
    timerInterval: null,
    difficulty: 'easy',
    isProcessing: false
};

// Set Difficulty
function setDifficulty(level) {
    try {
        if (!fossilIcons[level]) {
            console.error('Invalid difficulty level:', level);
            return;
        }
        
        gameState.difficulty = level;
        
        // Update button active state
        const buttons = document.querySelectorAll('.difficulty-btn');
        buttons.forEach(btn => btn.classList.remove('active'));
        
        if (event && event.target) {
            const clickedBtn = event.target.closest('.difficulty-btn');
            if (clickedBtn) {
                clickedBtn.classList.add('active');
            }
        }
        
        startGame();
    } catch (error) {
        console.error('Error setting difficulty:', error);
    }
}

// Shuffle Array
function shuffle(array) {
    const newArray = [...array];
    for (let i = newArray.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [newArray[i], newArray[j]] = [newArray[j], newArray[i]];
    }
    return newArray;
}

// Start Game
function startGame() {
    try {
        // Reset game state
        gameState.flipped = [];
        gameState.matched = [];
        gameState.moves = 0;
        gameState.timer = 0;
        gameState.isProcessing = false;
        
        // Clear timer
        if (gameState.timerInterval) {
            clearInterval(gameState.timerInterval);
        }
        
        // Update UI
        const movesEl = document.getElementById('moves');
        const timerEl = document.getElementById('timer');
        const pairsEl = document.getElementById('pairs');
        
        if (!movesEl || !timerEl || !pairsEl) {
            throw new Error('Required UI elements not found');
        }
        
        movesEl.textContent = '0';
        timerEl.textContent = '00:00';
        pairsEl.textContent = '0';
    
        // Get cards based on difficulty
        const selectedFossils = fossilIcons[gameState.difficulty];
        const totalPairsEl = document.getElementById('totalPairs');
        
        if (totalPairsEl) {
            totalPairsEl.textContent = selectedFossils.length;
        }
        
        // Create card pairs and shuffle
        gameState.cards = shuffle([...selectedFossils, ...selectedFossils]);
        
        // Render board
        renderBoard();
        
        // Start timer
        startTimer();
    } catch (error) {
        console.error('Error starting game:', error);
        alert('Failed to start game. Please refresh the page.');
    }
}

// Render Board
function renderBoard() {
    try {
        const board = document.getElementById('gameBoard');
        
        if (!board) {
            throw new Error('Game board element not found');
        }
        
        board.innerHTML = '';
        board.className = `game-board ${gameState.difficulty}`;
        
        gameState.cards.forEach((card, index) => {
            const cardElement = document.createElement('div');
            cardElement.className = 'flip-card';
            cardElement.dataset.index = index;
            cardElement.dataset.name = card.name;
            
            cardElement.innerHTML = `
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <span aria-hidden="true">?</span>
                    </div>
                    <div class="flip-card-back">
                        <i class="fas ${card.icon}" aria-hidden="true"></i>
                    </div>
                </div>
            `;
            
            cardElement.setAttribute('role', 'button');
            cardElement.setAttribute('tabindex', '0');
            cardElement.setAttribute('aria-label', `Card ${index + 1}, ${card.name}`);
            cardElement.addEventListener('click', () => flipCard(cardElement, index));
            cardElement.addEventListener('keypress', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    flipCard(cardElement, index);
                }
            });
            board.appendChild(cardElement);
        });
        
        updateProgress();
    } catch (error) {
        console.error('Error rendering board:', error);
    }
}

// Flip Card
function flipCard(cardElement, index) {
    // Prevent flipping if processing or card already flipped/matched
    if (gameState.isProcessing || 
        cardElement.classList.contains('flipped') || 
        cardElement.classList.contains('matched') ||
        gameState.flipped.length >= 2) {
        return;
    }
    
    // Flip card
    cardElement.classList.add('flipped');
    gameState.flipped.push({ element: cardElement, index: index, name: gameState.cards[index].name });
    
    // Check for match when 2 cards are flipped
    if (gameState.flipped.length === 2) {
        gameState.isProcessing = true;
        gameState.moves++;
        const movesEl = document.getElementById('moves');
        if (movesEl) {
            movesEl.textContent = gameState.moves;
        }
        
        setTimeout(() => {
            checkMatch();
        }, GAME_CONFIG.FLIP_DELAY);
    }
}

// Check Match
function checkMatch() {
    try {
        const [card1, card2] = gameState.flipped;
        
        if (card1.name === card2.name && card1.index !== card2.index) {
            // Match found
            card1.element.classList.add('matched');
            card2.element.classList.add('matched');
            gameState.matched.push(card1.index, card2.index);
            
            // Update pairs counter
            const pairsEl = document.getElementById('pairs');
            if (pairsEl) {
                pairsEl.textContent = gameState.matched.length / 2;
            }
        
        // Check if game completed
        if (gameState.matched.length === gameState.cards.length) {
            setTimeout(() => {
                gameCompleted();
            }, 500);
        }
        } else {
            // No match - flip back
            card1.element.classList.add('wrong');
            card2.element.classList.add('wrong');
            
            setTimeout(() => {
                card1.element.classList.remove('flipped', 'wrong');
                card2.element.classList.remove('flipped', 'wrong');
            }, GAME_CONFIG.WRONG_CARD_DELAY);
        }
        
        gameState.flipped = [];
        gameState.isProcessing = false;
        updateProgress();
    } catch (error) {
        console.error('Error checking match:', error);
        gameState.flipped = [];
        gameState.isProcessing = false;
    }
}

// Update Progress Bar
function updateProgress() {
    const total = gameState.cards.length / 2;
    const completed = gameState.matched.length / 2;
    const percentage = Math.round((completed / total) * 100);
    
    const progressBar = document.getElementById('progressBar');
    progressBar.style.width = percentage + '%';
    progressBar.querySelector('span').innerHTML = `${percentage}% <span data-lang-key="memory_complete">${getTrans('memory_complete')}</span>`;
}

// Start Timer
function startTimer() {
    gameState.timerInterval = setInterval(() => {
        gameState.timer++;
        const mins = Math.floor(gameState.timer / 60);
        const secs = gameState.timer % 60;
        document.getElementById('timer').textContent = 
            `${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
    }, 1000);
}

// Game Completed
function gameCompleted() {
    clearInterval(gameState.timerInterval);
    
    // Confetti celebration
    if (typeof confetti === 'function') {
        confetti({
            particleCount: 200,
            spread: 100,
            origin: { y: 0.6 },
            colors: GAME_CONFIG.CONFETTI_COLORS
        });
        
        setTimeout(() => {
            confetti({
                particleCount: 150,
                angle: 60,
                spread: 80,
                origin: { x: 0 }
            });
            confetti({
                particleCount: 150,
                angle: 120,
                spread: 80,
                origin: { x: 1 }
            });
        }, 250);
    }
    
    const mins = Math.floor(gameState.timer / 60);
    const secs = gameState.timer % 60;
    const timeStr = `${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
    
    // Calculate rating
    let rating = '⭐⭐⭐';
    const optimalMoves = gameState.cards.length / 2;
    if (gameState.moves <= optimalMoves + GAME_CONFIG.RATING_THRESHOLDS.EXCELLENT) {
        rating = '⭐⭐⭐⭐⭐';
    } else if (gameState.moves <= optimalMoves + GAME_CONFIG.RATING_THRESHOLDS.GOOD) {
        rating = '⭐⭐⭐⭐';
    }
    
    setTimeout(() => {
        Swal.fire({
            title: '🎉 ' + getTrans('memory_congrats'),
            html: `
                <div class="text-center">
                    <p class="fs-4 mb-3">${getTrans('memory_completed')}</p>
                    <div class="bg-dark bg-opacity-50 p-4 rounded-3 mb-3">
                        <p class="text-warning fs-3 fw-bold mb-2">⏱️ ${getTrans('memory_time_label')} ${timeStr}</p>
                        <p class="text-info fs-3 fw-bold mb-2">🎯 ${getTrans('memory_moves_label')} ${gameState.moves}</p>
                        <p class="text-success fs-3 fw-bold mb-2">🏆 ${getTrans('memory_level')} ${gameState.difficulty.toUpperCase()}</p>
                        <p class="fs-2 mt-3">${rating}</p>
                    </div>
                    <p class="text-muted fs-6">${getTrans('memory_try_harder')}</p>
                </div>
            `,
            icon: 'success',
            ...GAME_CONFIG.SWAL_THEME,
            confirmButtonText: '<i class="fas fa-play me-2"></i>' + getTrans('memory_play_again'),
            showCancelButton: true,
            cancelButtonColor: '#6c757d',
            cancelButtonText: getTrans('memory_close')
        }).then((result) => {
            if (result.isConfirmed) {
                startGame();
            }
        });
    }, 800);
}

// Reset Game
function resetGame() {
    Swal.fire({
        title: getTrans('memory_reset_title'),
        text: getTrans('memory_reset_text'),
        icon: 'question',
        showCancelButton: true,
        ...GAME_CONFIG.SWAL_THEME,
        cancelButtonColor: '#6c757d',
        confirmButtonText: getTrans('memory_reset_confirm'),
        cancelButtonText: getTrans('memory_reset_cancel')
    }).then((result) => {
        if (result.isConfirmed) {
            startGame();
        }
    });
}

// Initialize game on page load
try {
    if (!fossilIcons || Object.keys(fossilIcons).length === 0) {
        throw new Error('Fossil icons data not loaded');
    }
    startGame();
} catch (error) {
    console.error('Failed to initialize game:', error);
    const swalConfig = typeof GAME_CONFIG !== 'undefined' ? GAME_CONFIG.SWAL_THEME : {
        background: '#1a1a1a',
        color: '#fff',
        confirmButtonColor: '#FFD400'
    };
    Swal.fire({
        title: 'Error!',
        text: 'Failed to load the game. Please refresh the page.',
        icon: 'error',
        ...swalConfig
    });
}

// Listen for language change events
document.addEventListener('languageChanged', function() {
    console.log('Language changed, updating Memory Match game...');
    // Update progress bar text
    updateProgress();
});
</script>
@endsection