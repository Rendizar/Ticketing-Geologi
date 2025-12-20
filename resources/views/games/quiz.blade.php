@extends('layouts.app')

@section('title', 'Rock & Fossil Quiz')

@section('content')
<section class="min-vh-100 d-flex align-items-center py-5">
    <div class="container py-4">

        <!-- Judul Utama -->
        <div class="text-center mb-5">
            <h1 class="display-2 fw-bold mb-4 quiz-title" style="font-family: 'Merriweather', serif !important; color: #1F2933;">
                Rock & Fossil Quiz
            </h1>
            <p class="fs-4 quiz-subtitle" style="color: #6c6c6c; font-weight: 500;">
                Test your knowledge about rocks and fossils!
            </p>
            
            <!-- Score & Progress -->
            <div class="d-flex flex-wrap justify-content-center gap-3 mt-4 px-3">
                <div class="badge bg-white border-2 fs-6 px-4 py-2 shadow-sm" style="border-color: #FACC15 !important;" role="status" aria-live="polite">
                    <i class="fas fa-star me-2" style="color: #FACC15;"></i>
                    <span style="color: #1F2933; font-weight: 600;">Score:</span> <span id="score" class="fw-bold" style="color: #FACC15;" aria-label="Current score">0</span> <span style="color: #1F2933; font-weight: 600;">/</span> <span id="total" style="color: #FACC15;">10</span>
                </div>
                <div class="badge bg-white border-2 fs-6 px-4 py-2 shadow-sm" style="border-color: #FACC15 !important;" role="status" aria-live="polite">
                    <i class="fas fa-question-circle me-2" style="color: #FACC15;"></i>
                    <span style="color: #1F2933; font-weight: 600;">Question:</span> <span id="currentQ" class="fw-bold" style="color: #FACC15;" aria-label="Current question number">1</span> <span style="color: #1F2933; font-weight: 600;">/</span> <span id="totalQ" style="color: #FACC15;">10</span>
                </div>
            </div>
        </div>

        <!-- Card Game Utama -->
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                <div class="card bg-white border-0 shadow-lg rounded-4 overflow-hidden quiz-card">
                    <div class="card-body p-4 p-xl-5">

                        <div id="quiz">
                            <!-- Question -->
                            <div class="p-4 rounded-3 border-2 mb-4 quiz-question-box" style="border-color: #FACC15 !important; background-color: #fffbeb;">
                                <h2 class="text-center mb-0 fs-3 fs-md-2 fw-bold quiz-question" id="question" role="heading" aria-level="2" style="color: #1F2933;"></h2>
                            </div>

                            <!-- Options -->
                            <div class="row g-3 justify-content-center mb-4" id="options" role="group" aria-label="Answer options"></div>

                            <!-- Feedback -->
                            <div id="feedback" class="text-center mb-4 fs-5" role="status" aria-live="assertive"></div>

                            <!-- Next Button -->
                            <div class="text-center">
                                <button onclick="nextQuestion()" 
                                        class="btn btn-next-question px-4 py-2 fw-bold" 
                                        id="nextBtn" 
                                        style="display:none;"
                                        aria-label="Go to next question">
                                    <i class="fas fa-arrow-right me-2"></i>Next Question
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Kembali -->
        <div class="text-center mt-5">
            <a href="{{ route('games.index') }}" 
               class="btn btn-back-home px-4 py-2 fw-bold">
                <i class="fas fa-arrow-left me-2"></i>Back to Mini Games
            </a>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
    /* Theme Variables */
    :root {
        --quiz-yellow: #FACC15;
        --quiz-dark: #1F2933;
        --quiz-muted: #6c6c6c;
        --quiz-light: #fffbeb;
    }

    /* Title Styles */
    .quiz-title {
        letter-spacing: 2px;
        text-shadow: none;
    }

    .quiz-subtitle {
        text-shadow: none;
    }

    /* Quiz Card */
    .quiz-card {
        transition: all 0.3s ease;
    }

    /* Question Box */
    .quiz-question-box {
        background: var(--quiz-light);
    }

    /* Question Text */
    .quiz-question {
        color: var(--quiz-dark);
        font-weight: 700;
    }

    /* Button Styles - Selaras dengan Home */
    .btn-next-question,
    .btn-back-home {
        background: var(--quiz-yellow) !important;
        color: #000 !important;
        border: 2px solid var(--quiz-yellow) !important;
        font-weight: 700;
        letter-spacing: 0.5px;
        border-radius: 25px;
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .btn-next-question:hover,
    .btn-back-home:hover {
        background: transparent !important;
        color: var(--quiz-yellow) !important;
        border-color: var(--quiz-yellow) !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(250, 204, 21, 0.3);
    }

    /* Option Button Styles */
    .option-btn {
        background: #ffffff;
        border: 2px solid var(--quiz-yellow) !important;
        color: var(--quiz-dark);
        padding: 1.5rem;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .option-btn:hover:not(:disabled) {
        background: var(--quiz-yellow);
        color: #000;
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(250, 204, 21, 0.3);
    }

    .option-btn:disabled {
        cursor: not-allowed;
        opacity: 0.9;
    }

    .option-btn.correct {
        background: #28a745 !important;
        border-color: #28a745 !important;
        color: white;
        animation: correctPulse 0.6s ease;
    }

    .option-btn.wrong {
        background: #dc3545 !important;
        border-color: #dc3545 !important;
        color: white;
        animation: shake 0.5s ease;
    }

    @keyframes correctPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-10px); }
        50% { transform: translateX(10px); }
        75% { transform: translateX(-5px); }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .quiz-title { 
            font-size: 2rem !important;
            letter-spacing: 1px;
        }
        .quiz-subtitle { 
            font-size: 1.1rem !important;
        }
        .option-btn { 
            font-size: 1rem; 
            padding: 1.2rem; 
        }
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Game Configuration
const QUIZ_CONFIG = {
    CONFETTI_COLORS: ['#FACC15', '#FFC107', '#FFB300'],
    SWAL_THEME: {
        background: '#ffffff',
        color: '#1F2933',
        confirmButtonColor: '#FACC15'
    },
    SCORE_THRESHOLDS: {
        EXCELLENT: 80,
        GOOD: 60,
        FAIR: 40
    }
};

// Quiz Data - 10 Questions
const questions = [
    { 
        q: "What type of rock is formed from cooled lava or magma?", 
        options: ["Sedimentary", "Igneous", "Metamorphic"], 
        a: 1,
        category: "Rock Types"
    },
    { 
        q: "Which mineral is the hardest natural substance (hardness 10 on Mohs scale)?", 
        options: ["Quartz", "Diamond", "Talc"], 
        a: 1,
        category: "Minerals"
    },
    { 
        q: "A trilobite is a famous example of a...", 
        options: ["Dinosaur", "Fossil", "Volcano"], 
        a: 1,
        category: "Fossils"
    },
    { 
        q: "Which rock type is formed by heat and pressure?", 
        options: ["Metamorphic", "Sedimentary", "Igneous"], 
        a: 0,
        category: "Rock Types"
    },
    { 
        q: "Limestone is classified as which type of rock?", 
        options: ["Igneous", "Sedimentary", "Metamorphic"], 
        a: 1,
        category: "Rock Types"
    },
    { 
        q: "What is the study of fossils called?", 
        options: ["Geology", "Paleontology", "Archaeology"], 
        a: 1,
        category: "Science"
    },
    { 
        q: "Which rock is formed from layers of sediment?", 
        options: ["Granite", "Marble", "Sandstone"], 
        a: 2,
        category: "Rock Types"
    },
    { 
        q: "Obsidian is an example of which rock type?", 
        options: ["Igneous", "Sedimentary", "Metamorphic"], 
        a: 0,
        category: "Rock Types"
    },
    { 
        q: "Which era is known as the 'Age of Dinosaurs'?", 
        options: ["Paleozoic", "Mesozoic", "Cenozoic"], 
        a: 1,
        category: "Geology History"
    },
    { 
        q: "What mineral is commonly found in granite?", 
        options: ["Quartz", "Calcite", "Gypsum"], 
        a: 0,
        category: "Minerals"
    }
];

let score = 0;
let currentQuestion = 0;
let answered = false;

// Initialize Quiz
function initQuiz() {
    try {
        score = 0;
        currentQuestion = 0;
        answered = false;
        
        const scoreEl = document.getElementById('score');
        const totalEl = document.getElementById('total');
        const totalQEl = document.getElementById('totalQ');
        
        if (!scoreEl || !totalEl || !totalQEl) {
            throw new Error('Required elements not found');
        }
        
        scoreEl.textContent = score;
        totalEl.textContent = questions.length;
        totalQEl.textContent = questions.length;
        
        showQuestion();
    } catch (error) {
        console.error('Failed to initialize quiz:', error);
        alert('Failed to load quiz. Please refresh the page.');
    }
}

// Show Current Question
function showQuestion() {
    try {
        answered = false;
        const q = questions[currentQuestion];
        
        const questionEl = document.getElementById('question');
        const currentQEl = document.getElementById('currentQ');
        const nextBtn = document.getElementById('nextBtn');
        const feedback = document.getElementById('feedback');
        const opts = document.getElementById('options');
        
        if (!questionEl || !currentQEl || !nextBtn || !feedback || !opts) {
            throw new Error('Required elements not found');
        }
        
        questionEl.textContent = q.q;
        currentQEl.textContent = currentQuestion + 1;
        nextBtn.style.display = 'none';
        feedback.innerHTML = '';
        opts.innerHTML = '';
        
        q.options.forEach((opt, i) => {
            const col = document.createElement('div');
            col.className = 'col-12 col-md-6';
            
            const btn = document.createElement('button');
            btn.className = 'option-btn w-100';
            btn.textContent = opt;
            btn.setAttribute('aria-label', `Option ${i + 1}: ${opt}`);
            btn.onclick = () => checkAnswer(i, btn);
            
            col.appendChild(btn);
            opts.appendChild(col);
        });
    } catch (error) {
        console.error('Failed to show question:', error);
        alert('Failed to load question. Please refresh the page.');
    }
}

// Check Answer
function checkAnswer(selected, btn) {
    if (answered) return;
    answered = true;
    
    try {
        const correct = questions[currentQuestion].a;
        const feedback = document.getElementById('feedback');
        const scoreEl = document.getElementById('score');
        const nextBtn = document.getElementById('nextBtn');
        
        if (!feedback || !scoreEl || !nextBtn) {
            throw new Error('Required elements not found');
        }
        
        // Disable all buttons
        document.querySelectorAll('.option-btn').forEach(b => {
            b.disabled = true;
        });
    
    if (selected === correct) {
        score++;
        document.getElementById('score').textContent = score;
        btn.classList.add('correct');
        
        feedback.innerHTML = '<p class="text-success fw-bold mb-0"><i class="fas fa-check-circle me-2"></i>Correct! Great job!</p>';
        
        // Confetti effect
        if (typeof confetti === 'function') {
            confetti({
                particleCount: 100,
                spread: 70,
                origin: { y: 0.6 },
                colors: QUIZ_CONFIG.CONFETTI_COLORS
            });
        }
    } else {
        btn.classList.add('wrong');
        
        // Show correct answer
        const allBtns = document.querySelectorAll('.option-btn');
        allBtns[correct].classList.add('correct');
        
        feedback.innerHTML = '<p class="text-danger fw-bold mb-0"><i class="fas fa-times-circle me-2"></i>Wrong! The correct answer is highlighted in green.</p>';
    }
    
    nextBtn.style.display = 'inline-block';
    } catch (error) {
        console.error('Error checking answer:', error);
        answered = false;
    }
}

// Next Question
function nextQuestion() {
    currentQuestion++;
    
    if (currentQuestion >= questions.length) {
        showResults();
        return;
    }
    
    showQuestion();
}

// Show Final Results
function showResults() {
    const percentage = (score / questions.length * 100).toFixed(0);
    let icon = 'success';
    let title = 'Excellent!';
    let message = '';
    
    if (percentage >= QUIZ_CONFIG.SCORE_THRESHOLDS.EXCELLENT) {
        icon = 'success';
        title = '🏆 Outstanding!';
        message = 'You have excellent knowledge of rocks and fossils!';
    } else if (percentage >= QUIZ_CONFIG.SCORE_THRESHOLDS.GOOD) {
        icon = 'info';
        title = '👍 Good Job!';
        message = 'You have a solid understanding of geology!';
    } else if (percentage >= QUIZ_CONFIG.SCORE_THRESHOLDS.FAIR) {
        icon = 'warning';
        title = '📚 Not Bad!';
        message = 'Keep learning about rocks and fossils!';
    } else {
        icon = 'error';
        title = '💪 Keep Trying!';
        message = 'Review the material and try again!';
    }
    
    Swal.fire({
        title: title,
        html: `
            <div class="text-center">
                <h3 class="mb-3">${message}</h3>
                <h2 class="display-4 fw-bold" style="color: #FFC107;">${score}/${questions.length}</h2>
                <p class="fs-4">${percentage}% Correct</p>
            </div>
        `,
        icon: icon,
        ...QUIZ_CONFIG.SWAL_THEME,
        confirmButtonText: '<i class="fas fa-redo me-2"></i>Play Again',
        showCancelButton: true,
        cancelButtonText: '<i class="fas fa-arrow-left me-2"></i>Back to Games',
        cancelButtonColor: '#6c757d'
    }).then((result) => {
        if (result.isConfirmed) {
            initQuiz();
        } else {
            window.location.href = "{{ route('games.index') }}";
        }
    });
}

// Initialize quiz on page load
try {
    if (questions.length === 0) {
        throw new Error('No questions available');
    }
    initQuiz();
} catch (error) {
    console.error('Failed to start quiz:', error);
    Swal.fire({
        title: 'Error!',
        text: 'Failed to load the quiz. Please refresh the page.',
        icon: 'error',
        ...QUIZ_CONFIG.SWAL_THEME
    });
}
</script>
@endsection