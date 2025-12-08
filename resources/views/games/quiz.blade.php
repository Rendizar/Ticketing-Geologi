@extends('layouts.app')

@section('title', 'Rock & Fossil Quiz')

@section('content')
<section class="min-vh-100 d-flex align-items-center py-5">
    <div class="container py-4">

        <!-- Judul Utama -->
        <div class="text-center mb-5">
            <h1 class="display-2 fw-bold mb-3" 
                style="color: #FFC107; text-shadow: 0 10px 30px rgba(0,0,0,0.8); letter-spacing: 4px;">
                🪨 Rock & Fossil Quiz
            </h1>
            <p class="fs-3 opacity-95" 
               style="color: #FFC107; text-shadow: 0 4px 12px rgba(0,0,0,0.7);">
                Test your knowledge about rocks and fossils!
            </p>
            
            <!-- Score & Progress -->
            <div class="d-flex justify-content-center gap-4 mt-4">
                <div class="badge bg-dark border border-warning fs-5 px-4 py-2">
                    <i class="fas fa-star text-warning me-2"></i>
                    Score: <span id="score" class="text-warning fw-bold">0</span>/<span id="total" class="text-warning">10</span>
                </div>
                <div class="badge bg-dark border border-info fs-5 px-4 py-2">
                    <i class="fas fa-question-circle text-info me-2"></i>
                    Question: <span id="currentQ" class="text-info fw-bold">1</span>/<span id="totalQ" class="text-info">10</span>
                </div>
            </div>
        </div>

        <!-- Card Game Utama -->
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                <div class="card bg-dark bg-opacity-94 border-0 shadow-2xl rounded-4 overflow-hidden"
                     style="border: 5px solid #FFD400; backdrop-filter: blur(18px);">
                    <div class="card-body p-4 p-xl-5">

                        <div id="quiz">
                            <!-- Question -->
                            <div class="bg-black bg-opacity-50 p-4 rounded-3 border border-warning border-3 mb-4">
                                <h2 class="text-center mb-0 fs-3 fs-md-2 fw-bold" id="question" style="color: #FFC107;"></h2>
                            </div>

                            <!-- Options -->
                            <div class="row g-3 justify-content-center mb-4" id="options"></div>

                            <!-- Feedback -->
                            <div id="feedback" class="text-center mb-4 fs-5"></div>

                            <!-- Next Button -->
                            <div class="text-center">
                                <button onclick="nextQuestion()" 
                                        class="btn btn-warning btn-lg px-5 py-3 fw-bold shadow-lg hover-lift" 
                                        id="nextBtn" 
                                        style="display:none; border-radius:50px;">
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
               class="btn btn-warning btn-lg px-5 py-3 fw-bold text-dark shadow-lg hover-lift">
                <i class="fas fa-arrow-left me-2"></i>Back to Mini Games
            </a>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
    /* Hover Lift Effect */
    .hover-lift {
        transition: all 0.4s ease;
    }
    .hover-lift:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 50px rgba(255,212,0,0.5) !important;
    }

    /* Shadow 2XL */
    .shadow-2xl {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
    }

    /* Option Button Styles */
    .option-btn {
        background: rgba(255,255,255,0.08);
        border: 3px solid #FFD400 !important;
        color: #FFC107;
        padding: 1.5rem;
        border-radius: 15px;
        font-size: 1.1rem;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
        text-align: center;
    }

    .option-btn:hover:not(:disabled) {
        background: rgba(255,212,0,0.2);
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(255,212,0,0.3);
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
        .display-2 { font-size: 2.5rem; }
        .fs-3 { font-size: 1.2rem !important; }
        .option-btn { font-size: 1rem; padding: 1.2rem; }
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Quiz Data - 10 Questions
const questions = [
    { q: "What type of rock is formed from cooled lava or magma?", options: ["Sedimentary", "Igneous", "Metamorphic"], a: 1 },
    { q: "Which mineral is the hardest natural substance (hardness 10 on Mohs scale)?", options: ["Quartz", "Diamond", "Talc"], a: 1 },
    { q: "A trilobite is a famous example of a...", options: ["Dinosaur", "Fossil", "Volcano"], a: 1 },
    { q: "Which rock type is formed by heat and pressure?", options: ["Metamorphic", "Sedimentary", "Igneous"], a: 0 },
    { q: "Limestone is classified as which type of rock?", options: ["Igneous", "Sedimentary", "Metamorphic"], a: 1 },
    { q: "What is the study of fossils called?", options: ["Geology", "Paleontology", "Archaeology"], a: 1 },
    { q: "Which rock is formed from layers of sediment?", options: ["Granite", "Marble", "Sandstone"], a: 2 },
    { q: "Obsidian is an example of which rock type?", options: ["Igneous", "Sedimentary", "Metamorphic"], a: 0 },
    { q: "Which era is known as the 'Age of Dinosaurs'?", options: ["Paleozoic", "Mesozoic", "Cenozoic"], a: 1 },
    { q: "What mineral is commonly found in granite?", options: ["Quartz", "Calcite", "Gypsum"], a: 0 }
];

let score = 0;
let currentQuestion = 0;
let answered = false;

// Initialize Quiz
function initQuiz() {
    score = 0;
    currentQuestion = 0;
    answered = false;
    document.getElementById('score').textContent = score;
    document.getElementById('total').textContent = questions.length;
    document.getElementById('totalQ').textContent = questions.length;
    showQuestion();
}

// Show Current Question
function showQuestion() {
    answered = false;
    const q = questions[currentQuestion];
    document.getElementById('question').textContent = q.q;
    document.getElementById('currentQ').textContent = currentQuestion + 1;
    document.getElementById('nextBtn').style.display = 'none';
    document.getElementById('feedback').innerHTML = '';
    
    const opts = document.getElementById('options');
    opts.innerHTML = '';
    
    q.options.forEach((opt, i) => {
        const col = document.createElement('div');
        col.className = 'col-12 col-md-6';
        
        const btn = document.createElement('button');
        btn.className = 'option-btn w-100';
        btn.textContent = opt;
        btn.onclick = () => checkAnswer(i, btn);
        
        col.appendChild(btn);
        opts.appendChild(col);
    });
}

// Check Answer
function checkAnswer(selected, btn) {
    if (answered) return;
    answered = true;
    
    const correct = questions[currentQuestion].a;
    const feedback = document.getElementById('feedback');
    
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
        confetti({
            particleCount: 100,
            spread: 70,
            origin: { y: 0.6 },
            colors: ['#FFD400', '#FFC107', '#FFB300']
        });
    } else {
        btn.classList.add('wrong');
        
        // Show correct answer
        const allBtns = document.querySelectorAll('.option-btn');
        allBtns[correct].classList.add('correct');
        
        feedback.innerHTML = '<p class="text-danger fw-bold mb-0"><i class="fas fa-times-circle me-2"></i>Wrong! The correct answer is highlighted in green.</p>';
    }
    
    document.getElementById('nextBtn').style.display = 'inline-block';
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
    
    if (percentage >= 80) {
        icon = 'success';
        title = '🏆 Outstanding!';
        message = 'You have excellent knowledge of rocks and fossils!';
    } else if (percentage >= 60) {
        icon = 'info';
        title = '👍 Good Job!';
        message = 'You have a solid understanding of geology!';
    } else if (percentage >= 40) {
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
        background: '#1a1a1a',
        color: '#fff',
        confirmButtonText: '<i class="fas fa-redo me-2"></i>Play Again',
        confirmButtonColor: '#FFD400',
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
initQuiz();
</script>
@endsection