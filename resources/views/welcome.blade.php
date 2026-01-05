<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login | Choose Role</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #f5f7fa, #e4ebf5);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12);
        }

        .icon-box {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 28px;
        }

        .admin-icon {
            background: #e8f0ff;
            color: #0d6efd;
        }

        .customer-icon {
            background: #e9f9f1;
            color: #198754;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center g-4">
            <div class="col-md-5">
                <div class="card login-card text-center p-4">
                    <div class="icon-box admin-icon">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <h4 class="fw-bold">Admin Login</h4>
                    <p class="text-muted">
                        Manage products, users, and system settings from the admin panel.
                    </p>
                    <a href="{{ route('admin.login') }}" class="btn btn-primary w-100">
                        Login as Admin
                    </a>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card login-card text-center p-4">
                    <div class="icon-box customer-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <h4 class="fw-bold">Customer Login</h4>
                    <p class="text-muted">
                        Browse products, place orders, and manage your account easily.
                    </p>
                    <a href="{{ route('customer.login') }}" class="btn btn-success w-100">
                        Login as Customer
                    </a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
