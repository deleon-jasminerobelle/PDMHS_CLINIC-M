<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Student Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1e40af;
            --primary-dark: #1e3a8a;
            --secondary: #3b82f6;
            --gradient: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        }
        
        .navbar.bg-primary {
            background: var(--gradient) !important;
            padding: 1rem 0 !important;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        
        .navbar-brand {
            font-weight: 600;
        }
        
        .navbar-nav .nav-link {
            font-family: 'Epilogue', sans-serif !important;
            font-size: 25px !important;
            font-weight: 600 !important;
        }
        
        .page-container {
            max-width: 900px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        
        .main-container {
            max-width: 900px;
            margin: 0 auto;
        }
        
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        
        .page-title {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 800;
            font-size: 25px;
            color: #2c3e50;
            margin: 0;
        }
        
        .back-btn {
            background: var(--gradient);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: opacity 0.2s ease;
        }
        
        .back-btn:hover {
            opacity: 0.9;
            color: white;
            text-decoration: none;
        }
        
        .read-only-badge {
            background: var(--gradient);
            color: white;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-family: 'Albert Sans', sans-serif;
            font-size: 20px;
            font-weight: 700;
        }
        
        .info-section {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .section-title {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 800;
            font-size: 25px;
            color: #2c3e50;
            margin: 0;
        }
        
        .edit-btn {
            background: var(--gradient);
            color: white;
            border: none;
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-family: 'Albert Sans', sans-serif;
            font-size: 20px;
            font-weight: 700;
            cursor: pointer;
        }
        
        .edit-btn:hover {
            opacity: 0.9;
        }
        
        .form-row {
            display: flex;
            gap: 2rem;
            margin-bottom: 1.5rem;
        }
        
        .form-group {
            flex: 1;
        }
        
        .form-label {
            font-family: 'Albert Sans', sans-serif;
            font-size: 15px;
            font-weight: 500;
            color: #000000;
            margin-bottom: 0.5rem;
        }
        
        .table th,
        .table td {
            font-family: 'Albert Sans', sans-serif;
            font-size: 15px;
            color: #000000;
            vertical-align: middle;
        }
        
        .table th {
            font-weight: 600;
            background-color: #f8f9fa;
        }
        
        .table td {
            font-weight: 400;
        }
        
        .form-control {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 0.75rem;
            font-size: 0.95rem;
            background-color: #f8f9fa;
        }
        
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
            background-color: white;
        }
        
        .form-control[readonly] {
            background-color: #f8f9fa;
            color: #6c757d;
        }
        
        .textarea-large {
            min-height: 100px;
            resize: vertical;
        }
        
        .form-check-label {
            font-family: 'Albert Sans', sans-serif;
            font-size: 15px;
            font-weight: 500;
            color: #000000;
        }
        
        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
                gap: 1rem;
            }
            
            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('student.dashboard') }}">
            </a>
            <div class="navbar-nav me-auto">
                <a class="nav-link" href="{{ route('student.dashboard') }}">
                    Dashboard
                </a>
                <a class="nav-link" href="{{ route('student.medical') }}">
                    My Medical
                </a>
            </div>
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user me-1"></i>
                        {{ $user->name }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('student.profile') }}"><i class="fas fa-user-edit me-2"></i>Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="page-container">
        <!-- Back Button -->
        <div class="mb-3">
            <a href="{{ route('student.medical') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i>
                Back to Medical Records
            </a>
        </div>

        <!-- Main Container -->
        <div class="main-container">
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">Student Information</h1>
                <span class="read-only-badge">Read Only</span>
            </div>

        <!-- Student Information Section -->
        <div class="info-section">
            <form>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Name of Learner</label>
                        <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label class="form-label">LRN</label>
                        <input type="text" class="form-control" value="{{ $student->lrn ?? '000001' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label class="form-label">School</label>
                        <input type="text" class="form-control" value="Don Dada High School" readonly>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Grade Level & Section</label>
                        <input type="text" class="form-control" value="{{ $student->grade_level ?? '12 - STEM-1' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Birthday</label>
                        <input type="text" class="form-control" value="{{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('m/d/Y') : '04/01/2005' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Sex/Age</label>
                        <input type="text" class="form-control" value="{{ $student->gender ?? 'F' }}/{{ $age ?? '20' }}" readonly>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Adviser</label>
                        <input type="text" class="form-control" value="{{ $adviser->name ?? 'Ms. Rea Loloy' }}" readonly>
                    </div>
                </div>
            </form>
        </div>

        <!-- Contact Information Section -->
        <div class="info-section">
            <div class="section-header">
                <h2 class="section-title">Contact Information</h2>
                <button class="edit-btn" onclick="alert('Edit functionality coming soon!')">Edit</button>
            </div>
            
            <form>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Contact Person in Case of Emergency</label>
                        <input type="text" class="form-control" value="{{ $student->emergency_contact ?? 'Parent: 09123456789' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Relation</label>
                        <input type="text" class="form-control" value="e.g., Mother, Father, Guardian" readonly>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Address</label>
                        <textarea class="form-control textarea-large" readonly>{{ $student->address ?? 'Test Address Update' }}</textarea>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Phone No.</label>
                        <input type="text" class="form-control" placeholder="Enter phone number" readonly>
                    </div>
                </div>
            </form>
        </div>

        <!-- Medical History Section -->
        <div class="info-section">
            <div class="section-header">
                <h2 class="section-title">Medical History (For Learners)</h2>
                <span class="read-only-badge">Read Only</span>
            </div>
            
            <form>
                <div class="mb-4">
                    <label class="form-label fw-bold">1. Does your child have any allergies?</label>
                    
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label class="form-label">Medicine</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="medicine_allergy" id="medicine_yes" disabled>
                                    <label class="form-check-label" for="medicine_yes">Yes</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="medicine_allergy" id="medicine_no" checked disabled>
                                    <label class="form-check-label" for="medicine_no">No</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <label class="form-label">Pollen</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="pollen_allergy" id="pollen_yes" disabled>
                                    <label class="form-check-label" for="pollen_yes">Yes</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="pollen_allergy" id="pollen_no" checked disabled>
                                    <label class="form-check-label" for="pollen_no">No</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <label class="form-label">Food</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="food_allergy" id="food_yes" checked disabled>
                                    <label class="form-check-label" for="food_yes">Yes</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="food_allergy" id="food_no" disabled>
                                    <label class="form-check-label" for="food_no">No</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <label class="form-label">Stinging Insects</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="insects_allergy" id="insects_yes" disabled>
                                    <label class="form-check-label" for="insects_yes">Yes</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="insects_allergy" id="insects_no" checked disabled>
                                    <label class="form-check-label" for="insects_no">No</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <label class="form-label fw-bold">Known Allergies:</label>
                        <div class="d-flex gap-2 mt-2">
                            <span class="badge bg-danger fs-6 px-3 py-2">Peanuts</span>
                            <span class="badge bg-warning text-dark fs-6 px-3 py-2">Shellfish</span>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">2. Does your child have any ongoing medical condition?</label>
                    
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="refractive_error" disabled>
                                <label class="form-check-label" for="refractive_error">Error of refraction (Wearing Corrective Lenses)</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="anemia" disabled>
                                <label class="form-check-label" for="anemia">Anemia</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="heart_problem" disabled>
                                <label class="form-check-label" for="heart_problem">Heart problem</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="anxiety_depression" disabled>
                                <label class="form-check-label" for="anxiety_depression">Anxiety/Depression</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="bleeding_disorder" disabled>
                                <label class="form-check-label" for="bleeding_disorder">Bleeding disorder (nose, etc.)</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="seizure" disabled>
                                <label class="form-check-label" for="seizure">Seizure</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="hernia" disabled>
                                <label class="form-check-label" for="hernia">Hernia (pagdol bulge in the groin area)</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="asthma" disabled>
                                <label class="form-check-label" for="asthma">Asthma</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">3. Does your child have ever had surgery/hospitalization?</label>
                    <div class="d-flex gap-3 mt-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="surgery_history" id="surgery_yes" disabled>
                            <label class="form-check-label" for="surgery_yes">Yes</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="surgery_history" id="surgery_no" checked disabled>
                            <label class="form-check-label" for="surgery_no">No</label>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h5 class="section-title mb-3">Family History</h5>
                    <label class="form-label fw-bold">4. Does anyone in your family have the following conditions:</label>
                    
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="family_tuberculosis" disabled>
                                <label class="form-check-label" for="family_tuberculosis">Tuberculosis</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="family_depression" disabled>
                                <label class="form-check-label" for="family_depression">Depression</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="family_cancer" disabled>
                                <label class="form-check-label" for="family_cancer">Cancer</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="family_thyroid" disabled>
                                <label class="form-check-label" for="family_thyroid">Thyroid Problem</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="family_stroke" disabled>
                                <label class="form-check-label" for="family_stroke">Stroke/Cardiac Problem</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="family_phobia" disabled>
                                <label class="form-check-label" for="family_phobia">Phobia</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="family_diabetes" disabled>
                                <label class="form-check-label" for="family_diabetes">Diabetes Mellitus</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="family_hypertension" disabled>
                                <label class="form-check-label" for="family_hypertension">Hypertension</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">5. Exposure to cigarette/vape smoke at home?</label>
                    <div class="d-flex gap-3 mt-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="smoke_exposure" id="smoke_yes" disabled>
                            <label class="form-check-label" for="smoke_yes">Yes</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="smoke_exposure" id="smoke_no" checked disabled>
                            <label class="form-check-label" for="smoke_no">No</label>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Vaccination History Section -->
        <div class="info-section">
            <div class="section-header">
                <h2 class="section-title">Vaccination History (Dates of Immunization)</h2>
                <span class="read-only-badge">Read Only</span>
            </div>
            
            <form>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 25%;">Vaccine</th>
                                <th style="width: 15%;">Given (Yes/No)</th>
                                <th style="width: 20%;">Date Given</th>
                                <th style="width: 40%;">Given By (Family/Health Center)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>DPT (Diphtheria Pertussis)</td>
                                <td class="text-center">✓</td>
                                <td>3-24-12</td>
                                <td>Health Center</td>
                            </tr>
                            <tr>
                                <td>OPV (Oral polio Vaccine)</td>
                                <td class="text-center">✓</td>
                                <td>3-24-12</td>
                                <td>Health Center</td>
                            </tr>
                            <tr>
                                <td>BCG (TB Vaccine)</td>
                                <td class="text-center">✓</td>
                                <td>6-18-13</td>
                                <td>Health Center</td>
                            </tr>
                            <tr>
                                <td>MMR (Measles Mumps Rubella)</td>
                                <td class="text-center">✓</td>
                                <td>-</td>
                                <td>Health Center</td>
                            </tr>
                            <tr>
                                <td>Chicken pox Vaccine</td>
                                <td class="text-center">-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>Hepa B</td>
                                <td class="text-center">✓</td>
                                <td>4-6-12</td>
                                <td>Health Center</td>
                            </tr>
                            <tr>
                                <td>Tetanus</td>
                                <td class="text-center">-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>Flu Vaccine</td>
                                <td class="text-center">-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>Pneumococcal Vaccine</td>
                                <td class="text-center">-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>MR-TD Vaccine</td>
                                <td class="text-center">-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>Cervical Vaccine</td>
                                <td class="text-center">-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>Covid Vaccine</td>
                                <td class="text-center">✓</td>
                                <td>-</td>
                                <td>Health Center</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>

        <!-- Emergency Medication Protocol Section -->
        <div class="info-section">
            <div class="section-header">
                <h2 class="section-title">Emergency Medication Protocol</h2>
                <span class="read-only-badge">Read Only</span>
            </div>
            
            <form>
                <div class="mb-4">
                    <label class="form-label fw-bold">If in case your child develops fever, pain, allergic he/she will be given:</label>
                    
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="paracetamol" checked disabled>
                                <label class="form-check-label" for="paracetamol">Paracetamol</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="mefenamic" disabled>
                                <label class="form-check-label" for="mefenamic">Mefenamic</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="antihistamine" disabled>
                                <label class="form-check-label" for="antihistamine">Antihistamine</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="amoxil" disabled>
                                <label class="form-check-label" for="amoxil">Amoxil</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="loperamide" disabled>
                                <label class="form-check-label" for="loperamide">Loperamide</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="nothing" disabled>
                                <label class="form-check-label" for="nothing">Nothing</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="others_specify" disabled>
                                <label class="form-check-label" for="others_specify">Others, specify</label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
        </div> <!-- End Main Container -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>