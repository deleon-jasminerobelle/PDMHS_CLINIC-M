<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Clinic Staff Dashboard - PDMHS Clinic</title>
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
        .stat-card {
            border-radius: 12px;
            border: none;
            padding: 1.5rem;
            margin-bottom: 1rem;
            color: white;
            font-weight: 500;
            text-align: center;
        }
        .stat-card h2 {
            font-family: 'Roboto', sans-serif;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .stat-card p {
            margin: 0;
            opacity: 0.9;
            font-family: 'Roboto', sans-serif;
            font-size: 25px;
            font-weight: 700;
        }
        .stat-card-blue { background: var(--gradient); }
        .stat-card-orange { background: var(--gradient); }
        .stat-card-yellow { background: var(--gradient); }
        .stat-card-purple { background: var(--gradient); }
        
        .btn-action {
            background: white;
            border: 2px solid #e8ecf4;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            color: var(--primary);
            font-weight: 600;
            transition: all 0.3s ease;
            min-height: 120px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        
        .btn-action:hover {
            background: var(--gradient);
            color: white;
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(30, 64, 175, 0.2);
        }
        
        .btn-action i {
            font-size: 2rem;
        }
        
        .visit-name {
            font-family: 'Albert Sans', sans-serif !important;
            font-weight: 500 !important;
            font-size: 20px !important;
        }
        
        .visit-type {
            font-family: 'Albert Sans', sans-serif !important;
            font-weight: 500 !important;
            font-size: 20px !important;
            color: #6c757d !important;
        }
        
        .visit-date {
            font-family: 'Albert Sans', sans-serif !important;
            font-weight: 500 !important;
            font-size: 20px !important;
        }
        
        .visit-status {
            font-family: 'Albert Sans', sans-serif !important;
            font-weight: 500 !important;
            font-size: 20px !important;
        }
        
        .allergy-name {
            font-family: 'Albert Sans', sans-serif !important;
            font-weight: 500 !important;
            font-size: 20px !important;
        }
        
        .allergy-list {
            font-family: 'Albert Sans', sans-serif !important;
            font-weight: 500 !important;
            font-size: 20px !important;
            color: #6c757d !important;
        }
        
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
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .section-header h5 {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 700;
            font-size: 30px;
            margin-bottom: 0;
        }
        .section-content {
            padding: 2rem;
            text-align: center;
            color: #6c757d;
        }
        .navbar-brand {
            font-weight: 600;
        }
        
        .navbar-nav .nav-link {
            font-family: 'Epilogue', sans-serif !important;
            font-size: 25px !important;
            font-weight: 600 !important;
        }
        
        .dropdown-menu .dropdown-item {
            font-family: 'Epilogue', sans-serif !important;
            font-size: 20px !important;
            font-weight: 500 !important;
        }
        .welcome-header {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 800;
            font-size: 35px;
        }
        
        .dashboard-subtitle {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 700;
            font-size: 25px;
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('clinic-staff.dashboard') }}">
            </a>
            <div class="navbar-nav me-auto">
                <a class="nav-link active" href="{{ route('clinic-staff.dashboard') }}">
                    <i></i>Dashboard
                </a>
                <a class="nav-link" href="{{ route('clinic-staff.students') }}">
                    <i ></i>Students
                </a>
                <a class="nav-link" href="{{ route('clinic-staff.visits') }}">
                    <i ></i>Visits
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
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user-cog me-2"></i>Profile</a></li>
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
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="font-family: 'Epilogue', sans-serif; font-size: 20px; font-weight: 500;">
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

        <!-- Header -->
        <div class="mb-4">
            <h1 class="h3 mb-1 welcome-header">Welcome, Maria Santos!</h1>
            <p class="text-muted dashboard-subtitle">Clinic Staff Dashboard</p>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="stat-card stat-card-blue d-flex flex-column justify-content-center" style="min-height: 120px;">
                    <h2>4</h2>
                    <p>Total Students</p>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="stat-card stat-card-orange d-flex flex-column justify-content-center" style="min-height: 120px;">
                    <h2>1</h2>
                    <p>Today's Visits</p>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="stat-card stat-card-yellow d-flex flex-column justify-content-center" style="min-height: 120px;">
                    <h2>2</h2>
                    <p>New Visits</p>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="stat-card stat-card-purple d-flex flex-column justify-content-center" style="min-height: 120px;">
                    <h2>0</h2>
                    <p>Pending Visits</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="section-card">
                    <div class="section-header">
                        <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
                    </div>
                    <div class="section-content">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <button class="btn btn-action w-100" onclick="alert('New Visit functionality coming soon!')">
                                    <i class="fas fa-plus-circle mb-2"></i>
                                    <div>New Visit</div>
                                </button>
                            </div>
                            <div class="col-md-3 mb-3">
                                <button class="btn btn-action w-100" onclick="alert('Find Student functionality coming soon!')">
                                    <i class="fas fa-search mb-2"></i>
                                    <div>Find Student</div>
                                </button>
                            </div>
                            <div class="col-md-3 mb-3">
                                <button class="btn btn-action w-100" onclick="alert('Generate Report functionality coming soon!')">
                                    <i class="fas fa-file-alt mb-2"></i>
                                    <div>Generate Report</div>
                                </button>
                            </div>
                            <div class="col-md-3 mb-3">
                                <button class="btn btn-action w-100" onclick="alert('My Profile functionality coming soon!')">
                                    <i class="fas fa-user-cog mb-2"></i>
                                    <div>My Profile</div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
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
                        <div class="visit-item mb-3 p-3" style="background: #f8f9fa; border-radius: 8px; border-left: 4px solid var(--primary);">
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
                        
                        <div class="visit-item mb-3 p-3" style="background: #f8f9fa; border-radius: 8px; border-left: 4px solid var(--primary);">
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
                        <div class="allergy-item mb-3 p-3" style="background: #fff3cd; border-radius: 8px; border-left: 4px solid #ffc107;">
                            <div class="d-flex align-items-center">
                                <div class="allergy-avatar me-3">
                                    <i class="fas fa-user-circle" style="font-size: 2rem; color: #ffc107;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 allergy-name">Hannah Loraine Geronday</h6>
                                    <p class="mb-0 allergy-list">Peanuts, Shellfish</p>
                                </div>
                                <i class="fas fa-exclamation-circle text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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