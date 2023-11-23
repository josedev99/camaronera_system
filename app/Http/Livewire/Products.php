<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Movements;
use Livewire\Component;
use App\Models\Product as ProductModel;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

class Products extends Component
{
    public $nombre;
    public $descripcion;
    public $unidad_medida;
    public $image;
    public $category_id;
    public $user_id;

    public $registros;
    public $id_product;


    protected $listeners = ['destroy','edit','resetFormulario'];

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
    public function resetFormulario(){
        $this->id_product = "";
        $this->nombre = '';
        $this->descripcion = '';
        $this->unidad_medida = '';
        $this->category_id = '';
        
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

    public function destroy($id){
        ProductModel::where('id',$id)->delete();
        $this->emit('eliminado','La compra se ha eliminado exitosamente!');
    }
    public function edit($id){
        $data = ProductModel::where('id',$id)->get();
        foreach($data as $row){
            $this->id_product = $row['id'];
            $this->nombre = $row['nombre'];
            $this->descripcion = $row['descripcion'];
            $this->unidad_medida = $row['unidad_medida'];
            $this->category_id = $row['category_id'];
        }
       
        $this->emit('showModalEditar');
    }
    public function updateProduct(){
        $this->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
        ]);
    
        ProductModel::where('id', $this->id_product)->update([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'unidad_medida' => $this->unidad_medida,
            'image' => '',
            'category_id' => $this->category_id,
        ]);
    
        $this->cargarRegistros(); // Actualizar la lista de registros después de la actualización
    
        $this->emit('udp', 'Datos actualizados exitosamente!');
    }
}
