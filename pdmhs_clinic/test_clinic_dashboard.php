<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Testing clinic dashboard controller...\n";

try {
    // Simulate authentication
    $user = \App\Models\User::where('email', 'nurse@pdmhs.edu.ph')->first();
    if (!$user) {
        echo "User not found\n";
        exit;
    }

    \Illuminate\Support\Facades\Auth::login($user);
    echo "User authenticated: " . $user->name . " (" . $user->role . ")\n";

    // Create controller instance
    $controller = new \App\Http\Controllers\ClinicStaffController();

    // Call the method
    try {
        $response = $controller->clinicDashboard();

        echo "Controller method executed successfully\n";
        echo "Response type: " . get_class($response) . "\n";

        if ($response instanceof \Illuminate\View\View) {
            echo "View name: " . $response->getName() . "\n";
            echo "View data keys: " . implode(', ', array_keys($response->getData())) . "\n";
        } elseif ($response instanceof \Illuminate\Http\RedirectResponse) {
            echo "Redirect response to: " . $response->getTargetUrl() . "\n";
        }
    } catch (\Exception $e) {
        echo "Exception in controller: " . $e->getMessage() . "\n";
        echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    }

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
