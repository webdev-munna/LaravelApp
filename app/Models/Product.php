<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id'];
    function relToCateogry()
    {
        return $this->belongsTo(Category::class, 'categoryId');
    }
    function relToSubcateogry()
    {
        return $this->belongsTo(Subcategory::class, 'subcategoryId');
    }
    function relToInventory()
    {
        return $this->hasMany(Inventory::class, 'productId');
    }
}
