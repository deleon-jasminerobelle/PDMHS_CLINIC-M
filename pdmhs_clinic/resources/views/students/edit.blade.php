@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h3>Edit Student</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('students.update', $student) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="student_id" class="form-label">Student ID *</label>
                            <input type="text" class="form-control @error('student_id') is-invalid @enderror" id="student_id" name="student_id" value="{{ old('student_id', $student->student_id) }}" required>
                            @error('student_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="first_name" class="form-label">First Name *</label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name', $student->first_name) }}" required>
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="last_name" class="form-label">Last Name *</label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name', $student->last_name) }}" required>
                            @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="date_of_birth" class="form-label">Date of Birth *</label>
                            <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $student->date_of_birth ? $student->date_of_birth->format('Y-m-d') : '') }}" required>
                            @error('date_of_birth')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="grade_level" class="form-label">Grade Level *</label>
                            <select class="form-control @error('grade_level') is-invalid @enderror" id="grade_level" name="grade_level" required>
                                <option value="">Select Grade</option>
                                <option value="1" {{ old('grade_level', $student->grade_level) == '1' ? 'selected' : '' }}>Grade 1</option>
                                <option value="2" {{ old('grade_level', $student->grade_level) == '2' ? 'selected' : '' }}>Grade 2</option>
                                <option value="3" {{ old('grade_level', $student->grade_level) == '3' ? 'selected' : '' }}>Grade 3</option>
                                <option value="4" {{ old('grade_level', $student->grade_level) == '4' ? 'selected' : '' }}>Grade 4</option>
                                <option value="5" {{ old('grade_level', $student->grade_level) == '5' ? 'selected' : '' }}>Grade 5</option>
                                <option value="6" {{ old('grade_level', $student->grade_level) == '6' ? 'selected' : '' }}>Grade 6</option>
                            </select>
                            @error('grade_level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="section" class="form-label">Section *</label>
                            <select class="form-control @error('section') is-invalid @enderror" id="section" name="section" required>
                                <option value="">Select Section</option>
                                <option value="A" {{ old('section', $student->section) == 'A' ? 'selected' : '' }}>Section A</option>
                                <option value="B" {{ old('section', $student->section) == 'B' ? 'selected' : '' }}>Section B</option>
                                <option value="C" {{ old('section', $student->section) == 'C' ? 'selected' : '' }}>Section C</option>
                            </select>
                            @error('section')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="contact_number" class="form-label">Contact Number</label>
                            <input type="text" class="form-control @error('contact_number') is-invalid @enderror" id="contact_number" name="contact_number" value="{{ old('contact_number', $student->contact_number) }}">
                            @error('contact_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="emergency_contact_name" class="form-label">Emergency Contact Name</label>
                            <input type="text" class="form-control @error('emergency_contact_name') is-invalid @enderror" id="emergency_contact_name" name="emergency_contact_name" value="{{ old('emergency_contact_name', $student->emergency_contact_name) }}">
                            @error('emergency_contact_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="emergency_contact_number" class="form-label">Emergency Contact Number</label>
                            <input type="text" class="form-control @error('emergency_contact_number') is-invalid @enderror" id="emergency_contact_number" name="emergency_contact_number" value="{{ old('emergency_contact_number', $student->emergency_contact_number) }}">
                            @error('emergency_contact_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address', $student->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('students.show', $student) }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Student</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
