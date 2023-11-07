

<div class="row sales layout-top-spacing">
<div class="col-lg-12 col-12 col-sm-12 layout-spacing">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-header">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                           <h4 class="card-title text-center pt-3">
                                                <b>Reportes de Inventarios</b>
                                            </h4>

                                           
                                        </div>            
                                    </div>    
                                </div>
                                
                                <div class="widget-content widget-content-area">
                                    @cannot(['report_consult', 'report_table'])
                                            <div class="alert alert-danger mb-2" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                                <strong>Atencion!</strong> Comunicarse con el Administrador para tener los todos los permisos de esta seccion</button>
                                            </div>
                                    @endcannot
                                        <div class="row">
                                            @can('report_consult')
                                            {{-- inputs --}}
                                            <div class="col-sm-12 col-md-2">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Seleccione el Usuario</label>
                                                            <select wire:model="userid" class="form-control">
                                                                <option value="0">Todos</option>
                                                                @foreach($users as $user)
                                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('userid') <span class="text-danger er">{{$message}}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Seleccione el producto</label>
                                                            <select wire:model="product" class="form-control">
                                                                <option value="0" {{$reporType == 2 ? 'disabled' : ''}}>Todos</option>
                                                                @foreach($products as $produc)
                                                                <option value="{{$produc->id}}">{{$produc->name}}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('product') <span class="text-danger er">{{$message}}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Seleccione el tipo de reporte</label>
                                                            <select wire:model="reporType" class="form-control">
                                                                <option value="0">Movimientos del Dia</option>
                                                                <option value="1">Movimientos por fecha</option>
                                                                <option value="2" {{$product == 0 ? 'disabled' : ''}}>Movimientos desde el inicio</option>
                                                                
                                                            </select>
                                                            @error('reporType') <span class="text-danger er">{{$message}}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Fecha Inicial</label>
                                                            <input type="text" class="form-control flatpickr" wire:model.lazy="fromDate">
                                                            @error('formDate') <span class="text-danger er">{{$message}}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Fecha Final</label>
                                                            <input type="text" class="form-control flatpickr" wire:model.lazy="toDate">
                                                            @error('toDate') <span class="text-danger er">{{$message}}</span> @enderror
                                                        </div>
                                                    </div>
                                                        {{--  botones --}}
                                                    <div class="col-sm-12">
                                                        <button class="btn btn-dark btn-block" wire:click.prevent="$refresh" type="button">
                                                            Consultar
                                                        </button>

                                                        @can('pdf')
                                                        <a href="{{url('report/pdf' . '/' . $userid . '/' . $reporType . '/'. $product. '/' . $fromDate . '/'. $toDate)}}" class="btn btn-dark btn-block {{count($data) < 1 ? 'disabled' : ''}}
                                                        @if($toDate == '' && $reporType == 1)
                                                            {{'disabled'}}
                                                            @endif
                                                        " target="_blank">
                                                        Generar PDF
                                                        </a>
                                                        @endcan
                                                        @can('excel')
                                                        <a href="{{url('report/excel' . '/' . $userid . '/' . $reporType . '/'. $product. '/' . $fromDate . '/'. $toDate)}}" class="btn btn-dark btn-block {{count($data) < 1 ? 'disabled' : ''}} 
                                                        @if($toDate == '' && $reporType == 1)
                                                            {{'disabled'}}
                                                            @endif
                                                        " target="_blank">
                                                            
                                                        Exportar a Excel
                                                        </a>
                                                        @endcan

                                                    </div>
                                                </div>
                                                    
                                            </div>
                                            @endcan
                                            {{-- tabla --}}

                                            @can('report_table')
                                            <div class="col-sm-12 col-md-10">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped mt-1" >
                                                        <thead class="text-white" style="background:#3B3F5C ;">
                                                            <tr>
                                                                <th class="table-th text-center text-white">Folio</th>
                                                                <th class="table-th text-center text-white">Tipo</th>
                                                                <th class="table-th text-center text-white">Cant</th>
                                                                <th class="table-th text-center text-white">Precio U</th>
                                                                <th class="table-th text-center text-white">Promedio</th>
                                                                <th class="table-th text-center text-white">Total Cant</th>
                                                                <th class="table-th text-center text-white">Total Mov.</th>
                                                                <th class="table-th text-center text-white">Producto</th>
                                                                <th class="table-th text-center text-white">Usuario</th>
                                                                <th class="table-th text-center text-white">Fecha</th>
                                                                
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                           
                                                            @if(count($data) < 1)
                                                                <tr><td colspan="10"><h6 class="text-center">Sin resultados</h6></td></tr>
                                                            @endif
    
                                                                @foreach($data as $d)
                                                                <tr>
                                                                <td class="text-center"><h6>{{$d->id}}</h6></td>
                                                                <td class="text-center"><h6>{{$d->type}}</h6></td>
                                                                <td class="text-center"><h6>{{$d->quantity}}</h6></td>
                                                                <td class="text-center"><h6>${{$d->priceu}}</h6></td>
                                                                <td class="text-center"><h6>${{number_format($d->price,2)}}</h6></td>
                                                                <td class="text-center"><h6>{{$d->available}}</h6></td>
                                                                <td class="text-center"><h6>${{$d->total}}</h6></td>
                                                                <td class="text-center"><h6>{{$d->product}}</h6></td>
                                                                <td class="text-center"><h6>{{$d->user}}</h6></td>
                                                                <td class="text-center"><h6>
                                                                {{Carbon\Carbon::parse($d->created_at)->format('d-m-Y')}}
                                                                
                                                                </h6></td>

                                                                
                                                                </tr>
                                                                @endforeach
                                                            
                                                        </tbody>

                                                        
                                                        
                                                    </table>
                                                    <table class="table table-bordered table-striped mt-1" >
                                                        

                                                        @if($cantC > 0 && $totalC > 0)
                                                        <thead class="text-white" style="background:#3B3F5C ;">
                                                            <tr>
                                                                <th class="table-th text-center text-white">Total Cant. Compra</th>
                                                                <th class="table-th text-center text-white">Total Cant. Salida</th>
                                                                <th class="table-th text-center text-white">Total Disponible</th>
                                                                <th class="table-th text-center text-white" colspan="2">Total Saldo Compra</th>
                                                                <th class="table-th text-center text-white" colspan="2">Total Saldo Salida</th>
                                                                <th class="table-th text-center text-white" colspan="3">Total</th>
                                                                
                                                                
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                           
                                                            
    
                                                                
                                                                <tr>
                                                                <td class="text-center"><h6>{{$cantC}}</h6></td>
                                                                <td class="text-center"><h6>{{$cantS}}</h6></td>
                                                                <td class="text-center"><h6>{{$cantI}}</h6></td>
                                                                <td class="text-center" colspan="2"><h6>${{$totalC}}</h6></td>
                                                                <td class="text-center" colspan="2"><h6>${{$totalS}}</h6></td>
                                                                <td class="text-center" colspan="3"><h6>${{$totalI}}</h6></td>
                                                                

                                                                
                                                                </tr>
                                                                
                                                            
                                                        </tbody>
                                                        @endif
                                                        
                                                    </table>
                                                    
                                            </div>

                                                    
                                            </div>
                                            @endcan


                                            
                                            

                                            


                                        </div>

                                       



                                    

                                </div>
                            </div>
                        </div>
                       
                        
                        </div>


<script>
    document.addEventListener('DOMContentLoaded', function(){
        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show');
        });



        
    });
</script>                        

