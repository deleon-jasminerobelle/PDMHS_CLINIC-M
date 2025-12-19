<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Student extends Model
{
    use HasFactory;

    protected $table = 'students';
    protected $primaryKey = 'id';

    protected $fillable = [
        'student_id',
        'first_name',
        'last_name',
        'date_of_birth',
        'grade_level',
        'section',
        'contact_number',
        'emergency_contact_name',
        'emergency_contact_number',
        'address',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * User relationship
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Medical visits relationship
     */
    public function medicalVisits()
    {
        return $this->hasMany(MedicalVisit::class, 'student_id', 'id');
    }

    /**
     * Clinic visits relationship
     */
    public function clinicVisits()
    {
        return $this->hasMany(ClinicVisit::class, 'student_id', 'id');
    }

    /**
     * Immunizations relationship
     */
    public function immunizations()
    {
        return $this->hasMany(Immunization::class, 'student_id', 'id');
    }

    /**
     * Allergies relationship
     */
    public function allergies()
    {
        return $this->hasMany(Allergy::class, 'student_id', 'id');
    }

    /**
     * QR codes relationship
     */
    public function qrCodes()
    {
        return $this->hasMany(QrCode::class, 'student_id', 'id');
    }

    /**
     * Parents relationship (many-to-many)
     */
    public function parents()
    {
        return $this->belongsToMany(ParentModel::class, 'student_parent', 'student_id', 'parent_id');
    }

    /**
     * Advisers relationship (many-to-many)
     */
    public function advisers()
    {
        return $this->belongsToMany(Adviser::class, 'student_adviser', 'student_id', 'adviser_id')
                    ->withPivot('assigned_date')
                    ->withTimestamps();
    }

    /**
     * Get full name attribute
     */
    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name);
    }
}
