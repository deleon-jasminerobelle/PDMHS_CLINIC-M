<<<<<<< HEAD
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
=======
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - PDMHS Clinic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        .stat-card {
            border-radius: 12px;
            border: none;
            padding: 1.5rem;
            margin-bottom: 1rem;
            color: white;
            font-weight: 500;
        }
        .stat-card h2 {
            font-size: 2.5rem;
            font-weight: 300;
            margin-bottom: 0.5rem;
        }
        .stat-card p {
            margin: 0;
            opacity: 0.9;
        }
        .stat-card-blue { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .stat-card-orange { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
        .stat-card-yellow { background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%); color: #333; }
        .stat-card-purple { background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); color: #333; }
        .stat-card-green { background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%); color: #333; }
        .stat-card-red { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: #333; }
        
        .section-card {
            background: white;
            border-radius: 12px;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        .section-header {
            padding: 1.5rem;
            border-bottom: 1px solid #eee;
            font-weight: 600;
            color: #6c757d;
        }
        .section-content {
            padding: 2rem;
        }
        .navbar-brand {
            font-weight: 600;
        }
        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .info-item:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #6c757d;
        }
        .info-value {
            color: #333;
        }
        .allergy-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            margin: 0.25rem;
            border-radius: 20px;
            font-size: 0.875rem;
        }
        .allergy-mild { background-color: #d4edda; color: #155724; }
        .allergy-moderate { background-color: #fff3cd; color: #856404; }
        .allergy-severe { background-color: #f8d7da; color: #721c24; }
        .bmi-indicator {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            display: inline-block;
        }
        .bmi-underweight { background-color: #cce5ff; color: #004085; }
        .bmi-normal { background-color: #d4edda; color: #155724; }
        .bmi-overweight { background-color: #fff3cd; color: #856404; }
        .bmi-obese { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-heartbeat me-2"></i>
                PDMHS Clinic
            </a>
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user me-1"></i>
                        {{ $student->first_name }} {{ $student->last_name }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user-cog me-2"></i>Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
>>>>>>> ba9aaa71bc9abfb6ff0b899eb0b1e7a9be6803ee
                </div>
            </div>
        </div>
    </nav>

<<<<<<< HEAD
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
=======
    <div class="container mt-4">
        <!-- Header -->
        <div class="mb-4">
            <h1 class="h3 mb-1">Student Health Dashboard</h1>
            <p class="text-muted">Welcome, {{ $student->first_name }} {{ $student->last_name }}</p>
        </div>

        <!-- Health Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-2 mb-3">
                <div class="stat-card stat-card-blue">
                    <h2>{{ $age ?? 'N/A' }}</h2>
                    <p>Age (Years)</p>
                </div>
            </div>

            <div class="col-md-2 mb-3">
                <div class="stat-card stat-card-orange">
                    <h2>{{ $latestVitals->weight ?? 'N/A' }}</h2>
                    <p>Weight (kg)</p>
                </div>
            </div>

            <div class="col-md-2 mb-3">
                <div class="stat-card stat-card-yellow">
                    <h2>{{ $latestVitals->height ?? 'N/A' }}</h2>
                    <p>Height (cm)</p>
                </div>
            </div>

            <div class="col-md-2 mb-3">
                <div class="stat-card stat-card-purple">
                    <h2>{{ $bmi ?? 'N/A' }}</h2>
                    <p>BMI</p>
                </div>
            </div>

            <div class="col-md-2 mb-3">
                <div class="stat-card stat-card-green">
                    <h2>{{ $totalVisits }}</h2>
                    <p>Total Visits</p>
                </div>
            </div>

            <div class="col-md-2 mb-3">
                <div class="stat-card stat-card-red">
                    <h2>{{ $allergies->count() }}</h2>
                    <p>Known Allergies</p>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Personal Information -->
            <div class="col-md-6 mb-4">
                <div class="section-card">
                    <div class="section-header">
                        <h5 class="mb-0"><i class="fas fa-user me-2"></i>Personal Information</h5>
                    </div>
                    <div class="section-content">
                        <div class="info-item">
                            <span class="info-label">Student ID:</span>
                            <span class="info-value">{{ $student->student_id }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Full Name:</span>
                            <span class="info-value">{{ $student->first_name }} {{ $student->last_name }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Birth Date:</span>
                            <span class="info-value">{{ $student->date_of_birth ? $student->date_of_birth->format('M j, Y') : 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Grade Level:</span>
                            <span class="info-value">{{ $student->grade_level ?? 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Section:</span>
                            <span class="info-value">{{ $student->section ?? 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Contact Number:</span>
                            <span class="info-value">{{ $student->contact_number ?? 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Emergency Contact:</span>
                            <span class="info-value">
                                {{ $student->emergency_contact_name ?? 'N/A' }}
                                @if($student->emergency_contact_number)
                                    <br><small class="text-muted">{{ $student->emergency_contact_number }}</small>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Latest Medical Information -->
            <div class="col-md-6 mb-4">
                <div class="section-card">
                    <div class="section-header">
                        <h5 class="mb-0"><i class="fas fa-stethoscope me-2"></i>Latest Medical Information</h5>
                    </div>
                    <div class="section-content">
                        @if($latestVitals)
                            <div class="info-item">
                                <span class="info-label">Last Visit:</span>
                                <span class="info-value">{{ $lastVisit->visit_date->format('M j, Y g:i A') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Weight:</span>
                                <span class="info-value">{{ $latestVitals->weight }} kg</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Height:</span>
                                <span class="info-value">{{ $latestVitals->height }} cm</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">BMI:</span>
                                <span class="info-value">
                                    {{ $bmi }}
                                    @if($bmiCategory)
                                        <span class="bmi-indicator bmi-{{ strtolower(str_replace(' ', '', $bmiCategory)) }}">
                                            {{ $bmiCategory }}
                                        </span>
                                    @endif
                                </span>
                            </div>
                            @if($latestVitals->temperature)
                                <div class="info-item">
                                    <span class="info-label">Temperature:</span>
                                    <span class="info-value">{{ $latestVitals->temperature }}°C</span>
                                </div>
                            @endif
                            @if($latestVitals->blood_pressure)
                                <div class="info-item">
                                    <span class="info-label">Blood Pressure:</span>
                                    <span class="info-value">{{ $latestVitals->blood_pressure }}</span>
                                </div>
                            @endif
                            @if($latestVitals->heart_rate)
                                <div class="info-item">
                                    <span class="info-label">Heart Rate:</span>
                                    <span class="info-value">{{ $latestVitals->heart_rate }} bpm</span>
                                </div>
                            @endif
                            @if($latestVitals->respiratory_rate)
                                <div class="info-item">
                                    <span class="info-label">Respiratory Rate:</span>
                                    <span class="info-value">{{ $latestVitals->respiratory_rate }} /min</span>
                                </div>
                            @endif
                        @else
                            <p class="text-muted text-center">No medical records available</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Known Allergies -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="section-card">
                    <div class="section-header">
                        <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Known Allergies</h5>
                    </div>
                    <div class="section-content">
                        @if($allergies->count() > 0)
                            @foreach($allergies as $allergy)
                                <span class="allergy-badge allergy-{{ strtolower($allergy->severity) }}">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    {{ $allergy->allergy_name }}
                                    <small>({{ $allergy->severity }})</small>
                                </span>
                            @endforeach
                        @else
                            <p class="text-muted text-center">No known allergies recorded</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Immunization Records -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="section-card">
                    <div class="section-header">
                        <h5 class="mb-0"><i class="fas fa-syringe me-2"></i>Immunization Records</h5>
                    </div>
                    <div class="section-content">
                        @if($immunizations->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Vaccine</th>
                                            <th>Date Administered</th>
                                            <th>Administered By</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($immunizations as $immunization)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-shield-alt text-success me-2"></i>
                                                        <strong>{{ $immunization->vaccine_name }}</strong>
                                                    </div>
                                                </td>
                                                <td>{{ $immunization->date_administered ? $immunization->date_administered->format('M j, Y') : 'N/A' }}</td>
                                                <td>{{ $immunization->administered_by ?? 'N/A' }}</td>
                                                <td>{{ $immunization->notes ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted text-center">No immunization records available</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Medical Visits -->
        <div class="row">
            <div class="col-12">
                <div class="section-card">
                    <div class="section-header">
                        <h5 class="mb-0"><i class="fas fa-history me-2"></i>Recent Medical Visits</h5>
                    </div>
                    <div class="section-content">
                        @if($recentVisits->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Visit Date</th>
                                            <th>Type</th>
                                            <th>Chief Complaint</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentVisits as $visit)
                                            <tr>
                                                <td>
                                                    <div>{{ $visit->visit_date->format('M j, Y') }}</div>
                                                    <small class="text-muted">{{ $visit->visit_date->format('g:i A') }}</small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">Clinic Visit</span>
                                                </td>
                                                <td>{{ $visit->reason_for_visit ?? 'N/A' }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $visit->status === 'pending' ? 'warning' : ($visit->status === 'completed' ? 'success' : 'secondary') }}">
                                                        {{ ucfirst($visit->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted text-center">No recent medical visits</p>
                        @endif
                    </div>
>>>>>>> ba9aaa71bc9abfb6ff0b899eb0b1e7a9be6803ee
                </div>
            </div>
        </div>
    </div>
<<<<<<< HEAD
</div>
@endsection
=======

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
>>>>>>> ba9aaa71bc9abfb6ff0b899eb0b1e7a9be6803ee
