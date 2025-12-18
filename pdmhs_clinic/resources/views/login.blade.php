<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PDMHS</title>
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
            max-width: 400px;
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
                <li><a href="/">Home</a></li>
                <li><a href="/features">Features</a></li>
                <li><a href="/architecture">Architecture</a></li>
                <li><a href="/scanner">Scanner</a></li>
                <li><a href="/login" class="active">Login</a></li>
                <li><a href="/dashboard">Dashboard</a></li>
            </ul>
        </div>
    </nav>

    <div class="login-container">
        <div class="login-header">
            <h1>Welcome Back</h1>
            <p>Sign in to access the PDMHS High School Clinic Management System</p>
        </div>

        <form method="POST" action="/login">
            @csrf
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>

            <button type="submit" class="btn btn-primary">
                Sign In
            </button>

            <a href="/dashboard" class="btn btn-secondary">
                Continue as Guest
            </a>
        </form>

        <div class="login-footer">
            <p>Don't have an account? <a href="/register">Contact Administrator</a></p>
        </div>
    </div>
</body>
</html>
