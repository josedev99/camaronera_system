<?php

namespace App\Http\Controllers;

use App\Exports\SalesExport;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon; 
use App\Models\Sale;
use App\Models\Movements;
use App\Models\SaleDetails;
use App\Models\User;
use App\Models\Product;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public $cantC, $cantS, $totalC, $totalS, $totalI, $cantI, $userid, $reporType, $data, $product, $fromDate, $toDate;
    
    public function reportPDF($userid, $reporType, $product, $dateFrom = null, $dateTo = null)
    {
        Carbon::setlocale(config('app.locale'));
       
        $this->reporType = $reporType;
        $this->userid = $userid;
        $this->product = $product;
        $this->fromDate = $dateFrom;
        $this->toDate = $dateTo;
        
       if($this->reporType == 0) //ventas de dia
       {
           $from = Carbon::parse(Carbon::now())->format('Y-m-d').' 00:00:00';
           $to = Carbon::parse(Carbon::now())->format('Y-m-d').' 23:59:59';
           

       }
       elseif($this->reporType == 2) {
        $from = Carbon::parse(Carbon::now())->startOfYear()->toDateTimeString();
        $dateFrom = Carbon::parse($from)->format('d-m-Y');
        $to = Carbon::parse(Carbon::now())->endOfYear()->toDateTimeString();
        $dateTo = Carbon::parse(Carbon::now())->format('d-m-Y');
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

       
        $data = $this->data;
        $user = $userid == 0 ? 'Todos' : User::find($userid)->name;
        $product = $product == 0 ? 'Todos' : Product::find($product)->name;
        $cantC = $this->cantC;
        $cantS = $this->cantS; 
        $cantI = $this->cantI;
        $totalC = $this->totalC;
        $totalS = $this->totalS;
        $totalI = $this->totalI;

        

        $pdf = Pdf::loadView('pdf.reports', compact('data', 'reporType', 'user', 'dateFrom', 'dateTo','cantC','cantS','cantI','totalC','totalS','totalI', 'product'));
        $reportNow = Carbon::parse(Carbon::now())->format('d-m-Y h-i');
        return $pdf->stream('Movimientos '.$reportNow.' .pdf');
        //return $pdf->download('ventas.pdf');
    }

    public function ReporteExcel($userid, $reporType, $product ,$fi = null, $ff= null)
    {
        $reportName = "Reporte de Ventas_".uniqid().'.xlsx';
        return Excel::download(new SalesExport($userid, $reporType, $product,$fi, $ff), $reportName);
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
