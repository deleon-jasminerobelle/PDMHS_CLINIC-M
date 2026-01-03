<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:wght@400;500;600;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;500;600;700&display=swap" rel="stylesheet">
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
            font-size: 2.5rem;
            font-weight: 300;
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
        .stat-card-green { background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%); color: #333; }
        .stat-card-red { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: #333; }
        
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
        
        .health-info-label {
            font-family: 'Albert Sans', sans-serif !important;
            font-weight: 700 !important;
            font-size: 20px !important;
        }
        
        .empty-state-message {
            font-family: 'Albert Sans', sans-serif !important;
            font-style: italic !important;
            font-size: 23px !important;
        }
        .section-content {
            padding: 2rem;
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
            font-size: 30px;
        }
        
        .profile-picture-container {
            position: relative;
        }
        
        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .default-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
            border: 4px solid #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('student.dashboard') }}">
            </a>
            <div class="navbar-nav me-auto">
                <a class="nav-link active" href="{{ route('student.dashboard') }}">
                    <i></i>Dashboard
                </a>
                <a class="nav-link" href="{{ route('student.medical') }}">
                    <i></i>My Medical
                </a>
            </div>
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user me-1"></i>
                        {{ $user->name }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('student.profile') }}"><i class="fas fa-user-edit me-2"></i>Profile</a></li>
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

        <!-- Header with Profile Picture -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="section-card">
                    <div class="section-content">
                        <div class="row align-items-center">
                            <div class="col-md-2 text-center">
                                <div class="profile-picture-container">
                                    @if($user->profile_picture && file_exists(public_path($user->profile_picture)))
                                        <img src="{{ asset($user->profile_picture) }}" alt="Profile Picture" class="profile-picture">
                                    @else
                                        <div class="default-avatar">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-10">
                                <h1 class="h3 mb-1 welcome-header">Welcome back, {{ $user->name }}!</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Health Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="stat-card stat-card-blue d-flex flex-column justify-content-center" style="min-height: 120px;">
                    <h2>{{ $bmi ?? '' }}</h2>
                    <p>BMI</p>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="stat-card stat-card-orange d-flex flex-column justify-content-center" style="min-height: 120px;">
                    <h2>{{ $bloodType ?? '' }}</h2>
                    <p>Blood Type</p>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="stat-card stat-card-yellow d-flex flex-column justify-content-center" style="min-height: 120px;">
                    <h2>{{ isset($allergies) && $allergies && $allergies->count() > 0 ? $allergies->count() : '' }}</h2>
                    <p>Allergies</p>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="stat-card stat-card-purple d-flex flex-column justify-content-center" style="min-height: 120px;">
                    <h2>{{ isset($lastVisit) && $lastVisit ? $lastVisit->visit_date->format('M j') : '' }}</h2>
                    <p>Last Visit</p>
                </div>
            </div>
        </div>

        <!-- Health Information Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="section-card">
                    <div class="section-header">
                        <h5 class="mb-0"><i class="fas fa-heartbeat me-2"></i>Health Information</h5>
                    </div>
                    <div class="section-content">
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <div class="text-center">
                                    <h6 class="text-muted mb-1 health-info-label">Height</h6>
                                    <h4 class="mb-0">{{ $latestVitals->height ? $latestVitals->height . ' cm' : 'Not Set' }}</h4>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <div class="text-center">
                                    <h6 class="text-muted mb-1 health-info-label">Weight</h6>
                                    <h4 class="mb-0">{{ $latestVitals->weight ? $latestVitals->weight . ' kg' : 'Not Set' }}</h4>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <div class="text-center">
                                    <h6 class="text-muted mb-1 health-info-label">Age</h6>
                                    <h4 class="mb-0">{{ $age ?? 'Not Set' }}</h4>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="text-center">
                                    <h6 class="text-muted mb-1 health-info-label">BMI</h6>
                                    <h4 class="mb-0">{{ $bmi ? $bmi : 'Not Set' }}</h4>
                                    @if(isset($bmiCategory) && $bmiCategory)
                                        <small class="text-muted">({{ $bmiCategory }})</small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="text-center">
                                    <h6 class="text-muted mb-1 health-info-label">Blood Type</h6>
                                    <h4 class="mb-0">{{ $bloodType ? $bloodType : 'Not Set' }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Known Allergies -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="section-card">
                    <div class="section-header">
                        <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Known Allergies</h5>
                        <button class="btn btn-sm btn-outline-primary" onclick="editAllergies()">
                            <i class="fas fa-edit me-1"></i>Edit
                        </button>
                    </div>
                    <div class="section-content">
                        @if(isset($allergies) && $allergies && $allergies->count() > 0)
                            <div class="row">
                                @foreach($allergies as $allergy)
                                    <div class="col-md-4 col-sm-6 mb-3">
                                        <div class="alert alert-info mb-0 d-flex align-items-center" style="padding: 12px; border-radius: 8px;">
                                            <i class="fas fa-exclamation-circle me-2"></i>
                                            <div>
                                                <strong>{{ $allergy->allergy_name ?? 'Unknown' }}</strong>
                                                <br><small>Severity: {{ $allergy->severity ?? 'Unknown' }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-check-circle text-success mb-2" style="font-size: 2rem;"></i>
                                <p class="text-muted mb-0 empty-state-message">No known allergies recorded</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Immunization Records -->
        <div class="row mb-4">
            <div class="col-12">
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function editAllergies() {
            alert('Edit allergies functionality will be implemented soon.');
        }

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

        // Session keep-alive mechanism
        function keepSessionAlive() {
            fetch('/keep-alive', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    console.warn('Session keep-alive failed:', response.status);
                    // If session expired, redirect to login
                    if (response.status === 401 || response.status === 419) {
                        window.location.href = '/login';
                    }
                }
                return response.json();
            })
            .then(data => {
                console.log('Session keep-alive successful:', data);
            })
            .catch(error => {
                console.error('Session keep-alive error:', error);
            });
        }

        // Check session status on page load
        function checkSessionStatus() {
            fetch('/session-status', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    console.warn('Session check failed:', response.status);
                    if (response.status === 401 || response.status === 419) {
                        window.location.href = '/login';
                    }
                    return;
                }
                return response.json();
            })
            .then(data => {
                if (!data.authenticated) {
                    console.warn('User not authenticated, redirecting to login');
                    window.location.href = '/login';
                } else {
                    console.log('Session status OK:', data);
                }
            })
            .catch(error => {
                console.error('Session status check error:', error);
            });
        }

        // Check session status immediately on page load
        checkSessionStatus();

        // Keep session alive every 10 minutes (600,000 ms)
        setInterval(keepSessionAlive, 600000);

        // Also keep session alive on user activity
        let activityTimer;
        function resetActivityTimer() {
            clearTimeout(activityTimer);
            activityTimer = setTimeout(keepSessionAlive, 300000); // 5 minutes of inactivity
        }

        // Listen for user activity
        ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart', 'click'].forEach(event => {
            document.addEventListener(event, resetActivityTimer, true);
        });

        // Initial activity timer
        resetActivityTimer();
    </script>
</body>
</html>