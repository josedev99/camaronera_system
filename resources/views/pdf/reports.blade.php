<!DOCTYPE html>
<html lang="es">
<head> 
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Movimientos</title>
    <link href="{{public_path('css/custom.css')}}" rel="stylesheet" type="text/css" />
    
    <link href="{{public_path('css/custom_pdf.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{public_path('css/custom_page.css')}}" rel="stylesheet" type="text/css" />
</head>
<body>
    <section class="header" style="top:-287px;">
        <table cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td colspan="2" class="text-center">
                    <span style="font-size: 25px; font-weight:bold;">Sistema de inventarios MAE S.A. De C.V.</span>
                </td>
            </tr>
            <tr>
                <td width="30%" style="vertical-align:top; padding-top:10px; position:relative;">
                    <img src="{{public_path('assets/img/empresa.png')}}" alt="" class="invoice-logo">
                </td>

                <td width="70%" class="text-left text-company" style="vertical-align: top; padding-top: 10px;">
                    
                    @if($reporType == 0)
                    <span style="font-size: 16px;"><strong>Reportes de movimientos del dia</strong></span>
                    @elseif($reporType == 2)
                    <span style="font-size: 16px;"><strong>Reportes de movimientos del año</strong></span>
                    @else
                    <span style="font-size: 16px;"><strong>Reportes de movimientos por fechas</strong></span>
                    @endif
                    <br>
                    @if($reporType != 0)
                    <span style="font-size: 16px;"><strong>Fecha de Consulta: {{$dateFrom}} al {{$dateTo}}</strong></span>
                    @else
                    <span style="font-size: 16px;"><strong>Fecha de Consulta: {{\Carbon\Carbon::now()->format('d-m-Y')}}</strong></span>
                    @endif
                    <br>
                    <span style="font-size: 14px;">Usuario: {{$user}}</span>
                    <br>
                    <span style="font-size: 14px;">Producto: {{$product}}</span>
                </td>
            </tr>
        </table>
    </section>

    <section style="margin-top: -110px;">
        <table cellpadding="0" cellspacing="0" width="100%" class="table-items">
            <thead>
                <tr>
                    <th>FOLIO</th>
                    <th>TIPO</th>
                    <th>CANT</th>
                    <th>PRECIO U</th>
                    <th>PROMEDIO</th>
                    <th>TOTAL CANT</th>
                    <th>TOTAL SALDO</th>
                    <th>TOTAL MOV</th>
                    <th>PRODUCTO</th>
                    <th>USUARIO</th>
                    <th>FECHA</th>
                </tr>
            </thead>
            <tbody>
                
                @foreach($data as $item)
                <tr>
                    <td align="center">{{$item->id}}</td>
                    <td align="center">{{$item->type}}</td>
                    <td align="center">{{$item->quantity}}</td>
                    <td align="center">${{$item->priceu}}</td>
                    <td align="center">${{number_format($item->price,2)}}</td>
                    <td align="center">{{$item->available}}</td>
                    <td align="center">${{$item->sald}}</td>
                    <td align="center">${{$item->total}}</td>
                    <td align="center">{{$item->product}}</td>
                    <td align="center">{{$item->user}}</td>
                    <td align="center">{{\Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i:s')}}</td>
                </tr>
                @endforeach
                
            </tbody>
            
        </table>
        @if($cantC > 0 && $totalC > 0)
        <table cellpadding="0" cellspacing="0" width="100%" class="table-items">
            <thead>
                <tr>
                    <th>TOTAL CANT. COMPRA</th>
                    <th>TOTAL CANT. SALIDA</th>
                    <th>TOTAL CANT. DISPONIBLE</th>
                    <th>TOTAL SALDO COMPRA</th>
                    <th>TOTAL SALDO SALIDA</th>
                    <th>TOTAL</th>
                </tr>
            </thead>
            <tbody>
                
                
                <tr>
                    <td align="center">{{$cantC}}</td>
                    <td align="center">{{$cantS}}</td>
                    <td align="center">{{$cantI}}</td>
                    <td align="center">${{number_format($totalC,2)}}</td>
                    <td align="center">${{number_format($totalS,2)}}</td>
                    <td align="center">${{number_format($totalI,2)}}</td>
                   
                </tr>
                
                
            </tbody>
            
        </table>
        @endif
    </section>
    
    <section class="footer">
        <table cellpadding="0" cellspacing="0" width="100%" class="table-items">
            <tr>
                <td width="20%"><span>Sistema de Inventarios 1.0</span></td>
                    <td width="60%" class="text-center">Reporte de Inventarios</td>
                    <td width="20%" class="text-center">Pagina <span class="pagenum"></span></td>
                    
            </tr>
        </table>
    </section>
</body>
</html>