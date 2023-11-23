<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Sale;
use App\Models\compras;
use App\Models\Product;
use App\Models\Movements;
use App\Models\SaleDetails;
use Carbon\Carbon;
use Livewire\Component;
use DB;


class Reports extends Component
{
    public $fromDate, $toDate, $total, $items, $sales, $details, 
    $userid, $reporType, $data , $sumDetails, $countDetails, $saleid, $product, $getMovement = [],
    $cantC, $cantS, $totalC, $totalS, $totalI, $cantI, $compras, $ventas, $type, $pond, $abonos;

    public function mount() 
    {
        
        
        $this->userid = 0;
        $this->pond = 'Estanque 1';
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

        return view('livewire.reports.component', ['users' => User::orderBy('name', 'asc')->get(),
         'products' => Product::orderBy('nombre', 'asc')->get()])
        ->extends('layouts.theme.app')
        ->section('content'); 
    }

    public function SalesByDate()
    {
        
        if($this->reporType == 0) //ventas de dia
        {
            $this->compras = null;
            $this->abonos = null;
            $from = Carbon::parse(Carbon::now())->format('Y-m-d').' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d').' 23:59:59';

            $this->ventas = DB::table('sales')
            ->join('users as u', 'u.id', '=', 'sales.user_id')
            ->whereBetween('sales.created_at', [$from, $to])
            ->where('sales.pond', '=', $this->pond)
            ->select(
                'sales.*',
                'u.name as usuario',
            )
            ->when($this->userid > 0, function ($query) {
                $query->where(function ($subquery) {
                    $subquery->where('u.id', '=', $this->userid);
                });
            })->get();
            

        }
        elseif($this->reporType == 1) { //compras de dia
            $this->ventas = null;
            $this->abonos = null;
            $from = Carbon::parse(Carbon::now())->format('Y-m-d').' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d').' 23:59:59';

            $this->compras = DB::table('compras')
            ->join('users as u', 'u.id', '=', 'compras.user_id')
            ->join('products as p', 'p.id', '=', 'compras.product_id')
            ->select(
                'compras.*',
                'p.nombre as producto',
                'u.name as usuario',
                DB::raw("DATE_FORMAT(compras.created_at, '%d/%m/%Y') as fecha"),
            )
            ->whereBetween('compras.created_at', [$from, $to])
            ->when($this->userid > 0, function ($query) {
                $query->where(function ($subquery) {
                    $subquery->where('u.id', '=', $this->userid);
                });
            })->get();
            //dd($this->compras);
        }
        elseif($this->reporType == 2) { //ventas fecha
            $this->compras = null;
            $this->abonos = null;
            $from = Carbon::parse($this->fromDate)->format('Y-m-d').' 00:00:00';
            $to = Carbon::parse($this->toDate)->format('Y-m-d').' 23:59:59';
            $this->ventas = DB::table('sales')
            ->join('users as u', 'u.id', '=', 'sales.user_id')
            ->whereBetween('sales.created_at', [$from, $to])
            ->where('sales.pond', '=', $this->pond)
            ->select(
                'sales.*',
                'u.name as usuario',
            )
            ->when($this->userid > 0, function ($query) {
                $query->where(function ($subquery) {
                    $subquery->where('u.id', '=', $this->userid);
                });
            })->get();

        }
        elseif ($this->reporType == 4) {
            $this->compras = null;
            $this->ventas = null;
            $from = Carbon::parse(Carbon::now())->format('Y-m-d').' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d').' 23:59:59';

            $this->abonos = DB::table('abonos')
            ->join('users as u', 'u.id', '=', 'abonos.user_id')
            ->join('sales as s', 's.id', '=', 'abonos.sale_id')
            ->select(
                'abonos.*',
                'u.name as usuario',
                DB::raw("DATE_FORMAT(abonos.created_at, '%d/%m/%Y') as fecha"),
                's.customer as cliente'
            )
            ->whereBetween('abonos.created_at', [$from, $to])
            ->when($this->userid > 0, function ($query) {
                $query->where(function ($subquery) {
                    $subquery->where('u.id', '=', $this->userid);
                });
            })->get();
           

        }
        elseif ($this->reporType == 5) {
            $this->compras = null;
            $this->ventas = null;
            $from = Carbon::parse($this->fromDate)->format('Y-m-d').' 00:00:00';
            $to = Carbon::parse($this->toDate)->format('Y-m-d').' 23:59:59';

            $this->abonos = DB::table('abonos')
            ->join('users as u', 'u.id', '=', 'abonos.user_id')
            ->join('sales as s', 's.id', '=', 'abonos.sale_id')
            ->select(
                'abonos.*',
                'u.name as usuario',
                DB::raw("DATE_FORMAT(abonos.created_at, '%d/%m/%Y') as fecha"),
                's.customer as cliente'
            )
            ->whereBetween('abonos.created_at', [$from, $to])
            ->when($this->userid > 0, function ($query) {
                $query->where(function ($subquery) {
                    $subquery->where('u.id', '=', $this->userid);
                });
            })->get();
           

        }
        
        else {//compras fecha
            $this->ventas = null;
            $this->abonos = null;
            $from = Carbon::parse($this->fromDate)->format('Y-m-d').' 00:00:00';
            $to = Carbon::parse($this->toDate)->format('Y-m-d').' 23:59:59';
            $this->compras = DB::table('compras')
            ->join('users as u', 'u.id', '=', 'compras.user_id')
            ->join('products as p', 'p.id', '=', 'compras.product_id')
            ->select(
                'compras.*',
                'p.nombre as producto',
                'u.name as usuario',
                DB::raw("DATE_FORMAT(compras.created_at, '%d/%m/%Y') as fecha"),
            )
            ->whereBetween('compras.created_at', [$from, $to])
            ->when($this->userid > 0, function ($query) {
                $query->where(function ($subquery) {
                    $subquery->where('u.id', '=', $this->userid);
                });
            })->get();
        }

        
        

        

        
    }

   
}
