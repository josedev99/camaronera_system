<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'total',
        'items',
        'invoice',
        'iva',
        'type_invoice',
        'status',
        'pay',
        'user_id',
        'customer',
        'pond',
        'grams',
        'image'
                
    ];



            
}
