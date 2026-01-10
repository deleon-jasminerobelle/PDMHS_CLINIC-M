<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Student Dashboard - {{ $user->name }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #1877f2;
            --primary-dark: #166fe5;
            --secondary: #3b82f6;
            --accent: #60a5fa;
            --dark: #0f172a;
            --gray: #64748b;
            --light: #f1f5f9;
            --white: #ffffff;
            --success: #10b981;
            --warning: #f59e0b;
            --gradient: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            --danger: #ef4444;
            --info: #60a5fa;
            --gray-light: #f8fafc;
            --gradient-subtle: linear-gradient(135deg, #eff6ff 0%, #dbe9ff 100%);
            --shadow-blue: rgba(24, 119, 242, 0.1);
            --shadow-blue-light: rgba(24, 119, 242, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--gradient);
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
            background: linear-gradient(135deg, var(--dark) 0%, var(--primary) 100%);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
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
            font-size: 1.5rem;
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
            color: var(--dark);
            text-decoration: none;
            font-weight: 500;
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

        /* Welcome Section */
        .welcome-section {
            background: white;
            border-radius: 1.5rem;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 2rem;
            animation: slideDown 0.5s ease;
        }

        .profile-pic-large {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--primary);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .profile-pic-default-large {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
            border: 4px solid white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .welcome-content h1 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .welcome-content p {
            color: #6b7280;
            font-size: 1.1rem;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            animation: fadeInUp 0.5s ease;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .stat-card:hover::before {
            transform: scaleX(1);
        }

        .stat-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.25rem;
        }

        .stat-label {
            color: #6b7280;
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Section Cards */
        .section-card {
            background: white;
            border-radius: 1.5rem;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 0.5s ease;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--light);
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .btn {
            padding: 0.5rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
        }

        /* Health Info Grid */
        .health-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1.5rem;
        }

        .health-item {
            text-align: center;
            padding: 1rem;
            background: var(--light);
            border-radius: 0.75rem;
            transition: all 0.3s ease;
        }

        .health-item:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-3px);
        }

        .health-item-label {
            font-size: 0.9rem;
            color: #6b7280;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .health-item:hover .health-item-label {
            color: rgba(255, 255, 255, 0.9);
        }

        .health-item-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark);
        }

        .health-item:hover .health-item-value {
            color: white;
        }

        /* Allergies Grid */
        .allergies-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }

        .allergy-badge {
            padding: 1rem;
            border-radius: 0.75rem;
            border-left: 4px solid var(--warning);
            background: #fef3c7;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.3s ease;
        }

        .allergy-badge:hover {
            transform: translateX(5px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .allergy-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--warning);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .allergy-info strong {
            display: block;
            color: var(--dark);
            margin-bottom: 0.25rem;
        }

        .allergy-info small {
            color: #92400e;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #6b7280;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--success);
        }

        /* Alert */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 0.75rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            animation: slideDown 0.3s ease;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border-left: 4px solid var(--success);
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid var(--danger);
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            z-index: 2000;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.3s ease;
        }

        .modal.show {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 1rem;
            width: 90%;
            max-width: 800px;
            max-height: 90vh;
            overflow-y: auto;
            animation: scaleIn 0.3s ease;
        }

        .modal-header {
            padding: 1.5rem;
            border-bottom: 2px solid var(--light);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            padding: 1.5rem;
            border-top: 2px solid var(--light);
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }

        .close-btn {
            background: transparent;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #6b7280;
            transition: all 0.3s ease;
        }

        .close-btn:hover {
            color: var(--danger);
            transform: rotate(90deg);
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--dark);
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid var(--light);
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .allergy-item {
            padding: 1.5rem;
            background: var(--light);
            border-radius: 0.75rem;
            margin-bottom: 1rem;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .allergy-item:hover {
            border-color: var(--primary);
        }

        .allergy-item-row {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 1rem;
            align-items: end;
        }

        .btn-danger {
            background: var(--danger);
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
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

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes expand {
            from {
                width: 0;
                height: 0;
                opacity: 1;
            }
            to {
                width: 200px;
                height: 200px;
                opacity: 0;
            }
        }

        @keyframes floatUp {
            from {
                opacity: 0.8;
                transform: translateY(0) scale(1);
            }
            to {
                opacity: 0;
                transform: translateY(-50px) scale(1.2);
            }
        }

        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes glow {
            0% {
                box-shadow: 0 0 5px rgba(79, 70, 229, 0.3);
            }
            50% {
                box-shadow: 0 0 20px rgba(79, 70, 229, 0.6), 0 0 30px rgba(79, 70, 229, 0.4);
            }
            100% {
                box-shadow: 0 0 5px rgba(79, 70, 229, 0.3);
            }
        }

        @keyframes particleFloat {
            0% {
                opacity: 0;
                transform: translateY(0) rotate(0deg);
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                opacity: 0;
                transform: translateY(-100px) rotate(360deg);
            }
        }

        @keyframes highlight {
            0% {
                background-color: transparent;
            }
            50% {
                background-color: rgba(79, 70, 229, 0.1);
            }
            100% {
                background-color: transparent;
            }
        }

        @keyframes bounceIn {
            0% {
                opacity: 0;
                transform: scale(0.3);
            }
            50% {
                opacity: 1;
                transform: scale(1.05);
            }
            70% {
                transform: scale(0.9);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Health Resources */
        .resources-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .resource-card {
            background: var(--light);
            border-radius: 1rem;
            padding: 1.5rem;
            transition: all 0.3s ease;
            cursor: pointer;
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
            animation: slideInLeft 0.6s ease-out;
        }

        .resource-card:nth-child(2) {
            animation: slideInRight 0.6s ease-out 0.2s both;
        }

        .resource-card:nth-child(3) {
            animation: bounceIn 0.6s ease-out 0.4s both;
        }

        .resource-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            border-color: var(--primary);
            animation: glow 2s ease-in-out infinite;
        }

        .resource-card.active {
            border-color: var(--primary);
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.05), rgba(6, 182, 212, 0.05));
        }

        .resource-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .resource-icon {
            width: 50px;
            height: 50px;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: white;
        }

        .resource-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark);
            margin: 0;
            flex: 1;
        }

        .resource-toggle {
            color: var(--primary);
            transition: transform 0.3s ease;
        }

        .resource-card.active .resource-toggle {
            transform: rotate(180deg);
        }

        .resource-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .resource-card.active .resource-content {
            max-height: 500px;
        }

        .resource-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .resource-list li {
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            color: #374151;
            line-height: 1.5;
        }

        .resource-list li:last-child {
            border-bottom: none;
        }

        .first-aid-tips {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .tip-item {
            padding: 1rem;
            background: white;
            border-radius: 0.5rem;
            border-left: 4px solid var(--success);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .navigation-guide {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .nav-section {
            padding: 1rem;
            background: white;
            border-radius: 0.5rem;
            border-left: 4px solid var(--info);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            line-height: 1.5;
        }

        /* Custom Tooltips */
        .tooltip-custom {
            position: relative;
            display: inline-block;
        }

        .tooltip-custom .tooltip-text {
            visibility: hidden;
            width: 280px;
            background-color: var(--dark);
            color: #fff;
            text-align: left;
            border-radius: 0.5rem;
            padding: 1rem;
            position: absolute;
            z-index: 1000;
            bottom: 125%;
            left: 50%;
            margin-left: -140px;
            opacity: 0;
            transition: opacity 0.3s, visibility 0.3s;
            font-size: 0.875rem;
            line-height: 1.4;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .tooltip-custom .tooltip-text::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: var(--dark) transparent transparent transparent;
        }

        .tooltip-custom:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }

        .tooltip-custom .tooltip-text strong {
            color: var(--primary);
            display: block;
            margin-bottom: 0.5rem;
            font-size: 1rem;
        }

        .tooltip-custom .tooltip-text .tooltip-section {
            margin-bottom: 0.75rem;
        }

        .tooltip-custom .tooltip-text .tooltip-section:last-child {
            margin-bottom: 0;
        }

        /* Medical History Timeline */
        .timeline-section {
            background: white;
            border-radius: 1.5rem;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 0.5s ease;
        }

        .timeline {
            position: relative;
            padding-left: 2rem;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 1rem;
            top: 0;
            bottom: 0;
            width: 3px;
            background: linear-gradient(to bottom, var(--primary), var(--secondary));
            border-radius: 2px;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 2rem;
            padding-left: 2rem;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -1.5rem;
            top: 1.5rem;
            width: 1rem;
            height: 1rem;
            border-radius: 50%;
            background: var(--primary);
            border: 3px solid white;
            box-shadow: 0 0 0 2px var(--primary);
            z-index: 1;
        }

        .timeline-item.completed::before {
            background: var(--success);
            box-shadow: 0 0 0 2px var(--success);
        }

        .timeline-item.pending::before {
            background: var(--warning);
            box-shadow: 0 0 0 2px var(--warning);
        }

        .timeline-item.emergency::before {
            background: var(--danger);
            box-shadow: 0 0 0 2px var(--danger);
        }

        .timeline-content {
            background: var(--light);
            border-radius: 1rem;
            padding: 1.5rem;
            border-left: 4px solid var(--primary);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .timeline-content:hover {
            transform: translateX(5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            border-left-color: var(--primary-dark);
        }

        .timeline-item.completed .timeline-content {
            border-left-color: var(--success);
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.05), rgba(255, 255, 255, 0.5));
        }

        .timeline-item.pending .timeline-content {
            border-left-color: var(--warning);
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.05), rgba(255, 255, 255, 0.5));
        }

        .timeline-item.emergency .timeline-content {
            border-left-color: var(--danger);
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.05), rgba(255, 255, 255, 0.5));
        }

        .timeline-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .timeline-date {
            font-weight: 700;
            color: var(--dark);
            font-size: 1.1rem;
        }

        .timeline-type {
            font-size: 0.875rem;
            color: #6b7280;
            background: white;
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            border: 1px solid var(--light);
        }

        .timeline-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .timeline-detail {
            display: flex;
            flex-direction: column;
        }

        .timeline-detail-label {
            font-size: 0.8rem;
            color: #6b7280;
            font-weight: 600;
            margin-bottom: 0.25rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .timeline-detail-value {
            font-weight: 600;
            color: var(--dark);
            font-size: 0.95rem;
        }

        .timeline-reason {
            background: white;
            padding: 1rem;
            border-radius: 0.5rem;
            border-left: 3px solid var(--primary);
            margin-top: 1rem;
        }

        .timeline-reason-label {
            font-size: 0.85rem;
            color: #6b7280;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .timeline-reason-text {
            color: var(--dark);
            line-height: 1.5;
        }

        .timeline-empty {
            text-align: center;
            padding: 3rem;
            color: #6b7280;
        }

        .timeline-empty i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--success);
            opacity: 0.5;
        }

        /* Enhanced Health Item Hover Effects */
        .health-item {
            position: relative;
            transition: all 0.3s ease;
        }

        .health-item:hover {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
        }

        .health-item:hover .health-item-label {
            color: rgba(255, 255, 255, 0.9);
        }

        .health-item:hover .health-item-value {
            color: white;
        }

        /* Advanced Filters */
        .filters-section {
            background: var(--light);
            border-radius: 0.75rem;
            padding: 1.5rem;
            border: 2px solid var(--primary-light);
            transition: all 0.3s ease;
        }

        .filters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            align-items: end;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
        }

        .filter-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-select {
            padding: 0.5rem;
            border: 2px solid var(--light);
            border-radius: 0.5rem;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            background: white;
        }

        .filter-select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(24, 119, 242, 0.1);
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            border-radius: 0.375rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar-menu {
                display: none;
            }

            .welcome-section {
                flex-direction: column;
                text-align: center;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .health-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .allergies-grid {
                grid-template-columns: 1fr;
            }

            .resources-grid {
                grid-template-columns: 1fr;
            }

            .resource-header {
                flex-direction: column;
                text-align: center;
                gap: 0.75rem;
            }

            .resource-title {
                text-align: center;
            }

            .timeline {
                padding-left: 1.5rem;
            }

            .timeline::before {
                left: 0.75rem;
            }

            .timeline-item {
                padding-left: 1.5rem;
            }

            .timeline-item::before {
                left: -1rem;
            }

            .timeline-details {
                grid-template-columns: 1fr;
            }

            .tooltip-custom .tooltip-text {
                width: 250px;
                margin-left: -125px;
                left: 50%;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a class="navbar-brand" href="{{ route('student.dashboard') }}">
                <i class="fas fa-heartbeat"></i>
                PDMHS Clinic
            </a>
            <ul class="navbar-menu">
                <li><a class="nav-link active" href="{{ route('student.dashboard') }}"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
                <li><a class="nav-link" href="{{ route('student.medical') }}"><i class="fas fa-notes-medical"></i>My Medical</a></li>
                <li><a class="nav-link" href="{{ route('health-form.index') }}"><i class="fas fa-clipboard-list"></i>Health Form</a></li>
            </ul>
            <div class="user-dropdown">
                <button class="user-btn" onclick="toggleDropdown()">
                    @if($user->profile_picture && file_exists(public_path($user->profile_picture)))
                        <img src="{{ asset($user->profile_picture) }}" alt="Profile" class="user-avatar">
                    @else
                        <div class="user-avatar-default">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif
                    <span>{{ $user->name }}</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="dropdown-menu" id="userDropdown">
                    <a class="dropdown-item" href="{{ route('student.info') }}">
                        
                    </a>
                    <a class="dropdown-item" href="{{ route('student.profile') }}">
                        <i class="fas fa-user-edit"></i>
                        Profile
                    </a>
                    <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <strong>Success!</strong> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-triangle"></i>
                <strong>Error!</strong> {{ session('error') }}
            </div>
        @endif

        <!-- Welcome Section -->
        <div class="welcome-section">
            @if($user->profile_picture && file_exists(public_path($user->profile_picture)))
                <img src="{{ asset($user->profile_picture) }}" alt="Profile Picture" class="profile-pic-large">
            @else
                <div class="profile-pic-default-large">
                    <i class="fas fa-user"></i>
                </div>
            @endif
            <div class="welcome-content">
                <h1>Welcome back, {{ $user->name }}!</h1>
                <p>Here's your health overview for today</p>
            </div>
        </div>

        <!-- Health Statistics Cards -->
        <div class="stats-grid">
            <div class="tooltip-custom" data-tooltip="<strong>BMI Details</strong><div class='tooltip-section'>Your current BMI is {{ $bmi ?? 'not calculated' }}.</div><div class='tooltip-section'>Category: {{ $bmiCategory ?? 'Unknown' }}</div><div class='tooltip-section'>BMI ranges: Underweight (<18.5), Normal (18.5-24.9), Overweight (25-29.9), Obese (≥30)</div>">
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-icon" style="background: linear-gradient(135deg, var(--primary), var(--secondary));">
                            <i class="fas fa-weight"></i>
                        </div>
                    </div>
                    <div class="stat-value">{{ $bmi ?? 'N/A' }}</div>
                    <div class="stat-label">BMI</div>
                    <div class="tooltip-text"></div>
                </div>
            </div>
            <div class="tooltip-custom" data-tooltip="<strong>Blood Type Information</strong><div class='tooltip-section'>Your blood type is {{ $bloodType ?? 'not specified' }}.</div><div class='tooltip-section'>Blood types determine compatibility for transfusions and organ donations.</div><div class='tooltip-section'>Type {{ $bloodType ?? 'O' }} can donate to: {{ $bloodType == 'O-' ? 'All types' : ($bloodType == 'O+' ? 'O+, A+, B+, AB+' : ($bloodType == 'A-' ? 'A-, A+, AB-, AB+' : ($bloodType == 'A+' ? 'A+, AB+' : ($bloodType == 'B-' ? 'B-, B+, AB-, AB+' : ($bloodType == 'B+' ? 'B+, AB+' : ($bloodType == 'AB-' ? 'AB-, AB+' : 'AB+ only')))))) }}</div>">
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-icon" style="background: linear-gradient(135deg, var(--danger), #ff6b6b);">
                            <i class="fas fa-tint"></i>
                        </div>
                    </div>
                    <div class="stat-value">{{ $bloodType ?? 'N/A' }}</div>
                    <div class="stat-label">Blood Type</div>
                    <div class="tooltip-text"></div>
                </div>
            </div>
            <div class="tooltip-custom" data-tooltip="<strong>Allergy Information</strong><div class='tooltip-section'>You have {{ isset($allergies) && $allergies && $allergies->count() > 0 ? $allergies->count() : 'no' }} recorded allergies.</div>@if(isset($allergies) && $allergies && $allergies->count() > 0)<div class='tooltip-section'>Allergies: @foreach($allergies as $allergy){{ $allergy->allergy_name }} ({{ $allergy->severity }}), @endforeach</div>@endif<div class='tooltip-section'>Always inform healthcare providers about your allergies before treatment.</div>">
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-icon" style="background: linear-gradient(135deg, var(--warning), #ffa726);">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                    <div class="stat-value">{{ isset($allergies) && $allergies && $allergies->count() > 0 ? $allergies->count() : '0' }}</div>
                    <div class="stat-label">Allergies</div>
                    <div class="tooltip-text"></div>
                </div>
            </div>
            <div class="tooltip-custom" data-tooltip="<strong>Last Clinic Visit</strong><div class='tooltip-section'>{{ isset($lastVisit) && $lastVisit ? 'Last visited on ' . $lastVisit->visit_date->format('F j, Y') : 'No clinic visits recorded yet' }}</div>@if(isset($lastVisit) && $lastVisit)<div class='tooltip-section'>Purpose: {{ $lastVisit->purpose ?? 'Not specified' }}</div><div class='tooltip-section'>Next check-up recommended within 6-12 months.</div>@endif">
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-icon" style="background: linear-gradient(135deg, var(--info), #42a5f5);">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                    </div>
                    <div class="stat-value">{{ isset($lastVisit) && $lastVisit ? $lastVisit->visit_date->format('M j') : 'N/A' }}</div>
                    <div class="stat-label">Last Visit</div>
                    <div class="tooltip-text"></div>
                </div>
            </div>
        </div>

        <!-- Health Information Section -->
        <div class="section-card">
            <div class="section-header">
                <h5 class="section-title">
                    <i class="fas fa-heartbeat"></i>
                    Health Information
                </h5>
                <div class="d-flex gap-2 align-items-center">
                    <button class="btn btn-outline btn-sm" onclick="toggleFilters()">
                        <i class="fas fa-filter"></i>Filters
                    </button>
                    <a href="{{ route('health-form.index') }}" class="btn btn-outline btn-sm">
                        <i class="fas fa-edit"></i>Edit
                    </a>
                </div>
            </div>

            <!-- Advanced Filters -->
            <div class="filters-section" id="filtersSection" style="display: none; margin-bottom: 1.5rem;">
                <div class="filters-grid">
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-calendar"></i>Date Range
                        </label>
                        <select class="filter-select" id="dateFilter">
                            <option value="all">All Time</option>
                            <option value="last-week">Last Week</option>
                            <option value="last-month">Last Month</option>
                            <option value="last-3-months">Last 3 Months</option>
                            <option value="last-6-months">Last 6 Months</option>
                            <option value="last-year">Last Year</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-tag"></i>Category
                        </label>
                        <select class="filter-select" id="categoryFilter">
                            <option value="all">All Categories</option>
                            <option value="vitals">Vitals</option>
                            <option value="measurements">Measurements</option>
                            <option value="personal">Personal Info</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-check-circle"></i>Status
                        </label>
                        <select class="filter-select" id="statusFilter">
                            <option value="all">All Status</option>
                            <option value="complete">Complete</option>
                            <option value="incomplete">Incomplete</option>
                            <option value="pending">Pending</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <button class="btn btn-primary btn-sm" onclick="applyFilters()">
                            <i class="fas fa-search"></i>Apply Filters
                        </button>
                        <button class="btn btn-outline btn-sm" onclick="resetFilters()">
                            <i class="fas fa-times"></i>Reset
                        </button>
                    </div>
                </div>
            </div>
            <div class="health-grid">
                <div class="tooltip-custom" data-tooltip="<strong>Height Information</strong><div class='tooltip-section'>Current Height: {{ $latestVitals->height ? $latestVitals->height . ' cm' : 'Not recorded' }}</div><div class='tooltip-section'>Height is used to calculate BMI and assess growth patterns.</div><div class='tooltip-section'>Regular height measurements help track development and identify potential health concerns.</div>">
                    <div class="health-item">
                        <div class="health-item-label">Height</div>
                        <div class="health-item-value">{{ $latestVitals->height ? $latestVitals->height . ' cm' : 'Not Set' }}</div>
                    </div>
                </div>
                <div class="tooltip-custom" data-tooltip="<strong>Weight Information</strong><div class='tooltip-section'>Current Weight: {{ $latestVitals->weight ? $latestVitals->weight . ' kg' : 'Not recorded' }}</div><div class='tooltip-section'>Weight combined with height determines BMI.</div><div class='tooltip-section'>Maintaining healthy weight is important for overall well-being and disease prevention.</div>">
                    <div class="health-item">
                        <div class="health-item-label">Weight</div>
                        <div class="health-item-value">{{ $latestVitals->weight ? $latestVitals->weight . ' kg' : 'Not Set' }}</div>
                    </div>
                </div>
                <div class="tooltip-custom" data-tooltip="<strong>Age Information</strong><div class='tooltip-section'>Current Age: {{ $age ?? 'Not calculated' }} years</div><div class='tooltip-section'>Age influences health screening schedules and risk assessments.</div><div class='tooltip-section'>Different age groups have specific health priorities and vaccination requirements.</div>">
                    <div class="health-item">
                        <div class="health-item-label">Age</div>
                        <div class="health-item-value">{{ $age ?? 'Not Set' }}</div>
                    </div>
                </div>
                <div class="tooltip-custom" data-tooltip="<strong>BMI Details</strong><div class='tooltip-section'>Your current BMI is {{ $bmi ?? 'not calculated' }}.</div><div class='tooltip-section'>Category: {{ $bmiCategory ?? 'Unknown' }}</div><div class='tooltip-section'>BMI ranges: Underweight (<18.5), Normal (18.5-24.9), Overweight (25-29.9), Obese (≥30)</div><div class='tooltip-section'>BMI is a screening tool, consult healthcare provider for comprehensive assessment.</div>">
                    <div class="health-item">
                        <div class="health-item-label">BMI</div>
                        <div class="health-item-value">
                            {{ $bmi ? $bmi : 'Not Set' }}
                            @if(isset($bmiCategory) && $bmiCategory)
                                <small style="display: block; color: #6b7280; font-size: 0.8rem;">({{ $bmiCategory }})</small>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="tooltip-custom" data-tooltip="<strong>Blood Type Information</strong><div class='tooltip-section'>Your blood type is {{ $bloodType ?? 'not specified' }}.</div><div class='tooltip-section'>Blood types determine compatibility for transfusions and organ donations.</div><div class='tooltip-section'>Type {{ $bloodType ?? 'O' }} can donate to: {{ $bloodType == 'O-' ? 'All types' : ($bloodType == 'O+' ? 'O+, A+, B+, AB+' : ($bloodType == 'A-' ? 'A-, A+, AB-, AB+' : ($bloodType == 'A+' ? 'A+, AB+' : ($bloodType == 'B-' ? 'B-, B+, AB-, AB+' : ($bloodType == 'B+' ? 'B+, AB+' : ($bloodType == 'AB-' ? 'AB-, AB+' : 'AB+ only')))))) }}</div><div class='tooltip-section'>Know your blood type - it could save lives in emergencies.</div>">
                    <div class="health-item">
                        <div class="health-item-label">Blood Type</div>
                        <div class="health-item-value">{{ $bloodType ? $bloodType : 'Not Set' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Known Allergies -->
        <div class="section-card">
            <div class="section-header">
                <h5 class="section-title">
                    <i class="fas fa-exclamation-triangle"></i>
                    Known Allergies
                </h5>
                <button class="btn btn-outline" onclick="openAllergiesModal()">
                    <i class="fas fa-edit"></i>Edit
                </button>
            </div>
            @if(isset($allergies) && $allergies && $allergies->count() > 0)
                <div class="allergies-grid">
                    @foreach($allergies as $allergy)
                        <div class="allergy-badge">
                            <div class="allergy-icon">
                                <i class="fas fa-exclamation-circle"></i>
                            </div>
                            <div class="allergy-info">
                                <strong>{{ $allergy->allergy_name ?? 'Unknown' }}</strong>
                                <small>Severity: {{ $allergy->severity ?? 'Unknown' }}</small>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-check-circle"></i>
                    <p>No known allergies recorded</p>
                </div>
            @endif
        </div>

        <!-- Health Resources -->
        <div class="section-card">
            <div class="section-header">
                <h5 class="section-title">
                    <i class="fas fa-info-circle"></i>
                    Health Resources
                </h5>
            </div>
            <div class="resources-grid">
                <div class="resource-card" onclick="toggleResource('clinic-visit')">
                    <div class="resource-header">
                        <div class="resource-icon" style="background: linear-gradient(135deg, var(--primary), var(--secondary));">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <h6 class="resource-title">When to Visit the Clinic</h6>
                        <i class="fas fa-chevron-down resource-toggle"></i>
                    </div>
                    <div class="resource-content" id="clinic-visit-content">
                        <ul class="resource-list">
                            <li><strong>Emergency Situations:</strong> Severe pain, difficulty breathing, chest pain, or any life-threatening condition - seek immediate medical attention</li>
                            <li><strong>Urgent Care:</strong> High fever (>101°F), severe headache, vomiting, or injury requiring stitches</li>
                            <li><strong>Routine Visits:</strong> Annual check-ups, vaccinations, or follow-up appointments</li>
                            <li><strong>Health Concerns:</strong> Persistent symptoms, new allergies, or changes in health status</li>
                            <li><strong>Medication Issues:</strong> Side effects from medications or need for prescription refills</li>
                        </ul>
                    </div>
                </div>

                <div class="resource-card" onclick="toggleResource('first-aid')">
                    <div class="resource-header">
                        <div class="resource-icon" style="background: linear-gradient(135deg, var(--success), #34d399);">
                            <i class="fas fa-medkit"></i>
                        </div>
                        <h6 class="resource-title">First Aid Tips</h6>
                        <i class="fas fa-chevron-down resource-toggle"></i>
                    </div>
                    <div class="resource-content" id="first-aid-content">
                        <div class="first-aid-tips">
                            <div class="tip-item">
                                <strong>Bleeding:</strong> Apply direct pressure with a clean cloth. Elevate the wound above heart level if possible.
                            </div>
                            <div class="tip-item">
                                <strong>Burns:</strong> Cool the burn with running water for 10-15 minutes. Cover with a clean, dry dressing.
                            </div>
                            <div class="tip-item">
                                <strong>Choking:</strong> Perform the Heimlich maneuver. For children, use back blows and chest thrusts.
                            </div>
                            <div class="tip-item">
                                <strong>Sprains:</strong> Rest, Ice, Compression, Elevation (RICE method). Seek medical attention if severe.
                            </div>
                            <div class="tip-item">
                                <strong>CPR:</strong> For adults, push hard and fast in the center of the chest at 100-120 compressions per minute.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="resource-card" onclick="toggleResource('navigation')">
                    <div class="resource-header">
                        <div class="resource-icon" style="background: linear-gradient(135deg, var(--info), #60a5fa);">
                            <i class="fas fa-compass"></i>
                        </div>
                        <h6 class="resource-title">System Navigation Help</h6>
                        <i class="fas fa-chevron-down resource-toggle"></i>
                    </div>
                    <div class="resource-content" id="navigation-content">
                        <div class="navigation-guide">
                            <div class="nav-section">
                                <strong>Dashboard:</strong> Overview of your health information, recent visits, and quick stats.
                            </div>
                            <div class="nav-section">
                                <strong>My Medical:</strong> View your medical history, vitals, and clinic visit records.
                            </div>
                            <div class="nav-section">
                                <strong>Health Form:</strong> Complete and update your health information and emergency contacts.
                            </div>
                            <div class="nav-section">
                                <strong>Profile:</strong> Update your personal information and account settings.
                            </div>
                            <div class="nav-section">
                                <strong>Quick Actions:</strong> Use the top navigation to switch between sections quickly.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Educational Video Section -->
        <div class="section-card">
            <div class="section-header">
                <h5 class="section-title">
                    <i class="fas fa-video"></i>
                    How to take Care of Your Health
                </h5>
            </div>
            <div class="video-container" style="text-align: center; padding: 1rem;">
                <div style="position: relative; width: 100%; max-width: 1400px; margin: 0 auto;">
                    <div style="padding-bottom: 56.25%; position: relative; height: 0;">
                        <iframe src="https://www.youtube.com/embed/UxnEuj1c0sw" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border-radius: 0.75rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function editAllergies() {
            // Fetch current allergies
            fetch('/student/allergies', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.allergies) {
                    populateAllergiesModal(data.allergies);
                }
                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('allergiesModal'));
                modal.show();
            })
            .catch(error => {
                console.error('Error fetching allergies:', error);
                alert('Error loading allergies. Please try again.');
            });
        }

        function populateAllergiesModal(allergies) {
            const container = document.getElementById('allergiesContainer');
            container.innerHTML = '';

            if (allergies.length === 0) {
                container.innerHTML = '<p class="text-muted">No allergies recorded yet.</p>';
                return;
            }

            allergies.forEach((allergy, index) => {
                const allergyDiv = document.createElement('div');
                allergyDiv.className = 'mb-3 p-3 border rounded';
                allergyDiv.innerHTML = `
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Allergy Name</label>
                            <input type="text" class="form-control" name="allergies[${index}][allergy_name]" value="${allergy.allergy_name}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Severity</label>
                            <select class="form-control" name="allergies[${index}][severity]" required>
                                <option value="mild" ${allergy.severity === 'mild' ? 'selected' : ''}>Mild</option>
                                <option value="moderate" ${allergy.severity === 'moderate' ? 'selected' : ''}>Moderate</option>
                                <option value="severe" ${allergy.severity === 'severe' ? 'selected' : ''}>Severe</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" class="btn btn-danger btn-sm" onclick="removeAllergy(this)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                `;
                container.appendChild(allergyDiv);
            });
        }

        function addAllergy() {
            const container = document.getElementById('allergiesContainer');
            const index = container.children.length;

            const allergyDiv = document.createElement('div');
            allergyDiv.className = 'mb-3 p-3 border rounded';
            allergyDiv.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Allergy Name</label>
                        <input type="text" class="form-control" name="allergies[${index}][allergy_name]" placeholder="e.g., Peanuts, Penicillin" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Severity</label>
                        <select class="form-control" name="allergies[${index}][severity]" required>
                            <option value="mild">Mild</option>
                            <option value="moderate">Moderate</option>
                            <option value="severe">Severe</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-sm" onclick="removeAllergy(this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            container.appendChild(allergyDiv);
        }

        function removeAllergy(button) {
            button.closest('.mb-3').remove();
            // Re-index the remaining allergies
            const container = document.getElementById('allergiesContainer');
            Array.from(container.children).forEach((div, index) => {
                const inputs = div.querySelectorAll('input, select');
                inputs.forEach(input => {
                    const name = input.name.replace(/\[\d+\]/, `[${index}]`);
                    input.name = name;
                });
            });
        }

        function saveAllergies() {
            const allergies = [];
            const container = document.getElementById('allergiesContainer');
            const allergyDivs = container.querySelectorAll('.mb-3');

            allergyDivs.forEach(div => {
                const allergyName = div.querySelector('input[name*="[allergy_name]"]').value.trim();
                const severity = div.querySelector('select[name*="[severity]"]').value;

                if (allergyName) {
                    allergies.push({
                        allergy_name: allergyName,
                        severity: severity
                    });
                }
            });

            // Send to server
            fetch('/student/allergies', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                credentials: 'same-origin',
                body: JSON.stringify({ allergies: allergies })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Close modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('allergiesModal'));
                    modal.hide();

                    // Show success message
                    showAlert('success', data.message);

                    // Update allergies section dynamically instead of reloading page
                    setTimeout(() => {
                        updateAllergiesSection(allergies);
                        updateAllergiesStats(allergies.length);
                    }, 500);
                } else {
                    showAlert('error', 'Error updating allergies. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error saving allergies:', error);
                showAlert('error', 'Error saving allergies. Please try again.');
            });
        }

        function updateAllergiesSection(allergies) {
            const allergiesGrid = document.querySelector('.allergies-grid');

            if (allergies.length === 0) {
                allergiesGrid.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-check-circle"></i>
                        <p>No known allergies recorded</p>
                    </div>
                `;
            } else {
                let html = '';
                allergies.forEach(allergy => {
                    html += `
                        <div class="allergy-badge">
                            <div class="allergy-icon">
                                <i class="fas fa-exclamation-circle"></i>
                            </div>
                            <div class="allergy-info">
                                <strong>${allergy.allergy_name}</strong>
                                <small>Severity: ${allergy.severity}</small>
                            </div>
                        </div>
                    `;
                });
                allergiesGrid.innerHTML = html;
            }
        }

        function updateAllergiesStats(count) {
            // Update the allergies count in the stats card
            const allergyStatValue = document.querySelector('.stat-card:nth-child(3) .stat-value');
            if (allergyStatValue) {
                allergyStatValue.textContent = count;
            }

            // Update the tooltip text
            const tooltipText = document.querySelector('.stat-card:nth-child(3) .tooltip-text');
            if (tooltipText) {
                const tooltipDiv = tooltipText.querySelector('.tooltip-section:first-child');
                if (tooltipDiv) {
                    tooltipDiv.textContent = `You have ${count} recorded allergies.`;
                }
            }
        }

        function showAlert(type, message) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
            alertDiv.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

            const container = document.querySelector('.container.mt-4');
            container.insertBefore(alertDiv, container.firstChild);

            // Auto-dismiss after 5 seconds
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 5000);
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

        // Health Resources toggle functionality with enhanced effects
        function toggleResource(resourceId) {
            const card = event.currentTarget;
            const content = document.getElementById(resourceId + '-content');
            const icon = card.querySelector('.resource-icon');
            const toggleIcon = card.querySelector('.resource-toggle');

            // Toggle active class on card
            card.classList.toggle('active');

            // Add visual feedback effects
            if (card.classList.contains('active')) {
                // Create expanding effect
                createExpandingEffect(card);
                createFloatingEmojis(card, resourceId);

                // Animate icon
                icon.style.animation = 'pulse 0.6s ease-in-out';
                setTimeout(() => {
                    icon.style.animation = '';
                }, 600);

                // Rotate toggle icon
                toggleIcon.style.transform = 'rotate(180deg) scale(1.2)';
                setTimeout(() => {
                    toggleIcon.style.transform = 'rotate(180deg) scale(1)';
                }, 300);

                // Scroll into view with delay
                setTimeout(() => {
                    content.scrollIntoView({
                        behavior: 'smooth',
                        block: 'nearest'
                    });
                }, 300);
            } else {
                // Reset toggle icon
                toggleIcon.style.transform = 'rotate(0deg)';

                // Add closing effect
                createClosingEffect(card);
            }
        }

        // Create expanding circle effect
        function createExpandingEffect(card) {
            const effect = document.createElement('div');
            effect.className = 'expand-effect';
            effect.style.cssText = `
                position: absolute;
                top: 50%;
                left: 50%;
                width: 0;
                height: 0;
                border-radius: 50%;
                background: radial-gradient(circle, rgba(79, 70, 229, 0.3) 0%, transparent 70%);
                transform: translate(-50%, -50%);
                pointer-events: none;
                z-index: 1;
                animation: expand 0.8s ease-out forwards;
            `;
            card.style.position = 'relative';
            card.appendChild(effect);

            setTimeout(() => {
                effect.remove();
            }, 800);
        }

        // Create floating emojis effect
        function createFloatingEmojis(card, resourceId) {
            const emojis = {
                'clinic-visit': ['🏥', '👨‍⚕️', '💊', '📅'],
                'first-aid': ['🩹', '❤️', '🩺', '🚑'],
                'navigation': ['🧭', '📍', '🗺️', '⭐']
            };

            const selectedEmojis = emojis[resourceId] || ['✨', '⭐', '🌟'];

            for (let i = 0; i < 5; i++) {
                setTimeout(() => {
                    const emoji = document.createElement('div');
                    emoji.textContent = selectedEmojis[Math.floor(Math.random() * selectedEmojis.length)];
                    emoji.style.cssText = `
                        position: absolute;
                        top: ${20 + Math.random() * 60}%;
                        left: ${20 + Math.random() * 60}%;
                        font-size: 1.5rem;
                        pointer-events: none;
                        z-index: 10;
                        animation: floatUp 2s ease-out forwards;
                        opacity: 0.8;
                    `;
                    card.style.position = 'relative';
                    card.appendChild(emoji);

                    setTimeout(() => {
                        emoji.remove();
                    }, 2000);
                }, i * 100);
            }
        }

        // Create closing effect
        function createClosingEffect(card) {
            const effect = document.createElement('div');
            effect.className = 'close-effect';
            effect.style.cssText = `
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(45deg, transparent, rgba(239, 68, 68, 0.1), transparent);
                pointer-events: none;
                z-index: 1;
                animation: fadeOut 0.5s ease-out forwards;
            `;
            card.appendChild(effect);

            setTimeout(() => {
                effect.remove();
            }, 500);
        }

        // Dropdown toggle functionality
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('show');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('userDropdown');
            const userBtn = event.target.closest('.user-btn');

            if (!userBtn && !dropdown.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });

        // Allergies modal functionality
        function openAllergiesModal() {
            // Fetch current allergies
            fetch('/student/allergies', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.allergies) {
                    populateAllergiesModal(data.allergies);
                }
                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('allergiesModal'));
                modal.show();
            })
            .catch(error => {
                console.error('Error fetching allergies:', error);
                alert('Error loading allergies. Please try again.');
            });
        }

        // Advanced Filters functionality
        function toggleFilters() {
            const filtersSection = document.getElementById('filtersSection');
            const filterBtn = event.target.closest('button');

            if (filtersSection.style.display === 'none' || filtersSection.style.display === '') {
                filtersSection.style.display = 'block';
                filterBtn.innerHTML = '<i class="fas fa-times"></i>Hide Filters';
                filterBtn.classList.remove('btn-outline');
                filterBtn.classList.add('btn-primary');
            } else {
                filtersSection.style.display = 'none';
                filterBtn.innerHTML = '<i class="fas fa-filter"></i>Filters';
                filterBtn.classList.remove('btn-primary');
                filterBtn.classList.add('btn-outline');
            }
        }

        function applyFilters() {
            const dateFilter = document.getElementById('dateFilter').value;
            const categoryFilter = document.getElementById('categoryFilter').value;
            const statusFilter = document.getElementById('statusFilter').value;

            const healthItems = document.querySelectorAll('.health-item');

            healthItems.forEach(item => {
                let showItem = true;

                // Date filter (placeholder - would need actual date data)
                if (dateFilter !== 'all') {
                    // Implement date filtering logic here
                    // For now, show all items
                }

                // Category filter
                if (categoryFilter !== 'all') {
                    const itemLabel = item.querySelector('.health-item-label').textContent.toLowerCase();
                    if (categoryFilter === 'vitals' && !['height', 'weight', 'bmi'].includes(itemLabel)) {
                        showItem = false;
                    } else if (categoryFilter === 'measurements' && !['height', 'weight', 'age'].includes(itemLabel)) {
                        showItem = false;
                    } else if (categoryFilter === 'personal' && !['age', 'blood type'].includes(itemLabel)) {
                        showItem = false;
                    }
                }

                // Status filter
                if (statusFilter !== 'all') {
                    const itemValue = item.querySelector('.health-item-value').textContent.toLowerCase();
                    if (statusFilter === 'complete' && (itemValue === 'not set' || itemValue === 'n/a')) {
                        showItem = false;
                    } else if (statusFilter === 'incomplete' && itemValue !== 'not set' && itemValue !== 'n/a') {
                        showItem = false;
                    }
                }

                item.style.display = showItem ? 'block' : 'none';
            });

            // Show feedback
            showAlert('success', 'Filters applied successfully!');
        }

        function resetFilters() {
            // Reset all filter selects
            document.getElementById('dateFilter').value = 'all';
            document.getElementById('categoryFilter').value = 'all';
            document.getElementById('statusFilter').value = 'all';

            // Show all health items
            const healthItems = document.querySelectorAll('.health-item');
            healthItems.forEach(item => {
                item.style.display = 'block';
            });

            // Show feedback
            showAlert('success', 'Filters reset successfully!');
        }
    </script>

    <!-- Allergies Edit Modal -->
    <div class="modal fade" id="allergiesModal" tabindex="-1" aria-labelledby="allergiesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="allergiesModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Edit Allergies
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="allergiesForm">
                        <div id="allergiesContainer">
                            <!-- Allergies will be populated here -->
                        </div>
                        <div class="text-center mt-3">
                            <button type="button" class="btn btn-outline-primary" onclick="addAllergy()">
                                <i class="fas fa-plus me-2"></i>Add Allergy
                            </button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveAllergies()">
                        <i class="fas fa-save me-2"></i>Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
