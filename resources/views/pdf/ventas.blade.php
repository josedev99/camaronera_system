<!DOCTYPE html>
<html lang="es">
<head> 
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de ventas</title>
    <link href="{{public_path('css/custom.css')}}" rel="stylesheet" type="text/css" />
    
    <link href="{{public_path('css/custom_pdf.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{public_path('css/custom_page.css')}}" rel="stylesheet" type="text/css" />
</head>
<body>
    <section class="header" style="top:-287px;">
        <table cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td colspan="2" class="text-center">
                    <span style="font-size: 25px; font-weight:bold;">Sistema de ACOOAMAR de R.L.</span>
                </td>
            </tr>
            <tr>
                <td width="30%" style="vertical-align:top; padding-top:10px; position:relative;">
                    <img src="{{public_path('assets/img/empresa.png')}}" alt="" class="invoice-logo">
                </td>

                <td width="70%" class="text-left text-company" style="vertical-align: top; padding-top: 10px;">
                    
                    @if($reporType == 0)
                    <span style="font-size: 16px;"><strong>Reportes de ventas del dia</strong></span>
                    @else
                    <span style="font-size: 16px;"><strong>Reportes de ventas por fechas</strong></span>
                    @endif
                    <br>
                    @if($reporType != 0)
                    <span style="font-size: 16px;"><strong>Fecha de Consulta: {{\Carbon\Carbon::parse($dateFrom)->format('d-m-Y')}} al {{\Carbon\Carbon::parse($dateTo)->format('d-m-Y')}}</strong></span>
                    @else
                    <span style="font-size: 16px;"><strong>Fecha de Consulta: {{\Carbon\Carbon::now()->format('d-m-Y')}}</strong></span>
                    @endif
                    <br>
                    <span style="font-size: 14px;">Usuario: {{$user}}</span>
                    
                </td>
            </tr>
        </table>
    </section>

    <section style="margin-top: -110px;">
        <table cellpadding="0" cellspacing="0" width="100%" class="table-items">
            <thead>
                <tr>
                    <th>FACTURA</th>
                    <th>TIPO F.</th>
                    <th>CLIENTE</th>
                    <th>GRAMOS</th>
                    <th>LIBRAS</th>
                    <th>TOTAL</th>
                    <th>IVA</th>
                    <th>ESTANQUE</th>
                    <th>METODO</th>
                    <th>ESTADO</th>
                    <th>FECHA</th>
                </tr>
            </thead>
            <tbody>
                
                @foreach($data as $item)
                <tr>
                    <td align="center">{{$item->invoice}}</td>
                    <td align="center">{{$item->type_invoice}}</td>
                    <td align="center">{{$item->customer}}</td>
                    <td align="center">{{$item->grams}} g.</td>
                    <td align="center">{{$item->items}} LB.</td>
                    <td align="center">${{number_format($item->total,2)}}</td>
                    <td align="center">${{number_format($item->iva,2)}}</td>
                    <td align="center">{{$item->pond}}</td>
                    <td align="center">{{$item->pay}}</td>
                    @if($item->status == 'PAID')
                    <td align="center">PAGADO</td>
                    @else
                    <td align="center">PENDIENTE</td>
                    @endif
                    <td align="center">{{\Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i:s')}}</td>
                </tr>
                @endforeach
                
            </tbody>
            
        </table>
        
    </section>
    
    <section class="footer">
        <table cellpadding="0" cellspacing="0" width="100%" class="table-items">
            <tr>
                <td width="20%"><span>Sistema de ACOOAMAR de R.L. 1.0</span></td>
                    <td width="60%" class="text-center">Reporte de ventas</td>
                    <td width="20%" class="text-center">Pagina <span class="pagenum"></span></td>
                    
            </tr>
        </table>
    </section>
</body>
</html>