<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gesit - Museum Geologi</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root{
            --mg-yellow: #FFD400;
            --mg-black: #0b0b0b;
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
            background: rgba(255, 212, 0, 0.95) !important;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            padding: 0.75rem 2rem;
            border-bottom: 3px solid var(--mg-black);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
            z-index: 1030;
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            padding: 0.5rem 2rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }

        .navbar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(255,255,255,0.1) 10px, rgba(255,255,255,0.1) 20px);
            opacity: 0.5;
            pointer-events: none;
        }

        .navbar-brand {
            font-weight: bold;
            color: var(--mg-black) !important;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-right: auto;
            transition: transform 0.3s ease;
        }

        .navbar-brand:hover {
            transform: scale(1.05);
        }

        .navbar-brand img {
            transition: transform 0.5s ease, filter 0.3s ease;
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2));
        }

        .navbar-brand:hover img {
            transform: rotate(360deg);
            filter: drop-shadow(0 6px 12px rgba(0,0,0,0.3));
        }

        .brand-text {
            font-family: 'Futura PT', 'Century Gothic', sans-serif;
            font-size: 2rem;
            font-weight: 900;
            letter-spacing: 0.10em;
            color: var(--mg-black);
            text-shadow: 
                2px 2px 0px rgba(11, 11, 11, 0.3),
                4px 4px 0px rgba(11, 11, 11, 0.2),
                6px 6px 12px rgba(0, 0, 0, 0.15);
            transform: perspective(600px) rotateX(-5deg);
            transition: all 0.3s ease;
        }

        .navbar-brand:hover .brand-text {
            text-shadow: 
                3px 3px 0px rgba(11, 11, 11, 0.4),
                6px 6px 0px rgba(11, 11, 11, 0.3),
                9px 9px 15px rgba(0, 0, 0, 0.2);
        }

        .navbar-nav {
            gap: 0.3rem;
        }

        .nav-link {
            color: var(--mg-black) !important;
            font-weight: 700;
            margin: 0 0.3rem;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            font-size: 1.15rem;
            padding: 0.6rem 1.2rem !important;
            border-radius: 30px;
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 3px;
            background: var(--mg-black);
            transition: all 0.4s ease;
            transform: translateX(-50%);
        }

        .nav-link:hover::before {
            width: 80%;
        }

        .nav-link:hover {
            background: var(--mg-black) !important;
            color: var(--mg-yellow) !important;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }

        .nav-link.active {
            background: rgba(11, 11, 11, 0.1);
            border-bottom: 3px solid var(--mg-black);
        }

        .language-toggle-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        #language-toggle {
            background: var(--mg-black);
            border-radius: 50%;
            padding: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.4s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            position: relative;
            overflow: hidden;
        }

        #language-toggle::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle, rgba(255,212,0,0.3) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        #language-toggle:hover::before {
            opacity: 1;
        }

        #language-toggle:hover {
            transform: scale(1.15) rotate(360deg);
            box-shadow: 0 6px 20px rgba(255,212,0,0.5);
        }

        #lang-flag {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--mg-yellow);
            transition: all 0.3s ease;
        }

        .admin-button-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--mg-black);
            padding: 8px 16px;
            border-radius: 30px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .admin-button-wrapper:hover {
            background: linear-gradient(135deg, var(--mg-black) 0%, #2c2c2c 100%);
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        }

        .admin-text {
            color: var(--mg-yellow);
            font-weight: 700;
            font-size: 1rem;
            margin: 0;
            transition: all 0.3s ease;
        }

        .admin-button-wrapper:hover .admin-text {
            letter-spacing: 1px;
        }

        .admin-icon {
            color: var(--mg-yellow);
            font-size: 1.5rem;
            transition: all 0.3s ease;
        }

        .admin-button-wrapper:hover .admin-icon {
            transform: rotate(360deg);
        }

        .navbar-toggler {
            border: 2px solid var(--mg-black);
            padding: 0.4rem 0.6rem;
            transition: all 0.3s ease;
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        .navbar-toggler:hover {
            background: var(--mg-black);
            transform: scale(1.1);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(11, 11, 11, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .navbar-toggler:hover .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 212, 0, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
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
            background: var(--mg-black) !important;
            border-color: var(--mg-black) !important;
            color: var(--mg-white) !important;
        }

        .btn-outline-light {
            color: var(--mg-black) !important;
            border-color: var(--mg-black) !important;
            background: transparent !important;
        }

        .bg-dark {
            background: var(--mg-black) !important;
            color: var(--mg-white) !important;
        }

        .card {
            background: var(--mg-white) !important;
            border: 1px solid rgba(0,0,0,0.06);
        }

        a { color: var(--mg-black); }
        a:hover { color: #b88600; }

        .text-muted { color: var(--mg-muted) !important; }

        /* Responsive */
        @media (max-width: 992px) {
            .navbar {
                padding: 0.6rem 1rem;
            }

            .navbar-brand {
                gap: 6px;
            }

            .brand-text {
                font-size: 1.5rem;
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
                padding: 0.5rem 0.75rem;
            }

            .navbar-brand {
                gap: 4px;
            }

            .brand-text {
                font-size: 1.2rem;
                letter-spacing: 0.05em;
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
                padding: 0.4rem 0.5rem;
            }

            .navbar-brand {
                gap: 3px;
            }

            .brand-text {
                font-size: 1rem;
                letter-spacing: 0.03em;
            }

            .nav-link {
                font-size: 0.9rem;
                padding: 0.4rem 0.75rem !important;
            }

            .nav-link i {
                font-size: 1rem;
            }

            body {
                margin-top: 75px;
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
                <img src="{{ asset('images/logo-mg.png') }}" alt="Museum Geologi" style="height:90px;">
                <span class="brand-text">Geology Visit</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
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
                        <a class="nav-link" href="{{ route('tickets.reschedule.form') }}">
                            Reschedule
                        </a>
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
                    <li class="nav-item ms-lg-2">
                        <a href="/admin/login" class="admin-button-wrapper text-decoration-none">
                            <span class="admin-text" data-lang-key="nav_admin">Admin</span>
                            <i class="fas fa-user admin-icon"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

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
                    "speed": 3,
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

            // Smooth scroll for nav links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const href = this.getAttribute('href');
                    const targetId = href.replace(/^\//, '');
                    const target = document.querySelector(targetId);
                    
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                        
                        // Close mobile menu after click
                        const navbarCollapse = document.getElementById('navbarNav');
                        if (navbarCollapse && navbarCollapse.classList.contains('show')) {
                            const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
                            if (bsCollapse) {
                                bsCollapse.hide();
                            }
                        }
                    }
                });
            });
        });
    </script>

    @yield('scripts')
</body>
</html>