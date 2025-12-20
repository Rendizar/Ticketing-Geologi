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
                    <a href="#banner" class="btn btn-lg btn-service-yellow fw-bold px-5 py-3 animate__animated animate__fadeInUp" style="animation-delay: 0.8s; color: #000000 !important;" data-lang-key="hero_button">
                        Get Started
                    </a>
                </div>
            </div>
            <a href="#banner" class="section-arrow">
                <i class="fas fa-chevron-down"></i>
            </a>
        </section>

        <!-- BANNER SECTION -->
        <section id="banner" class="min-vh-100 d-flex align-items-center position-relative overflow-hidden scroll-reveal">
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
        <section id="services" class="min-vh-100 d-flex align-items-center py-5 position-relative scroll-reveal" style="overflow: hidden;">
            <!-- Background Image -->
            <div class="section-bg" style="position: absolute; inset: 0; background-image: url('{{ asset('images/section1.png') }}'); background-size: cover; background-position: center;"></div>
            <!-- Dark Overlay with Fade -->
            <div class="section-overlay" style="position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.4) 15%, rgba(0, 0, 0, 0.4) 85%, rgba(0, 0, 0, 0.7) 100%);"></div>
            <!-- Content -->
            <div class="container position-relative" style="z-index: 2;">
                <h2 class="text-center mb-5 display-4 fw-bold" style="font-family: 'Merriweather', serif !important; color: #ffffff !important;" data-lang-key="services_title">Our Services</h2>
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
<section id="events" class="min-vh-100 d-flex align-items-center py-5 position-relative scroll-reveal">
    <div class="container">
        <h2 class="text-center mb-5 display-4 fw-bold" style="font-family: 'Merriweather', serif !important;">Upcoming Events</h2>

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
                            <p class="card-text grow text-muted">
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
    <a href="#rating-review" class="section-arrow">
        <i class="fas fa-chevron-down"></i>
    </a>
</section>


        <!-- RATING & REVIEW FORM SECTION -->
        <section id="rating-review" class="min-vh-100 d-flex align-items-center py-5 position-relative scroll-reveal" style="overflow: hidden;">
            <!-- Background Image -->
            <div class="section-bg" style="position: absolute; inset: 0; background-image: url('{{ asset('images/section2.png') }}'); background-size: cover; background-position: center;"></div>
            <!-- Dark Overlay with Fade -->
            <div class="section-overlay" style="position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.4) 15%, rgba(0, 0, 0, 0.4) 85%, rgba(0, 0, 0, 0.7) 100%);"></div>
            <!-- Content -->
            <div class="container position-relative" style="z-index: 2;">
                <h2 class="text-center mb-5 display-4 fw-bold" style="font-family: 'Merriweather', serif !important; color: #ffffff !important;" data-lang-key="rating_title">Rate Your Experience</h2>
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-xl-7">
                        <div class="card shadow-sm border-0" style="border-radius: 20px; overflow: hidden;">
                            <div class="card-body p-4 p-md-5">
                                <!-- Rating Section -->
                                <div class="text-center mb-4 pb-4" style="border-bottom: 1px solid #e5e7eb;">
                                    <h4 class="mb-4" style="color: #1F2933; font-weight: 600;" data-lang-key="rating_question">How was your experience?</h4>
                                    <div class="stars-container d-flex justify-content-center gap-2 mb-3" id="starsContainer">
                                        <i class="fas fa-star" data-rating="1"></i>
                                        <i class="fas fa-star" data-rating="2"></i>
                                        <i class="fas fa-star" data-rating="3"></i>
                                        <i class="fas fa-star" data-rating="4"></i>
                                        <i class="fas fa-star" data-rating="5"></i>
                                    </div>
                                    <p id="ratingText" class="fs-6 fw-semibold mb-0" style="color: #9CA3AF; min-height: 24px;">&nbsp;</p>
                                    <input type="hidden" id="selectedRating" value="0">
                                </div>
                                
                                <!-- Review Form -->
                                <div class="pt-2">
                                    <h5 class="mb-4 text-center" style="color: #1F2933; font-weight: 600;" data-lang-key="review_title">Share Your Thoughts</h5>
                                    <form id="reviewForm">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <input type="text" class="form-control modern-input" id="reviewName" data-lang-placeholder="review_name" placeholder="Your Name" required>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="email" class="form-control modern-input" id="reviewEmail" data-lang-placeholder="review_email" placeholder="Your Email" required>
                                            </div>
                                            <div class="col-12">
                                                <textarea class="form-control modern-input" id="reviewText" rows="5" data-lang-placeholder="review_text" placeholder="Share your experience with us..." required></textarea>
                                            </div>
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-review-yellow w-100 py-3 fw-semibold" data-lang-key="review_button" style="border-radius: 12px; transition: all 0.3s ease;">Submit Review</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
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
        <section id="customer-reviews" class="min-vh-100 d-flex align-items-center py-5 position-relative scroll-reveal">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="display-4 fw-bold mb-3" style="font-family: 'Merriweather', serif !important; color: #1F2933;" data-lang-key="reviews_title">Customer Reviews</h2>
                    <p class="text-muted fs-5" style="max-width: 600px; margin: 0 auto;">Hear what our visitors say about their geology adventure</p>
                </div>
                <div id="reviewsContainer" class="reviews-container">
                    @if(($reviews ?? collect())->count())
                        <div class="row g-4" id="reviewsGrid">
                            @foreach(($reviews ?? collect()) as $review)
                                <div class="col-lg-4 col-md-6">
                                    <div class="modern-review-card h-100">
                                        <div class="quote-icon">
                                            <i class="fas fa-quote-left"></i>
                                        </div>
                                        <div class="review-rating mb-3">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $review->rating ? 'star-filled' : 'star-empty' }}"></i>
                                            @endfor
                                        </div>
                                        <p class="review-text mb-4">{{ $review->text }}</p>
                                        <div class="d-flex align-items-center mt-auto">
                                            <div class="review-avatar">
                                                {{ strtoupper(substr($review->name, 0, 1)) }}
                                            </div>
                                            <div class="ms-3">
                                                <div class="review-author">{{ $review->name }}</div>
                                                <div class="review-date">{{ optional($review->created_at)->diffForHumans() }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="reviews-placeholder text-center text-muted py-5" id="reviewsPlaceholder">
                            <div class="mb-4">
                                <i class="fas fa-comments" style="font-size: 4rem; color: #E5E7EB;"></i>
                            </div>
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
    /* Import Merriweather Font */
    @import url('https://fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700;900&display=swap');
    
    /* Import Open Sans Font */
    @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap');

    /* Apply Open Sans to all text by default */
    body, p, span, a, button, input, textarea, select, .btn, .card-text, .lead, h3, h4, h5, h6, .text-muted, .form-control, .badge {
        font-family: 'Open Sans', sans-serif !important;
    }

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
        font-size: clamp(2.5rem, 7vw, 8rem);
        font-weight: 900;
        font-family: 'Futura PT', 'Century Gothic', sans-serif;
        color: #1a1a1a;
        -webkit-text-stroke: 3px #FFD400;
        text-stroke: 3px #FFD400;
        paint-order: stroke fill;
        text-shadow: 
            0 1px 0 #FFD400,
            0 2px 0 #FFD400,
            0 3px 0 #FFD400,
            0 4px 0 #FFD400,
            0 5px 0 #FFD400,
            0 6px 1px rgba(0,0,0,.1),
            0 0 5px rgba(0,0,0,.1),
            0 1px 3px rgba(0,0,0,.3),
            0 3px 5px rgba(0,0,0,.2),
            0 5px 10px rgba(0,0,0,.25),
            0 10px 20px rgba(0,0,0,.2),
            0 20px 30px rgba(0,0,0,.15);
        letter-spacing: 0.15em;
        line-height: 1.1;
        transform: perspective(500px) rotateX(5deg);
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


    /* Section Title with Yellow Outline */
    .section-title-outline {
        -webkit-text-stroke: 2px #FFD400;
        text-stroke: 2px #FFD400;
        paint-order: stroke fill;
        color: #1a1a1a;
    }

    /* Enhanced button - sama dengan btn-login */
    .btn-service-yellow {
        background: #FACC15 !important;
        color: #000000 !important;
        border: 2px solid #FACC15 !important;
        font-weight: 700;
        transition: all 0.3s ease;
        border-radius: 25px;
        font-size: 1.1rem;
        padding: 0.75rem 2rem;
    }

    .btn-service-yellow:hover {
        background: transparent !important;
        color: #FACC15 !important;
        border-color: #FACC15 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(250, 204, 21, 0.3);
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
    @media (max-width: 992px) {
        .hero-content h1 {
            font-size: 4rem;
            letter-spacing: 6px;
        }
        
        .hero-content h2 {
            font-size: 1.5rem;
        }
        
        .btn-service-yellow,
        .btn-event-yellow,
        .btn-review-yellow {
            font-size: 1rem;
            padding: 0.6rem 1.5rem;
        }
        
        .section-arrow i {
            font-size: 2rem;
        }
    }

    @media (max-width: 768px) {
        .hero-content h1 {
            font-size: 3rem;
            letter-spacing: 4px;
            -webkit-text-stroke: 2px #FFD400;
            text-stroke: 2px #FFD400;
        }
        
        .hero-content h2 {
            font-size: 1.3rem;
            letter-spacing: 2px;
        }
        
        .hero-content .lead {
            font-size: 1rem;
            padding: 0 1rem;
        }
        
        .hero-content {
            padding: 1rem;
        }
        
        .service-card,
        .event-card {
            margin-bottom: 1.5rem;
        }
        
        .btn-service-yellow,
        .btn-event-yellow,
        .btn-review-yellow {
            font-size: 0.95rem;
            padding: 0.5rem 1.2rem;
        }
        
        .display-4 {
            font-size: 2rem !important;
        }
        
        .section-arrow i {
            font-size: 1.8rem;
        }
        
        .stars-container i {
            font-size: 2rem;
        }
    }
    
    @media (max-width: 576px) {
        .hero-content h1 {
            font-size: 2.5rem;
            letter-spacing: 3px;
            -webkit-text-stroke: 1.5px #FFD400;
            text-stroke: 1.5px #FFD400;
        }
        
        .hero-content h2 {
            font-size: 1.1rem;
            letter-spacing: 1px;
        }
        
        .hero-content .lead {
            font-size: 0.9rem;
        }
        
        .btn-service-yellow,
        .btn-event-yellow,
        .btn-review-yellow {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
            letter-spacing: 0.5px;
        }
        
        .display-4 {
            font-size: 1.75rem !important;
        }
        
        .card-body {
            padding: 1rem !important;
        }
        
        h4 {
            font-size: 1.1rem;
        }
        
        .section-arrow i {
            font-size: 1.5rem;
        }
        
        .stars-container i {
            font-size: 1.8rem;
        }
        
        .review-slide {
            flex: 0 0 calc(100% - 1rem);
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

    /* Buttons - sama dengan btn-login di login.blade.php */
    .btn-service-yellow,
    .btn-event-yellow,
    .btn-review-yellow {
        background: var(--mg-yellow) !important;
        color: var(--mg-black) !important;
        border: 2px solid var(--mg-yellow) !important;
        font-weight: 700;
        transition: all 0.3s ease;
        border-radius: 25px;
        font-size: 1.1rem;
        padding: 0.75rem 2rem;
        position: relative;
        overflow: hidden;
    }

    .btn-service-yellow:hover,
    .btn-event-yellow:hover,
    .btn-review-yellow:hover {
        background: var(--mg-black) !important;
        color: var(--mg-yellow) !important;
        border-color: var(--mg-black) !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
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
        font-size: 2.8rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        color: #e5e7eb;
        cursor: pointer;
        filter: none;
    }

    .stars-container i.selected,
    .stars-container i.active {
        color: #FACC15 !important;
        filter: drop-shadow(0 0 8px rgba(250, 204, 21, 0.4));
    }

    .stars-container i:hover {
        transform: scale(1.2) translateY(-4px);
        color: #FACC15;
    }
    
    /* Modern Input Styling */
    .modern-input {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: #f9fafb;
    }
    
    .modern-input:focus {
        border-color: #FACC15;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(250, 204, 21, 0.1);
        outline: none;
    }
    
    .modern-input::placeholder {
        color: #9CA3AF;
    }

    /* Review Card (setelah submit) - optimized untuk performance */
    .review-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease, border-left-color 0.3s ease;
        border-radius: 0.8rem;
    }

    .review-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.12);
        border-left-color: #ffb300;
        will-change: transform;
    }

    /* Tambahan kecil biar lebih modern */
    .card {
        border: none !important;
        border-radius: 1px solid rgba(0,0,0,0.05);
    }

    h2.display-4 {
        font-family: 'Merriweather', serif !important;
    }
    
    /* White text for sections with background images */
    #services h2.display-4,
    #rating-review h2.display-4 {
        color: #ffffff !important;
        background: none !important;
        -webkit-text-fill-color: #ffffff !important;
    }

    /* Modern Reviews Section */
    .reviews-container {
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .modern-review-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(31, 41, 51, 0.08);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        position: relative;
        border: 1px solid rgba(229, 231, 235, 0.5);
    }
    
    .modern-review-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(31, 41, 51, 0.12);
        border-color: rgba(250, 204, 21, 0.3);
    }
    
    .quote-icon {
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
        color: rgba(250, 204, 21, 0.15);
        font-size: 2.5rem;
    }
    
    .modern-review-card .review-rating {
        display: flex;
        gap: 0.25rem;
    }
    
    .modern-review-card .review-rating .star-filled {
        color: #FACC15;
        font-size: 1rem;
    }
    
    .modern-review-card .review-rating .star-empty {
        color: #E5E7EB;
        font-size: 1rem;
    }
    
    .modern-review-card .review-text {
        color: #4B5563;
        font-size: 1rem;
        line-height: 1.7;
        font-style: italic;
        flex-grow: 1;
    }
    
    .review-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: linear-gradient(135deg, #FACC15 0%, #F59E0B 100%);
        color: #1F2933;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.25rem;
        flex-shrink: 0;
    }
    
    .modern-review-card .review-author {
        font-weight: 600;
        color: #1F2933;
        font-size: 1rem;
        margin-bottom: 0.25rem;
    }
    
    .modern-review-card .review-date {
        font-size: 0.875rem;
        color: #9CA3AF;
    }
    
    /* Scroll Reveal Animation */
    .scroll-reveal {
        opacity: 0;
        transform: translateY(80px);
        transition: opacity 0.8s ease-out, transform 0.8s ease-out;
    }
    
    .scroll-reveal.revealed {
        opacity: 1;
        transform: translateY(0);
    }
</style>
@endsection

@section('scripts')
<script>
    // Script untuk carousel auto-slide dengan interval 6 detik (6000 ms)
    document.addEventListener('DOMContentLoaded', function() {
        var carousel = document.getElementById('bannerCarousel');
        if (carousel) {
            var bsCarousel = new bootstrap.Carousel(carousel, {
                interval: 6000,  // 6 detik
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

                    var reviewName = data.review?.name || name;
                    var reviewInitial = reviewName.charAt(0).toUpperCase();
                    
                    var stars = '';
                    for (var i = 1; i <= 5; i++) {
                        stars += '<i class="fas fa-star ' + (i <= rating ? 'star-filled' : 'star-empty') + '"></i>';
                    }
                    
                    var col = document.createElement('div');
                    col.className = 'col-lg-4 col-md-6';
                    col.innerHTML = `
                        <div class="modern-review-card h-100">
                            <div class="quote-icon">
                                <i class="fas fa-quote-left"></i>
                            </div>
                            <div class="review-rating mb-3">
                                ${stars}
                            </div>
                            <p class="review-text mb-4">${data.review?.text || text}</p>
                            <div class="d-flex align-items-center mt-auto">
                                <div class="review-avatar">
                                    ${reviewInitial}
                                </div>
                                <div class="ms-3">
                                    <div class="review-author">${reviewName}</div>
                                    <div class="review-date">baru saja</div>
                                </div>
                            </div>
                        </div>
                    `;

                    var placeholder = document.getElementById('reviewsPlaceholder');
                    if (placeholder) placeholder.remove();

                    var container = document.getElementById('reviewsContainer');
                    var grid = document.getElementById('reviewsGrid');

                    if (!grid) {
                        grid = document.createElement('div');
                        grid.className = 'row g-4';
                        grid.id = 'reviewsGrid';
                        if (container) {
                            container.innerHTML = '';
                            container.appendChild(grid);
                        }
                    }

                    grid.insertBefore(col, grid.firstChild);

                    reviewForm.reset();
                    document.getElementById('selectedRating').value = 0;
                    ratingText.textContent = '';
                    
                    // Reset star selection in the rating input
                    var starsInContainer = starsContainer ? Array.from(starsContainer.querySelectorAll('i[data-rating]')) : [];
                    starsInContainer.forEach(function(s) { s.classList.remove('selected'); });
                })
                .catch(error => {
                    console.error(error);
                    alert(error.message || 'Failed to save review. Please try again.');
                });
            });
        }

        
    });
    
    // Scroll Reveal Animation
    function revealOnScroll() {
        const reveals = document.querySelectorAll('.scroll-reveal');
        
        reveals.forEach(element => {
            const windowHeight = window.innerHeight;
            const elementTop = element.getBoundingClientRect().top;
            const revealPoint = 150;
            
            if (elementTop < windowHeight - revealPoint) {
                element.classList.add('revealed');
            }
        });
    }
    
    // Trigger on load and scroll
    window.addEventListener('scroll', revealOnScroll);
    window.addEventListener('load', revealOnScroll);
</script>
@endsection
