<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Student Information</title>

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
            position: relative;
            z-index: 1001;
        }

        .user-btn:hover {
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .user-btn.active {
            border-color: var(--primary);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary);
            transition: all 0.3s ease;
        }

        .user-btn:hover .user-avatar {
            border-color: var(--primary-dark);
            transform: scale(1.05);
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
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .user-btn:hover .user-avatar-default {
            transform: scale(1.05);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2);
        }

        .user-info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            min-width: 0;
        }

        .user-name {
            font-weight: 600;
            color: var(--dark);
            font-size: 0.9rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 120px;
        }

        .user-role {
            font-size: 0.75rem;
            color: #6b7280;
            font-weight: 500;
        }

        .dropdown-arrow {
            transition: all 0.3s ease;
            color: #6b7280;
        }

        .user-btn.active .dropdown-arrow {
            transform: rotate(180deg);
            color: var(--primary);
        }

        .dropdown-menu {
            position: absolute;
            top: calc(100% + 0.5rem);
            right: 0;
            background: white;
            border-radius: 1rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            min-width: 220px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px) scale(0.95);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            border: 1px solid var(--light);
            overflow: hidden;
        }

        .dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
        }

        .dropdown-header {
            padding: 1rem 1.25rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .dropdown-header .user-name {
            color: white;
            font-size: 1rem;
            max-width: none;
            margin-bottom: 0.25rem;
        }

        .dropdown-header .user-role {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.8rem;
        }

        .dropdown-item {
            padding: 0.875rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.875rem;
            color: var(--dark);
            text-decoration: none;
            transition: all 0.2s ease;
            border-bottom: 1px solid var(--light);
            position: relative;
        }

        .dropdown-item:last-child {
            border-bottom: none;
        }

        .dropdown-item:hover {
            background: linear-gradient(135deg, var(--light), rgba(79, 70, 229, 0.05));
            color: var(--primary);
            transform: translateX(4px);
        }

        .dropdown-item:hover i {
            color: var(--primary);
            transform: scale(1.1);
        }

        .dropdown-item i {
            width: 18px;
            text-align: center;
            transition: all 0.2s ease;
            color: #6b7280;
        }

        .dropdown-divider {
            height: 1px;
            background: var(--light);
            margin: 0.5rem 0;
        }

        .dropdown-item.logout {
            color: var(--danger);
        }

        .dropdown-item.logout:hover {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
        }

        .dropdown-item.logout i {
            color: var(--danger);
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
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .form-control {
            padding: 0.75rem;
            border: 2px solid var(--light);
            border-radius: 0.5rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .form-control[readonly] {
            background: var(--light);
            color: #6b7280;
            cursor: not-allowed;
        }

        .textarea-large {
            min-height: 100px;
            resize: vertical;
        }

        /* Table Styles */
        .table {
            background: white;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .table th {
            background: var(--primary);
            color: white;
            font-weight: 600;
            border: none;
            padding: 1rem;
            text-align: center;
        }

        .table td {
            padding: 1rem;
            border: none;
            text-align: center;
            vertical-align: middle;
        }

        .table tbody tr:nth-child(even) {
            background: var(--light);
        }

        .table tbody tr:hover {
            background: rgba(79, 70, 229, 0.05);
        }

        /* Checkbox and Radio Styles */
        .form-check {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .form-check-input {
            width: 1.2rem;
            height: 1.2rem;
            border: 2px solid var(--light);
            border-radius: 0.25rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .form-check-input:checked {
            background: var(--primary);
            border-color: var(--primary);
        }

        .form-check-input:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .form-check-label {
            font-weight: 500;
            color: var(--dark);
            cursor: pointer;
            margin: 0;
        }

        /* Badge Styles */
        .badge {
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .badge-danger {
            background: var(--danger);
            color: white;
        }

        .badge-warning {
            background: var(--warning);
            color: var(--dark);
        }

        .badge-info {
            background: var(--info);
            color: white;
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

            .welcome-section {
                flex-direction: column;
                text-align: center;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .table-responsive {
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a class="navbar-brand" href="{{ route('student.dashboard') }}">
                <i class="fas fa-clinic-medical"></i>
                PDMHS Clinic
            </a>

            <ul class="navbar-menu">
                <li><a class="nav-link" href="{{ route('student.dashboard') }}"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
                <li><a class="nav-link active" href="{{ route('student.medical') }}"><i class="fas fa-notes-medical"></i>My Medical</a></li>
            </ul>

            <div class="user-dropdown">
                <button class="user-btn" id="userBtn" onclick="toggleDropdown()">
                    @if($user->profile_picture && file_exists(public_path($user->profile_picture)))
                        <img src="{{ asset($user->profile_picture) }}" alt="Profile" class="user-avatar">
                    @else
                        <div class="user-avatar-default">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="user-info">
                        <span class="user-name">{{ $user->name }}</span>
                        <span class="user-role">Student</span>
                    </div>
                    <i class="fas fa-chevron-down dropdown-arrow"></i>
                </button>

                <div class="dropdown-menu" id="userDropdown">
                    <div class="dropdown-header">
                        <div class="user-name">{{ $user->name }}</div>
                        <div class="user-role">{{ $user->email }}</div>
                    </div>
                    <a class="dropdown-item" href="{{ route('student.profile') }}">
                        <i class="fas fa-user-edit"></i>
                        <span>Profile Settings</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item logout" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
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
                <h1>Student Information</h1>
                <p>View your complete personal and medical information</p>
            </div>
        </div>

        <!-- Student Information Section -->
        <div class="section-card">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fas fa-user-graduate"></i>
                    Student Information
                </h2>
            </div>

            <form>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Name of Learner</label>
                        <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label class="form-label">LRN</label>
                        <input type="text" class="form-control" value="{{ $student->lrn ?? '000001' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label class="form-label">School</label>
                        <input type="text" class="form-control" value="Don Dada High School" readonly>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Grade Level & Section</label>
                        <input type="text" class="form-control" value="{{ $student->grade_level ?? '12 - STEM-1' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Birthday</label>
                        <input type="text" class="form-control" value="{{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('m/d/Y') : '04/01/2005' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Sex/Age</label>
                        <input type="text" class="form-control" value="{{ $student->gender ?? 'F' }}/{{ $age ?? '20' }}" readonly>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Adviser</label>
                        <input type="text" class="form-control" value="{{ $adviser->name ?? 'Ms. Rea Loloy' }}" readonly>
                    </div>
                </div>
            </form>
        </div>

        <!-- Contact Information Section -->
        <div class="section-card">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fas fa-address-book"></i>
                    Contact Information
                </h2>
                <button class="btn btn-outline" onclick="alert('Edit functionality coming soon!')">
                    <i class="fas fa-edit"></i>
                    Edit
                </button>
            </div>
            
            <form>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Contact Person in Case of Emergency</label>
                        <input type="text" class="form-control" value="{{ $student->emergency_contact ?? 'Parent: 09123456789' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Relation</label>
                        <input type="text" class="form-control" value="e.g., Mother, Father, Guardian" readonly>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Address</label>
                        <textarea class="form-control textarea-large" readonly>{{ $student->address ?? 'Test Address Update' }}</textarea>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Phone No.</label>
                        <input type="text" class="form-control" placeholder="Enter phone number" readonly>
                    </div>
                </div>
            </form>
        </div>

        <!-- Medical History Section -->
        <div class="section-card">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fas fa-history"></i>
                    Medical History (For Learners)
                </h2>
            </div>
            
            <form>
                <div class="mb-4">
                    <label class="form-label fw-bold">1. Does your child have any allergies?</label>
                    
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label class="form-label">Medicine</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="medicine_allergy" id="medicine_yes" disabled>
                                    <label class="form-check-label" for="medicine_yes">Yes</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="medicine_allergy" id="medicine_no" checked disabled>
                                    <label class="form-check-label" for="medicine_no">No</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <label class="form-label">Pollen</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="pollen_allergy" id="pollen_yes" disabled>
                                    <label class="form-check-label" for="pollen_yes">Yes</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="pollen_allergy" id="pollen_no" checked disabled>
                                    <label class="form-check-label" for="pollen_no">No</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <label class="form-label">Food</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="food_allergy" id="food_yes" checked disabled>
                                    <label class="form-check-label" for="food_yes">Yes</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="food_allergy" id="food_no" disabled>
                                    <label class="form-check-label" for="food_no">No</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <label class="form-label">Stinging Insects</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="insects_allergy" id="insects_yes" disabled>
                                    <label class="form-check-label" for="insects_yes">Yes</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="insects_allergy" id="insects_no" checked disabled>
                                    <label class="form-check-label" for="insects_no">No</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <label class="form-label fw-bold">Known Allergies:</label>
                        <div class="d-flex gap-2 mt-2">
                            <span class="badge badge-danger">Peanuts</span>
                            <span class="badge badge-warning">Shellfish</span>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">2. Does your child have any ongoing medical condition?</label>
                    
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="refractive_error" disabled>
                                <label class="form-check-label" for="refractive_error">Error of refraction (Wearing Corrective Lenses)</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="anemia" disabled>
                                <label class="form-check-label" for="anemia">Anemia</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="heart_problem" disabled>
                                <label class="form-check-label" for="heart_problem">Heart problem</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="anxiety_depression" disabled>
                                <label class="form-check-label" for="anxiety_depression">Anxiety/Depression</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="bleeding_disorder" disabled>
                                <label class="form-check-label" for="bleeding_disorder">Bleeding disorder (nose, etc.)</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="seizure" disabled>
                                <label class="form-check-label" for="seizure">Seizure</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="hernia" disabled>
                                <label class="form-check-label" for="hernia">Hernia (pagdol bulge in the groin area)</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="asthma" disabled>
                                <label class="form-check-label" for="asthma">Asthma</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">3. Does your child have ever had surgery/hospitalization?</label>
                    <div class="d-flex gap-3 mt-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="surgery_history" id="surgery_yes" disabled>
                            <label class="form-check-label" for="surgery_yes">Yes</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="surgery_history" id="surgery_no" checked disabled>
                            <label class="form-check-label" for="surgery_no">No</label>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h5 class="section-title mb-3">Family History</h5>
                    <label class="form-label fw-bold">4. Does anyone in your family have the following conditions:</label>
                    
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="family_tuberculosis" disabled>
                                <label class="form-check-label" for="family_tuberculosis">Tuberculosis</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="family_depression" disabled>
                                <label class="form-check-label" for="family_depression">Depression</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="family_cancer" disabled>
                                <label class="form-check-label" for="family_cancer">Cancer</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="family_thyroid" disabled>
                                <label class="form-check-label" for="family_thyroid">Thyroid Problem</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="family_stroke" disabled>
                                <label class="form-check-label" for="family_stroke">Stroke/Cardiac Problem</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="family_phobia" disabled>
                                <label class="form-check-label" for="family_phobia">Phobia</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="family_diabetes" disabled>
                                <label class="form-check-label" for="family_diabetes">Diabetes Mellitus</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="family_hypertension" disabled>
                                <label class="form-check-label" for="family_hypertension">Hypertension</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">5. Exposure to cigarette/vape smoke at home?</label>
                    <div class="d-flex gap-3 mt-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="smoke_exposure" id="smoke_yes" disabled>
                            <label class="form-check-label" for="smoke_yes">Yes</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="smoke_exposure" id="smoke_no" checked disabled>
                            <label class="form-check-label" for="smoke_no">No</label>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Vaccination History Section -->
        <div class="section-card">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fas fa-syringe"></i>
                    Vaccination History (Dates of Immunization)
                </h2>
                <span class="badge badge-info">Read Only</span>
            </div>
            
            <form>
                <div class="table-responsive">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 25%;">Vaccine</th>
                                <th style="width: 15%;">Given (Yes/No)</th>
                                <th style="width: 20%;">Date Given</th>
                                <th style="width: 40%;">Given By (Family/Health Center)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>DPT (Diphtheria Pertussis)</td>
                                <td class="text-center">✓</td>
                                <td>3-24-12</td>
                                <td>Health Center</td>
                            </tr>
                            <tr>
                                <td>OPV (Oral polio Vaccine)</td>
                                <td class="text-center">✓</td>
                                <td>3-24-12</td>
                                <td>Health Center</td>
                            </tr>
                            <tr>
                                <td>BCG (TB Vaccine)</td>
                                <td class="text-center">✓</td>
                                <td>6-18-13</td>
                                <td>Health Center</td>
                            </tr>
                            <tr>
                                <td>MMR (Measles Mumps Rubella)</td>
                                <td class="text-center">✓</td>
                                <td>-</td>
                                <td>Health Center</td>
                            </tr>
                            <tr>
                                <td>Chicken pox Vaccine</td>
                                <td class="text-center">-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>Hepa B</td>
                                <td class="text-center">✓</td>
                                <td>4-6-12</td>
                                <td>Health Center</td>
                            </tr>
                            <tr>
                                <td>Tetanus</td>
                                <td class="text-center">-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>Flu Vaccine</td>
                                <td class="text-center">-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>Pneumococcal Vaccine</td>
                                <td class="text-center">-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>MR-TD Vaccine</td>
                                <td class="text-center">-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>Cervical Vaccine</td>
                                <td class="text-center">-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>Covid Vaccine</td>
                                <td class="text-center">✓</td>
                                <td>-</td>
                                <td>Health Center</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>

        <!-- Emergency Medication Protocol Section -->
        <div class="section-card">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fas fa-pills"></i>
                    Emergency Medication Protocol
                </h2>
            </div>
            
            <form>
                <div class="mb-4">
                    <label class="form-label fw-bold">If in case your child develops fever, pain, allergic he/she will be given:</label>
                    
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="paracetamol" checked disabled>
                                <label class="form-check-label" for="paracetamol">Paracetamol</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="mefenamic" disabled>
                                <label class="form-check-label" for="mefenamic">Mefenamic</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="antihistamine" disabled>
                                <label class="form-check-label" for="antihistamine">Antihistamine</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="amoxil" disabled>
                                <label class="form-check-label" for="amoxil">Amoxil</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="loperamide" disabled>
                                <label class="form-check-label" for="loperamide">Loperamide</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="nothing" disabled>
                                <label class="form-check-label" for="nothing">Nothing</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="others_specify" disabled>
                                <label class="form-check-label" for="others_specify">Others, specify</label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
        </div> <!-- End Main Container -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Dropdown toggle functionality
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

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 10) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>
