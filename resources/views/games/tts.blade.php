{{-- resources/views/games/tts.blade.php --}}
@extends('layouts.app')

@section('title', 'Geology Crossword Puzzle')

@section('content')
<section class="min-vh-100 d-flex align-items-center py-5">
    <div class="container py-4">

        <!-- Judul Utama -->
        <div class="text-center mb-5">
            <h1 class="display-2 fw-bold mb-3 game-title game-title-outline">
                Geology Crossword Puzzle
            </h1>
            <p class="fs-3 text-dark opacity-95 game-subtitle">
                Fill the grid with correct geology terms!
            </p>
            
            <!-- Score & Timer -->
            <div class="d-flex justify-content-center gap-4 mt-4">
                <div class="badge bg-dark border border-danger fs-5 px-4 py-2">
                    <i class="fas fa-clock text-danger me-2"></i>
                    Time: <span id="timer" class="text-danger">00:00</span>
                </div>
                <div class="badge bg-dark border border-warning fs-5 px-4 py-2">
                    <i class="fas fa-check-circle text-warning me-2"></i>
                    Score: <span id="score" class="text-warning">0</span>/<span id="total" class="text-warning">0</span>
                </div>
            </div>
        </div>

        <!-- Card Game Utama -->
        <div class="row justify-content-center">
            <div class="col-12 col-xl-11">
                <div class="card bg-dark bg-opacity-94 border-0 shadow-2xl rounded-4 overflow-hidden game-card">
                    <div class="card-body p-4 p-xl-5 text-white">

                        <div class="row g-4 align-items-start">

                            <!-- Crossword Grid -->
                            <div class="col-lg-7">
                                <div class="bg-black bg-opacity-50 p-4 rounded-3 border-warning border-3">
                                    <div id="crossword" class="mx-auto"></div>
                                </div>
                                
                                <!-- Progress Bar -->
                                <div class="mt-3">
                                    <label class="form-label text-dark fw-bold mb-2">
                                        <i class="fas fa-chart-line me-2"></i>Progress Bar
                                    </label>
                                    <div class="progress game-progress">
                                        <div id="progressBar" class="progress-bar bg-success progress-bar-striped progress-bar-animated" 
                                             role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                            <span class="fw-bold">0%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Clues Section -->
                            <div class="col-lg-5">
                                <h3 class="text-warning fw-bold mb-4 fs-2">
                                    <i class="fas fa-lightbulb me-3"></i>Clues
                                </h3>
                                <div class="clues-container bg-black bg-opacity-40 p-4 rounded-3 border-warning border-2">
                                    
                                    <!-- Across -->
                                    <div class="mb-4">
                                        <h5 class="text-warning fw-bold mb-3 fs-4">
                                            <i class="fas fa-arrow-right me-2"></i>Across
                                        </h5>
                                        <div class="clue-list" id="acrossClues">
                                            <!-- Clues will be generated dynamically -->
                                        </div>
                                    </div>
                                    
                                    <!-- Down -->
                                    <div>
                                        <h5 class="text-warning fw-bold mb-3 fs-4">
                                            <i class="fas fa-arrow-down me-2"></i>Down
                                        </h5>
                                        <div class="clue-list" id="downClues">
                                            <!-- Clues will be generated dynamically -->
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Hint Button -->
                                <div class="mt-3">
                                    <button onclick="giveHint()" class="btn btn-warning btn-sm w-100 fw-bold text-dark">
                                        <i class="fas fa-question-circle me-2"></i><span id="hintText">Get Hint (3 remaining)</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="text-center mt-5">
                            <div class="d-flex flex-wrap justify-content-center gap-3">
                                <button onclick="checkAnswers()" 
                                        class="btn btn-success btn-lg px-5 py-3 fw-bold shadow-lg">
                                    <i class="fas fa-check-double me-2"></i>Check Answers
                                </button>
                                <button onclick="revealAnswer()" 
                                        class="btn btn-warning btn-lg px-5 py-3 fw-bold shadow-lg text-white">
                                    <i class="fas fa-eye me-2"></i>Reveal All
                                </button>
                                <button onclick="resetPuzzle()" 
                                        class="btn btn-danger btn-lg px-5 py-3 fw-bold shadow-lg">
                                    <i class="fas fa-redo me-2"></i>Reset
                                </button>
                            </div>
                        </div>

                        <!-- Hasil -->
                        <div id="result" class="mt-4 text-center fw-bold fs-3"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Kembali -->
        <div class="text-center mt-5">
            <a href="{{ route('games.index') }}" 
               class="btn btn-warning btn-lg px-5 py-3 fw-bold text-dark shadow-lg hover-lift">
                <i class="fas fa-arrow-left me-2"></i>Back to Mini Games
            </a>
        </div>
    </div>
</section>
@endsection

{{-- STYLE KHUSUS TTS --}}
@section('styles')
<style>
    /* Theme Variables */
    :root {
        --game-yellow: #FFD400;
        --game-black: #1a1a1a;
        --game-dark: #0a0a0a;
    }

    /* Title Styles */
    .game-title {
        text-shadow: 0 10px 30px rgba(0,0,0,0.8);
        letter-spacing: 4px;
    }

    .game-title-outline {
        color: var(--mg-black);
        -webkit-text-stroke: 3px var(--game-yellow);
        text-stroke: 3px var(--game-yellow);
        paint-order: stroke fill;
    }

    .game-subtitle {
        text-shadow: 0 4px 12px rgba(0,0,0,0.7);
    }

    /* Game Card */
    .game-card {
        border: 5px solid var(--game-yellow) !important;
        backdrop-filter: blur(18px);
    }

    /* Clue Items */
    .clue-item {
        background: rgba(255,212,0,0.1);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .clue-item:hover {
        background: rgba(255,212,0,0.2);
        transform: translateX(5px);
    }

    /* Progress Bar */
    .game-progress {
        height: 30px;
        background: var(--game-black);
    }

    /* Clues Container */
    .clues-container {
        max-height: 500px;
        overflow-y: auto;
    }

    /* Grid Crossword - Responsive & Beautiful */
    #crossword {
        display: grid;
        gap: 3px;
        grid-template-columns: repeat(12, 1fr);
        background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 100%);
        padding: 20px;
        border-radius: 20px;
        border: 4px solid #FFD400;
        box-shadow: 0 0 40px rgba(255,212,0,0.4);
        max-width: 650px;
        margin: 0 auto;
    }

    .cw-cell {
        aspect-ratio: 1;
        min-width: 0;
        background: #1a1a1a;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        box-shadow: inset 0 0 10px rgba(0,0,0,0.5);
    }

    .cw-cell.has-number::before {
        content: attr(data-number);
        position: absolute;
        top: 2px;
        left: 4px;
        font-size: 0.7rem;
        color: #FFD400;
        font-weight: bold;
        z-index: 1;
    }

    .cw-cell input {
        width: 100%;
        height: 100%;
        text-align: center;
        font-size: clamp(1rem, 2vw, 1.5rem);
        font-weight: bold;
        background: rgba(255,255,255,0.08);
        border: 2px solid #FFD400;
        color: white;
        border-radius: 6px;
        text-transform: uppercase;
        transition: all 0.3s ease;
        padding: 0;
    }

    .cw-cell input:focus {
        background: rgba(255,212,0,0.25) !important;
        border-color: #FFD700;
        outline: 3px solid rgba(255,212,0,0.4);
        box-shadow: 0 0 20px rgba(255,212,0,0.6);
        transform: scale(1.05);
        z-index: 10;
    }

    .cw-cell input.correct {
        background: #28a745 !important;
        border-color: #28a745 !important;
        color: white;
        animation: correctPulse 0.6s ease;
    }

    .cw-cell input.wrong {
        background: #dc3545 !important;
        border-color: #dc3545 !important;
        color: white;
        animation: shake 0.5s ease;
    }

    .cw-cell input.hint {
        background: rgba(0,123,255,0.5) !important;
        border-color: #007bff !important;
        animation: hintGlow 1s ease;
    }

    @keyframes correctPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.15); }
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }

    @keyframes hintGlow {
        0%, 100% { box-shadow: 0 0 10px rgba(0,123,255,0.5); }
        50% { box-shadow: 0 0 25px rgba(0,123,255,1); }
    }

    /* Responsive Grid */
    @media (max-width: 1200px) {
        #crossword {
            grid-template-columns: repeat(12, 1fr);
            gap: 2px;
            padding: 15px;
        }
    }

    @media (max-width: 768px) {
        #crossword {
            grid-template-columns: repeat(12, 1fr);
            gap: 2px;
            padding: 10px;
        }
        .cw-cell input { font-size: 1rem; }
    }

    /* Hover Lift Tombol */
    .hover-lift {
        transition: all 0.4s ease;
    }
    .hover-lift:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 50px rgba(255,212,0,0.5) !important;
    }

    /* Scrollbar Custom */
    .clues-container::-webkit-scrollbar {
        width: 8px;
    }
    .clues-container::-webkit-scrollbar-track {
        background: rgba(255,212,0,0.1);
        border-radius: 10px;
    }
    .clues-container::-webkit-scrollbar-thumb {
        background: #FFD400;
        border-radius: 10px;
    }

    /* Shadow 2XL */
    .shadow-2xl {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
    }
</style>
@endsection

{{-- SCRIPT GAME --}}
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Constants
const GAME_CONFIG = {
    GRID_SIZE: 12,
    INITIAL_HINTS: 3,
    SWAL_THEME: {
        background: '#1a1a1a',
        color: '#fff',
        confirmButtonColor: '#FFD400'
    }
};

// Data Crossword dengan clues terintegrasi
const crosswordData = [
    { 
        word: 'IGNEOUS', 
        x: 2, 
        y: 3, 
        direction: 'across', 
        number: 1,
        clue: 'Rock formed from cooled magma'
    },
    { 
        word: 'FOSSIL', 
        x: 5, 
        y: 1, 
        direction: 'down', 
        number: 2,
        clue: 'Preserved remains of ancient life'
    },
    { 
        word: 'PLATE', 
        x: 5, 
        y: 5, 
        direction: 'down', 
        number: 3,
        clue: 'Tectonic ___ moves continents'
    },
    { 
        word: 'QUARTZ', 
        x: 3, 
        y: 8, 
        direction: 'across', 
        number: 4,
        clue: 'Most common mineral on Earth'
    }
];

let timerInterval;
let seconds = 0;
let hintsRemaining = GAME_CONFIG.INITIAL_HINTS;

// Generate Clues Dynamically
function generateClues() {
    const acrossContainer = document.getElementById('acrossClues');
    const downContainer = document.getElementById('downClues');
    
    if (!acrossContainer || !downContainer) {
        console.error('Clue containers not found');
        return;
    }
    
    acrossContainer.innerHTML = '';
    downContainer.innerHTML = '';
    
    crosswordData.forEach(item => {
        const clueDiv = document.createElement('div');
        clueDiv.className = 'clue-item mb-3 p-3 rounded';
        clueDiv.innerHTML = `
            <span class="badge bg-warning text-dark fw-bold me-2">${item.number}</span>
            <span class="fs-6">${item.clue} (${item.word.length} letters)</span>
        `;
        
        if (item.direction === 'across') {
            acrossContainer.appendChild(clueDiv);
        } else {
            downContainer.appendChild(clueDiv);
        }
    });
}

// Create Crossword Grid
function createCrossword() {
    const grid = document.getElementById('crossword');
    
    if (!grid) {
        console.error('Crossword grid element not found');
        return;
    }
    
    grid.innerHTML = '';
    
    // Buat grid dengan ukuran dari config
    const gridSize = GAME_CONFIG.GRID_SIZE;
    const cells = [];
    
    // Initialize semua cell sebagai kosong
    for (let i = 0; i < gridSize; i++) {
        cells[i] = [];
        for (let j = 0; j < gridSize; j++) {
            cells[i][j] = { hasInput: false, letter: '', number: null };
        }
    }
    
    // Mark cells yang ada huruf
    crosswordData.forEach(item => {
        for (let i = 0; i < item.word.length; i++) {
            if (item.direction === 'across') {
                const row = item.y;
                const col = item.x + i;
                cells[row][col] = {
                    hasInput: true,
                    letter: item.word[i],
                    number: i === 0 ? item.number : cells[row][col].number
                };
            } else { // down
                const row = item.y + i;
                const col = item.x;
                cells[row][col] = {
                    hasInput: true,
                    letter: item.word[i],
                    number: i === 0 ? item.number : cells[row][col].number
                };
            }
        }
    });
    
    // Render grid
    let totalCells = 0;
    for (let i = 0; i < gridSize; i++) {
        for (let j = 0; j < gridSize; j++) {
            const cellDiv = document.createElement('div');
            cellDiv.className = 'cw-cell';
            
            if (cells[i][j].hasInput) {
                const input = document.createElement('input');
                input.type = 'text';
                input.maxLength = 1;
                input.dataset.answer = cells[i][j].letter;
                input.dataset.row = i;
                input.dataset.col = j;
                input.setAttribute('aria-label', `Cell row ${i + 1}, column ${j + 1}`);
                input.setAttribute('autocomplete', 'off');
                input.addEventListener('input', handleInput);
                input.addEventListener('keydown', handleKeydown);
                cellDiv.appendChild(input);
                totalCells++;
                
                // Tambahkan nomor jika ada
                if (cells[i][j].number) {
                    cellDiv.classList.add('has-number');
                    cellDiv.dataset.number = cells[i][j].number;
                }
            } else {
                cellDiv.style.background = 'transparent';
                cellDiv.style.border = 'none';
            }
            
            grid.appendChild(cellDiv);
        }
    }
    
    document.getElementById('total').textContent = totalCells;
    startTimer();
}

// Handle input dengan auto-focus ke cell berikutnya
function handleInput(e) {
    const input = e.target;
    const val = input.value.toUpperCase();
    
    if (val.length === 1) {
        input.value = val;
        
        // Auto-check individual cell
        if (val === input.dataset.answer) {
            input.classList.remove('wrong');
            input.classList.add('correct');
            updateScore();
        } else {
            input.classList.remove('correct');
        }
        
        // Move to next input
        moveToNextInput(input);
    }
}

// Navigasi dengan arrow keys
function handleKeydown(e) {
    const input = e.target;
    const row = parseInt(input.dataset.row);
    const col = parseInt(input.dataset.col);
    
    let newRow = row, newCol = col;
    
    switch(e.key) {
        case 'ArrowRight':
            newCol++;
            break;
        case 'ArrowLeft':
            newCol--;
            break;
        case 'ArrowDown':
            newRow++;
            break;
        case 'ArrowUp':
            newRow--;
            break;
        case 'Backspace':
            if (!input.value) {
                moveToPrevInput(input);
            }
            return;
        default:
            return;
    }
    
    e.preventDefault();
    const nextInput = document.querySelector(`input[data-row="${newRow}"][data-col="${newCol}"]`);
    if (nextInput) nextInput.focus();
}

function moveToNextInput(current) {
    const allInputs = Array.from(document.querySelectorAll('#crossword input'));
    const currentIndex = allInputs.indexOf(current);
    if (currentIndex < allInputs.length - 1) {
        allInputs[currentIndex + 1].focus();
    }
}

function moveToPrevInput(current) {
    const allInputs = Array.from(document.querySelectorAll('#crossword input'));
    const currentIndex = allInputs.indexOf(current);
    if (currentIndex > 0) {
        allInputs[currentIndex - 1].focus();
    }
}

// Update score real-time
function updateScore() {
    let correct = 0;
    const inputs = document.querySelectorAll('#crossword input');
    inputs.forEach(input => {
        const val = (input.value || '').toUpperCase();
        if (val === input.dataset.answer) {
            correct++;
        }
    });
    
    const total = inputs.length;
    document.getElementById('score').textContent = correct;
    
    // Update progress bar
    const percentage = Math.round((correct / total) * 100);
    const progressBar = document.getElementById('progressBar');
    progressBar.style.width = percentage + '%';
    progressBar.querySelector('span').textContent = percentage + '%';
    
    // Check if completed
    if (correct === total && total > 0) {
        setTimeout(() => {
            gameCompleted();
        }, 500);
    }
}

// Timer
function startTimer() {
    timerInterval = setInterval(() => {
        seconds++;
        const mins = Math.floor(seconds / 60);
        const secs = seconds % 60;
        document.getElementById('timer').textContent = 
            `${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
    }, 1000);
}

// Check Answers dengan feedback
function checkAnswers() {
    let correct = 0, wrong = 0;
    const inputs = document.querySelectorAll('#crossword input');
    
    inputs.forEach(input => {
        const val = (input.value || '').toUpperCase().trim();
        const ans = input.dataset.answer;
        
        input.classList.remove('correct', 'wrong');
        
        if (val === ans) {
            input.classList.add('correct');
            correct++;
        } else if (val !== '') {
            input.classList.add('wrong');
            wrong++;
        }
    });
    
    const total = inputs.length;
    const result = document.getElementById('result');
    
    if (correct === total) {
        result.innerHTML = `<span class="text-success"><i class="fas fa-trophy"></i> PERFECT! All answers correct!</span>`;
        gameCompleted();
    } else if (correct > 0) {
        result.innerHTML = `
            <span class="text-success"><i class="fas fa-check"></i> ${correct} Correct</span> | 
            <span class="text-danger"><i class="fas fa-times"></i> ${wrong} Wrong</span> | 
            <span class="text-secondary">${total - correct - wrong} Empty</span>
        `;
    } else {
        result.innerHTML = `<span class="text-warning"><i class="fas fa-exclamation-triangle"></i> Keep trying!</span>`;
    }
}

// Give Hint
function giveHint() {
    if (hintsRemaining <= 0) {
        Swal.fire({
            title: 'No hints left!',
            text: 'You have used all your hints.',
            icon: 'warning',
            ...GAME_CONFIG.SWAL_THEME
        });
        return;
    }
    
    const emptyInputs = Array.from(document.querySelectorAll('#crossword input'))
        .filter(input => !input.value || input.value.toUpperCase() !== input.dataset.answer);
    
    if (emptyInputs.length === 0) {
        Swal.fire({
            title: 'All filled!',
            text: 'All cells are already filled correctly.',
            icon: 'info',
            ...GAME_CONFIG.SWAL_THEME
        });
        return;
    }
    
    const randomInput = emptyInputs[Math.floor(Math.random() * emptyInputs.length)];
    randomInput.value = randomInput.dataset.answer;
    randomInput.classList.add('hint', 'correct');
    
    hintsRemaining--;
    const hintText = document.getElementById('hintText');
    const hintBtn = document.querySelector('.btn-info');
    
    if (hintText) {
        hintText.textContent = `Get Hint (${hintsRemaining} remaining)`;
    }
    
    if (hintsRemaining === 0 && hintBtn) {
        hintBtn.disabled = true;
    }
    
    updateScore();
}

// Reveal All Answers
function revealAnswer() {
    Swal.fire({
        title: 'Reveal all answers?',
        text: "This will show all the correct answers!",
        icon: 'question',
        showCancelButton: true,
        ...GAME_CONFIG.SWAL_THEME,
        confirmButtonColor: '#17a2b8',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, reveal!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            document.querySelectorAll('#crossword input').forEach(input => {
                input.value = input.dataset.answer;
                input.classList.add('correct');
            });
            updateScore();
        }
    });
}

// Game Completed
function gameCompleted() {
    clearInterval(timerInterval);
    
    const mins = Math.floor(seconds / 60);
    const secs = seconds % 60;
    const timeStr = `${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
    
    Swal.fire({
        title: '🎉 Congratulations!',
        html: `
            <p class="fs-5">You completed the Geology Crossword!</p>
            <p class="text-warning fs-4 fw-bold">⏱️ Time: ${timeStr}</p>
            <p class="text-info">💡 Hints used: ${GAME_CONFIG.INITIAL_HINTS - hintsRemaining}</p>
        `,
        icon: 'success',
        ...GAME_CONFIG.SWAL_THEME,
        confirmButtonText: 'Play Again!'
    }).then((result) => {
        if (result.isConfirmed) {
            resetPuzzle();
        }
    });
}

// Reset Puzzle
function resetPuzzle() {
    clearInterval(timerInterval);
    seconds = 0;
    hintsRemaining = GAME_CONFIG.INITIAL_HINTS;
    
    const resultEl = document.getElementById('result');
    const scoreEl = document.getElementById('score');
    const hintBtn = document.querySelector('.btn-info');
    
    if (resultEl) resultEl.innerHTML = '';
    if (scoreEl) scoreEl.textContent = '0';
    if (hintBtn) {
        hintBtn.disabled = false;
        hintBtn.innerHTML = `<i class="fas fa-question-circle me-2"></i>Get Hint (${GAME_CONFIG.INITIAL_HINTS} remaining)`;
    }
    
    createCrossword();
}

// Initialize
try {
    generateClues();
    createCrossword();
} catch (error) {
    console.error('Failed to initialize crossword game:', error);
    Swal.fire({
        title: 'Error!',
        text: 'Failed to load the game. Please refresh the page.',
        icon: 'error',
        ...GAME_CONFIG.SWAL_THEME
    });
}
</script>
@endsection