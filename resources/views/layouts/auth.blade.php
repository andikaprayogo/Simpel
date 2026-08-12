<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMPEL - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .auth-card {
            max-width: 500px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
        }
        .auth-header {
            font-weight: bold;
            margin-bottom: 20px;
        }
        .section-header {
            font-weight: bold;
            margin-bottom: 15px;
        }
        .btn-auth {
            background-color: #dc0000;
            color: white;
            border: none;
            border-radius: 25px;
            padding: 12px;
            font-weight: bold;
            width: 100%;
            margin-top: 20px;
        }
        .btn-auth:hover {
            background-color: #b80000;
            color: white;
        }
        .form-control {
            border-radius: 5px;
            padding: 12px;
            margin-bottom: 15px;
        }
        .icon-input {
            position: relative;
        }
        .icon-input i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #dc0000;
        }
        .icon-input input {
            padding-left: 45px;
        }
        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
        }
        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo-container img {
            width: 120px;
            height: 120px;
        }
        .welcome-text {
            text-align: center;
            margin-bottom: 25px;
        }
        .welcome-text span {
            color: #dc0000;
            font-weight: bold;
        }
        .forgot-password {
            text-align: right;
            margin-top: -10px;
            margin-bottom: 10px;
        }
        .forgot-password a {
            color: #dc0000;
            text-decoration: none;
            font-size: 14px;
        }
        .signup-link {
            text-align: center;
            margin-top: 15px;
        }
        .signup-link a {
            color: #dc0000;
            text-decoration: none;
            border: 1px solid #28a745;
            padding: 5px 10px;
            border-radius: 4px;
            background-color: white;
        }
        .back-button {
            margin-bottom: 20px;
            font-size: 1.5rem;
            color: #000;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = document.querySelector(`#${inputId} + .toggle-password`);
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        }
    </script>
</body>
</html>