<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDMHS Clinic Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
            font-family: 'Epilogue', sans-serif;
            line-height: 1.6;
            color: var(--dark);
            overflow-x: hidden;
        }

        /* Navigation */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background: linear-gradient(135deg, #1877f2 0%, #42a5f5 100%);
            border-bottom: 1px solid rgba(30, 64, 175, 0.1);
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            background: linear-gradient(135deg, #1877f2 0%, #42a5f5 100%);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 80px;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: white;
            font-weight: 600;
            font-size: 25px;
            font-family: 'Epilogue', sans-serif;
            transition: color 0.3s ease;
        }

        .nav-links a:hover {
            color: rgba(255, 255, 255, 0.8);
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            background: linear-gradient(rgba(255, 255, 255, 0.7), rgba(255, 255, 255, 0.7)), url('/pdmhs.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 0 2rem;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><radialGradient id="a" cx="50%" cy="50%" r="50%"><stop offset="0%" stop-color="%231e40af" stop-opacity="0.1"/><stop offset="100%" stop-color="%231e40af" stop-opacity="0"/></radialGradient></defs><circle cx="200" cy="200" r="100" fill="url(%23a)"/><circle cx="800" cy="300" r="150" fill="url(%23a)"/><circle cx="400" cy="700" r="120" fill="url(%23a)"/></svg>') no-repeat center center;
            background-size: cover;
            opacity: 0.5;
        }

        .hero-content {
            max-width: 800px;
            z-index: 1;
            position: relative;
        }

        .hero h1 {
            font-size: 70px;
            font-weight: 800;
            margin-bottom: 1.5rem;
            color: #1877f2;
            line-height: 1.2;
        }

        .hero p {
            font-size: 23px;
            font-weight: 700;
            color: var(--gray);
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 1rem 2rem;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: var(--gradient);
            color: var(--white);
            box-shadow: 0 8px 24px rgba(30, 64, 175, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(30, 64, 175, 0.4);
        }

        .btn-secondary {
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-secondary:hover {
            background: var(--primary);
            color: var(--white);
            transform: translateY(-3px);
        }

        .btn-sm {
            padding: 0.6rem 1.5rem;
            font-size: 0.9rem;
        }

        /* Health Tips Carousel */
        .health-tips {
            padding: 5rem 2rem;
            background: #1877f2;
        }

        .tips-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .carousel {
            position: relative;
            max-width: 800px;
            margin: 0 auto;
            padding: 0 60px;
        }

        .carousel-track {
            overflow: hidden;
            position: relative;
            height: 300px;
        }

        .tip-card {
            position: absolute;
            width: 100%;
            background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 100%);
            padding: 3rem;
            border-radius: 20px;
            text-align: center;
            opacity: 0;
            transform: translateX(100%);
            transition: all 0.5s ease;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .tip-card.active {
            opacity: 1;
            transform: translateX(0);
        }

        .tip-card.prev {
            transform: translateX(-100%);
        }

        .tip-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .tip-card h3 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .tip-card p {
            font-size: 1.1rem;
            color: var(--gray);
            line-height: 1.6;
        }

        .carousel-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: var(--gradient);
            color: var(--white);
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .carousel-btn:hover {
            transform: translateY(-50%) scale(1.1);
            box-shadow: 0 8px 24px rgba(30, 64, 175, 0.3);
        }

        .carousel-btn.prev {
            left: 0;
        }

        .carousel-btn.next {
            right: 0;
        }

        .carousel-dots {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 2rem;
        }

        .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--light);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .dot.active {
            background: var(--primary);
            width: 30px;
            border-radius: 6px;
        }

        /* Educational Articles */
        .educational-articles {
            padding: 5rem 2rem;
            background: #1877f2;
        }

        .articles-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .articles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
        }

        .article-card {
            background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 100%);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            text-decoration: none;
            display: block;
        }

        .article-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.15);
        }

        .article-image {
            background: #1877f2;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 4rem;
        }

        .article-content {
            padding: 2rem;
        }

        .article-category {
            display: inline-block;
            background: var(--primary);
            color: var(--white);
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .article-content h3 {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 0.8rem;
            color: var(--dark);
        }

        .article-content p {
            color: var(--gray);
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .read-more {
            color: var(--primary);
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: gap 0.3s ease;
        }

        .article-card:hover .read-more {
            gap: 1rem;
        }

        /* How It Works Section */
        .how-it-works {
            padding: 5rem 2rem;
            background: #1877f2;
        }

        .how-it-works-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            position: relative;
        }

        .step-card {
            background: var(--white);
            padding: 2.5rem 2rem;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 2px solid transparent;
            transition: all 0.3s ease;
            position: relative;
        }

        .step-card:hover {
            transform: translateY(-8px);
            border-color: var(--primary);
            box-shadow: 0 16px 48px rgba(30, 64, 175, 0.2);
        }

        .step-number {
            position: absolute;
            top: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 40px;
            background: #1877f2;
            color: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: 800;
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
        }

        .step-icon {
            width: 80px;
            height: 80px;
            background: #1877f2;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 1.5rem auto 1.5rem;
            transition: all 0.3s ease;
        }

        .step-card:hover .step-icon {
            background: #1877f2;
            transform: scale(1.1) rotate(5deg);
        }

        .step-icon i {
            font-size: 2.5rem;
            color: white;
            transition: all 0.3s ease;
        }

        .step-card:hover .step-icon i {
            color: var(--white);
        }

        .step-card h3 {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1rem;
        }

        .step-card p {
            color: var(--gray);
            line-height: 1.6;
            font-size: 1rem;
        }

        .step-arrow {
            position: absolute;
            right: -30px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 2rem;
            color: var(--primary);
            opacity: 0.3;
        }

        .step-card:last-child .step-arrow {
            display: none;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
            animation: fadeIn 0.3s ease;
        }

        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: var(--white);
            border-radius: 24px;
            max-width: 950px;
            width: 95%;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
            animation: slideUp 0.4s ease;
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(30, 64, 175, 0.1);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .close-modal {
            position: absolute;
            right: 24px;
            top: 24px;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--gray);
            cursor: pointer;
            transition: all 0.3s ease;
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: var(--light);
            z-index: 10;
            border: 2px solid transparent;
        }

        .close-modal:hover {
            background: #ef4444;
            color: var(--white);
            transform: rotate(90deg);
            border-color: #dc2626;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .modal-body {
            padding: 0;
        }

        .modal-header-section {
            background: #1877f2;
            padding: 3.5rem 4rem 3rem;
            text-align: center;
            border-radius: 24px 24px 0 0;
        }

        .modal-icon {
            width: 90px;
            height: 90px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            animation: pulse 2s ease-in-out infinite;
            border: 3px solid rgba(255, 255, 255, 0.3);
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        .modal-icon i {
            font-size: 3rem;
            color: var(--white);
        }

        .modal-header-section h2 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            color: white;
            line-height: 1.3;
        }

        .modal-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
            font-weight: 500;
            margin: 0;
        }

        .modal-intro {
            padding: 2.5rem 4rem;
            background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 100%);
        }

        .modal-intro p {
            font-size: 1.15rem;
            color: #475569;
            line-height: 1.8;
            margin: 0;
            text-align: center;
            font-weight: 600;
        }

        .modal-features {
            padding: 3rem 4rem;
            display: grid;
            gap: 1.8rem;
        }

        .feature-item {
            display: flex;
            gap: 1.5rem;
            align-items: flex-start;
            padding: 1.5rem;
            background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
            border-radius: 16px;
            border: 2px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .feature-item:hover {
            border-color: #4f46e5;
            transform: translateX(8px);
            box-shadow: 0 8px 24px rgba(79, 70, 229, 0.15);
        }

        .feature-icon-small {
            width: 55px;
            height: 55px;
            background: #1877f2;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(24, 119, 242, 0.3);
        }

        .feature-icon-small i {
            font-size: 1.4rem;
            color: var(--white);
        }

        .feature-text h4 {
            font-size: 1.15rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.4rem;
        }

        .feature-text p {
            font-size: 1rem;
            color: #64748b;
            line-height: 1.7;
            margin: 0;
        }

        .modal-mission {
            padding: 3rem 4rem;
            background: #1877f2;
            text-align: center;
            border-top: 4px solid #1877f2;
            border-bottom: 4px solid #1877f2;
            position: relative;
            overflow: hidden;
        }

        .modal-mission::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="10" cy="10" r="2" fill="%23ffffff" opacity="0.1"/><circle cx="90" cy="20" r="3" fill="%23ffffff" opacity="0.1"/><circle cx="50" cy="90" r="2" fill="%23ffffff" opacity="0.1"/></svg>');
            pointer-events: none;
        }

        .mission-icon {
            font-size: 4rem;
            margin-bottom: 1.2rem;
            display: inline-block;
            animation: glow 2s ease-in-out infinite;
            filter: drop-shadow(0 4px 8px rgba(255, 255, 255, 0.3));
        }

        @keyframes glow {
            0%, 100% {
                transform: scale(1);
                filter: drop-shadow(0 4px 8px rgba(255, 255, 255, 0.3));
            }
            50% {
                transform: scale(1.1);
                filter: drop-shadow(0 8px 16px rgba(255, 255, 255, 0.5));
            }
        }

        .modal-mission h3 {
            font-size: 1.8rem;
            font-weight: 800;
            color: white;
            margin-bottom: 1.2rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
        }

        .modal-mission h3::after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, transparent, white, transparent);
            margin: 0.8rem auto 0;
            border-radius: 2px;
        }

        .modal-mission p {
            font-size: 1.1rem;
            color: white;
            line-height: 1.8;
            margin: 0;
            font-weight: 700;
        }

        .modal-benefits {
            padding: 3rem 4rem;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        }

        .benefits-title {
            text-align: center;
            font-size: 1.8rem;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 2.5rem;
            position: relative;
        }

        .benefits-title::after {
            content: '';
            display: block;
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, transparent, #4f46e5, transparent);
            margin: 1rem auto 0;
            border-radius: 2px;
        }

        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
        }

        .benefit-card {
            background: var(--white);
            padding: 2rem;
            border-radius: 16px;
            text-align: center;
            border: 2px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .benefit-card:hover {
            border-color: #1877f2;
            transform: translateY(-5px);
            box-shadow: 0 12px 32px rgba(24, 119, 242, 0.2);
        }

        .benefit-icon {
            width: 80px;
            height: 80px;
            background: #1877f2;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2.5rem;
            color: white;
            box-shadow: 0 8px 24px rgba(24, 119, 242, 0.3);
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        .benefit-card h4 {
            font-size: 1.2rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.8rem;
        }

        .benefit-card p {
            font-size: 0.95rem;
            color: #64748b;
            line-height: 1.6;
            margin: 0;
        }

        .modal-stats {
            padding: 3rem 4rem;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
            background: var(--white);
            border-radius: 0 0 24px 24px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 2.8rem;
            font-weight: 800;
            color: #1877f2;
            margin-bottom: 0.6rem;
        }

        .stat-label {
            font-size: 1rem;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .modal-body p {
            font-size: 1.05rem;
            color: #475569;
            line-height: 1.8;
            margin-bottom: 1.3rem;
        }

        .modal-body p:last-child {
            margin-bottom: 0;
        }

        .modal-divider {
            height: 2px;
            background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
            margin: 2rem 0;
        }

        .modal-highlight {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            padding: 1.5rem;
            border-radius: 16px;
            border-left: 4px solid #4f46e5;
            margin: 1.5rem 0;
        }

        .modal-highlight p {
            margin-bottom: 0;
            font-weight: 500;
            color: #1e293b;
        }

        /* Scrollbar styling for modal */
        .modal-content::-webkit-scrollbar {
            width: 8px;
        }

        .modal-content::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 0 24px 24px 0;
        }

        .modal-content::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .modal-content::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }



        /* Features Section */
        .features {
            padding: 5rem 2rem;
            background: white;
        }

        .features-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-header h2 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1rem;
            color: white;
        }

        .section-header p {
            font-size: 1.2rem;
            font-weight: 500;
            color: #ffffff;
            max-width: 600px;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: var(--white);
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(30, 64, 175, 0.1);
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.15);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: #1877f2;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .feature-icon i {
            font-size: 1.5rem;
            color: var(--white);
        }

        .feature-card h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .feature-card p {
            color: var(--gray);
            line-height: 1.6;
        }

        /* Contact/Support Section */
        .contact-section {
            padding: 5rem 2rem;
            background: var(--white);
        }

        .contact-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 3rem;
            margin-top: 3rem;
        }

        .contact-card {
            background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 100%);
            padding: 2.5rem;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .contact-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.15);
        }

        .contact-icon {
            width: 60px;
            height: 60px;
            background: #1877f2;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 1.5rem;
            color: white;
            box-shadow: 0 8px 24px rgba(24, 119, 242, 0.3);
        }

        .contact-card h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1rem;
        }

        .contact-email {
            font-size: 1.1rem;
            color: #1877f2;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            margin-top: 0.5rem;
            transition: all 0.3s ease;
        }

        .contact-email:hover {
            color: var(--primary-dark);
            transform: scale(1.05);
        }

        .hours-list {
            list-style: none;
            padding: 0;
            margin: 1rem 0 0 0;
        }

        .hours-list li {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e2e8f0;
            color: var(--dark);
            font-weight: 500;
        }

        .hours-list li:last-child {
            border-bottom: none;
        }

        .day {
            font-weight: 600;
        }

        .time {
            color: #1877f2;
            font-weight: 600;
        }

        /* Modal Support Hours */
        .modal-hours {
            padding: 3rem 4rem;
            background: #1877f2;
            text-align: center;
        }

        .modal-hours h3 {
            font-size: 1.8rem;
            font-weight: 800;
            color: white;
            margin-bottom: 1rem;
        }

        .modal-hours p {
            color: white;
            font-size: 1.1rem;
            margin-bottom: 2rem;
            font-weight: 500;
        }

        .modal-hours-list {
            list-style: none;
            padding: 0;
            margin: 0 auto;
            max-width: 500px;
        }

        .modal-hours-list li {
            display: flex;
            justify-content: space-between;
            padding: 1rem 1.5rem;
            background: white;
            margin-bottom: 0.75rem;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .modal-hours-list li:hover {
            transform: translateX(5px);
            box-shadow: 0 4px 12px rgba(24, 119, 242, 0.2);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .hero p {
                font-size: 23px;
                font-weight: 500;
            }

            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }

            .section-header h2 {
                font-size: 2rem;
            }

            .steps-grid {
                grid-template-columns: 1fr;
            }

            .step-arrow {
                display: none;
            }

            .modal-content {
                width: 98%;
                max-height: 95vh;
            }

            .modal-header-section,
            .modal-intro,
            .modal-features,
            .modal-mission,
            .modal-benefits {
                padding: 2rem;
            }

            .benefits-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .modal-stats {
                padding: 2rem;
                grid-template-columns: repeat(2, 1fr);
                gap: 1.5rem;
            }
        }

        /* Scroll animations */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="{{ route('home') }}" class="logo">
              
              
            </a>
            <ul class="nav-links">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="#" onclick="openAboutModal(); return false;">About</a></li>
                <li><a href="{{ route('register') }}">Sign Up</a></li>
                <li><a href="{{ route('login') }}">Login</a></li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content fade-in">
            <h1>PDMHS Student</h1>
            <h1>Medical System</h1>
            
            <p>Modern Healthcare Management designed specifically for PDMHS students. Secure, Efficient, and Accessible.</p>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="how-it-works">
        <div class="how-it-works-container">
            <div class="section-header">
                <h2>How It Works</h2>
                <p>Simple, fast, and efficient clinic management in 4 easy steps</p>
            </div>
            <div class="steps-grid">
                <div class="step-card fade-in">
                    <div class="step-number">1</div>
                    <div class="step-icon">
                        <i class="fas fa-qrcode"></i>
                    </div>
                    <h3>Student Scans QR Code</h3>
                    <p>Students present their unique QR code at the clinic entrance for instant identification.</p>
                    <div class="step-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
                <div class="step-card fade-in">
                    <div class="step-number">2</div>
                    <div class="step-icon">
                        <i class="fas fa-laptop-medical"></i>
                    </div>
                    <h3>View Health Records</h3>
                    <p>Clinic staff instantly access complete health profiles, medical history, and allergies.</p>
                    <div class="step-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
                <div class="step-card fade-in">
                    <div class="step-number">3</div>
                    <div class="step-icon">
                        <i class="fas fa-edit"></i>
                    </div>
                    <h3>Record & Update Data</h3>
                    <p>Log clinic visits, update vital signs, and add new health information in real-time.</p>
                    <div class="step-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
                <div class="step-card fade-in">
                    <div class="step-number">4</div>
                    <div class="step-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <h3>Parents Get Notified</h3>
                    <p>Automated notifications sent to parents about clinic visits and health updates.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Educational Articles -->
    <section class="educational-articles">
        <div class="articles-container">
            <div class="section-header">
                <h2>Educational Articles</h2>
                <p>Learn more about health and wellness from trusted sources</p>
            </div>
            <div class="articles-grid">
                <a href="https://www.who.int/health-topics/adolescent-health" target="_blank" class="article-card fade-in">
                    <div class="article-image">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <div class="article-content">
                        <span class="article-category">WHO</span>
                        <h3>Adolescent Health</h3>
                        <p>Comprehensive guide to teenage health and development from the World Health Organization.</p>
                        <span class="read-more">Read More <i class="fas fa-arrow-right"></i></span>
                    </div>
                </a>
                <a href="https://www.cdc.gov/healthyschools/nutrition/index.htm" target="_blank" class="article-card fade-in">
                    <div class="article-image">
                        <i class="fas fa-apple-alt"></i>
                    </div>
                    <div class="article-content">
                        <span class="article-category">CDC</span>
                        <h3>Nutrition for Students</h3>
                        <p>Essential nutrition information for healthy growth and academic success.</p>
                        <span class="read-more">Read More <i class="fas fa-arrow-right"></i></span>
                    </div>
                </a>
                <a href="https://www.nimh.nih.gov/health/topics/child-and-adolescent-mental-health" target="_blank" class="article-card fade-in">
                    <div class="article-image">
                        <i class="fas fa-brain"></i>
                    </div>
                    <div class="article-content">
                        <span class="article-category">NIMH</span>
                        <h3>Mental Health Matters</h3>
                        <p>Understanding and supporting adolescent mental health and wellbeing.</p>
                        <span class="read-more">Read More <i class="fas fa-arrow-right"></i></span>
                    </div>
                </a>
                <a href="https://www.cdc.gov/physicalactivity/basics/children/index.htm" target="_blank" class="article-card fade-in">
                    <div class="article-image">
                        <i class="fas fa-running"></i>
                    </div>
                    <div class="article-content">
                        <span class="article-category">CDC</span>
                        <h3>Physical Activity Guidelines</h3>
                        <p>How much physical activity do children and adolescents need?</p>
                        <span class="read-more">Read More <i class="fas fa-arrow-right"></i></span>
                    </div>
                </a>
                <a href="https://www.sleepfoundation.org/teens-and-sleep" target="_blank" class="article-card fade-in">
                    <div class="article-image">
                        <i class="fas fa-bed"></i>
                    </div>
                    <div class="article-content">
                        <span class="article-category">Sleep Foundation</span>
                        <h3>Sleep & Teens</h3>
                        <p>Why sleep is crucial for teenage health, growth, and academic performance.</p>
                        <span class="read-more">Read More <i class="fas fa-arrow-right"></i></span>
                    </div>
                </a>
                <a href="https://www.cdc.gov/healthyweight/children/index.html" target="_blank" class="article-card fade-in">
                    <div class="article-image">
                        <i class="fas fa-weight"></i>
                    </div>
                    <div class="article-content">
                        <span class="article-category">CDC</span>
                        <h3>Healthy Weight</h3>
                        <p>Tips and resources for maintaining a healthy weight during adolescence.</p>
                        <span class="read-more">Read More <i class="fas fa-arrow-right"></i></span>
                    </div>
                </a>
                <a href="https://www.cdc.gov/vaccines/parents/teens/index.html" target="_blank" class="article-card fade-in">
                    <div class="article-image">
                        <i class="fas fa-syringe"></i>
                    </div>
                    <div class="article-content">
                        <span class="article-category">CDC</span>
                        <h3>Vaccines for Teens</h3>
                        <p>Important information about immunizations and vaccines recommended for teenagers.</p>
                        <span class="read-more">Read More <i class="fas fa-arrow-right"></i></span>
                    </div>
                </a>
                <a href="https://www.who.int/news-room/fact-sheets/detail/physical-activity" target="_blank" class="article-card fade-in">
                    <div class="article-image">
                        <i class="fas fa-dumbbell"></i>
                    </div>
                    <div class="article-content">
                        <span class="article-category">WHO</span>
                        <h3>Benefits of Exercise</h3>
                        <p>Discover how regular physical activity improves overall health and wellbeing.</p>
                        <span class="read-more">Read More <i class="fas fa-arrow-right"></i></span>
                    </div>
                </a>
                <a href="https://www.cdc.gov/healthyschools/bam/index.htm" target="_blank" class="article-card fade-in">
                    <div class="article-image">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div class="article-content">
                        <span class="article-category">CDC</span>
                        <h3>Body & Mind</h3>
                        <p>Interactive resources about diseases, nutrition, physical activity, and safety for students.</p>
                        <span class="read-more">Read More <i class="fas fa-arrow-right"></i></span>
                    </div>
                </a>
                <a href="https://www.who.int/news-room/fact-sheets/detail/mental-health-strengthening-our-response" target="_blank" class="article-card fade-in">
                    <div class="article-image">
                        <i class="fas fa-head-side-virus"></i>
                    </div>
                    <div class="article-content">
                        <span class="article-category">WHO</span>
                        <h3>Mental Health Awareness</h3>
                        <p>Understanding mental health disorders and how to seek help and support.</p>
                        <span class="read-more">Read More <i class="fas fa-arrow-right"></i></span>
                    </div>
                </a>
                <a href="https://www.cdc.gov/handwashing/when-how-handwashing.html" target="_blank" class="article-card fade-in">
                    <div class="article-image">
                        <i class="fas fa-hands-wash"></i>
                    </div>
                    <div class="article-content">
                        <span class="article-category">CDC</span>
                        <h3>Hand Hygiene</h3>
                        <p>When and how to wash your hands properly to prevent the spread of germs.</p>
                        <span class="read-more">Read More <i class="fas fa-arrow-right"></i></span>
                    </div>
                </a>
                <a href="https://www.who.int/news-room/fact-sheets/detail/healthy-diet" target="_blank" class="article-card fade-in">
                    <div class="article-image">
                        <i class="fas fa-carrot"></i>
                    </div>
                    <div class="article-content">
                        <span class="article-category">WHO</span>
                        <h3>Healthy Diet Facts</h3>
                        <p>Key facts about maintaining a healthy diet for optimal growth and development.</p>
                        <span class="read-more">Read More <i class="fas fa-arrow-right"></i></span>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Daily Health Tips Carousel -->
    <section class="health-tips">
        <div class="tips-container">
            <div class="section-header">
                <h2>Daily Health Tips</h2>
                <p>Stay healthy with our expert wellness advice</p>
            </div>
            <div class="carousel">
                <button class="carousel-btn prev" onclick="moveCarousel(-1)">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <div class="carousel-track">
                    <div class="tip-card active">
                        <div class="tip-icon">💧</div>
                        <h3>Stay Hydrated</h3>
                        <p>Drink at least 8 glasses of water daily to maintain optimal body function and energy levels.</p>
                    </div>
                    <div class="tip-card">
                        <div class="tip-icon">🥗</div>
                        <h3>Eat Balanced Meals</h3>
                        <p>Include fruits, vegetables, proteins, and whole grains in your diet for complete nutrition.</p>
                    </div>
                    <div class="tip-card">
                        <div class="tip-icon">😴</div>
                        <h3>Get Enough Sleep</h3>
                        <p>Aim for 7-9 hours of quality sleep each night to support physical and mental health.</p>
                    </div>
                    <div class="tip-card">
                        <div class="tip-icon">🏃</div>
                        <h3>Exercise Regularly</h3>
                        <p>Engage in at least 30 minutes of physical activity daily to boost your immune system.</p>
                    </div>
                    <div class="tip-card">
                        <div class="tip-icon">🧘</div>
                        <h3>Manage Stress</h3>
                        <p>Practice mindfulness, meditation, or deep breathing to reduce stress and anxiety.</p>
                    </div>
                    <div class="tip-card">
                        <div class="tip-icon">🧼</div>
                        <h3>Practice Good Hygiene</h3>
                        <p>Wash your hands frequently with soap and water for at least 20 seconds to prevent illness.</p>
                    </div>
                    <div class="tip-card">
                        <div class="tip-icon">🌞</div>
                        <h3>Get Sunlight Exposure</h3>
                        <p>Spend 10-15 minutes in sunlight daily for vitamin D production and improved mood.</p>
                    </div>
                    <div class="tip-card">
                        <div class="tip-icon">📱</div>
                        <h3>Limit Screen Time</h3>
                        <p>Take regular breaks from screens to reduce eye strain and improve sleep quality.</p>
                    </div>
                    <div class="tip-card">
                        <div class="tip-icon">🍎</div>
                        <h3>Eat Healthy Snacks</h3>
                        <p>Choose nutritious snacks like fruits, nuts, and yogurt instead of processed foods.</p>
                    </div>
                    <div class="tip-card">
                        <div class="tip-icon">🚭</div>
                        <h3>Avoid Harmful Substances</h3>
                        <p>Stay away from smoking, vaping, alcohol, and drugs to protect your health and future.</p>
                    </div>
                    <div class="tip-card">
                        <div class="tip-icon">👥</div>
                        <h3>Build Social Connections</h3>
                        <p>Maintain healthy relationships with friends and family for emotional support and wellbeing.</p>
                    </div>
                    <div class="tip-card">
                        <div class="tip-icon">🦷</div>
                        <h3>Maintain Oral Hygiene</h3>
                        <p>Brush teeth twice daily and floss regularly to prevent cavities and gum disease.</p>
                    </div>
                </div>
                <button class="carousel-btn next" onclick="moveCarousel(1)">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            <div class="carousel-dots">
                <span class="dot active" onclick="currentSlide(0)"></span>
                <span class="dot" onclick="currentSlide(1)"></span>
                <span class="dot" onclick="currentSlide(2)"></span>
                <span class="dot" onclick="currentSlide(3)"></span>
                <span class="dot" onclick="currentSlide(4)"></span>
                <span class="dot" onclick="currentSlide(5)"></span>
                <span class="dot" onclick="currentSlide(6)"></span>
                <span class="dot" onclick="currentSlide(7)"></span>
                <span class="dot" onclick="currentSlide(8)"></span>
                <span class="dot" onclick="currentSlide(9)"></span>
                <span class="dot" onclick="currentSlide(10)"></span>
                <span class="dot" onclick="currentSlide(11)"></span>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="features-container">

            <div class="features-grid">
                <div class="feature-card fade-in">
                    <div class="feature-icon">
                        <i class="fas fa-qrcode"></i>
                    </div>
                    <h3>QR Code Student Identification</h3>
                    <p>Instant student identification using QR codes for fast and accurate clinic check-ins. Streamlined process that reduces wait times and improves clinic workflow efficiency.</p>
                </div>
                <div class="feature-card fade-in">
                    <div class="feature-icon">
                        <i class="fas fa-file-medical-alt"></i>
                    </div>
                    <h3>Digital Health Records</h3>
                    <p>Comprehensive digital health profiles with secure storage of medical history, allergies, medications, and vital signs. Quick access to critical health information when needed most.</p>
                </div>
                <div class="feature-card fade-in">
                    <div class="feature-icon">
                        <i class="fas fa-syringe"></i>
                    </div>
                    <h3>Immunization & Health Monitoring</h3>
                    <p>Track vaccination records, monitor health compliance requirements, and generate automated reminders for upcoming immunizations. Ensure all students meet health standards for school attendance.</p>
                </div>
                <div class="feature-card fade-in">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Advanced Health Analytics</h3>
                    <p>Generate comprehensive reports on student health trends, clinic visit patterns, and health incident tracking. Data-driven insights to improve school health programs and resource allocation.</p>
                </div>
                <div class="feature-card fade-in">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Privacy & Security First</h3>
                    <p>Bank-level security with encrypted data storage, role-based access controls, and complete audit trails. Protecting sensitive student health information with the highest security standards.</p>
                </div>
                <div class="feature-card fade-in">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Multi-Device Accessibility</h3>
                    <p>Access the system seamlessly from any device - desktop, tablet, or smartphone. Responsive design ensures clinic staff can manage student health records efficiently from anywhere on campus.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact/Support Section -->
    <section class="contact-section">
        <div class="contact-container">
            <div class="section-header">
                <h2>Get In Touch</h2>
                <p>Have questions? We're here to help</p>
            </div>
            <div class="contact-grid">
                <div class="contact-card fade-in">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3>Email Us</h3>
                    <a href="https://mail.google.com/mail/?view=cm&fs=1&to=sdotapat.pdmhs@deped.gov.ph" target="_blank" class="contact-email">
                        sdotapat.pdmhs@deped.gov.ph
                    </a>
                </div>
                <div class="contact-card fade-in">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3>Visit Us</h3>
                    <a href="https://www.google.com/maps/search/?api=1&query=8th+Street+GHQ+Village+Katuparan+Taguig+Philippines+1630" target="_blank" class="contact-email" style="display: block; margin-top: 1rem;">
                        8th Street GHQ Village<br>
                        Katuparan, Taguig<br>
                        Philippines, 1630
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- About Modal -->
    <div id="aboutModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeAboutModal()">&times;</span>
            <div class="modal-body">
                <div class="modal-header-section">
                    <div class="modal-icon">
                        <i class="fas fa-hospital"></i>
                    </div>
                    <h2>Transforming Healthcare at PDMHS</h2>
                </div>
                
                <div class="modal-intro">
                    <p>The PDMHS Clinic Management System is an innovative solution that enhances the delivery of healthcare services in the school environment. Built to support efficient clinic operations, it enables secure health record management, fast student identification through QR codes, and data-driven insights to promote better student health and safety.</p>
                </div>
                
                <div class="modal-features">
                    <div class="feature-item">
                        <div class="feature-icon-small">
                            <i class="fas fa-qrcode"></i>
                        </div>
                        <div class="feature-text">
                            <h4>QR Code Technology</h4>
                            <p>Lightning-fast student identification with secure QR codes. Scan and access complete health profiles in seconds, eliminating manual searches and reducing wait times.</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon-small">
                            <i class="fas fa-database"></i>
                        </div>
                        <div class="feature-text">
                            <h4>Centralized Health Records</h4>
                            <p>Complete digital health profiles including medical history, allergies, medications, immunizations, and vital signs - all in one secure location accessible to authorized staff.</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon-small">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="feature-text">
                            <h4>Advanced Analytics</h4>
                            <p>Real-time insights into campus health trends, visit patterns, and incident tracking. Generate comprehensive reports to improve health programs and resource allocation.</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon-small">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="feature-text">
                            <h4>Enterprise-Grade Security</h4>
                            <p>Bank-level encryption, role-based access controls, complete audit trails, and HIPAA-compliant data protection to safeguard sensitive student health information.</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon-small">
                            <i class="fas fa-bell"></i>
                        </div>
                        <div class="feature-text">
                            <h4>Automated Notifications</h4>
                            <p>Instant parent alerts for clinic visits, health updates, and medication reminders. Keep families informed and engaged in their child's health journey.</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon-small">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="feature-text">
                            <h4>Multi-Device Access</h4>
                            <p>Responsive design works seamlessly on desktop, tablet, and smartphone. Access student records from anywhere on campus with internet connectivity.</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon-small">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="feature-text">
                            <h4>Real-Time Updates</h4>
                            <p>Instant synchronization across all devices. Updates made by any staff member are immediately available to all authorized users.</p>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon-small">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <div class="feature-text">
                            <h4>Streamlined Workflow</h4>
                            <p>Intuitive interface designed for busy clinic staff. Reduce paperwork, minimize errors, and spend more time caring for students.</p>
                        </div>
                    </div>
                </div>
                
                <div class="modal-mission">
                    <div class="mission-icon">💡</div>
                    <h3>Our Mission</h3>
                    <p>Empowering healthcare providers with cutting-edge technology while prioritizing user experience, data security, and clinical efficiency - ensuring focus on what matters most: the health and wellbeing of our students.</p>
                </div>
                
                <div class="modal-benefits">
                    <h3 class="benefits-title">Why Schools Choose Our System</h3>
                    <div class="benefits-grid">
                        <div class="benefit-card">
                            <div class="benefit-icon"><i class="fas fa-bolt"></i></div>
                            <h4>Increased Efficiency</h4>
                            <p>Reduce clinic visit processing time by 70% with instant QR code identification and digital records.</p>
                        </div>
                        <div class="benefit-card">
                            <div class="benefit-icon"><i class="fas fa-chart-line"></i></div>
                            <h4>Better Decision Making</h4>
                            <p>Data-driven insights help administrators make informed decisions about health programs and resources.</p>
                        </div>
                        <div class="benefit-card">
                            <div class="benefit-icon"><i class="fas fa-shield-alt"></i></div>
                            <h4>Enhanced Compliance</h4>
                            <p>Meet all regulatory requirements with automated tracking, audit trails, and secure data management.</p>
                        </div>
                        <div class="benefit-card">
                            <div class="benefit-icon"><i class="fas fa-users"></i></div>
                            <h4>Parent Engagement</h4>
                            <p>Keep parents informed and involved with automated notifications and transparent health tracking.</p>
                        </div>
                    </div>
                </div>

                <div class="modal-hours">
                    <h3><i class="fas fa-clock"></i> Support Hours</h3>
                    <p>We're available during these hours</p>
                    <ul class="modal-hours-list">
                        <li><span class="day">Monday</span><span class="time">8:00 AM - 5:00 PM</span></li>
                        <li><span class="day">Tuesday</span><span class="time">8:00 AM - 5:00 PM</span></li>
                        <li><span class="day">Wednesday</span><span class="time">8:00 AM - 5:00 PM</span></li>
                        <li><span class="day">Thursday</span><span class="time">8:00 AM - 5:00 PM</span></li>
                        <li><span class="day">Friday</span><span class="time">8:00 AM - 5:00 PM</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Fade in animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        // Observe all fade-in elements
        document.querySelectorAll('.fade-in').forEach(el => {
            observer.observe(el);
        });

        // Initial fade-in for hero content
        setTimeout(() => {
            document.querySelector('.hero .fade-in').classList.add('visible');
        }, 300);

        // Carousel functionality
        let currentIndex = 0;
        const tips = document.querySelectorAll('.tip-card');
        const dots = document.querySelectorAll('.dot');

        function showSlide(index) {
            tips.forEach((tip, i) => {
                tip.classList.remove('active', 'prev');
                if (i === index) {
                    tip.classList.add('active');
                } else if (i < index) {
                    tip.classList.add('prev');
                }
            });

            dots.forEach((dot, i) => {
                dot.classList.toggle('active', i === index);
            });

            currentIndex = index;
        }

        function moveCarousel(direction) {
            let newIndex = currentIndex + direction;
            if (newIndex < 0) newIndex = tips.length - 1;
            if (newIndex >= tips.length) newIndex = 0;
            showSlide(newIndex);
        }

        function currentSlide(index) {
            showSlide(index);
        }

        // Auto-advance carousel every 5 seconds
        setInterval(() => {
            moveCarousel(1);
        }, 5000);

        // Modal functions
        function openAboutModal() {
            document.getElementById('aboutModal').classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeAboutModal() {
            document.getElementById('aboutModal').classList.remove('show');
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('aboutModal');
            if (event.target === modal) {
                closeAboutModal();
            }
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeAboutModal();
            }
        });
    </script>
</body>
</html>