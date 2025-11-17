<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Museum Geologi - @yield('title')</title>
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
            background: var(--mg-white);
            color: var(--mg-black);
        }

        /* Navbar */
        .navbar {
            background: var(--mg-yellow) !important;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
            padding: 1rem 2rem;
        }

        .navbar-brand {
            font-weight: bold;
            color: var(--mg-black) !important;
        }

        .nav-link {
            color: var(--mg-black) !important;
            font-weight: 600;
            margin: 0 1rem;
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
    </style>
    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="/">MG</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="/collections">Collections</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/artists">Artists</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/events">Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contacts">Contacts</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/login"><i class="fas fa-user"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>