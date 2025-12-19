<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - PDMHS Clinic</title>
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
        }
        .section-content {
            padding: 2rem;
        }
        .navbar-brand {
            font-weight: 600;
        }
        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .info-item:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #6c757d;
        }
        .info-value {
            color: #333;
        }
        .allergy-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            margin: 0.25rem;
            border-radius: 20px;
            font-size: 0.875rem;
        }
        .allergy-mild { background-color: #d4edda; color: #155724; }
        .allergy-moderate { background-color: #fff3cd; color: #856404; }
        .allergy-severe { background-color: #f8d7da; color: #721c24; }
        .bmi-indicator {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            display: inline-block;
        }
        .bmi-underweight { background-color: #cce5ff; color: #004085; }
        .bmi-normal { background-color: #d4edda; color: #155724; }
        .bmi-overweight { background-color: #fff3cd; color: #856404; }
        .bmi-obese { background-color: #f8d7da; color: #721c24; }
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
                        {{ $student->first_name }} {{ $student->last_name }}
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
            <h1 class="h3 mb-1">Student Health Dashboard</h1>
            <p class="text-muted">Welcome, {{ $student->first_name }} {{ $student->last_name }}</p>
        </div>

        <!-- Health Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-2 mb-3">
                <div class="stat-card stat-card-blue">
                    <h2>{{ $age ?? 'N/A' }}</h2>
                    <p>Age (Years)</p>
                </div>
            </div>

            <div class="col-md-2 mb-3">
                <div class="stat-card stat-card-orange">
                    <h2>{{ $latestVitals->weight ?? 'N/A' }}</h2>
                    <p>Weight (kg)</p>
                </div>
            </div>

            <div class="col-md-2 mb-3">
                <div class="stat-card stat-card-yellow">
                    <h2>{{ $latestVitals->height ?? 'N/A' }}</h2>
                    <p>Height (cm)</p>
                </div>
            </div>

            <div class="col-md-2 mb-3">
                <div class="stat-card stat-card-purple">
                    <h2>{{ $bmi ?? 'N/A' }}</h2>
                    <p>BMI</p>
                </div>
            </div>

            <div class="col-md-2 mb-3">
                <div class="stat-card stat-card-green">
                    <h2>{{ $totalVisits }}</h2>
                    <p>Total Visits</p>
                </div>
            </div>

            <div class="col-md-2 mb-3">
                <div class="stat-card stat-card-red">
                    <h2>{{ $allergies->count() }}</h2>
                    <p>Known Allergies</p>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Personal Information -->
            <div class="col-md-6 mb-4">
                <div class="section-card">
                    <div class="section-header">
                        <h5 class="mb-0"><i class="fas fa-user me-2"></i>Personal Information</h5>
                    </div>
                    <div class="section-content">
                        <div class="info-item">
                            <span class="info-label">Student ID:</span>
                            <span class="info-value">{{ $student->student_id }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Full Name:</span>
                            <span class="info-value">{{ $student->first_name }} {{ $student->last_name }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Birth Date:</span>
                            <span class="info-value">{{ $student->date_of_birth ? $student->date_of_birth->format('M j, Y') : 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Grade Level:</span>
                            <span class="info-value">{{ $student->grade_level ?? 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Section:</span>
                            <span class="info-value">{{ $student->section ?? 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Contact Number:</span>
                            <span class="info-value">{{ $student->contact_number ?? 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Emergency Contact:</span>
                            <span class="info-value">
                                {{ $student->emergency_contact_name ?? 'N/A' }}
                                @if($student->emergency_contact_number)
                                    <br><small class="text-muted">{{ $student->emergency_contact_number }}</small>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Latest Medical Information -->
            <div class="col-md-6 mb-4">
                <div class="section-card">
                    <div class="section-header">
                        <h5 class="mb-0"><i class="fas fa-stethoscope me-2"></i>Latest Medical Information</h5>
                    </div>
                    <div class="section-content">
                        @if($latestVitals)
                            <div class="info-item">
                                <span class="info-label">Last Visit:</span>
                                <span class="info-value">{{ $lastVisit->visit_date->format('M j, Y g:i A') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Weight:</span>
                                <span class="info-value">{{ $latestVitals->weight }} kg</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Height:</span>
                                <span class="info-value">{{ $latestVitals->height }} cm</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">BMI:</span>
                                <span class="info-value">
                                    {{ $bmi }}
                                    @if($bmiCategory)
                                        <span class="bmi-indicator bmi-{{ strtolower(str_replace(' ', '', $bmiCategory)) }}">
                                            {{ $bmiCategory }}
                                        </span>
                                    @endif
                                </span>
                            </div>
                            @if($latestVitals->temperature)
                                <div class="info-item">
                                    <span class="info-label">Temperature:</span>
                                    <span class="info-value">{{ $latestVitals->temperature }}°C</span>
                                </div>
                            @endif
                            @if($latestVitals->blood_pressure)
                                <div class="info-item">
                                    <span class="info-label">Blood Pressure:</span>
                                    <span class="info-value">{{ $latestVitals->blood_pressure }}</span>
                                </div>
                            @endif
                            @if($latestVitals->heart_rate)
                                <div class="info-item">
                                    <span class="info-label">Heart Rate:</span>
                                    <span class="info-value">{{ $latestVitals->heart_rate }} bpm</span>
                                </div>
                            @endif
                            @if($latestVitals->respiratory_rate)
                                <div class="info-item">
                                    <span class="info-label">Respiratory Rate:</span>
                                    <span class="info-value">{{ $latestVitals->respiratory_rate }} /min</span>
                                </div>
                            @endif
                        @else
                            <p class="text-muted text-center">No medical records available</p>
                        @endif
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
                    </div>
                    <div class="section-content">
                        @if($allergies->count() > 0)
                            @foreach($allergies as $allergy)
                                <span class="allergy-badge allergy-{{ strtolower($allergy->severity) }}">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    {{ $allergy->allergy_name }}
                                    <small>({{ $allergy->severity }})</small>
                                </span>
                            @endforeach
                        @else
                            <p class="text-muted text-center">No known allergies recorded</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Immunization Records -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="section-card">
                    <div class="section-header">
                        <h5 class="mb-0"><i class="fas fa-syringe me-2"></i>Immunization Records</h5>
                    </div>
                    <div class="section-content">
                        @if($immunizations->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Vaccine</th>
                                            <th>Date Administered</th>
                                            <th>Administered By</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($immunizations as $immunization)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-shield-alt text-success me-2"></i>
                                                        <strong>{{ $immunization->vaccine_name }}</strong>
                                                    </div>
                                                </td>
                                                <td>{{ $immunization->date_administered ? $immunization->date_administered->format('M j, Y') : 'N/A' }}</td>
                                                <td>{{ $immunization->administered_by ?? 'N/A' }}</td>
                                                <td>{{ $immunization->notes ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted text-center">No immunization records available</p>
                        @endif
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
                        @if($recentVisits->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Visit Date</th>
                                            <th>Type</th>
                                            <th>Chief Complaint</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentVisits as $visit)
                                            <tr>
                                                <td>
                                                    <div>{{ $visit->visit_date->format('M j, Y') }}</div>
                                                    <small class="text-muted">{{ $visit->visit_date->format('g:i A') }}</small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">Clinic Visit</span>
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
                            <p class="text-muted text-center">No recent medical visits</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>