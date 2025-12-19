<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $primaryKey = 'student_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'student_id',
        'first_name',
        'last_name',
        'date_of_birth',
        'grade_level',
        'section',
        'school',
        'sex',
        'age',
        'adviser',
        'blood_type',
        'height',
        'weight',
        'temperature',
        'blood_pressure',
        'allergies',
        'medical_conditions',
        'family_history',
        'smoke_exposure',
        'medication',
        'vaccination_history',
        'emergency_contact_name',
        'emergency_contact_number',
        'emergency_relation',
        'emergency_address',
        'parent_certification',
        'bmi',
        'has_allergies',
        'has_medical_condition',
        'has_surgery',
        'surgery_details',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'allergies' => 'array',
        'medical_conditions' => 'array',
        'family_history' => 'array',
        'medication' => 'array',
        'parent_certification' => 'array',
        'vaccination_history' => 'array',
    ];
}
