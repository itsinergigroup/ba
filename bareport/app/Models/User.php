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
        'cluster',
        'region',
        'areas',
        'rbs_id',
        'distributor_id',
        'photo_path',
        'is_active',
    ];

    public function profile()
    {
        return $this->hasOne(EmployeeProfile::class);
    }

    public function rbs()
    {
        return $this->belongsTo(User::class, 'rbs_id');
    }

    public function subordinates()
    {
        return $this->hasMany(User::class, 'rbs_id');
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

    public function isRbs(): bool
    {
        return $this->role === 'rbs';
    }

    public function isViewOnly(): bool
    {
        return $this->role === 'view user only';
    }

    public function isAnyViewer(): bool
    {
        return in_array($this->role, ['admin', 'rbs', 'view user only']);
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

    public function getTodayCheckIn()
    {
        $today = now('Asia/Jakarta')->toDateString();
        return $this->attendances()
            ->where('date', $today)
            ->where('type', 'check-in')
            ->first();
    }

    public function hasCheckedOutToday(): bool
    {
        $today = now('Asia/Jakarta')->toDateString();
        return $this->attendances()->where('date', $today)->where('type', 'check-out')->exists();
    }

    public function hasIncompleteAttendance(): bool
    {
        $today = now('Asia/Jakarta')->toDateString();
        $lastAttendance = $this->attendances()
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->first();

        // Jika absen terakhir adalah check-in dan bukan hari ini, berarti lupa check-out kemarin
        return ($lastAttendance && $lastAttendance->type === 'check-in' && $lastAttendance->date < $today);
    }

    public function getIncompleteAttendance()
    {
        $today = now('Asia/Jakarta')->toDateString();
        return $this->attendances()
            ->where('type', 'check-in')
            ->where('date', '<', $today)
            ->whereNotExists(function ($query) {
                $query->select(\DB::raw(1))
                    ->from('attendances as a2')
                    ->whereColumn('a2.user_id', 'attendances.user_id')
                    ->whereColumn('a2.date', 'attendances.date')
                    ->where('a2.type', 'check-out');
            })
            ->orderBy('date', 'desc')
            ->first();
    }

    public function hasMissingAttendanceYesterday(): bool
    {
        $yesterday = now('Asia/Jakarta')->subDay();
        $yesterdayDate = $yesterday->toDateString();
        $todayDate = now('Asia/Jakarta')->toDateString();

        // 1. Cek apakah kemarin hari kerja
        $workingDays = json_decode(Setting::getValue('working_days', '[1,2,3,4,5,6,7]'), true);
        if (!in_array($yesterday->dayOfWeekIso, $workingDays)) {
            return false;
        }

        // 2. Cek apakah kemarin sedang libur (Day-Off)
        $hasDayOff = $this->attendanceRequests()
            ->where('type', 'day-off')
            ->where('status', 'approved')
            ->where('date', $yesterdayDate)
            ->exists();
        
        if ($hasDayOff) {
            return false;
        }

        // 3. Cek apakah ada data absen kemarin
        $hasAttendance = $this->attendances()
            ->where('date', $yesterdayDate)
            ->exists();

        // Jika tidak ada absen sama sekali di hari kerja kemarin
        return !$hasAttendance;
    }

    public function hasApprovedDayOffToday(): bool
    {
        $today = now('Asia/Jakarta')->toDateString();
        return $this->attendanceRequests()
            ->where('type', 'day-off')
            ->where('status', 'approved')
            ->where('date', $today)
            ->exists();
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
            'areas' => 'array',
        ];
    }
}
