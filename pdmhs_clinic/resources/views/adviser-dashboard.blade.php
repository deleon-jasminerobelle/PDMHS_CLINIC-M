@extends('layouts.app')

@section('title', 'Adviser Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('adviser.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#students">
                            <i class="fas fa-users"></i> My Students
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#visits">
                            <i class="fas fa-stethoscope"></i> Clinic Visits
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#allergies">
                            <i class="fas fa-exclamation-triangle"></i> Allergies
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main role="main" class="col-md-10 ml-sm-auto col-lg-10 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Adviser Dashboard</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group mr-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.location.reload()">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </button>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Students
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalStudents }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Recent Visits (30 days)
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $recentVisits->count() }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-stethoscope fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Students with Allergies
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $studentsWithAllergies }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                        Pending Visits
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingVisits }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clock fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Advised Students Section -->
            <div class="card shadow mb-4" id="students">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-users"></i> Advised Students ({{ $totalStudents }})
                    </h6>
                </div>
                <div class="card-body">
                    @if($students->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Student ID</th>
                                        <th>Name</th>
                                        <th>Grade</th>
                                        <th>Section</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $student)
                                        <tr>
                                            <td>{{ $student->student_id }}</td>
                                            <td>
                                                <a href="{{ route('adviser.students.show', $student) }}" class="text-primary font-weight-bold">
                                                    {{ $student->first_name }} {{ $student->last_name }}
                                                </a>
                                            </td>
                                            <td>
                                                <span class="badge badge-info">{{ $student->grade_level ?? 'N/A' }}</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-secondary">{{ $student->section ?? 'N/A' }}</span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('adviser.students.show', $student) }}" class="btn btn-sm btn-outline-primary" title="View Student Profile">
                                                        <i class="fas fa-user"></i> Profile
                                                    </a>
                                                    @if($student->clinicVisits && $student->clinicVisits->where('status', 'pending')->count() > 0)
                                                        <span class="badge badge-warning ml-1" title="Has pending visits">
                                                            <i class="fas fa-exclamation-triangle"></i>
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-users fa-3x text-gray-300 mb-3"></i>
                            <h5 class="text-gray-500">No students assigned yet</h5>
                            <p class="text-gray-400">Contact the clinic administrator to assign students to your advisory.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Medical Visits Section -->
            <div class="card shadow mb-4" id="visits">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-stethoscope"></i> Recent Medical Visits (Last 30 Days)
                    </h6>
                </div>
                <div class="card-body">
                    @if($recentVisits->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Student</th>
                                        <th>Purpose</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentVisits as $visit)
                                        <tr>
                                            <td>{{ $visit->visit_date->format('M d, Y') }}</td>
                                            <td>
                                                <a href="{{ route('adviser.students.show', $visit->student) }}" class="text-primary">
                                                    {{ $visit->student->first_name }} {{ $visit->student->last_name }}
                                                </a>
                                            </td>
                                            <td>{{ $visit->reason_for_visit }}</td>
                                            <td>
                                                @if($visit->status === 'completed')
                                                    <span class="badge badge-success">{{ ucfirst($visit->status) }}</span>
                                                @elseif($visit->status === 'pending')
                                                    <span class="badge badge-warning">{{ ucfirst($visit->status) }}</span>
                                                @elseif($visit->status === 'in_progress')
                                                    <span class="badge badge-info">{{ ucfirst($visit->status) }}</span>
                                                @else
                                                    <span class="badge badge-secondary">{{ ucfirst($visit->status ?? 'unknown') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('adviser.clinic-visits.show', $visit) }}" class="btn btn-sm btn-outline-primary" title="View Visit Details">
                                                        <i class="fas fa-eye"></i> Details
                                                    </a>
                                                    <a href="{{ route('adviser.students.show', $visit->student) }}" class="btn btn-sm btn-outline-secondary" title="View Student Profile">
                                                        <i class="fas fa-user"></i> Student
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-stethoscope fa-3x text-gray-300 mb-3"></i>
                            <h5 class="text-gray-500">No recent clinic visits</h5>
                            <p class="text-gray-400">Clinic visits for your students will appear here.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Allergies Overview Section -->
            <div class="card shadow mb-4" id="allergies">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">
                        <i class="fas fa-exclamation-triangle"></i> Students with Allergies ({{ $studentsWithAllergies }})
                    </h6>
                </div>
                <div class="card-body">
                    @if($studentsWithAllergies > 0)
                        <div class="row">
                            @foreach($students as $student)
                                @if($student->has_allergies && (!empty($student->allergies) || !empty($student->allergy_details)))
                                    <div class="col-md-6 mb-3">
                                        <div class="card border-left-warning">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h6 class="card-title">
                                                            <a href="{{ route('adviser.students.show', $student) }}" class="text-warning">
                                                                {{ $student->first_name }} {{ $student->last_name }}
                                                            </a>
                                                        </h6>
                                                        <p class="card-text small text-muted">Grade {{ $student->grade_level }} - {{ $student->section }}</p>
                                                        @if(!empty($student->allergies))
                                                            <div class="mt-2">
                                                                <strong>Allergies:</strong>
                                                                @if(is_array($student->allergies))
                                                                    <ul class="mb-0">
                                                                        @foreach($student->allergies as $allergy)
                                                                            <li class="small">{{ is_array($allergy) ? ($allergy['name'] ?? $allergy) : $allergy }}</li>
                                                                        @endforeach
                                                                    </ul>
                                                                @else
                                                                    <p class="small mb-0">{{ $student->allergies }}</p>
                                                                @endif
                                                            </div>
                                                        @endif
                                                        @if(!empty($student->allergy_details))
                                                            <div class="mt-2">
                                                                <strong>Details:</strong>
                                                                <p class="small mb-0">{{ $student->allergy_details }}</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <a href="{{ route('adviser.students.show', $student) }}" class="btn btn-sm btn-warning">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <h5 class="text-gray-500">No allergies reported</h5>
                            <p class="text-gray-400">All your students have completed their health forms with no allergies reported.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Pending Visits Section -->
            @if($pendingVisits > 0)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-danger">
                        <i class="fas fa-clock"></i> Pending Clinic Visits ({{ $pendingVisits }})
                    </h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Attention:</strong> There are {{ $pendingVisits }} pending clinic visits for your students.
                        Please follow up with the clinic staff regarding these visits.
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Visit Date</th>
                                    <th>Purpose</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentVisits->where('status', 'pending') as $visit)
                                    <tr>
                                        <td>
                                            <a href="{{ route('adviser.students.show', $visit->student) }}" class="text-danger font-weight-bold">
                                                {{ $visit->student->first_name }} {{ $visit->student->last_name }}
                                            </a>
                                        </td>
                                        <td>{{ $visit->visit_date->format('M d, Y') }}</td>
                                        <td>{{ $visit->reason_for_visit }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('adviser.clinic-visits.show', $visit) }}" class="btn btn-sm btn-outline-danger" title="View Visit Details">
                                                    <i class="fas fa-eye"></i> Details
                                                </a>
                                                <a href="{{ route('adviser.students.show', $visit->student) }}" class="btn btn-sm btn-outline-secondary" title="View Student Profile">
                                                    <i class="fas fa-user"></i> Student
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </main>
    </div>
</div>

<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}
.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}
.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}
.border-left-danger {
    border-left: 0.25rem solid #e74a3b !important;
}
.text-primary {
    color: #5a5c69 !important;
}
.text-gray-300 {
    color: #dddfeb !important;
}
.text-gray-800 {
    color: #5a5c69 !important;
}
.sidebar {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    z-index: 100;
    padding: 48px 0 0;
    box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
}
.sidebar-sticky {
    position: relative;
    top: 0;
    height: calc(100vh - 48px);
    padding-top: .5rem;
    overflow-x: hidden;
    overflow-y: auto;
}
</style>
@endsection
