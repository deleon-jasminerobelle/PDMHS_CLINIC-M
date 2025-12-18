@extends('layouts.app')

@section('title', 'Vital Signs Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Vital Signs Details</h1>
                    <div class="flex space-x-3">
                        <a href="{{ route('vitals.edit', $vital) }}" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">Edit</a>
                        <a href="{{ route('vitals.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600">Back to Vitals</a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Student Information</h3>
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Student:</span>
                                <p class="text-sm text-gray-900 dark:text-white">{{ $vital->clinicVisit->student->first_name }} {{ $vital->clinicVisit->student->last_name }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Student ID:</span>
                                <p class="text-sm text-gray-900 dark:text-white">{{ $vital->clinicVisit->student->student_id }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Grade:</span>
                                <p class="text-sm text-gray-900 dark:text-white">Grade {{ $vital->clinicVisit->student->grade_level }}-{{ $vital->clinicVisit->student->section }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Measurement Details</h3>
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Date:</span>
                                <p class="text-sm text-gray-900 dark:text-white">{{ $vital->created_at->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Time:</span>
                                <p class="text-sm text-gray-900 dark:text-white">{{ $vital->created_at->format('h:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Vital Measurements</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <span class="text-2xl">🩸</span>
                                </div>
                                <div class="ml-4">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Blood Pressure</dt>
                                    <dd class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ $vital->blood_pressure ?: 'N/A' }}
                                    </dd>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <span class="text-2xl">❤️</span>
                                </div>
                                <div class="ml-4">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Heart Rate</dt>
                                    <dd class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ $vital->heart_rate ? $vital->heart_rate . ' bpm' : 'N/A' }}
                                    </dd>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <span class="text-2xl">🌡️</span>
                                </div>
                                <div class="ml-4">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Temperature</dt>
                                    <dd class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ $vital->temperature ? $vital->temperature . '°C' : 'N/A' }}
                                    </dd>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <span class="text-2xl">⚖️</span>
                                </div>
                                <div class="ml-4">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Weight</dt>
                                    <dd class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ $vital->weight ? $vital->weight . ' kg' : 'N/A' }}
                                    </dd>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <span class="text-2xl">📏</span>
                                </div>
                                <div class="ml-4">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Height</dt>
                                    <dd class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ $vital->height ? $vital->height . ' cm' : 'N/A' }}
                                    </dd>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <span class="text-2xl">🫁</span>
                                </div>
                                <div class="ml-4">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Oxygen Saturation</dt>
                                    <dd class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ $vital->oxygen_saturation ? $vital->oxygen_saturation . '%' : 'N/A' }}
                                    </dd>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($vital->notes)
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Notes</h3>
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <p class="text-sm text-gray-900 dark:text-white">{{ $vital->notes }}</p>
                    </div>
                </div>
                @endif

                <div class="mt-8 flex justify-end">
                    <form method="POST" action="{{ route('vitals.destroy', $vital) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2" onclick="return confirm('Are you sure you want to delete this vital signs record?')">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
