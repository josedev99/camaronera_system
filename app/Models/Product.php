<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'descripcion',
        'unidad_medida',
        'image',
        'category_id',
        'user_id',       
    ];
    
}
