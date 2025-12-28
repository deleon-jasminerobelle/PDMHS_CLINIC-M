<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    protected $table = 'treatments';
    protected $primaryKey = 'treatment_id';

    protected $fillable = [
        'visit_id',
        'treatment_name',
        'description',
        'treatment_type',
    ];

    /**
     * Medical visit relationship
     */
    public function medicalVisit()
    {
        return $this->belongsTo(MedicalVisit::class, 'visit_id', 'visit_id');
    }
}