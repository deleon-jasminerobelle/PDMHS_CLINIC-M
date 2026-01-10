<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Student's Health Record</title>
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

        /* Health Form Specific Styles */
        .health-form-container {
            background: white;
            border-radius: 1.5rem;
            padding: 2rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 0.5s ease;
        }

        .health-form-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--light);
        }

        .health-form-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .form-section {
            background: var(--light);
            border-radius: 1rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid var(--primary);
        }

        .form-section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .vaccination-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
            background: white;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .vaccination-table th {
            background: var(--primary);
            color: white;
            padding: 0.75rem;
            text-align: left;
            font-weight: 600;
        }

        .vaccination-table td {
            padding: 0.75rem;
            border-bottom: 1px solid var(--light);
        }

        .vaccination-table tr:nth-child(even) {
            background: rgba(79, 70, 229, 0.02);
        }

        .radio-group {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .radio-option {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .checkbox-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .submit-section {
            text-align: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px solid var(--light);
        }

        .submit-btn {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 1.1rem;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
            transition: all 0.3s ease;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.4);
        }

        /* Medical History Questions */
        .medical-history-questions {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .question-group {
            padding: 1rem;
            background: rgba(79, 70, 229, 0.02);
            border-radius: 0.5rem;
            border: 1px solid rgba(79, 70, 229, 0.1);
        }

        .conditional-field {
            margin-top: 1rem;
            padding: 1rem;
            background: rgba(79, 70, 229, 0.05);
            border-radius: 0.5rem;
            border-left: 3px solid var(--primary);
        }

        .conditional-field.hidden {
            display: none;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a class="navbar-brand" href="{{ route('student.dashboard') }}">
                <i class="fas fa-heartbeat"></i>
                PDMHS Clinic
            </a>
            <ul class="navbar-menu">
                <li><a class="nav-link" href="{{ route('student.dashboard') }}"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
                <li><a class="nav-link" href="{{ route('student.medical') }}"><i class="fas fa-notes-medical"></i>My Medical</a></li>
                <li><a class="nav-link active" href="{{ route('health-form.index') }}"><i class="fas fa-clipboard-list"></i>Health Form</a></li>
            </ul>
            <div class="user-dropdown">
                <button class="user-btn" onclick="toggleDropdown()">
                    @if(Auth::user() && Auth::user()->profile_picture && file_exists(public_path(Auth::user()->profile_picture)))
                        <img src="{{ asset(Auth::user()->profile_picture) }}" alt="Profile" class="user-avatar">
                    @else
                        <div class="user-avatar-default">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif
                    <span>{{ Auth::user() ? Auth::user()->name : 'Guest' }}</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="dropdown-menu" id="userDropdown">
                    <a class="dropdown-item" href="{{ route('student.info') }}">
                        <i class="fas fa-user"></i>
                        User
                    </a>
                    <a class="dropdown-item" href="{{ route('student.profile') }}">
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
        <div class="health-form-container">
            <div class="health-form-header">
                <h1 class="health-form-title">
                    <i class="fas fa-clipboard-list"></i>
                    STUDENT'S HEALTH RECORD
                </h1>
                <div class="flex gap-2">
                    <a href="{{ route('student.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i>Back to Dashboard
                    </a>
                    <button type="button" id="editBtn" class="btn btn-primary">
                        <i class="fas fa-edit"></i>Edit
                    </button>
                </div>
            </div>

            <form action="{{ route('student.health.store') }}" method="POST" id="healthForm">
                @csrf

                {{-- Basic Information --}}
                <div class="form-section">
                    <h2 class="form-section-title">
                        <i class="fas fa-user"></i>
                        Student Information
                    </h2>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" value="{{ isset($student) ? $student->first_name . ' ' . $student->last_name : old('name') }}" required class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="form-label">LRN</label>
                            <input type="text" name="lrn" value="{{ isset($student) ? $student->student_id : old('lrn') }}" required class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="form-label">School</label>
                            <input type="text" name="school" value="{{ isset($student) ? $student->school : old('school') }}" required class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Grade Level & Section</label>
                            <input type="text" name="grade_section" value="{{ isset($student) ? $student->grade_level . ' ' . $student->section : old('grade_section') }}" required class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Birthday</label>
                            <input type="date" name="birthday" value="{{ isset($student) && $student->date_of_birth ? $student->date_of_birth->format('Y-m-d') : old('birthday') }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Sex/Age</label>
                            <div class="d-flex gap-2">
                                <select name="gender" required class="form-select flex-fill">
                                    <option value="">Select</option>
                                    <option value="M" {{ isset($student) && $student->gender == 'M' ? 'selected' : '' }}>Male</option>
                                    <option value="F" {{ isset($student) && $student->gender == 'F' ? 'selected' : '' }}>Female</option>
                                </select>
                                <input type="number" name="age" placeholder="Age" value="{{ isset($student) ? $student->age : old('age') }}" required class="form-control" style="width: 80px;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Adviser</label>
                            <select name="adviser" class="form-select">
                                <option value="">Select Adviser</option>
                                @foreach($advisers as $adviser)
                                    <option value="{{ $adviser->first_name . ' ' . $adviser->last_name }}" {{ isset($student) && $student->adviser == $adviser->first_name . ' ' . $adviser->last_name ? 'selected' : '' }}>
                                        {{ $adviser->first_name . ' ' . $adviser->last_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Contact Number</label>
                            <input type="text" name="contact_number" value="{{ isset($student) ? $student->contact_number : old('contact_number') }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Blood Type</label>
                            <select name="blood_type" class="form-select">
                                <option value="">Select</option>
                                <option value="A+" {{ isset($student) && $student->blood_type == 'A+' ? 'selected' : '' }}>A+</option>
                                <option value="A-" {{ isset($student) && $student->blood_type == 'A-' ? 'selected' : '' }}>A-</option>
                                <option value="B+" {{ isset($student) && $student->blood_type == 'B+' ? 'selected' : '' }}>B+</option>
                                <option value="B-" {{ isset($student) && $student->blood_type == 'B-' ? 'selected' : '' }}>B-</option>
                                <option value="AB+" {{ isset($student) && $student->blood_type == 'AB+' ? 'selected' : '' }}>AB+</option>
                                <option value="AB-" {{ isset($student) && $student->blood_type == 'AB-' ? 'selected' : '' }}>AB-</option>
                                <option value="O+" {{ isset($student) && $student->blood_type == 'O+' ? 'selected' : '' }}>O+</option>
                                <option value="O-" {{ isset($student) && $student->blood_type == 'O-' ? 'selected' : '' }}>O-</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Height (cm)</label>
                            <input type="number" name="height" step="0.1" value="{{ isset($student) ? $student->height : old('height') }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Weight (kg)</label>
                            <input type="number" name="weight" step="0.1" value="{{ isset($student) ? $student->weight : old('weight') }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Temperature (°C)</label>
                            <input type="number" name="temperature" step="0.1" value="{{ isset($student) ? $student->temperature : old('temperature') }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Blood Pressure</label>
                            <input type="text" name="blood_pressure" placeholder="e.g., 120/80" value="{{ isset($student) ? $student->blood_pressure : old('blood_pressure') }}" class="form-control">
                        </div>
                    </div>
                </div>

                {{-- Medical History --}}
                <div class="form-section">
                    <h2 class="form-section-title">
                        <i class="fas fa-heartbeat"></i>
                        Medical History (For Learners)
                    </h2>

                    <div class="medical-history-questions">
                        <div class="question-group">
                            <p class="mb-2">1. Does your child have any allergies?</p>
                            <div class="radio-group">
                                <label class="radio-option">
                                    <input type="radio" name="has_allergies" value="1" {{ isset($student) && $student->has_allergies == '1' ? 'checked' : '' }}>
                                    <span>Yes</span>
                                </label>
                                <label class="radio-option">
                                    <input type="radio" name="has_allergies" value="0" {{ isset($student) && $student->has_allergies == '0' ? 'checked' : '' }}>
                                    <span>No</span>
                                </label>
                            </div>
                            <div id="allergiesDiv" class="checkbox-grid conditional-field {{ isset($student) && $student->has_allergies == '1' ? '' : 'hidden' }}">
                                @php
                                $allergies = isset($student) ? $student->allergies ?? [] : [];
                                @endphp
                                <label class="checkbox-item">
                                    <input type="checkbox" name="allergies[]" value="Medicine" {{ in_array('Medicine', $allergies) ? 'checked' : '' }}>
                                    <span>Medicine</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="allergies[]" value="Others" {{ in_array('Others', $allergies) ? 'checked' : '' }}>
                                    <span>Others</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="allergies[]" value="Food" {{ in_array('Food', $allergies) ? 'checked' : '' }}>
                                    <span>Food</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="allergies[]" value="Stinging Insects" {{ in_array('Stinging Insects', $allergies) ? 'checked' : '' }}>
                                    <span>Stinging Insects</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="allergies[]" value="Rhinitis/Sinusitis" {{ in_array('Rhinitis/Sinusitis', $allergies) ? 'checked' : '' }}>
                                    <span>Rhinitis/Sinusitis</span>
                                </label>
                            </div>
                        </div>

                        <div class="question-group">
                            <p class="mb-2">2. Does your child have any ongoing medical condition?</p>
                            <div class="radio-group">
                                <label class="radio-option">
                                    <input type="radio" name="has_medical_condition" value="1" {{ isset($student) && $student->has_medical_condition == '1' ? 'checked' : '' }}>
                                    <span>Yes</span>
                                </label>
                                <label class="radio-option">
                                    <input type="radio" name="has_medical_condition" value="0" {{ isset($student) && $student->has_medical_condition == '0' ? 'checked' : '' }}>
                                    <span>No</span>
                                </label>
                            </div>
                            <div id="medicalConditionsDiv" class="checkbox-grid conditional-field {{ isset($student) && $student->has_medical_condition == '1' ? '' : 'hidden' }}">
                                @php
                                $medicalConditions = isset($student) ? $student->medical_conditions ?? [] : [];
                                @endphp
                                <label class="checkbox-item">
                                    <input type="checkbox" name="medical_conditions[]" value="Error of refraction" {{ in_array('Error of refraction', $medicalConditions) ? 'checked' : '' }}>
                                    <span>Error of refraction (Wearing Corrective Lenses)</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="medical_conditions[]" value="Asthma" {{ in_array('Asthma', $medicalConditions) ? 'checked' : '' }}>
                                    <span>Asthma</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="medical_conditions[]" value="Heart problem" {{ in_array('Heart problem', $medicalConditions) ? 'checked' : '' }}>
                                    <span>Heart problem</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="medical_conditions[]" value="Anemia" {{ in_array('Anemia', $medicalConditions) ? 'checked' : '' }}>
                                    <span>Anemia</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="medical_conditions[]" value="Eating disorder" {{ in_array('Eating disorder', $medicalConditions) ? 'checked' : '' }}>
                                    <span>Eating disorder (nose, etc.)</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="medical_conditions[]" value="Anxiety/Depression" {{ in_array('Anxiety/Depression', $medicalConditions) ? 'checked' : '' }}>
                                    <span>Anxiety/Depression</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="medical_conditions[]" value="Hernia" {{ in_array('Hernia', $medicalConditions) ? 'checked' : '' }}>
                                    <span>Hernia (painful bulge in the groin area)</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="medical_conditions[]" value="Seizure" {{ in_array('Seizure', $medicalConditions) ? 'checked' : '' }}>
                                    <span>Seizure</span>
                                </label>
                            </div>
                        </div>

                        <div class="question-group">
                            <p class="mb-2">3. Does your child have ever had surgery/ hospitalization?</p>
                            <div class="radio-group">
                                <label class="radio-option">
                                    <input type="radio" name="has_surgery" value="1" {{ isset($student) && $student->has_surgery == '1' ? 'checked' : '' }}>
                                    <span>Yes</span>
                                </label>
                                <label class="radio-option">
                                    <input type="radio" name="has_surgery" value="0" {{ isset($student) && $student->has_surgery == '0' ? 'checked' : '' }}>
                                    <span>No</span>
                                </label>
                            </div>
                            <div id="surgeryDiv" class="conditional-field {{ isset($student) && $student->has_surgery == '1' ? '' : 'hidden' }}">
                                <input type="text" name="surgery_details" value="{{ isset($student) ? $student->surgery_details : old('surgery_details') }}" placeholder="If yes, please identify" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Family History --}}
                <div class="form-section">
                    <h2 class="form-section-title">
                        <i class="fas fa-users"></i>
                        Family History
                    </h2>
                    <p class="mb-3">4. Does anyone in your family have the following conditions:</p>

                    <div class="checkbox-grid">
                        @php
                        $familyHistory = isset($student) ? $student->family_history ?? [] : [];
                        @endphp
                        <label class="checkbox-item">
                            <input type="checkbox" name="family_history[]" value="Tuberculosis" {{ in_array('Tuberculosis', $familyHistory) ? 'checked' : '' }}>
                            <span>Tuberculosis</span>
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="family_history[]" value="Cancer" {{ in_array('Cancer', $familyHistory) ? 'checked' : '' }}>
                            <span>Cancer (if yes, what kind?)</span>
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="family_history[]" value="Stroke/Cardiac Problem" {{ in_array('Stroke/Cardiac Problem', $familyHistory) ? 'checked' : '' }}>
                            <span>Stroke/Cardiac Problem</span>
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="family_history[]" value="Diabetes Mellitus" {{ in_array('Diabetes Mellitus', $familyHistory) ? 'checked' : '' }}>
                            <span>Diabetes Mellitus</span>
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="family_history[]" value="Hypertension" {{ in_array('Hypertension', $familyHistory) ? 'checked' : '' }}>
                            <span>Hypertension</span>
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="family_history[]" value="Depression" {{ in_array('Depression', $familyHistory) ? 'checked' : '' }}>
                            <span>Depression</span>
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="family_history[]" value="Thyroid Problem" {{ in_array('Thyroid Problem', $familyHistory) ? 'checked' : '' }}>
                            <span>Thyroid Problem</span>
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="family_history[]" value="Phobia" {{ in_array('Phobia', $familyHistory) ? 'checked' : '' }}>
                            <span>Phobia (what kind?)</span>
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="family_history[]" value="Others" {{ in_array('Others', $familyHistory) ? 'checked' : '' }}>
                            <span>Others</span>
                        </label>
                    </div>

                    <div class="mt-4">
                        <p class="mb-2">5. Exposure to cigarette/vape smoke at home?</p>
                        <div class="radio-group">
                            <label class="radio-option">
                                <input type="radio" name="smoke_exposure" value="1" {{ isset($student) && $student->smoke_exposure == '1' ? 'checked' : '' }}>
                                <span>Yes</span>
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="smoke_exposure" value="0" {{ isset($student) && $student->smoke_exposure == '0' ? 'checked' : '' }}>
                                <span>No</span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Vaccination History --}}
                <div class="form-section">
                    <h2 class="form-section-title">
                        <i class="fas fa-syringe"></i>
                        Vaccination History
                    </h2>

                    <div class="overflow-x-auto">
                        <table class="vaccination-table">
                            <thead>
                                <tr>
                                    <th>Vaccine</th>
                                    <th>Given YES</th>
                                    <th>Given NO</th>
                                    <th>Date Given</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $vaccines = [
                                    'DP (Diptheria Pertussis)',
                                    'MMR (Measles, Mumps, Rubella)',
                                    'BCG (TB Vaccine)',
                                    'OPV (Oral Polio Vaccine)',
                                    'Rubella',
                                    'Chicken pox Vaccine',
                                    'Hepa B',
                                    'Tetanus',
                                    'Flu Vaccine',
                                    'Pneumococcal Vaccine',
                                    'MRTD Vaccine',
                                    'Hepa A',
                                    'Covid Vaccine',
                                    'Others'
                                ];
                                @endphp

                                @php
                                $vaccinationHistory = isset($student) ? $student->vaccination_history ?? [] : [];
                                @endphp
                                @foreach($vaccines as $vaccine)
                                @php
                                $vaccineSlug = Str::slug($vaccine);
                                $vaccineData = $vaccinationHistory[$vaccineSlug] ?? null;
                                @endphp
                                <tr>
                                    <td>{{ $vaccine }}</td>
                                    <td class="text-center">
                                        <input type="radio" name="vaccine_{{ $vaccineSlug }}" value="yes" {{ $vaccineData && $vaccineData['given'] == 'yes' ? 'checked' : '' }}>
                                    </td>
                                    <td class="text-center">
                                        <input type="radio" name="vaccine_{{ $vaccineSlug }}" value="no" {{ $vaccineData && $vaccineData['given'] == 'no' ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input type="text" name="vaccine_date_{{ $vaccineSlug }}" value="{{ $vaccineData['date'] ?? '' }}" placeholder="Date" class="form-control">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Emergency Contact --}}
                <div class="form-section">
                    <h2 class="form-section-title">
                        <i class="fas fa-phone"></i>
                        Emergency Contact Information
                    </h2>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Contact Person in Case of Emergency</label>
                            <input type="text" name="emergency_contact_name" value="{{ isset($student) ? $student->emergency_contact_name : old('emergency_contact_name') }}" required class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Relation</label>
                            <input type="text" name="emergency_relation" value="{{ isset($student) ? $student->emergency_relation : old('emergency_relation') }}" required class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Address</label>
                            <input type="text" name="emergency_address" value="{{ isset($student) ? $student->emergency_address : old('emergency_address') }}" required class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Phone No.</label>
                            <input type="text" name="emergency_contact_number" value="{{ isset($student) ? $student->emergency_contact_number : old('emergency_contact_number') }}" required class="form-control">
                        </div>
                    </div>

                    <div class="mt-4">
                        <p class="mb-2">If in case your child develops fever, pain, allergies he/she will be given:</p>
                        <div class="checkbox-grid">
                            @php
                            $medications = isset($student) ? $student->medications ?? [] : [];
                            @endphp
                            <label class="checkbox-item">
                                <input type="checkbox" name="medication[]" value="Paracetamol" {{ in_array('Paracetamol', $medications) ? 'checked' : '' }}>
                                <span>Paracetamol</span>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="medication[]" value="Mefenamic" {{ in_array('Mefenamic', $medications) ? 'checked' : '' }}>
                                <span>Mefenamic</span>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="medication[]" value="Loperamide" {{ in_array('Loperamide', $medications) ? 'checked' : '' }}>
                                <span>Loperamide</span>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="medication[]" value="Antihistamine" {{ in_array('Antihistamine', $medications) ? 'checked' : '' }}>
                                <span>Antihistamine</span>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="medication[]" value="Antacid" {{ in_array('Antacid', $medications) ? 'checked' : '' }}>
                                <span>Antacid</span>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="medication[]" value="Nothing" {{ in_array('Nothing', $medications) ? 'checked' : '' }}>
                                <span>Nothing</span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Certification --}}
                <div class="form-section">
                    <h2 class="form-section-title">
                        <i class="fas fa-signature"></i>
                        Certification
                    </h2>
                    <p class="mb-4">I certify that the above information is correct.</p>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Name & Signature of Parent/Guardian</label>
                            <input type="text" name="parent_signature" required class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Date</label>
                            <input type="date" name="signature_date" required class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Relationship to Student</label>
                            <input type="text" name="parent_relationship" required class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Contact Number</label>
                            <input type="text" name="parent_contact" required class="form-control">
                        </div>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="submit-section">
                    <button type="submit" class="submit-btn">
                        <i class="fas fa-paper-plane"></i>
                        Submit Health Record
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Initially disable all form inputs
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('healthForm');
            const inputs = form.querySelectorAll('input, select, textarea');
            const submitBtn = form.querySelector('button[type="submit"]');

            // Disable all inputs initially
            inputs.forEach(input => {
                input.disabled = true;
            });

            // Hide submit button initially
            if (submitBtn) {
                submitBtn.style.display = 'none';
            }
        });

        // Edit button functionality
        document.getElementById('editBtn').addEventListener('click', function() {
            const form = document.getElementById('healthForm');
            const inputs = form.querySelectorAll('input, select, textarea');
            const submitBtn = form.querySelector('button[type="submit"]');

            // Enable all inputs
            inputs.forEach(input => {
                input.disabled = false;
            });

            // Show submit button
            if (submitBtn) {
                submitBtn.style.display = 'block';
            }

            // Change edit button to save mode
            this.innerHTML = '<i class="fas fa-save mr-2"></i>Save Changes';
            this.classList.remove('bg-sky-600', 'hover:bg-sky-700');
            this.classList.add('bg-green-600', 'hover:bg-green-700');
        });

        // Show/hide conditional fields
        document.querySelectorAll('input[name="has_allergies"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const allergiesDiv = document.getElementById('allergiesDiv');
                if (this.value === '1') {
                    allergiesDiv.classList.remove('hidden');
                } else {
                    allergiesDiv.classList.add('hidden');
                }
            });
        });

        document.querySelectorAll('input[name="has_medical_condition"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const medicalDiv = document.getElementById('medicalConditionsDiv');
                if (this.value === '1') {
                    medicalDiv.classList.remove('hidden');
                } else {
                    medicalDiv.classList.add('hidden');
                }
            });
        });

        document.querySelectorAll('input[name="has_surgery"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const surgeryDiv = document.getElementById('surgeryDiv');
                if (this.value === '1') {
                    surgeryDiv.classList.remove('hidden');
                } else {
                    surgeryDiv.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>
