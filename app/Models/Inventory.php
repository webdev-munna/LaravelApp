<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    function relToColor()
    {
        return $this->belongsTo(ProductColor::class, 'colorId');
    }
    function relToSize()
    {
        return $this->belongsTo(ProductSize::class, 'sizeId');
    }
    function relToProduct()
    {
        return $this->belongsTo(Product::class, 'productId');
    }
}
