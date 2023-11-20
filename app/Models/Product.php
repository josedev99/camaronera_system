<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'nombre',
        'descripcion',
        'unidad_medida',
        'image',
        'category_id',
        'user_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sales()
    {
        return $this->hasMany(SaleDetails::class);
    }

    public function getImageAttribute($image)
    {
        if($image == null){
            return 'noimg.png';
        }
        else {
            if (file_exists('storage/products/'.$image)) {
                return $image;
            }
            else {
            return 'noimg.png';
            }
        }
    }


    
}
