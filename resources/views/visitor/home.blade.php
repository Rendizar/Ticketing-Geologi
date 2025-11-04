@extends('layouts.app')

@section('title', 'Welcome to Ticketing Geologi')

@section('content')
<!-- Hero Section with Carousel -->
<div class="hero-section mb-5">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('images/Museum1.jpg') }}" class="d-block w-100" alt="Geological Site 1" style="height: 400px; object-fit: cover;">
                <div class="carousel-caption">
                    <h2>Selamat Datang di Gesit!</h2>
                    <p>Your Gateway to Geological Support and Services</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/Museum2.jpg') }}" class="d-block w-100" alt="Geological Site 2" style="height: 400px; object-fit: cover;">
                <div class="carousel-caption">
                    <h2>Expert Assistance</h2>
                    <p>Get Help from Our Team of Geological Experts</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/Museum3.jpg') }}" class="d-block w-100" alt="Geological Site 3" style="height: 400px; object-fit: cover;">
                <div class="carousel-caption">
                    <h2>Quick Support</h2>
                    <p>Fast and Efficient Response to Your Queries</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
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
    .event-card {
        transition: transform 0.3s ease;
        border: none;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .event-card:hover {
        transform: translateY(-5px);
    }

    .event-details {
        font-size: 0.9rem;
    }

    .service-card {
        transition: transform 0.3s ease;
        border: none;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .service-card:hover {
        transform: translateY(-5px);
    }

    .service-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background-color: #f8f9fa;
    }

    .stat-card {
        padding: 20px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .counter {
        font-size: 2.5rem;
        font-weight: bold;
        color: #0d6efd;
    }

    .carousel-caption {
        background: rgba(0, 0, 0, 0.5);
        border-radius: 10px;
        padding: 20px;
    }

    .hero-section {
        margin-top: -1.5rem;
    }
</style>
@endsection