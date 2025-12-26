<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:wght@400;500;600;800&display=swap" rel="stylesheet">
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
        
        .dropdown-menu .dropdown-item {
            font-family: 'Epilogue', sans-serif !important;
            font-size: 20px !important;
            font-weight: 500 !important;
        }
        
        .page-container {
            max-width: 900px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        
        .profile-section {
            background: white;
            border-radius: 16px;
            padding: 3rem 2rem;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            border: 1px solid rgba(30, 64, 175, 0.1);
        }
        
        .form-container {
            background: var(--gradient);
            border-radius: 16px;
            padding: 3rem 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 12px 35px rgba(30, 64, 175, 0.2);
        }
        
        .form-section {
            background: white;
            border-radius: 16px;
            padding: 2.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border: 1px solid rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        
        .form-section:hover {
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }
        
        .profile-picture-section {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 2px solid rgba(30, 64, 175, 0.1);
        }
        
        .profile-picture-container {
            position: relative;
            display: inline-block;
            margin-bottom: 1.5rem;
        }
        
        .profile-picture {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #fff;
            box-shadow: 0 8px 25px rgba(30, 64, 175, 0.2);
            transition: all 0.3s ease;
        }
        
        .profile-picture:hover {
            transform: scale(1.05);
            box-shadow: 0 12px 35px rgba(30, 64, 175, 0.3);
        }
        
        .default-avatar {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: var(--gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 4.5rem;
            border: 5px solid #fff;
            box-shadow: 0 8px 25px rgba(30, 64, 175, 0.2);
            margin: 0 auto 1.5rem;
            transition: all 0.3s ease;
        }
        
        .default-avatar:hover {
            transform: scale(1.05);
            box-shadow: 0 12px 35px rgba(30, 64, 175, 0.3);
        }
        
        .upload-btn {
            background: var(--gradient);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            font-family: 'Albert Sans', sans-serif;
            font-weight: 700;
            font-size: 20px;
            margin-top: 1rem;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(30, 64, 175, 0.3);
            transition: all 0.3s ease;
        }
        
        .upload-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(30, 64, 175, 0.4);
        }
        
        .form-row {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .form-group {
            flex: 1;
        }
        
        .form-label {
            font-family: 'Albert Sans', sans-serif !important;
            font-weight: 700 !important;
            font-size: 25px !important;
            color: #495057;
            margin-bottom: 0.5rem;
        }
        
        .form-control, .form-select {
            border: 2px solid #e8ecf4;
            border-radius: 12px;
            padding: 1rem;
            font-size: 1rem;
            background-color: #fafbfc;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(30, 64, 175, 0.15);
            background-color: white;
            transform: translateY(-1px);
        }
        
        .form-control.is-invalid, .form-select.is-invalid {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.15);
        }
        
        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875rem;
            color: #dc3545;
        }
        
        .textarea-large {
            min-height: 100px;
            resize: vertical;
        }
        
        .btn-edit {
            background: var(--gradient);
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-family: 'Albert Sans', sans-serif;
            font-weight: 700;
            font-size: 20px;
        }
        
        .btn-edit:hover {
            background: var(--primary-dark);
            color: white;
        }
        
        .btn-password {
            background: var(--gradient);
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-family: 'Albert Sans', sans-serif;
            font-weight: 700;
            font-size: 20px;
        }
        
        .btn-password:hover {
            background: var(--primary-dark);
            color: white;
        }
        
        .btn-qr {
            background: var(--gradient);
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-family: 'Albert Sans', sans-serif;
            font-weight: 700;
            font-size: 20px;
        }
        
        .btn-qr:hover {
            background: var(--primary-dark);
            color: white;
        }
        
        .alert {
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }
        
        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
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
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Error!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Profile Picture Section -->
        <div class="profile-section">
            <h2 class="mb-4" style="font-family: 'Albert Sans', sans-serif; font-weight: 700; font-size: 28px; color: #495057; text-align: center;">Profile Settings</h2>
            <div class="profile-picture-section">
                <div class="profile-picture-container">
                    @if($user->profile_picture && file_exists(public_path($user->profile_picture)))
                        <img src="{{ asset($user->profile_picture) }}" alt="Profile Picture" class="profile-picture" id="profileImage">
                    @else
                        <div class="default-avatar" id="profileImage">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif
                </div>
                <div>
                    <button type="button" class="upload-btn" onclick="document.getElementById('profilePictureInput').click()">
                        <i class="fas fa-camera me-1"></i>Change Photo
                    </button>
                    <input type="file" id="profilePictureInput" accept="image/*" style="display: none;" onchange="uploadProfilePicture(this)">
                </div>
            </div>
        </div>

        <!-- Profile Edit Form -->
        <div class="form-container">
            <form method="POST" action="{{ route('student.profile.update') }}">
                @csrf
                @method('PUT')
                
                <!-- Personal Information Section -->
                <div class="form-section">
                    <!-- Name Fields -->
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name', $student->first_name ?? 'Hannah Lorraine') }}" required>
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Middle Name</label>
                            <input type="text" class="form-control @error('middle_name') is-invalid @enderror" name="middle_name" value="{{ old('middle_name', $student->middle_name ?? '') }}">
                            @error('middle_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name', $student->last_name ?? 'Geronday') }}" required>
                            @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Student Number, Gender, Birthday -->
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Student Number</label>
                            <input type="text" class="form-control" value="{{ $student->student_id ?? '000001' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Gender</label>
                            <select class="form-select @error('gender') is-invalid @enderror" name="gender">
                                <option value="">Select Gender</option>
                                <option value="M" {{ old('gender', $student->gender ?? '') == 'M' ? 'selected' : '' }}>Male</option>
                                <option value="F" {{ old('gender', $student->gender ?? 'F') == 'F' ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Birthday</label>
                            <input type="date" class="form-control @error('birth_date') is-invalid @enderror" name="birth_date" value="{{ old('birth_date', $student->date_of_birth ?? '2005-04-01') }}">
                            @error('birth_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Academic Information Section -->
                <div class="form-section">
                    <!-- Grade Level, Section, Blood Type -->
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Grade Level</label>
                            <input type="text" class="form-control @error('grade_level') is-invalid @enderror" name="grade_level" value="{{ old('grade_level', $student->grade_level ?? '12') }}">
                            @error('grade_level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Section</label>
                            <input type="text" class="form-control @error('section') is-invalid @enderror" name="section" value="{{ old('section', $student->section ?? 'STEM 1') }}">
                            @error('section')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Blood Type</label>
                            <select class="form-select @error('blood_type') is-invalid @enderror" name="blood_type">
                                <option value="">Select Blood Type</option>
                                <option value="A+" {{ old('blood_type', $student->blood_type ?? 'O+') == 'A+' ? 'selected' : '' }}>A+</option>
                                <option value="A-" {{ old('blood_type', $student->blood_type ?? '') == 'A-' ? 'selected' : '' }}>A-</option>
                                <option value="B+" {{ old('blood_type', $student->blood_type ?? '') == 'B+' ? 'selected' : '' }}>B+</option>
                                <option value="B-" {{ old('blood_type', $student->blood_type ?? '') == 'B-' ? 'selected' : '' }}>B-</option>
                                <option value="AB+" {{ old('blood_type', $student->blood_type ?? '') == 'AB+' ? 'selected' : '' }}>AB+</option>
                                <option value="AB-" {{ old('blood_type', $student->blood_type ?? '') == 'AB-' ? 'selected' : '' }}>AB-</option>
                                <option value="O+" {{ old('blood_type', $student->blood_type ?? 'O+') == 'O+' ? 'selected' : '' }}>O+</option>
                                <option value="O-" {{ old('blood_type', $student->blood_type ?? '') == 'O-' ? 'selected' : '' }}>O-</option>
                            </select>
                            @error('blood_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Contact Information Section -->
                <div class="form-section">
                    <!-- Email and Phone -->
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email ?? 'loraineh540@gmail.com') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Phone Number</label>
                            <input type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number', $student->contact_number ?? '09923603742') }}">
                            @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Address</label>
                            <textarea class="form-control textarea-large @error('address') is-invalid @enderror" name="address" rows="3">{{ old('address', $student->address ?? 'Test Address Update') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Emergency Contact -->
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Emergency Contact</label>
                            <input type="text" class="form-control @error('emergency_contact') is-invalid @enderror" name="emergency_contact" value="{{ old('emergency_contact', $student->emergency_contact ?? 'Parent: 09123456789') }}">
                            @error('emergency_contact')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Button and Additional Actions -->
                <div class="form-section">
                    <div class="d-flex justify-content-between align-items-center">
                        <button type="submit" class="btn btn-edit">
                            <i class="fas fa-save me-1"></i>Edit Profile
                        </button>
                        
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-password" onclick="showPasswordModal()">
                                <i class="fas fa-key me-1"></i>Change Password
                            </button>
                            <button type="button" class="btn btn-qr" onclick="showQRModal()">
                                <i class="fas fa-qrcode me-1"></i>View QR Code
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Password Modal -->
    <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="passwordModalLabel">
                        <i class="fas fa-key me-2"></i>Change Password
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="passwordForm" method="POST" action="{{ route('student.password.update') }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Current Password</label>
                            <input type="password" class="form-control" name="current_password" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" name="password_confirmation" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save me-1"></i>Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- QR Code Modal -->
    <div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qrModalLabel">
                        <i class="fas fa-qrcode me-2"></i>Your QR Code
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="mb-3">
                        <p class="text-muted">Scan this QR code for quick access to your student information</p>
                    </div>
                    <div class="qr-code-container mb-3">
                        <div id="qrcode" class="d-flex justify-content-center"></div>
                    </div>
                    <div class="student-info">
                        <h6 class="fw-bold">{{ $user->name }}</h6>
                        <p class="text-muted mb-1">Student ID: {{ $student->student_id ?? '000001' }}</p>
                        <p class="text-muted">{{ $student->grade_level ?? '12' }} - {{ $student->section ?? 'STEM 1' }}</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-info" onclick="downloadQR()">
                        <i class="fas fa-download me-1"></i>Download QR
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>
    <script>
        function showPasswordModal() {
            const passwordModal = new bootstrap.Modal(document.getElementById('passwordModal'));
            passwordModal.show();
        }
        
        function showQRModal() {
            const qrModal = new bootstrap.Modal(document.getElementById('qrModal'));
            generateQRCode();
            qrModal.show();
        }
        
        function generateQRCode() {
            const qrContainer = document.getElementById('qrcode');
            qrContainer.innerHTML = ''; // Clear previous QR code
            
            const studentData = {
                name: '{{ $user->name }}',
                student_id: '{{ $student->student_id ?? "000001" }}',
                grade_level: '{{ $student->grade_level ?? "12" }}',
                section: '{{ $student->section ?? "STEM 1" }}',
                email: '{{ $user->email }}'
            };
            
            const qrText = JSON.stringify(studentData);
            
            QRCode.toCanvas(qrText, { width: 200, height: 200 }, function (error, canvas) {
                if (error) {
                    console.error(error);
                    qrContainer.innerHTML = '<p class="text-danger">Error generating QR code</p>';
                } else {
                    qrContainer.appendChild(canvas);
                }
            });
        }
        
        function downloadQR() {
            const canvas = document.querySelector('#qrcode canvas');
            if (canvas) {
                const link = document.createElement('a');
                link.download = 'student-qr-code.png';
                link.href = canvas.toDataURL();
                link.click();
            }
        }

        function uploadProfilePicture(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                
                // Validate file type
                if (!file.type.startsWith('image/')) {
                    alert('Please select a valid image file.');
                    return;
                }
                
                // Validate file size (max 5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('File size must be less than 5MB.');
                    return;
                }
                
                const formData = new FormData();
                formData.append('profile_picture', file);
                
                // Get CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (csrfToken) {
                    formData.append('_token', csrfToken.getAttribute('content'));
                } else {
                    console.error('CSRF token not found');
                    alert('Security token not found. Please refresh the page.');
                    return;
                }
                
                // Show loading state
                const uploadBtn = document.querySelector('.upload-btn');
                const originalText = uploadBtn.innerHTML;
                uploadBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Uploading...';
                uploadBtn.disabled = true;
                
                console.log('Starting upload...');
                
                fetch('/student/upload-profile-picture', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    if (data.success) {
                        // Update profile picture
                        const profileImage = document.getElementById('profileImage');
                        if (profileImage.tagName === 'IMG') {
                            profileImage.src = data.profile_picture_url;
                        } else {
                            // Replace default avatar with image
                            profileImage.outerHTML = `<img src="${data.profile_picture_url}" alt="Profile Picture" class="profile-picture" id="profileImage">`;
                        }
                        
                        // Show success message
                        showAlert('Profile picture updated successfully!', 'success');
                    } else {
                        showAlert(data.message || 'Failed to upload profile picture.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('An error occurred while uploading the profile picture.', 'error');
                })
                .finally(() => {
                    // Reset button state
                    uploadBtn.innerHTML = originalText;
                    uploadBtn.disabled = false;
                });
            }
        }
        
        function showAlert(message, type) {
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';
            
            const alertHtml = `
                <div class="alert ${alertClass} alert-dismissible fade show mb-4" role="alert">
                    <i class="fas ${iconClass} me-2"></i>
                    <strong>${type === 'success' ? 'Success!' : 'Error!'}</strong> ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            
            const container = document.querySelector('.page-container');
            container.insertAdjacentHTML('afterbegin', alertHtml);
            
            // Auto-dismiss after 5 seconds
            setTimeout(() => {
                const alert = container.querySelector('.alert');
                if (alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            }, 5000);
        }
    </script>
</body>
</html>