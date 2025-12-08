{{-- resources/views/games/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Mini Games - Museum Geologi')

@section('content')
<section class="min-vh-100 d-flex align-items-center py-5">
    <div class="container">

        <!-- Judul -->
        <div class="text-center mb-5">
            <h1 class="display-2 fw-bold mb-3 games-title games-title-gradient">
                GEOLOGY MINI GAMES
            </h1>
            <p class="lead fs-2 text-black games-subtitle">
                Choose a fun & educational game!
            </p>
        </div>

        @php
        $games = [
            [
                'title' => 'Geology Crossword',
                'description' => 'Test your geology vocabulary knowledge!',
                'icon' => 'fa-th-large',
                'gradient' => 'bg-gradient-1',
                'route' => 'games.tts',
                'category' => 'Puzzle'
            ],
            [
                'title' => 'Rock & Fossil Quiz',
                'description' => 'Guess the rocks and fossils from real photos!',
                'icon' => 'fa-question-circle',
                'gradient' => 'bg-gradient-2',
                'route' => 'games.quiz',
                'category' => 'Quiz'
            ],
            [
                'title' => 'Fossil Memory Match',
                'description' => 'Match pairs of ancient fossils!',
                'icon' => 'fa-brain',
                'gradient' => 'bg-gradient-3',
                'route' => 'games.memory',
                'category' => 'Memory'
            ]
        ];
        @endphp

        <div class="row g-5 justify-content-center">
            @foreach($games as $index => $game)
            <!-- Game {{ $index + 1 }}: {{ $game['title'] }} -->
            <div class="col-lg-4 col-md-6">
                <article class="game-card-wrapper position-relative" 
                         role="article" 
                         aria-label="{{ $game['title'] }} game card">
                    <div class="game-card h-100 bg-dark bg-opacity-92 rounded-4 overflow-hidden shadow-2xl border-3 border-warning border-opacity-50">
                        
                        <!-- Game Icon (Aspect Ratio 4:3) -->
                        <div class="game-image-container position-relative">
                            <div class="game-bg {{ $game['gradient'] }}" 
                                 role="img" 
                                 aria-label="{{ $game['category'] }} game background"></div>
                            <div class="game-icon-overlay position-absolute top-50 start-50 translate-middle text-center w-100">
                                <i class="fas {{ $game['icon'] }} fa-8x text-warning game-icon" 
                                   aria-hidden="true"></i>
                            </div>
                        </div>

                        <div class="p-5 text-center text-white">
                            <h3 class="fw-bold fs-1 text-warning mb-3">{{ $game['title'] }}</h3>
                            <p class="fs-5 opacity-90 mb-4">{{ $game['description'] }}</p>
                            <a href="{{ route($game['route']) }}" 
                               class="btn btn-game-play btn-lg px-5 py-3 fw-bold"
                               aria-label="Play {{ $game['title'] }} game">
                                <i class="fas fa-play me-2" aria-hidden="true"></i>Play Now
                            </a>
                        </div>
                    </div>
                </article>
            </div>
            @endforeach
        </div>

        <!-- Back to Home -->
        <div class="text-center mt-5">
            <a href="{{ url('/') }}" 
               class="btn btn-back-home btn-lg px-5 py-3 fw-bold shadow-lg"
               aria-label="Go back to homepage">
                <i class="fas fa-arrow-left me-2" aria-hidden="true"></i>Back to Home
            </a>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
    /* ========================================
       CSS Variables & Theme Colors
       ======================================== */
    :root {
        --games-yellow: #FFD400;
        --games-dark: #1a1a1a;
        --games-shadow: rgba(0, 0, 0, 0.7);
    }

    /* ========================================
       Page Title & Subtitle
       ======================================== */
    .games-title {
        text-shadow: 0 10px 30px var(--games-shadow);
        letter-spacing: 4px;
    }

    .games-title-gradient {
        color: var(--mg-black);
        -webkit-text-stroke: 3px var(--mg-yellow);
        text-stroke: 3px var(--mg-yellow);
        paint-order: stroke fill;
    }

    .games-subtitle {
        text-shadow: 0 4px 12px var(--games-shadow);
    }

    /* ========================================
       Game Card Structure
       ======================================== */
    .game-card {
        backdrop-filter: blur(16px);
        transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

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
    
    /* ========================================
       Gradient Backgrounds
       ======================================== */
    /* Purple to Pink gradient (Crossword) */
    .bg-gradient-1 {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
    }
    
    /* Pink to Blue gradient (Quiz) */
    .bg-gradient-2 {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 50%, #4facfe 100%);
    }
    
    /* Green to Cyan gradient (Memory) */
    .bg-gradient-3 {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 50%, #667eea 100%);
    }
    
    /* ========================================
       Game Icon Styling
       ======================================== */
    /* Overlay ensures icon stays centered */
    .game-icon-overlay {
        z-index: 2;
    }
    
    .game-icon {
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        filter: drop-shadow(0 10px 25px rgba(0,0,0,0.8));
    }
    
    /* ========================================
       Hover Effects
       ======================================== */
    
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
        filter: drop-shadow(0 0 50px var(--games-yellow));
    }

    /* ========================================
       Button Styles
       ======================================== */
    /* Play Now button */
    .btn-game-play {
        background: linear-gradient(135deg, var(--games-yellow) 0%, #FFC107 100%);
        color: #000 !important;
        border: 3px solid var(--games-yellow) !important;
        font-weight: 800;
        letter-spacing: 1.5px;
        box-shadow: 0 12px 35px rgba(255,212,0,0.5);
        transition: all 0.4s ease;
    }
    
    .btn-game-play:hover {
        background: #000 !important;
        color: var(--games-yellow) !important;
        border-color: var(--games-yellow) !important;
        transform: translateY(-6px) scale(1.1);
        box-shadow: 0 25px 60px rgba(255,212,0,0.7) !important;
    }

    /* Back to Home button */
    .btn-back-home {
        background: linear-gradient(135deg, var(--games-yellow) 0%, #FFC107 100%);
        color: #000 !important;
        border: 3px solid var(--games-yellow) !important;
        font-weight: 800;
        letter-spacing: 1.5px;
        box-shadow: 0 12px 35px rgba(255,212,0,0.5);
        transition: all 0.4s ease;
    }
    
    .btn-back-home:hover {
        background: #000 !important;
        color: var(--games-yellow) !important;
        border-color: var(--games-yellow) !important;
        transform: translateY(-6px) scale(1.05);
        box-shadow: 0 25px 60px rgba(255,212,0,0.7) !important;
    }

    /* ========================================
       Responsive Design
       ======================================== */
    @media (max-width: 768px) {
        .games-title { 
            font-size: 2.8rem !important; 
        }
        .game-icon { 
            font-size: 6rem !important; 
        }
        .game-card:hover { 
            transform: translateY(-15px) scale(1.03); 
        }
        .btn-game-play,
        .btn-back-home {
            font-size: 1rem;
            padding: 0.75rem 2rem !important;
        }
    }
    
    /* ========================================
       Utility Classes
       ======================================== */
    /* Enhanced shadow for cards */
    .shadow-2xl {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }

    /* ========================================
       Accessibility - Focus States
       ======================================== */
    .btn-game-play:focus,
    .btn-back-home:focus {
        outline: 3px solid var(--games-yellow);
        outline-offset: 3px;
    }

    .game-card:focus-within {
        outline: 3px solid var(--games-yellow);
        outline-offset: 5px;
    }
</style>
@endsection