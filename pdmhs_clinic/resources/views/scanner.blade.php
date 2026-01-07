<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>QR Scanner - PDMHS Clinic</title>
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
            font-family: 'Albert Sans', sans-serif;
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
            justify-content: center;
            margin-top: 1.5rem;
        }

        .scanner-status {
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            font-family: 'Albert Sans', sans-serif;
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
            font-family: 'Albert Sans', sans-serif;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .instructions ol {
            font-family: 'Albert Sans', sans-serif;
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
            font-family: 'Albert Sans', sans-serif;
        }

        .scan-result-details {
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
                <a class="nav-link" href="{{ route('clinic-staff.visits') }}">
                    Visits
                </a>
                <a class="nav-link active" href="{{ route('scanner') }}">
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
                        {{ Auth::user()->name }}
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
                    <h1 class="page-title">QR Code Scanner</h1>
                    <p class="page-subtitle">Scan or upload student QR codes for quick identification</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-primary btn-lg" onclick="startScanning()">
                        <i class="fas fa-qrcode me-2"></i>Start Scanner
                    </button>
                    <button class="btn btn-outline-primary btn-lg" onclick="document.getElementById('qr-upload').click()">
                        <i class="fas fa-upload me-2"></i>Upload QR
                    </button>
                    <input type="file" id="qr-upload" accept="image/*" style="display: none;" onchange="processUploadedQR(event)">
                </div>
            </div>
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

            <div class="scanner-controls">
                <button class="btn btn-primary" id="start-btn">
                    <i class="fas fa-camera me-1"></i> Start Scanner
                </button>
                <button class="btn btn-secondary" id="stop-btn" disabled>
                    <i class="fas fa-stop me-1"></i> Stop Scanner
                </button>
            </div>

            <div class="scanner-status" id="scanner-status" style="display: none;"></div>
        </div>

        <!-- Instructions -->
        <div class="instructions">
            <h6><i class="fas fa-info-circle me-2"></i>How to Use the QR Scanner</h6>
            <ol>
                <li><strong>Live Scanning:</strong> Click "Start Scanner" to activate your camera, then position the student's QR code within the highlighted frame</li>
                <li><strong>Upload QR Code:</strong> Click "Upload QR" to select a QR code image file from your device</li>
                <li>Wait for automatic detection and student identification</li>
                <li>The system will automatically redirect to the student's profile</li>
                <li>If scanning fails, try manual search in the Students section</li>
            </ol>
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

            if (startBtn) startBtn.disabled = false;
            if (stopBtn) stopBtn.disabled = true;

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
                        startBtn.disabled = true;
                        stopBtn.disabled = false;

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

                        showStatus('Scanner active - position QR code in frame', 'success');

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
    </script>
</body>
</html>
