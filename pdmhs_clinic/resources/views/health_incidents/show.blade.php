@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Health Incident Details</h1>
            <div>
                <a href="{{ route('health-incidents.edit', $healthIncident) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
                    Edit
                </a>
                <a href="{{ route('health-incidents.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to List
                </a>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b">
                <h2 class="text-xl font-semibold text-gray-800">Incident Information</h2>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Student Information</h3>
                        <div class="space-y-2">
                            <p><strong>Name:</strong> {{ $healthIncident->student->first_name }} {{ $healthIncident->student->last_name }}</p>
                            <p><strong>Student ID:</strong> {{ $healthIncident->student->student_id }}</p>
                            <p><strong>Grade & Section:</strong> {{ $healthIncident->student->grade_level }} - {{ $healthIncident->student->section }}</p>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Incident Details</h3>
                        <div class="space-y-2">
                            <p><strong>Date:</strong> {{ $healthIncident->incident_date->format('F d, Y') }}</p>
                            <p><strong>Type:</strong> {{ $healthIncident->incident_type }}</p>
                            <p><strong>Reported By:</strong> {{ $healthIncident->reported_by ?: 'Not specified' }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Description</h3>
                    <p class="text-gray-700 bg-gray-50 p-4 rounded">{{ $healthIncident->description }}</p>
                </div>

                @if($healthIncident->treatment_provided)
                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Treatment Provided</h3>
                    <p class="text-gray-700 bg-gray-50 p-4 rounded">{{ $healthIncident->treatment_provided }}</p>
                </div>
                @endif

                @if($healthIncident->follow_up_actions)
                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Follow-up Actions</h3>
                    <p class="text-gray-700 bg-gray-50 p-4 rounded">{{ $healthIncident->follow_up_actions }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
