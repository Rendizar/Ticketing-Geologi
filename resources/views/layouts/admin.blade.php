<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin GESIT</title>
    
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
            border-bottom: 4px solid var(--mg-black);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .sidebar-header::before {
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

        .sidebar-brand {
            font-size: clamp(2rem, 5vw, 3rem);
            font-weight: 900;
            font-family: 'Futura PT', 'Century Gothic', sans-serif;
            color: #1a1a1a;
            -webkit-text-stroke: 2px #FFD400;
            text-stroke: 2px #FFD400;
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

        /* Floating Toggle Button */
        .floating-sidebar-toggle {
            position: fixed;
            top: 20px;
            left: calc(var(--sidebar-width) + 10px);
            z-index: 1050;
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--mg-yellow) 0%, #FFB300 100%);
            border: none;
            color: var(--mg-black);
            font-size: 1.3rem;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(255, 212, 0, 0.4);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        .main-content.expanded .floating-sidebar-toggle {
            left: 10px;
        }

        .floating-sidebar-toggle:hover {
            background: var(--mg-black);
            color: var(--mg-yellow);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 212, 0, 0.6);
        }

        .floating-sidebar-toggle:active {
            transform: translateY(0);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--mg-yellow);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            color: var(--mg-black);
            border: 3px solid var(--mg-yellow);
            transition: all 0.3s ease;
        }

        .navbar-user:hover .user-avatar {
            transform: rotate(360deg);
        }

        /* Content Area */
        .content-wrapper {
            padding: 2rem;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: calc(100vh - 80px);
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
                <a href="{{ route('admin.events.index') }}" class="nav-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt"></i>
                    Event
                </a>
            </div>
            
            <div class="nav-item">
                <a href="{{ route('admin.stats') }}" class="nav-link {{ request()->routeIs('admin.stats') ? 'active' : '' }}">
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
        <!-- Floating Toggle Button -->
        <button class="floating-sidebar-toggle" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>

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