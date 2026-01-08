<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>QR Scanner - PDMHS Clinic</title>
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
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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

        /* Page Header */
        .page-header {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(220, 220, 250, 0.95) 100%);
            backdrop-filter: blur(10px);
            border-radius: 1.5rem;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            animation: slideDown 0.5s ease;
        }
        
        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }
        
        .page-subtitle {
            color: #6b7280;
            font-size: 1.1rem;
            margin-bottom: 0;
        }

        /* QR Scanner Styles */
        .scanner-container {
            max-width: 600px;
            margin: 0 auto;
        }

        .scanner-video {
            width: 100%;
            height: 400px;
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
            width: 250px;
            height: 250px;
            border: 3px solid var(--primary);
            border-radius: 15px;
            box-shadow: 0 0 0 1000px rgba(0, 0, 0, 0.5);
        }

        .scanner-placeholder {
            color: white;
            font-size: 16px;
            text-align: center;
            font-weight: 600;
        }

        .scanner-placeholder::before {
            content: "📱";
            font-size: 50px;
            display: block;
            margin-bottom: 12px;
        }

        .scanner-controls {
            display: flex;
            gap: 1rem;
            justify-content: center !important;
            align-items: center;
            flex-wrap: wrap;
            margin-top: 1.5rem;
        }

        .scanner-status {
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            text-align: center;
            margin-top: 1rem;
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
            padding: 1.5rem;
            margin-top: 2rem;
        }

        .instructions h6 {
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .instructions ol {
            font-size: 14px;
            color: #495057;
            margin-bottom: 0;
        }

        .recent-scans {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-top: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .scan-result-item {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 0.5rem;
            background: #f8f9fa;
        }

        .scan-result-name {
            font-weight: 600;
            color: #212529;
            margin-bottom: 2px;
        }

        .scan-result-details {
            font-size: 12px;
            color: #6c757d;
            font-weight: 600;
        }

        /* Custom Button Styles */
        .btn-primary {
            background: var(--primary) !important;
            border-color: var(--primary) !important;
            color: white !important;
        }

        .btn-primary:hover {
            background: var(--primary-dark) !important;
            border-color: var(--primary-dark) !important;
        }

        .btn-outline-primary {
            background: transparent !important;
            border-color: var(--primary) !important;
            color: var(--primary) !important;
        }

        .btn-outline-primary:hover {
            background: var(--primary) !important;
            border-color: var(--primary) !important;
            color: white !important;
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
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a class="navbar-brand" href="{{ Auth::user()->role === 'adviser' ? route('adviser.dashboard') : route('clinic-staff.dashboard') }}">
                <i class="fas fa-heartbeat"></i>
                PDMHS Clinic
            </a>
            <ul class="navbar-menu">
                @if(Auth::user()->role === 'adviser')
                    <li><a class="nav-link" href="{{ route('adviser.dashboard') }}"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
                    <li><a class="nav-link" href="{{ route('adviser.my-students') }}"><i class="fas fa-users"></i>My Students</a></li>
                    <li><a class="nav-link active" href="{{ route('adviser.scanner') }}"><i class="fas fa-qrcode"></i>Scanner</a></li>
                @else
                    <li><a class="nav-link" href="{{ route('clinic-staff.dashboard') }}"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
                    <li><a class="nav-link" href="{{ route('clinic-staff.students') }}"><i class="fas fa-users"></i>Students</a></li>
                    <li><a class="nav-link" href="{{ route('clinic-staff.visits') }}"><i class="fas fa-calendar-check"></i>Visits</a></li>
                    <li><a class="nav-link active" href="{{ route('scanner') }}"><i class="fas fa-qrcode"></i>Scanner</a></li>
                    <li><a class="nav-link" href="{{ route('clinic-staff.reports') }}"><i class="fas fa-chart-bar"></i>Reports</a></li>
                @endif
            </ul>
            <div class="user-dropdown">
                <button class="user-btn" onclick="toggleDropdown()">
                    @if(Auth::user()->profile_picture && file_exists(public_path(Auth::user()->profile_picture)))
                        <img src="{{ asset(Auth::user()->profile_picture) }}" alt="Profile" class="user-avatar">
                    @else
                        <div class="user-avatar-default">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif
                    <span>{{ Auth::user()->name }}</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="dropdown-menu" id="userDropdown">
                    <a class="dropdown-item" href="{{ Auth::user()->role === 'adviser' ? route('adviser.profile') : route('clinic-staff.profile') }}">
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
            <h1 class="page-title">QR Code Scanner</h1>
            <p class="page-subtitle">Scan or upload student QR codes for quick identification</p>
        </div>

        <!-- Scanner Section -->
        <div class="scanner-container">
            <div class="scanner-video" id="scanner-video">
                <div class="scanner-placeholder">
                    <div>Camera Access Required</div>
                    <div style="font-size: 14px; margin-top: 8px;">Click "Start Scanner" to begin</div>
                </div>
                <div class="scanner-overlay"></div>
            </div>

            <div class="scanner-controls" style="display: flex; justify-content: center; align-items: center; text-align: center;">
                <button class="btn btn-primary" id="start-btn">
                    <i class="fas fa-camera me-1"></i> Start Scanner
                </button>
                <button class="btn btn-secondary" id="stop-btn" style="display: none;">
                    <i class="fas fa-stop me-1"></i> Stop Scanner
                </button>
                <button class="btn btn-outline-primary" onclick="document.getElementById('qr-upload').click()" style="display: none;">
                    <i class="fas fa-upload me-1"></i> Upload QR
                </button>
                <input type="file" id="qr-upload" accept="image/*" style="display: none;" onchange="processUploadedQR(event)">
            </div>

            <div class="scanner-status" id="scanner-status" style="display: none;"></div>
        </div>

        <!-- Recent Scans (placeholder for now) -->
        <div class="recent-scans">
            <h6 class="mb-3"><i class="fas fa-history me-2"></i>Recent Scans</h6>
            <div id="recent-scans-list">
                <div class="text-center text-muted py-4">
                    <i class="fas fa-history fa-2x mb-2"></i>
                    <p>No recent scans</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/@zxing/library@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>
    <script>
        // Global variables
        let qrCodeReader;
        let isQRScanning = false;
        let qrVideoElement;

        // Initialize ZXing code reader
        try {
            qrCodeReader = new ZXing.BrowserQRCodeReader();
            console.log('QR code reader initialized');
        } catch (error) {
            console.error('Failed to initialize QR code reader:', error);
            showStatus('Error initializing scanner. Please refresh the page.', 'error');
        }

        function startScanning() {
            document.getElementById('start-btn').click();
        }

        async function processUploadedQR(event) {
            const file = event.target.files[0];
            if (!file) return;

            console.log('Processing uploaded QR code file:', file);
            showStatus('Processing uploaded QR code...', 'success');

            try {
                // Create an image element to load the file
                const img = new Image();

                img.onload = function() {
                    console.log('Image loaded, dimensions:', img.width, 'x', img.height);
                    try {
                        // Create canvas to get image data
                        const canvas = document.createElement('canvas');
                        const ctx = canvas.getContext('2d');

                        // Set canvas size to image size
                        canvas.width = img.width;
                        canvas.height = img.height;

                        // Draw image to canvas
                        ctx.drawImage(img, 0, 0);

                        // Get image data
                        const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                        console.log('Image data extracted, size:', imageData.width, 'x', imageData.height);

                        // Check if jsQR is available
                        if (typeof jsQR === 'undefined') {
                            console.error('jsQR library not loaded');
                            showStatus('QR decoding library not available. Please refresh the page.', 'error');
                            return;
                        }

                        // Use jsQR to decode the QR code
                        console.log('Attempting to decode QR code with jsQR...');
                        const code = jsQR(imageData.data, imageData.width, imageData.height);

                        if (code) {
                            console.log('QR code decoded successfully:', code.data);
                            processQRData(code.data, 'upload');
                        } else {
                            console.log('No QR code found in image');
                            showStatus('No QR code found in the uploaded image. Please ensure the image contains a clear QR code.', 'error');
                        }
                    } catch (decodeError) {
                        console.error('QR decode error:', decodeError);
                        showStatus('Unable to decode QR code from image. Please ensure it contains a valid QR code.', 'error');
                    }
                };

                img.onerror = function() {
                    console.error('Error loading image');
                    showStatus('Error loading image. Please try a different file.', 'error');
                };

                // Load the image from the file
                const reader = new FileReader();
                reader.onload = function(e) {
                    console.log('File loaded as data URL');
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);

            } catch (error) {
                console.error('Error processing uploaded QR:', error);
                showStatus('Error processing uploaded QR code', 'error');
            }

            // Reset the file input
            event.target.value = '';
        }

        function showStatus(message, type) {
            const status = document.getElementById('scanner-status');
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

        function stopQRScanning() {
            isQRScanning = false;
            const startBtn = document.getElementById('start-btn');
            const stopBtn = document.getElementById('stop-btn');

            if (startBtn) startBtn.style.display = 'inline-block';
            if (stopBtn) stopBtn.style.display = 'none';

            if (qrVideoElement && qrVideoElement.srcObject) {
                qrVideoElement.srcObject.getTracks().forEach(track => track.stop());
            }

            if (qrCodeReader) {
                qrCodeReader.reset();
            }

            const scannerVideo = document.getElementById('scanner-video');
            if (scannerVideo) {
                scannerVideo.innerHTML = `
                    <div class="scanner-placeholder">
                        <div>Camera Access Required</div>
                        <div style="font-size: 14px; margin-top: 8px;">Click "Start Scanner" to begin</div>
                    </div>
                    <div class="scanner-overlay"></div>
                `;
            }
        }

        function processQRData(qrData, source = 'live_scan') {
            showStatus('Processing QR code...', 'success');

            fetch('{{ route("qr-process") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    qr_data: qrData,
                    source: source
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showStatus('Student found! Redirecting...', 'success');

                    // Add to recent scans
                    addRecentScan(data.student);

                    setTimeout(() => {
                        window.location.href = data.redirect_url;
                    }, 1500);
                } else {
                    showStatus('Student not found in database', 'error');
                    setTimeout(() => {
                        if (!isQRScanning) {
                            document.getElementById('start-btn').click();
                        }
                    }, 3000);
                }
            })
            .catch(error => {
                console.error('Error processing QR code:', error);
                showStatus('Error processing QR code', 'error');
            });
        }

        function addRecentScan(student) {
            const recentScansList = document.getElementById('recent-scans-list');
            const timestamp = new Date().toLocaleString();

            const scanItem = document.createElement('div');
            scanItem.className = 'scan-result-item';
            scanItem.innerHTML = `
                <div class="scan-result-name">${student.name}</div>
                <div class="scan-result-details">
                    Student #: ${student.student_id || 'N/A'} |
                    Scanned: ${timestamp}
                </div>
            `;

            // Remove existing "no recent scans" message
            const noScansMsg = recentScansList.querySelector('.text-center');
            if (noScansMsg) {
                noScansMsg.remove();
            }

            // Add new scan at the top
            recentScansList.insertBefore(scanItem, recentScansList.firstChild);

            // Keep only last 5 scans
            const items = recentScansList.querySelectorAll('.scan-result-item');
            if (items.length > 5) {
                items[items.length - 1].remove();
            }
        }

        // Event listeners
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Scanner page loaded');

            const startBtn = document.getElementById('start-btn');
            const stopBtn = document.getElementById('stop-btn');

            if (startBtn) {
                startBtn.addEventListener('click', async function() {
                    try {
                        isQRScanning = true;
                        startBtn.style.display = 'none';
                        stopBtn.style.display = 'inline-block';

                        const constraints = {
                            video: { facingMode: 'environment' }
                        };

                        const stream = await navigator.mediaDevices.getUserMedia(constraints);
                        qrVideoElement = document.createElement('video');
                        qrVideoElement.srcObject = stream;
                        qrVideoElement.setAttribute('playsinline', '');
                        qrVideoElement.play();

                        const scannerVideo = document.getElementById('scanner-video');
                        scannerVideo.innerHTML = '';
                        scannerVideo.appendChild(qrVideoElement);

                        const overlay = document.createElement('div');
                        overlay.className = 'scanner-overlay';
                        scannerVideo.appendChild(overlay);

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
                        showStatus('Error accessing camera. Please check permissions and try again.', 'error');
                        stopQRScanning();
                    }
                });
            }

            if (stopBtn) {
                stopBtn.addEventListener('click', stopQRScanning);
            }

            // Auto-dismiss alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });

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
    </script>
</body>
</html>
