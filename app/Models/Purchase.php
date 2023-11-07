<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable = [
        'total',
        'items',
        'status',
        'user_id',
        'provider_id',
        'pay',
        'invoice',
        'iva',
                
    ];
}
