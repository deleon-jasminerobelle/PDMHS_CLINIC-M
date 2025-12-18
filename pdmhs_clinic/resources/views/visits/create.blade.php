@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-10 offset-md-1">
        <div class="card">
            <div class="card-header">
                <h3>Create New Clinic Visit</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('clinic-visits.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="student_id" class="form-label">Student *</label>
                            <select class="form-control @error('student_id') is-invalid @enderror" id="student_id" name="student_id" required>
                                <option value="">Select Student</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                        {{ $student->first_name }} {{ $student->last_name }} ({{ $student->student_id }})
                                    </option>
                                @endforeach
                            </select>
                            @error('student_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="visit_date" class="form-label">Visit Date *</label>
                            <input type="datetime-local" class="form-control @error('visit_date') is-invalid @enderror" id="visit_date" name="visit_date" value="{{ old('visit_date') }}" required>
                            @error('visit_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="reason" class="form-label">Reason for Visit *</label>
                            <select class="form-control @error('reason') is-invalid @enderror" id="reason" name="reason" required>
                                <option value="">Select Reason</option>
                                <option value="checkup" {{ old('reason') == 'checkup' ? 'selected' : '' }}>Regular Checkup</option>
                                <option value="illness" {{ old('reason') == 'illness' ? 'selected' : '' }}>Illness</option>
                                <option value="injury" {{ old('reason') == 'injury' ? 'selected' : '' }}>Injury</option>
                                <option value="vaccination" {{ old('reason') == 'vaccination' ? 'selected' : '' }}>Vaccination</option>
                                <option value="follow_up" {{ old('reason') == 'follow_up' ? 'selected' : '' }}>Follow-up</option>
                                <option value="emergency" {{ old('reason') == 'emergency' ? 'selected' : '' }}>Emergency</option>
                                <option value="other" {{ old('reason') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status *</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="scheduled" {{ old('status', 'scheduled') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="symptoms" class="form-label">Symptoms/Description</label>
                        <textarea class="form-control @error('symptoms') is-invalid @enderror" id="symptoms" name="symptoms" rows="3" placeholder="Describe the symptoms or reason for visit">{{ old('symptoms') }}</textarea>
                        @error('symptoms')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="temperature" class="form-label">Temperature (°C)</label>
                            <input type="number" step="0.1" class="form-control @error('temperature') is-invalid @enderror" id="temperature" name="temperature" value="{{ old('temperature') }}" placeholder="36.5">
                            @error('temperature')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="blood_pressure" class="form-label">Blood Pressure</label>
                            <input type="text" class="form-control @error('blood_pressure') is-invalid @enderror" id="blood_pressure" name="blood_pressure" value="{{ old('blood_pressure') }}" placeholder="120/80">
                            @error('blood_pressure')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="heart_rate" class="form-label">Heart Rate (bpm)</label>
                            <input type="number" class="form-control @error('heart_rate') is-invalid @enderror" id="heart_rate" name="heart_rate" value="{{ old('heart_rate') }}" placeholder="72">
                            @error('heart_rate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="weight" class="form-label">Weight (kg)</label>
                            <input type="number" step="0.1" class="form-control @error('weight') is-invalid @enderror" id="weight" name="weight" value="{{ old('weight') }}">
                            @error('weight')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="diagnosis" class="form-label">Diagnosis</label>
                        <textarea class="form-control @error('diagnosis') is-invalid @enderror" id="diagnosis" name="diagnosis" rows="2" placeholder="Medical diagnosis">{{ old('diagnosis') }}</textarea>
                        @error('diagnosis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="treatment" class="form-label">Treatment/Prescription</label>
                        <textarea class="form-control @error('treatment') is-invalid @enderror" id="treatment" name="treatment" rows="3" placeholder="Treatment plan and medications">{{ old('treatment') }}</textarea>
                        @error('treatment')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Additional Notes</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="2" placeholder="Any additional notes">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('clinic-visits.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create Clinic Visit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
