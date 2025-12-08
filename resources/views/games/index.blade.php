{{-- resources/views/games/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Mini Games - Museum Geologi')

@section('content')
<section class="min-vh-100 d-flex align-items-center py-5">
    <div class="container">

        <!-- Judul -->
        <div class="text-center mb-5">
            <h1 class="display-2 fw-bold text-white mb-3" style="text-shadow: 0 10px 30px rgba(0,0,0,0.7); letter-spacing: 4px;">
                GEOLOGY MINI GAMES
            </h1>
            <p class="lead fs-2 text-warning" style="text-shadow: 0 4px 12px rgba(0,0,0,0.7);">
                Choose a fun & educational game!
            </p>
        </div>

        <div class="row g-5 justify-content-center">

            <!-- Game 1: Crossword -->
            <div class="col-lg-4 col-md-6">
                <div class="game-card-wrapper position-relative">
                    <div class="game-card h-100 bg-dark bg-opacity-92 rounded-4 overflow-hidden shadow-2xl border border-3 border-warning border-opacity-50"
                         style="backdrop-filter: blur(16px);">
                        
                        <!-- Gambar + Icon (Rasio tetap 4:3) -->
                        <div class="game-image-container position-relative">
                            <div class="game-bg bg-gradient-1"></div>
                            <div class="game-icon-overlay position-absolute top-50 start-50 translate-middle text-center w-100">
                                <i class="fas fa-th-large fa-8x text-warning game-icon"></i>
                            </div>
                        </div>

                        <div class="p-5 text-center text-white">
                            <h3 class="fw-bold fs-1 text-warning mb-3">Geology Crossword</h3>
                            <p class="fs-5 opacity-90 mb-4">Test your geology vocabulary knowledge!</p>
                            <a href="{{ route('games.tts') }}" class="btn btn-game-play btn-lg px-5 py-3 fw-bold">
                                Play Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Game 2: Quiz -->
            <div class="col-lg-4 col-md-6">
                <div class="game-card-wrapper position-relative">
                    <div class="game-card h-100 bg-dark bg-opacity-92 rounded-4 overflow-hidden shadow-2xl border border-3 border-warning border-opacity-50"
                         style="backdrop-filter: blur(16px);">
                        
                        <div class="game-image-container position-relative">
                            <div class="game-bg bg-gradient-2"></div>
                            <div class="game-icon-overlay position-absolute top-50 start-50 translate-middle text-center w-100">
                                <i class="fas fa-question-circle fa-8x text-warning game-icon"></i>
                            </div>
                        </div>

                        <div class="p-5 text-center text-white">
                            <h3 class="fw-bold fs-1 text-warning mb-3">Rock & Fossil Quiz</h3>
                            <p class="fs-5 opacity-90 mb-4">Guess the rocks and fossils from real photos!</p>
                            <a href="{{ route('games.quiz') }}" class="btn btn-game-play btn-lg px-5 py-3 fw-bold">
                                Play Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Game 3: Memory -->
            <div class="col-lg-4 col-md-6">
                <div class="game-card-wrapper position-relative">
                    <div class="game-card h-100 bg-dark bg-opacity-92 rounded-4 overflow-hidden shadow-2xl border border-3 border-warning border-opacity-50"
                         style="backdrop-filter: blur(16px);">
                        
                        <div class="game-image-container position-relative">
                            <div class="game-bg bg-gradient-3"></div>
                            <div class="game-icon-overlay position-absolute top-50 start-50 translate-middle text-center w-100">
                                <i class="fas fa-brain fa-8x text-warning game-icon"></i>
                            </div>
                        </div>

                        <div class="p-5 text-center text-white">
                            <h3 class="fw-bold fs-1 text-warning mb-3">Fossil Memory Match</h3>
                            <p class="fs-5 opacity-90 mb-4">Match pairs of ancient fossils!</p>
                            <a href="{{ route('games.memory') }}" class="btn btn-game-play btn-lg px-5 py-3 fw-bold">
                                Play Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Back to Home -->
        <div class="text-center mt-5">
            <a href="{{ url('/') }}" class="btn btn-warning btn-lg px-5 py-3 fw-bold text-dark shadow-lg">
                Back to Home
            </a>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
    /* Container gambar dengan rasio 4:3 */
    .game-image-container {
        width: 100%;
        padding-top: 75%; /* 4:3 aspect ratio */
        overflow: hidden;
    }
    
    /* Background gambar menggunakan div dengan background-image */
    .game-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        transition: all 0.6s ease;
    }
    
    /* Gradient backgrounds untuk setiap card */
    .bg-gradient-1 {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
    }
    
    .bg-gradient-2 {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 50%, #4facfe 100%);
    }
    
    .bg-gradient-3 {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 50%, #667eea 100%);
    }
    
    /* Overlay untuk icon agar selalu di tengah */
    .game-icon-overlay {
        z-index: 2;
    }
    
    .game-icon {
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        filter: drop-shadow(0 10px 25px rgba(0,0,0,0.8));
    }
    
    /* Hover Effect */
    .game-card {
        transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .game-card:hover {
        transform: translateY(-30px) scale(1.06);
        box-shadow: 0 60px 120px rgba(255,212,0,0.45) !important;
    }
    
    .game-card:hover .game-bg {
        transform: scale(1.15);
        filter: brightness(0.7);
    }
    
    .game-card:hover .game-icon {
        transform: scale(1.3) rotate(5deg);
        filter: drop-shadow(0 0 50px #FFD400);
    }

    /* Tombol Play Now */
    .btn-game-play {
        background: linear-gradient(135deg, #FFD400 0%, #FFC107 100%);
        color: #000 !important;
        border: 3px solid #FFD400 !important;
        font-weight: 800;
        letter-spacing: 1.5px;
        box-shadow: 0 12px 35px rgba(255,212,0,0.5);
        transition: all 0.4s ease;
    }
    
    .btn-game-play:hover {
        background: #000 !important;
        color: #FFD400 !important;
        border-color: #FFD400 !important;
        transform: translateY(-6px) scale(1.1);
        box-shadow: 0 25px 60px rgba(255,212,0,0.7) !important;
    }

    /* Responsif */
    @media (max-width: 768px) {
        .display-2 { 
            font-size: 2.8rem !important; 
        }
        .game-icon { 
            font-size: 6rem !important; 
        }
        .game-card:hover { 
            transform: translateY(-15px) scale(1.03); 
        }
    }
    
    /* Shadow untuk card */
    .shadow-2xl {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }
</style>
@endsection