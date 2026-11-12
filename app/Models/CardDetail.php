<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardDetail extends Model
{
     protected $fillable = [
        'customer_email', 'owner', 'cardNumber',
        'cvv','expiration_month','expiration_year','merchant'
    ];
}