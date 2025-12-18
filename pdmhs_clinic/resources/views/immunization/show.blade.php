@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Immunization Record Details</h1>
            <div>
                <a href="{{ route('immunizations.edit', $immunization) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
                    Edit
                </a>
                <a href="{{ route('immunizations.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to List
                </a>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b">
                <h2 class="text-xl font-semibold text-gray-800">Immunization Information</h2>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Student Information</h3>
                        <div class="space-y-2">
                            <p><strong>Name:</strong> {{ $immunization->student->first_name }} {{ $immunization->student->last_name }}</p>
                            <p><strong>Student ID:</strong> {{ $immunization->student->student_id }}</p>
                            <p><strong>Grade & Section:</strong> {{ $immunization->student->grade_level }} - {{ $immunization->student->section }}</p>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Vaccine Details</h3>
                        <div class="space-y-2">
                            <p><strong>Vaccine Name:</strong> {{ $immunization->vaccine_name }}</p>
                            <p><strong>Date Administered:</strong> {{ $immunization->date_administered->format('F d, Y') }}</p>
                            <p><strong>Next Due Date:</strong> {{ $immunization->next_due_date ? $immunization->next_due_date->format('F d, Y') : 'Not scheduled' }}</p>
                            <p><strong>Administered By:</strong> {{ $immunization->administered_by ?: 'Not specified' }}</p>
                            <p><strong>Batch Number:</strong> {{ $immunization->batch_number ?: 'Not specified' }}</p>
                        </div>
                    </div>
                </div>

                @if($immunization->notes)
                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Notes</h3>
                    <p class="text-gray-700 bg-gray-50 p-4 rounded">{{ $immunization->notes }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
