<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Adviser Dashboard - PDMHS Clinic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:wght@400;500;600;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
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
            background: var(--gradient);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            min-height: 100vh;
        }
        .stat-card {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            border: none;
            padding: 1.5rem;
            margin-bottom: 1rem;
            font-weight: 500;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            color: white;
        }
        .stat-card h2 {
            font-family: 'Roboto', sans-serif;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: white;
        }
        .stat-card p {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            font-size: 25px;
            font-weight: 700;
            color: white;
            opacity: 0.95;
        }
        
        .btn-action {
            background: white;
            border: 2px solid #e8ecf4;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            color: var(--primary);
            font-weight: 600;
            transition: all 0.3s ease;
            min-height: 120px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        
        .btn-action:hover {
            background: var(--gradient);
            color: white;
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(30, 64, 175, 0.2);
        }
        
        .btn-action i {
            font-size: 2rem;
        }
        
        .student-name {
            font-family: 'Albert Sans', sans-serif !important;
            font-weight: 500 !important;
            font-size: 20px !important;
        }
        
        .student-info {
            font-family: 'Albert Sans', sans-serif !important;
            font-weight: 500 !important;
            font-size: 20px !important;
            color: #6c757d !important;
        }
        
        .visit-name {
            font-family: 'Albert Sans', sans-serif !important;
            font-weight: 500 !important;
            font-size: 20px !important;
        }
        
        .visit-type {
            font-family: 'Albert Sans', sans-serif !important;
            font-weight: 500 !important;
            font-size: 20px !important;
            color: #6c757d !important;
        }
        
        .visit-date {
            font-family: 'Albert Sans', sans-serif !important;
            font-weight: 500 !important;
            font-size: 20px !important;
        }
        
        .visit-status {
            font-family: 'Albert Sans', sans-serif !important;
            font-weight: 500 !important;
            font-size: 20px !important;
        }
        
        .section-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(220, 220, 250, 0.95) 100%);
            backdrop-filter: blur(10px);
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
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .section-header h5 {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 700;
            font-size: 30px;
            margin-bottom: 0;
        }
        .section-content {
            padding: 2rem;
            text-align: center;
            color: #6c757d;
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
            margin: 0;
            padding: 0;
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
            border: 2px solid #f3f4f6;
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
            border-bottom: 1px solid #f3f4f6;
        }

        .dropdown-item:last-child {
            border-bottom: none;
        }

        .dropdown-item:hover {
            background: #f3f4f6;
        }
        .welcome-header {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 800;
            font-size: 35px;
        }
        
        .welcome-container {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(220, 220, 250, 0.95) 100%);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .profile-pic-large {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--primary);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            flex-shrink: 0;
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
            flex-shrink: 0;
        }
        
        .dashboard-subtitle {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 700;
            font-size: 25px;
            margin-bottom: 0;
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
                <li><a class="nav-link active" href="{{ route('adviser.dashboard') }}"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
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
                    <a href="{{ route('adviser.profile') }}" class="dropdown-item">
                        <i class="fas fa-user-cog"></i>
                        Profile Settings
                    </a>
                    <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit(); return false;">
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

    <div class="container mt-4">
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="font-family: 'Epilogue', sans-serif; font-size: 20px; font-weight: 500;">
                <i class="fas fa-check-circle me-2"></i>
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Error!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Tab Content -->
        <div id="dashboardContent">
            <!-- Dashboard Section (Main Content) -->
            <div id="dashboard-section" class="content-section">
                <!-- Header -->
                <div class="mb-4">
                    <div class="welcome-container">
                        @if($user->profile_picture && file_exists(public_path($user->profile_picture)))
                            <img src="{{ asset($user->profile_picture) }}" alt="Profile Picture" class="profile-pic-large">
                        @else
                            <div class="profile-pic-default-large">
                                <i class="fas fa-user"></i>
                            </div>
                        @endif
                        <div>
                            <h1 class="h3 mb-1 welcome-header">Welcome, {{ $user->name }}!</h1>
                            <p class="text-muted dashboard-subtitle">
                                @if($adviser)
                                    Adviser Class - {{ $adviser->first_name }} {{ $adviser->last_name }}
                                @else
                                    Adviser Dashboard
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <div class="stat-card stat-card-blue">
                            <h2>{{ $totalStudents ?? 3 }}</h2>
                            <p>Total Students</p>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="stat-card stat-card-orange">
                            <h2>{{ isset($recentVisits) ? $recentVisits->count() : 1 }}</h2>
                            <p>Clinic Visits (This Month)</p>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="stat-card stat-card-yellow">
                            <h2>{{ $studentsWithAllergies ?? 1 }}</h2>
                            <p>With Allergies</p>
                        </div>
                    </div>
                </div>

                <!-- Students Under Your Advisory -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="section-card">
                            <div class="section-header">
                                <h5 class="mb-0"><i class="fas fa-users me-2"></i>Students Under Your Advisory</h5>
                                <small class="text-muted">{{ $totalStudents }} students</small>
                            </div>
                            <div class="section-content">
                                @if($students->count() > 0)
                                    <div class="row">
                                        @foreach($students as $student)
                                            <div class="col-md-4 mb-3">
                                                <div class="student-card text-center">
                                                    <div class="student-avatar mb-2">
                                                        <i class="fas fa-user-circle" style="font-size: 3rem; color: #6c757d;"></i>
                                                    </div>
                                                    <h6 class="student-name">{{ $student->first_name }} {{ $student->last_name }}</h6>
                                                    <p class="student-info text-muted small">
                                                        {{ $student->grade_level ?? 'N/A' }}<br>
                                                        Grade {{ $student->grade_level ?? 'N/A' }} - {{ $student->section ?? 'N/A' }}
                                                    </p>
                                                    <a href="{{ route('adviser.student-profile', $student->id) }}" class="btn btn-sm btn-primary">View Profile</a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <i class="fas fa-users text-muted" style="font-size: 3rem;"></i>
                                        <h6 class="text-muted mt-3">No Students Assigned</h6>
                                        <p class="text-muted small">No students have been assigned to your advisory yet.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Clinic Activity -->
                <div class="row">
                    <div class="col-12">
                        <div class="section-card">
                            <div class="section-header">
                                <h5 class="mb-0"><i class="fas fa-history me-2"></i>Recent Clinic Activity</h5>
                            </div>
                            <div class="section-content">
                                @if($recentVisits->count() > 0)
                                    @foreach($recentVisits as $visit)
                                        <div class="clinic-activity-item d-flex align-items-center p-3 border-bottom">
                                            <div class="activity-icon me-3">
                                                <i class="fas fa-user-injured text-primary"></i>
                                            </div>
                                            <div class="activity-details">
                                                <p class="mb-1">
                                                    <strong>{{ $visit->student->first_name }} {{ $visit->student->last_name }}</strong>
                                                    visited the clinic - {{ $visit->chief_complaint ?? 'General checkup' }}
                                                </p>
                                                <small class="text-muted">
                                                    {{ $visit->visit_date ? $visit->visit_date->format('M d, Y h:i A') : 'Date not set' }}
                                                </small>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center py-4">
                                        <i class="fas fa-history text-muted" style="font-size: 2rem;"></i>
                                        <h6 class="text-muted mt-2">No Recent Activity</h6>
                                        <p class="text-muted small">No clinic visits recorded for your students in the last 30 days.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alerts Section -->
            <div id="alerts-section" class="content-section" style="display: none;">
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="section-card">
                            <div class="section-header">
                                <h5 class="mb-0"><i class="fas fa-bell me-2"></i>Alerts & Notifications</h5>
                                <small class="text-muted">Messages from Clinic Staff regarding your students</small>
                            </div>
                            <div class="section-content">
                                @if(isset($notifications) && $notifications->count() > 0)
                                    <div class="notifications-list">
                                        @foreach($notifications as $notification)
                                            <div class="notification-item d-flex align-items-start p-3 border-bottom {{ !$notification->is_read ? 'bg-light' : '' }}">
                                                <div class="notification-icon me-3">
                                                    @if($notification->type == 'clinic_visit')
                                                        <i class="fas fa-user-injured text-primary"></i>
                                                    @elseif($notification->type == 'health_alert')
                                                        <i class="fas fa-exclamation-triangle text-warning"></i>
                                                    @else
                                                        <i class="fas fa-info-circle text-info"></i>
                                                    @endif
                                                </div>
                                                <div class="notification-content flex-grow-1">
                                                    <h6 class="notification-title mb-1">{{ $notification->title }}</h6>
                                                    <p class="notification-message mb-1">{{ $notification->message }}</p>
                                                    <small class="text-muted">{{ $notification->time_ago }}</small>
                                                    @if(!$notification->is_read)
                                                        <span class="badge bg-primary ms-2">New</span>
                                                    @endif
                                                </div>
                                                <div class="notification-actions">
                                                    @if(!$notification->is_read)
                                                        <button class="btn btn-sm btn-outline-primary" onclick="markAsRead({{ $notification->id }})">
                                                            Mark as Read
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <i class="fas fa-bell-slash text-muted" style="font-size: 3rem;"></i>
                                        <h5 class="text-muted mt-3">No Alerts Yet</h5>
                                        <p class="text-muted" style="font-style: italic;">You will receive notifications here when clinic staff sends updates about your students' health visits.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Health Status Section -->
            <div id="health-status-section" class="content-section" style="display: none;">
                <!-- Health Status Overview -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="section-card">
                            <div class="section-header">
                                <h5 class="mb-0"><i class="fas fa-heartbeat me-2"></i>Health Status Overview</h5>
                                <small class="text-muted">Summary of health status for students under your advisory</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <div class="stat-card" style="background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%); color: white; text-align: center;">
                            <h2>{{ $totalStudents ?? 3 }}</h2>
                            <p>Total Students</p>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="stat-card" style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); color: white; text-align: center;">
                            <h2>{{ isset($recentVisits) ? $recentVisits->count() : 1 }}</h2>
                            <p>With Clinic Visits</p>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="stat-card" style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); color: white; text-align: center;">
                            <h2>{{ $studentsWithAllergies ?? 1 }}</h2>
                            <p>With Allergies</p>
                        </div>
                    </div>
                </div>

                <!-- Student Health Cards -->
                <div class="row">
                    @if($students->count() > 0)
                        @foreach($students as $student)
                            <div class="col-lg-4 mb-4">
                                <div class="card h-100" style="border-radius: 12px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                                    <div class="card-body p-4">
                                        <!-- Student Header -->
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="student-avatar me-3">
                                                <i class="fas fa-user-circle" style="font-size: 2.5rem; color: #6c757d;"></i>
                                            </div>
                                            <div>
                                                <h6 class="student-name mb-1">{{ $student->first_name }} {{ $student->last_name }}</h6>
                                                <p class="student-info text-muted small mb-0">
                                                    Grade {{ $student->grade_level ?? 'N/A' }} - {{ $student->section ?? 'N/A' }}
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Basic Info -->
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <div class="text-center p-2" style="background: #f8f9fa; border-radius: 8px;">
                                                    <i class="fas fa-heartbeat text-danger mb-1"></i>
                                                    <div class="small text-muted">Blood Type</div>
                                                    <div class="fw-bold">{{ $student->blood_type ?? 'N/A' }}</div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="text-center p-2" style="background: #f8f9fa; border-radius: 8px;">
                                                    <i class="fas fa-user text-primary mb-1"></i>
                                                    <div class="small text-muted">Gender</div>
                                                    <div class="fw-bold">{{ $student->gender ? ucfirst($student->gender) : 'N/A' }}</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <div class="text-center p-2" style="background: #f8f9fa; border-radius: 8px;">
                                                    <i class="fas fa-calendar text-info mb-1"></i>
                                                    <div class="small text-muted">Age</div>
                                                    <div class="fw-bold">
                                                        @if($student->date_of_birth)
                                                            {{ \Carbon\Carbon::parse($student->date_of_birth)->age }}
                                                        @else
                                                            N/A
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="text-center p-2" style="background: #f8f9fa; border-radius: 8px;">
                                                    <i class="fas fa-phone text-success mb-1"></i>
                                                    <div class="small text-muted">Contact</div>
                                                    <div class="fw-bold">{{ $student->contact_number ?? 'N/A' }}</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Last Clinic Visit -->
                                        <div class="mb-3">
                                            <h6 class="visit-name mb-2">Last Clinic Visit</h6>
                                            <div class="visit-info p-2" style="background: #f8f9fa; border-radius: 8px;">
                                                @if($student->clinicVisits && $student->clinicVisits->count() > 0)
                                                    @php $lastVisit = $student->clinicVisits->first(); @endphp
                                                    <div class="visit-date fw-bold">{{ $lastVisit->visit_date ? $lastVisit->visit_date->format('M d, Y') : 'Date not set' }}</div>
                                                    <div class="visit-type text-muted small">
                                                        {{ $lastVisit->chief_complaint ?? 'General checkup' }}
                                                        @if($lastVisit->visit_date)
                                                            {{ $lastVisit->visit_date->format('h:i A') }}
                                                        @endif
                                                    </div>
                                                    @if($lastVisit->status)
                                                        <div class="visit-status">
                                                            <span class="badge bg-{{ $lastVisit->status == 'completed' ? 'success' : 'warning' }} text-dark">
                                                                {{ ucfirst($lastVisit->status) }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="visit-type text-muted small">No clinic visits recorded</div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Action Button -->
                                        <button class="btn btn-primary w-100" style="border-radius: 8px;">
                                            View Full Record
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12">
                            <div class="text-center py-5">
                                <i class="fas fa-users text-muted" style="font-size: 3rem;"></i>
                                <h6 class="text-muted mt-3">No Students Assigned</h6>
                                <p class="text-muted">No students have been assigned to your advisory yet.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navigation function to show different sections
        function showTab(tabName) {
            // Hide all content sections
            const sections = document.querySelectorAll('.content-section');
            sections.forEach(section => {
                section.style.display = 'none';
            });
            
            // Show the selected section
            const targetSection = document.getElementById(tabName + '-section');
            if (targetSection) {
                targetSection.style.display = 'block';
            }
            
            // Update navbar active states
            const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
            navLinks.forEach(link => {
                link.classList.remove('active');
            });
            
            // Set active state based on tab
            if (tabName === 'dashboard') {
                document.querySelector('.navbar-nav .nav-link[href*="dashboard"]').classList.add('active');
            } else {
                document.querySelector('.navbar-nav .nav-link[onclick*="' + tabName + '"]').classList.add('active');
            }
        }
        
        // Initialize dashboard view
        document.addEventListener('DOMContentLoaded', function() {
            showTab('dashboard');
        });
        
        // Function to mark notification as read
        function markAsRead(notificationId) {
            // This would typically make an AJAX call to mark the notification as read
            alert('Mark as read functionality will be implemented soon.');
        }

        // Dropdown toggle
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('show');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('userDropdown');
            const userBtn = document.querySelector('.user-btn');
            if (dropdown && !userBtn.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });

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