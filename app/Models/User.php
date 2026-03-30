<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'distributor_id',
        'photo_path',
        'is_active',
    ];

    public function profile()
    {
        return $this->hasOne(EmployeeProfile::class);
    }

    public function documents()
    {
        return $this->hasMany(EmployeeDocument::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isBa(): bool
    {
        return $this->role === 'ba';
    }

    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }

    public function outlets()
    {
        return $this->belongsToMany(Outlet::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function attendanceRequests()
    {
        return $this->hasMany(AttendanceRequest::class);
    }

    public function hasFinishedAttendanceToday(): bool
    {
        return ($this->hasCheckedInToday() && $this->hasCheckedOutToday());
    }

    public function hasCheckedInToday(): bool
    {
        $today = now('Asia/Jakarta')->toDateString();
        return $this->attendances()->where('date', $today)->where('type', 'check-in')->exists();
    }

    public function hasCheckedOutToday(): bool
    {
        $today = now('Asia/Jakarta')->toDateString();
        return $this->attendances()->where('date', $today)->where('type', 'check-out')->exists();
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
