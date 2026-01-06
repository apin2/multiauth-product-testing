<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'category',
        'stock',
    ];

    public function getImageAttribute($value)
    {
        // Return default image if no image is set or if the image is empty
        if (empty($value)) {
            return 'products/default-product.svg';
        }
        
        return $value;
    }
}
