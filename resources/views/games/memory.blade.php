{{-- resources/views/games/memory.blade.php --}}
@extends('layouts.app')

@section('title', 'Fossil Memory Match')

@section('content')
<section class="min-vh-100 d-flex align-items-center py-5">
    <div class="container py-4">

        <!-- Judul Utama -->
        <div class="text-center mb-5">
            <h1 class="display-2 fw-bold mb-3 memory-title memory-title-outline">
                Fossil Memory Match
            </h1>
            <p class="fs-3 text-dark opacity-95 memory-subtitle">
                Find matching pairs of ancient fossils!
            </p>
            
            <!-- Score & Timer -->
            <div class="d-flex justify-content-center gap-4 mt-4 flex-wrap" role="status" aria-live="polite">
                <div class="badge bg-dark border border-warning fs-5 px-4 py-2">
                    <i class="fas fa-shoe-prints text-warning me-2" aria-hidden="true"></i>
                    Moves: <span id="moves" class="text-warning" aria-label="Number of moves">0</span>
                </div>
                <div class="badge bg-dark border border-danger fs-5 px-4 py-2">
                    <i class="fas fa-clock text-danger me-2" aria-hidden="true"></i>
                    Time: <span id="timer" class="text-danger" aria-label="Elapsed time">00:00</span>
                </div>
                <div class="badge bg-dark border border-warning fs-5 px-4 py-2">
                    <i class="fas fa-trophy text-warning me-2" aria-hidden="true"></i>
                    Pairs: <span id="pairs" class="text-warning" aria-label="Matched pairs">0</span>/<span id="totalPairs" class="text-warning">6</span>
                </div>
            </div>
        </div>

        <!-- Card Game Utama -->
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                <div class="card bg-dark bg-opacity-94 border-0 shadow-2xl rounded-4 overflow-hidden memory-card">
                    <div class="card-body p-4 p-xl-5">

                        <!-- Game Board -->
                        <div id="gameBoard" class="game-board mx-auto mb-4" role="group" aria-label="Memory game cards"></div>

                        <!-- Progress Bar -->
                        <div class="mt-4 mb-4">
                            <label class="form-label text-dark fw-bold mb-2">
                                <i class="fas fa-chart-line me-2"></i>Progress Bar
                            </label>
                            <div class="progress memory-progress">
                                <div id="progressBar" class="progress-bar bg-success progress-bar-striped progress-bar-animated" 
                                     role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                    <span class="fw-bold fs-6">0% Complete</span>
                                </div>
                            </div>
                        </div>

                        <!-- Difficulty Selection -->
                        <div class="text-center mb-4">
                            <h4 class="text-warning mb-3">
                                <i class="fas fa-sliders-h me-2" aria-hidden="true"></i>Difficulty Level
                            </h4>
                            <div class="btn-group" role="group" aria-label="Difficulty level selection">
                                <button type="button" class="btn btn-outline-success difficulty-btn active" onclick="setDifficulty('easy')" aria-label="Easy mode with 6 pairs">
                                    <i class="fas fa-smile me-2" aria-hidden="true"></i>Easy (6 pairs)
                                </button>
                                <button type="button" class="btn btn-outline-warning difficulty-btn" onclick="setDifficulty('medium')" aria-label="Medium mode with 8 pairs">
                                    <i class="fas fa-meh me-2" aria-hidden="true"></i>Medium (8 pairs)
                                </button>
                                <button type="button" class="btn btn-outline-danger difficulty-btn" onclick="setDifficulty('hard')" aria-label="Hard mode with 10 pairs">
                                    <i class="fas fa-fire me-2" aria-hidden="true"></i>Hard (10 pairs)
                                </button>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="text-center mt-4">
                            <button onclick="startGame()" 
                                    class="btn btn-success btn-lg px-5 py-3 me-3 fw-bold shadow-lg hover-lift"
                                    aria-label="Start a new game">
                                <i class="fas fa-play me-2" aria-hidden="true"></i>New Game
                            </button>
                            <button onclick="resetGame()" 
                                    class="btn btn-danger btn-lg px-5 py-3 me-3 fw-bold shadow-lg hover-lift"
                                    aria-label="Reset current game">
                                <i class="fas fa-redo me-2" aria-hidden="true"></i>Reset
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Kembali -->
        <div class="text-center mt-5">
            <a href="{{ route('games.index') }}" 
               class="btn btn-warning btn-lg px-5 py-3 fw-bold text-dark shadow-lg hover-lift"
               aria-label="Go back to mini games menu">
                <i class="fas fa-arrow-left me-2" aria-hidden="true"></i>Back to Mini Games
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
        --memory-yellow: #FFD400;
        --memory-dark: #1a1a1a;
        --memory-shadow: rgba(0, 0, 0, 0.8);
    }

    /* Title Styles */
    .memory-title {
        text-shadow: 0 10px 30px var(--memory-shadow);
        letter-spacing: 4px;
    }

    .memory-title-outline {
        color: var(--mg-black);
        -webkit-text-stroke: 3px var(--memory-yellow);
        text-stroke: 3px var(--memory-yellow);
        paint-order: stroke fill;
    }

    .memory-subtitle {
        text-shadow: 0 4px 12px rgba(0, 0, 0, 0.7);
    }

    /* Memory Card */
    .memory-card {
        border: 5px solid var(--memory-yellow) !important;
        backdrop-filter: blur(18px);
    }

    /* Progress Bar */
    .memory-progress {
        height: 35px;
        background: var(--memory-dark);
        border: 2px solid var(--memory-yellow);
    }

    /* ========================================
       Game Board Grid
       ======================================== */
    .game-board {
        display: grid;
        gap: 15px;
        padding: 30px;
        background: linear-gradient(135deg, #0a0a0a 0%, var(--memory-dark) 100%);
        border-radius: 25px;
        border: 4px solid var(--memory-yellow);
        box-shadow: 0 0 50px rgba(255,212,0,0.5);
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
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 4px solid var(--memory-yellow);
        box-shadow: 0 8px 16px rgba(0,0,0,0.4);
    }

    .flip-card-front {
        background: linear-gradient(135deg, var(--memory-yellow) 0%, #FFA500 100%);
        color: var(--memory-dark);
        font-size: 3rem;
        font-weight: bold;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }

    .flip-card-back {
        background: linear-gradient(135deg, var(--memory-dark) 0%, #2d2d2d 100%);
        transform: rotateY(180deg);
        color: var(--memory-yellow);
    }

    .flip-card-back i {
        font-size: 3.5rem;
        filter: drop-shadow(0 0 10px rgba(255,212,0,0.5));
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

    /* Difficulty Buttons */
    .difficulty-btn {
        transition: all 0.3s ease;
        border: 2px solid;
        font-weight: bold;
    }

    .difficulty-btn.active {
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(255,212,0,0.4);
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
    }

    /* Hover Lift */
    .hover-lift {
        transition: all 0.4s ease;
    }
    .hover-lift:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(255,212,0,0.5) !important;
    }

    /* Shadow 2XL */
    .shadow-2xl {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
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
// Game Configuration
const GAME_CONFIG = {
    CONFETTI_COLORS: ['#FFD400', '#FFA500', '#28a745'],
    SWAL_THEME: {
        background: '#1a1a1a',
        color: '#fff',
        confirmButtonColor: '#FFD400'
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
    progressBar.querySelector('span').textContent = percentage + '% Complete';
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
            title: '🎉 Congratulations!',
            html: `
                <div class="text-center">
                    <p class="fs-4 mb-3">You completed the Fossil Memory Match!</p>
                    <div class="bg-dark bg-opacity-50 p-4 rounded-3 mb-3">
                        <p class="text-warning fs-3 fw-bold mb-2">⏱️ Time: ${timeStr}</p>
                        <p class="text-info fs-3 fw-bold mb-2">🎯 Moves: ${gameState.moves}</p>
                        <p class="text-success fs-3 fw-bold mb-2">🏆 Level: ${gameState.difficulty.toUpperCase()}</p>
                        <p class="fs-2 mt-3">${rating}</p>
                    </div>
                    <p class="text-muted fs-6">Try a harder difficulty for more challenge!</p>
                </div>
            `,
            icon: 'success',
            ...GAME_CONFIG.SWAL_THEME,
            confirmButtonText: '<i class="fas fa-play me-2"></i>Play Again!',
            showCancelButton: true,
            cancelButtonColor: '#6c757d',
            cancelButtonText: 'Close'
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
        title: 'Reset game?',
        text: "Your current progress will be lost!",
        icon: 'question',
        showCancelButton: true,
        ...GAME_CONFIG.SWAL_THEME,
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, reset!',
        cancelButtonText: 'Cancel'
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
</script>
@endsection