<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denomination extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'value',
        'image',
        
    ];


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
