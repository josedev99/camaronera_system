<?php

namespace App\Http\Livewire;

use App\Models\SaleDetails;
use App\Models\compras;
use App\Models\Sale;
use App\Models\Product;
use App\Models\User;
use DateTime;
use DB;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class Dash extends Component
{

    public $totalUsuarios;
    public $empleado;
    public $totalProductos; // Nueva variable para el total de productos
    public $comprasPorMes; // Nueva variable para las compras por mes

    Public $ventasMensuales; //Nueva variable para las ventas por mes
    public $TipoPagoDeCompraFrecuente;

    public function render()
    {
        // Establecer las variables
        $this->totalUsuarios = User::count();
        $this->empleado = User::where('profile', 'EMPLEADO')->count();
        $this->totalProductos = Product::count(); // Obtener el total de productos
        $this->comprasPorMes = $this->getComprasPorMes(); // Llamada a la función
        $this->ventasMensuales = $this->getVentasPorMes(); // Llamada a la función
        $this->TipoPagoDeCompraFrecuente = $this->getFrecuenciaTiposPago(); // Llamada a la función
        

        // Renderizar la vista
        return view('livewire.dash.component', ['hello' => 'Hola'])
            ->extends('layouts.theme.app')
            ->section('content');
    }
    private function getComprasPorMes()
    {
        return compras::select(DB::raw('MONTH(fecha) as mes'), DB::raw('COUNT(*) as total'))
        ->groupBy(DB::raw('MONTH(fecha)'))
        ->orderBy('mes')
        ->get();
    }

    private function getVentasPorMes()
    {
       return Sale::select(DB::raw('MONTH(created_at) as mes'), DB::raw('COUNT(*) as total'))
       ->groupBy(DB::raw('MONTH(created_at)'))
       ->orderBy('mes')
       ->get();
    }
     
     private function getFrecuenciaTiposPago()
    {
        $tiposPagoFrecuentes = compras::select(
            DB::raw('CASE 
                WHEN tipo_pago = "Efectivo" THEN 0
                WHEN tipo_pago = "Cheque" THEN 1
                WHEN tipo_pago = "Transferencia" THEN 2
                ELSE 3
            END as tipo_pago_numero'),
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('tipo_pago_numero')
        ->orderBy('tipo_pago_numero')
        ->get()
        ->map(function ($item) {
            return [
                'name' => $item->tipo_pago_numero,
                'y' => $item->total,
            ];
        });

    return $tiposPagoFrecuentes;
    }


}