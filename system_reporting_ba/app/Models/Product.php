<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['brand_id', 'name', 'barcode', 'het', 'selling_price'];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
