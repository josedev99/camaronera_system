<?php

namespace App\Exports;

use App\Models\Movements;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Carbon\Carbon;

class SalesExport implements FromCollection, WithHeadings,  WithCustomStartCell, WithTitle, WithStyles
{
    public $cantC, $cantS, $totalC, $totalS, $totalI, $cantI, $userid, $reporType, $data, $product, $fromDate, $toDate;

    /**
    * @return \Illuminate\Support\Collection
    */

    function __construct($userid, $reporType, $product,$fi, $ff){
        $this->userid = $userid;
        $this->fromDate = $fi;
        $this->toDate = $ff;
        $this->product = $product;
        $this->reporType = $reporType;
    }

    public function collection()
    {
        $data = [];
        $count = 0;
        $data2 = [];
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
            ->whereBetween('movements.created_at', [$from, $to])->get()->toarray();
            $this->cantC = 0;
                $this->totalI = 0;
        } 
        elseif ($this->userid != 0 && $this->product == 0){
            $this->data = Movements::join('users as u', 'u.id', 'movements.user_id')
            ->join('products as p', 'p.id', 'movements.product_id')
            ->select('movements.*', 'u.name as user', 'p.name as product')
            ->whereBetween('movements.created_at', [$from, $to])
            ->where('user_id', $this->userid)
            ->get()->toarray();
            $this->cantC = 0;
                $this->totalC = 0;
        }
        elseif ($this->userid == 0 && $this->product != 0){
            $this->data = Movements::join('users as u', 'u.id', 'movements.user_id')
            ->join('products as p', 'p.id', 'movements.product_id')
            ->select('movements.*', 'u.name as user', 'p.name as product')
            ->whereBetween('movements.created_at', [$from, $to])
            ->where('product_id', $this->product)
            ->get()->toarray();

            $this->getmov($this->product);
        }
        else {
            $this->data = Movements::join('users as u', 'u.id', 'movements.user_id')
            ->join('products as p', 'p.id', 'movements.product_id')
            ->select('movements.*', 'u.name as user', 'p.name as product')
            ->whereBetween('movements.created_at', [$from, $to])
            ->where('product_id', $this->product)
            ->where('user_id', $this->userid)
            ->get()->toarray();

            $this->getmov($this->product, $this->userid);
        }
        foreach ($this->data as $d){
            $fecha = $this->data[$count]['created_at'];
            unset($this->data[$count]['created_at']);
            unset($this->data[$count]['updated_at']);
            unset($this->data[$count]['product_id']);
            unset($this->data[$count]['user_id']);
           
            $newf = Carbon::parse($fecha)->format('d-m-Y h:i:s A');
            $this->data[$count]['tiempo'] = $newf;
                        
                        
                        $count += 1;
        }

        if ($this->cantC > 0 && $this->totalC > 0) {
            $sep = ["id" => '-------',
            "quantity" => '-------',
            "available" => '-------',
            "price" => '-------',
            "priceu" =>'-------',
            "total" => '-------',
            "sald" => '-------',
            "type" => '-------',
            "user" => '-------',
            "product" => '-------'];
            array_push($this->data, $sep);

            $sep = ["id" => 'TOTAL CANT. COMPRA',
            "quantity" => 'TOTAL CANT. SALIDA',
            "available" => 'TOTAL CANT. DISPONIBLE',
            "price" => 'TOTAL SALDO COMPRA',
            "priceu" =>'TOTAL SALDO SALIDA',
            "total" => 'TOTAL',
            ];
            array_push($this->data, $sep);

            $sep = ["id" => $this->cantC,
            "quantity" => $this->cantS,
            "available" => number_format($this->cantI,2),
            "price" => $this->totalC,
            "priceu" =>$this->totalS,
            "total" => number_format($this->totalI,2),
            ];
            array_push($this->data, $sep);
        }
        
        

        

        return collect($this->data);
    }

    public function headings() : array
    {
        return ["FOLIO", "CANTIDAD", "TOTAL CANT", "PROMEDIO", "PRECIO U", "TOTAL MOV", "TOTAL SALDO", "TIPO", "USUARIO", "PRODUCTO", "FECHA"];
    }

    public function startCell(): string
    {
        return 'A2';
    }

    public function styles(Worksheet $sheet)
    {
       return [
        2 => ['font' => ['bold' => true]],

       ];
    }

    public function title(): string
    {
        return "Reporte de Ventas";
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
