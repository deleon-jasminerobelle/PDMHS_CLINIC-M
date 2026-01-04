<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Student;
use App\Models\Adviser;
use App\Models\Notification;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'student_id',
        'profile_picture',
        'phone_number',
        'staff_code',
        'position',
        'employee_number',
        'department',
        'first_name',
        'middle_name',
        'last_name',
        'birthday',
        'gender',
        'address',
        'contact_number',
    ];

    /**
     * Hidden attributes
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Attribute casts
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Role checks
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isClinicStaff(): bool
    {
        return $this->role === 'clinic_staff';
    }

    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    public function isAdviser(): bool
    {
        return $this->role === 'adviser';
    }

    /**
     * Relationships
     */
    public function adviser()
    {
        return $this->hasOne(Adviser::class, 'user_id', 'id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class)->orderBy('created_at', 'desc');
    }

    /**
     * Unread notifications count accessor
     */
    public function getUnreadNotificationsCountAttribute(): int
    {
        return $this->notifications()->whereNull('read_at')->count();
    }

    /**
     * Helper: Get associated Student record
     */
    public function getStudentRecord(): ?Student
    {
        return $this->student;
    }
}
