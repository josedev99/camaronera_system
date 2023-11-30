

<div class="row sales layout-top-spacing">
<div class="col-lg-12 col-12 col-sm-12 layout-spacing">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-header">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                           <h4 class="card-title text-center pt-3">
                                                <b>Corte de Caja</b>
                                            </h4>

                                           
                                        </div>            
                                    </div>    
                                </div>
                                
                                <div class="widget-content widget-content-area">
                                @can('cashout_form')
                                            <div class="row">
                                            <div class="col-sm-12 col-md-3">
                                                <div class="form-group">
                                                    <label>Usuario</label>
                                                    <select wire:model="userid" class="form-control">
                                                        <option value="0" disabled>Elegir</option>
                                                        @foreach($users as $user)
                                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('userid') <span class="text-danger er">{{$message}}</span> @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-3">
                                                <div class="form-group">
                                                    <label>Fecha Inicial</label>
                                                    <input type="date" class="form-control" wire:model.lazy="fromDate">
                                                    @error('formDate') <span class="text-danger er">{{$message}}</span> @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-3">
                                                <div class="form-group">
                                                    <label>Fecha Final</label>
                                                    <input type="date" class="form-control" wire:model.lazy="toDate">
                                                    @error('toDate') <span class="text-danger er">{{$message}}</span> @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-3 align-self-center d-flex justify-content-around">
                                                @if($userid > 0 && $fromDate !=null && $toDate !=null)
                                                <button style="border: none !important" class="btn btn-outline-danger btn-sm" wire:click.prevent="Consultar" type="button">
                                                    Consultar
                                                </button>
                                                @endif
                                                @if($total > 0)
                                                <button style="border: none !important" class="btn btn-outline-danger btn-sm" wire:click.prevent="Print()" type="button">
                                                    Imprimir
                                                </button>
                                                @endif
                                            </div>
                                        </div>
                                        @endcan
                                        @cannot(['cashout_form', 'cashout_table'])
                                        <div class="alert alert-danger mb-2" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                            <strong>Atencion!</strong> Comunicarse con el Administrador para tener los todos los permisos de esta seccion</button>
                                        </div>
                                        @endcannot


                                        @can('cashout_table')
                                        <div class="row mt-5">
                                            <div class="col-sm-12 col-md-4 mbmoobile">
                                                <div class="connect-sorting bg-dark">
                                                    <h5 class="text-white">Ventas Totales: $ {{number_format($total,2)}}</h5>
                                                    <h5 class="text-white">Articulos: {{$items}}</h5>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-8">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped mt-1" >
                                                        <thead class="text-white" style="background:#3B3F5C ;">
                                                            <tr>
                                                                <th class="table-th text-center text-white">Folio</th>
                                                                <th class="table-th text-center text-white">Total</th>
                                                                <th class="table-th text-center text-white">Items</th>
                                                                <th class="table-th text-center text-white">Fecha</th>
                                                                <th class="table-th text-center text-white"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            @if($total <=0)
                                                            <tr><td colspan="5"><h6 class="text-center">No hay ventas en la fecha seleccionada</h6></td></tr>
                                                            @endif

                                                            @foreach($sales as $sale)
                                                            <tr>
                                                            <td class="text-center"><h6>{{$sale->id}}</h6></td>
                                                            <td class="text-center"><h6>$ {{number_format($sale->total,2)}}</h6></td>
                                                            <td class="text-center"><h6>{{$sale->items}}</h6></td>
                                                            <td class="text-center"><h6>{{$sale->created_at}}</h6></td>
                                                            <td class="text-center">
                                                                <button class="btn btn-dark btn-sm" wire:click.prevent="viewDetails({{$sale}})" type="button">
                                                                <i class="fas fa-list"></i>
                                                                </button>
                                                            </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                        
                                                    </table>

                                            
                                                </div>
                                            </div>
                                        </div>
                                        @endcan



                                    

                                </div>
                            </div>
                        </div>

                        @include('livewire.cashout.modaldetails')
                        </div>






<script>
    document.addEventListener('DOMContentLoaded', function(){
        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show');
        });



        
    });
</script>