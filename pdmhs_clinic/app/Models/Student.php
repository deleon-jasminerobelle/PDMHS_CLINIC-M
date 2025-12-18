<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'grade_level',
        'student_id',
        'emergency_contact_name',
        'emergency_contact_phone',
        'medical_conditions',
        'allergies',
        'medications',
        'insurance_provider',
        'insurance_policy_number',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function clinicVisits()
    {
        return $this->hasMany(ClinicVisit::class);
    }

    public function healthIncidents()
    {
        return $this->hasMany(HealthIncident::class);
    }

    public function immunizations()
    {
        return $this->hasMany(Immunization::class);
    }

    public function vitals()
    {
        return $this->hasMany(Vital::class);
    }
}
