<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PDMHS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
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

        /* Login Form */
        .login-container {
            background: var(--white);
            border-radius: 24px;
            padding: 48px;
            box-shadow: 0 32px 64px rgba(30, 64, 175, 0.15);
            border: 1px solid rgba(30, 64, 175, 0.1);
            width: 731px;
            height: 1024px;
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
            font-family: 'Albert Sans', sans-serif;
            font-size: 60px;
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
            font-family: 'Albert Sans', sans-serif;
            font-weight: 600;
            font-size: 25px;
            margin-bottom: 8px;
            color: var(--dark);
        }

        .form-group input {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid var(--light);
            border-radius: 20px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #e9ecef;
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
            border-radius: 20px;
            font-family: 'Albert Sans', sans-serif;
            font-size: 20px;
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
            display: none; /* Hidden by default */
        }

        .login-footer p {
            font-family: 'Albert Sans', sans-serif;
            color: var(--gray);
            font-size: 20px;
            font-weight: 600;
        }

        .login-footer a {
            font-family: 'Albert Sans', sans-serif;
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            font-size: 20px;
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
            border: 2px solid;
            animation: slideInDown 0.5s ease-out;
            position: relative;
            overflow: hidden;
        }

        .alert::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            animation: progressBar 3s ease-out;
        }

        .alert-success {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #065f46;
            border-color: #10b981;
        }

        .alert-success::before {
            background: #10b981;
        }

        .alert-error {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #991b1b;
            border-color: #ef4444;
            box-shadow: 0 8px 24px rgba(239, 68, 68, 0.2);
        }

        .alert-error::before {
            background: #ef4444;
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes progressBar {
            from {
                width: 100%;
            }
            to {
                width: 0%;
            }
        }

        .error-text {
            color: #ef4444;
            font-size: 12px;
            margin-top: 4px;
            display: block;
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Role Selection */
        .role-selection {
            margin-bottom: 32px;
        }

        .role-selection h3 {
            font-family: 'Albert Sans', sans-serif;
            font-size: 30px;
            font-weight: 800;
            margin-bottom: 16px;
            background: linear-gradient(135deg, var(--dark) 0%, var(--primary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
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
            font-family: 'Albert Sans', sans-serif;
            font-size: 20px;
            font-weight: 500;
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

            .login-container {
                margin: 2rem;
                padding: 32px 24px;
            }
        }

        /* Animation keyframes */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>Welcome Back</h1>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                <strong>✓ Success!</strong> {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                <strong>⚠ Login Failed!</strong>
                @foreach ($errors->all() as $error)
                    <br>• {{ $error }}
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
                    <input type="email" id="admin-email" name="username" placeholder="Enter admin email" 
                           value="{{ old('username') }}" required>
                    @error('username')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="admin-password">Password</label>
                    <input type="password" id="admin-password" name="password" placeholder="Enter admin password" required>
                    @error('password')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Sign In as Admin</button>
            </form>
        </div>

        <div id="clinic_staff-form" class="login-form">
            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <div class="form-group">
                    <label for="staff-email">Email Address</label>
                    <input type="email" id="staff-email" name="username" placeholder="Enter staff email" 
                           value="{{ old('username') }}" required>
                    @error('username')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="staff-password">Password</label>
                    <input type="password" id="staff-password" name="password" placeholder="Enter staff password" required>
                    @error('password')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Sign In as Clinic Staff</button>
            </form>
        </div>

        <div id="adviser-form" class="login-form">
            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <div class="form-group">
                    <label for="adviser-email">Email Address</label>
                    <input type="email" id="adviser-email" name="username" placeholder="Enter adviser email" 
                           value="{{ old('username') }}" required>
                    @error('username')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="adviser-password">Password</label>
                    <input type="password" id="adviser-password" name="password" placeholder="Enter adviser password" required>
                    @error('password')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Sign In as Adviser</button>
            </form>
        </div>

        <div id="student-form" class="login-form">
            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <div class="form-group">
                    <label for="student-email">Email Address</label>
                    <input type="email" id="student-email" name="username" placeholder="Enter student email" 
                           value="{{ old('username') }}" required>
                    @error('username')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="student-password">Password</label>
                    <input type="password" id="student-password" name="password" placeholder="Enter student password" required>
                    @error('password')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Sign In as Student</button>
            </form>
        </div>

        <div class="login-footer">
            <p>Don't have an account? <a href="{{ route('register') }}">Sign up first</a></p>
            <p><a href="#" style="font-style: italic; text-decoration: underline;">I forgot my password</a></p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleButtons = document.querySelectorAll('.role-btn');
            const loginForms = document.querySelectorAll('.login-form');

            // Store original button texts
            const buttonTexts = {
                'admin-form': 'Sign In as Admin',
                'clinic_staff-form': 'Sign In as Clinic Staff', 
                'adviser-form': 'Sign In as Adviser',
                'student-form': 'Sign In as Student'
            };

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
                        
                        // Reset button text when switching forms
                        const submitBtn = selectedForm.querySelector('.btn-primary');
                        if (submitBtn && buttonTexts[selectedRole + '-form']) {
                            submitBtn.innerHTML = buttonTexts[selectedRole + '-form'];
                            submitBtn.disabled = false;
                        }
                    }
                    
                    // Show login footer when role is selected
                    const loginFooter = document.querySelector('.login-footer');
                    if (loginFooter) {
                        loginFooter.style.display = 'block';
                    }
                });
            });

            // Auto-dismiss alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-20px)';
                    setTimeout(() => {
                        alert.remove();
                    }, 300);
                }, 5000);
            });

            // Add shake animation to form on error
            const errorAlert = document.querySelector('.alert-error');
            if (errorAlert) {
                const activeForm = document.querySelector('.login-form.active');
                if (activeForm) {
                    activeForm.style.animation = 'shake 0.5s ease-in-out';
                    setTimeout(() => {
                        activeForm.style.animation = '';
                    }, 500);
                }
            }

            // Add form validation feedback with proper reset
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                const submitBtn = form.querySelector('.btn-primary');
                const formId = form.parentElement.id;
                const originalText = buttonTexts[formId] || 'Sign In';
                
                // Ensure button starts with correct text
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                
                form.addEventListener('submit', function(e) {
                    // Only show loading if form inputs are filled
                    const emailInput = form.querySelector('input[name="username"]');
                    const passwordInput = form.querySelector('input[name="password"]');
                    
                    if (emailInput.value.trim() && passwordInput.value.trim()) {
                        submitBtn.innerHTML = '<span style="display: inline-block; width: 16px; height: 16px; border: 2px solid #ffffff; border-top: 2px solid transparent; border-radius: 50%; animation: spin 1s linear infinite; margin-right: 8px;"></span>Signing In...';
                        submitBtn.disabled = true;
                        
                        // Reset button after 8 seconds as fallback (in case of network issues)
                        setTimeout(() => {
                            submitBtn.innerHTML = originalText;
                            submitBtn.disabled = false;
                        }, 8000);
                    }
                });
            });

            // Reset all buttons on page load (in case of refresh after error)
            Object.keys(buttonTexts).forEach(formId => {
                const form = document.getElementById(formId);
                if (form) {
                    const submitBtn = form.querySelector('.btn-primary');
                    if (submitBtn) {
                        submitBtn.innerHTML = buttonTexts[formId];
                        submitBtn.disabled = false;
                    }
                }
            });
        });
    </script>
</body>
</html>