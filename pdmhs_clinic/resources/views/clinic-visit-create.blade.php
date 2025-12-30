@extends('layouts.app')

@section('title', 'Create Clinic Visit')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('clinic-staff.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('clinic-staff.students') }}">
                            <i class="fas fa-users"></i> Students
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('scanner') }}">
                            <i class="fas fa-qrcode"></i> QR Scanner
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('clinic-staff.visits') }}">
                            <i class="fas fa-calendar-check"></i> Visits
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('clinic-staff.profile') }}">
                            <i class="fas fa-user"></i> Profile
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main role="main" class="col-md-10 ml-sm-auto col-lg-10 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Create Clinic Visit</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('scanner') }}" class="btn btn-outline-primary">
                        <i class="fas fa-qrcode"></i> Back to Scanner
                    </a>
                </div>
            </div>

            <!-- Student Information Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Student Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>{{ $student->first_name }} {{ $student->last_name }}</h6>
                            <p class="text-muted mb-1">Student ID: {{ $student->student_id }}</p>
                            <p class="text-muted mb-1">Grade {{ $student->grade_level }} - {{ $student->section }}</p>
                            @if($age)
                                <p class="text-muted mb-1">Age: {{ $age }} years old</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6>Latest Vitals</h6>
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted">Weight:</small><br>
                                    <strong>{{ $latestVitals->weight ?: 'Not recorded' }}</strong>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Height:</small><br>
                                    <strong>{{ $latestVitals->height ?: 'Not recorded' }}</strong>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Temperature:</small><br>
                                    <strong>{{ $latestVitals->temperature ?: 'Not recorded' }}</strong>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Blood Pressure:</small><br>
                                    <strong>{{ $latestVitals->blood_pressure ?: 'Not recorded' }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($allergies->count() > 0)
                    <div class="mt-3">
                        <h6>Allergies</h6>
                        <div class="alert alert-warning">
                            <ul class="mb-0">
                                @foreach($allergies as $allergy)
                                <li>{{ $allergy->allergy_name ?? $allergy }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Recent Visits -->
            @if($recentVisits->count() > 0)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Recent Visits</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentVisits as $visit)
                                <tr>
                                    <td>{{ $visit->visit_date ? \Carbon\Carbon::parse($visit->visit_date)->format('M d, Y') : 'N/A' }}</td>
                                    <td>{{ $visit->visit_type ?? 'General' }}</td>
                                    <td>
                                        <span class="badge badge-{{ $visit->status === 'completed' ? 'success' : 'warning' }}">
                                            {{ ucfirst($visit->status ?? 'pending') }}
                                        </span>
                                    </td>
                                    <td>{{ Str::limit($visit->notes ?? '', 50) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <!-- Visit Form -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Visit Details</h5>
                </div>
                <div class="card-body">
                    <form id="clinicVisitForm" action="{{ route('clinic-visit.store', $student->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="visit_datetime">Visit Date & Time *</label>
                                    <input type="datetime-local" class="form-control @error('visit_datetime') is-invalid @enderror"
                                           id="visit_datetime" name="visit_datetime"
                                           value="{{ old('visit_datetime', $currentDateTime) }}" required>
                                    @error('visit_datetime')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="visit_type">Visit Type *</label>
                                    <select class="form-control @error('visit_type') is-invalid @enderror"
                                            id="visit_type" name="visit_type" required>
                                        <option value="">Select visit type</option>
                                        <option value="Routine Checkup" {{ old('visit_type') === 'Routine Checkup' ? 'selected' : '' }}>Routine Checkup</option>
                                        <option value="Emergency" {{ old('visit_type') === 'Emergency' ? 'selected' : '' }}>Emergency</option>
                                        <option value="Follow-up" {{ old('visit_type') === 'Follow-up' ? 'selected' : '' }}>Follow-up</option>
                                        <option value="Illness" {{ old('visit_type') === 'Illness' ? 'selected' : '' }}>Illness</option>
                                        <option value="Injury" {{ old('visit_type') === 'Injury' ? 'selected' : '' }}>Injury</option>
                                        <option value="Vaccination" {{ old('visit_type') === 'Vaccination' ? 'selected' : '' }}>Vaccination</option>
                                        <option value="Other" {{ old('visit_type') === 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('visit_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="chief_complaint">Chief Complaint / Reason for Visit *</label>
                            <textarea class="form-control @error('chief_complaint') is-invalid @enderror"
                                      id="chief_complaint" name="chief_complaint" rows="3"
                                      placeholder="Describe the main reason for this visit..." required>{{ old('chief_complaint') }}</textarea>
                            @error('chief_complaint')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Vitals Section -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Vitals (Optional)</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="weight">Weight (kg)</label>
                                            <input type="number" step="0.1" class="form-control @error('weight') is-invalid @enderror"
                                                   id="weight" name="weight" value="{{ old('weight', $latestVitals->weight) }}">
                                            @error('weight')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="height">Height (cm)</label>
                                            <input type="number" step="0.1" class="form-control @error('height') is-invalid @enderror"
                                                   id="height" name="height" value="{{ old('height', $latestVitals->height) }}">
                                            @error('height')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="temperature">Temperature (°C)</label>
                                            <input type="number" step="0.1" class="form-control @error('temperature') is-invalid @enderror"
                                                   id="temperature" name="temperature" value="{{ old('temperature', $latestVitals->temperature) }}">
                                            @error('temperature')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="blood_pressure">Blood Pressure</label>
                                            <input type="text" class="form-control @error('blood_pressure') is-invalid @enderror"
                                                   id="blood_pressure" name="blood_pressure"
                                                   placeholder="120/80" value="{{ old('blood_pressure', $latestVitals->blood_pressure) }}">
                                            @error('blood_pressure')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="notes">Additional Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror"
                                      id="notes" name="notes" rows="4"
                                      placeholder="Any additional observations, treatments, or notes...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="requires_followup" name="requires_followup" value="1" {{ old('requires_followup') ? 'checked' : '' }}>
                                <label class="form-check-label" for="requires_followup">
                                    Requires follow-up visit
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Visit
                            </button>
                            <a href="{{ route('scanner') }}" class="btn btn-secondary ml-2">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
// Auto-calculate BMI when weight and height are entered
function calculateBMI() {
    const weight = parseFloat(document.getElementById('weight').value);
    const height = parseFloat(document.getElementById('height').value);

    if (weight > 0 && height > 0) {
        const heightInMeters = height / 100;
        const bmi = weight / (heightInMeters * heightInMeters);
        // You could add a BMI display field here if needed
        console.log('BMI:', bmi.toFixed(1));
    }
}

document.getElementById('weight').addEventListener('input', calculateBMI);
document.getElementById('height').addEventListener('input', calculateBMI);

// Form validation
document.getElementById('clinicVisitForm').addEventListener('submit', function(e) {
    const requiredFields = ['visit_datetime', 'visit_type', 'chief_complaint'];
    let isValid = true;

    requiredFields.forEach(field => {
        const element = document.getElementById(field);
        if (!element.value.trim()) {
            element.classList.add('is-invalid');
            isValid = false;
        } else {
            element.classList.remove('is-invalid');
        }
    });

    if (!isValid) {
        e.preventDefault();
        alert('Please fill in all required fields.');
    }
});
</script>
@endsection
