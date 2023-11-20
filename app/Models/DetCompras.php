<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetCompras extends Model
{
    use HasFactory;
    protected $fillable = [
        'precioUnit',
        'precioVenta',
        'descuento',
        'descripcion',
        'product_id',
        'compra_id',
    ];
}
