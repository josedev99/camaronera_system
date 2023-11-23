<?php

namespace App\Http\Controllers;

use App\Exports\SalesExport;
use App\Exports\ReportG;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\Sale;
use App\Models\Movements;
use App\Models\SaleDetails;
use App\Models\User;
use App\Models\Product;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class ExportController extends Controller
{
    public $cantC, $cantS, $totalC, $totalS, $totalI, $cantI,
        $userid, $reporType, $data, $product, $fromDate, $toDate, $ventas, $compras, $pond, $abonos;

    public function reportPDF($userid, $reporType, $product, $dateFrom = null, $dateTo = null)
    {
        Carbon::setlocale(config('app.locale'));

        $this->reporType = $reporType;
        $this->userid = $userid;
        $this->product = $product;
        $this->fromDate = $dateFrom;
        $this->toDate = $dateTo;

        if ($this->reporType == 0) //ventas de dia
        {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59';
        } elseif ($this->reporType == 2) {
            $from = Carbon::parse(Carbon::now())->startOfYear()->toDateTimeString();
            $dateFrom = Carbon::parse($from)->format('d-m-Y');
            $to = Carbon::parse(Carbon::now())->endOfYear()->toDateTimeString();
            $dateTo = Carbon::parse(Carbon::now())->format('d-m-Y');
        } else {
            $from = Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59';
        }




        if ($this->userid == 0 && $this->product == 0) {
            $this->data = Movements::join('users as u', 'u.id', 'movements.user_id')
                ->join('products as p', 'p.id', 'movements.product_id')
                ->select('movements.*', 'u.name as user', 'p.name as product')
                ->whereBetween('movements.created_at', [$from, $to])->get();
            $this->cantC = 0;
            $this->totalI = 0;
        } elseif ($this->userid != 0 && $this->product == 0) {
            $this->data = Movements::join('users as u', 'u.id', 'movements.user_id')
                ->join('products as p', 'p.id', 'movements.product_id')
                ->select('movements.*', 'u.name as user', 'p.name as product')
                ->whereBetween('movements.created_at', [$from, $to])
                ->where('user_id', $this->userid)
                ->get();
            $this->cantC = 0;
            $this->totalC = 0;
        } elseif ($this->userid == 0 && $this->product != 0) {
            $this->data = Movements::join('users as u', 'u.id', 'movements.user_id')
                ->join('products as p', 'p.id', 'movements.product_id')
                ->select('movements.*', 'u.name as user', 'p.name as product')
                ->whereBetween('movements.created_at', [$from, $to])
                ->where('product_id', $this->product)
                ->get();

            $this->getmov($this->product);
        } else {
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



        $pdf = Pdf::loadView('pdf.reports', compact('data', 'reporType', 'user', 'dateFrom', 'dateTo', 'cantC', 'cantS', 'cantI', 'totalC', 'totalS', 'totalI', 'product'));
        $reportNow = Carbon::parse(Carbon::now())->format('d-m-Y h-i');
        return $pdf->stream('Movimientos ' . $reportNow . ' .pdf');
        //return $pdf->download('ventas.pdf');
    }

    public function ReporteExcel($userid, $reporType, $product, $fi = null, $ff = null)
    {
        $reportName = "Reporte de Ventas_" . uniqid() . '.xlsx';
        return Excel::download(new SalesExport($userid, $reporType, $product, $fi, $ff), $reportName);
    }

    public function getmov($product, $userid = 0)
    {
        if ($this->reporType == 0) //ventas de dia
        {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59';
        } elseif ($this->reporType == 2) {
            $from = Carbon::parse(Carbon::now())->startOfYear()->toDateTimeString();
            $to = Carbon::parse(Carbon::now())->endOfYear()->toDateTimeString();
        } else {
            $from = Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59';
        }

        if ($userid != 0) {
            $data = [];
            $data = Movements::where('product_id', '=', $product)
                ->where(function ($query) {
                    $query->where('type', '=', 'COMPRA')
                        ->orWhere('type', '=', 'NUEVO');
                })
                ->where('user_id', '=', $userid)
                ->whereBetween('movements.created_at', [$from, $to])
                ->selectRaw("SUM(sald) as total_sum")
                ->selectRaw("SUM(quantity) as quantity_sum")
                ->groupBy('product_id')
                ->get()->toArray();

            if ($data) {
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

            if ($data) {
                $this->cantS = $data[0]['quantity_sum'];
                $this->totalS = $data[0]['total_sum'];
                $this->cantI = $this->cantI - $data[0]['quantity_sum'];
                $this->totalI = $this->totalI - $data[0]['total_sum'];
            } else {
                $this->cantS = 0;
                $this->totalS = 0;
            }
        } else {
            $data = [];
            $data = Movements::where('product_id', '=', $product)
                ->where(function ($query) {
                    $query->where('type', '=', 'COMPRA')
                        ->orWhere('type', '=', 'NUEVO');
                })
                ->whereBetween('movements.created_at', [$from, $to])
                ->selectRaw("SUM(sald) as total_sum")
                ->selectRaw("SUM(quantity) as quantity_sum")
                ->groupBy('product_id')
                ->get()->toArray();

            if ($data) {
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

            if ($data) {
                $this->cantS = $data[0]['quantity_sum'];
                $this->totalS = $data[0]['total_sum'];
                $this->cantI = $this->cantI - $data[0]['quantity_sum'];
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

    public function ventas_pdf($userid, $reporType, $pond, $dateFrom = null, $dateTo = null)
    {
        $this->userid = $userid;
        $this->reporType = $reporType;
        $this->pond = $pond;
        $this->fromDate = $dateFrom;
        $this->toDate = $dateTo;
        $this->consulta();
        $data = $this->ventas;
        $user = $userid == 0 ? 'Todos' : User::find($userid)->name;

        $pdf = Pdf::loadView('pdf.ventas', compact('data', 'reporType', 'user', 'dateFrom', 'dateTo'));
        $reportNow = Carbon::parse(Carbon::now())->format('d-m-Y h-i');
        return $pdf->stream('Ventas ' . $reportNow . ' .pdf');
    }

    public function compras_pdf($userid, $reporType, $dateFrom = null, $dateTo = null)
    {
        $this->userid = $userid;
        $this->reporType = $reporType;
        $this->fromDate = $dateFrom;
        $this->toDate = $dateTo;
        $this->consulta();
        $data = $this->compras;
        $user = $userid == 0 ? 'Todos' : User::find($userid)->name;

        $pdf = Pdf::loadView('pdf.compras', compact('data', 'reporType', 'user', 'dateFrom', 'dateTo'));
        $reportNow = Carbon::parse(Carbon::now())->format('d-m-Y h-i');
        return $pdf->stream('Compras ' . $reportNow . ' .pdf');
    }

    public function abonos_pdf($userid, $reporType, $dateFrom = null, $dateTo = null)
    {
        $this->userid = $userid;
        $this->reporType = $reporType;
        $this->fromDate = $dateFrom;
        $this->toDate = $dateTo;
        $this->consulta();
        $data = $this->abonos;
        $user = $userid == 0 ? 'Todos' : User::find($userid)->name;

        $pdf = Pdf::loadView('pdf.abonos', compact('data', 'reporType', 'user', 'dateFrom', 'dateTo'));
        $reportNow = Carbon::parse(Carbon::now())->format('d-m-Y h-i');
        return $pdf->stream('Abonos ' . $reportNow . ' .pdf');
    }

    public function ventas_excel($userid, $reporType, $pond, $dateFrom = null, $dateTo = null)
    {
        $this->userid = $userid;
        $this->reporType = $reporType;
        $this->pond = $pond;
        $this->fromDate = $dateFrom;
        $this->toDate = $dateTo;
        $this->consulta2();
        $data = $this->ventas;
        //dd($data);
        
        $title = 'Ventas';
        $headers = [
            'FACTURA',
            'CLIENTE',
            'TIPO F.',
            'GRAMOS',
            'LIBRAS',
            'TOTAL',
            'IVA',
            'ESTANQUE',
            'ESTADO',
            'USUARIO',
            'FECHA'
        ];

        $reportName = "Reporte de Ventas_" . uniqid() . '.xlsx';
        return Excel::download(new ReportG($data, $headers, $title), $reportName);
    }

    public function compras_excel($userid, $reporType, $dateFrom = null, $dateTo = null)
    {
        $this->userid = $userid;
        $this->reporType = $reporType;
        $this->fromDate = $dateFrom;
        $this->toDate = $dateTo;
        $this->consulta2();
        $data = $this->compras;
        //dd($data);
        
        $title = 'Compras';
        $headers = [
            'PRODUCTO',
            'PRECIO U.',
            'CANTIDAD',
            'MONTO',
            'TIPO P.',
            'USUARIO',
            'FECHA',
        ];

        $reportName = "Reporte de Compras_" . uniqid() . '.xlsx';
        return Excel::download(new ReportG($data, $headers, $title), $reportName);
    }

    public function abonos_excel($userid, $reporType, $dateFrom = null, $dateTo = null)
    {
        $this->userid = $userid;
        $this->reporType = $reporType;
        $this->fromDate = $dateFrom;
        $this->toDate = $dateTo;
        $this->consulta2();
        $data = $this->abonos;
        //dd($data);
        
        $title = 'Abonos';
        $headers = [
            'FACTURA',
            'CLIENTE',
            'TIPO',
            'ABONO',
            'SALDO',
            'USUARIO',
            'FECHA',
        ];

        $reportName = "Reporte de Abonos_" . uniqid() . '.xlsx';
        return Excel::download(new ReportG($data, $headers, $title), $reportName);
    }

    public function consulta()
    {
        if ($this->reporType == 0) //ventas de dia
        {
            $this->compras = null;
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59';

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
        } elseif ($this->reporType == 1) { //compras de dia
            $this->ventas = null;
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59';

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
        } elseif ($this->reporType == 2) { //ventas fecha
            $this->compras = null;
            $from = Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59';
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
        } elseif ($this->reporType == 4) {
            $this->compras = null;
            $this->ventas = null;
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59';

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
        } elseif ($this->reporType == 5) {
            $this->compras = null;
            $this->ventas = null;
            $from = Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59';

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
        } else { //compras fecha
            $this->ventas = null;
            $from = Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59';
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

    public function consulta2()
    {
        if ($this->reporType == 0) //ventas de dia
        {
            $this->compras = null;
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59';

            $this->ventas = DB::table('sales')
                ->join('users as u', 'u.id', '=', 'sales.user_id')
                ->whereBetween('sales.created_at', [$from, $to])
                ->where('sales.pond', '=', $this->pond)
                ->select(
                    'sales.invoice',
                    'sales.customer',
                    'sales.type_invoice',
                    'sales.grams',
                    'sales.items',
                    'sales.total',
                    'sales.iva',
                    'sales.pond',
                    'sales.status',
                    'u.name as usuario',
                    DB::raw("DATE_FORMAT(sales.created_at, '%d/%m/%Y') as fecha"),
                )
                ->when($this->userid > 0, function ($query) {
                    $query->where(function ($subquery) {
                        $subquery->where('u.id', '=', $this->userid);
                    });
                })->get();
        } elseif ($this->reporType == 1) { //compras de dia
            $this->ventas = null;
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59';

            $this->compras = DB::table('compras')
                ->join('users as u', 'u.id', '=', 'compras.user_id')
                ->join('products as p', 'p.id', '=', 'compras.product_id')
                ->select(
                    'p.nombre as producto',
                    'compras.precioUnit',
                    'compras.cantidad',
                    'compras.monto',
                    'compras.tipo_pago',
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
        } elseif ($this->reporType == 2) { //ventas fecha
            $this->compras = null;
            $from = Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59';
            $this->ventas = DB::table('sales')
                ->join('users as u', 'u.id', '=', 'sales.user_id')
                ->whereBetween('sales.created_at', [$from, $to])
                ->where('sales.pond', '=', $this->pond)
                ->select(
                    'sales.invoice',
                    'sales.customer',
                    'sales.type_invoice',
                    'sales.grams',
                    'sales.items',
                    'sales.total',
                    'sales.iva',
                    'sales.pond',
                    'sales.status',
                    'u.name as usuario',
                    DB::raw("DATE_FORMAT(sales.created_at, '%d/%m/%Y') as fecha"),
                )
                ->when($this->userid > 0, function ($query) {
                    $query->where(function ($subquery) {
                        $subquery->where('u.id', '=', $this->userid);
                    });
                })->get();
        } elseif ($this->reporType == 4) {
            $this->compras = null;
            $this->ventas = null;
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59';

            $this->abonos = DB::table('abonos')
                ->join('users as u', 'u.id', '=', 'abonos.user_id')
                ->join('sales as s', 's.id', '=', 'abonos.sale_id')
                ->select(
                    'abonos.numero_recibo',
                    's.customer as cliente',
                    'abonos.tipo_pago',
                    'abonos.monto_abono',
                    'abonos.saldo',
                    'u.name as usuario',
                    DB::raw("DATE_FORMAT(abonos.created_at, '%d/%m/%Y') as fecha"),
                )
                ->whereBetween('abonos.created_at', [$from, $to])
                ->when($this->userid > 0, function ($query) {
                    $query->where(function ($subquery) {
                        $subquery->where('u.id', '=', $this->userid);
                    });
                })->get();
        } elseif ($this->reporType == 5) {
            $this->compras = null;
            $this->ventas = null;
            $from = Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59';

            $this->abonos = DB::table('abonos')
                ->join('users as u', 'u.id', '=', 'abonos.user_id')
                ->join('sales as s', 's.id', '=', 'abonos.sale_id')
                ->select(
                    'abonos.numero_recibo',
                    's.customer as cliente',
                    'abonos.tipo_pago',
                    'abonos.monto_abono',
                    'abonos.saldo',
                    'u.name as usuario',
                    DB::raw("DATE_FORMAT(abonos.created_at, '%d/%m/%Y') as fecha"),
                )
                ->whereBetween('abonos.created_at', [$from, $to])
                ->when($this->userid > 0, function ($query) {
                    $query->where(function ($subquery) {
                        $subquery->where('u.id', '=', $this->userid);
                    });
                })->get();
        } else { //compras fecha
            $this->ventas = null;
            $from = Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59';
            $this->compras = DB::table('compras')
                ->join('users as u', 'u.id', '=', 'compras.user_id')
                ->join('products as p', 'p.id', '=', 'compras.product_id')
                ->select(
                    'p.nombre as producto',
                    'compras.precioUnit',
                    'compras.cantidad',
                    'compras.monto',
                    'compras.tipo_pago',
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
