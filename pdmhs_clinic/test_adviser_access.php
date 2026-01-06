<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Testing adviser dashboard access...\n";

$user = \App\Models\User::where('email', 'adviser@pdmhs.edu.ph')->first();
if (!$user) {
    echo "Adviser user not found!\n";
    exit;
}

echo "User found: {$user->email} (role: {$user->role})\n";

// Test adviser record
$adviser = \App\Models\Adviser::where('user_id', $user->id)->with('students')->first();
if ($adviser) {
    echo "Adviser record found: {$adviser->first_name} {$adviser->last_name}\n";
    echo "Students count: {$adviser->students->count()}\n";
} else {
    echo "Adviser record not found!\n";
}

echo "Test completed.\n";
