<<<<<<< HEAD
@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Login to PDMHS Clinic</h4>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" value="{{ old('email') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Select Your Role</label>
                        <select id="role" name="role" class="form-select" required>
                            <option value="">Choose your role</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="clinic_staff" {{ old('role') == 'clinic_staff' ? 'selected' : '' }}>Clinic Staff</option>
                            <option value="adviser" {{ old('role') == 'adviser' ? 'selected' : '' }}>Adviser</option>
                            <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
                        </select>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            Sign In
                        </button>
                    </div>
                </form>

                <div class="text-center mt-3">
                    <p class="mb-0">Don't have an account? <a href="{{ route('register') }}">Sign Up</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
=======
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PDMHS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #1e40af;
            --primary-dark: #1e3a8a;
            --secondary: #3b82f6;
            --accent: #60a5fa;
            --dark: #0f172a;
            --gray: #64748b;
            --light: #f1f5f9;
            --white: #ffffff;
            --success: #10b981;
            --warning: #f59e0b;
            --gradient: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to bottom right, #f8fafc, #e0f2fe);
            color: var(--dark);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
        }

        /* Navigation */
        nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.05);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(30, 64, 175, 0.1);
        }

        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 80px;
        }

        .logo {
            font-size: 28px;
            font-weight: 800;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -1px;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .logo::before {
            content: "🏥";
            font-size: 32px;
            -webkit-text-fill-color: initial;
        }

        .nav-links {
            display: flex;
            gap: 8px;
            list-style: none;
            align-items: center;
        }

        .nav-links a {
            color: var(--gray);
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            padding: 10px 20px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .nav-links a:hover {
            color: var(--primary);
            background: var(--light);
            transform: translateY(-2px);
        }

        .nav-links a.active {
            color: var(--primary);
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        }

        /* Login Form */
        .login-container {
            background: var(--white);
            border-radius: 24px;
            padding: 48px;
            box-shadow: 0 32px 64px rgba(30, 64, 175, 0.15);
            border: 1px solid rgba(30, 64, 175, 0.1);
            width: 100%;
            max-width: 450px;
            position: relative;
            overflow: hidden;
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: var(--gradient);
        }

        .login-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .login-header h1 {
            font-size: 32px;
            font-weight: 900;
            margin-bottom: 8px;
            background: linear-gradient(135deg, var(--dark) 0%, var(--primary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .login-header p {
            color: var(--gray);
            font-size: 16px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--dark);
        }

        .form-group input {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid var(--light);
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: var(--white);
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
        }

        .form-group input::placeholder {
            color: var(--gray);
        }

        .btn {
            width: 100%;
            padding: 16px 32px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 16px;
        }

        .btn-primary {
            background: var(--gradient);
            color: var(--white);
            box-shadow: 0 8px 24px rgba(30, 64, 175, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(30, 64, 175, 0.4);
        }

        .btn-secondary {
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-secondary:hover {
            background: var(--primary);
            color: var(--white);
            transform: translateY(-3px);
        }

        .login-footer {
            text-align: center;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid var(--light);
        }

        .login-footer p {
            color: var(--gray);
            font-size: 14px;
        }

        .login-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }

        /* Alert Messages */
        .alert {
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-weight: 600;
            font-size: 14px;
        }

        .alert-success {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #065f46;
            border: 1px solid #10b981;
        }

        .alert-error {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #991b1b;
            border: 1px solid #ef4444;
        }

        .error-text {
            color: #ef4444;
            font-size: 12px;
            margin-top: 4px;
            display: block;
        }

        /* Role Selection */
        .role-selection {
            margin-bottom: 32px;
        }

        .role-selection h3 {
            font-family: 'Poppins', sans-serif;
            font-size: 20px;
            font-weight: 900;
            margin-bottom: 16px;
            color: var(--dark);
            text-align: center;
            letter-spacing: -0.5px;
        }

        .role-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 16px;
        }

        .role-btn {
            padding: 16px 12px;
            border: 2px solid var(--light);
            border-radius: 16px;
            background: var(--white);
            color: var(--gray);
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            position: relative;
            overflow: hidden;
        }

        .role-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: transparent;
            transition: all 0.3s ease;
        }

        .role-btn:hover {
            border-color: var(--primary);
            color: var(--primary);
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(30, 64, 175, 0.15);
        }

        .role-btn.active {
            border-color: var(--primary);
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            color: var(--primary);
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(30, 64, 175, 0.2);
        }

        .role-btn .role-icon {
            font-size: 28px;
            margin-bottom: 8px;
            filter: grayscale(0.3);
            transition: all 0.3s ease;
        }

        .role-btn:hover .role-icon {
            filter: grayscale(0);
            transform: scale(1.1);
        }

        .role-btn.active .role-icon {
            filter: grayscale(0);
            transform: scale(1.15);
        }

        /* Role-specific styling */
        .role-btn[data-role="admin"]:hover,
        .role-btn[data-role="admin"].active {
            border-color: #dc2626;
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #dc2626;
        }

        .role-btn[data-role="clinic_staff"]:hover,
        .role-btn[data-role="clinic_staff"].active {
            border-color: #059669;
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #059669;
        }

        .role-btn[data-role="adviser"]:hover,
        .role-btn[data-role="adviser"].active {
            border-color: #7c3aed;
            background: linear-gradient(135deg, #ede9fe, #ddd6fe);
            color: #7c3aed;
        }

        .role-btn[data-role="student"]:hover,
        .role-btn[data-role="student"].active {
            border-color: #ea580c;
            background: linear-gradient(135deg, #fed7aa, #fdba74);
            color: #ea580c;
        }

        /* Top border colors */
        .role-btn[data-role="admin"]:hover::before,
        .role-btn[data-role="admin"].active::before {
            background: #dc2626;
        }

        .role-btn[data-role="clinic_staff"]:hover::before,
        .role-btn[data-role="clinic_staff"].active::before {
            background: #059669;
        }

        .role-btn[data-role="adviser"]:hover::before,
        .role-btn[data-role="adviser"].active::before {
            background: #7c3aed;
        }

        .role-btn[data-role="student"]:hover::before,
        .role-btn[data-role="student"].active::before {
            background: #ea580c;
        }

        .role-btn .role-name {
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }

        .role-btn .role-desc {
            font-size: 10px;
            opacity: 0.7;
            font-weight: 500;
            line-height: 1.2;
        }

        .role-btn:hover .role-desc,
        .role-btn.active .role-desc {
            opacity: 0.9;
        }

        .login-form {
            display: none;
        }

        .login-form.active {
            display: block;
        }



        /* Responsive */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .login-container {
                margin: 2rem;
                padding: 32px 24px;
            }
        }
    </style>
</head>
<body>
    <nav>
        <div class="nav-container">
            <a href="/" class="logo">PDMHS</a>
            <ul class="nav-links">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('features') }}">Features</a></li>
                <li><a href="{{ route('scanner') }}">QR Scanner</a></li>
                <li><a href="{{ route('students.index') }}">Students</a></li>
                <li><a href="{{ route('clinic-visits.index') }}">Clinic Visits</a></li>
                <li><a href="{{ route('immunizations.index') }}">Immunizations</a></li>
                <li><a href="{{ route('health-incidents.index') }}">Health Incidents</a></li>
                <li><a href="{{ route('vitals.index') }}">Vitals</a></li>
                <li><a href="{{ route('login') }}" class="active">Login</a></li>
            </ul>
        </div>
    </nav>

    <div class="login-container">
        <div class="login-header">
            <h1>Welcome Back</h1>
            <p>Sign in to access the PDMHS High School Clinic Management System</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif

        <!-- Role Selection -->
        <div class="role-selection">
            <h3>Select Your Role</h3>
            <div class="role-buttons">
                <div class="role-btn" data-role="admin">
                    <div class="role-icon">🛡️</div>
                    <div class="role-name">Admin</div>
                </div>
                <div class="role-btn" data-role="clinic_staff">
                    <div class="role-icon">🩺</div>
                    <div class="role-name">Clinic Staff</div>
                </div>
                <div class="role-btn" data-role="adviser">
                    <div class="role-icon">📚</div>
                    <div class="role-name">Adviser</div>
                </div>
                <div class="role-btn" data-role="student">
                    <div class="role-icon">🎓</div>
                    <div class="role-name">Student</div>
                </div>
            </div>
        </div>

        <!-- Login Forms for each role -->
        <div id="admin-form" class="login-form">
            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <div class="form-group">
                    <label for="admin-email">Email Address</label>
                    <input type="email" id="admin-email" name="username" placeholder="Enter admin email" required>
                </div>
                <div class="form-group">
                    <label for="admin-password">Password</label>
                    <input type="password" id="admin-password" name="password" placeholder="Enter admin password" required>
                </div>
                <button type="submit" class="btn btn-primary">Sign In as Admin</button>
            </form>
        </div>

        <div id="clinic_staff-form" class="login-form">
            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <div class="form-group">
                    <label for="staff-email">Email Address</label>
                    <input type="email" id="staff-email" name="username" placeholder="Enter staff email" required>
                </div>
                <div class="form-group">
                    <label for="staff-password">Password</label>
                    <input type="password" id="staff-password" name="password" placeholder="Enter staff password" required>
                </div>
                <button type="submit" class="btn btn-primary">Sign In as Clinic Staff</button>
            </form>
        </div>

        <div id="adviser-form" class="login-form">
            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <div class="form-group">
                    <label for="adviser-email">Email Address</label>
                    <input type="email" id="adviser-email" name="username" placeholder="Enter adviser email" required>
                </div>
                <div class="form-group">
                    <label for="adviser-password">Password</label>
                    <input type="password" id="adviser-password" name="password" placeholder="Enter adviser password" required>
                </div>
                <button type="submit" class="btn btn-primary">Sign In as Adviser</button>
            </form>
        </div>

        <div id="student-form" class="login-form">
            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <div class="form-group">
                    <label for="student-email">Email Address</label>
                    <input type="email" id="student-email" name="username" placeholder="Enter student email" required>
                </div>
                <div class="form-group">
                    <label for="student-password">Password</label>
                    <input type="password" id="student-password" name="password" placeholder="Enter student password" required>
                </div>
                <button type="submit" class="btn btn-primary">Sign In as Student</button>
            </form>
        </div>



        <div class="login-footer">
            <p>Don't have an account? <a href="/register">Contact Administrator</a></p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleButtons = document.querySelectorAll('.role-btn');
            const loginForms = document.querySelectorAll('.login-form');

            roleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const selectedRole = this.dataset.role;
                    
                    // Remove active class from all buttons
                    roleButtons.forEach(btn => btn.classList.remove('active'));
                    
                    // Add active class to clicked button
                    this.classList.add('active');
                    
                    // Hide all forms
                    loginForms.forEach(form => form.classList.remove('active'));
                    
                    // Show selected form
                    const selectedForm = document.getElementById(selectedRole + '-form');
                    if (selectedForm) {
                        selectedForm.classList.add('active');
                    }
                });
            });

            // Auto-select student role by default
            const studentButton = document.querySelector('[data-role="student"]');
            if (studentButton) {
                studentButton.click();
            }
        });
    </script>
</body>
</html>
>>>>>>> ba9aaa71bc9abfb6ff0b899eb0b1e7a9be6803ee
