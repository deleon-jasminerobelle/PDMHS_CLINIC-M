<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Medical Visits History</title>
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
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        
        .back-btn {
            background: var(--gradient);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: opacity 0.2s ease;
        }
        
        .back-btn:hover {
            opacity: 0.9;
            color: white;
            text-decoration: none;
        }
        
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        
        .page-title {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 700;
            font-size: 1.8rem;
            color: #2c3e50;
            margin: 0;
        }
        
        .filter-section {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        
        .filter-row {
            display: flex;
            gap: 1rem;
            align-items: end;
        }
        
        .filter-group {
            flex: 1;
        }
        
        .filter-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        
        .form-control, .form-select {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 0.75rem;
            font-size: 0.95rem;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
        }
        
        .btn-filter {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
        }
        
        .btn-filter:hover {
            background-color: #0056b3;
        }
        
        .visits-section {
            background: white;
            border-radius: 12px;
            padding: 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        
        .visits-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e9ecef;
            font-weight: 600;
            color: #2c3e50;
        }
        
        .visit-card {
            padding: 1.5rem;
            border-bottom: 1px solid #f1f3f4;
            transition: background-color 0.2s ease;
        }
        
        .visit-card:hover {
            background-color: #f8f9fa;
        }
        
        .visit-card:last-child {
            border-bottom: none;
        }
        
        .visit-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }
        
        .visit-date {
            font-weight: 700;
            color: #2c3e50;
            font-size: 1.1rem;
        }
        
        .visit-time {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .visit-status {
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .status-completed {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .visit-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }
        
        .detail-item {
            display: flex;
            flex-direction: column;
        }
        
        .detail-label {
            font-size: 0.85rem;
            color: #6c757d;
            font-weight: 500;
            margin-bottom: 0.25rem;
        }
        
        .detail-value {
            font-weight: 600;
            color: #2c3e50;
        }
        
        .visit-reason {
            background-color: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            margin-top: 1rem;
        }
        
        .reason-label {
            font-size: 0.85rem;
            color: #6c757d;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        
        .reason-text {
            color: #2c3e50;
            margin: 0;
        }
        
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #6c757d;
        }
        
        .empty-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
        
        @media (max-width: 768px) {
            .filter-row {
                flex-direction: column;
                align-items: stretch;
            }
            
            .visit-header {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .visit-details {
                grid-template-columns: 1fr;
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
                    <i class="fas fa-tachometer-alt"></i>Dashboard
                </a>
                <a class="nav-link" href="{{ route('student.medical') }}">
                    <i class="fas fa-notes-medical"></i>My Medical
                </a>
            </div>
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user me-1"></i>
                        {{ $user->name }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('student.profile') }}"><i class="fas fa-user-edit me-2"></i>Profile</a></li>
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
        <!-- Back Button -->
        <div class="mb-3">
            <a href="{{ route('student.medical') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i>
                Back to Medical Records
            </a>
        </div>

        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Medical Visits History</h1>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-row">
                <div class="filter-group">
                    <label class="filter-label">Date Range</label>
                    <select class="form-select">
                        <option>Last 30 days</option>
                        <option>Last 3 months</option>
                        <option>Last 6 months</option>
                        <option>Last year</option>
                        <option>All time</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Visit Type</label>
                    <select class="form-select">
                        <option>All visits</option>
                        <option>Regular checkup</option>
                        <option>Illness</option>
                        <option>Injury</option>
                        <option>Emergency</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Status</label>
                    <select class="form-select">
                        <option>All status</option>
                        <option>Completed</option>
                        <option>Pending</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">&nbsp;</label>
                    <button class="btn btn-filter">
                        <i class="fas fa-search me-1"></i>Filter
                    </button>
                </div>
            </div>
        </div>

        <!-- Visits History Section -->
        <div class="visits-section">
            <div class="visits-header">
                <i class="fas fa-clipboard-list me-2"></i>Visit History ({{ count($clinicVisits) }} visits)
            </div>

            @if(count($clinicVisits) > 0)
                @foreach($clinicVisits as $visit)
                <div class="visit-card">
                    <div class="visit-header">
                        <div>
                            <div class="visit-date">{{ $visit['date'] }}</div>
                            <div class="visit-time">{{ $visit['time'] }}</div>
                        </div>
                        <span class="visit-status {{ $visit['status'] == 'Completed' ? 'status-completed' : 'status-pending' }}">
                            {{ $visit['status'] }}
                        </span>
                    </div>
                    
                    <div class="visit-details">
                        <div class="detail-item">
                            <span class="detail-label">Visit Type</span>
                            <span class="detail-value">{{ $visit['type'] }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Attended By</span>
                            <span class="detail-value">{{ $visit['attendedBy'] }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Temperature</span>
                            <span class="detail-value">{{ $visit['temperature'] ?? 'Not recorded' }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Blood Pressure</span>
                            <span class="detail-value">{{ $visit['bloodPressure'] ?? 'Not recorded' }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Weight</span>
                            <span class="detail-value">{{ $visit['weight'] ?? 'Not recorded' }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Height</span>
                            <span class="detail-value">{{ $visit['height'] ?? 'Not recorded' }}</span>
                        </div>
                    </div>
                    
                    @if(isset($visit['reason']) && $visit['reason'])
                    <div class="visit-reason">
                        <div class="reason-label">Reason for Visit</div>
                        <p class="reason-text">{{ $visit['reason'] }}</p>
                    </div>
                    @endif
                </div>
                @endforeach
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <h4>No Medical Visits Found</h4>
                    <p>You haven't had any medical visits recorded yet.</p>
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>