<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Immunization extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'vaccine_name',
        'date_administered',
        'next_due_date',
        'administered_by',
        'batch_number',
        'notes',
    ];

    protected $casts = [
        'date_administered' => 'date',
        'next_due_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
