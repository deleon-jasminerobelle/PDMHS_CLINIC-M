<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\User;

echo "Testing database connection...\n";

try {
    // Test database connection
    $pdo = DB::connection()->getPdo();
    echo "✓ Database connection successful\n";

    // Test user creation
    echo "Testing user creation...\n";
    $user = User::create([
        'name' => 'Test User',
        'email' => 'test' . time() . '@example.com',
        'password' => bcrypt('password'),
        'role' => 'student',
        'first_name' => 'Test',
        'last_name' => 'User',
        'birthday' => '2000-01-01',
        'gender' => 'male',
        'address' => 'Test Address',
        'contact_number' => '09123456789'
    ]);

    echo "✓ User created with ID: {$user->id}\n";
    echo "✓ User email: {$user->email}\n";

    // Verify user exists
    $foundUser = User::find($user->id);
    if ($foundUser) {
        echo "✓ User found in database\n";
    } else {
        echo "✗ User not found after creation\n";
    }

} catch (\Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}
