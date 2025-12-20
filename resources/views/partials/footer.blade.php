<!-- FOOTER SECTION -->
<footer class="footer-section py-5" style="background: #1F2933; color: #E5E7EB;">
    <div class="container">
        <div class="row g-4">
            <!-- About Column -->
            <div class="col-lg-4 col-md-6">
                <div class="footer-brand mb-3">
                    <img src="{{ asset('images/logo-mg.png') }}" alt="Museum Geologi" style="height: 60px; filter: brightness(0) invert(1);">
                    <h4 class="mt-3 mb-3" style="color: #ffffff; font-family: 'Inter', sans-serif; font-weight: 600;">GESIT</h4>
                </div>
                <p class="text-light opacity-75" style="font-size: 0.95rem; line-height: 1.6;">
                    Geology Visit - Your gateway to explore the fascinating world of geology at Museum Geologi Bandung. 
                    Book tickets, join events, and discover earth's wonders.
                </p>
            </div>

            <!-- Quick Links Column -->
            <div class="col-lg-2 col-md-6">
                <h5 class="mb-3 fw-bold" style="color: #FACC15; font-family: 'Inter', sans-serif;">Quick Links</h5>
                <ul class="list-unstyled footer-links">
                    <li class="mb-2"><a href="/#banner" class="text-light text-decoration-none opacity-75 hover-link">News</a></li>
                    <li class="mb-2"><a href="/#services" class="text-light text-decoration-none opacity-75 hover-link">Services</a></li>
                    <li class="mb-2"><a href="/#events" class="text-light text-decoration-none opacity-75 hover-link">Events</a></li>
                    <li class="mb-2"><a href="/#rating-review" class="text-light text-decoration-none opacity-75 hover-link">Reviews</a></li>
                </ul>
            </div>

            <!-- Services Column -->
            <div class="col-lg-3 col-md-6">
                <h5 class="mb-3 fw-bold" style="color: #FACC15; font-family: 'Inter', sans-serif;">Our Services</h5>
                <ul class="list-unstyled footer-links">
                    <li class="mb-2"><a href="{{ route('tickets.create') }}" class="text-light text-decoration-none opacity-75 hover-link">Book Tickets</a></li>
                    <li class="mb-2"><a href="{{ route('tickets.reschedule.form') }}" class="text-light text-decoration-none opacity-75 hover-link">Reschedule</a></li>
                    <li class="mb-2"><a href="{{ route('games.index') }}" class="text-light text-decoration-none opacity-75 hover-link">Mini Games</a></li>
                    <li class="mb-2"><a href="/#events" class="text-light text-decoration-none opacity-75 hover-link">Event Booking</a></li>
                </ul>
            </div>

            <!-- Contact Column -->
            <div class="col-lg-3 col-md-6">
                <h5 class="mb-3 fw-bold" style="color: #FACC15; font-family: 'Inter', sans-serif;">Contact Us</h5>
                <ul class="list-unstyled text-light opacity-75" style="font-size: 0.95rem;">
                    <li class="mb-2">
                        <i class="fas fa-map-marker-alt me-2" style="color: #FACC15;"></i>
                        Jl. Diponegoro No.57, Bandung
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-phone me-2" style="color: #FACC15;"></i>
                        (022) 7200000
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-envelope me-2" style="color: #FACC15;"></i>
                        info@museumgeologi.go.id
                    </li>
                </ul>
                <!-- Social Media -->
                <div class="mt-3">
                    <a href="#" class="social-icon me-2"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon me-2"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon me-2"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="row mt-4 pt-4" style="border-top: 1px solid rgba(229, 231, 235, 0.2);">
            <div class="col-md-6 text-center text-md-start">
                <p class="mb-0 text-light opacity-75" style="font-size: 0.9rem;">
                    &copy; 2025 GESIT - Museum Geologi Bandung. All rights reserved.
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <p class="mb-0 text-light opacity-75" style="font-size: 0.9rem;">
                    Made with <i class="fas fa-heart" style="color: #FACC15;"></i> by Capstone Team
                </p>
            </div>
        </div>
    </div>
</footer>

<style>
    /* Footer Styles */
    .footer-section {
        font-family: 'Inter', sans-serif;
    }
    
    .footer-links a.hover-link:hover {
        color: #FACC15 !important;
        opacity: 1 !important;
        padding-left: 5px;
        transition: all 0.3s ease;
    }
    
    .social-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background: rgba(250, 204, 21, 0.1);
        border-radius: 50%;
        color: #FACC15;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .social-icon:hover {
        background: #FACC15;
        color: #1F2933;
        transform: translateY(-3px);
    }
</style>
