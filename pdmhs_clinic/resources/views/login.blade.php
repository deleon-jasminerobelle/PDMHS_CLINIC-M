<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PDMHS</title>
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary: #1877f2;
            --primary-dark: #166fe5;
            --secondary: #42a5f5;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #42a5f5;
            --light: #f3f4f6;
            --dark: #1f2937;
            --gradient: linear-gradient(135deg, #1877f2 0%, #42a5f5 100%);
            --gray: #64748b;
            --gray-light: #f8fafc;
            --white: #ffffff;
            --gradient-subtle: linear-gradient(135deg, #eff6ff 0%, #dbe9ff 100%);
            --shadow-blue: rgba(24, 119, 242, 0.1);
            --shadow-blue-light: rgba(24, 119, 242, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--gradient);
            min-height: 100vh;
            padding-bottom: 2rem;
        }
    </style>
    <style>
        .gradient-bg { background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); }
        .gradient-text { background: linear-gradient(135deg, #0f172a 0%, #1e40af 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .login-container::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 5px; background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); }
        @keyframes shake { 0%, 100% { transform: translateX(0); } 10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); } 20%, 40%, 60%, 80% { transform: translateX(5px); } }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        @keyframes slideInDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes progressBar { from { width: 100%; } to { width: 0%; } }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-10px); } }
        @keyframes pulse { 0%, 100% { opacity: 1; transform: scale(1); } 50% { opacity: 0.8; transform: scale(1.05); } }
        @keyframes slideIn { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
        @keyframes glow { 0%, 100% { box-shadow: 0 0 20px rgba(79, 70, 229, 0.3); } 50% { box-shadow: 0 0 40px rgba(79, 70, 229, 0.6); } }
        @keyframes bounce { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        
        body {
            position: relative;
            overflow-x: hidden;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 20%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
            animation: float 8s ease-in-out infinite;
            pointer-events: none;
            z-index: 0;
        }
        
        .login-container {
            animation: slideIn 0.6s ease-out;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.98);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        
        .login-container::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(79, 70, 229, 0.08) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
            pointer-events: none;
        }
        
        .alert { animation: slideInDown 0.5s ease-out; position: relative; overflow: hidden; }
        .alert::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; animation: progressBar 3s linear; }
        .alert-success { background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: #065f46; border-color: #10b981; }
        .alert-success::before { background: #10b981; }
        .alert-error { background: linear-gradient(135deg, #fee2e2, #fecaca); color: #991b1b; border-color: #ef4444; box-shadow: 0 8px 24px rgba(239, 68, 68, 0.2); }
        .alert-error::before { background: #ef4444; }
        .error-text { color: #ef4444; font-size: 12px; margin-top: 4px; display: block; animation: fadeIn 0.3s ease-out; }
        
        .role-btn {
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .role-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(79, 70, 229, 0.15);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .role-btn:hover::before {
            width: 300px;
            height: 300px;
        }
        
        .role-btn.active, .role-btn:hover { 
            border-color: #4f46e5; 
            background: linear-gradient(135deg, rgba(238, 242, 255, 0.9), rgba(224, 231, 255, 1)); 
            color: #4f46e5; 
            transform: translateY(-8px) scale(1.05); 
            box-shadow: 0 20px 50px rgba(79, 70, 229, 0.35); 
            animation: glow 2s ease-in-out infinite;
        }
        
        .role-btn .role-icon { 
            filter: grayscale(0.3); 
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); 
        }
        
        .role-btn:hover .role-icon, .role-btn.active .role-icon { 
            filter: grayscale(0) drop-shadow(0 6px 12px rgba(79, 70, 229, 0.4)); 
            transform: scale(1.3) rotate(8deg); 
            animation: bounce 0.6s ease-in-out;
        }
        
        .input-field {
            transition: all 0.3s ease;
            position: relative;
        }
        
        .input-field:focus {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.2);
            border-color: #4f46e5;
        }
        
        .btn-primary {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.5s;
        }
        
        .btn-primary:hover::before {
            left: 100%;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 15px 40px rgba(79, 70, 229, 0.5);
            animation: pulse 1.5s ease-in-out infinite;
        }
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(79, 70, 229, 0.4);
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }
    </style>
</head>
<body style="font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; color: var(--dark); min-height: 100vh; display: flex; align-items: center; justify-content: center; overflow-x: hidden;">
<div style="background: var(--white); border-radius: 20px; box-shadow: 0 32px 64px var(--shadow-blue); border: 1px solid var(--shadow-blue-light); padding: 48px; width: 800px; position: relative; min-height: fit-content; margin: 2rem auto;" class="login-container">
    <div style="position: absolute; top: 0; left: 0; right: 0; height: 5px; background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);"></div>

    <div style="text-align: center; margin-bottom: 2rem;">
        <h1 style="color: var(--primary); font-size: 40px; font-weight: 900; margin-bottom: 0.5rem;">Welcome Back</h1>
        <p style="color: #64748b; font-size: 16px; font-weight: 800; font-family: 'Albert Sans', sans-serif;">Sign in to your PDMHS account</p>
    </div>

    @if (session('success'))
        <div style="background: #f0fdf4; border-left: 4px solid #4ade80; padding: 1rem 1.5rem; margin-bottom: 1.5rem; border-radius: 0 0.5rem 0.5rem 0; animation: slideInDown 0.5s ease-out;">
            <div style="display: flex;">
                <div style="flex-shrink: 0;">
                    <svg style="height: 1.25rem; width: 1.25rem; color: #4ade80;" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div style="margin-left: 0.75rem;">
                    <p style="font-size: 0.875rem; color: #047857;">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div style="background: #fef2f2; border-left: 4px solid #f87171; padding: 1rem 1.5rem; margin-bottom: 1.5rem; border-radius: 0 0.5rem 0.5rem 0; animation: slideInDown 0.5s ease-out;">
            <div style="display: flex;">
                <div style="flex-shrink: 0;">
                    <svg style="height: 1.25rem; width: 1.25rem; color: #f87171;" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div style="margin-left: 0.75rem;">
                    <h3 style="font-size: 0.875rem; font-weight: 500; color: #991b1b;">Login Failed</h3>
                    <div style="margin-top: 0.5rem; font-size: 0.875rem; color: #b91c1c;">
                        <ul style="list-style-type: disc; padding-left: 1.25rem;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Role Selection -->
    <div style="margin-bottom: 1.5rem;">
        <h3 style="font-size: 1.25rem; font-weight: 600; color: #374151; margin-bottom: 1.25rem; text-align: center; font-family: 'Albert Sans', sans-serif;">Select Your Role</h3>
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem;">
            <button type="button" class="role-btn" style="padding: 1.25rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; background: white; cursor: pointer; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); text-align: center;" data-role="clinic_staff">
                <div style="margin-bottom: 0.75rem; display: flex; justify-content: center;">
                    <div style="width: 3rem; height: 3rem; background: linear-gradient(135deg, #10b981, #34d399); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: white; animation: pulse 2s infinite;">🏥</div>
                </div>
                <div class="role-name" style="font-weight: 600; color: #374151; font-size: 20px; font-family: 'Albert Sans', sans-serif;">Clinic Staff</div>
            </button>
            <button type="button" class="role-btn" style="padding: 1.25rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; background: white; cursor: pointer; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); text-align: center;" data-role="student">
                <div style="margin-bottom: 0.75rem; display: flex; justify-content: center;">
                    <img src="{{ asset('assets/student.png') }}" alt="Student" style="width: 3rem; height: 3rem;" class="role-icon">
                </div>
                <div class="role-name" style="font-weight: 600; color: #374151; font-size: 20px; font-family: 'Albert Sans', sans-serif;">Student</div>
            </button>
            <button type="button" class="role-btn" style="padding: 1.25rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; background: white; cursor: pointer; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); text-align: center;" data-role="adviser">
                <div style="margin-bottom: 0.75rem; display: flex; justify-content: center;">
                    <div style="width: 3rem; height: 3rem; background: linear-gradient(135deg, #f59e0b, #fbbf24); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: white; animation: pulse 2s infinite;">👨‍🏫</div>
                </div>
                <div class="role-name" style="font-weight: 600; color: #374151; font-size: 20px; font-family: 'Albert Sans', sans-serif;">Adviser</div>
            </button>
        </div>
    </div>

    <!-- Login Form -->
    <form method="POST" action="{{ route('login.post') }}" style="display: flex; flex-direction: column; gap: 1.5rem;" class="login-form">
        @csrf
        <input type="hidden" name="role" id="role" value="">
        <div>
            <label for="username" style="display: block; font-size: 20px; font-weight: 600; color: #374151; margin-bottom: 8px; font-family: 'Albert Sans', sans-serif;">Email Address</label>
            <input type="email" id="username" name="username" value="{{ old('username') }}" required
                   style="width: 100%; padding: 0.875rem 1rem; font-size: 1rem; border: 1px solid #d1d5db; border-radius: 0.5rem; transition: all 0.3s ease; background: #ffffff; font-family: 'Albert Sans', sans-serif;"
                   placeholder="Enter your email">
            @error('username')
                <p style="margin-top: 0.25rem; font-size: 0.875rem; color: #dc2626;">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" style="display: block; font-size: 20px; font-weight: 600; color: #374151; margin-bottom: 8px; font-family: 'Albert Sans', sans-serif;">Password</label>
            <input type="password" id="password" name="password" required
                   style="width: 100%; padding: 0.875rem 1rem; font-size: 1rem; border: 1px solid #d1d5db; border-radius: 0.5rem; transition: all 0.3s ease; background: #ffffff; font-family: 'Albert Sans', sans-serif;"
                   placeholder="Enter your password">
            @error('password')
                <p style="margin-top: 0.25rem; font-size: 0.875rem; color: #dc2626;">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn-primary" style="width: 100%; color: white; font-weight: 600; padding: 0.875rem 1rem; font-size: 1rem; border: none; border-radius: 0.5rem; cursor: pointer; transition: all 0.3s ease; background: #1877f2; box-shadow: 0 8px 24px rgba(24, 119, 242, 0.3);">
            Sign In
        </button>
    </form>

    <div class="mt-6 text-center space-y-2">
        <p class="text-sm text-slate-600">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-medium">Sign up first</a>
        </p>
        <p class="text-sm">
            <a href="#" class="text-slate-500 hover:text-slate-700 italic underline">I forgot my password</a>
        </p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleButtons = document.querySelectorAll('.role-btn');
    const formElement = document.querySelector('.login-form');
    const submitBtn = document.querySelector('.btn-primary');
    const originalText = submitBtn.innerHTML;

    // Role selection
    roleButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const role = this.dataset.role;
            roleButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            submitBtn.innerHTML = `Sign In as ${this.querySelector('.role-name').textContent}`;
        });
    });

    // Form submission with role
    formElement.addEventListener('submit', function(e){
        const activeRoleBtn = document.querySelector('.role-btn.active');
        if(!activeRoleBtn){
            e.preventDefault();
            alert('Please select a role first.');
            return;
        }

        const email = formElement.querySelector('input[name="username"]');
        const password = formElement.querySelector('input[name="password"]');
        if(email.value.trim() && password.value.trim()){
            const roleInput = formElement.querySelector('input[name="role"]');
            roleInput.value = activeRoleBtn.dataset.role;

            // Loading spinner
            submitBtn.innerHTML = '<span style="display:inline-block;width:16px;height:16px;border:2px solid #fff;border-top:2px solid transparent;border-radius:50%;animation:spin 1s linear infinite;margin-right:8px;"></span>Signing In...';
            submitBtn.disabled = true;
            setTimeout(()=>{ submitBtn.innerHTML=originalText; submitBtn.disabled=false; },8000);
        }
    });

    // Alerts auto-dismiss
    document.querySelectorAll('.alert').forEach(alert => { setTimeout(()=>{ alert.remove(); },5000); });

    // Shake on error
    const errorAlert = document.querySelector('.alert-error');
    if(errorAlert){
        formElement.style.animation='shake 0.5s ease-in-out';
        setTimeout(()=>{ formElement.style.animation=''; },500);
    }
});
</script>
</body>
</html>

