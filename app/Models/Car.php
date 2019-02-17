<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    public function models()
    {
        return $this->hasMany(CarModel::class);
    }

    public function products()
    {
        return $this->hasManyThrough(Product::class, Applying::class);
    }
}
