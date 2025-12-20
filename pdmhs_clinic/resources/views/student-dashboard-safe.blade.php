<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - PDMHS Clinic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:wght@400;500;600&display=swap" rel="stylesheet">
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
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .section-content {
            padding: 2rem;
        }
        .navbar-brand {
            font-weight: 600;
        }
        .welcome-header {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('student.dashboard') }}">
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
                        <li><a class="dropdown-item" href="{{ route('student.profile') }}"><i class="fas fa-user-edit me-2"></i>Edit Profile</a></li>
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

        <!-- Header -->
        <div class="mb-4">
            <h1 class="h3 mb-1 welcome-header">Welcome back, {{ $user->name }}!</h1>
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
                    <h2>{{ isset($allergies) && $allergies ? $allergies->count() : 0 }}</h2>
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
                                    <h6 class="text-muted mb-1">Height</h6>
                                    <h4 class="mb-0">{{ isset($latestVitals->height) && $latestVitals->height ? $latestVitals->height . ' cm' : '' }}</h4>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <div class="text-center">
                                    <h6 class="text-muted mb-1">Weight</h6>
                                    <h4 class="mb-0">{{ isset($latestVitals->weight) && $latestVitals->weight ? $latestVitals->weight . ' kg' : '' }}</h4>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <div class="text-center">
                                    <h6 class="text-muted mb-1">Age</h6>
                                    <h4 class="mb-0">{{ $age ?? '' }}</h4>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="text-center">
                                    <h6 class="text-muted mb-1">BMI</h6>
                                    <h4 class="mb-0">{{ $bmi ?? '' }}</h4>
                                    @if(isset($bmiCategory) && $bmiCategory)
                                        <small class="text-muted">({{ $bmiCategory }})</small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="text-center">
                                    <h6 class="text-muted mb-1">Blood Type</h6>
                                    <h4 class="mb-0">{{ $bloodType ?? '' }}</h4>
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
                                <p class="text-muted mb-0">No known allergies recorded</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Immunization Records -->
        <div class="row">
            <div class="col-12">
                <div class="section-card">
                    <div class="section-header">
                        <h5 class="mb-0"><i class="fas fa-syringe me-2"></i>Immunization Records</h5>
                    </div>
                    <div class="section-content">
                        @if(isset($immunizations) && $immunizations && $immunizations->count() > 0)
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
                                                    <strong>{{ $immunization->vaccine_name ?? '' }}</strong>
                                                    @if(isset($immunization->vaccine_type))
                                                        <br><small class="text-muted">{{ $immunization->vaccine_type }}</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(isset($immunization->date_administered))
                                                        <div>{{ $immunization->date_administered->format('M j, Y') }}</div>
                                                        <small class="text-muted">{{ $immunization->date_administered->format('g:i A') }}</small>
                                                    @else
                                                        <div></div>
                                                    @endif
                                                </td>
                                                <td>{{ $immunization->administered_by ?? '' }}</td>
                                                <td>
                                                    @if(isset($immunization->notes) && $immunization->notes)
                                                        {{ $immunization->notes }}
                                                    @else
                                                        <span class="text-muted">No notes</span>
                                                    @endif
                                                </td>
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
    </script>
</body>
</html>