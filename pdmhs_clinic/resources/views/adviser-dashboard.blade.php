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
            background-color: #f8f9fa;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        .stat-card {
            border-radius: 12px;
            border: none;
            padding: 1.5rem;
            margin-bottom: 1rem;
            color: white;
            font-weight: 500;
            text-align: center;
        }
        .stat-card h2 {
            font-family: 'Roboto', sans-serif;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .stat-card p {
            margin: 0;
            opacity: 0.9;
            font-family: 'Roboto', sans-serif;
            font-size: 25px;
            font-weight: 700;
        }
        .stat-card-blue { background: var(--gradient); }
        .stat-card-orange { background: var(--gradient); }
        .stat-card-yellow { background: var(--gradient); }
        .stat-card-purple { background: var(--gradient); }
        
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
        .navbar-brand {
            font-weight: 600;
        }
        
        .navbar-nav .nav-link {
            font-family: 'Epilogue', sans-serif !important;
            font-size: 25px !important;
            font-weight: 600 !important;
        }
        
        .dropdown-menu .dropdown-item {
            font-family: 'Epilogue', sans-serif !important;
            font-size: 20px !important;
            font-weight: 500 !important;
        }
        .welcome-header {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 800;
            font-size: 35px;
        }
        
        .dashboard-subtitle {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 700;
            font-size: 25px;
            margin-bottom: 0;
        }
        
        .secondary-nav {
            background: white;
            border-bottom: 1px solid #e9ecef;
            padding: 0;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        .secondary-nav .nav-tabs {
            border-bottom: none;
            padding: 0 2rem;
        }
        
        .secondary-nav .nav-tabs .nav-link {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 600;
            font-size: 18px;
            color: #6c757d;
            border: none;
            border-bottom: 3px solid transparent;
            padding: 1rem 2rem;
            margin-right: 1rem;
            background: transparent;
            transition: all 0.3s ease;
        }
        
        .secondary-nav .nav-tabs .nav-link:hover {
            color: var(--primary);
            border-bottom-color: rgba(30, 64, 175, 0.3);
            background: rgba(30, 64, 175, 0.05);
        }
        
        .secondary-nav .nav-tabs .nav-link.active {
            color: var(--primary) !important;
            border-bottom-color: var(--primary) !important;
            background: rgba(30, 64, 175, 0.05) !important;
            font-weight: 700 !important;
        }
        
        /* Fix for top navigation tabs */
        .nav-tabs .nav-link {
            font-family: 'Albert Sans', sans-serif;
            font-size: 16px;
            font-weight: 600;
            color: #6c757d;
            border: none;
            border-bottom: 2px solid transparent;
            background: transparent;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
        }
        
        .nav-tabs .nav-link:hover {
            color: #1e40af;
            border-bottom-color: rgba(30, 64, 175, 0.3);
            background: rgba(30, 64, 175, 0.05);
        }
        
        .nav-tabs .nav-link.active {
            color: #1e40af !important;
            border-bottom-color: #1e40af !important;
            background: rgba(30, 64, 175, 0.05) !important;
            font-weight: 700 !important;
        }
        
        .tab-content {
            padding: 0 2rem;
        }
        
        /* Navbar Tab Styling */
        .navbar .nav-pills .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            border-radius: 8px;
            margin: 0 0.5rem;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }
        
        .navbar .nav-pills .nav-link:hover {
            color: white !important;
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .navbar .nav-pills .nav-link.active {
            color: white !important;
            background-color: rgba(255, 255, 255, 0.2);
            border-bottom: 2px solid white;
        }
    </style>
</head>
<body>
    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg" style="background: white; border-bottom: 1px solid #e9ecef; padding: 0.5rem 0;">
        <div class="container">
            <!-- Navigation Tabs -->
            <ul class="nav nav-tabs border-0" id="dashboardTabs" role="tablist" style="margin-bottom: 0;">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="dashboard-tab" data-bs-toggle="tab" data-bs-target="#dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="true" style="font-family: 'Albert Sans', sans-serif; font-size: 16px; font-weight: 600; color: #1e40af; border: none; border-bottom: 2px solid #1e40af; background: transparent; padding: 0.75rem 1.5rem;">
                        Dashboard
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="alerts-tab" data-bs-toggle="tab" data-bs-target="#alerts" type="button" role="tab" aria-controls="alerts" aria-selected="false" style="font-family: 'Albert Sans', sans-serif; font-size: 16px; font-weight: 600; color: #6c757d; border: none; border-bottom: 2px solid transparent; background: transparent; padding: 0.75rem 1.5rem;">
                        Alerts
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="health-status-tab" data-bs-toggle="tab" data-bs-target="#health-status" type="button" role="tab" aria-controls="health-status" aria-selected="false" style="font-family: 'Albert Sans', sans-serif; font-size: 16px; font-weight: 600; color: #6c757d; border: none; border-bottom: 2px solid transparent; background: transparent; padding: 0.75rem 1.5rem;">
                        Health Status
                    </button>
                </li>
            </ul>
            
            <!-- User Profile Dropdown -->
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: #6c757d;">
                        <i class="fas fa-user me-1"></i>
                        {{ $user->name }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('adviser.profile') }}"><i class="fas fa-user-cog me-2"></i>Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
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
        <div class="tab-content" id="dashboardTabsContent">
            <!-- Dashboard Tab (Main Content) -->
            <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                <!-- Header -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
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
                                                    <button class="btn btn-sm btn-primary">View Profile</button>
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

            <!-- Alerts Tab -->
            <div class="tab-pane fade" id="alerts" role="tabpanel" aria-labelledby="alerts-tab">
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

            <!-- Health Status Tab -->
            <div class="tab-pane fade" id="health-status" role="tabpanel" aria-labelledby="health-status-tab">
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
                        <div class="stat-card" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; text-align: center;">
                            <h2>{{ isset($recentVisits) ? $recentVisits->count() : 1 }}</h2>
                            <p>With Clinic Visits</p>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="stat-card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; text-align: center;">
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