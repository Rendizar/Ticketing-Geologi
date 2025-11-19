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
                            <img src="{{ asset('images/banner1.png') }}" class="d-block w-100 h-100 banner-img" alt="Banner 2" style="object-fit: cover;">
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
                                <i class="fas fa-search fa-4x" style="color: var(--mg-yellow);"></i>
                            </div>
                            <h4 class="mb-3" data-lang-key="service2_title">Track Status</h4>
                            <p class="text-muted" data-lang-key="service2_desc">Check the status of your existing support tickets</p>
                            <a href="#" class="btn btn-service-yellow mt-auto" data-lang-key="service2_button">Track Ticket</a>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <div class="card h-100 shadow-lg border-0 service-card text-center p-4">
                            <div class="service-icon mb-4">
                                <i class="fas fa-gamepad fa-4x" style="color: var(--mg-yellow);"></i>
                            </div>
                            <h4 class="mb-3" data-lang-key="service3_title">Mini Games</h4>
                            <p class="text-muted" data-lang-key="service3_desc">Check out the mini games available at the museum!</p>
                            <a href="#" class="btn btn-service-yellow mt-auto" data-lang-key="service3_button">Play Games</a>
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
                <h2 class="text-center mb-5 display-4 fw-bold" data-lang-key="events_title">Upcoming Events</h2>
                <div class="row g-5 justify-content-center">
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 event-card shadow-lg border-0 overflow-hidden">
                            <img src="https://via.placeholder.com/600x400?text=Geology+Workshop+2023" class="card-img-top" alt="Geology Workshop 2023" style="height: 250px; object-fit: cover;">
                            <div class="card-body d-flex flex-column p-4">
                                <h5 class="card-title fw-bold" data-lang-key="event1_title">Geology Workshop 2023</h5>
                                <p class="card-text flex-grow-1 text-muted" data-lang-key="event1_desc">Join our interactive workshop on modern geology techniques.</p>
                                <div class="event-details mt-3 text-muted">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-calendar-alt me-2" style="color: var(--mg-yellow);"></i>
                                        <span>15 Dec 2023</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-clock me-2" style="color: var(--mg-yellow);"></i>
                                        <span>10:00 AM - 04:00 PM</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-ticket-alt me-2" style="color: var(--mg-yellow);"></i>
                                        <strong>Rp 50.000</strong>
                                    </div>
                                </div>
                                <a href="#" class="btn btn-event-yellow mt-4 fw-bold" data-lang-key="event_button">Get Ticket</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 event-card shadow-lg border-0 overflow-hidden">
                            <img src="https://via.placeholder.com/600x400?text=Fossil+Exhibition" class="card-img-top" alt="Fossil Exhibition" style="height: 250px; object-fit: cover;">
                            <div class="card-body d-flex flex-column p-4">
                                <h5 class="card-title fw-bold" data-lang-key="event2_title">Fossil Exhibition</h5>
                                <p class="card-text flex-grow-1 text-muted" data-lang-key="event2_desc">Explore ancient fossils from around the world, including rare dinosaur specimens.</p>
                                <div class="event-details mt-3 text-muted">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-calendar-alt me-2" style="color: var(--mg-yellow);"></i>
                                        <span>20 - 25 Jan 2024</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-clock me-2" style="color: var(--mg-yellow);"></i>
                                        <span>09:00 AM - 05:00 PM</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-ticket-alt me-2" style="color: var(--mg-yellow);"></i>
                                        <strong>Rp 30.000</strong>
                                    </div>
                                </div>
                                <a href="#" class="btn btn-event-yellow mt-4 fw-bold" data-lang-key="event_button">Get Ticket</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 event-card shadow-lg border-0 overflow-hidden">
                            <img src="https://via.placeholder.com/600x400?text=Earthquake+Simulation" class="card-img-top" alt="Earthquake Simulation Tour" style="height: 250px; object-fit: cover;">
                            <div class="card-body d-flex flex-column p-4">
                                <h5 class="card-title fw-bold" data-lang-key="event3_title">Earthquake Simulation Tour</h5>
                                <p class="card-text flex-grow-1 text-muted" data-lang-key="event3_desc">Experience a realistic earthquake simulation and learn essential safety measures.</p>
                                <div class="event-details mt-3 text-muted">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-calendar-alt me-2" style="color: var(--mg-yellow);"></i>
                                        <span>05 Feb 2024</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-clock me-2" style="color: var(--mg-yellow);"></i>
                                        <span>11:00 AM & 02:00 PM</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-ticket-alt me-2" style="color: var(--mg-yellow);"></i>
                                        <strong>Rp 40.000</strong>
                                    </div>
                                </div>
                                <a href="#" class="btn btn-event-yellow mt-4 fw-bold" data-lang-key="event_button">Get Ticket</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a href="#rating-review" class="section-arrow">
                <i class="fas fa-chevron-down"></i>
            </a>
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
                <div class="row g-4" id="reviewsList">
                    <div class="col-12 text-center text-muted py-5">
                        <p class="fs-3" data-lang-key="reviews_empty">No reviews yet. Be the first to review!</p>
                    </div>
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
        font-size: 5.5rem;
        font-weight: 800;
        font-family: inherit; /* Use default font like other sections */
        color: #1a1a1a;
        text-shadow: 
            0 2px 4px rgba(255,255,255,0.8),
            0 4px 8px rgba(255,255,255,0.6);
        letter-spacing: 8px;
        line-height: 1.1;
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
    }

    .stars-container i:hover {
        transform: scale(1.35) translateY(-8px);
        color: var(--mg-yellow) !important;
        filter: drop-shadow(0 0 20px rgba(255,193,7,0.6));
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
                    // remove hover effects
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

        // Review form submission (client-side only)
        var reviewForm = document.getElementById('reviewForm');
        var reviewsList = document.getElementById('reviewsList');

        if (reviewForm && reviewsList) {
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

                // Build review HTML (client-side only). For production, POST to server instead.
                var col = document.createElement('div');
                col.className = 'col-md-6';

                var card = document.createElement('div');
                card.className = 'review-card';

                var ratingEl = document.createElement('div');
                ratingEl.className = 'review-rating';
                ratingEl.innerHTML = Array.from({length: rating}).map(function(){ return '<i class="fas fa-star"></i>'; }).join('') +
                    Array.from({length: 5-rating}).map(function(){ return '<i class="far fa-star" style="color:#ddd"></i>'; }).join('');

                var authorEl = document.createElement('div');
                authorEl.className = 'review-author';
                authorEl.textContent = name;

                var emailEl = document.createElement('div');
                emailEl.className = 'review-email mb-2';
                emailEl.textContent = email;

                var textEl = document.createElement('div');
                textEl.className = 'review-text';
                textEl.textContent = text;

                card.appendChild(ratingEl);
                card.appendChild(authorEl);
                card.appendChild(emailEl);
                card.appendChild(textEl);

                col.appendChild(card);

                // If there was the 'no reviews' placeholder, remove it
                var placeholder = reviewsList.querySelector('.text-muted');
                if (placeholder) placeholder.remove();

                // Prepend new review
                reviewsList.insertBefore(col, reviewsList.firstChild);

                // Reset form and stars
                reviewForm.reset();
                selectedRatingInput.value = 0;
                if (starsContainer) setStars(0);
                ratingText.textContent = 'Select Rating';

                // Optional: show success message
                alert('Thank you! Your review has been added (client-side only).');
            });
        }

        // Hapus script terkait mini games karena sidebar dihapus
    });
</script>
@endsection