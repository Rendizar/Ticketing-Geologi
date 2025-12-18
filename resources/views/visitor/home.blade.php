@extends('layouts.app')

@section('title', 'Museum Geologi - Virtual Tour')

@section('content')
<div class="container-fluid px-0">
    <div class="row">
        <div class="col-lg-12 py-0">

        <!-- HERO SECTION -->
        <section id="hero" class="hero-section min-vh-100 d-flex align-items-center justify-content-center text-center position-relative overflow-hidden">
            <div class="hero-overlay"></div>
            <div class="container position-relative z-3">
                <div class="hero-content">
                    <h1 class="display-1 fw-bold mb-3 animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
                        GESIT
                    </h1>
                    <h2 class="text-subtitle mb-4 animate__animated animate__fadeInUp" style="animation-delay: 0.4s;" data-lang-key="hero_subtitle">
                        Geology Visit
                    </h2>
                    <p class="lead fs-4 mb-5 mx-auto animate__animated animate__fadeInUp" style="max-width: 800px; animation-delay: 0.6s;" data-lang-key="hero_description">
                        Explore the Geology Museum of Bandung with ease.<br>
                        Book tickets, attend events, and enjoy the ultimate virtual tour experience.
                    </p>
                    <a href="#banner" class="btn btn-lg btn-service-yellow fw-bold px-5 py-3 animate__animated animate__fadeInUp" style="animation-delay: 0.8s;" data-lang-key="hero_button">
                        Get Started
                    </a>
                </div>
            </div>
            <a href="#banner" class="section-arrow">
                <i class="fas fa-chevron-down"></i>
            </a>
        </section>

        <!-- BANNER SECTION -->
        <section id="banner" class="min-vh-100 d-flex align-items-center position-relative overflow-hidden">
            <div class="container-fluid px-0 w-100">
                <div id="bannerCarousel" class="carousel slide h-100" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="0" class="active"></button>
                        <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="1"></button>
                        <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="2"></button>
                    </div>
                    <div class="carousel-inner h-100">
                        <div class="carousel-item active">
                            <img src="{{ asset('images/banner1.png') }}" class="d-block w-100 h-100 banner-img" alt="Banner 1" style="object-fit: cover;">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('images/banner2.png') }}" class="d-block w-100 h-100 banner-img" alt="Banner 2" style="object-fit: cover;">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('images/banner1.png') }}" class="d-block w-100 h-100 banner-img" alt="Banner 3" style="object-fit: cover;">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </div>
            <a href="#services" class="section-arrow">
                <i class="fas fa-chevron-down"></i>
            </a>
        </section>

        <!-- SERVICES SECTION -->
        <section id="services" class="min-vh-100 d-flex align-items-center bg-light py-5 position-relative">
            <div class="container">
                <h2 class="text-center mb-5 display-4 fw-bold" data-lang-key="services_title">Our Services</h2>
                <div class="row g-5 justify-content-center">
                    <div class="col-md-4 col-lg-3">
                        <div class="card h-100 shadow-lg border-0 service-card text-center p-4">
                            <div class="service-icon mb-4">
                                <i class="fas fa-ticket-alt fa-4x" style="color: var(--mg-yellow);"></i>
                            </div>
                            <h4 class="mb-3" data-lang-key="service1_title">Submit Ticket</h4>
                            <p class="text-muted" data-lang-key="service1_desc">Create a new support ticket for your geological inquiries</p>
                            <a href="{{ route('tickets.create') }}" class="btn btn-service-yellow mt-auto" data-lang-key="service1_button">Create Ticket</a>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <div class="card h-100 shadow-lg border-0 service-card text-center p-4">
                            <div class="service-icon mb-4">
                                <i class="fas fa-calendar-alt fa-4x" style="color: var(--mg-yellow);"></i>
                            </div>
                            <h4 class="mb-3" data-lang-key="service2_title">Reschedule</h4>
                            <p class="text-muted" data-lang-key="service2_desc">Change your visit date or event for existing tickets</p>
                            <a href="{{ route('tickets.reschedule.form') }}" class="btn btn-service-yellow mt-auto" data-lang-key="service2_button">Reschedule Ticket</a>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <div class="card h-100 shadow-lg border-0 service-card text-center p-4">
                            <div class="service-icon mb-4">
                                <i class="fas fa-gamepad fa-4x" style="color: var(--mg-yellow);"></i>
                            </div>
                            <h4 class="mb-3" data-lang-key="service3_title">Mini Games</h4>
                            <p class="text-muted" data-lang-key="service3_desc">Check out the mini games available at the museum!</p>
                            <a href="{{ route('games.index') }}" class="btn btn-service-yellow mt-auto" data-lang-key="service3_button">Play Games</a>
                        </div>
                    </div>
                </div>
            </div>
            <a href="#events" class="section-arrow">
                <i class="fas fa-chevron-down"></i>
            </a>
        </section>

        <!-- UPCOMING EVENTS SECTION -->
<section id="events" class="min-vh-100 d-flex align-items-center py-5 position-relative">
    <div class="container">
        <h2 class="text-center mb-5 display-4 fw-bold">Upcoming Events</h2>

        <div class="row g-5 justify-content-center">
            @forelse($events as $event)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 event-card shadow-lg border-0 overflow-hidden">
                        <img src="{{ asset('storage/'.$event->image) }}" 
                             class="card-img-top" 
                             alt="{{ $event->title }}" 
                             style="height: 250px; object-fit: cover;">
                        <div class="card-body d-flex flex-column p-4">
                            <h5 class="card-title fw-bold">{{ $event->title }}</h5>
                            <p class="card-text flex-grow-1 text-muted">
                                {{ Str::limit($event->description, 120) }}
                            </p>
                            <div class="event-details mt-3 text-muted">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-calendar-alt me-2" style="color: var(--mg-yellow);"></i>
                                    <span>{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-clock me-2" style="color: var(--mg-yellow);"></i>
                                    <span>{{ \Carbon\Carbon::parse($event->event_time)->format('H:i') }}</span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-ticket-alt me-2" style="color: var(--mg-yellow);"></i>
                                    <strong>Rp {{ number_format($event->price, 0, ',', '.') }}</strong>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-users me-2" style="color: var(--mg-yellow);"></i>
                                    <span>
                                        <strong>{{ $event->available_slots }}</strong> / {{ $event->capacity }} tersisa
                                        @if($event->available_slots == 0)
                                            <span class="badge bg-danger ms-1">SOLD OUT</span>
                                        @elseif($event->available_slots <= 10)
                                            <span class="badge bg-warning text-dark ms-1">Hampir Habis!</span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                            @if($event->available_slots > 0)
                                <a href="{{ route('event.booking.create', $event->id) }}" class="btn btn-event-yellow mt-4 fw-bold">Get Ticket</a>
                            @else
                                <button class="btn btn-secondary mt-4 fw-bold" disabled>Sold Out</button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted py-5">
                    <p class="fs-3">Belum ada event yang tersedia saat ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>


        <!-- RATING & REVIEW FORM SECTION -->
        <section id="rating-review" class="min-vh-100 d-flex align-items-center bg-light py-5 position-relative">
            <div class="container">
                <h2 class="text-center mb-5 display-4 fw-bold" data-lang-key="rating_title">Rate Your Experience</h2>
                <div class="row justify-content-center">
                    <div class="col-lg-7 col-xl-6">
                        <div class="card shadow-lg mb-5">
                            <div class="card-body text-center py-5">
                                <h4 class="mb-5" data-lang-key="rating_question">How was your experience?</h4>
                                <div class="stars-container mb-4" id="starsContainer">
                                    <i class="fas fa-star" data-rating="1"></i>
                                    <i class="fas fa-star" data-rating="2"></i>
                                    <i class="fas fa-star" data-rating="3"></i>
                                    <i class="fas fa-star" data-rating="4"></i>
                                    <i class="fas fa-star" data-rating="5"></i>
                                </div>
                                <p id="ratingText" class="fs-3 fw-bold text-dark">&nbsp;</p>
                                <input type="hidden" id="selectedRating" value="0">
                            </div>
                        </div>
                        <div class="card shadow-lg">
                            <div class="card-body p-5">
                                <h4 class="text-center mb-4" data-lang-key="review_title">Write Your Review</h4>
                                <form id="reviewForm">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="reviewName" data-lang-placeholder="review_name" placeholder="Your Name" required>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="email" class="form-control" id="reviewEmail" data-lang-placeholder="review_email" placeholder="Your Email" required>
                                        </div>
                                        <div class="col-12">
                                            <textarea class="form-control" id="reviewText" rows="6" data-lang-placeholder="review_text" placeholder="Share your experience..." required></textarea>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-review-yellow w-100 py-3 fw-bold" data-lang-key="review_button">Submit Review</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a href="#customer-reviews" class="section-arrow">
                <i class="fas fa-chevron-down"></i>
            </a>
        </section>

        <!-- CUSTOMER REVIEWS SECTION -->
        <section id="customer-reviews" class="min-vh-100 d-flex align-items-center py-5 position-relative">
            <div class="container">
                <h2 class="text-center mb-5 display-4 fw-bold" data-lang-key="reviews_title">Customer Reviews</h2>
                <div id="reviewsSlider" class="reviews-slider position-relative">
                    @if(($reviews ?? collect())->count())
                        <div class="reviews-track d-flex gap-4" id="reviewsTrack">
                            @foreach(($reviews ?? collect()) as $review)
                                <div class="review-slide flex-shrink-0">
                                    <div class="review-card p-4 shadow-sm h-100 border-start border-4 border-warning bg-white">
                                        <div class="review-rating mb-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="{{ $i <= $review->rating ? 'fas fa-star text-warning' : 'far fa-star text-muted' }}"></i>
                                            @endfor
                                        </div>
                                        <div class="review-author fw-bold">{{ $review->name }}</div>
                                        <div class="review-email text-muted small mb-2">{{ $review->email }}</div>
                                        <div class="review-text mb-3">{{ $review->text }}</div>
                                        <div class="review-date text-muted small">
                                            {{ optional($review->created_at)->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="reviews-placeholder text-center text-muted py-5" id="reviewsPlaceholder">
                            <p class="fs-3" data-lang-key="reviews_empty">No reviews yet. Be the first to review!</p>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* IMPROVED HERO SECTION STYLING - Better Readability */
    .hero-section {
        background: transparent !important;
        color: #fff;
        position: relative;
    }

    /* Enhanced overlay with better contrast */
    .hero-overlay {
        position: absolute;
        inset: 0;
        background: transparent;
        pointer-events: none;
    }

    .hero-content {
        position: relative;
        z-index: 10;
        padding: 2rem;
        /* Background removed for transparency */
    }

    .hero-content h1 {
        font-size: 8rem;
        font-weight: 900;
        font-family: inherit;
        color: #1a1a1a;
        letter-spacing: 8px;
        line-height: 1.1;
        /* 3D Effect with thick yellow/gold outline */
        text-shadow: 
            /* Thick yellow outline */
            -4px -4px 0 #FFD700,
            -4px -3px 0 #FFD700,
            -4px -2px 0 #FFD700,
            -4px -1px 0 #FFD700,
            -4px 0px 0 #FFD700,
            -4px 1px 0 #FFD700,
            -4px 2px 0 #FFD700,
            -4px 3px 0 #FFD700,
            -4px 4px 0 #FFD700,
            -3px -4px 0 #FFD700,
            -3px -3px 0 #FFD700,
            -3px -2px 0 #FFD700,
            -3px -1px 0 #FFD700,
            -3px 0px 0 #FFD700,
            -3px 1px 0 #FFD700,
            -3px 2px 0 #FFD700,
            -3px 3px 0 #FFD700,
            -3px 4px 0 #FFD700,
            -2px -4px 0 #FFD700,
            -2px -3px 0 #FFD700,
            -2px -2px 0 #FFD700,
            -2px -1px 0 #FFD700,
            -2px 0px 0 #FFD700,
            -2px 1px 0 #FFD700,
            -2px 2px 0 #FFD700,
            -2px 3px 0 #FFD700,
            -2px 4px 0 #FFD700,
            -1px -4px 0 #FFD700,
            -1px -3px 0 #FFD700,
            -1px -2px 0 #FFD700,
            -1px -1px 0 #FFD700,
            -1px 0px 0 #FFD700,
            -1px 1px 0 #FFD700,
            -1px 2px 0 #FFD700,
            -1px 3px 0 #FFD700,
            -1px 4px 0 #FFD700,
            0px -4px 0 #FFD700,
            0px -3px 0 #FFD700,
            0px -2px 0 #FFD700,
            0px -1px 0 #FFD700,
            0px 1px 0 #FFD700,
            0px 2px 0 #FFD700,
            0px 3px 0 #FFD700,
            0px 4px 0 #FFD700,
            1px -4px 0 #FFD700,
            1px -3px 0 #FFD700,
            1px -2px 0 #FFD700,
            1px -1px 0 #FFD700,
            1px 0px 0 #FFD700,
            1px 1px 0 #FFD700,
            1px 2px 0 #FFD700,
            1px 3px 0 #FFD700,
            1px 4px 0 #FFD700,
            2px -4px 0 #FFD700,
            2px -3px 0 #FFD700,
            2px -2px 0 #FFD700,
            2px -1px 0 #FFD700,
            2px 0px 0 #FFD700,
            2px 1px 0 #FFD700,
            2px 2px 0 #FFD700,
            2px 3px 0 #FFD700,
            2px 4px 0 #FFD700,
            3px -4px 0 #FFD700,
            3px -3px 0 #FFD700,
            3px -2px 0 #FFD700,
            3px -1px 0 #FFD700,
            3px 0px 0 #FFD700,
            3px 1px 0 #FFD700,
            3px 2px 0 #FFD700,
            3px 3px 0 #FFD700,
            3px 4px 0 #FFD700,
            4px -4px 0 #FFD700,
            4px -3px 0 #FFD700,
            4px -2px 0 #FFD700,
            4px -1px 0 #FFD700,
            4px 0px 0 #FFD700,
            4px 1px 0 #FFD700,
            4px 2px 0 #FFD700,
            4px 3px 0 #FFD700,
            4px 4px 0 #FFD700,
            /* 3D depth shadow */
            6px 6px 0 #FFA500,
            8px 8px 0 #FF8C00,
            /* Final shadow for depth */
            10px 10px 20px rgba(0,0,0,0.3);
    }

    .text-subtitle {
        color: #2c3e50 !important;
        font-weight: 600;
        font-size: 1.8rem !important;
        text-shadow: 
            0 1px 3px rgba(255,255,255,0.8);
        letter-spacing: 3px;
    }

    .hero-content .lead {
        color: #333333 !important;
        text-shadow: 
            0 1px 2px rgba(255,255,255,0.9);
        line-height: 1.6;
        font-weight: 500;
        max-width: 900px;
    }

    .hero-content .lead strong {
        color: #1a1a1a;
        font-weight: 700;
        text-shadow: none;
    }

    /* Enhanced button with better visibility */
    .btn-service-yellow {
        background: linear-gradient(135deg, #FFC107 0%, #FFB300 100%) !important;
        color: #000000 !important;
        border: 3px solid #FFD54F !important;
        font-weight: 800 !important;
        font-size: 1.1rem;
        letter-spacing: 1px;
        text-shadow: none;
        box-shadow: 
            0 8px 25px rgba(255,193,7,0.4),
            0 0 40px rgba(255,193,7,0.3),
            inset 0 1px 0 rgba(255,255,255,0.3);
        transition: all 0.3s ease;
    }

    .btn-service-yellow:hover {
        background: linear-gradient(135deg, #1a1a1a 0%, #000000 100%) !important;
        color: #FFC107 !important;
        border-color: #FFC107 !important;
        transform: scale(1.05) translateY(-3px);
        box-shadow: 
            0 15px 40px rgba(255,193,7,0.5),
            0 0 60px rgba(255,193,7,0.4);
    }

    .scroll-indicator {
        position: absolute;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        animation: bounce 2s infinite;
        color: #FFC107;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% { 
            transform: translateX(-50%) translateY(0); 
        }
        40% { 
            transform: translateX(-50%) translateY(-15px); 
        }
        60% { 
            transform: translateX(-50%) translateY(-8px); 
        }
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .hero-content h1 {
            font-size: 3rem;
            letter-spacing: 4px;
        }
        
        .hero-content h2 {
            font-size: 2rem;
            letter-spacing: 2px;
        }
        
        .hero-content .lead {
            font-size: 1.1rem;
        }
        
        .hero-content {
            padding: 1.5rem;
        }
    }

    /* Additional glow effect on hover - removed since no background */
    
    /* Section Navigation Arrows */
    .section-arrow {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 10;
        animation: arrowBounce 2s infinite;
    }

    .section-arrow i {
        font-size: 2.5rem;
        color: var(--mg-yellow);
        filter: drop-shadow(0 4px 8px rgba(0,0,0,0.3));
        transition: all 0.3s ease;
    }

    .section-arrow:hover i {
        transform: translateY(5px);
        color: var(--mg-black);
    }

    @keyframes arrowBounce {
        0%, 20%, 50%, 80%, 100% { 
            transform: translateX(-50%) translateY(0); 
        }
        40% { 
            transform: translateX(-50%) translateY(-10px); 
        }
        60% { 
            transform: translateX(-50%) translateY(-5px); 
        }
    }
    /* ==== EFEK HOVER MODERN 2025 ==== */

    /* Service Cards */
    .service-card {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border-radius: 1rem;
    }

    .service-card:hover {
        transform: translateY(-20px) scale(1.05);
        box-shadow: 0 30px 60px rgba(0,0,0,0.18) !important;
    }

    .service-card .service-icon i {
        transition: transform 0.4s ease;
    }

    .service-card:hover .service-icon i {
        transform: scale(1.3) rotate(8deg);
    }

    /* Event Cards */
    .event-card {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border-radius: 1rem;
        overflow: hidden;
    }

    .event-card:hover {
        transform: translateY(-20px) scale(1.04);
        box-shadow: 0 35px 70px rgba(0,0,0,0.2) !important;
    }

    .event-card .card-img-top {
        transition: transform 0.8s ease;
    }

    .event-card:hover .card-img-top {
        transform: scale(1.18);
    }

    /* Buttons (semua jenis) */
    .btn-service-yellow,
    .btn-event-yellow,
    .btn-review-yellow {
        transition: all 0.35s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-service-yellow:hover,
    .btn-event-yellow:hover,
    .btn-review-yellow:hover {
        transform: scale(1.08);
        box-shadow: 0 10px 25px rgba(255,193,7,0.4);
    }

    /* Banner Section - Add padding to prevent cropping */
    #banner .carousel-inner {
        padding: 40px 60px;
    }

    #banner .banner-img {
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    }

    @media (max-width: 768px) {
        #banner .carousel-inner {
            padding: 20px 30px;
        }
    }

    /* Stars Rating */
    .stars-container i {
        font-size: 3.8rem;
        transition: all 0.3s ease;
        filter: drop-shadow(0 6px 12px rgba(0,0,0,0.15));
        color: #c6c6c6;
        cursor: pointer;
    }

    .stars-container i.selected,
    .stars-container i.active {
        color: var(--mg-yellow) !important;
        filter: drop-shadow(0 0 20px rgba(255,193,7,0.6));
    }

    .stars-container i:hover {
        transform: scale(1.35) translateY(-8px);
    }

    /* Review Card (setelah submit) */
    .review-card {
        transition: all 0.3s ease;
        border-radius: 0.8rem;
    }

    .review-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.12);
        border-left-color: #ffb300;
    }

    /* Button hover color tetap dipertahankan + ditambah glow */
    .btn-service-yellow:hover,
    .btn-event-yellow:hover,
    .btn-review-yellow:hover {
        background: var(--mg-black) !important;
        color: var(--mg-yellow) !important;
        border-color: var(--mg-black) !important;
    }

    /* Tambahan kecil biar lebih modern */
    .card {
        border: none !important;
        border-radius: 1px solid rgba(0,0,0,0.05);
    }

    h2.display-4 {
        background: linear-gradient(90deg, #000000, #000000);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Reviews slider */
    .reviews-slider {
        overflow: hidden;
        width: 100%;
        max-width: 1100px;
        margin: 0 auto;
    }

        .reviews-track {
            width: max-content;
            display: flex;
            gap: 1.5rem;
            padding-bottom: 0.5rem;
            will-change: transform;
        }

    .review-slide {
        flex: 0 0 calc(100% - 2rem);
        max-width: 420px;
    }

    @media (min-width: 768px) {
        .review-slide {
            flex: 0 0 360px;
        }
    }

    @media (min-width: 1200px) {
        .review-slide {
            flex: 0 0 420px;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    // Script untuk carousel auto-slide dengan interval 5 detik (5000 ms)
    document.addEventListener('DOMContentLoaded', function() {
        var carousel = document.getElementById('bannerCarousel');
        if (carousel) {
            var bsCarousel = new bootstrap.Carousel(carousel, {
                interval: 5000,  // 5 detik
                wrap: true
            });
        }

        // Rating & Review: star interactions
        var starsContainer = document.getElementById('starsContainer');
        var selectedRatingInput = document.getElementById('selectedRating');
        var ratingText = document.getElementById('ratingText');

        if (starsContainer) {
            var stars = Array.from(starsContainer.querySelectorAll('i[data-rating]'));

            function setStars(rating) {
                stars.forEach(function(star) {
                    var r = parseInt(star.getAttribute('data-rating'));
                    if (r <= rating) {
                        star.classList.add('selected');
                        star.classList.remove('active');
                    } else {
                        star.classList.remove('selected');
                        star.classList.remove('active');
                    }
                });
            }

            stars.forEach(function(star) {
                star.addEventListener('mouseenter', function() {
                    var r = parseInt(this.getAttribute('data-rating'));
                    stars.forEach(function(s) {
                        var rr = parseInt(s.getAttribute('data-rating'));
                        if (rr <= r) s.classList.add('active');
                        else s.classList.remove('active');
                    });
                });

                star.addEventListener('mouseleave', function() {
                    stars.forEach(function(s) { s.classList.remove('active'); });
                });

                star.addEventListener('click', function() {
                    var r = parseInt(this.getAttribute('data-rating'));
                    selectedRatingInput.value = r;
                    setStars(r);
                    var texts = ['Very poor','Poor','Okay','Good','Excellent'];
                    ratingText.textContent = r + ' / 5 — ' + texts[r-1];
                });
            });
        }

        // Reviews slider autoplay
        var reviewsSlider = document.getElementById('reviewsSlider');
        var reviewsTrack = document.getElementById('reviewsTrack');
        var sliderAnimationId;
        var sliderSpeed = 0.35; // px per frame
        var trackOffset = 0;
        var trackGap = 0;

        function updateTrackGap() {
            if (!reviewsTrack) return;
            var styles = window.getComputedStyle(reviewsTrack);
            var gapValue = parseFloat(styles.columnGap || styles.gap || 0);
            trackGap = isNaN(gapValue) ? 0 : gapValue;
        }

        function runReviewsSlider() {
            if (!reviewsSlider || !reviewsTrack) return;
            if (reviewsTrack.children.length < 2) {
                reviewsTrack.style.transform = 'translateX(0)';
                return;
            }

            if (reviewsSlider.dataset.paused === 'true') {
                sliderAnimationId = requestAnimationFrame(runReviewsSlider);
                return;
            }

            trackOffset -= sliderSpeed;
            var firstSlide = reviewsTrack.children[0];

            if (firstSlide) {
                var firstWidth = firstSlide.getBoundingClientRect().width;
                if (-trackOffset >= firstWidth + trackGap) {
                    trackOffset += firstWidth + trackGap;
                    reviewsTrack.appendChild(firstSlide);
                }
            }

            reviewsTrack.style.transform = 'translateX(' + trackOffset + 'px)';
            sliderAnimationId = requestAnimationFrame(runReviewsSlider);
        }

        function initReviewsSlider() {
            reviewsTrack = document.getElementById('reviewsTrack');

            if (sliderAnimationId) cancelAnimationFrame(sliderAnimationId);

            if (!reviewsSlider || !reviewsTrack) return;
            if (reviewsTrack.children.length < 2) {
                reviewsTrack.style.transform = 'translateX(0)';
                return;
            }

            trackOffset = 0;
            reviewsTrack.style.transform = 'translateX(0)';
            updateTrackGap();
            sliderAnimationId = requestAnimationFrame(runReviewsSlider);
        }

        if (reviewsSlider) {
            reviewsSlider.dataset.paused = 'false';
            ['mouseenter', 'touchstart'].forEach(function(evt) {
                reviewsSlider.addEventListener(evt, function() {
                    reviewsSlider.dataset.paused = 'true';
                });
            });
            ['mouseleave', 'touchend'].forEach(function(evt) {
                reviewsSlider.addEventListener(evt, function() {
                    reviewsSlider.dataset.paused = 'false';
                });
            });

            initReviewsSlider();
            window.addEventListener('resize', initReviewsSlider);
        }

        // === Review form submission (server-side via AJAX) ===
        var reviewForm = document.getElementById('reviewForm');

        if (reviewForm) {
            reviewForm.addEventListener('submit', function(e) {
                e.preventDefault();

                var rating = parseInt(document.getElementById('selectedRating').value || 0);
                var name = document.getElementById('reviewName').value.trim();
                var email = document.getElementById('reviewEmail').value.trim();
                var text = document.getElementById('reviewText').value.trim();

                if (!rating) {
                    alert('Please select a rating (1-5 stars) before submitting.');
                    return;
                }

                if (!name || !email || !text) {
                    alert('Please fill name, email and review text.');
                    return;
                }

                fetch('/reviews', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ name, email, text, rating })
                })
                .then(async response => {
                    if (!response.ok) {
                        let message = 'Failed to save review. Please try again.';
                        try {
                            const body = await response.json();
                            if (body?.message) {
                                message = body.message;
                            } else if (body?.errors) {
                                message = Object.values(body.errors).flat().join('\n');
                            }
                        } catch (parseError) {
                            console.error(parseError);
                        }
                        throw new Error(message);
                    }
                    return response.json();
                })
                .then(data => {
                    alert(data.message || 'Thank you! Your review has been saved.');

                    var col = document.createElement('div');
                    col.className = 'review-slide flex-shrink-0';
                    col.innerHTML = `
                        <div class="review-card p-4 shadow-sm h-100 border-start border-4 border-warning bg-white">
                            <div class="review-rating mb-2">
                                ${'<i class="fas fa-star text-warning"></i>'.repeat(rating)}
                                ${'<i class="far fa-star text-muted"></i>'.repeat(5 - rating)}
                            </div>
                            <div class="review-author fw-bold">${data.review?.name || name}</div>
                            <div class="review-email text-muted small mb-2">${data.review?.email || email}</div>
                            <div class="review-text mb-3">${data.review?.text || text}</div>
                            <div class="review-date text-muted small">baru saja</div>
                        </div>
                    `;

                    var placeholder = document.getElementById('reviewsPlaceholder');
                    if (placeholder) placeholder.remove();

                    var sliderWrapper = document.getElementById('reviewsSlider');
                    var track = document.getElementById('reviewsTrack');

                    if (!track) {
                        track = document.createElement('div');
                        track.className = 'reviews-track d-flex gap-4';
                        track.id = 'reviewsTrack';
                        if (sliderWrapper) {
                            sliderWrapper.innerHTML = '';
                            sliderWrapper.appendChild(track);
                        }
                    }

                    track.insertBefore(col, track.firstChild);
                    initReviewsSlider();

                    reviewForm.reset();
                    document.getElementById('selectedRating').value = 0;
                    ratingText.textContent = '';
                    stars.forEach(function(s) { s.classList.remove('selected'); });
                })
                .catch(error => {
                    console.error(error);
                    alert(error.message || 'Failed to save review. Please try again.');
                });
            });
        }

        
    });
</script>
@endsection
