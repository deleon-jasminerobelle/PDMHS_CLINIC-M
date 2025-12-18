<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthIncident extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'incident_date',
        'incident_type',
        'description',
        'treatment_provided',
        'reported_by',
        'follow_up_actions',
    ];

    protected $casts = [
        'incident_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
