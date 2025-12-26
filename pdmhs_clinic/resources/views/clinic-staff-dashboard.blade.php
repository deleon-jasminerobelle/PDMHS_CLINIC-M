<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Clinic Staff Dashboard - PDMHS Clinic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:wght@400;500;600&display=swap" rel="stylesheet">
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
        .section-content {
            padding: 2rem;
            text-align: center;
            color: #6c757d;
        }
        .navbar-brand {
            font-weight: 600;
        }
        .welcome-header {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('clinic-staff.dashboard') }}">
                <i class="fas fa-heartbeat me-2"></i>
                PDMHS Clinic
            </a>
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user me-1"></i>
                        {{ $user->name }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user-cog me-2"></i>Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </button>
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

        <!-- Header -->
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1 welcome-header">Welcome back, {{ $user->name }}!</h1>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-lg">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="stat-card stat-card-blue">
                    <h2>0</h2>
                    <p>Fit for Activities</p>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="stat-card stat-card-orange">
                    <h2>0</h2>
                    <p>Pending Assessment</p>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="stat-card stat-card-yellow">
                    <h2>0</h2>
                    <p>Restricted Activities</p>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="stat-card stat-card-purple">
                    <h2>0</h2>
                    <p>Special Medical Needs</p>
                </div>
            </div>
        </div>

        <!-- Student Health Status Section -->
        <div class="row">
            <div class="col-12">
                <div class="section-card">
                    <div class="section-header">
                        <h5 class="mb-0">Student Health Status</h5>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-success" onclick="addNewStudent()">
                                <i class="fas fa-plus me-1"></i>Add Student
                            </button>
                            <button class="btn btn-sm btn-primary" onclick="exportData()">
                                <i class="fas fa-download me-1"></i>Export
                            </button>
                        </div>
                    </div>
                    <div class="section-content">
                        <!-- Search Bar -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" class="form-control" id="studentSearch" placeholder="Search by name, LRN, or status..." onkeyup="searchStudents()">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="statusFilter" onchange="filterByStatus()">
                                    <option value="">All Status</option>
                                    <option value="fit">Fit for Activities</option>
                                    <option value="pending">Pending Assessment</option>
                                    <option value="restricted">Restricted Activities</option>
                                    <option value="special">Special Medical Needs</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-outline-secondary w-100" onclick="clearFilters()">
                                    <i class="fas fa-times me-1"></i>Clear Filters
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover" id="studentsTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>
                                            <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                                        </th>
                                        <th>Student Name</th>
                                        <th>LRN</th>
                                        <th>Status</th>
                                        <th>Last Check-up</th>
                                        <th>Notes</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="studentsTableBody">
                                    <!-- Sample Data -->
                                    <tr>
                                        <td><input type="checkbox" class="student-checkbox" value="1"></td>
                                        <td><strong>Clarence Villas</strong></td>
                                        <td>STU001</td>
                                        <td><span class="badge bg-success">Fit for Activities</span></td>
                                        <td>Dec 15, 2024</td>
                                        <td>Regular check-up completed</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-outline-primary" onclick="viewStudent(1)" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-warning" onclick="editStudent(1)" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-info" onclick="addVisit(1)" title="Add Visit">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" class="student-checkbox" value="2"></td>
                                        <td><strong>Maria Santos</strong></td>
                                        <td>STU002</td>
                                        <td><span class="badge bg-warning">Pending Assessment</span></td>
                                        <td>Dec 10, 2024</td>
                                        <td>Awaiting medical clearance</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-outline-primary" onclick="viewStudent(2)" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-warning" onclick="editStudent(2)" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-info" onclick="addVisit(2)" title="Add Visit">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" class="student-checkbox" value="3"></td>
                                        <td><strong>John Dela Cruz</strong></td>
                                        <td>STU003</td>
                                        <td><span class="badge bg-danger">Restricted Activities</span></td>
                                        <td>Dec 8, 2024</td>
                                        <td>Asthma - limited physical activities</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-outline-primary" onclick="viewStudent(3)" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-warning" onclick="editStudent(3)" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-info" onclick="addVisit(3)" title="Add Visit">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Bulk Actions -->
                        <div class="row mt-3" id="bulkActions" style="display: none;">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <strong>Bulk Actions:</strong>
                                    <button class="btn btn-sm btn-success ms-2" onclick="bulkUpdateStatus('fit')">
                                        Mark as Fit
                                    </button>
                                    <button class="btn btn-sm btn-warning ms-2" onclick="bulkUpdateStatus('pending')">
                                        Mark as Pending
                                    </button>
                                    <button class="btn btn-sm btn-danger ms-2" onclick="bulkUpdateStatus('restricted')">
                                        Mark as Restricted
                                    </button>
                                    <button class="btn btn-sm btn-secondary ms-2" onclick="clearSelection()">
                                        Clear Selection
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-dismiss alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });

            // Refresh CSRF token every 30 minutes to prevent expiration
            setInterval(function() {
                fetch('/csrf-token', {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Update all CSRF tokens on the page
                    const csrfInputs = document.querySelectorAll('input[name="_token"]');
                    csrfInputs.forEach(input => {
                        input.value = data.csrf_token;
                    });
                })
                .catch(error => {
                    console.log('CSRF token refresh failed:', error);
                });
            }, 30 * 60 * 1000); // 30 minutes

            // Keep session alive by pinging server every 10 minutes
            setInterval(function() {
                fetch('/keep-alive', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                                       document.querySelector('input[name="_token"]')?.value
                    }
                })
                .catch(error => {
                    console.log('Keep alive failed:', error);
                });
            }, 10 * 60 * 1000); // 10 minutes
        });

        // Search functionality
        function searchStudents() {
            const searchTerm = document.getElementById('studentSearch').value.toLowerCase();
            const rows = document.querySelectorAll('#studentsTableBody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Filter by status
        function filterByStatus() {
            const statusFilter = document.getElementById('statusFilter').value;
            const rows = document.querySelectorAll('#studentsTableBody tr');
            
            rows.forEach(row => {
                if (!statusFilter) {
                    row.style.display = '';
                    return;
                }
                
                const statusBadge = row.querySelector('.badge');
                if (statusBadge) {
                    const statusText = statusBadge.textContent.toLowerCase();
                    const showRow = 
                        (statusFilter === 'fit' && statusText.includes('fit')) ||
                        (statusFilter === 'pending' && statusText.includes('pending')) ||
                        (statusFilter === 'restricted' && statusText.includes('restricted')) ||
                        (statusFilter === 'special' && statusText.includes('special'));
                    
                    row.style.display = showRow ? '' : 'none';
                }
            });
        }

        // Clear all filters
        function clearFilters() {
            document.getElementById('studentSearch').value = '';
            document.getElementById('statusFilter').value = '';
            const rows = document.querySelectorAll('#studentsTableBody tr');
            rows.forEach(row => row.style.display = '');
        }

        // Select all functionality
        function toggleSelectAll() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.student-checkbox');
            
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
            });
            
            toggleBulkActions();
        }

        // Toggle bulk actions visibility
        function toggleBulkActions() {
            const checkboxes = document.querySelectorAll('.student-checkbox:checked');
            const bulkActions = document.getElementById('bulkActions');
            
            if (checkboxes.length > 0) {
                bulkActions.style.display = 'block';
            } else {
                bulkActions.style.display = 'none';
            }
        }

        // Add event listeners to checkboxes
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.student-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', toggleBulkActions);
            });
        });

        // Action functions
        function addNewStudent() {
            alert('Add New Student functionality - This would open a form to add a new student');
        }

        function exportData() {
            alert('Export Data functionality - This would export the student health data');
        }

        function viewStudent(studentId) {
            alert(`View Student ${studentId} - This would show detailed student information`);
        }

        function editStudent(studentId) {
            alert(`Edit Student ${studentId} - This would open an edit form for the student`);
        }

        function addVisit(studentId) {
            alert(`Add Visit for Student ${studentId} - This would open a form to record a new clinic visit`);
        }

        function bulkUpdateStatus(status) {
            const checkboxes = document.querySelectorAll('.student-checkbox:checked');
            const count = checkboxes.length;
            
            if (count === 0) {
                alert('Please select at least one student');
                return;
            }
            
            if (confirm(`Are you sure you want to update ${count} student(s) status to "${status}"?`)) {
                alert(`Bulk update completed for ${count} student(s) - Status changed to "${status}"`);
                clearSelection();
            }
        }

        function clearSelection() {
            const checkboxes = document.querySelectorAll('.student-checkbox');
            const selectAll = document.getElementById('selectAll');
            
            checkboxes.forEach(checkbox => checkbox.checked = false);
            selectAll.checked = false;
            toggleBulkActions();
        }
    </script>
</body>
</html>