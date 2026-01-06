<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Checking clinic staff user:\n";
$user = \App\Models\User::where('email', 'nurse@pdmhs.edu.ph')->first();
if ($user) {
    echo "User found:\n";
    echo "ID: " . $user->id . "\n";
    echo "Email: " . $user->email . "\n";
    echo "Name: " . $user->name . "\n";
    echo "Role: " . $user->role . "\n";
    echo "Password hash: " . substr($user->password, 0, 20) . "...\n";

    // Test password verification
    $password = 'nurse123';
    if (\Illuminate\Support\Facades\Hash::check($password, $user->password)) {
        echo "Password verification: SUCCESS\n";
    } else {
        echo "Password verification: FAILED\n";
    }
} else {
    echo "User not found!\n";
}

echo "\nAll users in database:\n";
$allUsers = \App\Models\User::all();
foreach ($allUsers as $u) {
    echo $u->id . ': ' . $u->email . ' (' . $u->role . ")\n";
}
