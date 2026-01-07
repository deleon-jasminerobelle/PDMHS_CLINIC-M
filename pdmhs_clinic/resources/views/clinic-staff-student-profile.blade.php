<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Student Profile - {{ $student->first_name }} {{ $student->last_name }} - PDMHS Clinic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:wght@400;500;600;800&display=swap" rel="stylesheet">
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

        .navbar-nav .nav-link {
            font-family: 'Albert Sans', sans-serif !important;
            font-size: 20px !important;
            font-weight: 700 !important;
        }
        
        .dropdown-menu .dropdown-item {
            font-family: 'Albert Sans', sans-serif !important;
            font-size: 20px !important;
            font-weight: 500 !important;
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
            font-size: 18px;
            color: #6c757d;
            margin-bottom: 2rem;
        }

        .profile-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid #f1f3f4;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: var(--gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.5rem;
            margin-right: 2rem;
            flex-shrink: 0;
        }

        .profile-info h2 {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 800;
            font-size: 28px;
            margin-bottom: 0.5rem;
            color: var(--primary);
        }

        .profile-info .student-id {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 600;
            font-size: 16px;
            color: #6c757d;
            margin-bottom: 0.5rem;
        }

        .profile-info .grade-section {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 500;
            font-size: 14px;
            background: #e3f2fd;
            color: var(--primary);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            display: inline-block;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 600;
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 0.25rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-value {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 500;
            font-size: 16px;
            color: #212529;
        }

        .section-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
        }

        .section-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f1f3f4;
        }

        .section-title {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 700;
            font-size: 20px;
            color: var(--primary);
            margin: 0;
        }

        .btn-primary {
            background: var(--gradient);
            border: none;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-family: 'Albert Sans', sans-serif;
            font-weight: 600;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .alert {
            border-radius: 10px;
            font-family: 'Albert Sans', sans-serif;
            font-weight: 500;
        }

        .vitals-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .vital-item {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1rem;
            text-align: center;
        }

        .vital-label {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 600;
            font-size: 12px;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .vital-value {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 700;
            font-size: 18px;
            color: var(--primary);
        }

        .allergy-badge {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
            border-radius: 20px;
            padding: 0.25rem 0.75rem;
            font-family: 'Albert Sans', sans-serif;
            font-weight: 500;
            font-size: 14px;
            margin: 0.25rem;
            display: inline-block;
        }

        .visit-item {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
            border-left: 4px solid var(--primary);
        }

        .visit-date {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 600;
            font-size: 14px;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .visit-type {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 500;
            font-size: 16px;
            color: #212529;
            margin-bottom: 0.25rem;
        }

        .visit-notes {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 400;
            font-size: 14px;
            color: #6c757d;
        }

        .back-btn {
            background: #6c757d;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-family: 'Albert Sans', sans-serif;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .back-btn:hover {
            background: #5a6268;
            color: white;
            text-decoration: none;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ $user->role === 'adviser' ? route('adviser.dashboard') : route('clinic-staff.dashboard') }}">
            </a>
            <div class="navbar-nav me-auto">
                @if($user->role === 'adviser')
                <a class="nav-link" href="{{ route('adviser.dashboard') }}">
                    Dashboard
                </a>
                <a class="nav-link active" href="{{ route('adviser.dashboard') }}">
                    Students
                </a>
                @else
                <a class="nav-link" href="{{ route('clinic-staff.dashboard') }}">
                    Dashboard
                </a>
                <a class="nav-link active" href="{{ route('clinic-staff.students') }}">
                    Students
                </a>
                <a class="nav-link" href="{{ route('clinic-staff.visits') }}">
                    Visits
                </a>
                <a class="nav-link" href="{{ route('clinic-staff.reports') }}">
                    Reports
                </a>
                @endif
            </div>
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user me-1"></i>
                        {{ $user->name }}
                    </a>
                    <ul class="dropdown-menu">
                        @if($user->role === 'adviser')
                        <li><a class="dropdown-item" href="{{ route('adviser.profile') }}"><i class="fas fa-user-cog me-2"></i>Profile</a></li>
                        @else
                        <li><a class="dropdown-item" href="{{ route('clinic-staff.profile') }}"><i class="fas fa-user-cog me-2"></i>Profile</a></li>
                        @endif
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

        <!-- Back Button -->
        <a href="{{ $user->role === 'adviser' ? route('adviser.dashboard') : route('clinic-staff.students') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i> {{ $user->role === 'adviser' ? 'Back to Dashboard' : 'Back to Students' }}
        </a>

        <!-- Student Profile Card -->
        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="profile-info">
                    <h2>{{ $student->first_name }} {{ $student->last_name }}</h2>
                    <div class="student-id">Student ID: {{ $student->student_id ?? 'N/A' }}</div>
                    <div class="grade-section">
                        {{ $student->grade_level ?? 'N/A' }} - {{ $student->section ?? 'N/A' }}
                    </div>
                </div>
            </div>

            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $student->email ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Phone</div>
                    <div class="info-value">{{ $student->phone ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Date of Birth</div>
                    <div class="info-value">
                        @if($student->date_of_birth)
                            {{ \Carbon\Carbon::parse($student->date_of_birth)->format('F j, Y') }}
                            ({{ \Carbon\Carbon::parse($student->date_of_birth)->age }} years old)
                        @else
                            N/A
                        @endif
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Gender</div>
                    <div class="info-value">{{ $student->gender == 'M' ? 'Male' : ($student->gender == 'F' ? 'Female' : 'N/A') }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Blood Type</div>
                    <div class="info-value">{{ $student->blood_type ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Emergency Contact</div>
                    <div class="info-value">{{ $student->emergency_contact_name ?? 'N/A' }}</div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Latest Vitals -->
            <div class="col-md-6">
                <div class="section-card">
                    <div class="section-header">
                        <h3 class="section-title"><i class="fas fa-heartbeat me-2"></i>Latest Vitals</h3>
                        @if($user->role === 'clinic_staff')
                        <button class="btn btn-primary btn-sm" onclick="addVitals()">
                            <i class="fas fa-plus me-1"></i>Add Vitals
                        </button>
                        @endif
                    </div>
                    <div class="vitals-grid">
                        <div class="vital-item">
                            <div class="vital-label">Weight</div>
                            <div class="vital-value">{{ $student->weight ?? 'N/A' }} kg</div>
                        </div>
                        <div class="vital-item">
                            <div class="vital-label">Height</div>
                            <div class="vital-value">{{ $student->height ?? 'N/A' }} cm</div>
                        </div>
                        <div class="vital-item">
                            <div class="vital-label">Temperature</div>
                            <div class="vital-value">{{ $student->temperature ?? 'N/A' }}°C</div>
                        </div>
                        <div class="vital-item">
                            <div class="vital-label">Blood Pressure</div>
                            <div class="vital-value">{{ $student->blood_pressure ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Allergies -->
            <div class="col-md-6">
                <div class="section-card">
                    <div class="section-header">
                        <h3 class="section-title"><i class="fas fa-exclamation-triangle me-2"></i>Allergies</h3>
                        @if($user->role === 'clinic_staff')
                        <button class="btn btn-primary btn-sm" onclick="addAllergy()">
                            <i class="fas fa-plus me-1"></i>Add Allergy
                        </button>
                        @endif
                    </div>
                    <div>
                        @if($student->allergies && count($student->allergies) > 0)
                            @if(is_array($student->allergies))
                                @foreach($student->allergies as $allergy)
                                    <span class="allergy-badge">
                                        {{ is_string($allergy) ? $allergy : ($allergy['name'] ?? 'Unknown') }}
                                    </span>
                                @endforeach
                            @else
                                <span class="allergy-badge">{{ $student->allergies }}</span>
                            @endif
                        @else
                            <p class="text-muted">No known allergies</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Visits -->
        <div class="section-card">
            <div class="section-header">
                <h3 class="section-title"><i class="fas fa-history me-2"></i>Recent Visits</h3>
                <a href="{{ route('clinic-staff.student-visit.create', $student->id) }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>Add New Visit
                </a>
            </div>
            <div>
                @if($student->visits && $student->visits->count() > 0)
                    @foreach($student->visits->take(5) as $visit)
                        <div class="visit-item">
                            <div class="visit-date">
                                {{ \Carbon\Carbon::parse($visit->visit_date)->format('F j, Y g:i A') }}
                            </div>
                            <div class="visit-type">{{ $visit->visit_type ?? 'General Visit' }}</div>
                            @if($visit->notes)
                                <div class="visit-notes">{{ $visit->notes }}</div>
                            @endif
                        </div>
                    @endforeach
                @else
                    <p class="text-muted">No recent visits recorded</p>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function addVitals() {
            alert('Add Vitals functionality coming soon!');
            // TODO: Implement vitals modal/form
        }

        function addAllergy() {
            alert('Add Allergy functionality coming soon!');
            // TODO: Implement allergy modal/form
        }

        function addVisit() {
            alert('Add Visit functionality coming soon!');
            // TODO: Implement visit modal/form
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