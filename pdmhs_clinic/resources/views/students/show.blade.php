<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Student Profile - {{ $student->first_name }} {{ $student->last_name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }
        .profile-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .profile-avatar {
            width: 100px;
            height: 100px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            margin-bottom: 1rem;
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
            color: #667eea;
            display: flex;
            justify-content: between;
            align-items: center;
            font-family: 'Poppins', sans-serif;
        }
        .info-item {
            padding: 0.75rem 0;
            border-bottom: 1px solid #f8f9fa;
        }
        .info-item:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
            font-family: 'Poppins', sans-serif;
        }
        .info-value {
            color: #2c3e50;
            font-size: 1rem;
            font-family: 'Poppins', sans-serif;
        }
        .allergy-badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
            margin: 0.25rem 0.25rem 0.25rem 0;
            display: inline-block;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
        }
        .condition-badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
            margin: 0.25rem 0.25rem 0.25rem 0;
            display: inline-block;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
        }
        .medication-badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
            margin: 0.25rem 0.25rem 0.25rem 0;
            display: inline-block;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
        }
        .vitals-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: 2px solid #667eea;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            margin-bottom: 1rem;
            transition: transform 0.2s ease;
        }
        .vitals-card:hover {
            transform: translateY(-2px);
        }
        .vitals-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: #667eea;
            font-family: 'Poppins', sans-serif;
        }
        .vitals-label {
            font-size: 0.9rem;
            color: #6c757d;
            font-weight: 500;
            font-family: 'Poppins', sans-serif;
        }
        .visit-item {
            padding: 1.5rem;
            border-left: 4px solid #667eea;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 0 12px 12px 0;
            margin-bottom: 1rem;
            transition: transform 0.2s ease;
        }
        .visit-item:hover {
            transform: translateX(5px);
        }
        .navbar-brand {
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
        }
        .btn-back {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
            font-family: 'Poppins', sans-serif;
        }
        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }
        .bg-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        }
        .badge.bg-success {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
        }
        .badge.bg-warning {
            background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%) !important;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
        }
        .badge.bg-secondary {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%) !important;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            color: #2c3e50;
        }
        .text-primary {
            color: #667eea !important;
        }
        .text-muted {
            font-family: 'Poppins', sans-serif;
        }
        p, span, div {
            font-family: 'Poppins', sans-serif;
        }
        .navbar {
            font-family: 'Poppins', sans-serif;
        }
        .nav-link {
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
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
                <a href="{{ route('adviser.dashboard') }}" class="btn btn-back me-2">
                    <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-back">
                        <i class="fas fa-sign-out-alt me-1"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="row align-items-center">
                <div class="col-md-2 text-center">
                    <div class="profile-avatar mx-auto">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
                <div class="col-md-7">
                    <h1 class="mb-2">{{ $student->first_name }} {{ $student->last_name }}</h1>
                    <p class="mb-1"><i class="fas fa-id-card me-2"></i>Student ID: {{ $student->student_id }}</p>
                    <p class="mb-1"><i class="fas fa-graduation-cap me-2"></i>{{ $student->grade_level }} {{ $student->section }}</p>
                    <p class="mb-0"><i class="fas fa-school me-2"></i>{{ $student->school ?? 'PDMHS' }}</p>
                </div>
                <div class="col-md-3 text-end">
                    @if($student->advisers && $student->advisers->count() > 0)
                        <div class="text-end">
                            <h6 class="mb-1">Adviser</h6>
                            @foreach($student->advisers as $adviser)
                                <p class="mb-0">{{ $adviser->first_name }} {{ $adviser->last_name }}</p>
                                <small>{{ $adviser->employee_number ?? 'N/A' }}</small>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Personal Information -->
            <div class="col-md-6">
                <div class="section-card">
                    <div class="section-header">
                        <h5 class="mb-0"><i class="fas fa-user me-2"></i>Personal Information</h5>
                    </div>
                    <div class="p-4">
                        <div class="info-item">
                            <div class="info-label">Full Name</div>
                            <div class="info-value">{{ $student->first_name }} {{ $student->last_name }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Date of Birth</div>
                            <div class="info-value">{{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('F d, Y') : 'N/A' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Age</div>
                            <div class="info-value">{{ $student->age ?? 'N/A' }} years old</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Gender</div>
                            <div class="info-value">{{ ucfirst($student->gender ?? 'N/A') }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Blood Type</div>
                            <div class="info-value">{{ $student->blood_type ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact & Emergency Information -->
            <div class="col-md-6">
                <div class="section-card">
                    <div class="section-header">
                        <h5 class="mb-0"><i class="fas fa-phone me-2"></i>Contact & Emergency Information</h5>
                    </div>
                    <div class="p-4">
                        <div class="info-item">
                            <div class="info-label">Emergency Contact Name</div>
                            <div class="info-value">{{ $student->emergency_contact_name ?? 'N/A' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Emergency Contact Number</div>
                            <div class="info-value">{{ $student->emergency_contact_number ?? 'N/A' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Relationship</div>
                            <div class="info-value">{{ $student->emergency_relation ?? 'N/A' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Emergency Address</div>
                            <div class="info-value">{{ $student->emergency_address ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Health Vitals -->
        <div class="section-card">
            <div class="section-header">
                <h5 class="mb-0"><i class="fas fa-heartbeat me-2"></i>Health Vitals</h5>
            </div>
            <div class="p-4">
                <div class="row">
                    <div class="col-md-3">
                        <div class="vitals-card">
                            <div class="vitals-value">{{ $student->height ?? 'N/A' }}</div>
                            <div class="vitals-label">Height (cm)</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="vitals-card">
                            <div class="vitals-value">{{ $student->weight ?? 'N/A' }}</div>
                            <div class="vitals-label">Weight (kg)</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="vitals-card">
                            <div class="vitals-value">{{ $student->temperature ?? 'N/A' }}</div>
                            <div class="vitals-label">Temperature (°C)</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="vitals-card">
                            <div class="vitals-value">{{ $student->blood_pressure ?? 'N/A' }}</div>
                            <div class="vitals-label">Blood Pressure</div>
                        </div>
                    </div>
                </div>
                @if($student->height && $student->weight && $student->height > 0)
                    <div class="text-center mt-3">
                        <strong>BMI: </strong>
                        <span class="text-primary">{{ number_format($student->bmi ?? 0, 1) }}</span>
                        <span class="text-muted">
                            @if($student->bmi)
                                @if($student->bmi < 18.5) (Underweight)
                                @elseif($student->bmi < 25) (Normal)
                                @elseif($student->bmi < 30) (Overweight)
                                @else (Obese)
                                @endif
                            @endif
                        </span>
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <!-- Medical Conditions & Allergies -->
            <div class="col-md-6">
                <div class="section-card">
                    <div class="section-header">
                        <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Allergies & Medical Conditions</h5>
                    </div>
                    <div class="p-4">
                        <div class="info-item">
                            <div class="info-label">Allergies</div>
                            <div class="info-value">
                                @if($student->allergies && is_array($student->allergies) && count($student->allergies) > 0)
                                    @foreach($student->allergies as $allergy)
                                        <span class="allergy-badge">{{ $allergy }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">No allergies recorded</span>
                                @endif
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Medical Conditions</div>
                            <div class="info-value">
                                @if($student->medical_conditions && is_array($student->medical_conditions) && count($student->medical_conditions) > 0)
                                    @foreach($student->medical_conditions as $condition)
                                        <span class="condition-badge">{{ $condition }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">No medical conditions recorded</span>
                                @endif
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Surgery History</div>
                            <div class="info-value">
                                @if($student->has_surgery && $student->surgery_details)
                                    {{ $student->surgery_details }}
                                @else
                                    <span class="text-muted">No surgery history</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Family History & Medications -->
            <div class="col-md-6">
                <div class="section-card">
                    <div class="section-header">
                        <h5 class="mb-0"><i class="fas fa-pills me-2"></i>Family History & Medications</h5>
                    </div>
                    <div class="p-4">
                        <div class="info-item">
                            <div class="info-label">Family Medical History</div>
                            <div class="info-value">
                                @if($student->family_history && is_array($student->family_history) && count($student->family_history) > 0)
                                    @foreach($student->family_history as $condition)
                                        <span class="condition-badge">{{ $condition }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">No family history recorded</span>
                                @endif
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Current Medications</div>
                            <div class="info-value">
                                @if($student->medication && is_array($student->medication) && count($student->medication) > 0)
                                    @foreach($student->medication as $med)
                                        <span class="medication-badge">{{ $med }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">No medications recorded</span>
                                @endif
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Smoke Exposure</div>
                            <div class="info-value">{{ $student->smoke_exposure ? 'Yes' : 'No' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vaccination History -->
        <div class="section-card">
            <div class="section-header">
                <h5 class="mb-0"><i class="fas fa-syringe me-2"></i>Vaccination History</h5>
            </div>
            <div class="p-4">
                @if($student->vaccination_history && is_array($student->vaccination_history) && count($student->vaccination_history) > 0)
                    <div class="row">
                        @foreach($student->vaccination_history as $vaccine)
                            <div class="col-md-3 mb-2">
                                <span class="badge bg-success">{{ $vaccine }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted mb-0">No vaccination history recorded</p>
                @endif
            </div>
        </div>

        <!-- Recent Clinic Visits -->
        <div class="section-card">
            <div class="section-header">
                <h5 class="mb-0"><i class="fas fa-clinic-medical me-2"></i>Recent Clinic Visits</h5>
            </div>
            <div class="p-4">
                @if($student->clinicVisits && $student->clinicVisits->count() > 0)
                    @foreach($student->clinicVisits as $visit)
                        <div class="visit-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">{{ $visit->visit_date ? \Carbon\Carbon::parse($visit->visit_date)->format('M d, Y') : 'N/A' }}</h6>
                                    <p class="mb-1"><strong>Reason:</strong> {{ $visit->reason_for_visit ?? 'N/A' }}</p>
                                    @if($visit->diagnosis)
                                        <p class="mb-0"><strong>Diagnosis:</strong> {{ $visit->diagnosis }}</p>
                                    @endif
                                </div>
                                <span class="badge 
                                    @if($visit->status == 'completed') bg-success
                                    @elseif($visit->status == 'pending') bg-warning
                                    @else bg-secondary
                                    @endif">
                                    {{ ucfirst($visit->status ?? 'unknown') }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted mb-0">No clinic visits recorded</p>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
