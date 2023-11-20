<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Movements;
use Livewire\Component;
use App\Models\Product as ProductModel;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Products extends Component
{
    public $nombre;
    public $descripcion;
    public $unidad_medida;
    public $image;
    public $category_id;
    public $user_id;

    public $registros;

    public function render()
    {
        return view('livewire.products.product', ['hello' => 'Hola'])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function mount()
    {
        $this->cargarRegistros();
    }

    public function cargarRegistros()
    {
        // Obtener registros de la base de datos
        $this->registros = ProductModel::orderBy('id','desc')->get();
    }

    public function saveProducto(){
        
        $this->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
        ]);

        ProductModel::create([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'unidad_medida' => $this->unidad_medida,
            'image' => '',
            'category_id' =>$this->category_id,
            'user_id' => Auth::user()->id
        ]);

        
        $this->emit('msg','El producto se registro exitosamente!');
    }
}
