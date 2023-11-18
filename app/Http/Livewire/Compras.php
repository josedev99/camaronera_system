<?php

namespace App\Http\Livewire;

use App\Models\compras as ComprasModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Compras extends Component
{
    public $proveedor;
    public $descripcion;
    public $monto;
    public $tipo_pago;
    public $producto_id;
    public $registros;
    public function render()
    {
        return view('livewire.compras.index', ['hello' => 'Hola'])
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
        $this->registros = ComprasModel::orderBy('id','desc')->get();
    }
    public function saveCompra(){
        $hoy = date('Y-m-d');
        $hora = date('H:i:s');
        $this->validate([
            'proveedor' => 'required',
            'descripcion' => 'required',
            'monto' => 'required',
            'tipo_pago' => 'required',
        ]);
        ComprasModel::create([
            'nombre_proveedor' => $this->proveedor,
            'descripcion' => $this->descripcion,
            'monto' => $this->monto,
            'saldo' => 0,
            'tipo_pago' => $this->tipo_pago,
            'hora' => $hora,
            'fecha' => $hoy,
            'product_id' => $this->producto_id,
            'user_id' => Auth::user()->id
        ]);
        $this->emit('msg','La compra se registro exitosamente!');
    }
}
