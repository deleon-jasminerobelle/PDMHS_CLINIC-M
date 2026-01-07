<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>My Students - PDMHS Clinic</title>
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

        .student-card {
            background: white;
            border-radius: 12px;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .student-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }

        .student-name {
            font-family: 'Albert Sans', sans-serif !important;
            font-weight: 600 !important;
            font-size: 20px !important;
            color: #1e40af !important;
            margin-bottom: 0.5rem !important;
        }

        .student-info {
            font-family: 'Albert Sans', sans-serif !important;
            font-weight: 500 !important;
            font-size: 16px !important;
            color: #6c757d !important;
            margin-bottom: 0.25rem !important;
        }

        .student-info i {
            width: 16px;
            color: #1e40af;
        }

        .health-status {
            font-size: 14px;
            padding: 2px 8px;
            border-radius: 12px;
            font-weight: 600;
            margin-left: 8px;
        }

        .healthy {
            background-color: #d1fae5;
            color: #065f46;
        }

        .needs-attention {
            background-color: #fef3c7;
            color: #92400e;
        }

        .critical {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .btn-view-profile {
            background: var(--gradient);
            border: none;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-view-profile:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(30, 64, 175, 0.3);
        }

        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .empty-state-icon {
            font-size: 4rem;
            color: #cbd5e1;
            margin-bottom: 1rem;
        }

        .empty-state-title {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 600;
            font-size: 24px;
            color: #475569;
            margin-bottom: 0.5rem;
        }

        .empty-state-text {
            font-family: 'Albert Sans', sans-serif;
            font-size: 16px;
            color: #64748b;
        }

        .navbar-brand {
            font-weight: 600;
        }

        .navbar-nav .nav-link {
            font-family: 'Epilogue', sans-serif !important;
            font-size: 16px !important;
            font-weight: 600 !important;
        }

        .dropdown-menu .dropdown-item {
            font-family: 'Epilogue', sans-serif !important;
            font-size: 14px !important;
            font-weight: 500 !important;
        }

        .page-header {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 800;
            font-size: 32px;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 500;
            font-size: 18px;
            color: #64748b;
        }

        .stats-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border: none;
        }

        .stats-number {
            font-family: 'Roboto', sans-serif;
            font-size: 32px;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 0.5rem;
        }

        .stats-label {
            font-family: 'Albert Sans', sans-serif;
            font-size: 16px;
            color: #64748b;
            margin: 0;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('adviser.dashboard') }}">
                <i class="fas fa-heartbeat me-2"></i>PDMHS Clinic
            </a>
            <div class="navbar-nav me-auto">
                <a class="nav-link" href="{{ route('adviser.dashboard') }}">
                    <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                </a>
                <a class="nav-link active" href="{{ route('adviser.my-students') }}">
                    <i class="fas fa-users me-1"></i>My Students
                </a>
                <a class="nav-link" href="{{ route('adviser.scanner') }}">
                    <i class="fas fa-qrcode me-1"></i>Scanner
                </a>
            </div>
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user me-1"></i>
                        {{ Auth::user()->name }}
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
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
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

        <!-- Page Header -->
        <div class="mb-4">
            <h1 class="page-header">My Students</h1>
            <p class="page-subtitle">Manage and view profiles of students under your advisory</p>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="stats-card">
                    <div class="stats-number">{{ $students->count() }}</div>
                    <p class="stats-label">Total Students</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="stats-card">
                    <div class="stats-number">{{ $studentsData->where('latestVitals', '!=', null)->count() }}</div>
                    <p class="stats-label">With Health Records</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="stats-card">
                    <div class="stats-number">{{ $studentsData->where('allergies', '!=', null)->count() }}</div>
                    <p class="stats-label">With Allergies</p>
                </div>
            </div>
        </div>

        <!-- Students List -->
        @if($students->count() > 0)
            @foreach($studentsData as $studentData)
                <div class="student-card">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3 class="student-name">{{ $studentData['student']->user->name }}</h3>
                            <div class="student-info">
                                <i class="fas fa-id-card me-1"></i>Student ID: {{ $studentData['student']->student_id }}
                            </div>
                            <div class="student-info">
                                <i class="fas fa-envelope me-1"></i>{{ $studentData['student']->user->email }}
                            </div>
                            @if($studentData['student']->user->contact_number)
                                <div class="student-info">
                                    <i class="fas fa-phone me-1"></i>{{ $studentData['student']->user->contact_number }}
                                </div>
                            @endif
                            @if($studentData['latestVitals'])
                                <div class="student-info">
                                    <i class="fas fa-weight me-1"></i>BMI: {{ number_format($studentData['bmi'], 1) }}
                                    <span class="health-status {{ $studentData['bmiCategory'] === 'Normal' ? 'healthy' : ($studentData['bmiCategory'] === 'Overweight' || $studentData['bmiCategory'] === 'Underweight' ? 'needs-attention' : 'critical') }}">
                                        {{ $studentData['bmiCategory'] }}
                                    </span>
                                </div>
                            @endif
                            @if($studentData['allergies'])
                                <div class="student-info">
                                    <i class="fas fa-allergies me-1"></i>Allergies: {{ Str::limit($studentData['allergies'], 50) }}
                                </div>
                            @endif
                        </div>
                        <div class="col-md-4 text-end">
                            <a href="{{ route('adviser.student-profile', $studentData['student']->id) }}" class="btn btn-primary btn-view-profile">
                                <i class="fas fa-eye me-1"></i>View Profile
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="empty-state-title">No Students Assigned</h3>
                <p class="empty-state-text">You don't have any students assigned to you yet.</p>
            </div>
        @endif
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
