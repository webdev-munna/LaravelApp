<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class customerLogin extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $guarded = ['id'];
    protected $guard = 'customerLogin';
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
