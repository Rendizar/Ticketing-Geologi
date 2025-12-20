<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gesit - Museum Geologi</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{
            --mg-yellow: #FACC15;
            --mg-charcoal: #1F2933;
            --mg-warm-gray: #E5E7EB;
            --mg-stone-gray: #9CA3AF;
            --mg-off-white: #F9FAFB;
            --mg-white: #ffffff;
            --mg-muted: #6c6c6c;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            color: var(--mg-black);
            margin-top: 120px;
            position: relative;
        }

        /* Particle Background */
        #particles-js {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: transparent;
        }

        /* Enhanced Navbar with Glass Effect */
        .navbar {
            background: transparent !important;
            backdrop-filter: none;
            -webkit-backdrop-filter: none;
            box-shadow: none;
            padding: 0.75rem 2rem;
            border-bottom: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
            z-index: 1030;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif !important;
        }

        .navbar.scrolled {
            padding: 0.5rem 2rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .navbar-brand {
            font-weight: bold;
            color: var(--mg-charcoal) !important;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-right: auto;
        }

        .navbar-brand img {
            transition: filter 0.3s ease;
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2));
        }

        .navbar-logo {
            height: clamp(40px, 10vw, 90px);
            flex-shrink: 0;
            max-width: 100%;
        }

        .brand-text {
            font-family: 'Inter', sans-serif !important;
            font-size: clamp(0.75rem, 2.5vw, 2rem);
            font-weight: 600;
            letter-spacing: 0.02em;
            color: var(--mg-charcoal);
            text-shadow: 0 1px 1px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            flex-shrink: 1;
            min-width: 0;
        }

        .brand-text:hover {
            text-shadow: 0 2px 2px rgba(0,0,0,0.3);
        }

        .navbar-nav {
            gap: 0.3rem;
        }

        .nav-link {
            color: var(--mg-charcoal) !important;
            font-weight: 600;
            margin: 0 0.3rem;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            font-size: 1.15rem;
            padding: 0.6rem 1.2rem !important;
            border-radius: 30px;
            position: relative;
            overflow: hidden;
            font-family: 'Inter', sans-serif !important;
            letter-spacing: 0.4px;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 3px;
            background: var(--mg-yellow);
            transition: all 0.4s ease;
            transform: translateX(-50%);
        }

        .nav-link:hover::before {
            width: 80%;
        }

        .nav-link:hover {
            background: var(--mg-yellow) !important;
            color: var(--mg-charcoal) !important;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(250, 204, 21, 0.3);
        }

        .nav-link.active {
            background: rgba(250, 204, 21, 0.1);
            color: var(--mg-yellow) !important;
            border-bottom: 3px solid var(--mg-yellow);
        }

        .language-toggle-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        #language-toggle {
            background: var(--mg-charcoal);
            border-radius: 50%;
            padding: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.4s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }

        #language-toggle::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle, rgba(250,204,21,0.3) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        #language-toggle:hover::before {
            opacity: 1;
        }

        #language-toggle:hover {
            transform: scale(1.15);
            box-shadow: 0 6px 20px rgba(250,204,21,0.4);
        }

        #lang-flag {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: none;
            transition: all 0.3s ease;
        }

        .admin-button-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--mg-charcoal);
            padding: 8px 16px;
            border-radius: 30px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .admin-button-wrapper:hover {
            background: var(--mg-yellow);
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 8px 25px rgba(250,204,21,0.3);
        }

        .admin-text {
            color: var(--mg-white);
            font-weight: 700;
            font-size: 1rem;
            margin: 0;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif !important;
        }

        .admin-button-wrapper:hover .admin-text {
            letter-spacing: 1px;
            color: var(--mg-charcoal);
        }

        .admin-icon {
            color: var(--mg-white);
            font-size: 1.5rem;
            transition: all 0.3s ease;
        }

        .admin-button-wrapper:hover .admin-icon {
            transform: scale(1.1);
            color: var(--mg-charcoal);
        }

        .navbar-toggler {
            border: 2px solid var(--mg-charcoal);
            padding: 0.4rem 0.6rem;
            transition: all 0.3s ease;
            flex-shrink: 0;
            margin-left: auto;
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        .navbar-toggler:hover {
            background: var(--mg-charcoal);
            transform: scale(1.1);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(31, 41, 51, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .navbar-toggler:hover .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(250, 204, 21, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .lang-switching {
            animation: rotateSwitch 0.5s ease;
        }

        @keyframes rotateSwitch {
            0% { transform: rotate(0deg) scale(1); }
            50% { transform: rotate(180deg) scale(1.2); }
            100% { transform: rotate(360deg) scale(1); }
        }

        /* Buttons */
        .btn-primary {
            background: var(--mg-charcoal) !important;
            border-color: var(--mg-charcoal) !important;
            color: var(--mg-white) !important;
        }

        .btn-outline-light {
            color: var(--mg-charcoal) !important;
            border-color: var(--mg-charcoal) !important;
            background: transparent !important;
        }

        .bg-dark {
            background: var(--mg-charcoal) !important;
            color: var(--mg-white) !important;
        }

        .card {
            background: var(--mg-white) !important;
            border: 1px solid rgba(0,0,0,0.06);
        }

        a { color: var(--mg-charcoal); }
        a:hover { color: var(--mg-yellow); }

        .text-muted { color: var(--mg-muted) !important; }
        
        /* Navbar on Dark Background */
        .navbar.on-dark .navbar-brand,
        .navbar.on-dark .brand-text,
        .navbar.on-dark .nav-link {
            color: #ffffff !important;
        }
        
        .navbar.on-dark .navbar-logo {
            filter: brightness(0) invert(1) drop-shadow(0 4px 8px rgba(255,255,255,0.3));
        }
        
        .navbar.on-dark .nav-link:hover {
            background: var(--mg-yellow) !important;
            color: var(--mg-charcoal) !important;
        }
        
        .navbar.on-dark .nav-link::before {
            background: #ffffff;
        }
        
        .navbar.on-dark .navbar-toggler {
            border-color: #ffffff;
        }
        
        .navbar.on-dark .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* Responsive */
        @media (max-width: 992px) {
            .navbar {
                padding: 0.5rem 0.75rem;
            }

            .navbar-brand {
                gap: 5px;
                max-width: 75%;
            }

            .nav-link {
                font-size: 1rem;
                margin: 0.2rem 0;
                padding: 0.5rem 1rem !important;
            }

            .nav-link i {
                font-size: 1.2rem;
            }

            .navbar-nav {
                gap: 0.1rem;
            }

            body {
                margin-top: 100px;
            }
        }

        @media (max-width: 768px) {
            .container-fluid {
                padding-left: 0.5rem !important;
                padding-right: 0.5rem !important;
            }

            .container-fluid.px-5 {
                padding-left: 15px !important;
                padding-right: 15px !important;
            }

            .row.g-4 {
                gap: 1rem !important;
            }

            .card-img-top {
                height: 150px !important;
            }

            .display-4 {
                font-size: 2.5rem !important;
            }

            .carousel img {
                height: 250px !important;
            }

            .navbar {
                padding: 0.3rem 0.4rem;
            }

            .navbar-brand {
                gap: 3px;
                max-width: 60%;
            }

            .nav-link {
                font-size: 0.95rem;
                margin: 0.15rem 0;
                padding: 0.45rem 0.9rem !important;
            }

            .nav-link i {
                font-size: 1.1rem;
            }

            body {
                margin-top: 85px;
            }

            body {
                margin-top: 80px;
            }

            .navbar-toggler {
                padding: 0.25rem 0.5rem;
                border: none;
            }

            .navbar-nav {
                align-items: stretch !important;
            }

            .language-toggle-wrapper,
            .admin-button-wrapper {
                width: 100%;
                justify-content: center;
                margin: 0.5rem 0;
            }

            .admin-text {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 576px) {
            .navbar {
                padding: 0.25rem 0.3rem;
            }

            .navbar-brand {
                gap: 2px;
                max-width: 55%;
            }

            body {
                margin-top: 65px;
            }

            .nav-link {
                font-size: 0.9rem;
                padding: 0.4rem 0.75rem !important;
            }

            .nav-link i {
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {
            .navbar {
                padding: 0.25rem 0.3rem;
            }

            .navbar-brand {
                gap: 2px;
                max-width: 50%;
            }

            body {
                margin-top: 60px;
            }
        }

        @media (max-width: 400px) {
            .navbar {
                padding: 0.2rem 0.25rem;
            }

            .navbar-brand {
                gap: 2px;
                max-width: 48%;
            }

            body {
                margin-top: 55px;
            }
        }

        /* Hamburger Menu Button */
        .hamburger-menu {
            display: none;
            flex-direction: column;
            justify-content: space-between;
            width: 30px;
            height: 22px;
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 0;
            z-index: 1001;
            position: relative;
        }

        .hamburger-menu span {
            width: 100%;
            height: 3px;
            background: #1F2933;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        .hamburger-menu:hover span {
            background: #FACC15;
        }

        .hamburger-menu.active {
            opacity: 0;
            visibility: hidden;
        }

        /* Mobile Sidebar */
        .mobile-sidebar {
            position: fixed;
            top: 0;
            left: -320px;
            width: 300px;
            height: 100vh;
            background: #ffffff;
            box-shadow: 2px 0 20px rgba(0, 0, 0, 0.1);
            z-index: 2000;
            transition: left 0.3s ease;
            overflow-y: auto;
        }

        .mobile-sidebar.active {
            left: 0;
        }

        .sidebar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid #E5E7EB;
            background: #1F2933;
        }

        .sidebar-title {
            font-family: 'Merriweather', serif;
            font-weight: 700;
            color: #ffffff;
            margin: 0;
            font-size: 1.25rem;
        }

        .sidebar-close {
            background: transparent;
            border: none;
            color: #ffffff;
            font-size: 1.5rem;
            cursor: pointer;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
            z-index: 10;
        }

        .sidebar-close:hover {
            background: rgba(250, 204, 21, 0.2);
            color: #FACC15;
        }

        .sidebar-nav {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-nav-item {
            border-bottom: 1px solid #F3F4F6;
        }

        .sidebar-nav-link {
            display: flex;
            align-items: center;
            padding: 1rem 1.25rem;
            color: #1F2933;
            text-decoration: none;
            font-weight: 500;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .sidebar-nav-link:hover {
            background: #F9FAFB;
            color: #FACC15;
            padding-left: 1.5rem;
        }

        .sidebar-nav-link i {
            color: #FACC15;
            font-size: 1.1rem;
        }

        .sidebar-language {
            border-bottom: none;
            padding: 1rem 1.25rem;
        }

        .language-toggle-mobile {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .language-label {
            color: #1F2933;
            font-weight: 500;
            display: flex;
            align-items: center;
        }

        .language-btn {
            padding: 0.5rem;
            background: #F9FAFB;
            border: 2px solid #E5E7EB;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .language-btn:hover {
            border-color: #FACC15;
            background: #ffffff;
        }

        /* Mobile Overlay */
        .mobile-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .mobile-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Show hamburger only on mobile */
        @media (max-width: 991px) {
            .hamburger-menu {
                display: flex;
            }

            .desktop-menu {
                display: none !important;
            }
        }

        /* Hide hamburger on desktop */
        @media (min-width: 992px) {
            .hamburger-menu,
            .mobile-sidebar,
            .mobile-overlay {
                display: none !important;
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Particle Background Container -->
    <div id="particles-js"></div>

    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <img src="{{ asset('images/logo-mg.png') }}" alt="Museum Geologi" class="navbar-logo">
                <span class="brand-text">Geology Visit</span>
            </a>
            
            <!-- Hamburger Menu Button (Mobile Only) -->
            <button class="hamburger-menu" id="hamburgerBtn" type="button" aria-label="Toggle navigation">
                <span></span>
                <span></span>
                <span></span>
            </button>
            
            <!-- Desktop Menu -->
            <div class="collapse navbar-collapse desktop-menu" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link" href="/#banner" data-section="banner" data-lang-key="nav_news">News</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/#services" data-section="services" data-lang-key="nav_services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/#events" data-section="events" data-lang-key="nav_events">Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/#rating-review" data-section="rating-review" data-lang-key="nav_rating">Rating & Review</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <div class="language-toggle-wrapper">
                            <a href="javascript:void(0)" id="language-toggle" class="p-0 border-0" title="Switch Language">
                                <img id="lang-flag" src="https://flagcdn.com/w40/us.png" alt="EN">
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Mobile Sidebar Menu -->
    <div class="mobile-sidebar" id="mobileSidebar">
        <div class="sidebar-header">
            <h5 class="sidebar-title">Menu</h5>
            <button class="sidebar-close" id="sidebarClose" aria-label="Close menu">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <ul class="sidebar-nav">
            <li class="sidebar-nav-item">
                <a class="sidebar-nav-link" href="/#banner" data-section="banner" data-lang-key="nav_news">
                    <i class="fas fa-newspaper me-3"></i>News
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a class="sidebar-nav-link" href="/#services" data-section="services" data-lang-key="nav_services">
                    <i class="fas fa-concierge-bell me-3"></i>Services
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a class="sidebar-nav-link" href="/#events" data-section="events" data-lang-key="nav_events">
                    <i class="fas fa-calendar-alt me-3"></i>Events
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a class="sidebar-nav-link" href="/#rating-review" data-section="rating-review" data-lang-key="nav_rating">
                    <i class="fas fa-star me-3"></i>Rating & Review
                </a>
            </li>
            <li class="sidebar-nav-item sidebar-language">
                <div class="language-toggle-mobile">
                    <span class="language-label">Language</span>
                    <a href="javascript:void(0)" id="language-toggle-mobile" class="language-btn" title="Switch Language">
                        <img id="lang-flag-mobile" src="https://flagcdn.com/w40/us.png" alt="EN" width="24">
                    </a>
                </div>
            </li>
        </ul>
    </div>

    <!-- Overlay for mobile menu -->
    <div class="mobile-overlay" id="mobileOverlay"></div>

    @yield('content')

    @include('partials.footer')

    <!-- Particles.js CDN -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Particles Config -->
    <script>
        particlesJS('particles-js', {
            "particles": {
                "number": {
                    "value": 60,
                    "density": {
                        "enable": true,
                        "value_area": 800
                    }
                },
                "color": {
                    "value": ["#FFD400", "#6c6c6c", "#0b0b0b"]
                },
                "shape": {
                    "type": "polygon",
                    "stroke": {
                        "width": 1,
                        "color": "#6c6c6c"
                    },
                    "polygon": {
                        "nb_sides": 6
                    }
                },
                "opacity": {
                    "value": 0.6,
                    "random": true,
                    "anim": {
                        "enable": false
                    }
                },
                "size": {
                    "value": 12,
                    "random": true,
                    "anim": {
                        "enable": false
                    }
                },
                "line_linked": {
                    "enable": true,
                    "distance": 150,
                    "color": "#808080",
                    "opacity": 0.4,
                    "width": 1
                },
                "move": {
                    "enable": true,
                    "speed": 1,
                    "direction": "none",
                    "out_mode": "out"
                }
            },
            "interactivity": {
                "detect_on": "canvas",
                "events": {
                    "onhover": {
                        "enable": false
                    },
                    "onclick": {
                        "enable": true,
                        "mode": "push"
                    },
                    "resize": true
                },
                "modes": {
                    "push": {
                        "particles_nb": 4
                    }
                }
            },
            "retina_detect": true
        });
    </script>

        <!-- Language Toggle Script -->
    <script src="{{ asset('js/lang.js') }}"></script>
    
    <!-- Navbar Dynamic Color Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.querySelector('.navbar');
            const darkSections = ['services', 'rating-review'];
            
            function updateNavbarColor() {
                const scrollPosition = window.scrollY + 100; // offset for navbar height
                let isOnDarkSection = false;
                
                darkSections.forEach(sectionId => {
                    const section = document.getElementById(sectionId);
                    if (section) {
                        const rect = section.getBoundingClientRect();
                        const sectionTop = rect.top + window.scrollY;
                        const sectionBottom = sectionTop + rect.height;
                        
                        if (scrollPosition >= sectionTop && scrollPosition <= sectionBottom) {
                            isOnDarkSection = true;
                        }
                    }
                });
                
                if (isOnDarkSection) {
                    navbar.classList.add('on-dark');
                } else {
                    navbar.classList.remove('on-dark');
                }
            }
            
            // Run on scroll
            window.addEventListener('scroll', updateNavbarColor);
            // Run on load
            updateNavbarColor();
        });

        // Mobile Menu Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const hamburgerBtn = document.getElementById('hamburgerBtn');
            const mobileSidebar = document.getElementById('mobileSidebar');
            const mobileOverlay = document.getElementById('mobileOverlay');
            const sidebarClose = document.getElementById('sidebarClose');
            const sidebarLinks = document.querySelectorAll('.sidebar-nav-link');

            // Open sidebar
            if (hamburgerBtn) {
                hamburgerBtn.addEventListener('click', function() {
                    mobileSidebar.classList.add('active');
                    mobileOverlay.classList.add('active');
                    hamburgerBtn.classList.add('active');
                    document.body.style.overflow = 'hidden';
                });
            }

            // Close sidebar function
            function closeSidebar() {
                mobileSidebar.classList.remove('active');
                mobileOverlay.classList.remove('active');
                hamburgerBtn.classList.remove('active');
                document.body.style.overflow = '';
            }

            // Close on close button click
            if (sidebarClose) {
                sidebarClose.addEventListener('click', closeSidebar);
            }

            // Close on overlay click
            if (mobileOverlay) {
                mobileOverlay.addEventListener('click', closeSidebar);
            }

            // Close on link click
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    setTimeout(closeSidebar, 300);
                });
            });

            // Close on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && mobileSidebar.classList.contains('active')) {
                    closeSidebar();
                }
            });

            // Sync language toggle between desktop and mobile
            const langToggle = document.getElementById('language-toggle');
            const langToggleMobile = document.getElementById('language-toggle-mobile');
            const langFlag = document.getElementById('lang-flag');
            const langFlagMobile = document.getElementById('lang-flag-mobile');

            if (langToggleMobile && langFlag && langFlagMobile) {
                langToggleMobile.addEventListener('click', function() {
                    // Trigger the desktop language toggle
                    if (langToggle) {
                        langToggle.click();
                    }
                    // Sync the flag immediately
                    setTimeout(() => {
                        langFlagMobile.src = langFlag.src;
                        langFlagMobile.alt = langFlag.alt;
                    }, 100);
                });
            }
        });
    </script>

    @yield('scripts')
</body>
</html>