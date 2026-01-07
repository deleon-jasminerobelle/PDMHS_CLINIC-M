<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports & Analytics - PDMHS Clinic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:wght@400;500;600;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #1e40af;
            --primary-dark: #1e3a8a;
            --secondary: #3b82f6;
            --gradient: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar.bg-primary {
            background: var(--gradient) !important;
            padding: 1rem 0 !important;
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
        .stats-card {
            background: white;
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
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }
        .filter-section {
            background: white;
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
        }
        
        .page-subtitle {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 500;
            font-size: 16px;
            color: #6c757d;
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('clinic-staff.dashboard') }}">
                
            </a>
            <div class="navbar-nav me-auto">
                <a class="nav-link" href="{{ route('clinic-staff.dashboard') }}">
                    Dashboard
                </a>
                <a class="nav-link" href="{{ route('clinic-staff.students') }}">
                    Students
                </a>
                <a class="nav-link" href="{{ route('clinic-staff.visits') }}">
                    Visits
                </a>
                <a class="nav-link" href="{{ route('scanner') }}">
                    Scanner
                </a>
                <a class="nav-link active" href="{{ route('clinic-staff.reports') }}">
                    Reports
                </a>
            </div>
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user me-1"></i>
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('clinic-staff.profile') }}"><i class="fas fa-user-cog me-2"></i>Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
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
        <div class="row">
            <div class="col-12">
                <h1 class="page-title">Reports & Analytics</h1>
                <p class="page-subtitle">Generate and export clinic reports</p>
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


    </script>
</body>
</html>