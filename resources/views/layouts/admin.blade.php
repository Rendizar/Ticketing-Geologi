<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin GESIT</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --mg-yellow: #FFD400;
            --mg-black: #0b0b0b;
            --mg-white: #ffffff;
            --sidebar-width: 280px;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--mg-black) 0%, #1a1a1a 100%);
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.3);
            border-right: 3px solid var(--mg-yellow);
            z-index: 1000;
            overflow-y: auto;
            transition: transform 0.3s ease-in-out;
        }

        .sidebar.collapsed {
            transform: translateX(-100%);
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            background: linear-gradient(135deg, var(--mg-yellow) 0%, #FFB300 100%);
            border-bottom: 3px solid var(--mg-black);
            text-align: center;
        }

        .sidebar-brand {
            font-family: 'Futura PT', 'Century Gothic', sans-serif;
            font-size: 2rem;
            font-weight: 900;
            letter-spacing: 0.1em;
            color: var(--mg-black);
            text-shadow: 2px 2px 4px rgba(255, 255, 255, 0.3);
            margin: 0;
        }

        .sidebar-subtitle {
            font-size: 0.9rem;
            color: var(--mg-black);
            font-weight: 600;
            margin-top: 0.5rem;
        }

        .nav-menu {
            padding: 1.5rem 0;
        }

        .nav-item {
            margin: 0.5rem 1rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 1rem 1.25rem;
            color: var(--mg-yellow);
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.05rem;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .nav-link i {
            width: 30px;
            font-size: 1.25rem;
            margin-right: 1rem;
        }

        .nav-link:hover {
            background: var(--mg-yellow);
            color: var(--mg-black);
            transform: translateX(8px);
            border-color: var(--mg-yellow);
            box-shadow: 0 4px 15px rgba(255, 212, 0, 0.4);
        }

        .nav-link.active {
            background: var(--mg-yellow);
            color: var(--mg-black);
            border-color: var(--mg-yellow);
            box-shadow: 0 4px 15px rgba(255, 212, 0, 0.5);
        }

        .nav-divider {
            height: 2px;
            background: rgba(255, 212, 0, 0.2);
            margin: 1rem 1.5rem;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin-left 0.3s ease-in-out;
        }

        .main-content.expanded {
            margin-left: 0;
        }

        /* Navbar */
        .top-navbar {
            background: var(--mg-white);
            border-bottom: 3px solid var(--mg-yellow);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .navbar-toggle {
            background: linear-gradient(135deg, var(--mg-yellow) 0%, #FFB300 100%);
            border: 2px solid var(--mg-black);
            color: var(--mg-black);
            padding: 0.6rem 1rem;
            border-radius: 8px;
            font-weight: 700;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .navbar-toggle:hover {
            background: var(--mg-black);
            color: var(--mg-yellow);
            transform: scale(1.05);
        }

        .navbar-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--mg-black);
        }

        .navbar-user {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: var(--mg-yellow);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            color: var(--mg-black);
            border: 3px solid var(--mg-black);
        }

        /* Content Area */
        .content-wrapper {
            padding: 2rem;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .navbar-title {
                font-size: 1rem;
            }

            .content-wrapper {
                padding: 1rem;
            }
        }

        /* Scrollbar Styling */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 212, 0, 0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: var(--mg-yellow);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: #FFB300;
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h2 class="sidebar-brand">GESIT</h2>
            <p class="sidebar-subtitle">Admin Panel</p>
        </div>
        
        <nav class="nav-menu">
            <div class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                </a>
            </div>
            
            <div class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-ticket-alt"></i>
                    Tiket
                </a>
            </div>
            
            <div class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-calendar-alt"></i>
                    Event
                </a>
            </div>
            
            <div class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-chart-bar"></i>
                    Statistik
                </a>
            </div>
            
            <div class="nav-divider"></div>
            
            <div class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-cog"></i>
                    Pengaturan
                </a>
            </div>
            
            <div class="nav-item">
                <a href="{{ route('admin.logout') }}" class="nav-link">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Top Navbar -->
        <div class="top-navbar">
            <div class="d-flex align-items-center gap-3">
                <button class="navbar-toggle" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <span class="navbar-title">Museum Geologi Bandung</span>
            </div>
            
            <div class="navbar-user">
                <div class="user-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <span class="fw-bold d-none d-md-inline">Admin</span>
            </div>
        </div>

        <!-- Content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const sidebarToggle = document.getElementById('sidebarToggle');

        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
            
            // Save state to localStorage
            const isCollapsed = sidebar.classList.contains('collapsed');
            localStorage.setItem('sidebarCollapsed', isCollapsed);
        });

        // Load saved state on page load
        window.addEventListener('DOMContentLoaded', function() {
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (isCollapsed) {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
            }
        });

        // Mobile: Toggle sidebar
        if (window.innerWidth <= 768) {
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('show');
            });

            // Close sidebar when clicking outside on mobile
            mainContent.addEventListener('click', function() {
                if (sidebar.classList.contains('show')) {
                    sidebar.classList.remove('show');
                }
            });
        }
    </script>
    
    @yield('scripts')
</body>
</html>