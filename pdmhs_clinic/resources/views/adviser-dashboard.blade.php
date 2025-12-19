<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adviser Dashboard - PDMHS Clinic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
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
        }
        .stat-card h2 {
            font-size: 2.5rem;
            font-weight: 300;
            margin-bottom: 0.5rem;
        }
        .stat-card p {
            margin: 0;
            opacity: 0.9;
        }
        .stat-card-blue { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .stat-card-orange { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
        .stat-card-yellow { background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%); color: #333; }
        .stat-card-purple { background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); color: #333; }
        
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
        }
        .section-content {
            padding: 2rem;
            text-align: center;
            color: #6c757d;
        }
        .navbar-brand {
            font-weight: 600;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-heartbeat me-2"></i>
                PDMHS Clinic
            </a>
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user me-1"></i>
                        {{ $user->name ?? $adviser->full_name }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user-cog me-2"></i>Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Header -->
        <div class="mb-4">
            <h1 class="h3 mb-1">Adviser Dashboard</h1>
            <p class="text-muted">Welcome, {{ $adviser->full_name }}</p>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="stat-card stat-card-blue">
                    <h2>{{ $totalStudents }}</h2>
                    <p>Total Students</p>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="stat-card stat-card-orange">
                    <h2>{{ $recentVisits->count() }}</h2>
                    <p>Recent Clinic Visits</p>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="stat-card stat-card-yellow">
                    <h2>{{ $studentsWithAllergies }}</h2>
                    <p>Students w/th Allergies</p>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="stat-card stat-card-purple">
                    <h2>{{ $pendingVisits }}</h2>
                    <p>Pending Visits</p>
                </div>
            </div>
        </div>

        <!-- Advised Students Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="section-card">
                    <div class="section-header">
                        <h5 class="mb-0">Advised Students ({{ $totalStudents }})</h5>
                    </div>
                    <div class="section-content">
                        @if($totalStudents > 0)
                            <div class="row">
                                @foreach($students as $student)
                                    <div class="col-md-4 mb-3">
                                        <div class="card border-0 bg-light">
                                            <div class="card-body text-center py-3">
                                                <div class="mb-2">
                                                    <i class="fas fa-user-graduate fa-2x text-primary"></i>
                                                </div>
                                                <h6 class="mb-1">{{ $student->first_name }} {{ $student->last_name }}</h6>
                                                <small class="text-muted">{{ $student->student_id }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">No students assigned yet</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Medical Visits Section -->
        <div class="row">
            <div class="col-12">
                <div class="section-card">
                    <div class="section-header">
                        <h5 class="mb-0">Recent Medical Visits (Last 30 Days)</h5>
                    </div>
                    <div class="section-content">
                        @if($recentVisits->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Student</th>
                                            <th>Visit Date</th>
                                            <th>Reason for Visit</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentVisits as $visit)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-2">
                                                            <i class="fas fa-user-circle fa-lg text-primary"></i>
                                                        </div>
                                                        <div>
                                                            <div class="fw-semibold">{{ $visit->student->first_name }} {{ $visit->student->last_name }}</div>
                                                            <small class="text-muted">{{ $visit->student->student_id }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>{{ $visit->visit_date->format('M j, Y') }}</div>
                                                    <small class="text-muted">{{ $visit->visit_date->format('g:i A') }}</small>
                                                </td>
                                                <td>{{ $visit->reason_for_visit ?? 'N/A' }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $visit->status === 'pending' ? 'warning' : ($visit->status === 'completed' ? 'success' : 'secondary') }}">
                                                        {{ ucfirst($visit->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">No recent clinic visits</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>