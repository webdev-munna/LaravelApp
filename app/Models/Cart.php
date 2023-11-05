<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    function relToProduct()
    {
        return $this->belongsTo(Product::class, 'productId');
    }
    function relToSize()
    {
        return $this->belongsTo(ProductSize::class, 'sizeId');
    }
    function relToColor()
    {
        return $this->belongsTo(ProductColor::class, 'colorId');
    }
}
