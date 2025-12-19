<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Adviser extends Model
{
    use HasFactory;

    protected $table = 'advisers';
    protected $primaryKey = 'adviser_id';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'employee_number',
        'contact_phone',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime'
    ];

    /**
     * Get the user that owns the adviser record
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the students assigned to this adviser
     */
    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_adviser', 'adviser_id', 'student_id')
                    ->withPivot('assigned_date');
    }

    /**
     * Get full name attribute
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}