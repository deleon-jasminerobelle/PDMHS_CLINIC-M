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

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        // Personal Info
        'student_id',
        'first_name',
        'middle_name',
        'last_name',
        'lrn',
        'date_of_birth',
        'gender',
        'age',
        'contact_number',
        'address',

        // School Info
        'grade_level',
        'section',
        'school',

        // Emergency Info
        'emergency_contact',
        'emergency_contact_name',
        'emergency_contact_number',
        'emergency_relation',
        'emergency_address',

        // Health Data
        'parent_certification',
        'vaccination_history',
        'bmi',
        'blood_type',
        'height',
        'weight',
        'temperature',
        'blood_pressure',
        'has_allergies',
        'allergies',
        'has_medical_condition',
        'medical_conditions',
        'has_surgery',
        'surgery_details',
        'family_history',
        'smoke_exposure',
        'medication',
        'health_form_completed',
    ];

    /**
     * Casts
     */
    protected $casts = [
        'date_of_birth'        => 'date',
        'parent_certification' => 'array',
        'vaccination_history'  => 'array',
        'allergies'            => 'array',
        'medical_conditions'   => 'array',
        'family_history'       => 'array',
        'medication'           => 'array',
        'has_allergies'        => 'boolean',
        'has_medical_condition'=> 'boolean',
        'has_surgery'          => 'boolean',
        'health_form_completed'=> 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Linked user account
     * users.student_id → students.id
     */
   
    public function user()
    {
    return $this->hasOne(User::class, 'student_id', 'id');
    }

    /**
     * Advisers (many-to-many)
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
     * Clinic visits
     */
    public function clinicVisits()
    {
        return $this->hasMany(ClinicVisit::class, 'student_id', 'id');
    }

    /**
     * Latest clinic visit
     */
    public function latestVisit()
    {
        return $this->hasOne(ClinicVisit::class, 'student_id', 'id')
            ->latest('visit_date');
    }

    public function medicalVisits()
    {
        return $this->hasMany(MedicalVisit::class, 'student_id', 'id');
    }

    public function immunizations()
    {
        return $this->hasMany(Immunization::class, 'student_id', 'id');
    }

    public function healthIncidents()
    {
        return $this->hasMany(HealthIncident::class, 'student_id', 'id');
    }

    public function vitals()
    {
        return $this->hasMany(Vitals::class, 'student_id', 'id');
    }

    public function allergyRecords()
    {
        return $this->hasMany(Allergy::class, 'student_id', 'id');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getFormattedStudentNumberAttribute()
    {
        return str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }

    public function getFormattedGradeSectionAttribute()
    {
        if ($this->grade_level && $this->section) {
            return "Grade {$this->grade_level} - {$this->section}";
        }

        if ($this->grade_level) {
            return "Grade {$this->grade_level}";
        }

        return 'N/A';
    }

    public function getLastVisitDateAttribute()
    {
        $visit = $this->clinicVisits()->latest('visit_date')->first();
        return $visit ? $visit->visit_date->format('M d, Y') : 'No visits';
    }

    public function getAllergyStatusAttribute()
    {
        return ($this->has_allergies && !empty($this->allergies)) ? 'Yes' : 'None';
    }

    public function getStudentIdAttribute()
    {
        return $this->lrn ?? $this->getFormattedStudentNumberAttribute();
    }
}
