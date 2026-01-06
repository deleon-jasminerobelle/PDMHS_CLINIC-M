<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Creating/updating test users...\n";

$users = [
    'student' => ['email'=>'student@pdmhs.edu.ph','password'=>'student123','name'=>'Hannah Loraine Geronday','role'=>'student'],
    'clinic_staff' => ['email'=>'nurse@pdmhs.edu.ph','password'=>'nurse123','name'=>'Maria Santos','role'=>'clinic_staff'],
    'adviser' => ['email'=>'adviser@pdmhs.edu.ph','password'=>'adviser123','name'=>'John Doe','role'=>'adviser']
];

foreach ($users as $key => $userData) {
    $user = \App\Models\User::updateOrCreate(
        ['email'=>$userData['email']],
        [
            'name'=>$userData['name'],
            'password'=>\Illuminate\Support\Facades\Hash::make($userData['password']),
            'role'=>$userData['role'],
            'email_verified_at'=>now(),
        ]
    );

    echo "✓ Created/Updated {$key}: {$user->email}\n";

    // For student, ensure they have a student record
    if ($key === 'student') {
        $student = \App\Models\Student::firstOrCreate(
            ['student_id' => $user->email],
            [
                'first_name' => 'Hannah',
                'last_name' => 'Geronday',
                'date_of_birth' => '2005-01-01',
                'grade_level' => 12,
                'section' => 'A',
                'contact_number' => '09123456789',
                'emergency_contact_name' => 'Parent Name',
                'emergency_contact_number' => '09123456789',
                'emergency_relation' => 'Parent',
                'emergency_address' => 'Sample Address',
                'address' => 'Sample Address',
                'sex' => 'female',
            ]
        );

        // Link user to student
        $user->update(['student_id' => $student->id]);
        echo "✓ Linked student user to student record\n";
    }

    // For adviser, ensure they have an adviser record
    if ($key === 'adviser') {
        \App\Models\Adviser::firstOrCreate(
            ['user_id' => $user->id],
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'contact_number' => '09123456789',
                'email' => $user->email,
            ]
        );
        echo "✓ Created adviser record\n";
    }
}

echo "\nTest login credentials:\n";
echo "Student: student@pdmhs.edu.ph / student123\n";
echo "Clinic Staff: nurse@pdmhs.edu.ph / nurse123\n";
echo "Adviser: adviser@pdmhs.edu.ph / adviser123\n";
