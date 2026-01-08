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
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1e40af',
                        'primary-dark': '#1e3a8a',
                        secondary: '#3b82f6',
                        accent: '#60a5fa',
                        dark: '#0f172a',
                        gray: '#64748b',
                        light: '#f1f5f9',
                        success: '#10b981',
                        warning: '#f59e0b',
                    },
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                        'albert': ['Albert Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
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
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }
        @keyframes slideIn { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
        
        .login-container {
            animation: slideIn 0.6s ease-out;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            position: relative;
            overflow: hidden;
        }
        
        .login-container::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(79, 70, 229, 0.05) 0%, transparent 70%);
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
            background: rgba(79, 70, 229, 0.1);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .role-btn:hover::before {
            width: 300px;
            height: 300px;
        }
        
        .role-btn.active, .role-btn:hover { 
            border-color: #4f46e5; 
            background: linear-gradient(135deg, rgba(238, 242, 255, 0.8), rgba(224, 231, 255, 0.9)); 
            color: #4f46e5; 
            transform: translateY(-5px) scale(1.02); 
            box-shadow: 0 15px 40px rgba(79, 70, 229, 0.25); 
        }
        
        .role-btn .role-icon { 
            filter: grayscale(0.3); 
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); 
        }
        
        .role-btn:hover .role-icon, .role-btn.active .role-icon { 
            filter: grayscale(0) drop-shadow(0 4px 8px rgba(79, 70, 229, 0.3)); 
            transform: scale(1.2) rotate(5deg); 
        }
        
        .input-field {
            transition: all 0.3s ease;
            position: relative;
        }
        
        .input-field:focus {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.15);
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
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }
        
        .btn-primary:hover::before {
            left: 100%;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(79, 70, 229, 0.4);
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }
    </style>
</head>
<body class="font-poppins text-slate-900 min-h-screen flex items-center justify-center overflow-x-hidden" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
<div class="bg-white rounded-2xl shadow-2xl p-12 w-full relative login-container" style="max-width: 700px; min-height: 800px;">
    <div class="absolute top-0 left-0 right-0 h-1 rounded-t-2xl" style="background: linear-gradient(90deg, #4f46e5, #7c3aed, #4f46e5); background-size: 200% 100%; animation: shimmer 3s linear infinite;"></div>

    <div class="text-center mb-8">
        <h1 class="font-albert font-bold mb-2" style="color: #4f46e5; font-size: 40px;">Welcome Back</h1>
        <p class="text-slate-600 text-base">Sign in to your PDMHS account</p>
    </div>

    @if (session('success'))
        <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-r-lg animate-slideInDown">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-r-lg animate-slideInDown">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Login Failed</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul role="list" class="list-disc pl-5 space-y-1">
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
    <div class="mb-6">
        <h3 class="text-xl font-semibold text-slate-700 mb-5 text-center">Select Your Role</h3>
        <div class="grid grid-cols-3 gap-4">
            <button type="button" class="role-btn p-5 border-2 border-slate-200 rounded-xl hover:border-blue-600 hover:bg-blue-50 transition-all duration-300 text-center" data-role="clinic_staff">
                <div class="mb-3 flex justify-center">
                    <img src="{{ asset('assets/medical.png') }}" alt="Clinic Staff" class="w-12 h-12 role-icon">
                </div>
                <div class="role-name font-semibold text-slate-700" style="font-size: 20px;">Clinic Staff</div>
            </button>
            <button type="button" class="role-btn p-5 border-2 border-slate-200 rounded-xl hover:border-blue-600 hover:bg-blue-50 transition-all duration-300 text-center" data-role="student">
                <div class="mb-3 flex justify-center">
                    <img src="{{ asset('assets/student.png') }}" alt="Student" class="w-12 h-12 role-icon">
                </div>
                <div class="role-name font-semibold text-slate-700" style="font-size: 20px;">Student</div>
            </button>
            <button type="button" class="role-btn p-5 border-2 border-slate-200 rounded-xl hover:border-blue-600 hover:bg-blue-50 transition-all duration-300 text-center" data-role="adviser">
                <div class="mb-3 flex justify-center">
                    <img src="{{ asset('assets/teacher.png') }}" alt="Adviser" class="w-12 h-12 role-icon">
                </div>
                <div class="role-name font-semibold text-slate-700" style="font-size: 20px;">Adviser</div>
            </button>
        </div>
    </div>

    <!-- Login Form -->
    <form method="POST" action="{{ route('login.post') }}" class="space-y-6 login-form">
        @csrf
        <input type="hidden" name="role" id="role" value="">
        <div>
            <label for="username" class="block text-base font-medium text-slate-700 mb-2">Email Address</label>
            <input type="email" id="username" name="username" value="{{ old('username') }}" required
                   class="input-field w-full px-4 py-3.5 text-base border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                   placeholder="Enter your email">
            @error('username')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-base font-medium text-slate-700 mb-2">Password</label>
            <input type="password" id="password" name="password" required
                   class="input-field w-full px-4 py-3.5 text-base border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                   placeholder="Enter your password">
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="w-full text-white font-semibold py-3.5 px-4 text-base rounded-lg transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 btn-primary" style="background: #4f46e5; box-shadow: 0 8px 24px rgba(79, 70, 229, 0.3);">
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

