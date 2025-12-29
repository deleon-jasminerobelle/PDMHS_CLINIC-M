<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Student Records - PDMHS Clinic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:wght@400;500;600;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
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

        .navbar-nav .nav-link {
            font-family: 'Epilogue', sans-serif !important;
            font-size: 25px !important;
            font-weight: 600 !important;
        }

        .navbar-nav .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
        }
        
        .page-header {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .page-title {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 800;
            font-size: 32px;
            margin-bottom: 0.5rem;
        }
        
        .page-subtitle {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 500;
            font-size: 16px;
            color: #6c757d;
            margin-bottom: 0;
        }
        
        .search-filters {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .students-table {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .table th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-family: 'Albert Sans', sans-serif;
            font-weight: 600;
            font-size: 14px;
            color: #495057;
            padding: 1rem;
        }
        
        .table td {
            padding: 1rem;
            vertical-align: middle;
            font-family: 'Albert Sans', sans-serif;
            font-size: 14px;
        }
        
        .student-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            margin-right: 12px;
        }
        
        .student-name {
            font-weight: 600;
            color: #212529;
        }
        
        .badge-allergy {
            background-color: #28a745;
            color: white;
            font-size: 12px;
            padding: 4px 8px;
            border-radius: 6px;
        }
        
        .badge-allergy.has-allergy {
            background-color: #ffc107;
            color: #212529;
        }
        
        .btn-action {
            padding: 6px 12px;
            font-size: 12px;
            border-radius: 6px;
            margin: 0 2px;
        }
        
        .btn-view {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
        }
        
        .btn-visit {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
        }
        
        .filter-controls {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .search-input {
            flex: 1;
            min-width: 300px;
        }
        
        .dropdown-menu .dropdown-item {
            font-family: 'Epilogue', sans-serif !important;
            font-size: 20px !important;
            font-weight: 500 !important;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('clinic-staff.dashboard') }}">
              
            </a>
            <div class="navbar-nav me-auto">
                <a class="nav-link" href="{{ route('clinic-staff.dashboard') }}">
                    <i></i>Dashboard
                </a>
                <a class="nav-link active" href="{{ route('clinic-staff.students') }}">
                    <i ></i>Students
                </a>
                <a class="nav-link" href="{{ route('clinic-staff.visits') }}">
                    <i></i>Visits
                </a>
                <a class="nav-link" href="{{ route('clinic-staff.reports') }}">
                    Reports
                </a>
            </div>
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user me-1"></i>
                        {{ $user->name }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('clinic-staff.profile') }}"><i class="fas fa-user-cog me-2"></i>Profile</a></li>
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

    <div class="container mt-4">
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Error!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Student Records</h1>
            <p class="page-subtitle">Search and manage student medical records</p>
        </div>

        <!-- Search and Filters -->
        <div class="search-filters">
            <div class="filter-controls">
                <div class="search-input">
                    <input type="text" class="form-control" id="searchInput" placeholder="Search by name or student number">
                </div>
                <select class="form-select" id="gradeFilter" style="width: auto;">
                    <option value="">All Grades</option>
                    <option value="Grade 7">Grade 7</option>
                    <option value="Grade 8">Grade 8</option>
                    <option value="Grade 9">Grade 9</option>
                    <option value="Grade 10">Grade 10</option>
                    <option value="Grade 11">Grade 11</option>
                    <option value="Grade 12">Grade 12</option>
                </select>
                <select class="form-select" id="allergyFilter" style="width: auto;">
                    <option value="">All Sections</option>
                    <option value="yes">Has Allergies</option>
                    <option value="no">No Allergies</option>
                </select>
            </div>
        </div>

        <!-- Students Table -->
        <div class="students-table">
            <div class="table-responsive">
                <table class="table" id="studentsTable">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Student Number</th>
                            <th>Grade & Section</th>
                            <th>Last Visit</th>
                            <th>Allergies</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="student-avatar">
                                        {{ strtoupper(substr($student->first_name, 0, 1)) }}
                                    </div>
                                    <div class="student-name">
                                        {{ $student->first_name }} {{ $student->last_name }}
                                    </div>
                                </div>
                            </td>
                            <td>{{ $student->formatted_student_number }}</td>
                            <td>{{ $student->formatted_grade_section }}</td>
                            <td>{{ $student->last_visit_date }}</td>
                            <td>
                                <span class="badge-allergy {{ $student->has_allergies ? 'has-allergy' : '' }}">
                                    {{ $student->allergy_status }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-action btn-view" onclick="viewStudent({{ $student->id }})">
                                    View Profile
                                </button>
                                <button class="btn btn-action btn-visit" onclick="addVisit({{ $student->id }})">
                                    New Visit
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No students found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Student count info -->
        <div class="mt-3">
            <small class="text-muted">Showing {{ $students->count() }} of {{ $students->count() }} students</small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Search and filter functionality
        document.getElementById('searchInput').addEventListener('input', filterStudents);
        document.getElementById('gradeFilter').addEventListener('change', filterStudents);
        document.getElementById('allergyFilter').addEventListener('change', filterStudents);

        function filterStudents() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const gradeFilter = document.getElementById('gradeFilter').value;
            const allergyFilter = document.getElementById('allergyFilter').value;
            const tableRows = document.querySelectorAll('#studentsTable tbody tr');

            let visibleCount = 0;

            tableRows.forEach(row => {
                const cells = row.querySelectorAll('td');
                if (cells.length === 1) return; // Skip "no records" row

                const studentName = cells[0].textContent.toLowerCase();
                const studentNumber = cells[1].textContent.toLowerCase();
                const gradeSection = cells[2].textContent;
                const allergyStatus = cells[4].textContent.toLowerCase();

                const matchesSearch = studentName.includes(searchTerm) || studentNumber.includes(searchTerm);
                const matchesGrade = !gradeFilter || gradeSection.includes(gradeFilter);
                const matchesAllergy = !allergyFilter || 
                    (allergyFilter === 'yes' && allergyStatus.includes('yes')) ||
                    (allergyFilter === 'no' && allergyStatus.includes('none'));

                if (matchesSearch && matchesGrade && matchesAllergy) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            // Update count display
            const countDisplay = document.querySelector('.mt-3 small');
            if (countDisplay) {
                countDisplay.textContent = `Showing ${visibleCount} of {{ $students->count() }} students`;
            }
        }

        function viewStudent(id) {
            window.location.href = `/clinic-staff/students/${id}`;
        }

        function addVisit(id) {
            // For now, just redirect to student profile where they can add a visit
            window.location.href = `/clinic-staff/students/${id}`;
        }

        // Auto-dismiss alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>
</body>
</html>