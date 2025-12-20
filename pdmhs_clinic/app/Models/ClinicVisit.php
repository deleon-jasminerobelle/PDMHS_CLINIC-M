<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'visit_date',
        'reason_for_visit',
        'symptoms',
        'status',
        'diagnosis',
        'treatment',
        'medications',
        'follow_up_required',
        'follow_up_date',
        'notes',
    ];

    protected $casts = [
        'visit_date' => 'datetime',
        'follow_up_date' => 'date',
        'follow_up_required' => 'boolean',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function vitals()
    {
        return $this->hasMany(Vitals::class);
    }
}
