<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthForm extends Model
{
    use HasFactory;

    protected $table = 'health_forms';

    protected $fillable = [
        'student_id',
        'height',
        'weight',
        'blood_type',
        'bmi',
        'allergies',
        'medical_conditions',
        'submitted_at',
    ];

    protected $casts = [
        'allergies' => 'array',
        'medical_conditions' => 'array',
        'submitted_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}

