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
    use WithPagination;

    public $top10Products = [], $salesWeek = [], $purchasesWeek = [], $salesMonth = [], $purchasesMotnh = [], $year, $search, $getsales = [], $top11Products = [];
    private $pagination = 4;

    public function mount()
    {
        $this->year = date("Y");
       
    }
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function render()
    {
        $this->getTop10();
        $this->getTop11();
        $this->getWeeksales();
        $this->getWeekpurchases();
        $this->getMonthsales();
        $this->getMonthpurchases();
        //$this->Getsales();

        
       
        
        
        
           
        
        

        
        

        return view('livewire.dash.component')
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function getTop10()
    {
        $this->top10Products = Movements::join('Products as p', 'movements.product_id', 'p.id')
            ->select(
                DB::raw("SUBSTRING(p.name,1,15) as producto, ROUND(sum(movements.sald),2) as cantidad")
            )
            ->where(function($query) {
                $query->where('type', '=', 'COMPRA')
                            ->orWhere('type', '=', 'NUEVO');})
            ->whereYear("movements.created_at", $this->year)
            ->groupBy('p.name')
            ->orderBy(DB::raw("count(movements.id)"), "desc")
            ->get()->take(5)->toArray();
        

        $condicion = (5 - count($this->top10Products));
        if($condicion > 0){
            for ($i=1; $i <= $condicion ; $i++) { 
                array_push($this->top10Products, ["producto" => "-", "cantidad" => 0]);
            }
        }
       
        
        
       
    }

    public function getTop11()
    {
        $this->top11Products = Movements::join('Products as p', 'movements.product_id', 'p.id')
            ->select(
                DB::raw("SUBSTRING(p.name,1,15) as producto, ROUND(sum(movements.sald),2) as cantidad")
            )
            ->where('type', '=', 'SALIDA')
            ->whereYear("movements.created_at", $this->year)
            ->groupBy('p.name')
            ->orderBy(DB::raw("count(movements.id)"), "desc")
            ->get()->take(5)->toArray();
        

        $condicion = (5 - count($this->top11Products));
        if($condicion > 0){
            for ($i=1; $i <= $condicion ; $i++) { 
                array_push($this->top11Products, ["producto" => "-", "cantidad" => 0]);
            }
        }
        
        
       
        
        
       
    }

    public function getWeeksales()
    {
        $dt = new DateTime();
        $starWeek = null;
        $endWeek = null;

        for ($i=1; $i < 8; $i++) { 
            $dt->setISODate($dt->format('o'),$dt->format('W'), $i);
            
            $starWeek = $dt->format('Y-m-d').' 00:00:00';
            $endWeek = $dt->format('Y-m-d').' 23:59:59';
           

            $data = Movements::where('type', '=', 'SALIDA')->whereBetween('created_at', [$starWeek, $endWeek])->sum('sald');
            array_push($this->salesWeek, $data);
        }

        
        
        
        
        

    }

    public function getWeekpurchases()
    {
        $dt = new DateTime();
        $starWeek = null;
        $endWeek = null;

        for ($i=1; $i < 8; $i++) { 
            $dt->setISODate($dt->format('o'),$dt->format('W'), $i);
            
            $starWeek = $dt->format('Y-m-d').' 00:00:00';
            $endWeek = $dt->format('Y-m-d').' 23:59:59';
           

            $data = Movements::where(function($query) {
                $query->where('type', '=', 'COMPRA')
                            ->orWhere('type', '=', 'NUEVO');})->whereBetween('created_at', [$starWeek, $endWeek])->sum('sald');
            array_push($this->purchasesWeek, $data);
        }
        
       
        
        
        
        
        
        

    }

    public function getMonthsales()
    {
        $Monthsales = DB::select(
            DB::raw("SELECT coalesce(cantidad,0) as cantidad
            FROM (SELECT 'January' 
            AS month UNION
            SELECT 'February'
            AS month UNION
            SELECT 'March'
            AS month UNION
            SELECT 'April'
            AS month UNION
            SELECT'May' 
            AS month UNION
            SELECT 'June' 
            AS month UNION
            SELECT 'July' 
            AS month UNION
            SELECT 'August'
            AS month UNION
            SELECT 'September'
            AS month UNION
            SELECT'October' 
            AS month UNION
            SELECT 'November'
            AS month UNION
            SELECT 'December' AS month) m LEFT JOIN (SELECT MONTHNAME(created_at) AS MONTH, COUNT(*) AS info, SUM(sald) as cantidad
            FROM movements WHERE year(created_at) = $this->year AND movements.type = 'SALIDA'
            GROUP BY MONTHNAME(created_at), MONTH(created_at)
            ORDER BY MONTH(created_at)) c ON m.MONTH = c.MONTH;
            ")
        );

        foreach ($Monthsales as $sales) {
           array_push($this->salesMonth, $sales->cantidad);
        }
        

       
        

        
    }

    public function getMonthpurchases()
    {
        $Monthpurchases = DB::select(
            DB::raw("SELECT coalesce(cantidad,0) as cantidad
            FROM (SELECT 'January' 
            AS month UNION
            SELECT 'February'
            AS month UNION
            SELECT 'March'
            AS month UNION
            SELECT 'April'
            AS month UNION
            SELECT'May' 
            AS month UNION
            SELECT 'June' 
            AS month UNION
            SELECT 'July' 
            AS month UNION
            SELECT 'August'
            AS month UNION
            SELECT 'September'
            AS month UNION
            SELECT'October' 
            AS month UNION
            SELECT 'November'
            AS month UNION
            SELECT 'December' AS month) m LEFT JOIN (SELECT MONTHNAME(created_at) AS MONTH, COUNT(*) AS info, SUM(sald) as cantidad
            FROM movements WHERE year(created_at) = $this->year AND (movements.type = 'COMPRA' OR movements.type = 'NUEVO')
            GROUP BY MONTHNAME(created_at), MONTH(created_at)
            ORDER BY MONTH(created_at)) c ON m.MONTH = c.MONTH;
            ")
        );

        foreach ($Monthpurchases as $sales) {
           array_push($this->purchasesMotnh, $sales->cantidad);
        }

        
        

        
    }

    public function Getsales()
    {
        $to = Carbon::parse(Carbon::now())->subDays(2)->toDateTimeString();

       
        $from = Carbon::parse(Carbon::now())->startOfYear()->toDateTimeString();

        

        $this->getsales = sale::where('status', '=', 4)->whereBetween('created_at', [$from, $to])->get();
       
       
         
       

        
        
    }
}