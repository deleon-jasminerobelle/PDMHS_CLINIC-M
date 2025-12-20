<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - PDMHS</title>
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

        .register-container {
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

        .register-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: var(--gradient);
        }

        .register-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .register-header h1 {
            font-size: 32px;
            font-weight: 900;
            margin-bottom: 8px;
            background: linear-gradient(135deg, var(--dark) 0%, var(--primary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .register-header p {
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

        .form-group input, .form-group select {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid var(--light);
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: var(--white);
        }

        .form-group input:focus, .form-group select:focus {
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

        .register-footer {
            text-align: center;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid var(--light);
        }

        .register-footer p {
            color: var(--gray);
            font-size: 14px;
        }

        .register-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .register-footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .register-container {
                margin: 2rem;
                padding: 32px 24px;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <h1>Create Account</h1>
            <p>Join the PDMHS High School Clinic Management System</p>
        </div>

        <form method="POST" action="{{ route('register.post') }}">
            @csrf
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your full name" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password" required>
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="">Select your role</option>
                    <option value="admin">Admin</option>
                    <option value="clinic_staff">Clinic Staff</option>
                    <option value="adviser">Adviser</option>
                    <option value="student">Student</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">
                Create Account
            </button>
        </form>

        <div class="register-footer">
            <p>Already have an account? <a href="{{ route('login') }}">Sign In</a></p>
        </div>
    </div>
</body>
</html>
