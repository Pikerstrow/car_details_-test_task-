<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    protected $fillable = [
        'name',
        'car_id'
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
