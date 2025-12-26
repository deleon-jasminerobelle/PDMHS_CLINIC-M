<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';

    public $incrementing = true;

    public $timestamps = true;

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
        'emergency_contact_name',
        'emergency_contact_number',
        'emergency_relation',
        'emergency_address',
        'parent_certification',
        'vaccination_history',
        'bmi',
        'blood_type',
        'height',
        'weight',
        'temperature',
        'blood_pressure',
        'adviser',
        'has_allergies',
        'allergies',
        'has_medical_condition',
        'medical_conditions',
        'has_surgery',
        'surgery_details',
        'family_history',
        'smoke_exposure',
        'medication',
    ];

    protected $casts = [
        'parent_certification'   => 'array',
        'vaccination_history'    => 'array',
        'allergies'              => 'array',
        'medical_conditions'     => 'array',
        'family_history'         => 'array',
        'medication'             => 'array',
    ];

    /**
     * Get the clinic visits for the student
     */
    public function clinicVisits()
    {
        return $this->hasMany(ClinicVisit::class);
    }

    /**
     * Get the allergies for the student
     */
    public function allergies()
    {
        return $this->hasMany(Allergy::class);
    }

    /**
     * Get the immunizations for the student
     */
    public function immunizations()
    {
        return $this->hasMany(Immunization::class);
    }

    /**
     * Get the advisers assigned to this student
     */
    public function advisers()
    {
        return $this->belongsToMany(Adviser::class, 'student_adviser', 'student_id', 'adviser_id')
                    ->withPivot('assigned_date');
    }
}
