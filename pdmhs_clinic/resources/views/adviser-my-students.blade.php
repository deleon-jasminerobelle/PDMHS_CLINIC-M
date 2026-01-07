<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>My Students - PDMHS Clinic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
            font-size: 18px;
            font-weight: 600;
            color: var(--primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar-menu {
            display: flex;
            gap: 0;
            align-items: center;
            list-style: none;
        }

        .nav-link {
            color: #6b7280;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.3s ease;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0 0.2rem;
        }

        .nav-link:hover, .nav-link.active {
            background: var(--primary);
            color: white;
            transform: none;
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

        .page-header {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(220, 220, 250, 0.95) 100%);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .page-title {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 600;
            font-size: 32px;
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 600;
            font-size: 16px;
            color: #6c757d;
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
                <li><a class="nav-link" href="{{ route('adviser.dashboard') }}"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
                <li><a class="nav-link active" href="{{ route('adviser.my-students') }}"><i class="fas fa-users"></i>My Students</a></li>
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
                    <a class="dropdown-item" href="{{ route('adviser.profile') }}">
                        <i class="fas fa-user-edit"></i>
                        Profile
                    </a>
                    <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hidden logout form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

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
