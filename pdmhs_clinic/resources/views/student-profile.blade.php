<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1877f2;
            --primary-dark: #166fe5;
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
            font-size: 1.5rem;
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
            color: var(--dark);
            text-decoration: none;
            font-weight: 500;
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
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        /* Welcome Section */
        .welcome-section {
            background: white;
            border-radius: 1.5rem;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 2rem;
            animation: slideDown 0.5s ease;
        }

        .profile-pic-large {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--primary);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .profile-pic-default-large {
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

        .welcome-content h1 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .welcome-content p {
            color: #6b7280;
            font-size: 1.1rem;
        }

        /* Section Cards */
        .section-card {
            background: white;
            border-radius: 1.5rem;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 0.5s ease;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--light);
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .btn {
            padding: 0.5rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
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
            border: 2px solid var(--primary);
            color: var(--primary);
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
        }

        /* Profile Picture Section */
        .profile-picture-section {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 2px solid var(--light);
        }

        .profile-picture-container {
            position: relative;
            display: inline-block;
            margin-bottom: 1.5rem;
        }

        .profile-picture {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid white;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .profile-picture:hover {
            transform: scale(1.05);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
        }

        .default-avatar {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 4.5rem;
            border: 5px solid white;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            margin: 0 auto 1.5rem;
            transition: all 0.3s ease;
        }

        .default-avatar:hover {
            transform: scale(1.05);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
        }

        .upload-btn {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            font-weight: 600;
            font-size: 1rem;
            margin-top: 1rem;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
            transition: all 0.3s ease;
        }

        .upload-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.4);
        }

        /* Form Styles */
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--dark);
        }

        .form-control, .form-select {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid var(--light);
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .form-control[readonly], .form-select[disabled] {
            background-color: #f8f9fa;
            border-color: #e9ecef;
            cursor: not-allowed;
        }

        .form-control.edit-mode, .form-select.edit-mode {
            border-color: var(--primary);
            background-color: white;
        }

        .form-control.is-invalid, .form-select.is-invalid {
            border-color: var(--danger);
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }

        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875rem;
            color: var(--danger);
        }

        .textarea-large {
            min-height: 100px;
            resize: vertical;
        }

        .btn-edit, .btn-password, .btn-qr {
            background: var(--primary);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .btn-edit:hover, .btn-password:hover, .btn-qr:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .btn-success {
            background: var(--success);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background: #059669;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: #4b5563;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px -5px rgba(0, 0, 0, 0.1);
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

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid var(--danger);
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            z-index: 2000;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.3s ease;
        }

        .modal.show {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 1rem;
            width: 90%;
            max-width: 800px;
            max-height: 90vh;
            overflow-y: auto;
            animation: scaleIn 0.3s ease;
        }

        .modal-header {
            padding: 1.5rem;
            border-bottom: 2px solid var(--light);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            padding: 1.5rem;
            border-top: 2px solid var(--light);
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }

        .close-btn {
            background: transparent;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #6b7280;
            transition: all 0.3s ease;
        }

        .close-btn:hover {
            color: var(--danger);
            transform: rotate(90deg);
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

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar-menu {
                display: none;
            }

            .welcome-section {
                flex-direction: column;
                text-align: center;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a class="navbar-brand" href="{{ route('student.dashboard') }}">
                <img src="{{ asset('logo.jpg') }}" alt="PDMHS Logo" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                PDMHS Clinic
            </a>
            <ul class="navbar-menu">
                <li><a class="nav-link" href="{{ route('student.dashboard') }}"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
                <li><a class="nav-link" href="{{ route('student.medical') }}"><i class="fas fa-notes-medical"></i>My Medical</a></li>
                <li><a class="nav-link active" href="{{ route('student.profile') }}"><i class="fas fa-user-edit"></i>Profile</a></li>
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
                    <a class="dropdown-item" href="{{ route('student.profile') }}">
                        <i class="fas fa-user-edit"></i>
                        Profile Settings
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
            <div class="alert alert-error">
                <i class="fas fa-exclamation-triangle"></i>
                <strong>Error!</strong> {{ session('error') }}
            </div>
        @endif

        <!-- Welcome Section -->
        <div class="welcome-section">
            @if($user->profile_picture && file_exists(public_path($user->profile_picture)))
                <img src="{{ asset($user->profile_picture) }}" alt="Profile Picture" class="profile-pic-large">
            @else
                <div class="profile-pic-default-large">
                    <i class="fas fa-user"></i>
                </div>
            @endif
            <div class="welcome-content">
                <h1>Welcome back, {{ $user->name }}!</h1>
                <p>Manage your profile information and account settings</p>
            </div>
        </div>

        <!-- Profile Picture Section -->
        <div class="section-card">
            <div class="section-header">
                <div class="section-title">
                    <i class="fas fa-camera"></i>
                    Profile Picture
                </div>
            </div>
            <div class="profile-picture-section">
                <div class="profile-picture-container">
                    @if($user->profile_picture && file_exists(public_path($user->profile_picture)))
                        <img src="{{ asset($user->profile_picture) }}" alt="Profile Picture" class="profile-picture" id="profileImage">
                    @else
                        <div class="default-avatar" id="profileImage">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif
                </div>
                <div>
                    <button type="button" class="upload-btn" onclick="document.getElementById('profilePictureInput').click()">
                        <i class="fas fa-camera"></i>Change Photo
                    </button>
                    <input type="file" id="profilePictureInput" accept="image/*" style="display: none;" onchange="uploadProfilePicture(this)">
                </div>
            </div>
        </div>

        <!-- Profile Edit Form -->
        <form method="POST" action="{{ route('student.profile.update') }}">
            @csrf
            @method('PUT')

            <!-- Personal Information Section -->
            <div class="section-card">
                <div class="section-header">
                    <div class="section-title">
                        <i class="fas fa-user"></i>
                        Personal Information
                    </div>
                    <div id="editButtons">
                        <button type="button" class="btn btn-outline" onclick="enableEditMode()">
                            <i class="fas fa-edit"></i>
                            Edit Profile
                        </button>
                    </div>
                    <div id="saveButtons" style="display: none;">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i>
                            Save Changes
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="cancelEdit()">
                            <i class="fas fa-times"></i>
                            Cancel
                        </button>
                    </div>
                </div>

                <!-- Name Fields -->
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">First Name</label>
                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name', $student->first_name) }}" readonly required>
                        @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Middle Name</label>
                        <input type="text" class="form-control @error('middle_name') is-invalid @enderror" name="middle_name" value="{{ old('middle_name', $student->middle_name ?? '') }}" readonly>
                        @error('middle_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Last Name</label>
                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name', $student->last_name) }}" readonly required>
                        @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Student Number, Gender, Birthday -->
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Student Number</label>
                        <input type="text" class="form-control" value="{{ $student->student_id }}" readonly>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Gender</label>
                        <select class="form-select @error('gender') is-invalid @enderror" name="gender" disabled>
                            <option value="">Select Gender</option>
                            <option value="M" {{ old('gender', $student->gender ?? '') == 'M' ? 'selected' : '' }}>Male</option>
                            <option value="F" {{ old('gender', $student->gender) == 'F' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Birthday</label>
                        <input type="date" class="form-control @error('birth_date') is-invalid @enderror" name="birth_date" value="{{ old('birth_date', $student->date_of_birth) }}" readonly>
                        @error('birth_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Academic Information Section -->
            <div class="section-card">
                <div class="section-header">
                    <div class="section-title">
                        <i class="fas fa-graduation-cap"></i>
                        Academic Information
                    </div>
                </div>

                <!-- Grade Level, Section, Blood Type -->
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Grade Level</label>
                        <input type="text" class="form-control @error('grade_level') is-invalid @enderror" name="grade_level" value="{{ old('grade_level', $student->grade_level) }}" readonly>
                        @error('grade_level')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Section</label>
                        <input type="text" class="form-control @error('section') is-invalid @enderror" name="section" value="{{ old('section', $student->section) }}" readonly>
                        @error('section')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Blood Type</label>
                        <select class="form-select @error('blood_type') is-invalid @enderror" name="blood_type" disabled>
                            <option value="">Select Blood Type</option>
                            <option value="A+" {{ old('blood_type', $student->blood_type ?? 'O+') == 'A+' ? 'selected' : '' }}>A+</option>
                            <option value="A-" {{ old('blood_type', $student->blood_type ?? '') == 'A-' ? 'selected' : '' }}>A-</option>
                            <option value="B+" {{ old('blood_type', $student->blood_type ?? '') == 'B+' ? 'selected' : '' }}>B+</option>
                            <option value="B-" {{ old('blood_type', $student->blood_type ?? '') == 'B-' ? 'selected' : '' }}>B-</option>
                            <option value="AB+" {{ old('blood_type', $student->blood_type ?? '') == 'AB+' ? 'selected' : '' }}>AB+</option>
                            <option value="AB-" {{ old('blood_type', $student->blood_type ?? '') == 'AB-' ? 'selected' : '' }}>AB-</option>
                            <option value="O+" {{ old('blood_type', $student->blood_type ?? 'O+') == 'O+' ? 'selected' : '' }}>O+</option>
                            <option value="O-" {{ old('blood_type', $student->blood_type ?? '') == 'O-' ? 'selected' : '' }}>O-</option>
                        </select>
                        @error('blood_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Contact Information Section -->
            <div class="section-card">
                <div class="section-header">
                    <div class="section-title">
                        <i class="fas fa-address-book"></i>
                        Contact Information
                    </div>
                </div>

                <!-- Email and Phone -->
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" readonly required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Phone Number</label>
                        <input type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number', $student->contact_number) }}" readonly>
                        @error('phone_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Address -->
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Address</label>
                        <textarea class="form-control textarea-large @error('address') is-invalid @enderror" name="address" rows="3" readonly>{{ old('address', $student->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Emergency Contact -->
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Emergency Contact</label>
                        <input type="text" class="form-control @error('emergency_contact') is-invalid @enderror" name="emergency_contact" value="{{ old('emergency_contact', $student->emergency_contact) }}" readonly>
                        @error('emergency_contact')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Additional Actions -->
            <div class="section-card">
                <div class="section-header">
                    <div class="section-title">
                        <i class="fas fa-cogs"></i>
                        Account Settings
                    </div>
                </div>
                <div style="text-align: center;">
                    <button type="button" class="btn btn-primary" onclick="showPasswordModal()">
                        <i class="fas fa-key"></i>
                        Change Password
                    </button>
                    <button type="button" class="btn btn-primary" onclick="showQRModal()" style="margin-left: 1rem;">
                        <i class="fas fa-qrcode"></i>
                        View QR Code
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Edit Password Modal -->
    <div class="modal" id="passwordModal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-key"></i>
                    Change Password
                </h5>
                <button type="button" class="close-btn" onclick="closePasswordModal()">&times;</button>
            </div>
            <form id="passwordForm" method="POST" action="{{ route('student.password.update') }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group" style="margin-bottom: 1rem;">
                        <label class="form-label">Current Password</label>
                        <input type="password" class="form-control" name="current_password" required>
                    </div>
                    <div class="form-group" style="margin-bottom: 1rem;">
                        <label class="form-label">New Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="form-group" style="margin-bottom: 1rem;">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" name="password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closePasswordModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- QR Code Modal -->
    <div class="modal" id="qrModal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-qrcode"></i>
                    Your QR Code
                </h5>
                <button type="button" class="close-btn" onclick="closeQRModal()">&times;</button>
            </div>
            <div class="modal-body" style="text-align: center;">
                <div style="margin-bottom: 1rem;">
                    <p style="color: #6b7280;">Scan this QR code for quick access to your student information</p>
                </div>
                <div class="qr-code-container" style="margin-bottom: 1rem;">
                    <div id="qrcode" style="display: flex; justify-content: center;"></div>
                </div>
                <div class="student-info">
                    <h6 style="font-weight: 700; margin-bottom: 0.5rem;">{{ $user->name }}</h6>
                    <p style="color: #6b7280; margin-bottom: 0.25rem;">Student ID: {{ $student->student_id }}</p>
                    <p style="color: #6b7280;">{{ $student->grade_level }} - {{ $student->section }}</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeQRModal()">Close</button>
                <button type="button" class="btn btn-primary" onclick="downloadQR()">
                    <i class="fas fa-download"></i>
                    Download QR
                </button>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <script>
        function showPasswordModal() {
            const passwordModal = document.getElementById('passwordModal');
            passwordModal.style.display = 'flex';
        }

        function closePasswordModal() {
            const passwordModal = document.getElementById('passwordModal');
            passwordModal.style.display = 'none';
        }

        function showQRModal() {
            const qrModal = document.getElementById('qrModal');
            qrModal.style.display = 'flex';
            // Clear any previous content
            document.getElementById('qrcode').innerHTML = '<p style="color: #3b82f6;">Generating QR Code...</p>';

            // Wait for QRCode library to be loaded before generating
            if (typeof QRCode === 'undefined') {
                console.log('QRCode library not loaded yet, waiting...');
                let attempts = 0;
                const checkLibrary = () => {
                    attempts++;
                    if (typeof QRCode !== 'undefined') {
                        generateQRCode();
                    } else if (attempts < 10) {
                        setTimeout(checkLibrary, 200);
                    } else {
                        console.error('QRCode library failed to load after multiple attempts');
                        document.getElementById('qrcode').innerHTML = '<p style="color: #ef4444;">QR Code library failed to load. Please refresh the page and try again.</p>';
                    }
                };
                setTimeout(checkLibrary, 200);
            } else {
                generateQRCode();
            }
        }

        function closeQRModal() {
            const qrModal = document.getElementById('qrModal');
            qrModal.style.display = 'none';
        }
        
        function generateQRCode() {
            const qrContainer = document.getElementById('qrcode');
            qrContainer.innerHTML = ''; // Clear previous QR code

            // Check if QRCode library is loaded
            if (typeof QRCode === 'undefined') {
                console.error('QRCode library not loaded');
                qrContainer.innerHTML = '<p class="text-danger">QR Code library not loaded. Please refresh the page.</p>';
                return;
            }

            const studentData = {
                name: '{{ $user->name }}',
                student_id: '{{ $student->student_id }}',
                grade_level: '{{ $student->grade_level }}',
                section: '{{ $student->section }}',
                email: '{{ $user->email }}'
            };

            console.log('Generating QR code for data:', studentData);

            const qrText = JSON.stringify(studentData);

            try {
                // Use qrcodejs library API
                new QRCode(qrContainer, {
                    text: qrText,
                    width: 200,
                    height: 200,
                    colorDark: "#000000",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.H
                });
                console.log('QR Code generated successfully');
            } catch (e) {
                console.error('Exception during QR code generation:', e);
                qrContainer.innerHTML = '<p class="text-danger">Exception generating QR code: ' + e.message + '</p>';
            }
        }
        
        function downloadQR() {
            const canvas = document.querySelector('#qrcode canvas');
            if (canvas) {
                const link = document.createElement('a');
                link.download = 'student-qr-code.png';
                link.href = canvas.toDataURL();
                link.click();
            }
        }

        function uploadProfilePicture(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                
                // Validate file type
                if (!file.type.startsWith('image/')) {
                    alert('Please select a valid image file.');
                    return;
                }
                
                // Validate file size (max 5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('File size must be less than 5MB.');
                    return;
                }
                
                const formData = new FormData();
                formData.append('profile_picture', file);
                
                // Get CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (csrfToken) {
                    formData.append('_token', csrfToken.getAttribute('content'));
                } else {
                    console.error('CSRF token not found');
                    alert('Security token not found. Please refresh the page.');
                    return;
                }
                
                // Show loading state
                const uploadBtn = document.querySelector('.upload-btn');
                const originalText = uploadBtn.innerHTML;
                uploadBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Uploading...';
                uploadBtn.disabled = true;
                
                console.log('Starting upload...');
                
                fetch('/student/upload-profile-picture', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    if (data.success) {
                        // Update profile picture
                        const profileImage = document.getElementById('profileImage');
                        if (profileImage.tagName === 'IMG') {
                            profileImage.src = data.profile_picture_url;
                        } else {
                            // Replace default avatar with image
                            profileImage.outerHTML = `<img src="${data.profile_picture_url}" alt="Profile Picture" class="profile-picture" id="profileImage">`;
                        }
                        
                        // Show success message
                        showAlert('Profile picture updated successfully!', 'success');
                    } else {
                        showAlert(data.message || 'Failed to upload profile picture.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('An error occurred while uploading the profile picture.', 'error');
                })
                .finally(() => {
                    // Reset button state
                    uploadBtn.innerHTML = originalText;
                    uploadBtn.disabled = false;
                });
            }
        }
        
        function showAlert(message, type) {
            const alertClass = type === 'success' ? 'alert-success' : 'alert-error';
            const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';

            const alertHtml = `
                <div class="alert ${alertClass}" role="alert">
                    <i class="fas ${iconClass}"></i>
                    <strong>${type === 'success' ? 'Success!' : 'Error!'}</strong> ${message}
                </div>
            `;

            const container = document.querySelector('.container');
            container.insertAdjacentHTML('afterbegin', alertHtml);

            // Auto-dismiss after 5 seconds
            setTimeout(() => {
                const alert = container.querySelector('.alert');
                if (alert) {
                    alert.remove();
                }
            }, 5000);
        }

        // Edit mode functionality
        let originalValues = {};

        function enableEditMode() {
            try {
                // Store original values
                const inputs = document.querySelectorAll('input[readonly], select[disabled], textarea[readonly]');
                inputs.forEach(input => {
                    if (input.name) {
                        originalValues[input.name] = input.value;
                    }
                });

                // Enable all form fields
                document.querySelectorAll('input[readonly]').forEach(input => {
                    input.removeAttribute('readonly');
                    input.classList.add('edit-mode');
                });
                
                document.querySelectorAll('select[disabled]').forEach(select => {
                    select.removeAttribute('disabled');
                    select.classList.add('edit-mode');
                });
                
                document.querySelectorAll('textarea[readonly]').forEach(textarea => {
                    textarea.removeAttribute('readonly');
                    textarea.classList.add('edit-mode');
                });

                // Show save/cancel buttons, hide edit button
                const editButtons = document.getElementById('editButtons');
                const saveButtons = document.getElementById('saveButtons');
                
                if (editButtons) editButtons.style.display = 'none';
                if (saveButtons) saveButtons.style.display = 'block';
            } catch (error) {
                console.error('Error enabling edit mode:', error);
                alert('Error enabling edit mode. Please refresh the page and try again.');
            }
        }

        function cancelEdit() {
            try {
                // Restore original values
                Object.keys(originalValues).forEach(name => {
                    const field = document.querySelector(`[name="${name}"]`);
                    if (field) {
                        field.value = originalValues[name];
                    }
                });

                // Disable all form fields
                document.querySelectorAll('input.edit-mode').forEach(input => {
                    input.setAttribute('readonly', true);
                    input.classList.remove('edit-mode');
                });

                document.querySelectorAll('select.edit-mode').forEach(select => {
                    select.setAttribute('disabled', true);
                    select.classList.remove('edit-mode');
                });

                document.querySelectorAll('textarea.edit-mode').forEach(textarea => {
                    textarea.setAttribute('readonly', true);
                    textarea.classList.remove('edit-mode');
                });

                // Show edit button, hide save/cancel buttons
                const editButtons = document.getElementById('editButtons');
                const saveButtons = document.getElementById('saveButtons');

                if (editButtons) editButtons.style.display = 'block';
                if (saveButtons) saveButtons.style.display = 'none';

                // Clear original values
                originalValues = {};
            } catch (error) {
                console.error('Error canceling edit:', error);
                alert('Error canceling edit. Please refresh the page.');
            }
        }

        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('show');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('userDropdown');
            const userBtn = event.target.closest('.user-btn');
            if (!userBtn && !dropdown.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });

        // Close modals when clicking outside
        document.addEventListener('click', function(event) {
            const passwordModal = document.getElementById('passwordModal');
            const qrModal = document.getElementById('qrModal');

            if (event.target === passwordModal) {
                closePasswordModal();
            }
            if (event.target === qrModal) {
                closeQRModal();
            }
        });
    </script>
</body>
</html>