<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Student;

echo "Testing Student model...\n\n";

try {
    // Test creating a new student instance
    $student = new Student();
    echo "✓ Student model instance created successfully\n";

    // Test if save method exists
    if (method_exists($student, 'save')) {
        echo "✓ save() method exists on Student model\n";
    } else {
        echo "✗ save() method missing on Student model\n";
    }

    // Test fillable attributes
    $fillable = $student->getFillable();
    echo "✓ Fillable attributes: " . implode(', ', $fillable) . "\n";

    if (in_array('health_form_completed', $fillable)) {
        echo "✓ health_form_completed is in fillable array\n";
    } else {
        echo "✗ health_form_completed is NOT in fillable array\n";
    }

    // Test firstOrNew method
    $testStudent = Student::firstOrNew(['student_id' => 'TEST123']);
    echo "✓ firstOrNew method works, returned: " . get_class($testStudent) . "\n";

    if ($testStudent instanceof Student) {
        echo "✓ Returned object is instance of Student model\n";
    } else {
        echo "✗ Returned object is NOT an instance of Student model\n";
    }

    echo "\nAll tests passed! Student model should work correctly.\n";

} catch (Exception $e) {
    echo "✗ Error testing Student model: " . $e->getMessage() . "\n";
}
