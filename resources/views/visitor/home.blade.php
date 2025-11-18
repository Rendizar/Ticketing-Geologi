@extends('layouts.app')

@section('title', 'Museum Geologi - Virtual Tour')

@section('content')
<div class="container-fluid px-5">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-9 py-5">
            <h1 class="display-4 mb-4">Museum Geologi</h1>
            
            <!-- Knowledge Test Section -->
            <div class="row mb-5">
                <div class="col-md-6">
                    <div class="card knowledge-test">
                        <div class="card-body">
                            <h3>Knowledge Test</h3>
                            <div class="test-progress">
                                <div class="progress-ring">
                                    <span>51%</span>
                                </div>
                                <p>12 questions</p>
                            </div>
                            <a href="#" class="btn btn-outline-dark mt-3">Start Test</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h3>Related Items</h3>
                            <div class="gallery-grid">
                                @foreach($events as $event)
                                <div class="gallery-item">
                                    <img src="{{ asset('storage/'.$event->image) }}" alt="{{ $event->title }}">
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline Section -->
            <div class="timeline-section">
                <h3 class="mb-4">Major Events <span class="badge bg-primary">NEW</span></h3>
                <div class="timeline">
                    @foreach($events as $event)
                    <div class="timeline-item">
                        <div class="timeline-image">
                            <img src="{{ asset('storage/'.$event->image) }}" alt="{{ $event->title }}">
                        </div>
                        <div class="timeline-content">
                            <h4>{{ $event->title }}</h4>
                            <p>{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</p>
                            <p>{{ Str::limit($event->description, 100) }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                <a href="#" class="btn btn-link">Virtual Tour <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>

        
<!-- Events Section -->
<div class="container mb-5">
    <h2 class="text-center mb-4">Upcoming Events</h2>
    <div class="row g-4">
        @foreach($events as $event)
        <div class="col-md-4">
            <div class="card h-100 event-card">
                <img src="{{ asset('storage/'.$event->image) }}" class="card-img-top" alt="{{ $event->title }}" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title">{{ $event->title }}</h5>
                    <p class="card-text">{{ Str::limit($event->description, 100) }}</p>
                    <div class="event-details mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-calendar-alt me-2 text-primary"></i>
                            <span>{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-clock me-2 text-primary"></i>
                            <span>{{ \Carbon\Carbon::parse($event->event_time)->format('H:i') }}</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-ticket-alt me-2 text-primary"></i>
                            <span>Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <a href="{{ route('events.show', $event->id) }}" class="btn btn-primary w-100">Get Ticket</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Quick Stats Section -->
<div class="container-fluid bg-light py-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 mb-3">
                <div class="stat-card">
                    <h3 class="counter">500+</h3>
                    <p>Tickets Resolved</p>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card">
                    <h3 class="counter">24/7</h3>
                    <p>Support Available</p>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card">
                    <h3 class="counter">50+</h3>
                    <p>Expert Geologists</p>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card">
                    <h3 class="counter">98%</h3>
                    <p>Satisfaction Rate</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Contact Section -->
<div class="container my-5">
    <div class="row">
        <div class="col-md-6">
            <h2>Need Immediate Assistance?</h2>
            <p class="lead">Our team is here to help you with any geological inquiries</p>
            <div class="d-flex align-items-center mb-3">
                <i class="fas fa-phone me-2 text-primary"></i>
                <span>+1234567890</span>
            </div>
            <div class="d-flex align-items-center mb-3">
                <i class="fas fa-envelope me-2 text-primary"></i>
                <span>support@ticketinggeologi.com</span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Quick Contact</h4>
                    <form>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Your Name">
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" placeholder="Your Email">
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" rows="3" placeholder="Your Message"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
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
    // Open modal when Play button clicked
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.open-game-btn').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                var id = btn.getAttribute('data-game-id');
                var modalEl = document.getElementById('gameModal' + id);
                if (modalEl) {
                    var modal = new bootstrap.Modal(modalEl);
                    modal.show();
                }
            });
        });

        // Example start-demo handler (placeholder)
        document.querySelectorAll('.start-demo').forEach(function(b) {
            b.addEventListener('click', function() {
                alert('Demo dimulai (placeholder). Implementasikan game atau iframe di sini.');
            });
        });
        
        // Sidebar open/close handling
        var miniBar = document.getElementById('miniGamesBar');
        var toggleBtn = document.getElementById('miniGamesToggle');
        var reopenBtn = document.getElementById('miniGamesReopen');

        function setCollapsed(collapsed) {
            if (!miniBar) return;
            if (collapsed) {
                miniBar.classList.add('collapsed');
                if (reopenBtn) reopenBtn.style.display = 'block';
                if (toggleBtn) toggleBtn.innerHTML = '<i class="fas fa-chevron-left"></i>';
            } else {
                miniBar.classList.remove('collapsed');
                if (reopenBtn) reopenBtn.style.display = 'none';
                if (toggleBtn) toggleBtn.innerHTML = '<i class="fas fa-chevron-right"></i>';
            }
        }

        if (toggleBtn) {
            toggleBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                var isCollapsed = miniBar.classList.contains('collapsed');
                setCollapsed(!isCollapsed);
            });
        }

        if (reopenBtn) {
            reopenBtn.addEventListener('click', function(e) {
                setCollapsed(false);
            });
        }

        // Initialize closed state on small screens
        if (window.innerWidth < 992) {
            setCollapsed(true);
        }
    });
</script>
@endsection