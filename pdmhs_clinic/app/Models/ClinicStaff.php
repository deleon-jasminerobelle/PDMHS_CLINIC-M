<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClinicStaff extends Model
{
    use SoftDeletes;

    protected $table = 'clinic_staff';
    protected $primaryKey = 'clinic_staff_id';

    protected $fillable = [
        'user_id',
        'staff_code',
        'position',
        'is_active',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'deleted_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * User relationship
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}