<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profile Settings - Clinic Staff Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --secondary: #06b6d4;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            --light: #f3f4f6;
            --dark: #1f2937;
            --gradient: #2196F3;
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

        /* Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .navbar-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            font-family: 'Albert Sans', sans-serif;
            font-size: 20px;
            font-weight: 500;
            color: var(--primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar-menu {
            display: flex;
            gap: 2rem;
            align-items: center;
            list-style: none;
        }

        .nav-link {
            font-family: 'Albert Sans', sans-serif;
            font-size: 20px;
            font-weight: 700;
            color: var(--dark);
            text-decoration: none;
            transition: all 0.3s ease;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-link:hover, .nav-link.active {
            background: #2196F3;
            color: white;
            transform: translateY(-2px);
        }

        .user-dropdown {
            position: relative;
        }

        .user-btn {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            background: white;
            border: 2px solid var(--light);
            border-radius: 2rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .user-btn:hover {
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary);
        }

        .user-avatar-default {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .dropdown-menu {
            position: absolute;
            top: 120%;
            right: 0;
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            min-width: 200px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        .dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            padding: 0.75rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--dark);
            text-decoration: none;
            transition: all 0.2s ease;
            border-bottom: 1px solid var(--light);
        }

        .dropdown-item:last-child {
            border-bottom: none;
        }

        .dropdown-item:hover {
            background: var(--light);
        }

        /* Main Container */
        .container {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 2rem;
        }
        
        .profile-container {
            max-width: 1000px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        
        .profile-header {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(220, 220, 250, 0.95) 100%);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        
        .profile-title {
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 0.5rem;
            font-family: 'Albert Sans', sans-serif;
            font-size: 32px;
        }
        
        .profile-subtitle {
            color: #6c757d;
            margin-bottom: 0;
            font-family: 'Albert Sans', sans-serif;
            font-size: 20px;
            font-weight: 700;
        }
        
        .profile-section {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(220, 220, 250, 0.95) 100%);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        
        .section-title {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e9ecef;
            font-family: 'Albert Sans', sans-serif;
            font-size: 30px;
        }
        
        .profile-photo-section {
            display: flex;
            align-items: center;
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .profile-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #e9ecef;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: #6c757d;
        }
        
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
        }
        
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(30, 64, 175, 0.25);
        }
        
        .btn-primary {
            background: #2196F3 !important;
            border: none;
            border-radius: 10px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.4);
        }
        
        .btn-outline-secondary {
            background: #2196F3 !important;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.4);
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
            border: none;
            border-radius: 10px;
            padding: 0.75rem 2rem;
            font-weight: 600;
        }
        
        .alert {
            border-radius: 10px;
            border: none;
            padding: 1rem 1.5rem;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .modal-footer {
            display: flex !important;
            flex-direction: row !important;
            justify-content: space-between !important;
            align-items: center !important;
            gap: 0.5rem;
            padding: 1rem 1.5rem !important;
            border-top: 1px solid #dee2e6;
            background: white;
            border-radius: 0 0 15px 15px;
            flex-shrink: 0;
        }
        
        .modal-footer .btn {
            display: inline-block !important;
            visibility: visible !important;
            margin: 0 !important;
            padding: 0.5rem 1rem !important;
            font-size: 14px;
            min-width: 140px;
            text-align: center;
        }
        
        .modal-footer .btn-secondary {
            background: #6c757d !important;
            border: none !important;
        }
        
        .modal-footer .btn-secondary:hover {
            background: #5a6268 !important;
        }
        
        .modal-body {
            max-height: 400px;
            overflow-y: auto;
            padding: 1.5rem;
        }
        
        .modal-dialog {
            max-width: 450px;
            margin: 3rem auto;
        }
        
        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            max-height: 90vh;
            display: flex;
            flex-direction: column;
        }
        
        .modal-header {
            border-bottom: 1px solid #dee2e6;
            padding: 1rem 1.5rem;
            background: white;
            border-radius: 15px 15px 0 0;
            flex-shrink: 0;
        }
        
        .modal-title {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 600;
            font-size: 20px;
            color: var(--dark);
        }
        
        .modal-body .mb-3 {
            margin-bottom: 1rem !important;
        }
        
        .modal-body .form-label {
            font-size: 14px;
            margin-bottom: 0.25rem;
        }
        
        .modal-body .form-control {
            padding: 0.5rem 0.75rem;
            font-size: 14px;
        }
        
        .row.g-3 > .col-md-6 {
            margin-bottom: 1rem;
        }
        
        .user-avatar {
            background: var(--gradient);
            color: white;
        }
        
        @media (max-width: 768px) {
            .profile-photo-section {
                flex-direction: column;
                text-align: center;
            }
            
            .profile-container {
                margin: 1rem auto;
                padding: 0 0.5rem;
            }
            
            .profile-section {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a class="navbar-brand" href="{{ route('clinic-staff.dashboard') }}">
                <img src="{{ asset('logo.jpg') }}" alt="PDMHS Logo" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                PDMHS Clinic
            </a>
            <ul class="navbar-menu">
                <li><a class="nav-link" href="{{ route('clinic-staff.dashboard') }}"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
                <li><a class="nav-link" href="{{ route('clinic-staff.students') }}"><i class="fas fa-users"></i>Students</a></li>
                <li><a class="nav-link" href="{{ route('clinic-staff.visits') }}"><i class="fas fa-calendar-check"></i>Visits</a></li>
                <li><a class="nav-link" href="{{ route('scanner') }}"><i class="fas fa-qrcode"></i>Scanner</a></li>
                <li><a class="nav-link" href="{{ route('clinic-staff.reports') }}"><i class="fas fa-chart-bar"></i>Reports</a></li>
            </ul>
            <div class="user-dropdown">
                <button class="user-btn" onclick="toggleDropdown()">
                    @if($user->profile_picture && file_exists(public_path($user->profile_picture)))
                        <img src="{{ asset($user->profile_picture) }}" alt="Profile" class="user-avatar">
                    @else
                        <div class="user-avatar-default">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif
                    <span>{{ $user->name }}</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="dropdown-menu" id="userDropdown">
                    <a class="dropdown-item" href="{{ route('clinic-staff.profile') }}">
                        <i class="fas fa-user-edit"></i>
                        Profile
                    </a>
                    <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hidden logout form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <div class="profile-container">
        <!-- Profile Header -->
        <div class="profile-header">
            <h1 class="profile-title">Profile Settings</h1>
            <p class="profile-subtitle">Manage your account information</p>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Validation Errors:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Profile Information Section -->
        <div class="profile-section">
            <div class="profile-photo-section">
                <div class="profile-photo user-avatar" id="profilePhotoContainer">
                    @if($user->profile_picture)
                        <img src="{{ asset($user->profile_picture) }}" alt="Profile Picture" class="profile-photo" id="profileImage">
                    @else
                        <i class="fas fa-user" id="profileIcon"></i>
                    @endif
                </div>
                <div>
                    <input type="file" id="profilePictureInput" accept="image/*" style="display: none;">
                    <button type="button" class="btn btn-outline-secondary" onclick="document.getElementById('profilePictureInput').click()">
                        <i class="fas fa-camera me-2"></i>Change Photo
                    </button>
                </div>
            </div>

            <form action="{{ route('clinic-staff.profile-update') }}" method="POST" id="profileForm">
                @csrf
                @method('PUT')
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $user->name) }}" required readonly>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="position" class="form-label">Position</label>
                        <input type="text" class="form-control @error('position') is-invalid @enderror" 
                               id="position" name="position" value="{{ old('position', $user->position ?? '') }}" 
                               placeholder="e.g., Nurse, Doctor, Medical Assistant" readonly>
                        @error('position')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', $user->email) }}" required readonly>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control @error('phone_number') is-invalid @enderror" 
                               id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number ?? '') }}" 
                               placeholder="e.g., +63 912 345 6789" readonly>
                        @error('phone_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <label for="staff_code" class="form-label">Staff Code</label>
                        <input type="text" class="form-control @error('staff_code') is-invalid @enderror" 
                               id="staff_code" name="staff_code" value="{{ old('staff_code', $user->staff_code ?? '') }}" 
                               placeholder="e.g., SC001" readonly>
                        @error('staff_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <button type="button" class="btn btn-primary" id="editBtn">
                        <i class="fas fa-edit me-2"></i>Edit Profile
                    </button>
                    <button type="submit" class="btn btn-primary d-none" id="saveBtn">
                        <i class="fas fa-save me-2"></i>Save Changes
                    </button>
                    <button type="button" class="btn btn-secondary d-none" id="cancelBtn">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                </div>
            </form>
        </div>

        <!-- Account Settings Section -->
        <div class="profile-section">
            <h3 class="section-title">Account Settings</h3>
            
            <div class="row">
                <div class="col-md-6">
                    <h5>Change Password</h5>
                    <p class="text-muted">Create your account password</p>
                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                        <i class="fas fa-key me-2"></i>Change
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('clinic-staff.password-update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                   id="current_password" name="current_password" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required minlength="8">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" required minlength="8">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Edit mode functionality
        let originalValues = {};
        
        document.getElementById('editBtn').addEventListener('click', function() {
            // Store original values
            const inputs = document.querySelectorAll('#profileForm input[type="text"], #profileForm input[type="email"], #profileForm input[type="tel"]');
            inputs.forEach(input => {
                originalValues[input.id] = input.value;
                input.removeAttribute('readonly');
                input.classList.add('border-primary');
            });
            
            // Toggle buttons
            document.getElementById('editBtn').classList.add('d-none');
            document.getElementById('saveBtn').classList.remove('d-none');
            document.getElementById('cancelBtn').classList.remove('d-none');
        });
        
        document.getElementById('cancelBtn').addEventListener('click', function() {
            // Restore original values
            const inputs = document.querySelectorAll('#profileForm input[type="text"], #profileForm input[type="email"], #profileForm input[type="tel"]');
            inputs.forEach(input => {
                input.value = originalValues[input.id];
                input.setAttribute('readonly', true);
                input.classList.remove('border-primary');
            });
            
            // Toggle buttons
            document.getElementById('editBtn').classList.remove('d-none');
            document.getElementById('saveBtn').classList.add('d-none');
            document.getElementById('cancelBtn').classList.add('d-none');
            
            // Clear original values
            originalValues = {};
        });

        // Profile picture upload functionality
        document.getElementById('profilePictureInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            // Validate file type
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
            if (!allowedTypes.includes(file.type)) {
                alert('Please select a valid image file (JPEG, PNG, JPG, GIF)');
                return;
            }

            // Validate file size (5MB max)
            if (file.size > 5 * 1024 * 1024) {
                alert('File size must be less than 5MB');
                return;
            }

            // Show loading state
            const changePhotoBtn = document.querySelector('.btn-outline-secondary');
            const originalText = changePhotoBtn.innerHTML;
            changePhotoBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Uploading...';
            changePhotoBtn.disabled = true;

            // Create FormData and upload
            const formData = new FormData();
            formData.append('profile_picture', file);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            fetch('{{ route("clinic-staff.upload-profile-picture") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update profile picture display
                    const profileContainer = document.getElementById('profilePhotoContainer');
                    profileContainer.innerHTML = `<img src="${data.profile_picture_url}" alt="Profile Picture" class="profile-photo" id="profileImage">`;
                    
                    // Show success message
                    showAlert('success', data.message);
                } else {
                    showAlert('danger', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('danger', 'An error occurred while uploading the profile picture.');
            })
            .finally(() => {
                // Reset button state
                changePhotoBtn.innerHTML = originalText;
                changePhotoBtn.disabled = false;
                // Clear file input
                e.target.value = '';
            });
        });

        // Function to show alert messages
        function showAlert(type, message) {
            const alertContainer = document.querySelector('.profile-container');
            const alertHtml = `
                <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            
            // Remove existing alerts
            const existingAlerts = alertContainer.querySelectorAll('.alert');
            existingAlerts.forEach(alert => alert.remove());
            
            // Add new alert after profile header
            const profileHeader = document.querySelector('.profile-header');
            profileHeader.insertAdjacentHTML('afterend', alertHtml);
            
            // Auto-dismiss after 5 seconds
            setTimeout(() => {
                const newAlert = alertContainer.querySelector('.alert');
                if (newAlert) {
                    const bsAlert = new bootstrap.Alert(newAlert);
                    bsAlert.close();
                }
            }, 5000);
        }

        // Show password change modal if there are validation errors
        @if($errors->has('current_password') || $errors->has('password'))
            document.addEventListener('DOMContentLoaded', function() {
                var modal = new bootstrap.Modal(document.getElementById('changePasswordModal'));
                modal.show();
            });
        @endif

        // Form submission debugging
        document.getElementById('profileForm').addEventListener('submit', function(e) {
            console.log('Form submitted');
            
            // Log all form data
            const formData = new FormData(this);
            console.log('Form data:');
            for (let [key, value] of formData.entries()) {
                console.log(key + ': ' + value);
            }
            
            // Check if fields have values
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const position = document.getElementById('position').value;
            const phone = document.getElementById('phone_number').value;
            const staffCode = document.getElementById('staff_code').value;
            
            console.log('Field values:', {
                name: name,
                email: email,
                position: position,
                phone: phone,
                staffCode: staffCode
            });

            // Check if form action and method are correct
            console.log('Form action:', this.action);
            console.log('Form method:', this.method);
            
            // Add a small delay to see the console logs before redirect
            // e.preventDefault();
            // setTimeout(() => {
            //     this.submit();
            // }, 1000);
        });

        // Dropdown toggle
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('show');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('userDropdown');
            const userBtn = document.querySelector('.user-btn');
            if (!userBtn.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });
    </script>
</body>
</html>
