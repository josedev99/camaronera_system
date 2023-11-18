<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class compras extends Model
{
    use HasFactory;
    protected $fillable = ['nombre_proveedor','descripcion','monto','saldo','tipo_pago','hora','fecha','product_id','user_id'];
}
