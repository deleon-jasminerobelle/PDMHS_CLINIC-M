<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Checking all users in database:\n\n";

$users = \App\Models\User::all();
if ($users->isEmpty()) {
    echo "No users found in database!\n";
    echo "Creating test users...\n";

    $users = [
        'student' => ['email'=>'student@pdmhs.edu.ph','password'=>'student123','name'=>'Hannah Loraine Geronday','role'=>'student'],
        'clinic_staff' => ['email'=>'nurse@pdmhs.edu.ph','password'=>'nurse123','name'=>'Maria Santos','role'=>'clinic_staff'],
        'adviser' => ['email'=>'adviser@pdmhs.edu.ph','password'=>'adviser123','name'=>'John Doe','role'=>'adviser']
    ];

    foreach ($users as $user) {
        \App\Models\User::updateOrCreate(
            ['email'=>$user['email']],
            [
                'name'=>$user['name'],
                'password'=>\Illuminate\Support\Facades\Hash::make($user['password']),
                'role'=>$user['role'],
                'email_verified_at'=>now(),
            ]
        );
    }

    echo "Test users created successfully!\n\n";
    $users = \App\Models\User::all();
}

foreach ($users as $user) {
    echo "ID: {$user->id}\n";
    echo "Email: {$user->email}\n";
    echo "Name: {$user->name}\n";
    echo "Role: {$user->role}\n";
    echo "Password Hash: " . substr($user->password, 0, 20) . "...\n";

    // Test password verification for known users
    $testPasswords = [
        'student@pdmhs.edu.ph' => 'student123',
        'nurse@pdmhs.edu.ph' => 'nurse123',
        'adviser@pdmhs.edu.ph' => 'adviser123'
    ];

    if (isset($testPasswords[$user->email])) {
        $password = $testPasswords[$user->email];
        if (\Illuminate\Support\Facades\Hash::check($password, $user->password)) {
            echo "✓ Password verification: SUCCESS\n";
        } else {
            echo "✗ Password verification: FAILED\n";
        }
    }

    echo "---\n";
}

echo "\nTest login credentials:\n";
echo "Student: student@pdmhs.edu.ph / student123\n";
echo "Clinic Staff: nurse@pdmhs.edu.ph / nurse123\n";
echo "Adviser: adviser@pdmhs.edu.ph / adviser123\n";
