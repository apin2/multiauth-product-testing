<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Customer Panel')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
            transition: all 0.3s;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 100;
            overflow-y: auto;
        }
        .sidebar .nav-link {
            color: #adb5bd;
            padding: 0.75rem 1rem;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background-color: #495057;
        }
        .main-content {
            padding-top: 20px;
            padding-bottom: 20px;
            margin-left: 25%;
        }
        @media (min-width: 992px) {
            .main-content {
                margin-left: 16.666667%;
            }
        }
        .navbar-brand {
            font-weight: 600;
        }
        .user-menu {
            cursor: pointer;
        }
        .sidebar .sidebar-header {
            padding: 1rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,.1);
        }
        .sidebar .nav-item {
            margin: 0 .5rem;
        }
        .sidebar .nav-item .nav-link {
            border-radius: .375rem;
            margin-bottom: .25rem;
        }
        .sidebar .nav-item .nav-link.active {
            background-color: rgba(255,255,255,.1);
        }
        
        /* Elegant pagination styling */
        .pagination {
            margin-top: 1rem;
            margin-bottom: 0;
        }
        
        .page-item {
            margin: 0 0.125rem;
        }
        
        .page-link {
            border-radius: .375rem !important;
            margin: 0 0.0625rem;
            border: 1px solid #dee2e6;
            color: #0d6efd;
            background-color: #fff;
            transition: all 0.2s ease-in-out;
            padding: 0.375rem 0.75rem;
        }
        
        .page-link:hover {
            color: #0a58ca;
            background-color: #e9ecef;
            border-color: #adb5bd;
        }
        
        .page-item.active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: #fff;
            box-shadow: 0 2px 4px rgba(13, 110, 253, 0.25);
        }
        
        .page-item.disabled .page-link {
            color: #6c757d;
            background-color: #f8f9fa;
            border-color: #dee2e6;
        }
        
        .page-link i {
            font-size: 0.9rem;
            vertical-align: middle;
        }
        
        header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
            padding: 0.5rem 1rem;
            position: sticky;
            top: 0;
            z-index: 1020;
            margin-left: 25%;
        }
        @media (min-width: 992px) {
            header {
                margin-left: 16.666667%;
            }
        }
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                bottom: 0;
                z-index: 1000;
                padding-top: 3.5rem;
            }
            .sidebar .close-sidebar {
                position: absolute;
                top: 1rem;
                right: 1rem;
                color: white;
            }
            .overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0,0,0,0.5);
                z-index: 999;
            }
        }
    </style>
</head>
<body class="bg-light">
    <!-- Header -->
    <header>
        <nav class="navbar navbar-expand navbar-light bg-light">
            <div class="container-fluid">
                <button class="navbar-toggler d-md-none" type="button" id="sidebarToggle" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <span class="navbar-brand mb-0 h1">Customer Portal</span>
                <div class="navbar-nav ms-auto d-flex align-items-center">
                    <div class="dropdown user-menu">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-2 fs-4 text-primary"></i>
                            <span class="d-none d-md-inline">{{ Auth::guard('customer')->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <span class="dropdown-header text-muted small">
                                    Signed in as <br><strong>{{ Auth::guard('customer')->user()->email }}</strong>
                                </span>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('customer.profile.index') }}">
                                    <i class="bi bi-person me-2"></i> Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('customer.profile.edit') }}">
                                    <i class="bi bi-pencil me-2"></i> Edit Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('customer.password.edit') }}">
                                    <i class="bi bi-shield-lock me-2"></i> Change Password
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('customer.logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    
    <div class="wrapper d-flex">
        <div class="overlay" id="sidebarOverlay"></div>
        <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse" id="sidebarMenu">
            <div class="position-sticky pt-3">
                <div class="text-white text-center py-3 mb-4 sidebar-header">
                    <h4 class="mb-0">Customer Panel</h4>
                    <button class="btn btn-sm btn-outline-light d-md-none close-sidebar" type="button" id="closeSidebarBtn">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}" 
                           href="{{ route('customer.dashboard') }}">
                            <i class="bi bi-speedometer2 me-2"></i>
                            Dashboard
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('customer.profile.*') ? 'active' : '' }}" 
                           href="{{ route('customer.profile.index') }}">
                            <i class="bi bi-person me-2"></i>
                            Profile
                        </a>
                    </li>
                </ul>                
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        if (performance.navigation.type === 2) {
            location.reload(true);
        }
        
        window.history.pushState(null, null, window.location.href);
        window.onpopstate = function () {
            window.history.pushState(null, null, window.location.href);
        };
        
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebarMenu');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const closeSidebarBtn = document.getElementById('closeSidebarBtn');
            
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                    sidebarOverlay.style.display = 'block';
                });
            }
            
            if (closeSidebarBtn) {
                closeSidebarBtn.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    sidebarOverlay.style.display = 'none';
                });
            }
            
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    this.style.display = 'none';
                });
            }
            
            // Show SweetAlert for success/error messages
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 3000
                });
            @endif
            
            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    showConfirmButton: false,
                    timer: 3000
                });
            @endif
        });
    </script>
</body>
</html>