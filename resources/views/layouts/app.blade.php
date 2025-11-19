<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gesit - Museum Geologi</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root{
            --mg-yellow: #FFD400; /* primary yellow */
            --mg-black: #0b0b0b;  /* primary black */
            --mg-white: #ffffff;  /* white */
            --mg-muted: #6c6c6c;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); /* Gradient dinamis untuk background */
            color: var(--mg-black);
            margin-top: 120px;  /* Ruang untuk navbar fixed */
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
            background: transparent; /* Biarkan transparan agar gradient body terlihat */
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(135deg, var(--mg-yellow) 0%, #f7c600 100%) !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            padding: 0.5rem 2rem;
            border-bottom: 3px solid var(--mg-black);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
            z-index: 1030;
        }

        .navbar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(255,255,255,0.1) 10px, rgba(255,255,255,0.1) 20px); /* Pattern garis diagonal halus */
            opacity: 0.5;
            pointer-events: none;
        }

        .navbar-brand {
            font-weight: bold;
            color: var(--mg-black) !important;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-right: auto;
        }

        .navbar-nav {
            gap: 0.2rem;
        }

        /* GESIT Text Style */
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
        }

        .nav-link {
            color: var(--mg-black) !important;
            font-weight: 700;
            margin: 0 0.3rem;
            transition: background-color 0.3s, color 0.3s, border-radius 0.3s, transform 0.3s;
            font-size: 1.15rem;
            padding: 0.6rem 1.2rem !important;
            border-radius: 25px;
            position: relative; /* Untuk efek hover */
        }

        .nav-link:hover {
            background: var(--mg-black) !important;
            color: var(--mg-yellow) !important;
            border-radius: 25px;
            transform: translateY(-2px); /* Efek angkat saat hover */
            box-shadow: 0 4px 8px rgba(0,0,0,0.2); /* Shadow saat hover */
        }
        
        .nav-link i {
            font-size: 1.5rem;
        }

        .navbar-nav .active {
            color: var(--mg-black) !important;
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

        /* Dark backgrounds used for sidebars/cards -> make them black */
        .bg-dark {
            background: var(--mg-black) !important;
            color: var(--mg-white) !important;
        }

        /* Cards default to white with subtle border */
        .card {
            background: var(--mg-white) !important;
            border: 1px solid rgba(0,0,0,0.06);
        }

        a { color: var(--mg-black); }
        a:hover { color: #b88600; }

        .text-muted { color: var(--mg-muted) !important; }

        /* Responsif adjustments */
        @media (max-width: 992px) {
            /* Tablet dan bawah */
            .navbar {
                padding: 0.5rem 1rem;
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
            /* Mobile */
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

            /* Navbar toggler styling */
            .navbar-toggler {
                padding: 0.25rem 0.5rem;
                border: none;
            }

            .navbar-toggler:focus {
                box-shadow: none;
            }
        }

        @media (max-width: 576px) {
            /* Extra small devices */
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
                <span class="brand-text">Geologi Visit</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/#banner">News</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/#events">Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/#rating-review">Rating & Review</a>
                    </li>
                    <li class="nav-item ms-2">
                        <a href="javascript:void(0)" id="language-toggle" class="nav-link p-0 border-0" title="Ganti Bahasa">
                            <img id="lang-flag" src="{{ asset('images/flags/id.svg') }}" alt="ID" style="width: 38px; height: 38px; border-radius: 50%; box-shadow: 0 2px 8px rgba(0,0,0,0.2); transition: all 0.3s;">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/login"><i class="fas fa-user"></i></a>
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
                        "nb_sides": 6 // Hexagon for crystal-like shapes
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
                    "speed": 3, // Slow movement for natural feel
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
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const langToggle = document.getElementById('language-toggle');
        const langFlag = document.getElementById('lang-flag');
        
        // Cek bahasa yang tersimpan di localStorage
        const savedLang = localStorage.getItem('language') || 'en'; // default English
        
        // Set awal sesuai yang tersimpan
        setLanguage(savedLang);

        // Event klik untuk toggle
        langToggle.addEventListener('click', function () {
            const newLang = (savedLang === 'en') ? 'id' : 'en';
            localStorage.setItem('language', newLang);
            setLanguage(newLang);
            
            // Refresh halaman agar translation Laravel di-load ulang (jika pakai @lang)
            location.reload();
        });

        function setLanguage(lang) {
            if (lang === 'id') {
                langFlag.src = "{{ asset('images/id.svg') }}";
                langFlag.alt = "ID";
                document.documentElement.lang = 'id';
                langToggle.title = "Switch to English";
            } else {
                langFlag.src = "{{ asset('images/en.svg') }}";
                langFlag.alt = "EN";
                document.documentElement.lang = 'en';
                langToggle.title = "Ganti ke Bahasa Indonesia";
            }
        }
    });
    </script>
    @yield('scripts')
</body>
</html>