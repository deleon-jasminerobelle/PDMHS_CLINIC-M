<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Medical Visits History</title>

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
            --gradient: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
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

        /* Medical History Timeline */
        .timeline-section {
            background: white;
            border-radius: 1.5rem;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 0.5s ease;
        }

        .timeline {
            position: relative;
            padding-left: 2rem;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 1rem;
            top: 0;
            bottom: 0;
            width: 3px;
            background: linear-gradient(to bottom, var(--primary), var(--secondary));
            border-radius: 2px;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 2rem;
            padding-left: 2rem;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -1.5rem;
            top: 1.5rem;
            width: 1rem;
            height: 1rem;
            border-radius: 50%;
            background: var(--primary);
            border: 3px solid white;
            box-shadow: 0 0 0 2px var(--primary);
            z-index: 1;
        }

        .timeline-item.completed::before {
            background: var(--success);
            box-shadow: 0 0 0 2px var(--success);
        }

        .timeline-item.pending::before {
            background: var(--warning);
            box-shadow: 0 0 0 2px var(--warning);
        }

        .timeline-item.emergency::before {
            background: var(--danger);
            box-shadow: 0 0 0 2px var(--danger);
        }

        .timeline-content {
            background: var(--light);
            border-radius: 1rem;
            padding: 1.5rem;
            border-left: 4px solid var(--primary);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .timeline-content:hover {
            transform: translateX(5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            border-left-color: var(--primary-dark);
        }

        .timeline-item.completed .timeline-content {
            border-left-color: var(--success);
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.05), rgba(255, 255, 255, 0.5));
        }

        .timeline-item.pending .timeline-content {
            border-left-color: var(--warning);
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.05), rgba(255, 255, 255, 0.5));
        }

        .timeline-item.emergency .timeline-content {
            border-left-color: var(--danger);
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.05), rgba(255, 255, 255, 0.5));
        }

        .timeline-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .timeline-date {
            font-weight: 700;
            color: var(--dark);
            font-size: 1.1rem;
        }

        .timeline-type {
            font-size: 0.875rem;
            color: #6b7280;
            background: white;
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            border: 1px solid var(--light);
        }

        .timeline-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .timeline-detail {
            display: flex;
            flex-direction: column;
        }

        .timeline-detail-label {
            font-size: 0.8rem;
            color: #6b7280;
            font-weight: 600;
            margin-bottom: 0.25rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .timeline-detail-value {
            font-weight: 600;
            color: var(--dark);
            font-size: 0.95rem;
        }

        .timeline-reason {
            background: white;
            padding: 1rem;
            border-radius: 0.5rem;
            border-left: 3px solid var(--primary);
            margin-top: 1rem;
        }

        .timeline-reason-label {
            font-size: 0.85rem;
            color: #6b7280;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .timeline-reason-text {
            color: var(--dark);
            line-height: 1.5;
        }

        .timeline-empty {
            text-align: center;
            padding: 3rem;
            color: #6b7280;
        }

        .timeline-empty i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--success);
            opacity: 0.5;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #6b7280;
        }

        .empty-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
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
            }

            .table-responsive {
                font-size: 0.85rem;
            }

            .visit-header {
                flex-direction: column;
                gap: 0.5rem;
            }

            .visit-details {
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
                <i class="fas fa-clinic-medical"></i>
                PDMHS Clinic
            </a>

            <ul class="navbar-menu">
                <li><a class="nav-link" href="{{ route('student.dashboard') }}"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
                <li><a class="nav-link active" href="{{ route('student.medical') }}"><i class="fas fa-notes-medical"></i>My Medical</a></li>
                <li><a class="nav-link" href="{{ route('health-form.index') }}"><i class="fas fa-clipboard-list"></i>Health Form</a></li>
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
                <h1>Medical Visits History</h1>
                <p>View your complete medical visit records and history</p>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="section-card">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fas fa-filter"></i>
                    Filter Visits
                </h2>
            </div>

            <form>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Date Range</label>
                        <select class="form-control">
                            <option>Last 30 days</option>
                            <option>Last 3 months</option>
                            <option>Last 6 months</option>
                            <option>Last year</option>
                            <option>All time</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Visit Type</label>
                        <select class="form-control">
                            <option>All visits</option>
                            <option>Regular checkup</option>
                            <option>Illness</option>
                            <option>Injury</option>
                            <option>Emergency</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select class="form-control">
                            <option>All status</option>
                            <option>Completed</option>
                            <option>Pending</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">&nbsp;</label>
                        <button class="btn btn-primary">
                            <i class="fas fa-search"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Medical History Timeline Section -->
        <div class="timeline-section">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fas fa-history"></i>
                    Medical History Timeline ({{ count($clinicVisits) }} visits)
                </h2>
                <a href="{{ route('student.medical') }}" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i>
                    Back to Medical Records
                </a>
            </div>

            @if(count($clinicVisits) > 0)
                <div class="timeline">
                    @foreach($clinicVisits as $visit)
                    <div class="timeline-item {{ strtolower($visit['status']) }} {{ $visit['type'] == 'Emergency' ? 'emergency' : '' }}">
                        <div class="timeline-content">
                            <div class="timeline-header">
                                <div>
                                    <div class="timeline-date">{{ $visit['date'] }}</div>
                                    <div class="timeline-type">{{ $visit['type'] }}</div>
                                </div>
                                <span class="timeline-type">{{ $visit['status'] }}</span>
                            </div>

                            <div class="timeline-details">
                                <div class="timeline-detail">
                                    <span class="timeline-detail-label">Attended By</span>
                                    <span class="timeline-detail-value">{{ $visit['attendedBy'] }}</span>
                                </div>
                                <div class="timeline-detail">
                                    <span class="timeline-detail-label">Temperature</span>
                                    <span class="timeline-detail-value">{{ $visit['temperature'] ?? 'Not recorded' }}</span>
                                </div>
                                <div class="timeline-detail">
                                    <span class="timeline-detail-label">Blood Pressure</span>
                                    <span class="timeline-detail-value">{{ $visit['bloodPressure'] ?? 'Not recorded' }}</span>
                                </div>
                                <div class="timeline-detail">
                                    <span class="timeline-detail-label">Weight</span>
                                    <span class="timeline-detail-value">{{ $visit['weight'] ?? 'Not recorded' }}</span>
                                </div>
                                <div class="timeline-detail">
                                    <span class="timeline-detail-label">Height</span>
                                    <span class="timeline-detail-value">{{ $visit['height'] ?? 'Not recorded' }}</span>
                                </div>
                            </div>

                            @if(isset($visit['reason']) && $visit['reason'])
                            <div class="timeline-reason">
                                <div class="timeline-reason-label">Reason for Visit</div>
                                <p class="timeline-reason-text">{{ $visit['reason'] }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="timeline-empty">
                    <div class="timeline-empty-icon">
                        <i class="fas fa-history"></i>
                    </div>
                    <h4>No Medical Visits Found</h4>
                    <p>Your medical history timeline will appear here once you have clinic visits recorded.</p>
                </div>
            @endif
        </div>
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