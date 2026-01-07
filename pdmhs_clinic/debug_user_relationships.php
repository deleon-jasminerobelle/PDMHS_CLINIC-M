<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Adviser;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

echo "=== Checking User Relationships for Zyrah's Students ===\n\n";

// Find Zyrah's adviser record
$adviser = Adviser::where('first_name', 'Zyrah')->where('last_name', 'De Leon')->first();
if (!$adviser) {
    echo "❌ Zyrah's adviser record not found!\n";
    exit(1);
}

echo "✅ Found Zyrah's adviser record (ID: {$adviser->id})\n";

// Get students via relationship
$students = $adviser->students;
$studentCount = $students->count();

echo "Students via relationship: {$studentCount}\n\n";

$missingUsers = [];
$validUsers = 0;

foreach ($students as $student) {
    $user = $student->user;
    if (!$user) {
        $missingUsers[] = $student->id;
        echo "❌ Student ID {$student->id} ({$student->first_name} {$student->last_name}) has no user relationship!\n";
    } else {
        $validUsers++;
        echo "✅ Student ID {$student->id} ({$student->first_name} {$student->last_name}) has user: {$user->name}\n";
    }
}

echo "\nSummary:\n";
echo "- Total students: {$studentCount}\n";
echo "- Students with users: {$validUsers}\n";
echo "- Students missing users: " . count($missingUsers) . "\n";

if (count($missingUsers) > 0) {
    echo "\nMissing user IDs: " . implode(', ', $missingUsers) . "\n";
    echo "\nThis could cause the view to break when trying to access user->name!\n";
}

echo "\n=== Debug Complete ===\n";
