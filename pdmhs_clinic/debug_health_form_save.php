<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Student;
use Illuminate\Support\Facades\Log;

echo "Debugging health form save issue...\n\n";

try {
    // Test 1: Create a new student instance
    echo "1. Testing Student model instantiation...\n";
    $student = new Student();
    echo "   ✓ Student instance created: " . get_class($student) . "\n";

    // Test 2: Check if save method exists
    echo "2. Testing save method existence...\n";
    if (method_exists($student, 'save')) {
        echo "   ✓ save() method exists\n";
    } else {
        echo "   ✗ save() method missing\n";
    }

    // Test 3: Check fillable attributes
    echo "3. Testing fillable attributes...\n";
    $fillable = $student->getFillable();
    echo "   Fillable attributes: " . implode(', ', $fillable) . "\n";

    if (in_array('health_form_completed', $fillable)) {
        echo "   ✓ health_form_completed is fillable\n";
    } else {
        echo "   ✗ health_form_completed is NOT fillable\n";
    }

    // Test 4: Try firstOrNew method
    echo "4. Testing firstOrNew method...\n";
    $testStudent = Student::firstOrNew(['student_id' => 'DEBUG123']);
    echo "   ✓ firstOrNew returned: " . get_class($testStudent) . "\n";

    if ($testStudent instanceof Student) {
        echo "   ✓ Returned object is Student instance\n";
    } else {
        echo "   ✗ Returned object is NOT Student instance: " . gettype($testStudent) . "\n";
    }

    // Test 5: Try setting attributes and saving
    echo "5. Testing attribute setting and save...\n";
    $testStudent->first_name = 'Debug';
    $testStudent->last_name = 'Test';
    $testStudent->health_form_completed = true;

    echo "   Student attributes before save:\n";
    echo "     - first_name: {$testStudent->first_name}\n";
    echo "     - last_name: {$testStudent->last_name}\n";
    echo "     - health_form_completed: " . ($testStudent->health_form_completed ? 'true' : 'false') . "\n";

    try {
        $result = $testStudent->save();
        echo "   ✓ Save successful, result: " . ($result ? 'true' : 'false') . "\n";
        echo "   ✓ Student ID after save: {$testStudent->id}\n";
    } catch (Exception $e) {
        echo "   ✗ Save failed with exception: " . $e->getMessage() . "\n";
        echo "   Exception type: " . get_class($e) . "\n";
        echo "   Stack trace:\n" . $e->getTraceAsString() . "\n";
    }

    // Test 6: Check database connection
    echo "6. Testing database connection...\n";
    try {
        $count = Student::count();
        echo "   ✓ Database connection works, student count: {$count}\n";
    } catch (Exception $e) {
        echo "   ✗ Database connection failed: " . $e->getMessage() . "\n";
    }

} catch (Exception $e) {
    echo "✗ Fatal error during testing: " . $e->getMessage() . "\n";
    echo "Exception type: " . get_class($e) . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\nDebugging completed.\n";
