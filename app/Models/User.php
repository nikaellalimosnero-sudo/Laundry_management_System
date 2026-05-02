<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'password', 'role',
        'student_id', 'course', 'year_level', 'contact',
    ];

    protected $hidden = ['password', 'remember_token'];

    // Check role helpers
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isCounselor(): bool
    {
        return $this->role === 'counselor';
    }

    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    // Relationships
    public function sessionsAsStudent(): HasMany
    {
        return $this->hasMany(CounselingSession::class, 'student_id');
    }

    public function sessionsAsCounselor(): HasMany
    {
        return $this->hasMany(CounselingSession::class, 'counselor_id');
    }
}