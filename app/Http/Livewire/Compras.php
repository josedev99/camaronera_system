<?php

namespace App\Http\Livewire;

use App\Models\compras as ComprasModel;
use App\Models\Product;
use Barryvdh\DomPDF\PDF;
use Faker\Core\Number;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Compras extends Component
{
    public $id_compra = '';
    public $proveedor;
    public $descripcion;
    public $precioUnit;
    public $cantidad;
    public $monto;
    public $tipo_pago;
    public $producto_id;
    public $products;
    public $buscar;
    public $desde;
    public $hasta;
    protected $listeners = ['destroy','edit','resetFormulario'];
    public function render()
    {
        $precioUnitario = is_numeric($this->precioUnit) ? $this->precioUnit : 0;
        $cantidad = is_numeric($this->cantidad) ? $this->cantidad : 0;
        $this->monto = number_format(($precioUnitario * $cantidad),2);
        $buscar = $this->buscar;
        if($this->buscar != null){
            $registros = ComprasModel::where('nombre_proveedor','like','%'.$this->buscar.'%')->where('descripcion','like','%'.$this->buscar.'%')->orderBy('id','desc')->paginate(10);
        }else{
            $registros = ComprasModel::orderBy('id','desc')->paginate(10);
        }
        return view('livewire.compras.index',compact('registros','buscar'))
        ->extends('layouts.theme.app')
        ->section('content');
    }
    public function updatedQuery()
    {
        $this->resetPage(); // Reset pagination when the query changes
    }
    public function resetFormulario(){
        $this->id_compra = "";
        $this->proveedor = '';
        $this->descripcion = '';
        $this->precioUnit = '';
        $this->cantidad = '';
        $this->monto = '';
        $this->tipo_pago = '';
    }

    public function mount()
    {
        $this->loadProducts();
    }
    public function loadProducts(){
        $this->products = Product::orderBy('id','desc')->get();
    }
    public function saveCompra(){
        $hoy = date('Y-m-d');
        $hora = date('H:i:s');
        $this->validate([
            'proveedor' => 'required',
            'descripcion' => 'required',
            'precioUnit' => 'required',
            'cantidad' => 'required',
            'monto' => 'required',
            'tipo_pago' => 'required',
            'producto_id' => 'required',
        ]);
        $totalMonto =  $this->precioUnit * $this->cantidad;
        ComprasModel::create([
            'nombre_proveedor' => $this->proveedor,
            'descripcion' => $this->descripcion,
            'precioUnit' => $this->precioUnit,
            'cantidad' => $this->cantidad,
            'monto' => $totalMonto,
            'saldo' => 0,
            'tipo_pago' => $this->tipo_pago,
            'hora' => $hora,
            'fecha' => $hoy,
            'product_id' => $this->producto_id,
            'user_id' => Auth::user()->id
        ]);
        $this->emit('msg','La compra se registro exitosamente!');
    }
    public function destroy($id){
        ComprasModel::where('id',$id)->delete();
        $this->emit('eliminado','La compra se ha eliminado exitosamente!');
    }
    public function edit($id){
        $data = ComprasModel::where('id',$id)->get();
        foreach($data as $row){
            $this->id_compra = $row['id'];
            $this->proveedor = $row['nombre_proveedor'];
            $this->descripcion = $row['descripcion'];
            $this->precioUnit = $row['precioUnit'];
            $this->cantidad = $row['cantidad'];
            $this->monto = $row['monto'];
            $this->tipo_pago = $row['tipo_pago'];
            $this->producto_id = $row['product_id'];
        }
        $this->emit('showModalEditar');
    }
    public function updateCompra(){
        $this->validate([
            'proveedor' => 'required',
            'descripcion' => 'required',
            'precioUnit' => 'required',
            'cantidad' => 'required',
            'monto' => 'required',
            'tipo_pago' => 'required',
            'producto_id' => 'required',
        ]);
        $totalMonto =  $this->precioUnit * $this->cantidad;
        ComprasModel::where('id',$this->id_compra)->update([
            'nombre_proveedor' => $this->proveedor,
            'descripcion' => $this->descripcion,
            'precioUnit' => $this->precioUnit,
            'cantidad' => $this->cantidad,
            'monto' => $totalMonto,
            'saldo' => 0,
            'tipo_pago' => $this->tipo_pago,
            'product_id' => $this->producto_id
        ]);
        $this->emit('udp','Datos actualizado exitosamente!');
    }
    public function generarPDF(){
        dd('Hola');
        return redirect()->to('pdfCompra');
    }
    public function reportePDF(){
        $pdf = PDF::loadView('compras.pdf.compras');
        return $pdf->stream('documento.pdf');
    }
}
