<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>My Medical Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:wght@400;500;600;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        
        .navbar-brand {
            font-weight: 600;
        }
        
        .navbar-nav .nav-link {
            font-family: 'Epilogue', sans-serif !important;
            font-size: 20px !important;
            font-weight: 600 !important;
        }
        
        .page-header {
            text-align: center;
            margin: 3rem 0;
        }
        
        .page-title {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 800;
            font-size: 2.5rem;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }
        
        .page-subtitle {
            color: #6c757d;
            font-size: 1.1rem;
        }
        
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: none;
            transition: transform 0.2s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-2px);
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            margin-bottom: 1rem;
        }
        
        .stat-icon.visits {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .stat-icon.recent {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        
        .stat-icon.allergies {
            background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2c3e50;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .stat-sublabel {
            font-size: 0.9rem;
            color: #6c757d;
            margin-top: 0.25rem;
        }
        
        .info-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: none;
            transition: transform 0.2s ease;
            cursor: pointer;
        }
        
        .info-card:hover {
            transform: translateY(-2px);
        }
        
        .info-card-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: white;
            margin-right: 1rem;
        }
        
        .info-card-icon.personal {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .info-card-icon.history {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        
        .info-card-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.25rem;
        }
        
        .info-card-description {
            color: #6c757d;
            font-size: 0.95rem;
            margin: 0;
        }
        
        .arrow-icon {
            color: #6c757d;
            font-size: 1.2rem;
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
                <a class="nav-link active" href="{{ route('student.medical') }}">
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

    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">My Medical Record</h1>
            <p class="page-subtitle">View and manage your medical information</p>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-5">
            <div class="col-md-4">
                <div class="stat-card text-center">
                    <div class="stat-icon visits mx-auto">
                        <i class="fas fa-stethoscope"></i>
                    </div>
                    <div class="stat-number">{{ $totalVisits ?? 2 }}</div>
                    <div class="stat-label">Total Visits</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card text-center">
                    <div class="stat-icon recent mx-auto">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="stat-number">{{ $recentVisits ?? 1 }}</div>
                    <div class="stat-label">Recent Visits</div>
                    <div class="stat-sublabel">Last 30 Days</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card text-center">
                    <div class="stat-icon allergies mx-auto">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="stat-number">{{ isset($allergies) && $allergies ? $allergies->count() : 2 }}</div>
                    <div class="stat-label">Allergies</div>
                </div>
            </div>
        </div>

        <!-- Information Cards -->
        <div class="row">
            <div class="col-12">
                <div class="info-card" onclick="window.location.href='{{ route('student.info') }}'">
                    <div class="d-flex align-items-center">
                        <div class="info-card-icon personal">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h3 class="info-card-title">Personal Medical Info</h3>
                            <p class="info-card-description">View and update your personal medical information, height, weight, allergies, and emergency contact</p>
                        </div>
                        <div class="arrow-icon">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="info-card" onclick="window.location.href='{{ route('student.medical-history') }}'">
                    <div class="d-flex align-items-center">
                        <div class="info-card-icon history">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h3 class="info-card-title">Medical Visits History</h3>
                            <p class="info-card-description">View your complete medical visit history and detailed visit information</p>
                        </div>
                        <div class="arrow-icon">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>