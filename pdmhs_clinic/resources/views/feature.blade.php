<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinic Services - PDMHS</title>
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

        /* Hero Section */
        .page-hero {
            padding: 140px 2rem 80px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .page-hero::before {
            content: '';
            position: absolute;
            top: -50%;
            left: 50%;
            transform: translateX(-50%);
            width: 1000px;
            height: 1000px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 0%, transparent 70%);
            border-radius: 50%;
        }

        .page-hero-content {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            color: var(--primary);
            padding: 10px 24px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 24px;
            border: 1px solid rgba(30, 64, 175, 0.2);
        }

        .hero-badge::before {
            content: "🎓";
        }

        .page-hero h1 {
            font-size: clamp(40px, 6vw, 64px);
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 24px;
            letter-spacing: -2px;
            background: linear-gradient(135deg, var(--dark) 0%, var(--primary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .page-hero p {
            font-size: 20px;
            color: var(--gray);
            line-height: 1.8;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Features Section */
        .features-section {
            padding: 80px 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 40px;
            margin-bottom: 80px;
        }

        .feature-card {
            background: var(--white);
            border-radius: 24px;
            padding: 48px;
            transition: all 0.4s ease;
            border: 1px solid rgba(30, 64, 175, 0.1);
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: var(--gradient);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }

        .feature-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 32px 64px rgba(30, 64, 175, 0.15);
            border-color: transparent;
        }

        .feature-card:hover::before {
            transform: scaleX(1);
        }

        .feature-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 24px;
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            box-shadow: 0 8px 24px rgba(59, 130, 246, 0.2);
            flex-shrink: 0;
        }

        .feature-card h3 {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 16px;
            color: var(--dark);
            letter-spacing: -0.5px;
        }

        .feature-card .description {
            color: var(--gray);
            line-height: 1.8;
            font-size: 16px;
            margin-bottom: 24px;
        }

        .feature-list {
            list-style: none;
            margin-top: 24px;
        }

        .feature-list li {
            padding: 12px 0;
            color: var(--dark);
            font-size: 15px;
            display: flex;
            align-items: start;
            gap: 12px;
            border-bottom: 1px solid var(--light);
        }

        .feature-list li:last-child {
            border-bottom: none;
        }

        .feature-list li::before {
            content: "✓";
            color: var(--success);
            font-weight: bold;
            font-size: 18px;
            flex-shrink: 0;
            width: 24px;
            height: 24px;
            background: rgba(16, 185, 129, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Benefits Section */
        .benefits-section {
            background: var(--white);
            border-radius: 32px;
            padding: 80px 60px;
            margin: 80px 0;
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(30, 64, 175, 0.1);
        }

        .section-title {
            text-align: center;
            font-size: clamp(32px, 5vw, 48px);
            font-weight: 900;
            margin-bottom: 16px;
            letter-spacing: -1.5px;
            background: linear-gradient(135deg, var(--dark) 0%, var(--primary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .section-subtitle {
            text-align: center;
            font-size: 18px;
            color: var(--gray);
            margin-bottom: 60px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 32px;
        }

        .benefit-card {
            padding: 32px;
            border-radius: 20px;
            background: linear-gradient(135deg, #f8fafc, #e0f2fe);
            border: 1px solid rgba(30, 64, 175, 0.1);
            transition: all 0.3s ease;
        }

        .benefit-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 16px 40px rgba(30, 64, 175, 0.12);
        }

        .benefit-icon {
            width: 56px;
            height: 56px;
            background: var(--gradient);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 20px;
            box-shadow: 0 8px 20px rgba(30, 64, 175, 0.3);
        }

        .benefit-card h4 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 12px;
            color: var(--dark);
        }

        .benefit-card p {
            color: var(--gray);
            line-height: 1.7;
            font-size: 15px;
        }

        /* CTA Section */
        .cta-section {
            text-align: center;
            padding: 80px 2rem;
            background: var(--gradient);
            border-radius: 32px;
            margin: 80px 0;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            border-radius: 50%;
        }

        .cta-content {
            position: relative;
            z-index: 1;
            max-width: 700px;
            margin: 0 auto;
        }

        .cta-section h2 {
            font-size: clamp(32px, 5vw, 48px);
            font-weight: 900;
            color: var(--white);
            margin-bottom: 20px;
            letter-spacing: -1.5px;
        }

        .cta-section p {
            font-size: 18px;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 40px;
            line-height: 1.8;
        }

        .cta-buttons {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 16px 32px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-white {
            background: var(--white);
            color: var(--primary);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        }

        .btn-white:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.2);
        }

        .btn-outline-white {
            background: transparent;
            color: var(--white);
            border: 2px solid var(--white);
        }

        .btn-outline-white:hover {
            background: var(--white);
            color: var(--primary);
            transform: translateY(-3px);
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
            .nav-links {
                display: none;
            }

            .page-hero {
                padding: 120px 1.5rem 60px;
            }

            .features-section {
                padding: 60px 1.5rem;
            }

            .features-grid {
                grid-template-columns: 1fr;
                gap: 24px;
            }

            .feature-card {
                padding: 32px 24px;
            }

            .benefits-section {
                padding: 60px 24px;
                margin: 60px 1.5rem;
            }

            .cta-section {
                padding: 60px 24px;
                margin: 60px 1.5rem;
            }

            .cta-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
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
                <li><a href="{{ route('features') }}" class="active">Features</a></li>
                <li><a href="{{ route('scanner') }}">QR Scanner</a></li>
                <li><a href="{{ route('students.index') }}">Students</a></li>
                <li><a href="{{ route('clinic-visits.index') }}">Clinic Visits</a></li>
                <li><a href="{{ route('immunizations.index') }}">Immunizations</a></li>
                <li><a href="{{ route('health-incidents.index') }}">Health Incidents</a></li>
                <li><a href="{{ route('vitals.index') }}">Vitals</a></li>
                <li><a href="{{ route('login') }}">Login</a></li>
            </ul>
        </div>
    </nav>

    <section class="page-hero">
        <div class="page-hero-content">
            <div class="hero-badge">School Health Excellence</div>
            <h1>PDMHS Clinic Management Services</h1>
            <p>Comprehensive healthcare management system designed specifically for high school students, ensuring their health and safety throughout their academic journey.</p>
        </div>
    </section>

    <section class="features-section">
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-header">
                    <div class="feature-icon">📋</div>
                </div>
                <h3>Activity Logging</h3>
                <p class="description">Comprehensive audit trail system tracking all user activities and system events for compliance and security.</p>
                <ul class="feature-list">
                    <li>User action tracking with detailed descriptions</li>
                    <li>IP address logging for security monitoring</li>
                    <li>Timestamp recording for chronological audit trails</li>
                    <li>Role-based activity monitoring</li>
                    <li>Automated log generation for all system interactions</li>
                    <li>Compliance-ready audit reports</li>
                </ul>
            </div>

            <div class="feature-card">
                <div class="feature-header">
                    <div class="feature-icon">👨‍🏫</div>
                </div>
                <h3>Adviser Management</h3>
                <p class="description">Complete management system for school advisers and their assignments to students for coordinated healthcare.</p>
                <ul class="feature-list">
                    <li>Adviser profile management with contact information</li>
                    <li>Student-adviser assignment tracking</li>
                    <li>Employee number and position tracking</li>
                    <li>Adviser activity status monitoring</li>
                    <li>Automated assignment notifications</li>
                    <li>Adviser-student relationship management</li>
                </ul>
            </div>

            <div class="feature-card">
                <div class="feature-header">
                    <div class="feature-icon">👨‍⚕️</div>
                </div>
                <h3>Clinic Staff Management</h3>
                <p class="description">Comprehensive management of clinic staff including roles, positions, and healthcare assignments.</p>
                <ul class="feature-list">
                    <li>Staff profile management with contact details</li>
                    <li>Position and role assignment tracking</li>
                    <li>Staff code and employee number management</li>
                    <li>Staff activity status monitoring</li>
                    <li>Medical visit assignment and tracking</li>
                    <li>Staff performance and workload management</li>
                </ul>
            </div>

            <div class="feature-card">
                <div class="feature-header">
                    <div class="feature-icon">👨‍🎓</div>
                </div>
                <h3>Student Health Records</h3>
                <p class="description">Comprehensive digital health records for all high school students with complete medical history tracking.</p>
                <ul class="feature-list">
                    <li>Complete student profiles with grade and section info</li>
                    <li>Medical history and allergy tracking</li>
                    <li>Emergency contact and blood type records</li>
                    <li>Immunization and vaccination history</li>
                    <li>Secure multi-user access with role-based permissions</li>
                    <li>Real-time health record updates</li>
                </ul>
            </div>

            <div class="feature-card">
                <div class="feature-header">
                    <div class="feature-icon">🏥</div>
                </div>
                <h3>Medical Visit Management</h3>
                <p class="description">Complete medical visit tracking system for routine check-ups, emergencies, and follow-up care.</p>
                <ul class="feature-list">
                    <li>Routine, emergency, and follow-up visit tracking</li>
                    <li>Clinic staff assignment and visit documentation</li>
                    <li>Chief complaint and detailed notes recording</li>
                    <li>Visit status tracking (Open, Closed, Referred)</li>
                    <li>Automated visit scheduling and reminders</li>
                    <li>Comprehensive visit history per student</li>
                </ul>
            </div>

            <div class="feature-card">
                <div class="feature-header">
                    <div class="feature-icon">💊</div>
                </div>
                <h3>Medication & Treatment</h3>
                <p class="description">Complete medication management system with prescription tracking and treatment documentation.</p>
                <ul class="feature-list">
                    <li>Prescription management with dosage and frequency</li>
                    <li>Medication administration tracking</li>
                    <li>Treatment procedure documentation</li>
                    <li>Medication allergy cross-referencing</li>
                    <li>Electronic prescription system</li>
                    <li>Treatment effectiveness monitoring</li>
                </ul>
            </div>

            <div class="feature-card">
                <div class="feature-header">
                    <div class="feature-icon">📏</div>
                </div>
                <h3>Vital Signs Monitoring</h3>
                <p class="description">Automated vital signs tracking with BMI calculation and health trend analysis.</p>
                <ul class="feature-list">
                    <li>Weight, height, temperature, and blood pressure tracking</li>
                    <li>Automated BMI calculation and categorization</li>
                    <li>Pulse rate and respiration monitoring</li>
                    <li>Health trend analysis over time</li>
                    <li>Growth and development tracking</li>
                    <li>Health status alerts and notifications</li>
                </ul>
            </div>

            <div class="feature-card">
                <div class="feature-header">
                    <div class="feature-icon">📱</div>
                </div>
                <h3>QR Code Integration</h3>
                <p class="description">Fast student identification and check-in system using QR codes for instant access to health records.</p>
                <ul class="feature-list">
                    <li>Unique QR code generation per student</li>
                    <li>Instant student identification and check-in</li>
                    <li>Secure QR token management with expiration</li>
                    <li>Mobile app integration for parents</li>
                    <li>Emergency access to critical health information</li>
                    <li>Automated attendance and visit logging</li>
                </ul>
            </div>

            <div class="feature-card">
                <div class="feature-header">
                    <div class="feature-icon">👨‍👩‍👧‍👦</div>
                </div>
                <h3>Parent Communication</h3>
                <p class="description">Automated notification system keeping parents informed about their child's health and clinic visits.</p>
                <ul class="feature-list">
                    <li>SMS and email notification system</li>
                    <li>Automated alerts for medical visits and treatments</li>
                    <li>Parent portal for health record access</li>
                    <li>Emergency contact management</li>
                    <li>Appointment scheduling notifications</li>
                    <li>Health status updates and reports</li>
                </ul>
            </div>
        </div>

        <div class="benefits-section">
            <h2 class="section-title">Why Schools Choose PDMHS Clinic</h2>
            <p class="section-subtitle">Trusted by educational institutions for comprehensive student health management and safety.</p>
            
            <div class="benefits-grid">
                <div class="benefit-card">
                    <div class="benefit-icon">⚡</div>
                    <h4>Lightning Fast</h4>
                    <p>Process patient check-ins in under 1 second with QR scanning technology.</p>
                </div>

                <div class="benefit-card">
                    <div class="benefit-icon">🛡️</div>
                    <h4>Secure & Private</h4>
                    <p>Bank-level encryption and HIPAA-compliant data storage for complete security.</p>
                </div>

                <div class="benefit-card">
                    <div class="benefit-icon">📱</div>
                    <h4>Mobile Ready</h4>
                    <p>Access from any device - desktop, tablet, or smartphone with responsive design.</p>
                </div>

                <div class="benefit-card">
                    <div class="benefit-icon">💰</div>
                    <h4>Cost Effective</h4>
                    <p>Reduce paperwork and administrative overhead with digital automation.</p>
                </div>

                <div class="benefit-card">
                    <div class="benefit-icon">🎯</div>
                    <h4>Easy to Use</h4>
                    <p>Intuitive interface requires minimal training for staff and doctors.</p>
                </div>

                <div class="benefit-card">
                    <div class="benefit-icon">📈</div>
                    <h4>Scalable</h4>
                    <p>Grows with your school from hundreds to thousands of students.</p>
                </div>

                <div class="benefit-card">
                    <div class="benefit-icon">🔄</div>
                    <h4>24/7 Availability</h4>
                    <p>System accessible anytime, anywhere with 99.9% uptime guarantee.</p>
                </div>

                <div class="benefit-card">
                    <div class="benefit-icon">💡</div>
                    <h4>Smart Insights</h4>
                    <p>AI-powered analytics help identify health trends and patient care patterns.</p>
                </div>

                <div class="benefit-card">
                    <div class="benefit-icon">🤝</div>
                    <h4>Dedicated Support</h4>
                    <p>Expert technical support team available to assist whenever needed.</p>
                </div>
            </div>
        </div>

        <div class="cta-section">
            <div class="cta-content">
                <h2>Ready to Transform Your School Clinic?</h2>
                <p>Join hundreds of schools already using PDMHS to streamline their student healthcare operations. Get started today with our easy setup process.</p>
                <div class="cta-buttons">
                    <a href="/login" class="btn btn-white">Get Started Now</a>
                    <a href="/architecture" class="btn btn-outline-white">View Architecture</a>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <div class="logo">PDMHS</div>
            <p>&copy; 2025 PDMHS/WEB3NITY. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
