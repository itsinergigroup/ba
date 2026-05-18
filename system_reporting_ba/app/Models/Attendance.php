<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'user_id',
        'outlet_id',
        'type',
        'latitude',
        'longitude',
        'photo_path',
        'status',
        'late_minutes',
        'date',
        'time',
        'attendance_request_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    public function attendanceRequest()
    {
        return $this->belongsTo(AttendanceRequest::class);
    }
}
