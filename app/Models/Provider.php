<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'nit',
        'contact',
        'phone',
        'email',
        'address',
    ];

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
