<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Applying extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'car_id',
        'car_model_id'
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function car_model()
    {
        return $this->belongsTo(CarModel::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
