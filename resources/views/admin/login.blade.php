<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Gesit - Museum Geologi</title>
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
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); /* Gradient dinamis untuk background selaras dengan visitor */
            color: var(--mg-black);
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

        .card {
            background: var(--mg-white) !important;
            border: 1px solid rgba(0,0,0,0.06);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            border-radius: 8px;
        }

        .card-body {
            padding: 3rem !important;
        }

        .card-title {
            font-size: 1.8rem;
            font-weight: 700;
        }

        /* Brand Text Style selaras dengan visitor */
        .brand-text {
            font-family: 'Futura PT', 'Century Gothic', sans-serif;
            font-size: 3.5rem;
            font-weight: 900;
            letter-spacing: 0.10em;
            color: var(--mg-black);
            text-shadow: 
                2px 2px 0px rgba(11, 11, 11, 0.3),
                4px 4px 0px rgba(11, 11, 11, 0.2),
                6px 6px 12px rgba(0, 0, 0, 0.15);
            transform: perspective(600px) rotateX(-5deg);
        }

        /* Button Styling selaras dengan btn-service-yellow di visitor */
        .btn-login {
            background: var(--mg-yellow) !important;
            color: var(--mg-black) !important;
            border: 2px solid var(--mg-yellow) !important;
            font-weight: 700;
            transition: all 0.3s ease;
            border-radius: 25px;
            font-size: 1.1rem;
            padding: 0.75rem 2rem;
            height: auto;
        }

        .btn-login:hover {
            background: var(--mg-black) !important;
            color: var(--mg-yellow) !important;
            border-color: var(--mg-black) !important;
            transform: translateY(-2px); /* Efek hover selaras */
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        /* Form labels and inputs */
        .form-label {
            color: var(--mg-black);
            font-weight: 600;
            font-size: 1.05rem;
        }

        .form-control {
            border-color: rgba(0,0,0,0.1);
            transition: border-color 0.3s;
            font-size: 1.05rem;
            padding: 0.75rem 1rem;
            height: auto;
        }

        .form-control:focus {
            border-color: var(--mg-yellow);
            box-shadow: 0 0 0 0.25rem rgba(255,212,0,0.25);
        }

        .subtitle-text {
            font-size: 1.3rem;
            font-weight: 500;
            letter-spacing: 0.05em;
        }

        /* Responsif adjustments selaras dengan visitor */
        @media (max-width: 768px) {
            .brand-text {
                font-size: 2rem;
            }

            .card-body {
                padding: 2rem !important;
            }
        }

        @media (max-width: 576px) {
            .brand-text {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Particle Background Container selaras dengan visitor -->
    <div id="particles-js"></div>

    <div class="container">
        <div class="row justify-content-center min-vh-100 align-items-center">
            <div class="col-md-6 col-lg-4">
                <div class="text-center mb-4">
                    <img src="{{ asset('images/logo-mg.png') }}" alt="Museum Geologi" style="height: 140px; margin-bottom: 1.5rem;">
                    <h2 class="brand-text">GESIT</h2>
                    <p class="text-muted subtitle-text">Museum Geologi Bandung</p>
                </div>
                <div class="card shadow">
                    <div class="card-body p-4">
                        <h4 class="card-title mb-4 text-center">Login Admin</h4>
                        
                        @if($errors->any())
                        <div class="alert alert-danger mb-4">
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
                    "color": "#6c6c6c",
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
</body>
</html>