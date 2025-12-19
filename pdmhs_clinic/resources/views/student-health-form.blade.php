<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Student's Health Record</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-2xl font-bold text-sky-700 mb-6 text-center">STUDENT'S HEALTH RECORD</h1>

            <form action="{{ isset($student) ? route('student.profile.update') : route('health-form.store') }}" method="POST" id="healthForm">
                @csrf
                @if(isset($student))
                    @method('PUT')
                @endif

                {{-- Basic Information --}}
                <div class="bg-sky-50 p-6 rounded-lg mb-6">
                    <h2 class="text-lg font-semibold text-sky-800 mb-4">Student Information</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                            <input type="text" name="name" value="{{ isset($student) ? $student->first_name . ' ' . $student->last_name : old('name') }}" required class="w-full px-3 py-2 border border-sky-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">LRN</label>
                            <input type="text" name="lrn" value="{{ isset($student) ? $student->student_id : old('lrn') }}" required class="w-full px-3 py-2 border border-sky-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">School</label>
                            <input type="text" name="school" value="{{ isset($student) ? $student->school : old('school') }}" required class="w-full px-3 py-2 border border-sky-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Grade Level & Section</label>
                            <input type="text" name="grade_section" value="{{ isset($student) ? $student->grade_level . ' ' . $student->section : old('grade_section') }}" required class="w-full px-3 py-2 border border-sky-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Birthday</label>
                            <input type="date" name="birthday" value="{{ isset($student) ? $student->date_of_birth->format('Y-m-d') : old('birthday') }}" required class="w-full px-3 py-2 border border-sky-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sex/Age</label>
                            <div class="flex gap-2">
                                <select name="sex" required class="flex-1 px-3 py-2 border border-sky-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500">
                                    <option value="">Select</option>
                                    <option value="M" {{ isset($student) && $student->sex == 'M' ? 'selected' : '' }}>Male</option>
                                    <option value="F" {{ isset($student) && $student->sex == 'F' ? 'selected' : '' }}>Female</option>
                                </select>
                                <input type="number" name="age" placeholder="Age" value="{{ isset($student) ? $student->age : old('age') }}" required class="w-20 px-3 py-2 border border-sky-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Adviser</label>
                            <input type="text" name="adviser" value="{{ isset($student) ? $student->adviser : old('adviser') }}" class="w-full px-3 py-2 border border-sky-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Blood Type</label>
                            <select name="blood_type" class="w-full px-3 py-2 border border-sky-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500">
                                <option value="">Select</option>
                                <option value="A+" {{ isset($student) && $student->blood_type == 'A+' ? 'selected' : '' }}>A+</option>
                                <option value="A-" {{ isset($student) && $student->blood_type == 'A-' ? 'selected' : '' }}>A-</option>
                                <option value="B+" {{ isset($student) && $student->blood_type == 'B+' ? 'selected' : '' }}>B+</option>
                                <option value="B-" {{ isset($student) && $student->blood_type == 'B-' ? 'selected' : '' }}>B-</option>
                                <option value="AB+" {{ isset($student) && $student->blood_type == 'AB+' ? 'selected' : '' }}>AB+</option>
                                <option value="AB-" {{ isset($student) && $student->blood_type == 'AB-' ? 'selected' : '' }}>AB-</option>
                                <option value="O+" {{ isset($student) && $student->blood_type == 'O+' ? 'selected' : '' }}>O+</option>
                                <option value="O-" {{ isset($student) && $student->blood_type == 'O-' ? 'selected' : '' }}>O-</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Height (cm)</label>
                            <input type="number" name="height" step="0.1" value="{{ isset($student) ? $student->height : old('height') }}" class="w-full px-3 py-2 border border-sky-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Weight (kg)</label>
                            <input type="number" name="weight" step="0.1" value="{{ isset($student) ? $student->weight : old('weight') }}" class="w-full px-3 py-2 border border-sky-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Temperature (°C)</label>
                            <input type="number" name="temperature" step="0.1" value="{{ isset($student) ? $student->temperature : old('temperature') }}" class="w-full px-3 py-2 border border-sky-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Blood Pressure</label>
                            <input type="text" name="blood_pressure" placeholder="e.g., 120/80" value="{{ isset($student) ? $student->blood_pressure : old('blood_pressure') }}" class="w-full px-3 py-2 border border-sky-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500">
                        </div>
                    </div>
                </div>

                {{-- Medical History --}}
                <div class="bg-sky-50 p-6 rounded-lg mb-6">
                    <h2 class="text-lg font-semibold text-sky-800 mb-4">Medical History (For Learners)</h2>

                    <div class="space-y-4">
                        <div>
                            <p class="font-medium text-gray-700 mb-2">1. Does your child have any allergies?</p>
                            <div class="flex gap-4 mb-2">
                                <label class="flex items-center">
                                    <input type="radio" name="has_allergies" value="1" {{ isset($student) && $student->has_allergies == '1' ? 'checked' : '' }} class="mr-2 text-sky-600">
                                    <span>Yes</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="has_allergies" value="0" {{ isset($student) && $student->has_allergies == '0' ? 'checked' : '' }} class="mr-2 text-sky-600">
                                    <span>No</span>
                                </label>
                            </div>
                            <div id="allergiesDiv" class="grid grid-cols-2 md:grid-cols-4 gap-2 ml-6 {{ isset($student) && $student->has_allergies == '1' ? '' : 'hidden' }}">
                                @php
                                $allergies = isset($student) ? json_decode($student->allergies, true) ?? [] : [];
                                @endphp
                                <label class="flex items-center">
                                    <input type="checkbox" name="allergies[]" value="Medicine" {{ in_array('Medicine', $allergies) ? 'checked' : '' }} class="mr-2 text-sky-600">
                                    <span class="text-sm">Medicine</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="allergies[]" value="Others" {{ in_array('Others', $allergies) ? 'checked' : '' }} class="mr-2 text-sky-600">
                                    <span class="text-sm">Others</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="allergies[]" value="Food" {{ in_array('Food', $allergies) ? 'checked' : '' }} class="mr-2 text-sky-600">
                                    <span class="text-sm">Food</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="allergies[]" value="Stinging Insects" {{ in_array('Stinging Insects', $allergies) ? 'checked' : '' }} class="mr-2 text-sky-600">
                                    <span class="text-sm">Stinging Insects</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="allergies[]" value="Rhinitis/Sinusitis" {{ in_array('Rhinitis/Sinusitis', $allergies) ? 'checked' : '' }} class="mr-2 text-sky-600">
                                    <span class="text-sm">Rhinitis/Sinusitis</span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <p class="font-medium text-gray-700 mb-2">2. Does your child have any ongoing medical condition?</p>
                            <div class="flex gap-4 mb-2">
                                <label class="flex items-center">
                                    <input type="radio" name="has_medical_condition" value="1" {{ isset($student) && $student->has_medical_condition == '1' ? 'checked' : '' }} class="mr-2 text-sky-600">
                                    <span>Yes</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="has_medical_condition" value="0" {{ isset($student) && $student->has_medical_condition == '0' ? 'checked' : '' }} class="mr-2 text-sky-600">
                                    <span>No</span>
                                </label>
                            </div>
                            <div id="medicalConditionsDiv" class="grid grid-cols-2 gap-2 ml-6 {{ isset($student) && $student->has_medical_condition == '1' ? '' : 'hidden' }}">
                                @php
                                $medicalConditions = isset($student) ? json_decode($student->medical_conditions, true) ?? [] : [];
                                @endphp
                                <label class="flex items-center">
                                    <input type="checkbox" name="medical_conditions[]" value="Error of refraction" {{ in_array('Error of refraction', $medicalConditions) ? 'checked' : '' }} class="mr-2 text-sky-600">
                                    <span class="text-sm">Error of refraction (Wearing Corrective Lenses)</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="medical_conditions[]" value="Asthma" {{ in_array('Asthma', $medicalConditions) ? 'checked' : '' }} class="mr-2 text-sky-600">
                                    <span class="text-sm">Asthma</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="medical_conditions[]" value="Heart problem" {{ in_array('Heart problem', $medicalConditions) ? 'checked' : '' }} class="mr-2 text-sky-600">
                                    <span class="text-sm">Heart problem</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="medical_conditions[]" value="Anemia" {{ in_array('Anemia', $medicalConditions) ? 'checked' : '' }} class="mr-2 text-sky-600">
                                    <span class="text-sm">Anemia</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="medical_conditions[]" value="Eating disorder" {{ in_array('Eating disorder', $medicalConditions) ? 'checked' : '' }} class="mr-2 text-sky-600">
                                    <span class="text-sm">Eating disorder (nose, etc.)</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="medical_conditions[]" value="Anxiety/Depression" {{ in_array('Anxiety/Depression', $medicalConditions) ? 'checked' : '' }} class="mr-2 text-sky-600">
                                    <span class="text-sm">Anxiety/Depression</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="medical_conditions[]" value="Hernia" {{ in_array('Hernia', $medicalConditions) ? 'checked' : '' }} class="mr-2 text-sky-600">
                                    <span class="text-sm">Hernia (painful bulge in the groin area)</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="medical_conditions[]" value="Seizure" {{ in_array('Seizure', $medicalConditions) ? 'checked' : '' }} class="mr-2 text-sky-600">
                                    <span class="text-sm">Seizure</span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <p class="font-medium text-gray-700 mb-2">3. Does your child have ever had surgery/ hospitalization?</p>
                            <div class="flex gap-4 mb-2">
                                <label class="flex items-center">
                                    <input type="radio" name="has_surgery" value="1" {{ isset($student) && $student->has_surgery == '1' ? 'checked' : '' }} class="mr-2 text-sky-600">
                                    <span>Yes</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="has_surgery" value="0" {{ isset($student) && $student->has_surgery == '0' ? 'checked' : '' }} class="mr-2 text-sky-600">
                                    <span>No</span>
                                </label>
                            </div>
                            <div id="surgeryDiv" class="ml-6 {{ isset($student) && $student->has_surgery == '1' ? '' : 'hidden' }}">
                                <input type="text" name="surgery_details" value="{{ isset($student) ? $student->surgery_details : old('surgery_details') }}" placeholder="If yes, please identify" class="w-full px-3 py-2 border border-sky-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Family History --}}
                <div class="bg-sky-50 p-6 rounded-lg mb-6">
                    <h2 class="text-lg font-semibold text-sky-800 mb-4">Family History</h2>
                    <p class="font-medium text-gray-700 mb-3">4. Does anyone in your family have the following conditions:</p>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                        @php
                        $familyHistory = isset($student) ? json_decode($student->family_history, true) ?? [] : [];
                        @endphp
                        <label class="flex items-center">
                            <input type="checkbox" name="family_history[]" value="Tuberculosis" {{ in_array('Tuberculosis', $familyHistory) ? 'checked' : '' }} class="mr-2 text-sky-600">
                            <span class="text-sm">Tuberculosis</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="family_history[]" value="Cancer" {{ in_array('Cancer', $familyHistory) ? 'checked' : '' }} class="mr-2 text-sky-600">
                            <span class="text-sm">Cancer (if yes, what kind?)</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="family_history[]" value="Stroke/Cardiac Problem" {{ in_array('Stroke/Cardiac Problem', $familyHistory) ? 'checked' : '' }} class="mr-2 text-sky-600">
                            <span class="text-sm">Stroke/Cardiac Problem</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="family_history[]" value="Diabetes Mellitus" {{ in_array('Diabetes Mellitus', $familyHistory) ? 'checked' : '' }} class="mr-2 text-sky-600">
                            <span class="text-sm">Diabetes Mellitus</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="family_history[]" value="Hypertension" {{ in_array('Hypertension', $familyHistory) ? 'checked' : '' }} class="mr-2 text-sky-600">
                            <span class="text-sm">Hypertension</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="family_history[]" value="Depression" {{ in_array('Depression', $familyHistory) ? 'checked' : '' }} class="mr-2 text-sky-600">
                            <span class="text-sm">Depression</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="family_history[]" value="Thyroid Problem" {{ in_array('Thyroid Problem', $familyHistory) ? 'checked' : '' }} class="mr-2 text-sky-600">
                            <span class="text-sm">Thyroid Problem</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="family_history[]" value="Phobia" {{ in_array('Phobia', $familyHistory) ? 'checked' : '' }} class="mr-2 text-sky-600">
                            <span class="text-sm">Phobia (what kind?)</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="family_history[]" value="Others" {{ in_array('Others', $familyHistory) ? 'checked' : '' }} class="mr-2 text-sky-600">
                            <span class="text-sm">Others</span>
                        </label>
                    </div>

                    <div class="mt-4">
                        <p class="font-medium text-gray-700 mb-2">5. Exposure to cigarette/vape smoke at home?</p>
                        <div class="flex gap-4">
                            <label class="flex items-center">
                                <input type="radio" name="smoke_exposure" value="1" {{ isset($student) && $student->smoke_exposure == '1' ? 'checked' : '' }} class="mr-2 text-sky-600">
                                <span>Yes</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="smoke_exposure" value="0" {{ isset($student) && $student->smoke_exposure == '0' ? 'checked' : '' }} class="mr-2 text-sky-600">
                                <span>No</span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Vaccination History --}}
                <div class="bg-sky-50 p-6 rounded-lg mb-6">
                    <h2 class="text-lg font-semibold text-sky-800 mb-4">Vaccination History</h2>

                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse border border-sky-300">
                            <thead>
                                <tr class="bg-sky-100">
                                    <th class="border border-sky-300 px-3 py-2 text-left">Vaccine</th>
                                    <th class="border border-sky-300 px-3 py-2">Given YES</th>
                                    <th class="border border-sky-300 px-3 py-2">Given NO</th>
                                    <th class="border border-sky-300 px-3 py-2">Date Given</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $vaccines = [
                                    'DP (Diptheria Pertussis)',
                                    'MMR (Measles, Mumps, Rubella)',
                                    'BCG (TB Vaccine)',
                                    'OPV (Oral Polio Vaccine)',
                                    'Rubella',
                                    'Chicken pox Vaccine',
                                    'Hepa B',
                                    'Tetanus',
                                    'Flu Vaccine',
                                    'Pneumococcal Vaccine',
                                    'MRTD Vaccine',
                                    'Hepa A',
                                    'Covid Vaccine',
                                    'Others'
                                ];
                                @endphp

                                @php
                                $vaccinationHistory = isset($student) ? json_decode($student->vaccination_history, true) ?? [] : [];
                                @endphp
                                @foreach($vaccines as $vaccine)
                                @php
                                $vaccineSlug = Str::slug($vaccine);
                                $vaccineData = $vaccinationHistory[$vaccineSlug] ?? null;
                                @endphp
                                <tr>
                                    <td class="border border-sky-300 px-3 py-2">{{ $vaccine }}</td>
                                    <td class="border border-sky-300 px-3 py-2 text-center">
                                        <input type="radio" name="vaccine_{{ $vaccineSlug }}" value="yes" {{ $vaccineData && $vaccineData['given'] == 'yes' ? 'checked' : '' }} class="text-sky-600">
                                    </td>
                                    <td class="border border-sky-300 px-3 py-2 text-center">
                                        <input type="radio" name="vaccine_{{ $vaccineSlug }}" value="no" {{ $vaccineData && $vaccineData['given'] == 'no' ? 'checked' : '' }} class="text-sky-600">
                                    </td>
                                    <td class="border border-sky-300 px-3 py-2">
                                        <input type="text" name="vaccine_date_{{ $vaccineSlug }}" value="{{ $vaccineData['date'] ?? '' }}" placeholder="Date" class="w-full px-2 py-1 border border-sky-200 rounded focus:outline-none focus:ring-1 focus:ring-sky-500">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Emergency Contact --}}
                <div class="bg-sky-50 p-6 rounded-lg mb-6">
                    <h2 class="text-lg font-semibold text-sky-800 mb-4">Emergency Contact Information</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Contact Person in Case of Emergency</label>
                            <input type="text" name="emergency_contact_name" value="{{ isset($student) ? $student->emergency_contact_name : old('emergency_contact_name') }}" required class="w-full px-3 py-2 border border-sky-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Relation</label>
                            <input type="text" name="emergency_relation" value="{{ isset($student) ? $student->emergency_relation : old('emergency_relation') }}" required class="w-full px-3 py-2 border border-sky-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                            <input type="text" name="emergency_address" value="{{ isset($student) ? $student->emergency_address : old('emergency_address') }}" required class="w-full px-3 py-2 border border-sky-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone No.</label>
                            <input type="text" name="emergency_phone" value="{{ isset($student) ? $student->emergency_phone : old('emergency_phone') }}" required class="w-full px-3 py-2 border border-sky-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500">
                        </div>
                    </div>

                    <div class="mt-4">
                        <p class="font-medium text-gray-700 mb-2">If in case your child develops fever, pain, allergies he/she will be given:</p>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                            @php
                            $medications = isset($student) ? json_decode($student->medications, true) ?? [] : [];
                            @endphp
                            <label class="flex items-center">
                                <input type="checkbox" name="medication[]" value="Paracetamol" {{ in_array('Paracetamol', $medications) ? 'checked' : '' }} class="mr-2 text-sky-600">
                                <span class="text-sm">Paracetamol</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="medication[]" value="Mefenamic" {{ in_array('Mefenamic', $medications) ? 'checked' : '' }} class="mr-2 text-sky-600">
                                <span class="text-sm">Mefenamic</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="medication[]" value="Loperamide" {{ in_array('Loperamide', $medications) ? 'checked' : '' }} class="mr-2 text-sky-600">
                                <span class="text-sm">Loperamide</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="medication[]" value="Antihistamine" {{ in_array('Antihistamine', $medications) ? 'checked' : '' }} class="mr-2 text-sky-600">
                                <span class="text-sm">Antihistamine</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="medication[]" value="Antacid" {{ in_array('Antacid', $medications) ? 'checked' : '' }} class="mr-2 text-sky-600">
                                <span class="text-sm">Antacid</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="medication[]" value="Nothing" {{ in_array('Nothing', $medications) ? 'checked' : '' }} class="mr-2 text-sky-600">
                                <span class="text-sm">Nothing</span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Certification --}}
                <div class="bg-sky-50 p-6 rounded-lg mb-6">
                    <p class="mb-4">I certify that the above information is correct.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Name & Signature of Parent/Guardian</label>
                            <input type="text" name="parent_signature" required class="w-full px-3 py-2 border border-sky-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                            <input type="date" name="signature_date" required class="w-full px-3 py-2 border border-sky-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Relationship to Student</label>
                            <input type="text" name="parent_relationship" required class="w-full px-3 py-2 border border-sky-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
                            <input type="text" name="parent_contact" required class="w-full px-3 py-2 border border-sky-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500">
                        </div>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="flex justify-center">
                    <button type="submit" class="bg-sky-600 hover:bg-sky-700 text-white font-semibold px-8 py-3 rounded-lg transition duration-200 shadow-md">
                        Submit Health Record
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Show/hide conditional fields
        document.querySelectorAll('input[name="has_allergies"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const allergiesDiv = document.getElementById('allergiesDiv');
                if (this.value === '1') {
                    allergiesDiv.classList.remove('hidden');
                } else {
                    allergiesDiv.classList.add('hidden');
                }
            });
        });

        document.querySelectorAll('input[name="has_medical_condition"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const medicalDiv = document.getElementById('medicalConditionsDiv');
                if (this.value === '1') {
                    medicalDiv.classList.remove('hidden');
                } else {
                    medicalDiv.classList.add('hidden');
                }
            });
        });

        document.querySelectorAll('input[name="has_surgery"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const surgeryDiv = document.getElementById('surgeryDiv');
                if (this.value === '1') {
                    surgeryDiv.classList.remove('hidden');
                } else {
                    surgeryDiv.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>
