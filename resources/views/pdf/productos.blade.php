<!DOCTYPE html>
<html lang="es">
<head> 
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de productos</title>
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
                    
                    
                    <span style="font-size: 16px;"><strong>Reportes de productos hasta la fecha</strong></span>
                    
                    <br>
                   
                    <span style="font-size: 16px;"><strong>Fecha de Consulta: {{\Carbon\Carbon::now()->format('d-m-Y')}}</strong></span>
                    
                    <br>
                    
                    
                </td>
            </tr>
        </table>
    </section>

    <section style="margin-top: -110px;">
        <table cellpadding="0" cellspacing="0" width="100%" class="table-items">
            <thead>
                <tr>
                    <th>NOMBRE</th>
                    <th>DESCRIPCION</th>
                    <th>UNIDAD DE MEDIDA</th>
                    
                </tr>
            </thead>
            <tbody>
                
                @foreach($data as $item)
                <tr>
                    <td align="center">{{$item->nombre}}</td>
                    <td align="center">{{$item->descripcion}}</td>
                    <td align="center">{{$item->unidad_medida}}</td>
                </tr>
                @endforeach
                
            </tbody>
            
        </table>
        
    </section>
    
    <section class="footer">
        <table cellpadding="0" cellspacing="0" width="100%" class="table-items">
            <tr>
                <td width="20%"><span>Sistema de ACOOAMAR de R.L. 1.0</span></td>
                    <td width="60%" class="text-center">Reporte de productos</td>
                    <td width="20%" class="text-center">Pagina <span class="pagenum"></span></td>
                    
            </tr>
        </table>
    </section>
</body>
</html>