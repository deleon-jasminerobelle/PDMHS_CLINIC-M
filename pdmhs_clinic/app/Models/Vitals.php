<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vitals extends Model
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
        'notes'
    ];

    protected $casts = [
        'temperature' => 'decimal:2',
        'weight' => 'decimal:2',
        'height' => 'decimal:2',
    ];

    /**
     * Clinic visit relationship
     */
    public function clinicVisit()
    {
        return $this->belongsTo(ClinicVisit::class);
    }

    /**
     * Calculate BMI
     */
    public function getBmiAttribute()
    {
        if ($this->height && $this->weight && $this->height > 0) {
            $heightInMeters = $this->height / 100;
            return round($this->weight / ($heightInMeters * $heightInMeters), 2);
        }
        return null;
    }

    /**
     * Get BMI category
     */
    public function getBmiCategoryAttribute()
    {
        $bmi = $this->getBmiAttribute();
        if (!$bmi) return null;

        if ($bmi < 18.5) return 'Underweight';
        if ($bmi <= 24.9) return 'Normal';
        if ($bmi <= 29.9) return 'Overweight';
        return 'Obese';
    }
}