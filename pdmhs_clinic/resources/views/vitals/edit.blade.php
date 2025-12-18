@extends('layouts.app')

@section('title', 'Edit Vital Signs')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Vital Signs</h1>
                    <a href="{{ route('vitals.show', $vital) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400">← Back to Vital Details</a>
                </div>

                <form method="POST" action="{{ route('vitals.update', $vital) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="clinic_visit_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Clinic Visit</label>
                        <select id="clinic_visit_id" name="clinic_visit_id" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required>
                            <option value="">Select a clinic visit</option>
                            @foreach($clinicVisits as $visit)
                                <option value="{{ $visit->id }}" {{ $vital->clinic_visit_id == $visit->id ? 'selected' : '' }}>{{ $visit->student->first_name }} {{ $visit->student->last_name }} ({{ $visit->student->student_id }}) - {{ $visit->visit_date->format('M d, Y') }}</option>
                            @endforeach
                        </select>
                        @error('clinic_visit_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="blood_pressure" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Blood Pressure</label>
                        <input type="text" id="blood_pressure" name="blood_pressure" value="{{ old('blood_pressure', $vital->blood_pressure) }}" placeholder="120/80" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        @error('blood_pressure')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="heart_rate" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Heart Rate (bpm)</label>
                            <input type="number" id="heart_rate" name="heart_rate" value="{{ old('heart_rate', $vital->heart_rate) }}" placeholder="72" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            @error('heart_rate')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="temperature" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Temperature (°C)</label>
                            <input type="number" step="0.1" id="temperature" name="temperature" value="{{ old('temperature', $vital->temperature) }}" placeholder="36.5" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            @error('temperature')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="weight" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Weight (kg)</label>
                        <input type="number" step="0.1" id="weight" name="weight" value="{{ old('weight', $vital->weight) }}" placeholder="50.0" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        @error('weight')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="height" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Height (cm)</label>
                        <input type="number" step="0.1" id="height" name="height" value="{{ old('height', $vital->height) }}" placeholder="150.0" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        @error('height')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="oxygen_saturation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Oxygen Saturation (%)</label>
                        <input type="number" step="0.1" id="oxygen_saturation" name="oxygen_saturation" value="{{ old('oxygen_saturation', $vital->oxygen_saturation) }}" placeholder="98.0" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        @error('oxygen_saturation')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Notes</label>
                        <textarea id="notes" name="notes" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" placeholder="Additional notes...">{{ old('notes', $vital->notes) }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('vitals.show', $vital) }}" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600">Cancel</a>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Update Vitals</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
