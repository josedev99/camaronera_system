<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'price',
        'quantity',
        'available',
        'total',
        'product_id',
        'purchase_id',
        
    ];
}
