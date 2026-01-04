<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Creating test student record for Student Two...\n\n";

$user = \App\Models\User::where('name', 'Student Two')->first();
if ($user) {
    echo "Found user: {$user->name} (ID: {$user->id})\n";

    // Create a test student record with complete emergency contact data
    $student = \App\Models\Student::create([
        'student_id' => 'TEST001',
        'first_name' => 'Student',
        'last_name' => 'Two',
        'date_of_birth' => '2000-01-01',
        'grade_level' => 10,
        'section' => 'A',
        'school' => 'Test School',
        'sex' => 'M',
        'age' => 18,
        'emergency_contact_name' => 'Test Parent',
        'emergency_contact_number' => '09123456789',
        'emergency_relation' => 'Parent',
        'emergency_address' => 'Test Address 123',
        'contact_number' => '09123456789',
        'address' => 'Test Student Address'
    ]);

    // Link the user to the student
    $user->update(['student_id' => $student->id]);

    echo "Created student record (ID: {$student->id}) and linked to user\n";
    echo "Student has complete emergency contact data:\n";
    echo "- Name: {$student->emergency_contact_name}\n";
    echo "- Number: {$student->emergency_contact_number}\n";
    echo "- Relation: {$student->emergency_relation}\n";
    echo "- Address: {$student->emergency_address}\n";
} else {
    echo "User 'Student Two' not found\n";
}
