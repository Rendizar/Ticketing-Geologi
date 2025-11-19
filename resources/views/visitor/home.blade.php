@extends('layouts.app')

@section('title', 'Museum Geologi - Virtual Tour')

@section('content')
<div class="container-fluid px-5">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-12 py-5">  <!-- Diperluas menjadi full width karena sidebar dihapus -->
            {{-- <h1 class="display-4 mb-4">Museum Geologi</h1> --}}
            
            <!-- Banner Slider Section (menggantikan knowledge test dan related items) -->
            <div class="row mb-5" id="banner">
                <div class="col-12">
                    <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset('images/banner1.png') }}" class="d-block w-100" alt="Banner 1" style="height: 1000px; object-fit: cover;">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('images/banner1.png') }}" class="d-block w-100" alt="Banner 2" style="height: 1000px; object-fit: cover;">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('images/banner1.png') }}" class="d-block w-100" alt="Banner 3" style="height: 1000px; object-fit: cover;">
                            </div>
                            <!-- Tambahkan lebih banyak carousel-item sesuai kebutuhan -->
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Services Section (dipindah ke atas) -->
<div class="container mb-5" id="services">
    <h2 class="text-center mb-4">Our Services</h2>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 service-card">
                <div class="card-body text-center">
                    <div class="service-icon mb-3">
                        <i class="fas fa-ticket-alt fa-3x" style="color: var(--mg-yellow);"></i>
                    </div>
                    <h4>Submit Ticket</h4>
                    <p>Create a new support ticket for your geological inquiries</p>
                    <a href="{{ route('tickets.create') }}" class="btn btn-service-yellow">Create Ticket</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 service-card">
                <div class="card-body text-center">
                    <div class="service-icon mb-3">
                        <i class="fas fa-search fa-3x" style="color: var(--mg-yellow);"></i>
                    </div>
                    <h4>Track Status</h4>
                    <p>Check the status of your existing support tickets</p>
                    <a href="#" class="btn btn-service-yellow">Track Ticket</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 service-card">
                <div class="card-body text-center">
                    <div class="service-icon mb-3">
                        <i class="fas fa-book fa-3x" style="color: var(--mg-yellow);"></i>
                    </div>
                    <h4>Mini Games</h4>
                    <p>Check out the mini games available at the museum!</p>
                    <a href="#" class="btn btn-service-yellow">Games</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upcoming Events Section (diubah menjadi statis dengan 3 poster random placeholder) -->
<div class="container mb-5" id="events">
    <h2 class="text-center mb-4">Upcoming Events</h2>
    <div class="row g-4">
        <!-- Event 1 -->
        <div class="col-md-4">
            <div class="card h-100 event-card">
                <img src="https://via.placeholder.com/400x200?text=Poster+Event+1" class="card-img-top" alt="Event 1 Poster" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title">Geology Workshop 2023</h5>
                    <p class="card-text">Join our interactive workshop on modern geology techniques.</p>
                    <div class="event-details mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-calendar-alt me-2" style="color: var(--mg-yellow);"></i>
                            <span>15 Dec 2023</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-clock me-2" style="color: var(--mg-yellow);"></i>
                            <span>10:00 AM</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-ticket-alt me-2" style="color: var(--mg-yellow);"></i>
                            <span>Rp 50.000</span>
                        </div>
                    </div>
                    <a href="#" class="btn btn-event-yellow w-100">Get Ticket</a>
                </div>
            </div>
        </div>
        <!-- Event 2 -->
        <div class="col-md-4">
            <div class="card h-100 event-card">
                <img src="https://via.placeholder.com/400x200?text=Poster+Event+2" class="card-img-top" alt="Event 2 Poster" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title">Fossil Exhibition</h5>
                    <p class="card-text">Explore ancient fossils from around the world.</p>
                    <div class="event-details mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-calendar-alt me-2" style="color: var(--mg-yellow);"></i>
                            <span>20 Jan 2024</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-clock me-2" style="color: var(--mg-yellow);"></i>
                            <span>09:00 AM</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-ticket-alt me-2" style="color: var(--mg-yellow);"></i>
                            <span>Rp 30.000</span>
                        </div>
                    </div>
                    <a href="#" class="btn btn-event-yellow w-100">Get Ticket</a>
                </div>
            </div>
        </div>
        <!-- Event 3 -->
        <div class="col-md-4">
            <div class="card h-100 event-card">
                <img src="https://via.placeholder.com/400x200?text=Poster+Event+3" class="card-img-top" alt="Event 3 Poster" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title">Earthquake Simulation Tour</h5>
                    <p class="card-text">Experience a simulated earthquake and learn safety measures.</p>
                    <div class="event-details mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-calendar-alt me-2" style="color: var(--mg-yellow);"></i>
                            <span>05 Feb 2024</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-clock me-2" style="color: var(--mg-yellow);"></i>
                            <span>11:00 AM</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-ticket-alt me-2" style="color: var(--mg-yellow);"></i>
                            <span>Rp 40.000</span>
                        </div>
                    </div>
                    <a href="#" class="btn btn-event-yellow w-100">Get Ticket</a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Rating & Review Section --}}
<div class="container my-5" id="rating-review">
    <div class="row">
        <div class="col-12">
            <h2 class="text-center mb-5">Rating & Review</h2>
        </div>
    </div>

    {{-- SATU KOLOM: Rate Your Experience + Write Your Review di bawahnya --}}
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-6">

            {{-- Bagian Rate Your Experience --}}
            <div class="card mb-4">
                <div class="card-body text-center">
                    <h4 class="card-title mb-4">Rate Your Experience</h4>
                    <div class="rating-section mb-4">
                        <div class="stars-container" id="starsContainer">
                            <i class="fas fa-star" data-rating="1" style="cursor: pointer; font-size: 2.5rem; margin: 0 0.5rem; color: #ddd; transition: color 0.3s;"></i>
                            <i class="fas fa-star" data-rating="2" style="cursor: pointer; font-size: 2.5rem; margin: 0 0.5rem; color: #ddd; transition: color 0.3s;"></i>
                            <i class="fas fa-star" data-rating="3" style="cursor: pointer; font-size: 2.5rem; margin: 0 0.5rem; color: #ddd; transition: color 0.3s;"></i>
                            <i class="fas fa-star" data-rating="4" style="cursor: pointer; font-size: 2.5rem; margin: 0 0.5rem; color: #ddd; transition: color 0.3s;"></i>
                            <i class="fas fa-star" data-rating="5" style="cursor: pointer; font-size: 2.5rem; margin: 0 0.5rem; color: #ddd; transition: color 0.3s;"></i>
                        </div>
                        {{-- Text default dihapus, diganti jadi kosong atau langsung menampilkan rating saat dipilih --}}
                        <p class="mt-3" id="ratingText" style="font-size: 1.2rem; font-weight: 600; color: var(--mg-black); min-height: 1.5em;">
                            &nbsp;
                        </p>
                    </div>
                    <input type="hidden" id="selectedRating" value="0">
                </div>
            </div>

            {{-- Bagian Write Your Review (dipindah ke bawah) --}}
            <div class="card mb-5">
                <div class="card-body">
                    <h4 class="card-title mb-4 text-center">Write Your Review</h4>
                    <form id="reviewForm">
                        <div class="mb-3">
                            <label for="reviewName" class="form-label">Your Name</label>
                            <input type="text" class="form-control" id="reviewName" placeholder="Enter your name" required>
                        </div>
                        <div class="mb-3">
                            <label for="reviewEmail" class="form-label">Your Email</label>
                            <input type="email" class="form-control" id="reviewEmail" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-3">
                            <label for="reviewText" class="form-label">Your Review</label>
                            <textarea class="form-control" id="reviewText" rows="5" placeholder="Share your experience with us..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-review-yellow w-100">Submit Review</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Display Section -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class=" text-center mb-4">Customer Reviews</h3>
            <div id="reviewsList" class="row g-4">
                <!-- Reviews akan ditampilkan di sini -->
                <div class="col-12 text-center text-muted">
                    <p>No reviews yet. Be the first to review!</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
    body {
        background: #fff;
    }

    /* Service Button Yellow Styling */
    .btn-service-yellow {
        background: var(--mg-yellow) !important;
        color: var(--mg-black) !important;
        border: 2px solid var(--mg-yellow) !important;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-service-yellow:hover {
        background: var(--mg-black) !important;
        color: var(--mg-yellow) !important;
        border-color: var(--mg-black) !important;
    }

    /* Event Button Yellow Styling */
    .btn-event-yellow {
        background: var(--mg-yellow) !important;
        color: var(--mg-black) !important;
        border: 2px solid var(--mg-yellow) !important;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-event-yellow:hover {
        background: var(--mg-black) !important;
        color: var(--mg-yellow) !important;
        border-color: var(--mg-black) !important;
    }

    /* Service Card Styling */
    .service-card {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .service-card .card-body {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .service-card .service-icon {
        flex-shrink: 0;
    }

    .service-card p {
        flex-grow: 1;
    }

    .service-card .btn {
        margin-top: auto;
    }

    /* Event Card Styling */
    .event-card {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .event-card .card-img-top {
        height: 200px;
        object-fit: cover;
    }

    .event-card .card-body {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .event-card .card-text {
        flex-grow: 1;
    }

    .event-card .btn {
        margin-top: auto;
    }

    .knowledge-test {
        background: #f8f9fa;
    }

    .test-progress {
        text-align: center;
        padding: 20px 0;
    }

    .progress-ring {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 10px solid #e9ecef;
        border-top-color: #0d6efd;
        margin: 0 auto 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        font-weight: bold;
    }

    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
    }

    .gallery-item img {
        width: 100%;
        height: 80px;
        object-fit: cover;
        border-radius: 4px;
    }

    .timeline {
        position: relative;
        padding: 20px 0;
    }

    .timeline-item {
        display: flex;
        align-items: center;
        margin-bottom: 30px;
    }

    .timeline-image {
        width: 100px;
        height: 100px;
        flex-shrink: 0;
        margin-right: 20px;
    }

    .timeline-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    .timeline-content {
        flex-grow: 1;
    }

    .audio-guide {
        padding: 20px;
    }

    .chapter-list {
        margin-top: 30px;
    }

    .chapter-item {
        display: flex;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .chapter-number {
        width: 30px;
        height: 30px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
    }

    .chapter-info small {
        color: #6c757d;
    }

    .chapter-info p {
        margin: 0;
    }

    /* Pro Plan removed - styles kept if needed later */

    /* Game list styles */
    .game-item .game-icon i {
        font-size: 18px;
    }
    .game-item .game-info strong {
        display: block;
        font-size: 14px;
    }
    .game-item .game-info p {
        margin: 0;
    }
    /* Rating & Review Styles */
    .btn-review-yellow {
        background: var(--mg-yellow) !important;
        color: var(--mg-black) !important;
        border: 2px solid var(--mg-yellow) !important;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-review-yellow:hover {
        background: var(--mg-black) !important;
        color: var(--mg-yellow) !important;
        border-color: var(--mg-black) !important;
    }

    .stars-container {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
    }

    .stars-container i {
        color: #ddd;
        transition: color 0.2s ease;
    }

    .stars-container i:hover,
    .stars-container i.active,
    .stars-container i.selected {
        color: var(--mg-yellow) !important;
    }

    .review-card {
        background: #f8f9fa;
        border-left: 4px solid var(--mg-yellow);
        border-radius: 0.5rem;
        padding: 1rem;
    }

    .review-rating {
        color: var(--mg-yellow);
        font-size: 0.95rem;
        margin-bottom: 0.5rem;
    }

    .review-author {
        font-weight: 600;
        color: var(--mg-black);
    }

    .review-email {
        color: var(--mg-muted);
        font-size: 0.9rem;
    }

    /* Modal specific tweaks */
    .modal-content.bg-dark {
        background: #222 !important;
    }
    .game-placeholder p { margin-bottom: 8px; }

    /* Sidebar collapse styles */
    #miniGamesBar {
        transition: transform 0.28s ease, opacity 0.28s ease;
        transform: translateX(0);
        opacity: 1;
    }
    #miniGamesBar.collapsed {
        transform: translateX(110%);
        opacity: 0;
        pointer-events: none;
    }

    /* When sidebar collapsed, show a small reopen button (handled by JS) */
    @media (max-width: 991px) {
        /* On small screens, let the reopen button be visible near top-right */
        #miniGamesReopen { top: 120px; }
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