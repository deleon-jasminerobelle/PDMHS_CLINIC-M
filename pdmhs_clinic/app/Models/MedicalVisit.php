<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalVisit extends Model
{
    protected $table = 'medical_visits';
    protected $primaryKey = 'visit_id';

    protected $fillable = [
        'student_id',
        'clinic_staff_id',
        'visit_datetime',
        'visit_type',
        'chief_complaint',
        'notes',
        'status',
    ];

    protected $casts = [
        'visit_datetime' => 'datetime',
        'created_at' => 'datetime',
    ];

    /**
     * Student relationship
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    /**
     * Clinic staff relationship
     */
    public function clinicStaff()
    {
        return $this->belongsTo(ClinicStaff::class, 'clinic_staff_id', 'clinic_staff_id');
    }

    /**
     * Diagnoses relationship
     */
    public function diagnoses()
    {
        return $this->hasMany(Diagnosis::class, 'visit_id', 'visit_id');
    }

    /**
     * Medications relationship
     */
    public function medications()
    {
        return $this->hasMany(Medication::class, 'visit_id', 'visit_id');
    }

    /**
     * Treatments relationship
     */
    public function treatments()
    {
        return $this->hasMany(Treatment::class, 'visit_id', 'visit_id');
    }

    /**
     * Vitals relationship
     */
    public function vitals()
    {
        return $this->hasMany(Vitals::class, 'visit_id', 'visit_id');
    }
}