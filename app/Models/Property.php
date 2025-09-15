<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'city',
        'rooms',
        'bathrooms',
        'consignation_type',
        'rent_price',
        'sale_price',
        'has_pool',
        'has_elevator',
        'parking_type',
    ];

    protected $casts = [
        'has_pool' => 'boolean',
        'has_elevator' => 'boolean',
    ];

    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }
}
