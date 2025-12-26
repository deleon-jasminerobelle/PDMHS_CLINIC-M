@extends('layouts.app')

@section('title', 'Student Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8 flex justify-between items-start">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Welcome, {{ $user->name }}!</h1>
            <p class="text-gray-600">Your Health Dashboard</p>
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

    @if($student)
        <!-- Student Information Card -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Student Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <span class="font-medium text-gray-600">Student ID:</span>
                    <p class="text-gray-800">{{ $student->student_id ?? 'N/A' }}</p>
                </div>
                <div>
                    <span class="font-medium text-gray-600">Name:</span>
                    <p class="text-gray-800">{{ $student->first_name ?? '' }} {{ $student->last_name ?? '' }}</p>
                </div>
                <div>
                    <span class="font-medium text-gray-600">Age:</span>
                    <p class="text-gray-800">{{ $age ?? 'N/A' }}</p>
                </div>
                <div>
                    <span class="font-medium text-gray-600">Grade & Section:</span>
                    <p class="text-gray-800">{{ $student->grade_level ?? '' }} {{ $student->section ?? '' }}</p>
                </div>
                <div>
                    <span class="font-medium text-gray-600">School:</span>
                    <p class="text-gray-800">{{ $student->school ?? 'N/A' }}</p>
                </div>
                <div>
                    <span class="font-medium text-gray-600">Blood Type:</span>
                    <p class="text-gray-800">{{ $student->blood_type ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Health Vitals Card -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Health Vitals</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="text-center">
                    <div class="bg-blue-100 rounded-lg p-4">
                        <div class="text-2xl font-bold text-blue-600">{{ $student->height ?? 'N/A' }}</div>
                        <div class="text-sm text-gray-600">Height (cm)</div>
                    </div>
                </div>
                <div class="text-center">
                    <div class="bg-green-100 rounded-lg p-4">
                        <div class="text-2xl font-bold text-green-600">{{ $student->weight ?? 'N/A' }}</div>
                        <div class="text-sm text-gray-600">Weight (kg)</div>
                    </div>
                </div>
                <div class="text-center">
                    <div class="bg-yellow-100 rounded-lg p-4">
                        <div class="text-2xl font-bold text-yellow-600">{{ $student->temperature ?? 'N/A' }}</div>
                        <div class="text-sm text-gray-600">Temperature (°C)</div>
                    </div>
                </div>
                <div class="text-center">
                    <div class="bg-purple-100 rounded-lg p-4">
                        <div class="text-2xl font-bold text-purple-600">{{ $student->blood_pressure ?? 'N/A' }}</div>
                        <div class="text-sm text-gray-600">Blood Pressure</div>
                    </div>
                </div>
            </div>
            @if($student->height && $student->weight && $student->height > 0)
                <div class="mt-4 text-center">
                    <span class="font-medium text-gray-600">BMI:</span>
                    <span class="text-lg font-bold text-blue-600">{{ number_format($student->bmi ?? 0, 1) }}</span>
                    <span class="text-sm text-gray-500">
                        @if($student->bmi)
                            @if($student->bmi < 18.5) (Underweight)
                            @elseif($student->bmi < 25) (Normal)
                            @elseif($student->bmi < 30) (Overweight)
                            @else (Obese)
                            @endif
                        @endif
                    </span>
                </div>
            @endif
        </div>

        <!-- Medical Information Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Allergies -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Allergies</h3>
                @if($student->allergies && is_array($student->allergies) && count($student->allergies) > 0)
                    <div class="flex flex-wrap gap-2">
                        @foreach($student->allergies as $allergy)
                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm">{{ $allergy }}</span>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">No allergies recorded</p>
                @endif
            </div>

            <!-- Medical Conditions -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Medical Conditions</h3>
                @if($student->medical_conditions && is_array($student->medical_conditions) && count($student->medical_conditions) > 0)
                    <div class="flex flex-wrap gap-2">
                        @foreach($student->medical_conditions as $condition)
                            <span class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm">{{ $condition }}</span>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">No medical conditions recorded</p>
                @endif
            </div>
        </div>

        <!-- Family History -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Family Medical History</h3>
            @if($student->family_history && is_array($student->family_history) && count($student->family_history) > 0)
                <div class="flex flex-wrap gap-2">
                    @foreach($student->family_history as $condition)
                        <span class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm">{{ $condition }}</span>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No family medical history recorded</p>
            @endif
        </div>

        <!-- Emergency Contact -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Emergency Contact</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <span class="font-medium text-gray-600">Name:</span>
                    <p class="text-gray-800">{{ $student->emergency_contact_name ?? 'N/A' }}</p>
                </div>
                <div>
                    <span class="font-medium text-gray-600">Relationship:</span>
                    <p class="text-gray-800">{{ $student->emergency_relation ?? 'N/A' }}</p>
                </div>
                <div>
                    <span class="font-medium text-gray-600">Phone:</span>
                    <p class="text-gray-800">{{ $student->emergency_contact_number ?? 'N/A' }}</p>
                </div>
                <div>
                    <span class="font-medium text-gray-600">Address:</span>
                    <p class="text-gray-800">{{ $student->emergency_address ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Recent Clinic Visits -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Recent Clinic Visits</h3>
            @if($recentVisits && $recentVisits->count() > 0)
                <div class="space-y-3">
                    @foreach($recentVisits as $visit)
                        <div class="border-l-4 border-blue-500 pl-4 py-2">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-medium text-gray-800">{{ $visit->visit_date ? \Carbon\Carbon::parse($visit->visit_date)->format('M d, Y') : 'N/A' }}</p>
                                    <p class="text-sm text-gray-600">{{ $visit->reason ?? 'N/A' }}</p>
                                </div>
                                <span class="px-2 py-1 text-xs rounded-full
                                    @if($visit->status == 'completed') bg-green-100 text-green-800
                                    @elseif($visit->status == 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($visit->status ?? 'unknown') }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <p class="text-sm text-gray-500 mt-3">Total visits: {{ $totalVisits }}</p>
            @else
                <p class="text-gray-500">No clinic visits recorded</p>
            @endif
        </div>

        <!-- Actions -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Actions</h3>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('student.profile') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    View Full Profile
                </a>
                <a href="{{ route('student-health-form') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    Update Health Form
                </a>
            </div>
        </div>

        <!-- QR Code Section -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Your QR Code</h3>
            <p class="text-gray-600 mb-4">Show this QR code to clinic staff for quick check-in and access to your health records.</p>
            <div class="flex flex-col items-center">
                <div id="qrcode" class="mb-4"></div>
                <p class="text-sm text-gray-500">Student ID: {{ $student->student_id ?? 'N/A' }}</p>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const studentId = '{{ $student->student_id ?? '' }}';
                if (studentId) {
                    new QRCode(document.getElementById("qrcode"), {
                        text: studentId,
                        width: 200,
                        height: 200,
                        colorDark: "#000000",
                        colorLight: "#ffffff",
                        correctLevel: QRCode.CorrectLevel.H
                    });
                }
            });
        </script>
    @else
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-6">
            <p>Student record not found. Please complete your health form.</p>
            <a href="{{ route('student-health-form') }}" class="underline text-yellow-800">Go to Health Form</a>
        </div>
    @endif
</div>
@endsection
