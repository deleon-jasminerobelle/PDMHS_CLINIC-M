<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profile - PDMHS Clinic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1e40af;
            --primary-dark: #1e3a8a;
            --secondary: #3b82f6;
            --gradient: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        }
        
        .navbar.bg-primary {
            background: var(--gradient) !important;
            padding: 1rem 0 !important;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }
        
        .profile-header {
            background: var(--gradient);
            color: white;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        
        .profile-avatar {
            width: 100px;
            height: 100px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        
        .section-card {
            background: white;
            border-radius: 12px;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        
        .section-header {
            padding: 1.5rem;
            border-bottom: 1px solid #eee;
            font-weight: 600;
            color: #6c757d;
        }
        
        .section-header h5 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 24px;
            margin-bottom: 0;
            color: var(--primary);
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 16px;
            margin-bottom: 0.5rem;
            color: #2c3e50;
        }
        
        .form-control {
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            border-radius: 8px;
            border: 2px solid #e9ecef;
            padding: 0.75rem 1rem;
            transition: all 0.2s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(30, 64, 175, 0.25);
        }
        
        .btn-primary {
            background: var(--gradient);
            border: none;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.4);
        }
        
        .btn-danger {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            padding: 0.75rem 2rem;
            border-radius: 8px;
        }
        
        .navbar-brand {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
        }
        
        .welcome-header {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: 35px;
        }
        
        .btn-back {
            background: var(--gradient);
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        
        .btn-back:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.4);
            color: white;
        }
        
        .alert {
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('adviser.dashboard') }}">
                <i class="fas fa-heartbeat me-2"></i>
                PDMHS Clinic
            </a>
            <div class="navbar-nav ms-auto">
                <a href="{{ route('adviser.dashboard') }}" class="btn btn-back">
                    <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Error!</strong> Please check the form for errors.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Profile Header -->
        <div class="profile-header">
            <div class="row align-items-center">
                <div class="col-md-2 text-center">
                    <div class="profile-avatar mx-auto">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
                <div class="col-md-10">
                    <h1 class="welcome-header mb-2">{{ $user->name }}</h1>
                    <p class="mb-1"><i class="fas fa-envelope me-2"></i>{{ $user->email }}</p>
                    <p class="mb-0"><i class="fas fa-chalkboard-teacher me-2"></i>{{ ucfirst(str_replace('_', ' ', $user->role)) }}
                        @if($user->isAdviser() && $user->adviser && $user->adviser->students->count() > 0)
                            - {{ $user->adviser->students->count() }} Students
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Profile Information -->
            <div class="col-md-8">
                <div class="section-card">
                    <div class="section-header">
                        <h5><i class="fas fa-user me-2"></i>Profile Information</h5>
                    </div>
                    <div class="p-4">
                        <form method="POST" action="{{ route('adviser.profile.update') }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first_name">First Name</label>
                                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                               id="first_name" name="first_name" 
                                               value="{{ old('first_name', $user->first_name) }}" required>
                                        @error('first_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name">Last Name</label>
                                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                               id="last_name" name="last_name" 
                                               value="{{ old('last_name', $user->last_name) }}" required>
                                        @error('last_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="middle_name">Middle Name</label>
                                <input type="text" class="form-control @error('middle_name') is-invalid @enderror" 
                                       id="middle_name" name="middle_name" 
                                       value="{{ old('middle_name', $user->middle_name) }}">
                                @error('middle_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="birthday">Birthday</label>
                                        <input type="date" class="form-control @error('birthday') is-invalid @enderror" 
                                               id="birthday" name="birthday" 
                                               value="{{ old('birthday', $user->birthday) }}" required>
                                        @error('birthday')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gender">Gender</label>
                                        <select class="form-control @error('gender') is-invalid @enderror" 
                                                id="gender" name="gender" required>
                                            <option value="">Select Gender</option>
                                            <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                        </select>
                                        @error('gender')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" 
                                          id="address" name="address" rows="3" required>{{ old('address', $user->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact_number">Contact Number</label>
                                        <input type="tel" class="form-control @error('contact_number') is-invalid @enderror" 
                                               id="contact_number" name="contact_number" 
                                               value="{{ old('contact_number', $user->contact_number) }}" required>
                                        @error('contact_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email Address</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                               id="email" name="email" 
                                               value="{{ old('email', $user->email) }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Update Profile
                                </button>
                            </div>
                        </form>
                    </div>
                </div>


            </div>

            <!-- Change Password -->
            <div class="col-md-4">
                <div class="section-card">
                    <div class="section-header">
                        <h5><i class="fas fa-lock me-2"></i>Change Password</h5>
                    </div>
                    <div class="p-4">
                        <form method="POST" action="{{ route('adviser.password.update') }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-group">
                                <label for="current_password">Current Password</label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                       id="current_password" name="current_password" required>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Confirm New Password</label>
                                <input type="password" class="form-control" 
                                       id="password_confirmation" name="password_confirmation" required>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-key me-1"></i> Change Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-dismiss alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>
</body>
</html>