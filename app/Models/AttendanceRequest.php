<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceRequest extends Model
{
    protected $fillable = [
        'user_id',
        'outlet_id',
        'type',
        'date',
        'time',
        'reason',
        'status',
        'admin_note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    public function attendance()
    {
        return $this->hasOne(Attendance::class);
    }
}
