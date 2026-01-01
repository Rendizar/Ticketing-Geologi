<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - GESIT - Geology Visit</title>
    <!-- Google Fonts - Montserrat -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root{
            --primary-color: #3B82F6; /* primary yellow */
            --primary-color: #1F2933;  /* primary black */
            --bg-white: #ffffff;  /* white */
            --mg-muted: #6c6c6c;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            color: var(--primary-color);
            position: relative;
            min-height: 100vh;
            padding: env(safe-area-inset-top, 0) env(safe-area-inset-right, 0) env(safe-area-inset-bottom, 0) env(safe-area-inset-left, 0);
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

        .card {
            background: var(--bg-white) !important;
            border: 2px solid rgba(0, 0, 0, 0.08);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border-radius: 1.25rem;
        }

        .card-body { 
            padding: 3rem !important; 
        }

        .card-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-color);
            letter-spacing: 0.02em;
        }

        /* Brand Text Style - exact match with landing page */
        .brand-text {
            font-size: clamp(2.5rem, 7vw, 5rem);
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

        .brand-logo {
            height: 140px;
        }

        /* Button Styling selaras dengan btn-service-yellow di visitor */
        .btn-login {
            background: var(--primary-color) !important;
            color: #ffffff !important;
            border: 2px solid var(--primary-color) !important;
            font-weight: 700;
            transition: all 0.3s ease;
            border-radius: 25px;
            font-size: 1.1rem;
            padding: 0.75rem 2rem;
            height: auto;
        }

        .btn-login:hover {
            background: #FACC15 !important;
            color: var(--primary-color) !important;
            border-color: #FACC15 !important;
            transform: translateY(-2px); /* Efek hover selaras */
            box-shadow: 0 4px 8px rgba(250, 204, 21, 0.4);
        }

        /* Back button */
        .btn-back {
            position: fixed;
            top: 2rem;
            left: 2rem;
            background: rgba(255, 255, 255, 0.95) !important;
            color: var(--primary-color) !important;
            border: 2px solid var(--primary-color) !important;
            font-weight: 600;
            transition: all 0.3s ease;
            border-radius: 50px;
            font-size: 0.95rem;
            padding: 0.6rem 1.5rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            backdrop-filter: blur(10px);
        }

        .btn-back:hover {
            background: #FACC15 !important;
            color: var(--primary-color) !important;
            border-color: #FACC15 !important;
            transform: translateX(-5px);
            box-shadow: 0 6px 16px rgba(250, 204, 21, 0.4);
        }
        
        .btn-back i {
            font-size: 1.1rem;
            transition: transform 0.3s ease;
        }
        
        .btn-back:hover i {
            transform: translateX(-3px);
        }

        /* Form labels and inputs */
        .form-label {
            color: var(--primary-color);
            font-weight: 600;
            font-size: 1.05rem;
        }

        .form-control {
            border: 2px solid rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            font-size: 1.05rem;
            padding: 0.75rem 1rem;
            height: auto;
            border-radius: 0.5rem;
        }

        .form-control:focus {
            border-color: #FACC15;
            box-shadow: 0 0 0 0.25rem rgba(250, 204, 21, 0.25);
            outline: none;
        }

        .subtitle-text {
            color: #2c3e50 !important;
            font-weight: 700;
            font-size: clamp(1rem, 2.5vw, 1.8rem) !important;
            text-shadow: 0 1px 3px rgba(255,255,255,0.8);
            letter-spacing: 3px;
        }

        /* Layout wrapper for better mobile scroll behavior */
        .login-wrapper { min-height: 100vh; }
        @supports (height: 100dvh) {
            .login-wrapper { min-height: 100dvh; }
        }

        /* Responsif adjustments */
        @media (max-width: 768px) {
            .card-body { padding: 2rem !important; }
            .btn-login { font-size: 1rem; padding: 0.65rem 1.5rem; border-radius: 22px; }
            .btn-back { 
                top: 1.5rem; 
                left: 1.5rem;
                font-size: 0.9rem; 
                padding: 0.55rem 1.2rem; 
            }
            .form-control { font-size: 1rem; padding: 0.7rem 0.9rem; }
            .form-label { font-size: 1rem; }
            .brand-logo { height: 100px; }
        }

        @media (max-width: 576px) {
            body { padding-bottom: 2.5rem; }
            .card-body { padding: 1.5rem !important; }
            .brand-logo { height: 80px; }
            .btn-login { font-size: 0.95rem; padding: 0.6rem 1.2rem; border-radius: 20px; }
            .btn-back { 
                top: 1rem; 
                left: 1rem;
                font-size: 0.85rem; 
                padding: 0.5rem 1rem;
                border-radius: 40px;
            }
            .btn-back span {
                display: none;
            }
            .btn-back i {
                font-size: 1.2rem;
                margin: 0;
            }
            .form-control { font-size: 0.95rem; padding: 0.6rem 0.85rem; }
            .form-label { font-size: 0.95rem; }
            .container { padding-left: 1rem; padding-right: 1rem; }
        }
    </style>
</head>
<body>
    <!-- Particle Background Container selaras dengan visitor -->
    <div id="particles-js"></div>

    <!-- Back Button - Fixed Position -->
    <a href="{{ url('/') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i>
        <span>Kembali ke Beranda</span>
    </a>

    <div class="container">
        <div class="row justify-content-center login-wrapper align-items-start align-items-md-center py-4 py-md-0">
            <div class="col-12 col-sm-10 col-md-7 col-lg-4">
                <div class="text-center mb-4">
                    <img src="{{ asset('images/logo-mg.png') }}" alt="Museum Geologi" class="brand-logo" style="margin-bottom: 1.5rem;">
                    <h2 class="brand-text">GESIT</h2>
                    <p class="subtitle-text">Geology Visit</p>
                </div>
                <div class="card shadow">
                    <div class="card-body">
                        <h4 class="card-title mb-4 text-center">Login Admin</h4>
                        
                        @if($errors->any())
                        <div class="alert alert-danger mb-4 border-0 shadow-sm">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            {{ $errors->first() }}
                        </div>
                        @endif
                        
                        <form method="POST" action="{{ route('admin.login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            
                            <button type="submit" class="btn btn-login w-100">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Particles.js CDN selaras dengan visitor -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    
    <!-- Particles Config selaras dengan visitor -->
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
</body>
</html>
