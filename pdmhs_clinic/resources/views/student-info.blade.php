<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Student Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:wght@400;500;600;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        
        .navbar-brand {
            font-weight: 600;
        }
        
        .navbar-nav .nav-link {
            font-family: 'Epilogue', sans-serif !important;
            font-size: 20px !important;
            font-weight: 600 !important;
        }
        
        .page-container {
            max-width: 900px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        
        .page-title {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 700;
            font-size: 1.8rem;
            color: #2c3e50;
            margin: 0;
        }
        
        .read-only-badge {
            background-color: #6c757d;
            color: white;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
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
            font-weight: 700;
            font-size: 1.3rem;
            color: #2c3e50;
            margin: 0;
        }
        
        .edit-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
        }
        
        .edit-btn:hover {
            background-color: #0056b3;
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
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
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
                    <i class="fas fa-home me-1"></i>Dashboard
                </a>
                <a class="nav-link" href="{{ route('student.medical') }}">
                    <i class="fas fa-file-medical me-1"></i>My Medical
                </a>
            </div>
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user me-1"></i>
                        {{ $user->name }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('student.profile') }}"><i class="fas fa-user-edit me-2"></i>Edit Profile</a></li>
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
                        <input type="text" class="form-control" value="{{ $user->name ?? 'Hannah Lorraine Geronday' }}" readonly>
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>