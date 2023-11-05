<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderedProduct extends Model
{
    use HasFactory;

    function relToProducts()
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
    function relToCustomer()
    {
        return $this->belongsTo(customerLogin::class, 'customerId');
    }
}
