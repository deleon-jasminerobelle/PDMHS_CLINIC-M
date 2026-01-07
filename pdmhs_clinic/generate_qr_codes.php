<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Student;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

// Create QR codes directory if it doesn't exist
$qrDir = __DIR__ . '/public/qr_codes';
if (!is_dir($qrDir)) {
    mkdir($qrDir, 0755, true);
}

echo "Generating QR codes for all students...\n";

// Get all students
$students = Student::all();

foreach ($students as $student) {
    // Create QR data as JSON
    $qrData = json_encode([
        'student_id' => $student->student_id, // Use the accessor
        'name' => $student->first_name . ' ' . $student->last_name,
        'grade_level' => $student->grade_level,
        'section' => $student->section
    ]);

    // Generate QR code
    $qrCode = QrCode::create($qrData)
        ->setSize(300)
        ->setMargin(10);

    $writer = new PngWriter();
    $result = $writer->write($qrCode);

    // Save QR code
    $filename = 'student_' . $student->id . '.png';
    $filepath = $qrDir . '/' . $filename;
    $result->saveToFile($filepath);

    echo "Generated QR code for {$student->first_name} {$student->last_name} (ID: {$student->student_id})\n";
}

echo "\nQR codes generated successfully! Files saved to: {$qrDir}\n";
echo "You can access them at: /qr_codes/student_{id}.png\n";
