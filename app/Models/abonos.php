<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class abonos extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_recibo',
        'tipo_pago',
        'monto_abono',
        'saldo',
        'sale_id',
        'user_id',
    ];
}
