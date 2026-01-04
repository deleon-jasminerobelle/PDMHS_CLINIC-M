<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\HealthForm;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'student_id',
        'first_name',
        'middle_name',
        'last_name',
        'date_of_birth',
        'gender',
        'grade_level',
        'section',
        'school',
        'sex',
        'age',
        'contact_number',
        'address',
        'emergency_contact',
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
        'date_of_birth'        => 'date',
        'parent_certification' => 'array',
        'vaccination_history'  => 'array',
        'allergies'            => 'array',
        'medical_conditions'   => 'array',
        'family_history'       => 'array',
        'medication'           => 'array',
    ];

    /**
     * Adviser relationship (many-to-many)
     */
    public function advisers()
    {
        return $this->belongsToMany(
            Adviser::class, 
            'student_adviser', 
            'student_id', 
            'adviser_id'
        )->withPivot('assigned_date');
    }

    /**
     * Clinic visits relationship
     */
    public function clinicVisits()
    {
        return $this->hasMany(ClinicVisit::class, 'student_id');
    }

    /**
     * Latest clinic visit
     */
    public function latestVisit()
    {
        return $this->hasOne(ClinicVisit::class, 'student_id')->latest('visit_date');
    }

    /**
     * All medical visits
     */
    public function medicalVisits()
    {
        return $this->hasMany(MedicalVisit::class, 'student_id');
    }

    /**
     * Immunizations
     */
    public function immunizations()
    {
        return $this->hasMany(Immunization::class, 'student_id');
    }

    /**
     * Health incidents
     */
    public function healthIncidents()
    {
        return $this->hasMany(HealthIncident::class, 'student_id');
    }

    /**
     * Vitals
     */
    public function vitals()
    {
        return $this->hasMany(Vitals::class, 'student_id');
    }

    /**
     * Allergies
     */
    public function allergies()
    {
        return $this->hasMany(Allergy::class, 'student_id');
    }


}
