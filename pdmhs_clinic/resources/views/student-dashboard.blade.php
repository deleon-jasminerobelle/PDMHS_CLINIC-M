@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50">
    <!-- Header Navigation -->
    <nav class="bg-gradient-to-r from-blue-600 to-blue-700 shadow-lg">
        <div class="max-w-6xl mx-auto px-6">
            <div class="flex items-center justify-between">
                <div class="flex space-x-8">
                    <a href="#" class="flex items-center space-x-2 py-4 px-2 border-b-2 border-white text-white">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-9 9a1 1 0 001.414 1.414L2 12.414V19a1 1 0 001 1h3a1 1 0 001-1v-3h2v3a1 1 0 001 1h3a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-9-9z"/>
                        </svg>
                        <span class="font-medium">Home</span>
                    </a>
                    <a href="#" class="flex items-center space-x-2 py-4 px-2 border-b-2 border-transparent text-blue-100 hover:text-white hover:border-blue-300 transition-all">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"/>
                            <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z"/>
                        </svg>
                        <span class="font-medium">Messages</span>
                    </a>
                    <a href="#" class="flex items-center space-x-2 py-4 px-2 border-b-2 border-transparent text-blue-100 hover:text-white hover:border-blue-300 transition-all">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                        </svg>
                        <span class="font-medium">Alerts</span>
                    </a>
                    <a href="#" class="flex items-center space-x-2 py-4 px-2 border-b-2 border-transparent text-blue-100 hover:text-white hover:border-blue-300 transition-all">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">Information</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="text-white hover:text-blue-100 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                        </svg>
                    </button>
                    <button class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-6 py-8">
        <!-- Welcome Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                Welcome back, {{ $studentData['name'] }}!
            </h1>
            <p class="text-gray-600">
                {{ $studentData['studentId'] }} • {{ $studentData['grade'] }} - {{ $studentData['section'] ?: 'Section' }}
            </p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm opacity-90">BMI</span>
                    <svg class="w-5 h-5 opacity-75" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="text-4xl font-bold">{{ $studentData['bmi'] }}</div>
            </div>

            <div class="bg-gradient-to-br from-red-400 to-red-500 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm opacity-90">Blood Type</span>
                    <svg class="w-5 h-5 opacity-75" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="text-4xl font-bold">{{ $studentData['bloodType'] }}</div>
            </div>

            <div class="bg-gradient-to-br from-orange-400 to-orange-500 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm opacity-90">Allergies</span>
                    <svg class="w-5 h-5 opacity-75" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="text-4xl font-bold">{{ $studentData['allergies'] }}</div>
            </div>

            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm opacity-90">Last Visit</span>
                    <svg class="w-5 h-5 opacity-75" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="text-2xl font-bold">{{ $studentData['lastVisit'] }}</div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Medical Information -->
            <div class="bg-white rounded-2xl shadow-md border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Medical Information</h3>
                <div class="grid grid-cols-2 gap-4">
                    @foreach($studentData['medicalInfo'] as $key => $value)
                    <div class="bg-gray-50 rounded-xl p-4">
                        <div class="text-xs text-gray-500 uppercase mb-1">
                            {{ ucwords(str_replace(['_', '-'], ' ', $key)) }}
                        </div>
                        <div class="text-lg font-semibold text-gray-900">{{ $value }}</div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Known Allergies -->
            <div class="bg-white rounded-2xl shadow-md border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Known Allergies</h3>
                    <button class="flex items-center space-x-2 px-3 py-1.5 text-sm text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                        </svg>
                        <span>Edit</span>
                    </button>
                </div>
                <div class="space-y-3">
                    @if(isset($studentData['knownAllergies']) && count($studentData['knownAllergies']) > 0)
                        @foreach($studentData['knownAllergies'] as $allergy)
                        <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                            <div class="font-medium text-gray-900">{{ $allergy }}</div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-gray-500 text-center py-4">No known allergies</div>
                    @endif
                </div>
            </div>

            <!-- Immunization Records -->
            <div class="bg-white rounded-2xl shadow-md border border-gray-200 p-6 lg:col-span-2">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Immunization Records</h3>
                <div class="space-y-3">
                    @if(isset($studentData['immunization']) && count($studentData['immunization']) > 0)
                        @foreach($studentData['immunization'] as $record)
                        <div class="flex items-center justify-between bg-gray-50 rounded-xl p-4">
                            <div>
                                <div class="font-semibold text-gray-900">{{ $record['name'] }}</div>
                                <div class="text-sm text-gray-500">{{ $record['date'] }}</div>
                            </div>
                            <span class="px-4 py-1.5 rounded-full text-sm font-medium {{ $record['status'] === 'Updated' ? 'bg-green-100 text-green-700 border border-green-200' : 'bg-orange-100 text-orange-700 border border-orange-200' }}">
                                {{ $record['status'] }}
                            </span>
                        </div>
                        @endforeach
                    @else
                        <div class="text-gray-500 text-center py-4">No immunization records</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
