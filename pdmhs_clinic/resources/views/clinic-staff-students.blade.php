<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Student Records - PDMHS Clinic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --secondary: #06b6d4;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            --light: #f3f4f6;
            --dark: #1f2937;
            --gradient: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--gradient);
            min-height: 100vh;
            padding-bottom: 2rem;
        }

        /* Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .navbar-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            font-family: 'Albert Sans', sans-serif;
            font-size: 20px;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar-menu {
            display: flex;
            gap: 2rem;
            align-items: center;
            list-style: none;
        }

        .nav-link {
            font-family: 'Albert Sans', sans-serif;
            font-size: 20px;
            font-weight: 700;
            color: var(--dark);
            text-decoration: none;
            transition: all 0.3s ease;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-link:hover, .nav-link.active {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
        }

        .user-dropdown {
            position: relative;
        }

        .user-btn {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            background: white;
            border: 2px solid var(--light);
            border-radius: 2rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .user-btn:hover {
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary);
        }

        .user-avatar-default {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .dropdown-menu {
            position: absolute;
            top: 120%;
            right: 0;
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            min-width: 200px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        .dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            padding: 0.75rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--dark);
            text-decoration: none;
            transition: all 0.2s ease;
            border-bottom: 1px solid var(--light);
        }

        .dropdown-item:last-child {
            border-bottom: none;
        }

        .dropdown-item:hover {
            background: var(--light);
        }

        /* Main Container */
        .container {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        
        .page-header {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(220, 220, 250, 0.95) 100%);
            backdrop-filter: blur(10px);
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
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(220, 220, 250, 0.95) 100%);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .students-table {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(220, 220, 250, 0.95) 100%);
            backdrop-filter: blur(10px);
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
            background-color: #4f46e5;
            border-color: #4f46e5;
            color: white;
        }
        
        .btn-view:hover {
            background-color: #4338ca;
            border-color: #4338ca;
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

    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a class="navbar-brand" href="{{ route('clinic-staff.dashboard') }}">
                <i class="fas fa-heartbeat"></i>
                PDMHS Clinic
            </a>
            <ul class="navbar-menu">
                <li><a class="nav-link" href="{{ route('clinic-staff.dashboard') }}"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
                <li><a class="nav-link active" href="{{ route('clinic-staff.students') }}"><i class="fas fa-users"></i>Students</a></li>
                <li><a class="nav-link" href="{{ route('clinic-staff.visits') }}"><i class="fas fa-calendar-check"></i>Visits</a></li>
                <li><a class="nav-link" href="{{ route('scanner') }}"><i class="fas fa-qrcode"></i>Scanner</a></li>
                <li><a class="nav-link" href="{{ route('clinic-staff.reports') }}"><i class="fas fa-chart-bar"></i>Reports</a></li>
            </ul>
            <div class="user-dropdown">
                <button class="user-btn" onclick="toggleDropdown()">
                    @if($user->profile_picture && file_exists(public_path($user->profile_picture)))
                        <img src="{{ asset($user->profile_picture) }}" alt="Profile" class="user-avatar">
                    @else
                        <div class="user-avatar-default">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif
                    <span>{{ $user->name }}</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="dropdown-menu" id="userDropdown">
                    <a class="dropdown-item" href="{{ route('clinic-staff.profile') }}">
                        <i class="fas fa-user-edit"></i>
                        Profile
                    </a>
                    <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hidden logout form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

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
            // Redirect to create visit form for this student
            window.location.href = `/clinic-staff/students/${id}/visit`;
        }

        // Dropdown toggle
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('show');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('userDropdown');
            const userBtn = document.querySelector('.user-btn');
            if (!userBtn.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });

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
