{{-- resources/views/games/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Mini Games - Museum Geologi')

@section('content')
<section class="min-vh-100 d-flex align-items-center py-5">
    <div class="container">

        <!-- Judul -->
        <div class="text-center mb-5">
            <h1 class="display-2 fw-bold mb-4 games-title" style="font-family: 'Merriweather', serif !important; color: #1F2933;">
                GEOLOGY MINI GAMES
            </h1>
            <p class="lead fs-4 games-subtitle" style="color: #6c6c6c; font-weight: 500;">
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

        <div class="row g-4 justify-content-center">
            @foreach($games as $index => $game)
            <!-- Game {{ $index + 1 }}: {{ $game['title'] }} -->
            <div class="col-lg-4 col-md-6">
                <article class="game-card-wrapper position-relative" 
                         role="article" 
                         aria-label="{{ $game['title'] }} game card">
                    <div class="game-card h-100 bg-white rounded-4 overflow-hidden shadow-lg border-0">
                        
                        <!-- Game Icon (Aspect Ratio 4:3) -->
                        <div class="game-image-container position-relative">
                            <div class="game-bg {{ $game['gradient'] }}" 
                                 role="img" 
                                 aria-label="{{ $game['category'] }} game background"></div>
                            <div class="game-icon-overlay position-absolute top-50 start-50 translate-middle text-center w-100">
                                <i class="fas {{ $game['icon'] }} fa-7x game-icon" 
                                   style="color: #FACC15;"
                                   aria-hidden="true"></i>
                            </div>
                        </div>

                        <div class="p-4 text-center">
                            <h3 class="fw-bold fs-4 mb-3" style="color: #1F2933;">{{ $game['title'] }}</h3>
                            <p class="fs-6 mb-4" style="color: #6c6c6c;">{{ $game['description'] }}</p>
                            <a href="{{ route($game['route']) }}" 
                               class="btn btn-game-play px-4 py-2 fw-bold"
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
               class="btn btn-back-home px-4 py-2 fw-bold"
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
        --games-yellow: #FACC15;
        --games-dark: #1F2933;
        --games-muted: #6c6c6c;
        --games-shadow: rgba(0, 0, 0, 0.1);
    }

    /* ========================================
       Page Title & Subtitle
       ======================================== */
    .games-title {
        letter-spacing: 2px;
        text-shadow: none;
    }

    .games-subtitle {
        text-shadow: none;
        font-weight: 500;
    }

    /* ========================================
       Game Card Structure
       ======================================== */
    .game-card {
        transition: all 0.4s ease;
        background: #ffffff;
        border-radius: 1.5rem;
    }

    .game-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important;
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
        transition: all 0.4s ease;
    }
    
    /* ========================================
       Gradient Backgrounds - Tetap Dipertahankan
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
        transition: all 0.4s ease;
        filter: drop-shadow(0 8px 20px rgba(0,0,0,0.3));
    }
    
    /* ========================================
       Hover Effects
       ======================================== */
    .game-card:hover .game-bg {
        transform: scale(1.08);
    }
    
    .game-card:hover .game-icon {
        transform: scale(1.15);
        filter: drop-shadow(0 10px 25px rgba(0,0,0,0.4));
    }

    /* ========================================
       Button Styles - Selaras dengan Home
       ======================================== */
    /* Play Now button */
    .btn-game-play {
        background: var(--games-yellow) !important;
        color: #000 !important;
        border: 2px solid var(--games-yellow) !important;
        font-weight: 700;
        letter-spacing: 0.5px;
        border-radius: 25px;
        transition: all 0.3s ease;
        font-size: 1rem;
    }
    
    .btn-game-play:hover {
        background: transparent !important;
        color: var(--games-yellow) !important;
        border-color: var(--games-yellow) !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(250, 204, 21, 0.3);
    }

    /* Back to Home button */
    .btn-back-home {
        background: var(--games-yellow) !important;
        color: #000 !important;
        border: 2px solid var(--games-yellow) !important;
        font-weight: 700;
        letter-spacing: 0.5px;
        border-radius: 25px;
        transition: all 0.3s ease;
        font-size: 1rem;
    }
    
    .btn-back-home:hover {
        background: transparent !important;
        color: var(--games-yellow) !important;
        border-color: var(--games-yellow) !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(250, 204, 21, 0.3);
    }

    /* ========================================
       Responsive Design
       ======================================== */
    @media (max-width: 768px) {
        .games-title { 
            font-size: 2.5rem !important; 
            letter-spacing: 1px;
        }
        .games-subtitle {
            font-size: 1.2rem !important;
        }
        .game-icon { 
            font-size: 5rem !important; 
        }
        .game-card:hover { 
            transform: translateY(-5px); 
        }
        .btn-game-play,
        .btn-back-home {
            font-size: 0.95rem;
            padding: 0.6rem 1.5rem !important;
        }
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