<?php

namespace App\Traits;

use App\Models\Student;
use App\Models\Vitals;
use App\Models\ClinicVisit;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

trait StudentHealthService
{
    /**
     * Get the Student model linked to a user
     *
     * @param \App\Models\User $user
     * @return Student|null
     */
    public function getStudentForUser($user): ?Student
    {
        if ($user->student_id) {
            return Student::with(['vitals', 'clinicVisits', 'immunizations'])
                          ->find($user->student_id);
        }

        $student = $this->findStudentByName($user->name);

        if ($student && !$user->student_id) {
            $user->update(['student_id' => $student->id]);
        }

        return $student;
    }

    /**
     * Find a student by name (first + last)
     */
    public function findStudentByName(string $userName): ?Student
    {
        $nameParts = array_filter(explode(' ', trim($userName)));
        if (empty($nameParts)) return null;

        $firstName = $nameParts[0];
        $lastName = end($nameParts);

        return Student::whereRaw('LOWER(first_name)=LOWER(?)', [$firstName])
                      ->whereRaw('LOWER(last_name)=LOWER(?)', [$lastName])
                      ->first();
    }

    /**
     * Get the latest vitals for a student
     */
    public function getLatestVitalsForStudent(Student $student)
    {
        try {
            $latestVital = $student->vitals()->latest('created_at')->first();
            if ($latestVital) {
                return (object)[
                    'weight' => $latestVital->weight ?? $student->weight ?? '',
                    'height' => $latestVital->height ?? $student->height ?? '',
                    'temperature' => $latestVital->temperature ?? '',
                    'blood_pressure' => $latestVital->blood_pressure ?? '',
                    'heart_rate' => $latestVital->heart_rate ?? '',
                    'respiratory_rate' => $latestVital->respiratory_rate ?? '',
                ];
            }
        } catch (\Exception $e) {
            Log::info('Error fetching vitals: ' . $e->getMessage());
        }

        return (object)[
            'weight' => $student->weight ?? '',
            'height' => $student->height ?? '',
            'temperature' => $student->temperature ?? '',
            'blood_pressure' => $student->blood_pressure ?? '',
        ];
    }

    /**
     * Calculate BMI and category
     */
    public function calculateBMI($latestVitals, Student $student): array
    {
        $weight = $latestVitals->weight ?: $student->weight ?? null;
        $height = $latestVitals->height ?: $student->height ?? null;

        if (!$weight || !$height || $height <= 0) {
            return ['bmi' => '', 'category' => ''];
        }

        $heightM = $height / 100;
        $bmiVal = $weight / ($heightM * $heightM);
        $bmi = number_format($bmiVal, 1);

        $category = match (true) {
            $bmiVal < 18.5 => 'Underweight',
            $bmiVal < 25 => 'Normal',
            $bmiVal < 30 => 'Overweight',
            default => 'Obese',
        };

        return ['bmi' => $bmi, 'category' => $category];
    }

    /**
     * Get allergies for a student
     */
    public function getAllergiesForStudent(Student $student)
    {
        try {
            $allergies = $student->allergies ?? [];
            if (!is_array($allergies)) $allergies = [];

            return collect($allergies)->map(fn($a) => (object)[
                'allergy_name' => is_string($a) ? $a : ($a['allergy_name'] ?? $a['name'] ?? 'Unknown'),
                'severity' => $a['severity'] ?? 'Unknown'
            ]);
        } catch (\Exception $e) {
            Log::info('Error fetching allergies: ' . $e->getMessage());
            return collect();
        }
    }

    /**
     * Get all clinic visits for a student
     */
    public function getClinicVisitsForStudent(Student $student)
    {
        return $student->clinicVisits()->orderBy('created_at', 'desc')->get();
    }

    /**
     * Get immunizations for a student
     */
    public function getImmunizationsForStudent(Student $student)
    {
        try {
            return $student->immunizations()->orderBy('created_at', 'desc')->get();
        } catch (\Exception $e) {
            Log::info('Error fetching immunizations: ' . $e->getMessage());
            return collect();
        }
    }

    /**
     * Check if student has complete emergency health data
     */
    public function hasCompleteHealthData(Student $student): bool
    {
        $required = [
            'emergency_contact_name',
            'emergency_contact_number',
            'emergency_relation',
            'emergency_address'
        ];

        foreach ($required as $field) {
            if (empty($student->$field) || trim($student->$field) === '') {
                return false;
            }
        }

        return true;
    }
}
