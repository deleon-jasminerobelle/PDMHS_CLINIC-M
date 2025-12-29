<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Adviser Dashboard - PDMHS Clinic</title>
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
            font-family: 'Poppins', sans-serif;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .stat-card p {
            margin: 0;
            opacity: 0.9;
            font-family: 'Poppins', sans-serif;
            font-size: 25px;
            font-weight: 700;
        }
        
        .stat-card-blue { background: var(--gradient); }
        .stat-card-orange { background: var(--gradient); }
        .stat-card-yellow { background: var(--gradient); }
        .stat-card-purple { background: var(--gradient); }
        
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
            font-family: 'Poppins', sans-serif;
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
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
        }
        
        .navbar-nav .nav-link {
            font-family: 'Poppins', sans-serif !important;
            font-size: 25px !important;
            font-weight: 600 !important;
        }
        
        .dropdown-menu .dropdown-item {
            font-family: 'Poppins', sans-serif !important;
            font-size: 20px !important;
            font-weight: 500 !important;
        }
        
        .welcome-header {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: 35px;
        }
        
        .dashboard-subtitle {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 25px;
            margin-bottom: 0;
        }
        
        .student-card {
            background: white;
            border-radius: 12px;
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            padding: 1.5rem;
            margin-bottom: 1rem;
            text-align: center;
            transition: transform 0.2s ease;
        }
        
        .student-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }
        
        .student-avatar {
            width: 60px;
            height: 60px;
            background: var(--gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            color: white;
            font-size: 1.5rem;
        }
        
        .student-name {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 20px;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }
        
        .student-info {
            font-family: 'Poppins', sans-serif;
            color: #6c757d;
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 1rem;
        }
        
        .btn-view-profile {
            background: var(--gradient);
            border: none;
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.2s ease;
        }
        
        .btn-view-profile:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.4);
            color: white;
        }
        
        .activity-item {
            padding: 1rem;
            border-left: 4px solid var(--primary);
            background: #f8f9fa;
            border-radius: 0 8px 8px 0;
            margin-bottom: 1rem;
        }
        
        .activity-item .activity-icon {
            color: var(--primary);
            margin-right: 0.5rem;
        }
        
        .activity-name {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 18px;
        }
        
        .activity-details {
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            font-size: 16px;
            color: #6c757d;
        }
        
        .students-count {
            color: var(--primary);
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 18px;
        }
        
        .text-muted {
            font-family: 'Poppins', sans-serif;
        }
        
        .btn {
            font-family: 'Poppins', sans-serif;
        }
        
        .alert {
            font-family: 'Poppins', sans-serif;
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
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="font-family: 'Poppins', sans-serif; font-size: 20px; font-weight: 500;">
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

        <!-- Header -->
        <div class="mb-4">
            <h1 class="welcome-header">Welcome, {{ $user->name }}!</h1>
            <p class="text-muted dashboard-subtitle">Adviser Dashboard - Grade 12 STEM-1</p>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="stat-card stat-card-blue d-flex flex-column justify-content-center" style="min-height: 120px;">
                    <h2>{{ $totalStudents ?? 3 }}</h2>
                    <p>Total Students</p>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="stat-card stat-card-orange d-flex flex-column justify-content-center" style="min-height: 120px;">
                    <h2>{{ $recentVisits ? $recentVisits->count() : 1 }}</h2>
                    <p>Clinic Visits<br>(This Month)</p>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="stat-card stat-card-yellow d-flex flex-column justify-content-center" style="min-height: 120px;">
                    <h2>{{ $studentsWithAllergies ?? 1 }}</h2>
                    <p>With Allergies</p>
                </div>
            </div>
        </div>

        <!-- Students Under Your Advisory -->
        <div class="section-card">
            <div class="section-header">
                <h5 class="mb-0"><i class="fas fa-users me-2"></i>Students Under Your Advisory</h5>
                <span class="students-count">{{ $totalStudents ?? 3 }} students</span>
            </div>
            <div class="p-4">
                <div class="row">
                    @if($students && $students->count() > 0)
                        @foreach($students as $student)
                            <div class="col-md-4 mb-3">
                                <div class="student-card">
                                    <div class="student-avatar">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="student-name">{{ $student->first_name }} {{ $student->last_name }}</div>
                                    <div class="student-info">
                                        {{ $student->student_id }}<br>
                                        {{ $student->grade_level }} {{ $student->section }}
                                    </div>
                                    <a href="{{ route('students.show', $student->id) }}" class="btn btn-view-profile">
                                        View Profile
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <!-- Sample students for demo -->
                        <div class="col-md-4 mb-3">
                            <div class="student-card">
                                <div class="student-avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="student-name">Irish Gallaza</div>
                                <div class="student-info">
                                    STU001<br>
                                    Grade 12 - STEM-1
                                </div>
                                <button class="btn btn-view-profile">
                                    View Profile
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="student-card">
                                <div class="student-avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="student-name">Hannah Lorraine Gonzalez</div>
                                <div class="student-info">
                                    STU002<br>
                                    Grade 12 - STEM-1
                                </div>
                                <button class="btn btn-view-profile">
                                    View Profile
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="student-card">
                                <div class="student-avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="student-name">Clarence Villas</div>
                                <div class="student-info">
                                    STU003<br>
                                    Grade 12 - STEM-1
                                </div>
                                <button class="btn btn-view-profile">
                                    View Profile
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Clinic Activity -->
        <div class="section-card">
            <div class="section-header">
                <h5 class="mb-0"><i class="fas fa-activity me-2"></i>Recent Clinic Activity</h5>
            </div>
            <div class="p-4">
                @if($recentVisits && $recentVisits->count() > 0)
                    @foreach($recentVisits as $visit)
                        <div class="activity-item">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user-md activity-icon"></i>
                                <div class="flex-grow-1">
                                    <div class="activity-name">{{ $visit->student->first_name }} {{ $visit->student->last_name }}</div>
                                    <div class="activity-details">visited the clinic - {{ $visit->reason_for_visit ?? 'General checkup' }}</div>
                                    <div class="activity-details">{{ $visit->visit_date ? \Carbon\Carbon::parse($visit->visit_date)->format('M d, Y') : 'Yesterday' }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- Sample activity for demo -->
                    <div class="activity-item">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user-md activity-icon"></i>
                            <div class="flex-grow-1">
                                <div class="activity-name">Hannah Lorraine Gonzalez</div>
                                <div class="activity-details">visited the clinic - may sakit ba sya</div>
                                <div class="activity-details">Yesterday</div>
                            </div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle activity-icon"></i>
                            <div class="flex-grow-1">
                                <div class="activity-name">Hannah Lorraine Gonzalez</div>
                                <div class="activity-details">has allergies - Peanuts, Shellfish</div>
                                <div class="activity-details">2 days ago</div>
                            </div>
                        </div>
                    </div>
                @endif
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