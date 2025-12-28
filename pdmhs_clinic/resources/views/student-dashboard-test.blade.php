<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard Test - PDMHS Clinic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1>Student Dashboard Test</h1>
        <p>User: {{ $user->name ?? 'No user' }}</p>
        <p>Role: {{ $user->role ?? 'No role' }}</p>
        <p>Age: {{ $age ?? 'No age' }}</p>
        <p>Total Visits: {{ $totalVisits ?? 'No visits' }}</p>
        
        <div class="alert alert-success">
            This is a test page to verify the student dashboard is working.
        </div>
        
        <a href="{{ route('student.dashboard') }}" class="btn btn-primary">Back to Dashboard</a>
    </div>
</body>
</html>