@extends('layouts.app')

@section('title', 'Student Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Student Details</h1>
                    <div class="flex space-x-2">
                        <a href="{{ route('students.edit', $student) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">
                            Edit Student
                        </a>
                        <a href="{{ route('students.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                            Back to Students
                        </a>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Personal Information -->
                    <div class="space-y-4">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Personal Information</h2>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full Name</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $student->first_name }} {{ $student->last_name }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Student ID</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $student->student_id }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date of Birth</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $student->date_of_birth ? $student->date_of_birth->format('F d, Y') : 'N/A' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Gender</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $student->gender ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Grade</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $student->grade ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="space-y-4">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Contact Information</h2>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $student->email ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $student->phone ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Address</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $student->address ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Emergency Contact</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $student->emergency_contact ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Emergency Phone</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $student->emergency_phone ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Medical Information -->
                <div class="mt-8">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Medical Information</h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Blood Type</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $student->blood_type ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Allergies</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $student->allergies ?? 'None' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Medical Conditions</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $student->medical_conditions ?? 'None' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Clinic Visits -->
                <div class="mt-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Recent Clinic Visits</h2>
                        <a href="{{ route('clinic.visits.create', ['student_id' => $student->id]) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                            New Visit
                        </a>
                    </div>

                    @if($student->clinicVisits && $student->clinicVisits->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Reason</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Diagnosis</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($student->clinicVisits->take(5) as $visit)
                                    <tr>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-white">{{ $visit->visit_date->format('M d, Y') }}</div>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500 dark:text-gray-300">{{ $visit->reason_for_visit }}</div>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500 dark:text-gray-300">{{ $visit->diagnosis ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('clinic.visits.show', $visit) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400">View</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">No clinic visits recorded yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
