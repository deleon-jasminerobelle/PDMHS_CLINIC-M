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

        <!-- Header -->
        <div class="mb-4">
            <h1 class="h3 mb-1 welcome-header">Welcome, {{ $user->name }}!</h1>
            <p class="text-muted dashboard-subtitle">Adviser Dashboard</p>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="stat-card stat-card-blue">
                    <h2>{{ $totalStudents ?? 0 }}</h2>
                    <p>Total Students</p>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="stat-card stat-card-orange">
                    <h2>{{ $studentsWithAllergies ?? 0 }}</h2>
                    <p>Students with Allergies</p>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="stat-card stat-card-yellow">
                    <h2>{{ $pendingVisits ?? 0 }}</h2>
                    <p>Pending Visits</p>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="stat-card stat-card-purple">
                    <h2>{{ isset($recentVisits) ? $recentVisits->count() : 0 }}</h2>
                    <p>Recent Visits</p>
                </div>
            </div>
        </div>

        <!-- Students List -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="section-card">
                    <div class="section-header">
                        <h5 class="mb-0"><i class="fas fa-users me-2"></i>Advised Students</h5>
                    </div>
                    <div class="section-content">
                        <p class="text-muted" style="font-style: italic;">No students assigned to you yet.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Medical Visits -->
        <div class="row">
            <div class="col-12">
                <div class="section-card">
                    <div class="section-header">
                        <h5 class="mb-0"><i class="fas fa-history me-2"></i>Recent Medical Visits</h5>
                    </div>
                    <div class="section-content">
                        <p class="text-muted" style="font-style: italic;">No recent medical visits for your students.</p>
                    </div>
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