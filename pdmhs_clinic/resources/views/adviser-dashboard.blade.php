@extends('layouts.app')

@section('title', 'Adviser Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8 flex justify-between items-start">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Adviser Dashboard</h1>
            <p class="text-gray-600">Welcome, {{ $user->name }}!</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="text-right">
                <div class="text-sm text-gray-500">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition duration-200 text-sm font-medium">
                    Logout
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Students -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="bg-blue-100 rounded-lg p-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Students</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalStudents }}</p>
                </div>
            </div>
        </div>

        <!-- Students with Allergies -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="bg-red-100 rounded-lg p-3">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Students with Allergies</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $studentsWithAllergies }}</p>
                </div>
            </div>
        </div>

        <!-- Recent Visits (30 days) -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="bg-green-100 rounded-lg p-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Recent Visits (30 days)</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $recentVisits->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Pending Visits -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="bg-yellow-100 rounded-lg p-3">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pending Visits</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $pendingVisits }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- My Students -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">My Students</h2>
        @if($students && $students->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student ID</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade & Section</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Allergies</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($students as $student)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">{{ $student->student_id }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">{{ $student->first_name }} {{ $student->last_name }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">{{ $student->grade_level }} {{ $student->section }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                    @if($student->allergies && is_array($student->allergies) && count($student->allergies) > 0)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            {{ count($student->allergies) }} allergy(ies)
                                        </span>
                                    @else
                                        <span class="text-gray-500">None</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('students.show', $student->id) }}" class="text-blue-600 hover:text-blue-900">View Details</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500">No students assigned to you yet.</p>
        @endif
    </div>

    <!-- Recent Clinic Visits -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Recent Clinic Visits (Last 30 Days)</h2>
        @if($recentVisits && $recentVisits->count() > 0)
            <div class="space-y-4">
                @foreach($recentVisits as $visit)
                    <div class="border-l-4 border-blue-500 pl-4 py-3 bg-gray-50 rounded-r-lg">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center gap-4 mb-2">
                                    <p class="font-medium text-gray-800">{{ $visit->student->first_name }} {{ $visit->student->last_name }}</p>
                                    <span class="px-2 py-1 text-xs rounded-full
                                        @if($visit->status == 'completed') bg-green-100 text-green-800
                                        @elseif($visit->status == 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($visit->status ?? 'unknown') }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 mb-1">
                                    <strong>Date:</strong> {{ $visit->visit_date ? \Carbon\Carbon::parse($visit->visit_date)->format('M d, Y') : 'N/A' }}
                                </p>
                                <p class="text-sm text-gray-600 mb-1">
                                    <strong>Reason:</strong> {{ $visit->reason_for_visit ?? 'N/A' }}
                                </p>
                                @if($visit->diagnosis)
                                    <p class="text-sm text-gray-600">
                                        <strong>Diagnosis:</strong> {{ $visit->diagnosis }}
                                    </p>
                                @endif
                            </div>
                            <a href="{{ route('clinic-visits.show', $visit->id) }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                View Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">No recent clinic visits in the last 30 days.</p>
        @endif
    </div>

    <!-- Students with Allergies -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Students with Allergies</h2>
        @if($students && $students->count() > 0)
            @php
                $studentsWithAllergiesList = $students->filter(function($student) {
                    return $student->allergies && is_array($student->allergies) && count($student->allergies) > 0;
                });
            @endphp

            @if($studentsWithAllergiesList->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($studentsWithAllergiesList as $student)
                        <div class="border border-red-200 rounded-lg p-4 bg-red-50">
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <h3 class="font-medium text-gray-900">{{ $student->first_name }} {{ $student->last_name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $student->grade_level }} {{ $student->section }}</p>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    {{ count($student->allergies) }} allergy(ies)
                                </span>
                            </div>
                            <div class="mb-3">
                                <p class="text-sm font-medium text-gray-700 mb-1">Allergies:</p>
                                <div class="flex flex-wrap gap-1">
                                    @foreach($student->allergies as $allergy)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            {{ $allergy }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            <a href="{{ route('students.show', $student->id) }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                View Full Profile →
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No students with recorded allergies.</p>
            @endif
        @else
            <p class="text-gray-500">No students assigned to you yet.</p>
        @endif
    </div>

    <!-- Pending Visits -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Pending Clinic Visits</h2>
        @if($students && $students->count() > 0)
            @php
                $pendingVisitsList = collect();
                foreach($students as $student) {
                    $studentPendingVisits = $student->clinicVisits()->where('status', 'pending')->get();
                    foreach($studentPendingVisits as $visit) {
                        $pendingVisitsList->push($visit);
                    }
                }
            @endphp

            @if($pendingVisitsList->count() > 0)
                <div class="space-y-3">
                    @foreach($pendingVisitsList as $visit)
                        <div class="border-l-4 border-yellow-500 pl-4 py-3 bg-yellow-50 rounded-r-lg">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center gap-4 mb-2">
                                        <p class="font-medium text-gray-800">{{ $visit->student->first_name }} {{ $visit->student->last_name }}</p>
                                        <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-1">
                                        <strong>Scheduled:</strong> {{ $visit->visit_date ? \Carbon\Carbon::parse($visit->visit_date)->format('M d, Y') : 'N/A' }}
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        <strong>Reason:</strong> {{ $visit->reason_for_visit ?? 'N/A' }}
                                    </p>
                                </div>
                                <a href="{{ route('clinic-visits.show', $visit->id) }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                    View Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No pending clinic visits.</p>
            @endif
        @else
            <p class="text-gray-500">No students assigned to you yet.</p>
        @endif
    </div>
</div>
@endsection
