<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ZyrahStudentsSeeder extends Seeder
{
    public function run()
    {
        $students = [
            // STEM Grade 11
            ['first_name' => 'Juan', 'last_name' => 'Dela Cruz', 'grade_level' => 11, 'section' => 'STEM-A', 'gender' => 'male'],
            ['first_name' => 'Maria', 'last_name' => 'Santos', 'grade_level' => 11, 'section' => 'STEM-A', 'gender' => 'female'],
            ['first_name' => 'Pedro', 'last_name' => 'Garcia', 'grade_level' => 11, 'section' => 'STEM-A', 'gender' => 'male'],
            ['first_name' => 'Ana', 'last_name' => 'Rodriguez', 'grade_level' => 11, 'section' => 'STEM-A', 'gender' => 'female'],
            ['first_name' => 'Carlos', 'last_name' => 'Martinez', 'grade_level' => 11, 'section' => 'STEM-A', 'gender' => 'male'],
            ['first_name' => 'Sofia', 'last_name' => 'Lopez', 'grade_level' => 11, 'section' => 'STEM-B', 'gender' => 'female'],
            ['first_name' => 'Miguel', 'last_name' => 'Gonzalez', 'grade_level' => 11, 'section' => 'STEM-B', 'gender' => 'male'],
            ['first_name' => 'Isabella', 'last_name' => 'Hernandez', 'grade_level' => 11, 'section' => 'STEM-B', 'gender' => 'female'],
            ['first_name' => 'Diego', 'last_name' => 'Perez', 'grade_level' => 11, 'section' => 'STEM-B', 'gender' => 'male'],
            ['first_name' => 'Valentina', 'last_name' => 'Torres', 'grade_level' => 11, 'section' => 'STEM-B', 'gender' => 'female'],

            // STEM Grade 12
            ['first_name' => 'Luis', 'last_name' => 'Flores', 'grade_level' => 12, 'section' => 'STEM-A', 'gender' => 'male'],
            ['first_name' => 'Camila', 'last_name' => 'Rivera', 'grade_level' => 12, 'section' => 'STEM-A', 'gender' => 'female'],
            ['first_name' => 'Antonio', 'last_name' => 'Gomez', 'grade_level' => 12, 'section' => 'STEM-A', 'gender' => 'male'],
            ['first_name' => 'Gabriela', 'last_name' => 'Diaz', 'grade_level' => 12, 'section' => 'STEM-A', 'gender' => 'female'],
            ['first_name' => 'Fernando', 'last_name' => 'Morales', 'grade_level' => 12, 'section' => 'STEM-A', 'gender' => 'male'],
            ['first_name' => 'Lucia', 'last_name' => 'Ortiz', 'grade_level' => 12, 'section' => 'STEM-B', 'gender' => 'female'],
            ['first_name' => 'Roberto', 'last_name' => 'Ramos', 'grade_level' => 12, 'section' => 'STEM-B', 'gender' => 'male'],
            ['first_name' => 'Elena', 'last_name' => 'Castro', 'grade_level' => 12, 'section' => 'STEM-B', 'gender' => 'female'],
            ['first_name' => 'Javier', 'last_name' => 'Ruiz', 'grade_level' => 12, 'section' => 'STEM-B', 'gender' => 'male'],
            ['first_name' => 'Paula', 'last_name' => 'Jimenez', 'grade_level' => 12, 'section' => 'STEM-B', 'gender' => 'female'],

            // ABM Grade 11
            ['first_name' => 'Alejandro', 'last_name' => 'Vargas', 'grade_level' => 11, 'section' => 'ABM-A', 'gender' => 'male'],
            ['first_name' => 'Daniela', 'last_name' => 'Silva', 'grade_level' => 11, 'section' => 'ABM-A', 'gender' => 'female'],
            ['first_name' => 'Ricardo', 'last_name' => 'Mendoza', 'grade_level' => 11, 'section' => 'ABM-A', 'gender' => 'male'],
            ['first_name' => 'Victoria', 'last_name' => 'Delgado', 'grade_level' => 11, 'section' => 'ABM-A', 'gender' => 'female'],
            ['first_name' => 'Emilio', 'last_name' => 'Guerrero', 'grade_level' => 11, 'section' => 'ABM-A', 'gender' => 'male'],
            ['first_name' => 'Natalia', 'last_name' => 'Sanchez', 'grade_level' => 11, 'section' => 'ABM-B', 'gender' => 'female'],
            ['first_name' => 'Francisco', 'last_name' => 'Romero', 'grade_level' => 11, 'section' => 'ABM-B', 'gender' => 'male'],
            ['first_name' => 'Carmen', 'last_name' => 'Alvarez', 'grade_level' => 11, 'section' => 'ABM-B', 'gender' => 'female'],
            ['first_name' => 'Eduardo', 'last_name' => 'Fernandez', 'grade_level' => 11, 'section' => 'ABM-B', 'gender' => 'male'],
            ['first_name' => 'Rosa', 'last_name' => 'Moreno', 'grade_level' => 11, 'section' => 'ABM-B', 'gender' => 'female'],

            // ABM Grade 12
            ['first_name' => 'Manuel', 'last_name' => 'Navarro', 'grade_level' => 12, 'section' => 'ABM-A', 'gender' => 'male'],
            ['first_name' => 'Andrea', 'last_name' => 'Gutierrez', 'grade_level' => 12, 'section' => 'ABM-A', 'gender' => 'female'],
            ['first_name' => 'Sergio', 'last_name' => 'Reyes', 'grade_level' => 12, 'section' => 'ABM-A', 'gender' => 'male'],
            ['first_name' => 'Monica', 'last_name' => 'Chavez', 'grade_level' => 12, 'section' => 'ABM-A', 'gender' => 'female'],
            ['first_name' => 'Rafael', 'last_name' => 'Medina', 'grade_level' => 12, 'section' => 'ABM-A', 'gender' => 'male'],
            ['first_name' => 'Patricia', 'last_name' => 'Herrera', 'grade_level' => 12, 'section' => 'ABM-B', 'gender' => 'female'],
            ['first_name' => 'Alberto', 'last_name' => 'Cortes', 'grade_level' => 12, 'section' => 'ABM-B', 'gender' => 'male'],
            ['first_name' => 'Claudia', 'last_name' => 'Pena', 'grade_level' => 12, 'section' => 'ABM-B', 'gender' => 'female'],
            ['first_name' => 'Victor', 'last_name' => 'Soto', 'grade_level' => 12, 'section' => 'ABM-B', 'gender' => 'male'],
            ['first_name' => 'Adriana', 'last_name' => 'Del Valle', 'grade_level' => 12, 'section' => 'ABM-B', 'gender' => 'female'],
        ];

        $allergies = [
            ['Peanuts', 'Shellfish'],
            ['Dust mites'],
            ['Milk', 'Eggs'],
            ['Pollen'],
            ['Cat hair'],
            ['Wheat'],
            ['Soy'],
            ['Tree nuts'],
            ['Fish'],
            ['Strawberries'],
            [], // No allergies
            ['Penicillin'],
            ['Aspirin'],
            ['Latex'],
            ['Mold'],
            ['Dog hair'],
            ['Chocolate'],
            ['Citrus'],
            ['Sesame'],
            ['Mustard'],
        ];

        $addresses = [
            '123 Main Street, Manila',
            '456 Rizal Avenue, Quezon City',
            '789 Bonifacio Drive, Makati',
            '321 Mabini Road, Pasig',
            '654 Aguinaldo Street, Taguig',
            '987 Roxas Boulevard, Paranaque',
            '147 P. Burgos Avenue, Caloocan',
            '258 Taft Avenue, Pasay',
            '369 España Boulevard, Manila',
            '741 Commonwealth Avenue, Quezon City',
            '852 Edsa Avenue, Mandaluyong',
            '963 C5 Road, Taguig',
            '159 Alabang-Zapote Road, Las Piñas',
            '357 South Superhighway, Makati',
            '468 Ortigas Avenue, Pasay',
            '579 BGC Boulevard, Taguig',
            '681 Araneta Avenue, Quezon City',
            '792 McKinley Parkway, Fort Bonifacio',
            '813 Ayala Avenue, Makati',
            '924 Poblacion Street, Muntinlupa',
        ];

        $emergencyContacts = [
            ['Maria Dela Cruz', '09123456789'],
            ['Pedro Santos', '09123456788'],
            ['Ana Garcia', '09123456787'],
            ['Carlos Rodriguez', '09123456786'],
            ['Sofia Martinez', '09123456785'],
            ['Miguel Lopez', '09123456784'],
            ['Isabella Gonzalez', '09123456783'],
            ['Diego Hernandez', '09123456782'],
            ['Valentina Perez', '09123456781'],
            ['Luis Torres', '09123456780'],
            ['Camila Flores', '09123456779'],
            ['Antonio Rivera', '09123456778'],
            ['Gabriela Gomez', '09123456777'],
            ['Fernando Diaz', '09123456776'],
            ['Lucia Morales', '09123456775'],
            ['Roberto Ortiz', '09123456774'],
            ['Elena Ramos', '09123456773'],
            ['Javier Castro', '09123456772'],
            ['Paula Ruiz', '09123456771'],
            ['Alejandro Jimenez', '09123456770'],
        ];

        foreach ($students as $index => $studentData) {
            $studentId = 'ZYR' . str_pad($index + 1, 3, '0', STR_PAD_LEFT);
            $email = strtolower($studentData['first_name'] . '.' . $studentData['last_name']) . '@pdmhs.edu.ph';

            // Check if student already exists, if not create new one
            $existingStudent = Student::where('lrn', $studentId)->first();
            if (!$existingStudent) {
                $student = Student::create([
                    'first_name' => $studentData['first_name'],
                    'last_name' => $studentData['last_name'],
                    'lrn' => $studentId,
                    'date_of_birth' => now()->subYears(rand(16, 18))->subDays(rand(0, 365))->format('Y-m-d'),
                    'grade_level' => $studentData['grade_level'],
                    'section' => $studentData['section'],
                    'gender' => $studentData['gender'],
                    'contact_number' => '+63 9' . rand(100000000, 999999999),
                    'emergency_contact_name' => $emergencyContacts[$index % count($emergencyContacts)][0],
                    'emergency_contact_number' => $emergencyContacts[$index % count($emergencyContacts)][1],
                    'address' => $addresses[$index % count($addresses)],
                    'allergies' => $allergies[$index % count($allergies)],
                    'blood_type' => collect(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'])->random(),
                    'height' => rand(150, 190), // cm
                    'weight' => rand(45, 90), // kg
                    'bmi' => null, // Will be calculated later
                    'health_form_completed' => collect([true, false])->random(),
                ]);

                // Check if user already exists, if not create new one linked to student
                $user = User::where('email', $email)->first();
                if (!$user) {
                    User::create([
                        'name' => $studentData['first_name'] . ' ' . $studentData['last_name'],
                        'first_name' => $studentData['first_name'],
                        'last_name' => $studentData['last_name'],
                        'email' => $email,
                        'password' => Hash::make('password'),
                        'role' => 'student',
                        'student_id' => $student->id,
                        'contact_number' => '+63 9' . rand(100000000, 999999999),
                        'gender' => $studentData['gender'],
                    ]);
                }
            }
        }
    }
}
