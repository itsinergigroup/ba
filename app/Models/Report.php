<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'distributor_id',
        'account_type',
        'channel',
        'group_id',
        'outlet_id',
        'brand_id',
        'product_id',
        'quantity',
        'het',
        'unit_price',
        'discount',
        'total_price',
        'province_id',
        'city_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
