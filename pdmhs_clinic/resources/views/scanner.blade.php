<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>QR Scanner - PDMHS</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #1e40af;
            --primary-dark: #1e3a8a;
            --secondary: #3b82f6;
            --accent: #60a5fa;
            --dark: #0f172a;
            --gray: #64748b;
            --light: #f1f5f9;
            --white: #ffffff;
            --success: #10b981;
            --warning: #f59e0b;
            --gradient: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to bottom right, #f8fafc, #e0f2fe);
            color: var(--dark);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Navigation */
        nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.05);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(30, 64, 175, 0.1);
        }

        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 80px;
        }

        .logo {
            font-size: 28px;
            font-weight: 800;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -1px;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .logo::before {
            content: "🏥";
            font-size: 32px;
            -webkit-text-fill-color: initial;
        }

        .nav-links {
            display: flex;
            gap: 8px;
            list-style: none;
            align-items: center;
        }

        .nav-links a {
            color: var(--gray);
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            padding: 10px 20px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .nav-links a:hover {
            color: var(--primary);
            background: var(--light);
            transform: translateY(-2px);
        }

        .nav-links a.active {
            color: var(--primary);
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        }

        /* Scanner Section */
        .scanner-section {
            padding: 140px 2rem 80px;
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
        }

        .scanner-header h1 {
            font-size: clamp(40px, 6vw, 64px);
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 24px;
            letter-spacing: -2px;
            background: linear-gradient(135deg, var(--dark) 0%, var(--primary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .scanner-header p {
            font-size: 20px;
            color: var(--gray);
            line-height: 1.8;
            max-width: 600px;
            margin: 0 auto 60px;
        }

        .scanner-container {
            background: var(--white);
            border-radius: 32px;
            padding: 60px;
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(30, 64, 175, 0.1);
            margin-bottom: 60px;
        }

        .scanner-video {
            width: 100%;
            max-width: 500px;
            height: 400px;
            background: #000;
            border-radius: 20px;
            margin: 0 auto 30px;
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
            border-radius: 20px;
        }

        .scanner-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 250px;
            height: 250px;
            border: 3px solid var(--primary);
            border-radius: 20px;
            box-shadow: 0 0 0 1000px rgba(0, 0, 0, 0.5);
        }

        .scanner-placeholder {
            color: var(--white);
            font-size: 18px;
            text-align: center;
        }

        .scanner-placeholder::before {
            content: "📱";
            font-size: 48px;
            display: block;
            margin-bottom: 16px;
        }

        .scanner-controls {
            display: flex;
            gap: 20px;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }

        .scanner-btn {
            background: var(--gradient);
            color: var(--white);
            border: none;
            padding: 16px 32px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .scanner-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(30, 64, 175, 0.3);
        }

        .scanner-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .scanner-status {
            margin-top: 30px;
            padding: 20px;
            border-radius: 12px;
            font-weight: 600;
            display: none;
        }

        .scanner-status.success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .scanner-status.error {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
            border: 1px solid rgba(245, 158, 11, 0.2);
        }

        /* Instructions */
        .instructions-section {
            background: var(--white);
            border-radius: 24px;
            padding: 60px;
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(30, 64, 175, 0.1);
        }

        .instructions-title {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 16px;
            color: var(--dark);
        }

        .instructions-list {
            list-style: none;
            padding: 0;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 24px;
            margin-top: 40px;
        }

        .instruction-item {
            display: flex;
            align-items: flex-start;
            gap: 16px;
        }

        .instruction-number {
            width: 32px;
            height: 32px;
            background: var(--gradient);
            color: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            flex-shrink: 0;
        }

        .instruction-content h4 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--dark);
        }

        .instruction-content p {
            color: var(--gray);
            line-height: 1.6;
        }

        /* Footer */
        footer {
            background: var(--dark);
            color: var(--white);
            padding: 60px 2rem 40px;
            margin-top: 120px;
        }

        .footer-content {
            max-width: 1400px;
            margin: 0 auto;
            text-align: center;
        }

        .footer-content .logo {
            color: var(--white);
            -webkit-text-fill-color: var(--white);
            margin-bottom: 20px;
            display: inline-flex;
        }

        .footer-content p {
            opacity: 0.7;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .scanner-section {
                padding: 120px 1.5rem 60px;
            }

            .scanner-container {
                padding: 40px 24px;
            }

            .scanner-video {
                height: 300px;
            }

            .scanner-overlay {
                width: 200px;
                height: 200px;
            }

            .scanner-controls {
                flex-direction: column;
                gap: 16px;
            }

            .instructions-section {
                padding: 40px 24px;
            }

            .instructions-list {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <nav>
        <div class="nav-container">
            <a href="/" class="logo">PDMHS</a>
            <ul class="nav-links">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('features') }}">Features</a></li>
                <li><a href="{{ route('scanner') }}" class="active">QR Scanner</a></li>
                <li><a href="{{ route('students.index') }}">Students</a></li>
                <li><a href="{{ route('clinic-visits.index') }}">Clinic Visits</a></li>
                <li><a href="{{ route('immunizations.index') }}">Immunizations</a></li>
                <li><a href="{{ route('health-incidents.index') }}">Health Incidents</a></li>
                <li><a href="{{ route('vitals.index') }}">Vitals</a></li>
                <li><a href="{{ route('login') }}">Login</a></li>
            </ul>
        </div>
    </nav>

    <section class="scanner-section">
        <div class="scanner-header">
            <h1>QR Code Scanner</h1>
            <p>Scan student QR codes for instant check-in and access to health records. Position the QR code within the frame for quick scanning.</p>
        </div>

        <div class="scanner-container">
            <div class="scanner-video" id="scanner-video">
                <div class="scanner-placeholder">
                    <div>Camera Access Required</div>
                    <div style="font-size: 14px; margin-top: 8px;">Click "Start Scanner" to begin</div>
                </div>
                <div class="scanner-overlay"></div>
            </div>

            <div class="scanner-controls">
                <button class="scanner-btn" id="start-btn">
                    📷 Start Scanner
                </button>
                <button class="scanner-btn" id="stop-btn" disabled>
                    ⏹️ Stop Scanner
                </button>
            </div>

            <div class="scanner-status" id="scanner-status"></div>
        </div>

        <div class="instructions-section">
            <h2 class="instructions-title">How to Use the QR Scanner</h2>

            <ul class="instructions-list">
                <li class="instruction-item">
                    <div class="instruction-number">1</div>
                    <div class="instruction-content">
                        <h4>Grant Camera Access</h4>
                        <p>Allow camera permissions when prompted to enable QR code scanning functionality.</p>
                    </div>
                </li>

                <li class="instruction-item">
                    <div class="instruction-number">2</div>
                    <div class="instruction-content">
                        <h4>Position QR Code</h4>
                        <p>Hold the student's QR code within the highlighted frame on your screen for optimal scanning.</p>
                    </div>
                </li>

                <li class="instruction-item">
                    <div class="instruction-number">3</div>
                    <div class="instruction-content">
                        <h4>Wait for Recognition</h4>
                        <p>The system will automatically detect and process the QR code, displaying student information.</p>
                    </div>
                </li>

                <li class="instruction-item">
                    <div class="instruction-number">4</div>
                    <div class="instruction-content">
                        <h4>Access Records</h4>
                        <p>Once scanned, you can view medical history, allergies, and manage clinic visits instantly.</p>
                    </div>
                </li>
            </ul>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <div class="logo">PDMHS</div>
            <p>&copy; 2025 PDMHS/WEB3NITY. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://unpkg.com/@zxing/library@latest"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const video = document.getElementById('scanner-video');
            const startBtn = document.getElementById('start-btn');
            const stopBtn = document.getElementById('stop-btn');
            const status = document.getElementById('scanner-status');
            const placeholder = document.querySelector('.scanner-placeholder');

            let codeReader;
            let isScanning = false;
            let videoElement;

            // Initialize ZXing code reader
            codeReader = new ZXing.BrowserQRCodeReader();

            startBtn.addEventListener('click', async function() {
                try {
                    isScanning = true;
                    startBtn.disabled = true;
                    stopBtn.disabled = false;
                    status.style.display = 'none';
                    placeholder.style.display = 'none';

                    // Get user media and display video
                    const constraints = {
                        video: {
                            facingMode: 'environment' // Use back camera on mobile
                        }
                    };

                    const stream = await navigator.mediaDevices.getUserMedia(constraints);
                    videoElement = document.createElement('video');
                    videoElement.srcObject = stream;
                    videoElement.setAttribute('playsinline', ''); // Required for iOS
                    videoElement.play();

                    // Clear the container and add video
                    video.innerHTML = '';
                    video.appendChild(videoElement);

                    // Start continuous scanning
                    codeReader.decodeFromVideoDevice(undefined, 'scanner-video', (result, err) => {
                        if (result) {
                            // QR code found, stop scanning
                            stopScanning();

                            // Send QR data to backend for processing
                            fetch('/qr-process', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({
                                    qr_data: result.text
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    showStatus('Student found! Redirecting to student record...', 'success');
                                    setTimeout(() => {
                                        window.location.href = data.redirect_url;
                                    }, 2000);
                                } else {
                                    showStatus('Student not found in database', 'error');
                                    // Restart scanning after error
                                    setTimeout(() => {
                                        if (!isScanning) startBtn.click();
                                    }, 3000);
                                }
                            })
                            .catch(error => {
                                console.error('Error processing QR code:', error);
                                showStatus('Error processing QR code', 'error');
                                // Restart scanning after error
                                setTimeout(() => {
                                    if (!isScanning) startBtn.click();
                                }, 3000);
                            });
                        }

                        if (err && !(err instanceof ZXing.NotFoundException)) {
                            console.error('Scanning error:', err);
                        }
                    });

                } catch (err) {
                    console.error('Camera access error:', err);
                    showStatus('Error accessing camera. Please check permissions and try again.', 'error');
                    resetScanner();
                }
            });

            stopBtn.addEventListener('click', function() {
                stopScanning();
            });

            function stopScanning() {
                isScanning = false;
                startBtn.disabled = false;
                stopBtn.disabled = true;

                // Stop the video stream
                if (videoElement && videoElement.srcObject) {
                    videoElement.srcObject.getTracks().forEach(track => track.stop());
                }

                // Reset the code reader
                if (codeReader) {
                    codeReader.reset();
                }

                // Show placeholder
                video.innerHTML = '';
                const placeholderDiv = document.createElement('div');
                placeholderDiv.className = 'scanner-placeholder';
                placeholderDiv.innerHTML = `
                    <div>Camera Access Required</div>
                    <div style="font-size: 14px; margin-top: 8px;">Click "Start Scanner" to begin</div>
                `;
                video.appendChild(placeholderDiv);
                video.appendChild(document.querySelector('.scanner-overlay'));
            }

            function resetScanner() {
                stopScanning();
                status.style.display = 'none';
            }

            function showStatus(message, type) {
                status.textContent = message;
                status.className = 'scanner-status ' + type;
                status.style.display = 'block';

                // Auto-hide after 5 seconds unless it's a success message
                if (type !== 'success') {
                    setTimeout(() => {
                        status.style.display = 'none';
                    }, 5000);
                }
            }

            // Clean up on page unload
            window.addEventListener('beforeunload', function() {
                if (codeReader) {
                    codeReader.reset();
                }
                if (videoElement && videoElement.srcObject) {
                    videoElement.srcObject.getTracks().forEach(track => track.stop());
                }
            });
        });
    </script>
</body>
</html>
