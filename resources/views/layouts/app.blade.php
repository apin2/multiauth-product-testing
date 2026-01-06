<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Multi-Auth System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
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
    </style>
</head>
<body class="bg-light">
    @yield('content')

    @if(session('success'))
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div class="toast show bg-success text-white" role="alert">
                <div class="toast-header bg-success text-white">
                    <strong class="me-auto">Success</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body">
                    {{ session('success') }}
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div class="toast show bg-danger text-white" role="alert">
                <div class="toast-header bg-danger text-white">
                    <strong class="me-auto">Error</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body">
                    {{ session('error') }}
                </div>
            </div>
        </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Bootstrap toasts
            const toastElList = [].slice.call(document.querySelectorAll('.toast'));
            toastElList.forEach(function (toastEl) {
                const toast = new bootstrap.Toast(toastEl, { delay: 5000 });
                toast.show();
            });
            
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
            function confirmToggle(formElement) {
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