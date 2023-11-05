<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingDetail extends Model
{
    use HasFactory;
    function relToCountry()
    {
        return $this->belongsTo(Country::class, 'countryId');
    }
    function relToCity()
    {
        return $this->belongsTo(City::class, 'cityId');
    }
}
