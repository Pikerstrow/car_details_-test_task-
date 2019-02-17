<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Modification extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'photo',
        'description',
        'condition',
        'price',
        'is_sold'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

//    public function getPriceAttribute($value)
//    {
//        return number_format($value, 2, ".", " ");
//    }

//    public function setPriceAttribute($value)
//    {
//        return str_replace(' ', '', $value);
//    }

    public function getFileNameFromFileUrl()
    {
        $urlParts = explode('/', $this->photo);
        return $urlParts[count($urlParts) - 1];
    }
}
