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
    
    <!-- Modern Admin Theme CSS -->
    <link href="{{ asset('css/admin-modern-theme.css') }}" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #1F2933;
            --secondary-color: #3B82F6;
            --accent-color: #10B981;
            --text-primary: #1F2933;
            --text-secondary: #6B7280;
            --bg-primary: #FFFFFF;
            --bg-secondary: #F9FAFB;
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
            background: var(--primary-color);
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
            border-right: 1px solid #E5E7EB;
            z-index: 1000;
            overflow-y: auto;
            transition: transform 0.3s ease-in-out;
        }

        .sidebar.collapsed {
            transform: translateX(-100%);
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            background: var(--primary-color);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            position: relative;
        }

        .sidebar-brand {
            font-size: 1.75rem;
            font-weight: 700;
            font-family: 'Merriweather', serif;
            color: #FFFFFF;
            letter-spacing: 0.5px;
            line-height: 1.2;
            margin: 0;
        }

        .sidebar-subtitle {
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.7);
            font-weight: 500;
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
            padding: 0.875rem 1.25rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            border-radius: 0.5rem;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            border: none;
        }

        .nav-link i {
            width: 24px;
            font-size: 1.125rem;
            margin-right: 0.75rem;
        }

        .nav-link:hover {
            background: #FACC15;
            color: var(--primary-color);
            transform: translateX(4px);
            box-shadow: 0 2px 8px rgba(250, 204, 21, 0.4);
        }

        .nav-link.active {
            background: #FACC15;
            color: var(--primary-color);
            box-shadow: 0 2px 8px rgba(250, 204, 21, 0.4);
            font-weight: 700;
        }

        .nav-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
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
            width: 44px;
            height: 44px;
            border-radius: 0.5rem;
            background: var(--primary-color);
            border: 1px solid #E5E7EB;
            color: #FFFFFF;
            font-size: 1.25rem;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main-content.expanded .floating-sidebar-toggle {
            left: 10px;
        }

        .floating-sidebar-toggle:hover {
            background: #FACC15;
            color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(250, 204, 21, 0.4);
        }

        .floating-sidebar-toggle:active {
            transform: translateY(0);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #FACC15;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: var(--primary-color);
            border: 2px solid #FACC15;
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

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }
        
        /* Badge */
        .badge.bg-warning {
            background: #FACC15 !important;
            color: var(--primary-color);
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            font-weight: 700;
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
                <a href="{{ route('admin.stats') }}" class="nav-link {{ request()->routeIs('admin.stats') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i>
                    Statistik
                </a>
            </div>
            
            <div class="nav-item">
                <a href="{{ route('admin.events.index') }}" class="nav-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt"></i>
                    Event
                </a>
            </div>
            
            <div class="nav-item">
                <a href="{{ route('admin.special-tickets.index') }}" class="nav-link {{ request()->routeIs('admin.special-tickets.*') ? 'active' : '' }}">
                    <i class="fas fa-ticket-alt"></i>
                    Tiket Khusus
                    @php
                        $pendingSpecial = \App\Models\SpecialTicketRequest::where('status', 'pending')->count();
                    @endphp
                    @if($pendingSpecial > 0)
                        <span class="badge bg-warning ms-2">{{ $pendingSpecial }}</span>
                    @endif
                </a>
            </div>
            
            <div class="nav-item">
                <a href="{{ route('admin.bookings.index') }}" class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                    <i class="fas fa-receipt"></i>
                    Riwayat Tiket & Pembayaran
                </a>
            </div>
            
            <div class="nav-divider"></div>
            
            <div class="nav-item">
                <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') && !request()->routeIs('admin.special-tickets.*') ? 'active' : '' }}">
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