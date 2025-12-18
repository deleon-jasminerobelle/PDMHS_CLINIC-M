@extends('layouts.app')

@section('title', 'Clinic Visit Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Clinic Visit Details</h1>
                    <div class="flex space-x-2">
                        <a href="{{ route('clinic.visits.edit', $clinicVisit) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">
                            Edit Visit
                        </a>
                        <a href="{{ route('clinic.visits.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                            Back to Visits
                        </a>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <!-- Visit Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="space-y-4">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Visit Information</h2>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Visit Date & Time</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $clinicVisit->visit_date->format('F d, Y \a\t h:i A') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Reason for Visit</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $clinicVisit->reason_for_visit }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Symptoms</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $clinicVisit->symptoms ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                            <span class="mt-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($clinicVisit->status == 'completed') bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                                @elseif($clinicVisit->status == 'in_progress') bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100
                                @else bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100 @endif">
                                {{ ucfirst(str_replace('_', ' ', $clinicVisit->status ?? 'pending')) }}
                            </span>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Student Information</h2>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Student Name</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                <a href="{{ route('students.show', $clinicVisit->student) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400">
                                    {{ $clinicVisit->student->first_name }} {{ $clinicVisit->student->last_name }}
                                </a>
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Student ID</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $clinicVisit->student->student_id }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Grade</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $clinicVisit->student->grade }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Age</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                @if($clinicVisit->student->date_of_birth)
                                    {{ $clinicVisit->student->date_of_birth->age }} years old
                                @else
                                    N/A
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Medical Assessment -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Medical Assessment</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Diagnosis</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $clinicVisit->diagnosis ?? 'Not yet diagnosed' }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Treatment</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $clinicVisit->treatment ?? 'N/A' }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Medications Prescribed</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $clinicVisit->medications ?? 'None' }}</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Follow-up Required</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $clinicVisit->follow_up_required ? 'Yes' : 'No' }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Follow-up Date</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                    {{ $clinicVisit->follow_up_date ? $clinicVisit->follow_up_date->format('F d, Y') : 'N/A' }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Notes</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $clinicVisit->notes ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Vitals -->
                @if($clinicVisit->vitals && $clinicVisit->vitals->count() > 0)
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Vitals Recorded</h2>

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Time</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Temperature</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Blood Pressure</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Heart Rate</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Weight</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Height</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($clinicVisit->vitals as $vital)
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">{{ $vital->recorded_at->format('h:i A') }}</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500 dark:text-gray-300">{{ $vital->temperature ?? 'N/A' }} °F</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500 dark:text-gray-300">{{ $vital->blood_pressure ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500 dark:text-gray-300">{{ $vital->heart_rate ?? 'N/A' }} bpm</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500 dark:text-gray-300">{{ $vital->weight ?? 'N/A' }} lbs</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500 dark:text-gray-300">{{ $vital->height ?? 'N/A' }} in</div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                <!-- Actions -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <form method="POST" action="{{ route('clinic.visits.destroy', $clinicVisit) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg" onclick="return confirm('Are you sure you want to delete this clinic visit?')">
                            Delete Visit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
