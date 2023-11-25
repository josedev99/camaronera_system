<?php

namespace App\Http\Livewire;

use App\Models\SaleDetails;
use App\Models\Compras;
use App\Models\Movements;
use App\Models\Purchase;
use App\Models\PurchaseDetails;
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

    public function render()
    {
        // Establecer las variables
        $this->totalUsuarios = User::count();
        $this->empleado = User::where('profile', 'EMPLEADO')->count();
        $this->totalProductos = Product::count(); // Obtener el total de productos
        $this->comprasPorMes = $this->getComprasPorMes(); // Llamada a la función

        // Renderizar la vista
        return view('livewire.dash.component', ['hello' => 'Hola'])
            ->extends('layouts.theme.app')
            ->section('content');
    }
    private function getComprasPorMes()
    {
        return Compras::select(DB::raw('MONTH(fecha) as mes'), DB::raw('COUNT(*) as total'))
        ->groupBy(DB::raw('MONTH(fecha)'))
        ->orderBy('mes')
        ->get();
    }

}