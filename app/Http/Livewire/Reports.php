<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Movements;
use App\Models\SaleDetails;
use Carbon\Carbon;
use Livewire\Component;


class Reports extends Component
{
    public $fromDate, $toDate, $total, $items, $sales, $details, 
    $userid, $reporType, $data , $sumDetails, $countDetails, $saleid, $product, $getMovement = [],
    $cantC, $cantS, $totalC, $totalS, $totalI, $cantI;

    public function mount() 
    {
        
        
        $this->userid = 0;
        $this->product = 0;
       
        $this->sales = [];
        $this->details = [];
        $this->data = []; //recordar quitar
        $this->reporType = 0;
        $this->sumDetails = 0;
        $this->countDetails = 0;
        $this->saleid = 0;
        
        
        
    }
    public function render()
    {
        $this->SalesByDate();

        return view('livewire.reports.component', ['users' => User::orderBy('name', 'asc')->get(), 'products' => Product::orderBy('name', 'asc')->get()])
        ->extends('layouts.theme.app')
        ->section('content'); 
    }

    public function SalesByDate()
    {
        
        if($this->reporType == 0) //ventas de dia
        {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d').' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d').' 23:59:59';


        }
        elseif($this->reporType == 2) {
            $from = Carbon::parse(Carbon::now())->startOfYear()->toDateTimeString();
            $to = Carbon::parse(Carbon::now())->endOfYear()->toDateTimeString();
        }
        
        else {
            $from = Carbon::parse($this->fromDate)->format('Y-m-d').' 00:00:00';
            $to = Carbon::parse($this->toDate)->format('Y-m-d').' 23:59:59';
        }

        
        

        if ($this->userid == 0 && $this->product == 0) {
            $this->data = Movements::join('users as u', 'u.id', 'movements.user_id')
            ->join('products as p', 'p.id', 'movements.product_id')
            ->select('movements.*', 'u.name as user', 'p.name as product')
            ->whereBetween('movements.created_at', [$from, $to])->get();
            $this->cantC = 0;
                $this->totalI = 0;
        } 
        elseif ($this->userid != 0 && $this->product == 0){
            $this->data = Movements::join('users as u', 'u.id', 'movements.user_id')
            ->join('products as p', 'p.id', 'movements.product_id')
            ->select('movements.*', 'u.name as user', 'p.name as product')
            ->whereBetween('movements.created_at', [$from, $to])
            ->where('user_id', $this->userid)
            ->get();
            $this->cantC = 0;
                $this->totalC = 0;
        }
        elseif ($this->userid == 0 && $this->product != 0){
            $this->data = Movements::join('users as u', 'u.id', 'movements.user_id')
            ->join('products as p', 'p.id', 'movements.product_id')
            ->select('movements.*', 'u.name as user', 'p.name as product')
            ->whereBetween('movements.created_at', [$from, $to])
            ->where('product_id', $this->product)
            ->get();

            $this->getmov($this->product);
        }
        else {
            $this->data = Movements::join('users as u', 'u.id', 'movements.user_id')
            ->join('products as p', 'p.id', 'movements.product_id')
            ->select('movements.*', 'u.name as user', 'p.name as product')
            ->whereBetween('movements.created_at', [$from, $to])
            ->where('product_id', $this->product)
            ->where('user_id', $this->userid)
            ->get();

            $this->getmov($this->product, $this->userid);
        }
        

        
    }

    public function getDetails($saleid)
    {
        $this->details = SaleDetails::join('products as p', 'p.id', 'sale_details.product_id')
        ->select('sale_details.id', 'sale_details.price', 'sale_details.quantity', 'p.name as product')
        ->where('sale_details.sale_id', $saleid)->get();

        $suma = $this->details->sum(function ($item)
        {
            return $item->price * $item->quantity;
        });

        $this->sumDetails = $suma;

        $this->countDetails = $this->details->sum('quantity');
        $this->saleid = $saleid;

        $this->emit('show-modal', 'modal');
    }

    public function getmov($product, $userid = 0)
    {
        if($this->reporType == 0) //ventas de dia
        {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d').' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d').' 23:59:59';


        }
        elseif($this->reporType == 2) {
            $from = Carbon::parse(Carbon::now())->startOfYear()->toDateTimeString();
            $to = Carbon::parse(Carbon::now())->endOfYear()->toDateTimeString();
        }
        else {
            $from = Carbon::parse($this->fromDate)->format('Y-m-d').' 00:00:00';
            $to = Carbon::parse($this->toDate)->format('Y-m-d').' 23:59:59';
        }
        
        if ($userid != 0) {
            $data = [];
            $data = Movements::where('product_id', '=', $product)
            ->where(function($query) {
                $query->where('type', '=', 'COMPRA')
                            ->orWhere('type', '=', 'NUEVO');})
            ->where('user_id', '=', $userid)
            ->whereBetween('movements.created_at', [$from, $to])
            ->selectRaw("SUM(sald) as total_sum")
            ->selectRaw("SUM(quantity) as quantity_sum")
            ->groupBy('product_id')
            ->get()->toArray();

            if($data){
                $this->cantC = $data[0]['quantity_sum'];
                $this->totalC = $data[0]['total_sum'];
                $this->cantI = $data[0]['quantity_sum'];
                $this->totalI = $data[0]['total_sum'];
            } else {
                $this->cantC = 0;
                $this->totalC = 0;
                $this->cantI = 0;
                $this->totalI = 0;
            }

            $data = Movements::where('product_id', '=', $product)
            ->where('type', '=', 'SALIDA')
            ->where('user_id', '=', $userid)
            ->whereBetween('movements.created_at', [$from, $to])
            ->selectRaw("SUM(sald) as total_sum")
            ->selectRaw("SUM(quantity) as quantity_sum")
            ->groupBy('product_id')
            ->get()->toArray();

            if($data){
                $this->cantS = $data[0]['quantity_sum'];
                $this->totalS = $data[0]['total_sum'];
                $this->cantI = $this->cantI-$data[0]['quantity_sum'];
                $this->totalI = $this->totalI - $data[0]['total_sum'];
            } else {
                $this->cantS = 0;
                $this->totalS = 0;
            }

        } else {
            $data = [];
            $data = Movements::where('product_id', '=', $product)
            ->where(function($query) {
                $query->where('type', '=', 'COMPRA')
                            ->orWhere('type', '=', 'NUEVO');})
            ->whereBetween('movements.created_at', [$from, $to])
            ->selectRaw("SUM(sald) as total_sum")
            ->selectRaw("SUM(quantity) as quantity_sum")
            ->groupBy('product_id')
            ->get()->toArray();

            if($data){
                $this->cantC = $data[0]['quantity_sum'];
                $this->totalC = $data[0]['total_sum'];
                $this->cantI = $data[0]['quantity_sum'];
                $this->totalI = $data[0]['total_sum'];
            } else {
                $this->cantC = 0;
                $this->totalC = 0;
                $this->cantI = 0;
                $this->totalI = 0;
            }

            $data = Movements::where('product_id', '=', $product)
            ->where('type', '=', 'SALIDA')
            ->whereBetween('movements.created_at', [$from, $to])
            ->selectRaw("SUM(sald) as total_sum")
            ->selectRaw("SUM(quantity) as quantity_sum")
            ->groupBy('product_id')
            ->get()->toArray();

            if($data){
                $this->cantS = $data[0]['quantity_sum'];
                $this->totalS = $data[0]['total_sum'];
                $this->cantI = $this->cantI-$data[0]['quantity_sum'];
                $this->totalI = $this->totalI - $data[0]['total_sum'];
            } else {
                $this->cantS = 0;
                $this->totalS = 0;
            }
           
            


        }
        
       
            
                
                /* $this->getMovement[1] = Movements::where('product_id', '=', $this->product)
                ->where('type', '=', 'SALIDA')
                ->selectRaw("SUM(total) as total_sum")
                ->selectRaw("SUM(quantity) as quantity_sum")
                ->groupBy('product_id')
                ->get()->toArray(); */
    }
}
