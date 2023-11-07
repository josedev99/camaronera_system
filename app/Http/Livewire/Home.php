<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use DB;

class Home extends Component
{
    public $data = [];
    public function render()
    {
        $this->data = DB::select('SELECT * FROM products WHERE products.stock < products.alerts');
       
        return view('livewire.home.home')->extends('layouts.theme.app')
        ->section('content'); 
    }
}
