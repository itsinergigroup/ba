<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeProfile extends Model
{
    protected $fillable = [
        'user_id',
        'nik',
        'gender',
        'dob',
        'address',
        'phone',
        'employment_status',
        'join_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
