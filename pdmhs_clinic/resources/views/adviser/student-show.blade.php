@extends('layouts.app')

@section('title', 'Student Details - ' . $student->first_name . ' ' . $student->last_name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Adviser Panel</span>
                </h6>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('adviser.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <i class="fas fa-user-graduate"></i> Students
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">{{ $student->first_name }} {{ $student->last_name }}</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('adviser.dashboard') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
            </div>

            <!-- Student Information -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Student Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Student ID:</strong> {{ $student->student_id }}</p>
                                    <p><strong>Name:</strong> {{ $student->first_name }} {{ $student->middle_name }} {{ $student->last_name }}</p>
                                    <p><strong>Grade Level:</strong> {{ $student->grade_level }}</p>
                                    <p><strong>Section:</strong> {{ $student->section }}</p>
                                    <p><strong>Age:</strong> {{ $age ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Date of Birth:</strong> {{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('M d, Y') : 'N/A' }}</p>
                                    <p><strong>Gender:</strong> {{ $student->gender ?? 'N/A' }}</p>
                                    <p><strong>Blood Type:</strong> {{ $student->blood_type ?? 'N/A' }}</p>
                                    <p><strong>Address:</strong> {{ $student->address ?? 'N/A' }}</p>
                                    <p><strong>Phone:</strong> {{ $student->phone ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Emergency Contact</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Name:</strong> {{ $student->emergency_contact_name ?? 'N/A' }}</p>
                            <p><strong>Phone:</strong> {{ $student->emergency_contact_number ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Health Information -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Health Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <h6>Medical Conditions</h6>
                                    <p>{{ $student->medical_conditions ?? 'None specified' }}</p>
                                </div>
                                <div class="col-md-4">
                                    <h6>Allergies</h6>
                                    @if($allergies && $allergies->count() > 0)
                                        <ul class="list-unstyled">
                                            @foreach($allergies as $allergy)
                                                <li>{{ $allergy->allergen ?? 'Unknown' }} - {{ $allergy->reaction ?? 'N/A' }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p>{{ $student->allergies ?? 'None specified' }}</p>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <h6>Medications</h6>
                                    <p>{{ $student->medications ?? 'None specified' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Clinic Visits -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Clinic Visits ({{ $totalVisits }})</h5>
                            @if($lastVisit)
                                <small class="text-muted">Last visit: {{ \Carbon\Carbon::parse($lastVisit->visit_date)->format('M d, Y') }}</small>
                            @endif
                        </div>
                        <div class="card-body">
                            @if($recentVisits && $recentVisits->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Reason</th>
                                                <th>Diagnosis</th>
                                                <th>Treatment</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentVisits as $visit)
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::parse($visit->visit_date)->format('M d, Y') }}</td>
                                                    <td>{{ $visit->reason_for_visit ?? 'N/A' }}</td>
                                                    <td>{{ $visit->diagnosis ?? 'N/A' }}</td>
                                                    <td>{{ $visit->treatment ?? 'N/A' }}</td>
                                                    <td>
                                                        <span class="badge badge-{{ $visit->status == 'completed' ? 'success' : ($visit->status == 'pending' ? 'warning' : 'secondary') }}">
                                                            {{ ucfirst($visit->status ?? 'unknown') }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">No clinic visits recorded.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Immunizations -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Immunizations</h5>
                        </div>
                        <div class="card-body">
                            @if($immunizations && $immunizations->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Vaccine</th>
                                                <th>Date Administered</th>
                                                <th>Dose</th>
                                                <th>Next Due</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($immunizations as $immunization)
                                                <tr>
                                                    <td>{{ $immunization->vaccine_name ?? 'N/A' }}</td>
                                                    <td>{{ $immunization->date_administered ? \Carbon\Carbon::parse($immunization->date_administered)->format('M d, Y') : 'N/A' }}</td>
                                                    <td>{{ $immunization->dose ?? 'N/A' }}</td>
                                                    <td>{{ $immunization->next_due_date ? \Carbon\Carbon::parse($immunization->next_due_date)->format('M d, Y') : 'N/A' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">No immunizations recorded.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
