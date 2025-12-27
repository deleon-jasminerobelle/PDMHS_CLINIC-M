<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Adviser Dashboard - PDMHS Clinic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        .welcome-header {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 500;
            font-size: 2rem;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }
        .welcome-subtitle {
            color: #6c757d;
            font-size: 1rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            border-radius: 12px;
            border: 1px solid #e9ecef;
            padding: 1.5rem;
            margin-bottom: 1rem;
            background: white;
            color: #2c3e50;
            font-weight: 500;
            position: relative;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .stat-card h2 {
            font-size: 2.5rem;
            font-weight: 300;
            margin-bottom: 0.5rem;
            color: #667eea;
        }
        .stat-card p {
            margin: 0;
            color: #6c757d;
        }
        .stat-card i {
            font-size: 2rem;
            color: #667eea;
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
            color: #2c3e50;
            display: flex;
            justify-content: between;
            align-items: center;
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            color: white;
            font-size: 1.5rem;
        }
        .student-name {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }
        .student-info {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
        .btn-view-profile {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        .btn-view-profile:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
            color: white;
        }
        .activity-item {
            padding: 1rem;
            border-left: 4px solid #667eea;
            background: #f8f9fa;
            border-radius: 0 8px 8px 0;
            margin-bottom: 1rem;
        }
        .activity-item .activity-icon {
            color: #667eea;
            margin-right: 0.5rem;
        }
        .navbar-brand {
            font-weight: 600;
        }
        .students-count {
            color: #667eea;
            font-weight: 600;
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

        <!-- Header with Logout Button -->
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h1 class="welcome-header">Welcome back, {{ $user->name }}!</h1>
                <p class="welcome-subtitle">Advisory Class: Grade 12 - STEM-1</p>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="text-end">
                    <div class="text-muted small">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-sign-out-alt me-1"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2>{{ $totalStudents ?? 3 }}</h2>
                            <p>Total Students</p>
                        </div>
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2>{{ $recentVisits ? $recentVisits->count() : 1 }}</h2>
                            <p>Clinic Visits (This Month)</p>
                        </div>
                        <i class="fas fa-clinic-medical"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2>{{ $studentsWithAllergies ?? 1 }}</h2>
                            <p>With Allergies</p>
                        </div>
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Students Under Your Advisory -->
        <div class="section-card">
            <div class="section-header">
                <h5 class="mb-0">Students Under Your Advisory</h5>
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
                <h5 class="mb-0">Recent Clinic Activity</h5>
            </div>
            <div class="p-4">
                @if($recentVisits && $recentVisits->count() > 0)
                    @foreach($recentVisits as $visit)
                        <div class="activity-item">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user-md activity-icon"></i>
                                <div class="flex-grow-1">
                                    <strong>{{ $visit->student->first_name }} {{ $visit->student->last_name }}</strong> visited the clinic - {{ $visit->reason_for_visit ?? 'General checkup' }}
                                    <div class="text-muted small">{{ $visit->visit_date ? \Carbon\Carbon::parse($visit->visit_date)->format('M d, Y') : 'Yesterday' }}</div>
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
                                <strong>Hannah Lorraine Gonzalez</strong> visited the clinic - may sakit ba sya
                                <div class="text-muted small">Yesterday</div>
                            </div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle activity-icon"></i>
                            <div class="flex-grow-1">
                                <strong>Hannah Lorraine Gonzalez</strong> has allergies - Peanuts, Shellfish
                                <div class="text-muted small">2 days ago</div>
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
