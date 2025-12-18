@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Edit Health Incident</h1>
            <a href="{{ route('health-incidents.show', $healthIncident) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Cancel
            </a>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b">
                <h2 class="text-xl font-semibold text-gray-800">Update Incident Information</h2>
            </div>

            <form method="POST" action="{{ route('health-incidents.update', $healthIncident) }}" class="p-6">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">Student</label>
                    <select name="student_id" id="student_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('student_id') border-red-500 @enderror" required>
                        <option value="">Select a student</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ $healthIncident->student_id == $student->id ? 'selected' : '' }}>
                                {{ $student->first_name }} {{ $student->last_name }} ({{ $student->student_id }})
                            </option>
                        @endforeach
                    </select>
                    @error('student_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="incident_date" class="block text-sm font-medium text-gray-700 mb-2">Incident Date</label>
                    <input type="date" name="incident_date" id="incident_date" value="{{ old('incident_date', $healthIncident->incident_date->format('Y-m-d')) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('incident_date') border-red-500 @enderror" required>
                    @error('incident_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="incident_type" class="block text-sm font-medium text-gray-700 mb-2">Incident Type</label>
                    <input type="text" name="incident_type" id="incident_type" value="{{ old('incident_type', $healthIncident->incident_type) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('incident_type') border-red-500 @enderror" required>
                    @error('incident_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" id="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror" required>{{ old('description', $healthIncident->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="treatment_provided" class="block text-sm font-medium text-gray-700 mb-2">Treatment Provided</label>
                    <textarea name="treatment_provided" id="treatment_provided" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('treatment_provided') border-red-500 @enderror">{{ old('treatment_provided', $healthIncident->treatment_provided) }}</textarea>
                    @error('treatment_provided')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="reported_by" class="block text-sm font-medium text-gray-700 mb-2">Reported By</label>
                    <input type="text" name="reported_by" id="reported_by" value="{{ old('reported_by', $healthIncident->reported_by) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('reported_by') border-red-500 @enderror">
                    @error('reported_by')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="follow_up_actions" class="block text-sm font-medium text-gray-700 mb-2">Follow-up Actions</label>
                    <textarea name="follow_up_actions" id="follow_up_actions" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('follow_up_actions') border-red-500 @enderror">{{ old('follow_up_actions', $healthIncident->follow_up_actions) }}</textarea>
                    @error('follow_up_actions')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                        Update Incident
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
