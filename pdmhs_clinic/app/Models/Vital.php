<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vital extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinic_visit_id',
        'temperature',
        'blood_pressure',
        'heart_rate',
        'respiratory_rate',
        'weight',
        'height',
        'notes',
    ];

    protected $casts = [
        'temperature' => 'decimal:2',
        'heart_rate' => 'integer',
        'respiratory_rate' => 'integer',
        'weight' => 'decimal:2',
        'height' => 'decimal:2',
    ];

    public function clinicVisit()
    {
        return $this->belongsTo(ClinicVisit::class);
    }
}
