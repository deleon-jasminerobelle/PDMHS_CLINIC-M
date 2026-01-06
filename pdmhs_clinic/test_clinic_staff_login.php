<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Testing clinic staff login...\n";

$user = \App\Models\User::where('email', 'nurse@pdmhs.edu.ph')->first();
if (!$user) {
    echo "Clinic staff user not found!\n";
    exit;
}

echo "User found: {$user->email} (role: {$user->role})\n";

// Test Auth::attempt
$credentials = [
    'email' => 'nurse@pdmhs.edu.ph',
    'password' => 'nurse123'
];

echo "Attempting login with credentials...\n";

if (\Illuminate\Support\Facades\Auth::attempt($credentials)) {
    echo "Login successful!\n";
    $authenticatedUser = \Illuminate\Support\Facades\Auth::user();
    echo "Authenticated user: {$authenticatedUser->email} (role: {$authenticatedUser->role})\n";
    echo "Auth check: " . (\Illuminate\Support\Facades\Auth::check() ? 'true' : 'false') . "\n";
} else {
    echo "Login failed!\n";
    echo "Auth check: " . (\Illuminate\Support\Facades\Auth::check() ? 'true' : 'false') . "\n";
}
