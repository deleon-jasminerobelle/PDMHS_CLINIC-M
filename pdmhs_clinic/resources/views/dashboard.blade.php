<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - PDMHS Clinic</title>
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
            --danger: #ef4444;
            --gradient: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to bottom right, #f8fafc, #e0f2fe);
            color: var(--dark);
            line-height: 1.6;
            min-height: 100vh;
        }

        /* Navigation */
        nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.05);
            border-bottom: 1px solid rgba(30, 64, 175, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
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

        .user-menu {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .user-info {
            text-align: right;
        }

        .user-name {
            font-weight: 700;
            color: var(--dark);
            font-size: 14px;
        }

        .user-role {
            font-size: 12px;
            color: var(--gray);
        }

        .logout-btn {
            background: var(--danger);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: #dc2626;
            transform: translateY(-2px);
        }

        /* Main Content */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }

        .dashboard-header {
            margin-bottom: 2rem;
        }

        .dashboard-header h1 {
            font-size: 2.5rem;
            font-weight: 900;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, var(--dark) 0%, var(--primary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .dashboard-header p {
            color: var(--gray);
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
            background: var(--white);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 8px 32px rgba(30, 64, 175, 0.1);
            border: 1px solid rgba(30, 64, 175, 0.1);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 48px rgba(30, 64, 175, 0.15);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .stat-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--gray);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-icon {
            font-size: 1.5rem;
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 900;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .stat-change {
            font-size: 0.8rem;
            font-weight: 600;
        }

        .stat-change.positive {
            color: var(--success);
        }

        .stat-change.negative {
            color: var(--danger);
        }

        /* Recent Activities */
        .recent-activities {
            background: var(--white);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 8px 32px rgba(30, 64, 175, 0.1);
            border: 1px solid rgba(30, 64, 175, 0.1);
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .activity-list {
            list-style: none;
        }

        .activity-item {
            display: flex;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid var(--light);
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            margin-right: 1rem;
        }

        .activity-content {
            flex: 1;
        }

        .activity-title {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.25rem;
        }

        .activity-meta {
            font-size: 0.8rem;
            color: var(--gray);
        }

        .activity-time {
            font-size: 0.8rem;
            color: var(--gray);
        }

        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 2rem;
        }

        .action-btn {
            background: var(--gradient);
            color: white;
            text-decoration: none;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 16px rgba(30, 64, 175, 0.2);
        }

        .action-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(30, 64, 175, 0.3);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .container {
                padding: 1rem;
            }

            .dashboard-header h1 {
                font-size: 2rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <nav>
        <div class="nav-container">
            <a href="{{ route('home') }}" class="logo">PDMHS</a>
            <ul class="nav-links">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('students.index') }}">Students</a></li>
                <li><a href="{{ route('clinic-visits.index') }}">Clinic Visits</a></li>
                <li><a href="{{ route('immunizations.index') }}">Immunizations</a></li>
                <li><a href="{{ route('health-incidents.index') }}">Health Incidents</a></li>
                <li><a href="{{ route('vitals.index') }}">Vitals</a></li>
            </ul>
            <div class="user-menu">
                <div class="user-info">
                    <div class="user-name">{{ $user->name }}</div>
                    <div class="user-role">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</div>
                </div>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container">
        @if (session('success'))
            <div class="alert alert-success" style="margin-bottom: 2rem; padding: 1rem; background: #d1fae5; color: #065f46; border-radius: 8px;">
                {{ session('success') }}
            </div>
        @endif

        <div class="dashboard-header">
            <h1>Dashboard</h1>
            <p>Welcome back, {{ $user->name }}! Here's what's happening at the clinic today.</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-title">Total Students</span>
                    <span class="stat-icon">👥</span>
                </div>
                <div class="stat-value">{{ number_format($stats['total_students']) }}</div>
                <div class="stat-change positive">Active students</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-title">Visits Today</span>
                    <span class="stat-icon">🏥</span>
                </div>
                <div class="stat-value">{{ number_format($stats['total_visits_today']) }}</div>
                <div class="stat-change">Today's appointments</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-title">Pending Visits</span>
                    <span class="stat-icon">⏳</span>
                </div>
                <div class="stat-value">{{ number_format($stats['pending_visits']) }}</div>
                <div class="stat-change">Awaiting completion</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-title">Immunizations</span>
                    <span class="stat-icon">💉</span>
                </div>
                <div class="stat-value">{{ number_format($stats['total_immunizations']) }}</div>
                <div class="stat-change">Total records</div>
            </div>
        </div>

        <div class="recent-activities">
            <h2 class="section-title">Recent Clinic Visits</h2>
            <ul class="activity-list">
                @forelse($recent_visits as $visit)
                <li class="activity-item">
                    <div class="activity-icon">🏥</div>
                    <div class="activity-content">
                        <div class="activity-title">
                            {{ $visit->student->first_name ?? 'Unknown' }} {{ $visit->student->last_name ?? 'Student' }} - Clinic Visit
                        </div>
                        <div class="activity-meta">{{ $visit->reason ?? 'No reason specified' }}</div>
                    </div>
                    <div class="activity-time">{{ $visit->created_at->format('M j, g:i A') }}</div>
                </li>
                @empty
                <li class="activity-item">
                    <div class="activity-icon">📝</div>
                    <div class="activity-content">
                        <div class="activity-title">No recent visits</div>
                        <div class="activity-meta">No clinic visits recorded yet</div>
                    </div>
                </li>
                @endforelse
            </ul>
        </div>

        <div class="quick-actions">
            <a href="{{ route('students.create') }}" class="action-btn">➕ Add New Student</a>
            <a href="{{ route('clinic-visits.create') }}" class="action-btn">🏥 New Clinic Visit</a>
            <a href="{{ route('immunizations.create') }}" class="action-btn">💉 Record Immunization</a>
            <a href="{{ route('health-incidents.create') }}" class="action-btn">🚨 Report Health Incident</a>
        </div>
    </div>
</body>
</html>