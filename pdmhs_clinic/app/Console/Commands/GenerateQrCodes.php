<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class GenerateQrCodes extends Command
{
    protected $signature = 'generate:qr-codes';
    protected $description = 'Generate QR codes for all students';

    public function handle()
    {
        $this->info('Generating QR codes for all students...');

        // Create QR codes directory if it doesn't exist
        $qrDir = public_path('qr_codes');
        if (!is_dir($qrDir)) {
            mkdir($qrDir, 0755, true);
        }

        // Get all students
        $students = Student::all();

        foreach ($students as $student) {
            // Create QR data as JSON
            $qrData = json_encode([
                'student_id' => $student->student_id, // Use accessor value
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

            $this->line("Generated QR code for {$student->first_name} {$student->last_name} (ID: {$student->getOriginal('student_id')})");
        }

        $this->info("\nQR codes generated successfully! Files saved to: {$qrDir}");
        $this->info("You can access them at: /qr_codes/student_{id}.png");
    }
}
