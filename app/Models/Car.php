<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $guarded = ['id'];

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
