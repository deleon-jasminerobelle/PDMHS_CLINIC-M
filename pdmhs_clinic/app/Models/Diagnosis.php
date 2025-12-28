<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    protected $table = 'diagnoses';
    protected $primaryKey = 'diagnosis_id';

    protected $fillable = [
        'visit_id',
        'diagnosis_name',
        'description',
        'diagnosis_code',
    ];

    /**
     * Medical visit relationship
     */
    public function medicalVisit()
    {
        return $this->belongsTo(MedicalVisit::class, 'visit_id', 'visit_id');
    }
}