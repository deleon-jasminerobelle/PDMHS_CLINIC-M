<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    protected $table = 'medications';
    protected $primaryKey = 'medication_id';

    protected $fillable = [
        'visit_id',
        'medication_name',
        'dosage',
        'frequency',
        'duration',
        'instructions',
    ];

    /**
     * Medical visit relationship
     */
    public function medicalVisit()
    {
        return $this->belongsTo(MedicalVisit::class, 'visit_id', 'visit_id');
    }
}