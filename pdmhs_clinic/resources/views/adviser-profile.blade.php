<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profile Settings - PDMHS Clinic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            font-weight: 700;
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
            background: var(--primary);
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
            max-width: 1000px;
            margin: 2rem auto;
            padding: 0 2rem;
        }
        
        /* Page Header */
        .page-header {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(220, 220, 250, 0.95) 100%);
            backdrop-filter: blur(10px);
            border-radius: 1.5rem;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            animation: slideDown 0.5s ease;
        }
        
        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }
        
        .page-subtitle {
            color: #6b7280;
            font-size: 1.1rem;
            margin-bottom: 0;
        }
        
        /* Profile Section */
        .profile-section {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(220, 220, 250, 0.95) 100%);
            backdrop-filter: blur(10px);
            border-radius: 1.5rem;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 0.5s ease;
        }
        
        /* Profile Photo Section */
        .profile-photo-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 2rem;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 1rem;
            border: 2px dashed #e5e7eb;
        }
        
        .profile-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--primary);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .profile-photo-default {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
            border: 4px solid white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        /* Form Styling */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-row.single {
            grid-template-columns: 1fr;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
        }
        
        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        
        .form-control {
            border: 2px solid #e5e7eb;
            border-radius: 0.75rem;
            padding: 0.875rem 1rem;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
            outline: none;
        }

        .form-control:disabled {
            background-color: #f9fafb;
            color: #6b7280;
            cursor: not-allowed;
        }
        
        /* Buttons */
        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid #d1d5db;
            color: #6b7280;
        }

        .btn-outline:hover {
            background: #f9fafb;
            border-color: var(--primary);
            color: var(--primary);
        }
        
        /* Alert */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 0.75rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            animation: slideDown 0.3s ease;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border-left: 4px solid var(--success);
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid var(--danger);
        }

        /* Animations */
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar-menu {
                display: none;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .profile-photo-section {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a class="navbar-brand" href="{{ route('adviser.dashboard') }}">
                <i class="fas fa-heartbeat"></i>
                PDMHS Clinic
            </a>
            <ul class="navbar-menu">
                <li><a class="nav-link" href="{{ route('adviser.dashboard') }}"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
                <li><a class="nav-link" href="{{ route('adviser.my-students') }}"><i class="fas fa-users"></i>My Students</a></li>
                <li><a class="nav-link" href="{{ route('adviser.scanner') }}"><i class="fas fa-qrcode"></i>Scanner</a></li>
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
                    <a class="dropdown-item" href="{{ route('adviser.profile') }}">
                        <i class="fas fa-user-edit"></i>
                        Profile
                    </a>
                    <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <strong>Success!</strong> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle"></i>
                <strong>Error!</strong> {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle"></i>
                <strong>Validation Errors:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Profile Settings</h1>
            <p class="page-subtitle">Manage your account information</p>
        </div>

        <!-- Profile Information Section -->
        <div class="profile-section">
            <!-- Profile Photo Section -->
            <div class="profile-photo-section">
                <div id="profilePhotoContainer">
                    @if($user->profile_picture && file_exists(public_path($user->profile_picture)))
                        <img src="{{ asset($user->profile_picture) }}" alt="Profile Picture" class="profile-photo" id="profileImage">
                    @else
                        <div class="profile-photo-default">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif
                </div>
                <div>
                    <input type="file" id="profilePictureInput" accept="image/*" style="display: none;">
                    <button type="button" class="btn btn-outline" onclick="document.getElementById('profilePictureInput').click()">
                        <i class="fas fa-camera"></i>Change Photo
                    </button>
                </div>
            </div>

            <form action="{{ route('adviser.profile.update') }}" method="POST" id="profileForm">
                @csrf
                @method('PUT')
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="first_name" class="form-label">Full Name</label>
                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                               id="full_name" name="first_name" value="{{ old('first_name', $user->name) }}" 
                               placeholder="{{ $user->name }}" disabled>
                        @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="position" class="form-label">Position</label>
                        <input type="text" class="form-control @error('position') is-invalid @enderror" 
                               id="position" name="position" value="{{ old('position', $user->position) }}" 
                               placeholder="e.g., Nurse, Doctor, Medical Assistant" disabled>
                        @error('position')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', $user->email) }}" 
                               placeholder="{{ $user->email }}" disabled>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="contact_number" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control @error('contact_number') is-invalid @enderror" 
                               id="contact_number" name="contact_number" value="{{ old('contact_number', $user->contact_number) }}" 
                               placeholder="e.g., +63 912 345 6789" disabled>
                        @error('contact_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row single">
                    <div class="form-group">
                        <label for="employee_number" class="form-label">Staff Code</label>
                        <input type="text" class="form-control @error('employee_number') is-invalid @enderror" 
                               id="employee_number" name="employee_number" value="{{ old('employee_number', $user->employee_number) }}" 
                               placeholder="e.g., SC001" disabled>
                        @error('employee_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4" id="formButtons">
                    <button type="button" class="btn btn-primary" id="editBtn" onclick="enableEditMode()">
                        <i class="fas fa-edit"></i>Edit Profile
                    </button>
                    <button type="submit" class="btn btn-primary" id="saveBtn" style="display: none;">
                        <i class="fas fa-save"></i>Save Changes
                    </button>
                    <button type="button" class="btn btn-outline" id="cancelBtn" style="display: none;" onclick="cancelEditMode()">
                        <i class="fas fa-times"></i>Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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
            const changePhotoBtn = document.querySelector('.btn-outline');
            const originalText = changePhotoBtn.innerHTML;
            changePhotoBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>Uploading...';
            changePhotoBtn.disabled = true;

            // Create FormData and upload
            const formData = new FormData();
            formData.append('profile_picture', file);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            fetch('{{ route("adviser.upload-profile-picture") }}', {
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
            const container = document.querySelector('.container');
            const alertHtml = `
                <div class="alert alert-${type}">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                    <strong>${type === 'success' ? 'Success!' : 'Error!'}</strong> ${message}
                </div>
            `;
            
            // Remove existing alerts
            const existingAlerts = container.querySelectorAll('.alert');
            existingAlerts.forEach(alert => alert.remove());
            
            // Add new alert after page header
            const pageHeader = document.querySelector('.page-header');
            pageHeader.insertAdjacentHTML('afterend', alertHtml);
            
            // Auto-dismiss after 5 seconds
            setTimeout(() => {
                const newAlert = container.querySelector('.alert');
                if (newAlert) {
                    newAlert.style.opacity = '0';
                    setTimeout(() => {
                        newAlert.remove();
                    }, 300);
                }
            }, 5000);
        }

        // Dropdown toggle
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('show');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('userDropdown');
            const userBtn = event.target.closest('.user-btn');
            if (!userBtn && dropdown.classList.contains('show')) {
                dropdown.classList.remove('show');
            }
        });

        // Edit mode functionality
        function enableEditMode() {
            // Enable all form fields except full name (read-only)
            const formFields = document.querySelectorAll('#profileForm input:not(#full_name), #profileForm select, #profileForm textarea');
            formFields.forEach(field => {
                field.disabled = false;
            });

            // Toggle buttons
            document.getElementById('editBtn').style.display = 'none';
            document.getElementById('saveBtn').style.display = 'inline-flex';
            document.getElementById('cancelBtn').style.display = 'inline-flex';
        }

        function cancelEditMode() {
            // Disable all form fields
            const formFields = document.querySelectorAll('#profileForm input, #profileForm select, #profileForm textarea');
            formFields.forEach(field => {
                field.disabled = true;
            });

            // Reset form to original values
            document.getElementById('profileForm').reset();

            // Toggle buttons
            document.getElementById('editBtn').style.display = 'inline-flex';
            document.getElementById('saveBtn').style.display = 'none';
            document.getElementById('cancelBtn').style.display = 'none';
        }

        // Auto-dismiss alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        alert.remove();
                    }, 300);
                }, 5000);
            });
        });

        // Add scroll effect to navbar
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>;
                }, 5000);
            });
        });
    </script>
</body>
</html>