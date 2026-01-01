{{-- resources/views/games/tts.blade.php --}}
@extends('layouts.app')

@section('title', 'Geology Crossword Puzzle')

@section('content')
<section class="min-vh-100 d-flex align-items-center py-5">
    <div class="container py-4">

        <!-- Judul Utama -->
        <div class="text-center mb-5">
            <h1 class="display-2 fw-bold mb-4 game-title" data-lang-key="tts_title" style="font-family: 'Merriweather', serif !important; color: #1F2933;">
                Geology Crossword Puzzle
            </h1>
            <p class="fs-4 game-subtitle" data-lang-key="tts_subtitle" style="color: #6c6c6c; font-weight: 500;">
                Fill the grid with correct geology terms!
            </p>
            
            <!-- Score & Timer -->
            <div class="d-flex justify-content-center gap-3 mt-4">
                <div class="badge bg-white border-2 border-danger fs-6 px-4 py-2 shadow-sm">
                    <i class="fas fa-clock text-danger me-2"></i>
                    <span style="color: #1F2933; font-weight: 600;" data-lang-key="tts_time">Time:</span> <span id="timer" class="text-danger fw-bold">00:00</span>
                </div>
                <div class="badge bg-white border-2 fs-6 px-4 py-2 shadow-sm" style="border-color: #FACC15 !important;">
                    <i class="fas fa-check-circle me-2" style="color: #FACC15;"></i>
                    <span style="color: #1F2933; font-weight: 600;" data-lang-key="tts_score">Score:</span> <span id="score" class="fw-bold" style="color: #FACC15;">0</span> <span style="color: #1F2933; font-weight: 600;">/</span> <span id="total" class="fw-bold" style="color: #FACC15;">0</span>
                </div>
            </div>
        </div>

        <!-- Card Game Utama -->
        <div class="row justify-content-center">
            <div class="col-12 col-xl-11">
                <div class="card bg-white border-0 shadow-lg rounded-4 overflow-hidden game-card">
                    <div class="card-body p-4 p-xl-5">

                        <div class="row g-4 align-items-start">

                            <!-- Crossword Grid -->
                            <div class="col-lg-7">
                                <div class="bg-light p-4 rounded-3 border-2" style="border-color: #FACC15 !important;">
                                    <div id="crossword" class="mx-auto"></div>
                                </div>
                                
                                <!-- Progress Bar -->
                                <div class="mt-3">
                                    <label class="form-label fw-bold mb-2" style="color: #1F2933;">
                                        <i class="fas fa-chart-line me-2" style="color: #FACC15;"></i><span data-lang-key="tts_progress">Progress Bar</span>
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
                                <h3 class="fw-bold mb-4 fs-4" style="color: #1F2933;">
                                    <i class="fas fa-lightbulb me-2" style="color: #FACC15;"></i><span data-lang-key="tts_clues">Clues</span>
                                </h3>
                                <div class="clues-container bg-light p-4 rounded-3 border-2" style="border-color: #FACC15 !important;">
                                    
                                    <!-- Across -->
                                    <div class="mb-4">
                                        <h5 class="fw-bold mb-3 fs-5" style="color: #1F2933;">
                                            <i class="fas fa-arrow-right me-2" style="color: #FACC15;"></i><span data-lang-key="tts_across">Across</span>
                                        </h5>
                                        <div class="clue-list" id="acrossClues">
                                            <!-- Clues will be generated dynamically -->
                                        </div>
                                    </div>
                                    
                                    <!-- Down -->
                                    <div>
                                        <h5 class="fw-bold mb-3 fs-5" style="color: #1F2933;">
                                            <i class="fas fa-arrow-down me-2" style="color: #FACC15;"></i><span data-lang-key="tts_down">Down</span>
                                        </h5>
                                        <div class="clue-list" id="downClues">
                                            <!-- Clues will be generated dynamically -->
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Hint Button -->
                                <div class="mt-3">
                                    <button onclick="giveHint()" class="btn btn-hint w-100 fw-bold">
                                        <i class="fas fa-question-circle me-2"></i><span id="hintText">Get Hint (3 remaining)</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="text-center mt-5">
                            <div class="d-flex flex-wrap justify-content-center gap-3">
                                <button onclick="checkAnswers()" 
                                        class="btn btn-check-answer px-4 py-2 fw-bold">
                                    <i class="fas fa-check-double me-2"></i><span data-lang-key="tts_check_answers">Check Answers</span>
                                </button>
                                <button onclick="revealAnswer()" 
                                        class="btn btn-reveal-answer px-4 py-2 fw-bold">
                                    <i class="fas fa-eye me-2"></i><span data-lang-key="tts_reveal_all">Reveal All</span>
                                </button>
                                <button onclick="resetPuzzle()" 
                                        class="btn btn-reset-game px-4 py-2 fw-bold">
                                    <i class="fas fa-redo me-2"></i><span data-lang-key="tts_reset">Reset</span>
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
               class="btn btn-back-home px-4 py-2 fw-bold">
                <i class="fas fa-arrow-left me-2"></i><span data-lang-key="games_back_menu">Back to Mini Games</span>
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
        --game-yellow: #FACC15;
        --game-dark: #1F2933;
        --game-muted: #6c6c6c;
        --game-light: #f8f9fa;
    }

    /* Title Styles */
    .game-title {
        letter-spacing: 2px;
        text-shadow: none;
    }

    .game-subtitle {
        text-shadow: none;
    }

    /* Game Card */
    .game-card {
        transition: all 0.3s ease;
    }

    /* Clue Items */
    .clue-item {
        background: rgba(250, 204, 21, 0.1);
        transition: all 0.3s ease;
        cursor: pointer;
        border-radius: 8px;
        padding: 0.5rem;
        margin-bottom: 0.5rem;
        border-left: 3px solid transparent;
    }

    .clue-item:hover {
        background: rgba(250, 204, 21, 0.2);
        border-left-color: var(--game-yellow);
        transform: translateX(5px);
    }

    /* Progress Bar */
    .game-progress {
        height: 25px;
        background: #e9ecef;
        border-radius: 12px;
    }

    /* Clues Container */
    .clues-container {
        max-height: 500px;
        overflow-y: auto;
    }

    /* Grid Crossword - Modern & Clean */
    #crossword {
        display: grid;
        gap: 3px;
        grid-template-columns: repeat(12, 1fr);
        background: #ffffff;
        padding: 20px;
        border-radius: 15px;
        border: 2px solid var(--game-yellow);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        max-width: 650px;
        margin: 0 auto;
    }

    .cw-cell {
        aspect-ratio: 1;
        min-width: 0;
        background: #f8f9fa;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .cw-cell.has-number::before {
        content: attr(data-number);
        position: absolute;
        top: 2px;
        left: 4px;
        font-size: 0.65rem;
        color: var(--game-yellow);
        font-weight: bold;
        z-index: 1;
    }

    .cw-cell input {
        width: 100%;
        height: 100%;
        text-align: center;
        font-size: clamp(1rem, 2vw, 1.5rem);
        font-weight: bold;
        background: #ffffff;
        border: 2px solid #dee2e6;
        color: #1F2933;
        border-radius: 6px;
        text-transform: uppercase;
        transition: all 0.3s ease;
        padding: 0;
    }

    .cw-cell input:focus {
        background: rgba(250, 204, 21, 0.15) !important;
        border-color: var(--game-yellow);
        outline: 2px solid rgba(250, 204, 21, 0.3);
        box-shadow: 0 0 12px rgba(250, 204, 21, 0.4);
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

    /* Button Styles - Selaras dengan Home */
    .btn-hint,
    .btn-check-answer,
    .btn-reveal-answer,
    .btn-reset-game,
    .btn-back-home {
        background: var(--game-yellow) !important;
        color: #000 !important;
        border: 2px solid var(--game-yellow) !important;
        font-weight: 700;
        letter-spacing: 0.5px;
        border-radius: 25px;
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .btn-hint:hover,
    .btn-check-answer:hover,
    .btn-reveal-answer:hover,
    .btn-reset-game:hover,
    .btn-back-home:hover {
        background: transparent !important;
        color: var(--game-yellow) !important;
        border-color: var(--game-yellow) !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(250, 204, 21, 0.3);
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
        .game-title { 
            font-size: 2rem !important; 
            letter-spacing: 1px;
        }
        .game-subtitle {
            font-size: 1.1rem !important;
        }
    }

    /* Scrollbar Custom */
    .clues-container::-webkit-scrollbar {
        width: 8px;
    }
    .clues-container::-webkit-scrollbar-track {
        background: rgba(250, 204, 21, 0.1);
        border-radius: 10px;
    }
    .clues-container::-webkit-scrollbar-thumb {
        background: var(--game-yellow);
        border-radius: 10px;
    }
    .clues-container::-webkit-scrollbar-thumb:hover {
        background: #e6b800;
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
        background: '#ffffff',
        color: '#1F2933',
        confirmButtonColor: '#FACC15'
    }
};

// Data Crossword English Version
const crosswordDataEN = [
    { 
        word: 'IGNEOUS', 
        x: 2, 
        y: 3, 
        direction: 'across', 
        number: 1,
        clue: 'Rock formed from cooled magma',
        clueKey: 'tts_clue1'
    },
    { 
        word: 'FOSSIL', 
        x: 5, 
        y: 1, 
        direction: 'down', 
        number: 2,
        clue: 'Preserved remains of ancient life',
        clueKey: 'tts_clue2'
    },
    { 
        word: 'PLATE', 
        x: 5, 
        y: 5, 
        direction: 'down', 
        number: 3,
        clue: 'Tectonic ___ moves continents',
        clueKey: 'tts_clue3'
    },
    { 
        word: 'QUARTZ', 
        x: 3, 
        y: 8, 
        direction: 'across', 
        number: 4,
        clue: 'Most common mineral on Earth',
        clueKey: 'tts_clue4'
    }
];

// Data Crossword Indonesian Version
const crosswordDataID = [
    { 
        word: 'MAGMA', 
        x: 3, 
        y: 3, 
        direction: 'across', 
        number: 1,
        clue: 'Batuan yang terbentuk dari magma yang mendingin',
        clueKey: 'tts_clue1'
    },
    { 
        word: 'FOSIL', 
        x: 5, 
        y: 1, 
        direction: 'down', 
        number: 2,
        clue: 'Sisa-sisa kehidupan purba yang terawetkan',
        clueKey: 'tts_clue2'
    },
    { 
        word: 'LEMPENG', 
        x: 4, 
        y: 5, 
        direction: 'down', 
        number: 3,
        clue: 'Lempeng ___ menggerakkan benua',
        clueKey: 'tts_clue3'
    },
    { 
        word: 'KUARSA', 
        x: 3, 
        y: 8, 
        direction: 'across', 
        number: 4,
        clue: 'Mineral paling umum di Bumi',
        clueKey: 'tts_clue4'
    }
];

// Select crossword data based on language
let crosswordData = [];
function getCrosswordData() {
    const currentLang = localStorage.getItem('language') || 'id';
    return currentLang === 'id' ? crosswordDataID : crosswordDataEN;
}
crosswordData = getCrosswordData();

let timerInterval;
let seconds = 0;
let hintsRemaining = GAME_CONFIG.INITIAL_HINTS;

// Helper function to get translated text
function getTrans(key) {
    const currentLang = localStorage.getItem('language') || 'id';
    if (window.translations && window.translations[currentLang] && window.translations[currentLang][key]) {
        return window.translations[currentLang][key];
    }
    return key; // Fallback to key if translation not found
}

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
    
    // Get current language and update crossword data
    const currentLang = localStorage.getItem('language') || 'id';
    crosswordData = getCrosswordData();
    
    const lettersText = currentLang === 'id' ? 'huruf' : 'letters';
    
    crosswordData.forEach(item => {
        const clueDiv = document.createElement('div');
        clueDiv.className = 'clue-item mb-3 p-3 rounded';
        
        // Get translated clue if available
        let clueText = item.clue;
        if (item.clueKey && typeof window.translations !== 'undefined' && window.translations[currentLang]) {
            clueText = window.translations[currentLang][item.clueKey] || item.clue;
        }
        
        clueDiv.innerHTML = `
            <span class="badge bg-warning text-dark fw-bold me-2">${item.number}</span>
            <span class="fs-6">${clueText} (${item.word.length} ${lettersText})</span>
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
            title: getTrans('tts_alert_no_hints'),
            text: getTrans('tts_alert_no_hints_text'),
            icon: 'warning',
            ...GAME_CONFIG.SWAL_THEME
        });
        return;
    }
    
    const emptyInputs = Array.from(document.querySelectorAll('#crossword input'))
        .filter(input => !input.value || input.value.toUpperCase() !== input.dataset.answer);
    
    if (emptyInputs.length === 0) {
        Swal.fire({
            title: getTrans('tts_alert_all_filled'),
            text: getTrans('tts_alert_all_filled_text'),
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
    const hintBtn = document.querySelector('.btn-hint');
    
    if (hintText) {
        const currentLang = localStorage.getItem('language') || 'id';
        const getText = currentLang === 'id' ? 'Dapatkan Petunjuk' : 'Get Hint';
        const remainText = currentLang === 'id' ? 'tersisa' : 'remaining';
        hintText.textContent = `${getText} (${hintsRemaining} ${remainText})`;
    }
    
    if (hintsRemaining === 0 && hintBtn) {
        hintBtn.disabled = true;
    }
    
    updateScore();
}

// Reveal All Answers
function revealAnswer() {
    Swal.fire({
        title: getTrans('tts_alert_reveal_title'),
        text: getTrans('tts_alert_reveal_text'),
        icon: 'question',
        showCancelButton: true,
        ...GAME_CONFIG.SWAL_THEME,
        confirmButtonColor: '#17a2b8',
        cancelButtonColor: '#6c757d',
        confirmButtonText: getTrans('tts_alert_yes'),
        cancelButtonText: getTrans('tts_alert_cancel')
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
        title: `🎉 ${getTrans('tts_alert_congrats')}`,
        html: `
            <p class="fs-5">${getTrans('tts_alert_completed')}</p>
            <p class="text-warning fs-4 fw-bold">⏱️ ${getTrans('tts_alert_time')} ${timeStr}</p>
            <p class="text-info">💡 ${getTrans('tts_alert_hints_used')}: ${GAME_CONFIG.INITIAL_HINTS - hintsRemaining}</p>
        `,
        icon: 'success',
        ...GAME_CONFIG.SWAL_THEME,
        confirmButtonText: getTrans('tts_alert_play_again')
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
    
    if (resultEl) resultEl.innerHTML = '';
    if (scoreEl) scoreEl.textContent = '0';
    
    updateHintButtonText();
    
    createCrossword();
}

// Initialize
function updateHintButtonText() {
    const hintBtn = document.getElementById('hintText');
    if (hintBtn) {
        const currentLang = localStorage.getItem('language') || 'id';
        const getText = currentLang === 'id' ? 'Dapatkan Petunjuk' : 'Get Hint';
        const remainText = currentLang === 'id' ? 'tersisa' : 'remaining';
        hintBtn.textContent = `${getText} (${hintsRemaining} ${remainText})`;
    }
}

// Listen for language change
document.addEventListener('DOMContentLoaded', function() {
    // Listen for custom languageChanged event on window
    window.addEventListener('languageChanged', function() {
        crosswordData = getCrosswordData(); // Update crossword data
        generateClues(); // Regenerate clues with new language
        updateHintButtonText(); // Update hint button text
        createCrossword(); // Recreate grid with new words
    });
    
    // Also listen for storage change (when language changes in another tab)
    window.addEventListener('storage', function(e) {
        if (e.key === 'language') {
            crosswordData = getCrosswordData();
            generateClues();
            updateHintButtonText();
            createCrossword();
        }
    });
});

try {
    generateClues();
    createCrossword();
    updateHintButtonText(); // Initialize hint button text
} catch (error) {
    console.error('Failed to initialize crossword game:', error);
    Swal.fire({
        title: getTrans('tts_alert_error'),
        text: getTrans('tts_alert_error_text'),
        icon: 'error',
        ...GAME_CONFIG.SWAL_THEME
    });
}
</script>
@endsection