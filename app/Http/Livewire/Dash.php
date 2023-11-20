<?php

namespace App\Http\Livewire;

use App\Models\SaleDetails;
use App\Models\Sale;
use App\Models\Movements;
use App\Models\Purchase;
use App\Models\PurchaseDetails;
use App\Models\Product;
use DateTime;
use DB;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class Dash extends Component
{

    public function render()
    {
        return view('livewire.dash.component', ['hello' => 'Hola'])
        ->extends('layouts.theme.app')
        ->section('content');
    }
}