<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Medical Visits - PDMHS Clinic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:wght@400;500;600;800&display=swap" rel="stylesheet">
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
        
        .visits-table {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
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
        
        .student-info {
            display: flex;
            align-items: center;
        }
        
        .student-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: var(--gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            margin-right: 10px;
            font-size: 14px;
        }
        
        .student-name {
            font-weight: 600;
            color: #212529;
            margin-bottom: 2px;
        }
        
        .student-number {
            font-size: 12px;
            color: #6c757d;
        }
        
        .visit-type-badge {
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .type-routine {
            background-color: #d4edda;
            color: #155724;
        }
        
        .type-emergency {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .type-follow-up {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        
        .type-referral {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-badge {
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .status-open {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-closed {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        
        .status-referred {
            background-color: #f8d7da;
            color: #721c24;
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
        
        .btn-edit {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
        }
        
        .btn-print {
            background-color: #6c757d;
            border-color: #6c757d;
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
        
        .complaint {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .visit-datetime {
            font-size: 13px;
            color: #495057;
        }
        
        .visit-date {
            font-weight: 600;
            margin-bottom: 2px;
        }
        
        .visit-time {
            color: #6c757d;
        }

        /* New Visit Modal Styles */
        .visit-form-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid #007bff;
        }

        .section-title {
            color: #007bff;
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        .student-result-item {
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 1rem;
            margin-bottom: 0.5rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .student-result-item:hover {
            background-color: #f8f9fa;
            border-color: #007bff;
        }

        .student-result-item.selected {
            background-color: #e3f2fd;
            border-color: #007bff;
        }

        .student-name {
            font-weight: 600;
            color: #212529;
        }

        .student-details {
            font-size: 0.875rem;
            color: #6c757d;
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
                    Dashboard
                </a>
                <a class="nav-link" href="{{ route('clinic-staff.students') }}">
                    <i></i>Students
                </a>
                <a class="nav-link active" href="{{ route('clinic-staff.visits') }}">
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
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="page-title">Medical Visits</h1>
                    <p class="page-subtitle">Manage student clinic visits</p>
                </div>
                <button class="btn btn-primary btn-lg" onclick="showNewVisitModal()">
                    <i class="fas fa-plus me-2"></i>New Visit
                </button>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="search-filters">
            <div class="filter-controls">
                <div class="search-input">
                    <input type="text" class="form-control" id="searchInput" placeholder="Search by student name or complaint">
                </div>
                <input type="date" class="form-control" id="dateFilter" style="width: auto;">
                <select class="form-select" id="statusFilter" style="width: auto;">
                    <option value="">All Status</option>
                    <option value="Open">Open</option>
                    <option value="Closed">Closed</option>
                    <option value="Referred">Referred</option>
                </select>
                <select class="form-select" id="typeFilter" style="width: auto;">
                    <option value="">All Types</option>
                    <option value="Routine">Routine</option>
                    <option value="Emergency">Emergency</option>
                    <option value="Follow-up">Follow-up</option>
                    <option value="Referral">Referral</option>
                </select>
            </div>
        </div>

        <!-- Visits Table -->
        <div class="visits-table">
            <div class="table-responsive">
                <table class="table" id="visitsTable">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Date & Time</th>
                            <th>Type</th>
                            <th>Chief Complaint</th>
                            <th>Diagnosis</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($visits as $visit)
                        <tr>
                            <td>
                                <div class="student-info">
                                    <div class="student-avatar">
                                        {{ strtoupper(substr($visit->student->first_name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="student-name">
                                            {{ $visit->student->first_name }} {{ $visit->student->last_name }}
                                        </div>
                                        <div class="student-number">
                                            {{ $visit->student->formatted_student_number }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="visit-datetime">
                                    <div class="visit-date">{{ $visit->visit_datetime->format('M d, Y') }}</div>
                                    <div class="visit-time">{{ $visit->visit_datetime->format('h:i A') }}</div>
                                </div>
                            </td>
                            <td>
                                <span class="visit-type-badge type-{{ strtolower(str_replace(' ', '-', $visit->visit_type)) }}">
                                    {{ $visit->visit_type }}
                                </span>
                            </td>
                            <td>
                                <div class="chief-complaint" title="{{ $visit->chief_complaint }}">
                                    {{ $visit->chief_complaint ?: 'Not specified' }}
                                </div>
                            </td>
                            <td>
                                @if($visit->diagnoses->count() > 0)
                                    {{ $visit->diagnoses->first()->diagnosis_name }}
                                    @if($visit->diagnoses->count() > 1)
                                        <small class="text-muted">(+{{ $visit->diagnoses->count() - 1 }} more)</small>
                                    @endif
                                @else
                                    <span class="text-muted">Pending</span>
                                @endif
                            </td>
                            <td>
                                <span class="status-badge status-{{ strtolower($visit->status) }}">
                                    {{ $visit->status }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-action btn-view" onclick="showVisitDetails({{ $visit->visit_id }})">
                                    <i class="fas fa-eye me-1"></i>View
                                </button>
                                @if($visit->status === 'Open')
                                <button class="btn btn-action btn-edit" onclick="editVisit({{ $visit->visit_id }})">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </button>
                                @endif
                                <button class="btn btn-action btn-print" onclick="printVisit({{ $visit->visit_id }})">
                                    <i class="fas fa-print me-1"></i>Print
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No visits found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Visit count info -->
        <div class="mt-3">
            <small class="text-muted">Showing {{ $visits->count() }} visits</small>
        </div>
    </div>

    <!-- Include Visit Details Modal -->
    @include('visit-details-modal')

    <!-- New Visit Modal -->
    <div class="modal fade" id="newVisitModal" tabindex="-1" aria-labelledby="newVisitModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="newVisitModalLabel">
                        <i class="fas fa-plus me-2"></i>New Medical Visit
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="newVisitForm" method="POST" action="{{ route('clinic-staff.visits.store') }}">
                    @csrf
                    <div class="modal-body">
                        <!-- Back to Visits Link -->
                        <div class="mb-3">
                            <a href="#" class="text-primary" data-bs-dismiss="modal">
                                <i class="fas fa-arrow-left me-1"></i>Back to Visits
                            </a>
                        </div>

                        <!-- Student Information Section -->
                        <div class="visit-form-section">
                            <h6 class="section-title">
                                <i class="fas fa-user me-2"></i>Student Information
                            </h6>
                            
                            <!-- QR Code Scanner Button -->
                            <div class="text-center mb-3">
                                <button type="button" class="btn btn-success btn-lg" onclick="openQRScanner()">
                                    <i class="fas fa-qrcode me-2"></i>Scan Student QR Code
                                </button>
                                <p class="text-muted mt-2">or search manually</p>
                            </div>

                            <!-- Manual Search -->
                            <div class="mb-3">
                                <label class="form-label">Search Student</label>
                                <input type="text" class="form-control" id="studentSearch" placeholder="Enter student number or name">
                                <input type="hidden" name="student_id" id="selectedStudentId">
                            </div>

                            <!-- Student Results -->
                            <div id="studentResults" class="mb-3" style="display: none;">
                                <!-- Student search results will appear here -->
                            </div>

                            <!-- Selected Student Display -->
                            <div id="selectedStudent" class="alert alert-info" style="display: none;">
                                <!-- Selected student info will appear here -->
                            </div>
                        </div>

                        <!-- Visit Details Section -->
                        <div class="visit-form-section">
                            <h6 class="section-title">
                                <i class="fas fa-clipboard-list me-2"></i>Visit Details
                            </h6>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Date & Time <span class="text-danger">*</span></label>
                                        <input type="datetime-local" class="form-control" name="visit_datetime" 
                                               value="{{ now()->format('Y-m-d\TH:i') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Visit Type <span class="text-danger">*</span></label>
                                        <select class="form-select" name="visit_type" required>
                                            <option value="">Select type</option>
                                            <option value="Routine">Routine</option>
                                            <option value="Emergency">Emergency</option>
                                            <option value="Follow-up">Follow-up</option>
                                            <option value="Referral">Referral</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Chief Complaint <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="chief_complaint" rows="3" 
                                          placeholder="Describe the main reason for the visit" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Notes</label>
                                <textarea class="form-control" name="notes" rows="3" 
                                          placeholder="Additional notes or observations"></textarea>
                            </div>
                        </div>

                        <!-- Vital Signs Section -->
                        <div class="visit-form-section">
                            <h6 class="section-title">
                                <i class="fas fa-heartbeat me-2"></i>Vital Signs
                            </h6>
                            
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Temperature (°C)</label>
                                        <input type="number" step="0.1" class="form-control" name="temperature" placeholder="36.5">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Blood Pressure</label>
                                        <input type="text" class="form-control" name="blood_pressure" placeholder="120/80">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Pulse Rate (bpm)</label>
                                        <input type="number" class="form-control" name="pulse_rate" placeholder="72">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Respiratory Rate</label>
                                        <input type="number" class="form-control" name="respiratory_rate" placeholder="16">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Assessment & Treatment Section -->
                        <div class="visit-form-section">
                            <h6 class="section-title">
                                <i class="fas fa-stethoscope me-2"></i>Assessment & Treatment
                            </h6>
                            
                            <div class="mb-3">
                                <label class="form-label">Diagnosis</label>
                                <textarea class="form-control" name="diagnosis" rows="2" 
                                          placeholder="Enter diagnosis"></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Treatment Given</label>
                                <textarea class="form-control" name="treatment_given" rows="3" 
                                          placeholder="Describe treatment provided"></textarea>
                            </div>
                        </div>

                        <!-- Medication Administered Section -->
                        <div class="visit-form-section">
                            <h6 class="section-title">
                                <i class="fas fa-pills me-2"></i>Medication Administered
                            </h6>
                            
                            <div class="mb-3">
                                <label class="form-label">Medications Given</label>
                                <textarea class="form-control" name="medications_administered" rows="3" 
                                          placeholder="List medications given"></textarea>
                            </div>
                        </div>

                        <!-- Status & Notification Section -->
                        <div class="visit-form-section">
                            <h6 class="section-title">
                                <i class="fas fa-bell me-2"></i>Status & Notification
                            </h6>
                            
                            <div class="mb-3">
                                <label class="form-label">Visit Status <span class="text-danger">*</span></label>
                                <select class="form-select" name="status" required>
                                    <option value="">Select status</option>
                                    <option value="Open" selected>Open</option>
                                    <option value="Closed">Closed</option>
                                    <option value="Referred">Referred</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="notify_parent" id="notifyParent" value="1">
                                    <label class="form-check-label" for="notifyParent">
                                        Notify Parent/Guardian via Email
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-primary" id="saveVisitBtn" disabled>
                            <i class="fas fa-save me-1"></i>Create Visit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Search and filter functionality
        document.getElementById('searchInput').addEventListener('input', filterVisits);
        document.getElementById('dateFilter').addEventListener('change', filterVisits);
        document.getElementById('statusFilter').addEventListener('change', filterVisits);
        document.getElementById('typeFilter').addEventListener('change', filterVisits);

        function filterVisits() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const dateFilter = document.getElementById('dateFilter').value;
            const statusFilter = document.getElementById('statusFilter').value;
            const typeFilter = document.getElementById('typeFilter').value;
            const tableRows = document.querySelectorAll('#visitsTable tbody tr');

            let visibleCount = 0;

            tableRows.forEach(row => {
                const cells = row.querySelectorAll('td');
                if (cells.length === 1) return; // Skip "no records" row

                const studentName = cells[0].textContent.toLowerCase();
                const visitDate = cells[1].textContent;
                const visitType = cells[2].textContent.trim();
                const complaint = cells[3].textContent.toLowerCase();
                const status = cells[5].textContent.trim();

                const matchesSearch = studentName.includes(searchTerm) || complaint.includes(searchTerm);
                const matchesDate = !dateFilter || visitDate.includes(new Date(dateFilter).toLocaleDateString());
                const matchesStatus = !statusFilter || status === statusFilter;
                const matchesType = !typeFilter || visitType === typeFilter;

                if (matchesSearch && matchesDate && matchesStatus && matchesType) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            // Update count display
            const countDisplay = document.querySelector('.mt-3 small');
            if (countDisplay) {
                countDisplay.textContent = `Showing ${visibleCount} visits`;
            }
        }

        function editVisit(visitId) {
            // For now, just show an alert - edit functionality will be added later
            alert('Edit visit functionality coming soon!');
        }

        function printVisit(visitId) {
            // For now, just show an alert - print functionality will be added later
            alert('Print visit functionality coming soon!');
        }

        // New Visit Modal Functions
        function showNewVisitModal() {
            const modal = new bootstrap.Modal(document.getElementById('newVisitModal'));
            modal.show();
        }

        function openQRScanner() {
            // For now, show alert - QR scanner will be implemented later
            alert('QR Scanner functionality coming soon!');
        }

        // Student search functionality
        document.getElementById('studentSearch').addEventListener('input', function() {
            const searchTerm = this.value.trim();
            
            if (searchTerm.length >= 2) {
                searchStudents(searchTerm);
            } else {
                document.getElementById('studentResults').style.display = 'none';
            }
        });

        function searchStudents(searchTerm) {
            // Make AJAX request to search students
            fetch(`/clinic-staff/students/search?q=${encodeURIComponent(searchTerm)}`)
                .then(response => response.json())
                .then(data => {
                    displayStudentResults(data.students);
                })
                .catch(error => {
                    console.error('Error searching students:', error);
                });
        }

        function displayStudentResults(students) {
            const resultsContainer = document.getElementById('studentResults');
            
            if (students.length === 0) {
                resultsContainer.innerHTML = '<p class="text-muted">No students found</p>';
                resultsContainer.style.display = 'block';
                return;
            }

            let html = '<div class="mb-2"><strong>Select a student:</strong></div>';
            students.forEach(student => {
                html += `
                    <div class="student-result-item" onclick="selectStudent(${student.id}, '${student.first_name} ${student.last_name}', '${student.student_id || 'N/A'}', '${student.grade_level || ''} ${student.section || ''}')">
                        <div class="student-name">${student.first_name} ${student.last_name}</div>
                        <div class="student-details">
                            Student #: ${student.student_id || 'N/A'} | 
                            Grade: ${student.grade_level || 'N/A'} ${student.section || ''}
                        </div>
                    </div>
                `;
            });

            resultsContainer.innerHTML = html;
            resultsContainer.style.display = 'block';
        }

        function selectStudent(studentId, studentName, studentNumber, gradeSection) {
            // Set the hidden input value
            document.getElementById('selectedStudentId').value = studentId;
            
            // Show selected student info
            const selectedContainer = document.getElementById('selectedStudent');
            selectedContainer.innerHTML = `
                <strong>Selected Student:</strong><br>
                <strong>${studentName}</strong><br>
                Student #: ${studentNumber} | Grade: ${gradeSection}
            `;
            selectedContainer.style.display = 'block';
            
            // Hide search results
            document.getElementById('studentResults').style.display = 'none';
            
            // Clear search input
            document.getElementById('studentSearch').value = '';
            
            // Enable save button
            document.getElementById('saveVisitBtn').disabled = false;
        }

        // Form submission
        document.getElementById('newVisitForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Simple form submission for testing
            const formData = new FormData(this);
            
            // Check if student is selected
            if (!document.getElementById('selectedStudentId').value) {
                alert('Please select a student first.');
                return;
            }
            
            // Show loading state
            const saveBtn = document.getElementById('saveVisitBtn');
            const originalText = saveBtn.innerHTML;
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Creating...';
            saveBtn.disabled = true;
            
            // Submit form normally for now
            this.submit();
        });
    </script>
</body>
</html>