<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports & Analytics - PDMHS Clinic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        .stats-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(220, 220, 250, 0.95) 100%);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            border: none;
            transition: transform 0.3s ease;
        }
        .stats-card:hover {
            transform: translateY(-5px);
        }
        .stats-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--primary);
        }
        .stats-label {
            color: #6c757d;
            font-size: 0.9rem;
            margin-top: 5px;
        }
        .chart-container {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(220, 220, 250, 0.95) 100%);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }
        .filter-section {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(220, 220, 250, 0.95) 100%);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }
        .btn-primary {
            background: var(--gradient);
            border: none;
            border-radius: 10px;
            padding: 10px 25px;
        }
        .btn-outline-primary {
            border: 2px solid var(--primary);
            color: var(--primary);
            border-radius: 10px;
            padding: 10px 25px;
        }
        .btn-outline-primary:hover {
            background: var(--primary);
            border-color: var(--primary);
        }
        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(30, 64, 175, 0.25);
        }
        
        .page-title {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 800;
            font-size: 32px;
            margin-bottom: 0.5rem;
            color: white;
        }
        
        .page-subtitle {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 500;
            font-size: 16px;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a class="navbar-brand" href="{{ route('clinic-staff.dashboard') }}">
                <i class="fas fa-heartbeat"></i>
                PDMHS Clinic
            </a>
            <ul class="navbar-menu">
                <li><a class="nav-link" href="{{ route('clinic-staff.dashboard') }}"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
                <li><a class="nav-link" href="{{ route('clinic-staff.students') }}"><i class="fas fa-users"></i>Students</a></li>
                <li><a class="nav-link" href="{{ route('clinic-staff.visits') }}"><i class="fas fa-calendar-check"></i>Visits</a></li>
                <li><a class="nav-link" href="{{ route('scanner') }}"><i class="fas fa-qrcode"></i>Scanner</a></li>
                <li><a class="nav-link active" href="{{ route('clinic-staff.reports') }}"><i class="fas fa-chart-bar"></i>Reports</a></li>
            </ul>
            <div class="user-dropdown">
                <button class="user-btn" onclick="toggleDropdown()">
                    @if(Auth::user()->profile_picture && file_exists(public_path(Auth::user()->profile_picture)))
                        <img src="{{ asset(Auth::user()->profile_picture) }}" alt="Profile" class="user-avatar">
                    @else
                        <div class="user-avatar-default">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif
                    <span>{{ Auth::user()->name }}</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="dropdown-menu" id="userDropdown">
                    <a class="dropdown-item" href="{{ route('clinic-staff.profile') }}">
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
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div style="background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(220, 220, 250, 0.95) 100%); backdrop-filter: blur(10px); border-radius: 15px; padding: 2rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                    <h1 class="page-title" style="color: #1f2937; margin-bottom: 0.5rem;">Reports & Analytics</h1>
                    <p class="page-subtitle" style="color: #6c757d; margin-bottom: 0;">Generate and export clinic reports</p>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="filter-section">
            <form method="GET" action="{{ route('clinic-staff.reports') }}">
                <div class="row align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Date Range</label>
                        <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-white">.</label>
                        <div class="d-flex align-items-center">
                            <span class="mx-2">to</span>
                            <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Grade Level</label>
                        <select name="grade_level" class="form-select">
                            <option value="all" {{ $gradeLevel == 'all' ? 'selected' : '' }}>All Grades</option>
                            <option value="7" {{ $gradeLevel == '7' ? 'selected' : '' }}>Grade 7</option>
                            <option value="8" {{ $gradeLevel == '8' ? 'selected' : '' }}>Grade 8</option>
                            <option value="9" {{ $gradeLevel == '9' ? 'selected' : '' }}>Grade 9</option>
                            <option value="10" {{ $gradeLevel == '10' ? 'selected' : '' }}>Grade 10</option>
                            <option value="11" {{ $gradeLevel == '11' ? 'selected' : '' }}>Grade 11</option>
                            <option value="12" {{ $gradeLevel == '12' ? 'selected' : '' }}>Grade 12</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="stats-card text-center">
                    <div class="stats-number">{{ $totalVisits }}</div>
                    <div class="stats-label">Total Visits</div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="stats-card text-center">
                    <div class="stats-number">{{ $chronicStudents }}</div>
                    <div class="stats-label">Chronic Students</div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="stats-card text-center">
                    <div class="stats-number">{{ $emergencyCases }}</div>
                    <div class="stats-label">Emergency Cases</div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="row">
            <div class="col-md-6">
                <div class="chart-container">
                    <h5 class="mb-3">Cases by Illness</h5>
                    @if($casesByIllness->count() > 0)
                        <canvas id="illnessChart" width="400" height="300"></canvas>
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-chart-pie fa-3x mb-3"></i>
                            <p>No data available</p>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <h5 class="mb-3">Cases by Grade Level</h5>
                    @if($casesByGrade->count() > 0)
                        <canvas id="gradeChart" width="400" height="300"></canvas>
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-chart-bar fa-3x mb-3"></i>
                            <p>No data available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Cases by Illness Chart
        @if($casesByIllness->count() > 0)
        const illnessCtx = document.getElementById('illnessChart').getContext('2d');
        new Chart(illnessCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($casesByIllness->keys()) !!},
                datasets: [{
                    data: {!! json_encode($casesByIllness->values()) !!},
                    backgroundColor: [
                        '#1e40af', '#3b82f6', '#60a5fa', '#93c5fd',
                        '#dbeafe', '#1e3a8a', '#2563eb', '#3b82f6',
                        '#60a5fa', '#93c5fd'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
        @endif

        // Cases by Grade Level Chart
        @if($casesByGrade->count() > 0)
        const gradeCtx = document.getElementById('gradeChart').getContext('2d');
        new Chart(gradeCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($casesByGrade->keys()->map(function($grade) { return 'Grade ' . $grade; })) !!},
                datasets: [{
                    label: 'Number of Cases',
                    data: {!! json_encode($casesByGrade->values()) !!},
                    backgroundColor: 'rgba(30, 64, 175, 0.8)',
                    borderColor: '#1e40af',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
        @endif

        // Dropdown toggle
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('show');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('userDropdown');
            const userBtn = document.querySelector('.user-btn');
            if (!userBtn.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });

    </script>
</body>
</html>
