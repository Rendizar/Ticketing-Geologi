<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin GESIT - @yield('title')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Admin CSS -->
    <style>
        :root{
            --mg-yellow: #FFD400;
            --mg-black: #0b0b0b;
            --mg-white: #ffffff;
            --mg-muted: #6c6c6c;
        }

        .sidebar {
            min-height: 100vh;
            background-color: var(--mg-black);
            color: var(--mg-white);
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,.85);
            padding: 1rem;
        }

        .sidebar .nav-link:hover {
            color: var(--mg-white);
            background-color: rgba(255,255,255,.06);
        }

        .sidebar .nav-link.active {
            color: var(--mg-white);
            background-color: rgba(255,255,255,.06);
        }

        .sidebar .nav-link i { margin-right: 0.5rem; }

        .content { margin-left: 250px; }

        /* Admin topbar accent */
        .sidebar .sidebar-heading { color: var(--mg-yellow); }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                top: 0;
                bottom: 0;
                left: -250px;
                z-index: 100;
                transition: all 0.3s;
            }

            .sidebar.active { left: 0; }

            .content { margin-left: 0; }
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="sidebar" style="width: 250px;">
            <div class="p-3">
                <h5 class="mb-4">Admin GESIT</h5>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/events*') ? 'active' : '' }}" href="{{ route('admin.events.index') }}">
                            <i class="fas fa-calendar-alt"></i> Events
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/tickets*') ? 'active' : '' }}" href="{{ route('admin.tickets.show', 1) }}">
                            <i class="fas fa-ticket-alt"></i> Tickets
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Content -->
        <main class="flex-grow-1 content p-4">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Optional: jQuery if needed -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    @yield('scripts')
</body>
</html>