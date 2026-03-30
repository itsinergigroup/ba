<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'city_id', 'address'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
