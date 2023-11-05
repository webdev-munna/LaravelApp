<?php

namespace App\Models;

use Faker\Core\Color;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    function relToProduct()
    {
        return $this->belongsTo(Product::class, 'productId');
    }
    function relToColor()
    {
        return $this->belongsTo(ProductColor::class, 'colorId');
    }
    function relToSize()
    {
        return $this->belongsTo(ProductSize::class, 'sizeId');
    }
}
