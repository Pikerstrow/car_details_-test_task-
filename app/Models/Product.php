<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name'
    ];

    public function modifications()
    {
        return $this->hasMany(Modification::class)->orderBy('id', 'desc');
    }

    public function applyings()
    {
        return $this->belongsToMany(Applying::class);
    }
}
