<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Medical Visits - PDMHS Clinic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
            font-family: 'Albert Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-weight: 600;
        }

        .navbar-nav .nav-link {
            font-family: 'Albert Sans', sans-serif !important;
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
            font-weight: 600;
            font-size: 32px;
            margin-bottom: 0.5rem;
        }
        
        .page-subtitle {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 600;
            font-size: 16px;
            color: #6c757d;
            margin-bottom: 0;
        }

        /* QR Scanner Modal Styles */
        .scanner-container {
            max-width: 500px;
            margin: 0 auto;
        }

        .scanner-video {
            width: 100%;
            height: 350px;
            background: #000;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .scanner-video video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 15px;
        }

        .scanner-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 200px;
            height: 200px;
            border: 3px solid var(--primary);
            border-radius: 15px;
            box-shadow: 0 0 0 1000px rgba(0, 0, 0, 0.5);
        }

        .scanner-placeholder {
            color: white;
            font-size: 16px;
            text-align: center;
            font-family: 'Albert Sans', sans-serif;
            font-weight: 600;
        }

        .scanner-placeholder::before {
            content: "📱";
            font-size: 40px;
            display: block;
            margin-bottom: 12px;
        }

        .scanner-status {
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            font-family: 'Albert Sans', sans-serif;
        }

        .scanner-status.success {
            background: rgba(30, 64, 175, 0.1);
            color: var(--primary);
            border: 1px solid rgba(30, 64, 175, 0.2);
        }

        .scanner-status.error {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.2);
        }

        .instructions {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1rem;
        }

        .instructions h6 {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .instructions ol {
            font-family: 'Albert Sans', sans-serif;
            font-size: 14px;
            color: #495057;
            margin-bottom: 0;
        }

        .visit-form-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid var(--primary);
        }

        .section-title {
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 1.1rem;
            font-family: 'Albert Sans', sans-serif;
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
            border-color: var(--primary);
        }

        .student-name {
            font-weight: 600;
            color: #212529;
            margin-bottom: 2px;
            font-family: 'Albert Sans', sans-serif;
        }

        .student-details {
            font-size: 12px;
            color: #6c757d;
            font-family: 'Albert Sans', sans-serif;
            font-weight: 600;
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
                    Students
                </a>
                <a class="nav-link active" href="{{ route('clinic-staff.visits') }}">
                    Visits
                </a>
                <a class="nav-link" href="{{ route('scanner') }}">
                    Scanner
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

        <!-- Visits Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Complaint</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6" class="text-center text-muted">No visits recorded yet</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

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
                        <!-- Student Information Section -->
                        <div class="visit-form-section">
                            <h6 class="section-title">
                                <i class="fas fa-user me-2"></i>Student Information
                            </h6>
                            
                            <!-- QR Code Scanner Button -->
                            <div class="text-center mb-3">
                                <button type="button" class="btn btn-primary btn-lg" onclick="openQRScanner()">
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

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Weight (kg)</label>
                                        <input type="number" step="0.1" class="form-control" name="weight" placeholder="50.0">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Height (cm)</label>
                                        <input type="number" class="form-control" name="height" placeholder="160">
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

    <!-- QR Scanner Modal -->
    <div class="modal fade" id="qrScannerModal" tabindex="-1" aria-labelledby="qrScannerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="qrScannerModalLabel">
                        <i class="fas fa-qrcode me-2"></i>Scan Student QR Code
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="scanner-container mb-3">
                        <div class="scanner-video" id="modal-scanner-video">
                            <div class="scanner-placeholder">
                                <div>Camera Access Required</div>
                                <div style="font-size: 14px; margin-top: 8px;">Click "Start Scanner" to begin</div>
                            </div>
                            <div class="scanner-overlay"></div>
                        </div>

                        <div class="scanner-controls mt-3">
                            <button class="btn btn-primary" id="modal-start-btn">
                                <i class="fas fa-camera me-1"></i> Start Scanner
                            </button>
                            <button class="btn btn-secondary" id="modal-stop-btn" disabled>
                                <i class="fas fa-stop me-1"></i> Stop Scanner
                            </button>
                        </div>

                        <div class="scanner-status mt-3" id="modal-scanner-status" style="display: none;"></div>
                    </div>

                    <div class="instructions mt-4">
                        <h6><i class="fas fa-info-circle me-2"></i>Instructions</h6>
                        <ol class="text-start">
                            <li>Click "Start Scanner" to activate the camera</li>
                            <li>Position the student's QR code within the highlighted frame</li>
                            <li>Wait for automatic detection and student selection</li>
                            <li>The modal will close automatically once a student is found</li>
                        </ol>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/@zxing/library@latest"></script>
    <script>
        // Global variables
        let qrCodeReader;
        let isQRScanning = false;
        let qrVideoElement;

        // New Visit Modal Functions - Define first
        function showNewVisitModal() {
            console.log('showNewVisitModal called');
            try {
                if (typeof bootstrap === 'undefined') {
                    console.error('Bootstrap is not loaded');
                    alert('Bootstrap library not loaded. Please refresh the page.');
                    return;
                }

                const modalElement = document.getElementById('newVisitModal');
                if (!modalElement) {
                    console.error('newVisitModal element not found');
                    return;
                }
                const modal = new bootstrap.Modal(modalElement);
                modal.show();
                console.log('Modal should be showing now');
            } catch (error) {
                console.error('Error showing modal:', error);
                alert('Error opening New Visit modal. Please refresh the page and try again.');
            }
        }

        function openQRScanner() {
            try {
                const qrModal = new bootstrap.Modal(document.getElementById('qrScannerModal'));
                qrModal.show();
            } catch (error) {
                console.error('Error opening QR scanner:', error);
                alert('Error opening QR scanner. Please try again.');
            }
        }

        function selectStudent(studentId, studentName, studentNumber, gradeSection) {
            document.getElementById('selectedStudentId').value = studentId;
            
            const selectedContainer = document.getElementById('selectedStudent');
            selectedContainer.innerHTML = `
                <strong>Selected Student:</strong><br>
                <strong>${studentName}</strong><br>
                Student #: ${studentNumber} | Grade: ${gradeSection}
            `;
            selectedContainer.style.display = 'block';
            
            // Hide search results
            const studentResults = document.getElementById('studentResults');
            if (studentResults) {
                studentResults.style.display = 'none';
            }
            
            // Clear search input
            const studentSearch = document.getElementById('studentSearch');
            if (studentSearch) {
                studentSearch.value = '';
            }
            
            document.getElementById('saveVisitBtn').disabled = false;
        }

        function searchStudents(searchTerm) {
            // Make AJAX request to search students
            fetch(`/clinic-staff/students/search?q=${encodeURIComponent(searchTerm)}`)
                .then(response => response.json())
                .then(data => {
                    displayStudentResults(data.students || []);
                })
                .catch(error => {
                    console.error('Error searching students:', error);
                    displayStudentResults([]);
                });
        }

        function displayStudentResults(students) {
            const resultsContainer = document.getElementById('studentResults');
            
            if (!resultsContainer) return;
            
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

        function stopQRScanning() {
            isQRScanning = false;
            const startBtn = document.getElementById('modal-start-btn');
            const stopBtn = document.getElementById('modal-stop-btn');
            
            if (startBtn) startBtn.disabled = false;
            if (stopBtn) stopBtn.disabled = true;

            if (qrVideoElement && qrVideoElement.srcObject) {
                qrVideoElement.srcObject.getTracks().forEach(track => track.stop());
            }

            if (qrCodeReader) {
                qrCodeReader.reset();
            }

            const modalVideo = document.getElementById('modal-scanner-video');
            if (modalVideo) {
                modalVideo.innerHTML = `
                    <div class="scanner-placeholder">
                        <div>Camera Access Required</div>
                        <div style="font-size: 14px; margin-top: 8px;">Click "Start Scanner" to begin</div>
                    </div>
                    <div class="scanner-overlay"></div>
                `;
            }
        }

        function showQRStatus(message, type) {
            const status = document.getElementById('modal-scanner-status');
            if (status) {
                status.textContent = message;
                status.className = 'scanner-status ' + type;
                status.style.display = 'block';

                if (type !== 'success') {
                    setTimeout(() => {
                        status.style.display = 'none';
                    }, 5000);
                }
            }
        }

        function processQRData(qrData) {
            showQRStatus('Processing QR code...', 'success');

            fetch('{{ route("qr-process") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    qr_data: qrData
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showQRStatus('Student found! Selecting student...', 'success');
                    
                    selectStudent(
                        data.student.id, 
                        data.student.name, 
                        data.student.student_id || 'N/A', 
                        (data.student.grade_level || '') + ' ' + (data.student.section || '')
                    );
                    
                    setTimeout(() => {
                        const qrModal = bootstrap.Modal.getInstance(document.getElementById('qrScannerModal'));
                        if (qrModal) qrModal.hide();
                    }, 2000);
                } else {
                    showQRStatus('Student not found in database', 'error');
                    setTimeout(() => {
                        if (!isQRScanning) {
                            const startBtn = document.getElementById('modal-start-btn');
                            if (startBtn) startBtn.click();
                        }
                    }, 3000);
                }
            })
            .catch(error => {
                console.error('Error processing QR code:', error);
                showQRStatus('Error processing QR code', 'error');
            });
        }

        // Make functions available globally
        window.showNewVisitModal = showNewVisitModal;
        window.openQRScanner = openQRScanner;

        // Initialize when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, initializing...');

            // Initialize ZXing code reader
            try {
                qrCodeReader = new ZXing.BrowserQRCodeReader();
                console.log('QR code reader initialized');
            } catch (error) {
                console.error('Failed to initialize QR code reader:', error);
            }

            // QR Scanner event listeners
            const modalStartBtn = document.getElementById('modal-start-btn');
            const modalStopBtn = document.getElementById('modal-stop-btn');

            if (modalStartBtn) {
                modalStartBtn.addEventListener('click', async function() {
                    try {
                        isQRScanning = true;
                        modalStartBtn.disabled = true;
                        modalStopBtn.disabled = false;

                        const constraints = {
                            video: { facingMode: 'environment' }
                        };

                        const stream = await navigator.mediaDevices.getUserMedia(constraints);
                        qrVideoElement = document.createElement('video');
                        qrVideoElement.srcObject = stream;
                        qrVideoElement.setAttribute('playsinline', '');
                        qrVideoElement.play();

                        const modalVideo = document.getElementById('modal-scanner-video');
                        modalVideo.innerHTML = '';
                        modalVideo.appendChild(qrVideoElement);

                        const overlay = document.createElement('div');
                        overlay.className = 'scanner-overlay';
                        modalVideo.appendChild(overlay);

                        qrCodeReader.decodeFromVideoDevice(undefined, qrVideoElement, (result, err) => {
                            if (result) {
                                stopQRScanning();
                                processQRData(result.text);
                            }
                            if (err && !(err instanceof ZXing.NotFoundException)) {
                                console.error('QR Scanning error:', err);
                            }
                        });

                    } catch (err) {
                        console.error('Camera access error:', err);
                        showQRStatus('Error accessing camera. Please check permissions and try again.', 'error');
                        stopQRScanning();
                    }
                });
            }

            if (modalStopBtn) {
                modalStopBtn.addEventListener('click', stopQRScanning);
            }

            // Clean up when QR modal is closed
            const qrModal = document.getElementById('qrScannerModal');
            if (qrModal) {
                qrModal.addEventListener('hidden.bs.modal', stopQRScanning);
            }

            // Form submission handling
            const newVisitForm = document.getElementById('newVisitForm');
            if (newVisitForm) {
                newVisitForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    if (!document.getElementById('selectedStudentId').value) {
                        alert('Please select a student first.');
                        return;
                    }
                    
                    const saveBtn = document.getElementById('saveVisitBtn');
                    saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Creating...';
                    saveBtn.disabled = true;
                    
                    this.submit();
                });
            }

            // Student search functionality
            const studentSearchInput = document.getElementById('studentSearch');
            if (studentSearchInput) {
                studentSearchInput.addEventListener('input', function() {
                    const searchTerm = this.value.trim();
                    
                    if (searchTerm.length >= 2) {
                        searchStudents(searchTerm);
                    } else {
                        const studentResults = document.getElementById('studentResults');
                        if (studentResults) {
                            studentResults.style.display = 'none';
                        }
                    }
                });
            }

            console.log('All event listeners initialized');
        });
    </script>
</body>
</html>