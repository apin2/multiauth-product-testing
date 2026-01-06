<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
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
            margin-left: 25%; /* This is the width of the col-md-3 sidebar */
        }
        @media (min-width: 992px) {
            .main-content {
                margin-left: 16.666667%; /* This is the width of the col-lg-2 sidebar */
            }
        }
        .navbar-brand {
            font-weight: 600;
        }
        .user-dropdown .dropdown-toggle::after {
            display: none;
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
        
        
        /* Header styling for visual separation */
        header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
            padding: 0.5rem 1rem;
            position: sticky;
            top: 0;
            z-index: 1020;
            margin-left: 25%; /* Account for fixed sidebar on medium screens */
        }
        @media (min-width: 992px) {
            header {
                margin-left: 16.666667%; /* Account for fixed sidebar on large screens */
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
                <span class="navbar-brand mb-0 h1">Admin Portal</span>
                <div class="navbar-nav ms-auto d-flex align-items-center">
                    <div class="dropdown user-menu">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-2 fs-4 text-primary"></i>
                            <span class="d-none d-md-inline">{{ Auth::guard('admin')->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <span class="dropdown-header text-muted small">
                                    Signed in as <br><strong>{{ Auth::guard('admin')->user()->email }}</strong>
                                </span>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.profile.index') }}">
                                    <i class="bi bi-person me-2"></i> Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.profile.edit') }}">
                                    <i class="bi bi-pencil me-2"></i> Edit Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.password.edit') }}">
                                    <i class="bi bi-shield-lock me-2"></i> Change Password
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
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
        <!-- Overlay for mobile sidebar -->
        <div class="overlay" id="sidebarOverlay"></div>
        
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse" id="sidebarMenu">
            <div class="position-sticky pt-3">
                <div class="text-white text-center py-3 mb-4 sidebar-header">
                    <h4 class="mb-0">Admin Panel</h4>
                    <button class="btn btn-sm btn-outline-light d-md-none close-sidebar" type="button" id="closeSidebarBtn">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                           href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-speedometer2 me-2"></i>
                            Dashboard
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}" 
                           href="{{ route('admin.customers.index') }}">
                            <i class="bi bi-people me-2"></i>
                            Customers
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" 
                           href="{{ route('admin.products.index') }}">
                            <i class="bi bi-box me-2"></i>
                            Products
                        </a>
                    </li>                    
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}" 
                           href="{{ route('admin.profile.index') }}">
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
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
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
            
            // Function for delete confirmation
            function confirmDelete(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + id).submit();
                    }
                });
            }
            
            // Function for toggle status confirmation
            function confirmToggle(formElement, customerId) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to change the customer status?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, change it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Temporarily update the status indicator to show immediate feedback
                        const statusIndicator = document.getElementById(`status-indicator-${customerId}`);
                        const statusText = document.getElementById(`status-text-${customerId}`);
                        
                        if (statusIndicator && statusText) {
                            // Find the button to get current status
                            const button = formElement.querySelector('button');
                            const currentStatus = button.getAttribute('data-current-status');
                            
                            if (currentStatus === 'active') {
                                // Changing from active to inactive, likely going offline
                                statusIndicator.innerHTML = '<i class="fas fa-circle text-secondary" title="Offline"></i>';
                                statusText.textContent = 'Offline';
                            } else {
                                // Changing from inactive to active, status remains offline until login
                                statusIndicator.innerHTML = '<i class="fas fa-circle text-secondary" title="Offline"></i>';
                                statusText.textContent = 'Offline';
                            }
                        }
                        
                        formElement.submit();
                    }
                });
                return false;
            }
            
            // Function for product delete confirmation
            function confirmDeleteProduct(event) {
                event.preventDefault();
                const form = event.target.closest('.delete-form');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
                
                return false;
            }
        });
    </script>
</body>
</html>