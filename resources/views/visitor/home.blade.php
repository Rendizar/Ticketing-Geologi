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

        <!-- Sidebar -->
        <div class="col-lg-3 py-5 bg-dark text-white">
            <div class="audio-guide">
                <h3>Mini Games Edukasi</h3>
                <p class="text-muted">Permainan singkat untuk belajar geologi</p>

                <div class="game-list">
                    {{-- Daftar game edukasi ringan untuk pengunjung --}}
                    @php
                        $games = [
                            ['id' => 1, 'title' => 'Quiz Geologi', 'desc' => 'Jawab beberapa pertanyaan singkat tentang batu dan fosil. Cocok untuk anak-anak.', 'link' => '#'],
                            ['id' => 2, 'title' => 'Puzzle Stratigrafi', 'desc' => 'Susun lapisan batu secara kronologis untuk memahami sejarah geologi.', 'link' => '#'],
                            ['id' => 3, 'title' => 'Tebak Mineral', 'desc' => 'Identifikasi mineral berdasarkan warna, kilap, dan sifat sederhana.', 'link' => '#'],
                        ];
                    @endphp

                    @foreach($games as $game)
                    <div class="game-item d-flex align-items-start mb-3">
                        <div class="game-icon me-3 bg-light text-dark rounded-circle d-flex align-items-center justify-content-center" style="width:44px;height:44px;">
                            <i class="fas fa-gamepad"></i>
                        </div>
                        <div class="game-info flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <strong>{{ $game['title'] }}</strong>
                                    <p class="mb-1 text-muted small">{{ $game['desc'] }}</p>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-sm btn-outline-light open-game-btn" data-game-id="{{ $game['id'] }}">Play</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for game -->
                    <div class="modal fade" id="gameModal{{ $game['id'] }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content bg-dark text-white">
                                <div class="modal-header border-0">
                                    <h5 class="modal-title">{{ $game['title'] }}</h5>
                                    <button type="button" class="btn-close btn-close-white close-modal" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>{{ $game['desc'] }}</p>
                                    <div class="game-placeholder p-3 bg-light text-dark rounded">
                                        <p class="mb-2"><strong>Demo:</strong></p>
                                        <p>Placeholder untuk demo game & interactive content. Anda dapat menambahkan iframe atau script permainan di sini.</p>
                                        <button class="btn btn-primary start-demo">Start Demo</button>
                                    </div>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-secondary close-modal" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="pro-plan mt-4">
                    <h5>Pro Plan</h5>
                    <p>Get full access for $5 per month</p>
                    <button class="btn btn-outline-light w-100">Subscribe</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Services Section -->
<div class="container mb-5">
    <h2 class="text-center mb-4">Our Services</h2>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 service-card">
                <div class="card-body text-center">
                    <div class="service-icon mb-3">
                        <i class="fas fa-ticket-alt fa-3x text-primary"></i>
                    </div>
                    <h4>Submit Ticket</h4>
                    <p>Create a new support ticket for your geological inquiries</p>
                    <a href="{{ route('tickets.create') }}" class="btn btn-primary">Create Ticket</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 service-card">
                <div class="card-body text-center">
                    <div class="service-icon mb-3">
                        <i class="fas fa-search fa-3x text-success"></i>
                    </div>
                    <h4>Track Status</h4>
                    <p>Check the status of your existing support tickets</p>
                    <a href="#" class="btn btn-success">Track Ticket</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 service-card">
                <div class="card-body text-center">
                    <div class="service-icon mb-3">
                        <i class="fas fa-book fa-3x text-info"></i>
                    </div>
                    <h4>Knowledge Base</h4>
                    <p>Access our geological knowledge base and resources</p>
                    <a href="#" class="btn btn-info text-white">Learn More</a>
                </div>
            </div>
        </div>
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

    .pro-plan {
        background: rgba(255,255,255,0.1);
        padding: 20px;
        border-radius: 10px;
    }

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
    });
</script>
@endsection