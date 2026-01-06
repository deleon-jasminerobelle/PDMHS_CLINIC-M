<?php

require_once 'vendor/autoload.php';

use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use App\Http\Controllers\HealthFormController;
use App\Models\Adviser;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Testing Health Form Controller...\n\n";

// Test 1: Check if advisers are loaded
echo "Test 1: Checking advisers in database...\n";
$advisers = Adviser::where('is_active', true)->get();
echo "Found " . $advisers->count() . " active advisers:\n";
foreach ($advisers as $adviser) {
    echo "- " . $adviser->first_name . " " . $adviser->last_name . "\n";
}
echo "\n";

// Test 2: Test controller index method
echo "Test 2: Testing HealthFormController index method...\n";
try {
    $controller = new HealthFormController();
    $response = $controller->index();

    if ($response instanceof \Illuminate\View\View) {
        echo "✓ Controller returned a view successfully\n";
        $viewData = $response->getData();
        if (isset($viewData['advisers'])) {
            echo "✓ Advisers variable is set in view data\n";
            echo "Advisers count in view: " . $viewData['advisers']->count() . "\n";
        } else {
            echo "✗ Advisers variable not found in view data\n";
        }
    } else {
        echo "✗ Controller did not return a view\n";
    }
} catch (Exception $e) {
    echo "✗ Error in controller: " . $e->getMessage() . "\n";
}

echo "\nTest completed!\n";
