<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movements extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'available',
        'price',
        'priceu',
        'total',
        'sald',
        'product_id',
        'user_id',
        'type',
        
    ];
}
