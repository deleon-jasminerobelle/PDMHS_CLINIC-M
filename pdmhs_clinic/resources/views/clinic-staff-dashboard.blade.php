<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Clinic Staff Dashboard - PDMHS Clinic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

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

        /* Welcome Section */
        .welcome-section {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(220, 220, 250, 0.95) 100%);
            backdrop-filter: blur(10px);
            border-radius: 1.5rem;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 2rem;
            animation: slideDown 0.5s ease;
        }

        .profile-pic-large {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--primary);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .profile-pic-default-large {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
            border: 4px solid white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .welcome-content h1 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .welcome-content p {
            color: #6b7280;
            font-size: 1.1rem;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(220, 220, 250, 0.95) 100%);
            backdrop-filter: blur(10px);
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            animation: fadeInUp 0.5s ease;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .stat-card:hover::before {
            transform: scaleX(1);
        }

        .stat-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.25rem;
        }

        .stat-label {
            color: #6b7280;
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Section Cards */
        .section-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(220, 220, 250, 0.95) 100%);
            backdrop-filter: blur(10px);
            border-radius: 1.5rem;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 0.5s ease;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--light);
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .btn {
            padding: 0.5rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
        }

        /* Alert */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 0.75rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            animation: slideDown 0.3s ease;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border-left: 4px solid var(--success);
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid var(--danger);
        }

        /* Animations */
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar-menu {
                display: none;
            }

            .welcome-section {
                flex-direction: column;
                text-align: center;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
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
                <li><a class="nav-link active" href="{{ route('clinic-staff.dashboard') }}"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
                <li><a class="nav-link" href="{{ route('clinic-staff.students') }}"><i class="fas fa-users"></i>Students</a></li>
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
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hidden logout form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <div class="container">
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <strong>Success!</strong> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-triangle"></i>
                <strong>Error!</strong> {{ session('error') }}
            </div>
        @endif

        <!-- Welcome Section -->
        <div class="welcome-section">
            @if($user->profile_picture && file_exists(public_path($user->profile_picture)))
                <img src="{{ asset($user->profile_picture) }}" alt="Profile Picture" class="profile-pic-large">
            @else
                <div class="profile-pic-default-large">
                    <i class="fas fa-user"></i>
                </div>
            @endif
            <div class="welcome-content">
                <h1>Welcome back, {{ $user->name }}!</h1>
                <p>Here's your clinic overview for today</p>
            </div>
        </div>

        <!-- Health Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-card-header">
                    <div class="stat-icon" style="background: linear-gradient(135deg, var(--primary), var(--secondary));">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $totalStudents }}</div>
                <div class="stat-label">Total Students</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-header">
                    <div class="stat-icon" style="background: linear-gradient(135deg, var(--success), #10b981);">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $todayVisits }}</div>
                <div class="stat-label">Today's Visits</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-header">
                    <div class="stat-icon" style="background: linear-gradient(135deg, var(--warning), #f59e0b);">
                        <i class="fas fa-plus-circle"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $newVisits }}</div>
                <div class="stat-label">New Visits</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-header">
                    <div class="stat-icon" style="background: linear-gradient(135deg, var(--info), #3b82f6);">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $pendingVisits }}</div>
                <div class="stat-label">Pending Visits</div>
            </div>
        </div>

        <!-- Recent Visits and Students with Allergies -->
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="section-card">
                    <div class="section-header">
                        <h5 class="mb-0"><i class="fas fa-history me-2"></i>Recent Visits</h5>
                    </div>
                    <div class="section-content" style="text-align: left; padding: 1rem;">
                        <div class="visit-item mb-3 p-3" style="background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(240, 240, 255, 0.95) 100%); border-radius: 8px; border-left: 4px solid var(--primary); box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                            <div class="d-flex align-items-center">
                                <div class="visit-avatar me-3">
                                    <i class="fas fa-user-circle" style="font-size: 2rem; color: var(--primary);"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 visit-name">Clarence Villas</h6>
                                    <p class="mb-1 visit-type">Annual Checkup</p>
                                    <small class="visit-date text-success">Dec 27, 2025 at 10:30 AM</small>
                                </div>
                                <span class="badge bg-success visit-status">Completed</span>
                            </div>
                        </div>
                        
                        <div class="visit-item mb-3 p-3" style="background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(240, 240, 255, 0.95) 100%); border-radius: 8px; border-left: 4px solid var(--primary); box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                            <div class="d-flex align-items-center">
                                <div class="visit-avatar me-3">
                                    <i class="fas fa-user-circle" style="font-size: 2rem; color: var(--primary);"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 visit-name">Jasmine De Leon</h6>
                                    <p class="mb-1 visit-type">Allergy Checkup</p>
                                    <small class="visit-date text-warning">Dec 26, 2025 at 2:15 PM</small>
                                </div>
                                <span class="badge bg-warning visit-status">In Progress</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="section-card">
                    <div class="section-header">
                        <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Students with Allergies</h5>
                    </div>
                    <div class="section-content" style="text-align: left; padding: 1rem;">
                        @forelse($studentsWithAllergies as $student)
                        <div class="allergy-item mb-3 p-3" style="background: linear-gradient(135deg, rgba(255, 250, 230, 0.95) 0%, rgba(255, 245, 220, 0.95) 100%); border-radius: 8px; border-left: 4px solid #ffc107; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                            <div class="d-flex align-items-center">
                                <div class="allergy-avatar me-3">
                                    <i class="fas fa-user-circle" style="font-size: 2rem; color: #ffc107;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 allergy-name">{{ $student->first_name }} {{ $student->last_name }}</h6>
                                    <p class="mb-0 allergy-list">
                                        {{ $student->allergies_display ?: 'Allergies recorded' }}
                                    </p>
                                </div>
                                <i class="fas fa-exclamation-circle text-warning"></i>
                            </div>
                        </div>
                        @empty
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-check-circle fa-2x mb-2 text-success"></i>
                            <p>No students with allergies found</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('show');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('userDropdown');
            const userBtn = event.target.closest('.user-btn');
            if (!userBtn && dropdown.classList.contains('show')) {
                dropdown.classList.remove('show');
            }
        });

        // Search functionality
        document.getElementById('studentSearch').addEventListener('input', function() {
            filterStudents();
        });

        document.getElementById('statusFilter').addEventListener('change', function() {
            filterStudents();
        });

        function filterStudents() {
            const searchTerm = document.getElementById('studentSearch').value.toLowerCase();
            const statusFilter = document.getElementById('statusFilter').value;
            const tableRows = document.querySelectorAll('#studentsTable tbody tr');

            tableRows.forEach(row => {
                const cells = row.querySelectorAll('td');
                if (cells.length === 1) return; // Skip "no records" row

                const name = cells[0].textContent.toLowerCase();
                const lrn = cells[1].textContent.toLowerCase();
                const status = cells[2].textContent.toLowerCase();

                const matchesSearch = name.includes(searchTerm) || lrn.includes(searchTerm) || status.includes(searchTerm);
                const matchesStatus = !statusFilter || status.includes(statusFilter);

                row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
            });
        }

        function clearFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('statusFilter').value = '';
            filterStudents();
        }

        function selectAll() {
            const checkboxes = document.querySelectorAll('.student-checkbox');
            const selectAllCheckbox = document.getElementById('selectAll');
            
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
            
            updateBulkActions();
        }

        function updateBulkActions() {
            const checkedBoxes = document.querySelectorAll('.student-checkbox:checked');
            const bulkActionsPanel = document.getElementById('bulkActionsPanel');
            
            if (checkedBoxes.length > 0) {
                bulkActionsPanel.style.display = 'block';
                document.getElementById('selectedCount').textContent = checkedBoxes.length;
            } else {
                bulkActionsPanel.style.display = 'none';
            }
        }

        function markAsFit() {
            const checkedBoxes = document.querySelectorAll('.student-checkbox:checked');
            alert(`Marking ${checkedBoxes.length} students as Fit for Activities`);
            // Add actual implementation here
        }

        function markAsPending() {
            const checkedBoxes = document.querySelectorAll('.student-checkbox:checked');
            alert(`Marking ${checkedBoxes.length} students as Pending Assessment`);
            // Add actual implementation here
        }

        function markAsRestricted() {
            const checkedBoxes = document.querySelectorAll('.student-checkbox:checked');
            alert(`Marking ${checkedBoxes.length} students as Restricted Activities`);
            // Add actual implementation here
        }

        function clearSelection() {
            const checkboxes = document.querySelectorAll('.student-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            document.getElementById('selectAll').checked = false;
            updateBulkActions();
        }

        function viewStudent(id) {
            alert(`Viewing student with ID: ${id}`);
            // Add actual implementation here
        }

        function editStudent(id) {
            alert(`Editing student with ID: ${id}`);
            // Add actual implementation here
        }

        function addVisit(id) {
            alert(`Adding visit for student with ID: ${id}`);
            // Add actual implementation here
        }

        function addStudent() {
            alert('Adding new student');
            // Add actual implementation here
        }

        function exportData() {
            alert('Exporting student data');
            // Add actual implementation here
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
            
            // Add event listeners for checkboxes
            const checkboxes = document.querySelectorAll('.student-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateBulkActions);
            });
        });

        // Session keep-alive mechanism
        function keepSessionAlive() {
            fetch('/keep-alive', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    console.warn('Session keep-alive failed:', response.status);
                    // If session expired, redirect to login
                    if (response.status === 401 || response.status === 419) {
                        window.location.href = '/login';
                    }
                }
                return response.json();
            })
            .then(data => {
                console.log('Session keep-alive successful:', data);
            })
            .catch(error => {
                console.error('Session keep-alive error:', error);
            });
        }

        // Check session status on page load
        function checkSessionStatus() {
            fetch('/session-status', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    console.warn('Session check failed:', response.status);
                    if (response.status === 401 || response.status === 419) {
                        window.location.href = '/login';
                    }
                    return;
                }
                return response.json();
            })
            .then(data => {
                if (!data.authenticated) {
                    console.warn('User not authenticated, redirecting to login');
                    window.location.href = '/login';
                } else {
                    console.log('Session status OK:', data);
                }
            })
            .catch(error => {
                console.error('Session status check error:', error);
            });
        }

        // Check session status immediately on page load
        checkSessionStatus();

        // Keep session alive every 10 minutes (600,000 ms)
        setInterval(keepSessionAlive, 600000);

        // Also keep session alive on user activity
        let activityTimer;
        function resetActivityTimer() {
            clearTimeout(activityTimer);
            activityTimer = setTimeout(keepSessionAlive, 300000); // 5 minutes of inactivity
        }

        // Listen for user activity
        ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart', 'click'].forEach(event => {
            document.addEventListener(event, resetActivityTimer, true);
        });

        // Initial activity timer
        resetActivityTimer();
    </script>
</body>
</html>
