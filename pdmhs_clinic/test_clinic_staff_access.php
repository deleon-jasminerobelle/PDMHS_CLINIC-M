<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

// Test clinic staff access
echo "Testing clinic staff dashboard access...\n";

// Find clinic staff user
$user = User::where('email', 'nurse@pdmhs.edu.ph')->first();

if (!$user) {
    echo "Clinic staff user not found!\n";
    exit(1);
}

echo "User found: {$user->email} (role: {$user->role})\n";

// Simulate login
Auth::login($user);
echo "User logged in successfully\n";

// Check if authenticated
if (Auth::check()) {
    echo "Auth check: true\n";
    echo "Current user: " . Auth::user()->email . " (role: " . Auth::user()->role . ")\n";
} else {
    echo "Auth check: false\n";
    exit(1);
}

// Try to access the clinic staff dashboard route
try {
    $response = app('router')->dispatch(request()->create('/clinic-staff/dashboard', 'GET'));
    echo "Route access successful\n";
    echo "Response status: " . $response->getStatusCode() . "\n";
} catch (Exception $e) {
    echo "Route access failed: " . $e->getMessage() . "\n";
}

// Logout
Auth::logout();
echo "Test completed.\n";
