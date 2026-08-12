<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SIMPEL - Dashboard</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Mapbox CSS -->
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css' rel='stylesheet' />
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
<!-- ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.35.0/dist/apexcharts.min.js"></script>


<meta name="csrf-token" content="{{ csrf_token() }}">

    
    <style>
        :root {
            --simpel-red: #dc0000;
            --sidebar-width: 250px;
        }
        
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
            transition: margin-left 0.3s;
        }
        
        .dashboard-container {
            display: flex;
            min-height: 100vh;
            position: relative;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background-color: #ffffff;
            border-right: 1px solid #e0e0e0;
            position: fixed;
            height: 100%;
            overflow-y: auto;
            z-index: 1000;
            transition: all 0.3s ease;
            left: 0;
        }
        
        .sidebar.collapsed {
            left: calc(-1 * var(--sidebar-width));
        }
        
        .sidebar-header {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #e0e0e0;
            position: relative;
        }
        
        .sidebar-header img {
            max-width: 80%;
            height: auto;
        }
        
        .sidebar-menu {
            padding: 20px 0;
        }
        
        .menu-item {
            padding: 10px 20px;
            color: #333;
            display: block;
            text-decoration: none;
            transition: all 0.3s;
            font-weight: 500;
        }
        
        .menu-item:hover {
            background-color: #f5f5f5;
            color: var(--simpel-red);
        }
        
        .menu-item.active {
            background-color: #f0f0f0;
            color: var(--simpel-red);
            border-left: 4px solid var(--simpel-red);
        }
        
        .menu-item i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .menu-section {
            font-size: 12px;
            text-transform: uppercase;
            color: #888;
            padding: 15px 20px 5px;
            font-weight: 700;
        }
        
        /* Main Content */
        .main-content {
            width: calc(100% - var(--sidebar-width));
            margin-left: var(--sidebar-width);
            padding: 20px;
            transition: all 0.3s ease;
        }
        
        .main-content.expanded {
            width: 100%;
            margin-left: 0;
        }
        
        .topbar {
            background-color: #fff;
            height: 60px;
            display: flex;
            align-items: center;
            padding: 0 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            justify-content: space-between;
        }
        
        .user-dropdown {
            display: flex;
            align-items: center;
        }
        
        .user-dropdown img {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            margin-right: 10px;
        }
        
        .toggle-btn {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: #333;
            padding: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .toggle-btn:hover {
            color: var(--simpel-red);
        }
        
        /* Service Cards */
        .service-card {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: all 0.3s;
            height: 100%;
            cursor: pointer;
        }
        
        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .service-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
        }
        
        .service-icon i {
            font-size: 32px;
            color: #fff;
        }
        
        .bg-red {
            background-color: var(--simpel-red);
        }
        
        .bg-blue {
            background-color: #007bff;
        }
        
        /* Calendar Styles */
        .calendar-container {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .weekdays {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
        }
        
        .day {
            padding: 10px;
            text-align: center;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .day:hover {
            background-color: #f0f0f0;
        }
        
        .day.active {
            background-color: #888;
            color: white;
        }
        
        .day.event {
            position: relative;
        }
        
        .day.event:after {
            content: "";
            position: absolute;
            bottom: 2px;
            left: 50%;
            transform: translateX(-50%);
            width: 6px;
            height: 6px;
            background-color: var(--simpel-red);
            border-radius: 50%;
        }
        
        .other-month {
            color: #ccc;
        }
        
        .calendar-tip {
            text-align: center;
            margin-top: 20px;
            font-style: italic;
            color: #888;
        }
        
        /* Logout Button */
        .logout-btn {
            background-color: var(--simpel-red);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 15px;
        }
        
        .logout-btn:hover {
            background-color: #b80000;
        }
        
        /* Overlay for mobile sidebar */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0,0,0,0.5);
            z-index: 999;
            display: none;
        }
        
        .sidebar-overlay.active {
            display: block;
        }
        
        /* Mapbox Styling */
        #map {
            width: 100%;
            height: 500px;
            border-radius: 10px;
        }
        
        .mapboxgl-marker {
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .mapboxgl-marker:hover {
            transform: scale(1.2);
        }
        
        .mapboxgl-popup-content {
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .marker {
            cursor: pointer;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .sidebar {
                left: calc(-1 * var(--sidebar-width));
            }
            
            .sidebar.active {
                left: 0;
            }
            
            .main-content {
                width: 100%;
                margin-left: 0;
            }
            
            #map {
                height: 400px;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar Overlay (for mobile) -->
        <div class="sidebar-overlay" id="sidebar-overlay"></div>
        
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <img src="{{ asset('img/simpel-logo.png') }}" alt="SIMPEL Logo">
                <p><small>SPEED. TECHNICIAN. INNOVATION</small></p>
            </div>
            
            <div class="sidebar-menu">
                <a href="{{ route('home') }}" class="menu-item {{ Request::routeIs('home') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                
                <div class="menu-section">SIMPEL SERVICES</div>
                
                <a href="{{ route('witel.search') }}" class="menu-item {{ Request::routeIs('witel.search') ? 'active' : '' }}">
                    <i class="fas fa-search"></i> WITEL SEARCH
                </a>
                <a href="{{ route('lop.create') }}" class="menu-item {{ Request::routeIs('lop.create') ? 'active' : '' }}">
                    <i class="fas fa-arrow-up"></i> ADD LOP
                </a>
                
                <a href="{{ route('forms.index') }}" class="menu-item {{ Request::routeIs('forms.*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i> FORMS
                </a>

                <div class="menu-section">PERSONAL INFORMATION</div>
                <a href="{{ route('profile.index') }}" class="menu-item {{ Request::routeIs('profile.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-user"></i> PROFILE
                </a>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content" id="main-content">
            <div class="topbar">
                <button id="sidebar-toggle" class="toggle-btn">
                    <i class="fas fa-bars"></i>
                </button>
                
                <div class="user-dropdown">
                    <span>{{ Auth::user()->full_name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Page Content -->
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Mapbox JS -->
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js'></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebarOverlay = document.getElementById('sidebar-overlay');
            
            // Function to check if on mobile view
            function isMobileView() {
                return window.innerWidth <= 768;
            }
            
            // Function to toggle sidebar
            function toggleSidebar() {
                sidebar.classList.toggle('collapsed');
                sidebar.classList.toggle('active');
                mainContent.classList.toggle('expanded');
                
                // Show/hide overlay on mobile
                if (isMobileView()) {
                    sidebarOverlay.classList.toggle('active');
                }
            }
            
            // Toggle sidebar when button is clicked
            sidebarToggle.addEventListener('click', toggleSidebar);
            
            // Close sidebar when overlay is clicked
            sidebarOverlay.addEventListener('click', function() {
                if (sidebar.classList.contains('active')) {
                    toggleSidebar();
                }
            });
            
            // Adjust UI when resizing window
            window.addEventListener('resize', function() {
                if (!isMobileView() && sidebarOverlay.classList.contains('active')) {
                    sidebarOverlay.classList.remove('active');
                }
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>