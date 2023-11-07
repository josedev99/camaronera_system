<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
    ];


    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getImageAttribute($image)
    {
        if($image == null){
            return 'noimg.png';
        }
        else {
            if (file_exists('storage/categories/'.$image)) {
                return $image;
            }
            else {
            return 'noimg.png';
            }
        }
    }
}
