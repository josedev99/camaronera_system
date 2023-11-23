<div class="row sales layout-top-spacing">
    <div class="col-lg-12 col-12 col-sm-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4 class="card-title text-center pt-3">
                            <b>Reportes Generales</b>
                        </h4>


                    </div>
                </div>
            </div>

            <div class="widget-content widget-content-area">
                @cannot(['report_consult', 'report_table'])
                    <div class="alert alert-danger mb-2" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg
                                xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg></button>
                        <strong>Atencion!</strong> Comunicarse con el Administrador para tener los todos los permisos de
                        esta seccion</button>
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
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('userid')
                                            <span class="text-danger er">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                @if ($reporType == 0 || $reporType == 2)
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Seleccione el Estanque</label>
                                            <select wire:model="pond" class="form-control">
                                                <option value="Estanque 1">Estanque 1</option>
                                                <option value="Estanque 2">Estanque 2</option>


                                            </select>
                                            @error('pond')
                                                <span class="text-danger er">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                @endif

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Seleccione el tipo de reporte</label>
                                        <select wire:model="reporType" class="form-control">
                                            <option value="0">Ventas del Dia</option>
                                            <option value="1">Compras del Dia</option>
                                            <option value="4">Abonos del Dia</option>
                                            <option value="2">Ventas por fecha</option>
                                            <option value="3">Compras por fecha</option>
                                            <option value="5">Abonos por fecha</option>


                                        </select>
                                        @error('reporType')
                                            <span class="text-danger er">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Fecha Inicial</label>
                                        <input type="date" class="form-control" wire:model.lazy="fromDate">
                                        @error('formDate')
                                            <span class="text-danger er">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Fecha Final</label>
                                        <input type="date" class="form-control" wire:model.lazy="toDate">
                                        @error('toDate')
                                            <span class="text-danger er">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                {{--  botones --}}
                                <div class="col-sm-12">
                                    <button class="btn btn-dark btn-block" wire:click.prevent="$refresh" type="button">
                                        Consultar
                                    </button>
                                    @if ($reporType == 0 || $reporType == 2)
                                        @can('pdf')
                                            <a href="{{ url('report/ventas_pdf' . '/' . $userid . '/' . $reporType . '/' . $pond . '/' . $fromDate . '/' . $toDate) }}"
                                                class="btn btn-dark btn-block 
                                                        @if (count($ventas) < 1) {{ 'disabled' }} @endif
                                                        "
                                                target="_blank">
                                                Generar PDF
                                            </a>
                                        @endcan
                                        @can('excel')
                                            <a href="{{ url('report/ventas_excel' . '/' . $userid . '/' . $reporType . '/' . $pond . '/' . $fromDate . '/' . $toDate) }}"
                                                class="btn btn-dark btn-block  
                                                        @if (count($ventas) < 1) {{ 'disabled' }} @endif
                                                        "
                                                target="_blank">

                                                Exportar a Excel
                                            </a>
                                        @endcan
                                        </button>
                                    @elseif($reporType == 4 || $reporType == 5)
                                        @can('pdf')
                                            <a href="{{ url('report/abonos_pdf' . '/' . $userid . '/' . $reporType . '/' . $fromDate . '/' . $toDate) }}"
                                                class="btn btn-dark btn-block 
                                                @if (count($abonos) < 1) {{ 'disabled' }} @endif
                                                "
                                                target="_blank">
                                                Generar PDF
                                            </a>
                                        @endcan
                                        @can('excel')
                                            <a href="{{ url('report/abonos_excel' . '/' . $userid . '/' . $reporType . '/' . $fromDate . '/' . $toDate) }}"
                                                class="btn btn-dark btn-block  
                                                @if (count($abonos) < 1) {{ 'disabled' }} @endif
                                                "
                                                target="_blank">

                                                Exportar a Excel
                                            </a>
                                        @endcan
                                    @else
                                        @can('pdf')
                                            <a href="{{ url('report/compras_pdf' . '/' . $userid . '/' . $reporType . '/' . $fromDate . '/' . $toDate) }}"
                                                class="btn btn-dark btn-block 
                                                        @if (count($compras) < 1) {{ 'disabled' }} @endif
                                                        "
                                                target="_blank">
                                                Generar PDF
                                            </a>
                                        @endcan
                                        @can('excel')
                                            <a href="{{ url('report/compras_excel' . '/' . $userid . '/' . $reporType . '/' . $fromDate . '/' . $toDate) }}"
                                                class="btn btn-dark btn-block  
                                                        @if (count($compras) < 1) {{ 'disabled' }} @endif
                                                        "
                                                target="_blank">

                                                Exportar a Excel
                                            </a>
                                        @endcan
                                    @endif

                                </div>
                            </div>

                        </div>
                    @endcan
                    {{-- tabla --}}

                    @can('report_table')
                        @if ($ventas)
                            <div class="col-sm-12 col-md-10">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped mt-1">
                                        <thead class="text-white" style="background:#f37f23 ;">
                                            <tr>
                                                <th class="table-th text-center">Factura</th>
                                                <th class="table-th text-center">Gramos</th>
                                                <th class="table-th text-center">Libras</th>
                                                <th class="table-th text-center">Total V</th>
                                                <th class="table-th text-center">Estanque</th>
                                                <th class="table-th text-center">Estado</th>
                                                <th class="table-th text-center">Usuario</th>
                                                <th class="table-th text-center">Fecha</th>

                                            </tr>
                                        </thead>
                                        <tbody>


                                            @if (count($ventas) < 1)
                                                <tr>
                                                    <td colspan="8">
                                                        <h6 class="text-center">Sin resultados</h6>
                                                    </td>
                                                </tr>
                                            @endif

                                            @foreach ($ventas as $d)
                                                <tr>
                                                    <td class="text-center">
                                                        <h6>{{ $d->invoice }}</h6>
                                                    </td>
                                                    <td class="text-center">
                                                        <h6>{{ $d->grams }} g</h6>
                                                    </td>
                                                    <td class="text-center">
                                                        <h6>{{ $d->items }} LB</h6>
                                                    </td>
                                                    <td class="text-center">
                                                        <h6>${{ number_format($d->total, 2) }}</h6>
                                                    </td>

                                                    <td class="text-center">
                                                        <h6>{{ $d->pond }}</h6>
                                                    </td>
                                                    @if ($d->status == 'PAID')
                                                        <td class="text-center"><span
                                                                class="badge bg-success">Pagado</span>
                                                        </td>
                                                    @else
                                                        <td class="text-center"><span
                                                                class="badge bg-warning text-dark">Pendiente</span></td>
                                                    @endif
                                                    <td class="text-center">
                                                        <h6>{{ $d->usuario }}</h6>
                                                    </td>

                                                    <td class="text-center">
                                                        <h6>
                                                            {{ Carbon\Carbon::parse($d->created_at)->format('d-m-Y') }}

                                                        </h6>
                                                    </td>



                                                </tr>
                                            @endforeach

                                        </tbody>



                                    </table>


                                </div>


                            </div>
                        @endif

                        @if ($compras)
                            <div class="col-sm-12 col-md-10">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped mt-1">
                                        <thead class="text-white" style="background:#f37f23 ;">
                                            <tr>
                                                <th class="table-th text-center">Producto</th>
                                                <th class="table-th text-center">Precio U.</th>
                                                <th class="table-th text-center">Cantidad</th>
                                                <th class="table-th text-center">Monto</th>
                                                <th class="table-th text-center">Tipo de P</th>
                                                <th class="table-th text-center">Usuario</th>
                                                <th class="table-th text-center">Fecha</th>

                                            </tr>
                                        </thead>
                                        <tbody>


                                            @if (count($compras) < 1)
                                                <tr>
                                                    <td colspan="7">
                                                        <h6 class="text-center">Sin resultados</h6>
                                                    </td>
                                                </tr>
                                            @endif

                                            @foreach ($compras as $d)
                                                <tr>
                                                    <td class="text-center">
                                                        <h6>{{ $d->producto }}</h6>
                                                    </td>
                                                    <td class="text-center">
                                                        <h6>{{ $d->precioUnit }}</h6>
                                                    </td>
                                                    <td class="text-center">
                                                        <h6>{{ $d->cantidad }}</h6>
                                                    </td>
                                                    <td class="text-center">
                                                        <h6>${{ number_format($d->monto, 2) }}</h6>
                                                    </td>

                                                    <td class="text-center">
                                                        <h6>{{ $d->tipo_pago }}</h6>
                                                    </td>

                                                    <td class="text-center">
                                                        <h6>{{ $d->usuario }}</h6>
                                                    </td>

                                                    <td class="text-center">
                                                        <h6>
                                                            {{ Carbon\Carbon::parse($d->created_at)->format('d-m-Y') }}

                                                        </h6>
                                                    </td>



                                                </tr>
                                            @endforeach

                                        </tbody>



                                    </table>


                                </div>


                            </div>
                        @endif

                        @if ($abonos)
                            <div class="col-sm-12 col-md-10">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped mt-1">
                                        <thead class="text-white" style="background:#f37f23 ;">
                                            <tr>

                                                <th class="table-th text-center">Factura</th>
                                                <th class="table-th text-center">Cliente</th>
                                                <th class="table-th text-center">Tipo</th>
                                                <th class="table-th text-center">Abono</th>
                                                <th class="table-th text-center">Saldo</th>
                                                <th class="table-th text-center">Usuario</th>
                                                <th class="table-th text-center">Fecha</th>

                                            </tr>
                                        </thead>
                                        <tbody>


                                            @if (count($abonos) < 1)
                                                <tr>
                                                    <td colspan="7">
                                                        <h6 class="text-center">Sin resultados</h6>
                                                    </td>
                                                </tr>
                                            @endif

                                            @foreach ($abonos as $d)
                                                <tr>
                                                    <td class="text-center">
                                                        <h6>{{ $d->numero_recibo }}</h6>
                                                    </td>
                                                    <td class="text-center">
                                                        <h6>{{ $d->cliente }}</h6>
                                                    </td>
                                                    <td class="text-center">
                                                        <h6>{{ $d->tipo_pago }}</h6>
                                                    </td>
                                                    <td class="text-center">
                                                        <h6>${{ number_format($d->monto_abono, 2) }}</h6>
                                                    </td>
                                                    <td class="text-center">
                                                        <h6>${{ number_format($d->saldo, 2) }}</h6>
                                                    </td>

                                                    <td class="text-center">
                                                        <h6>{{ $d->usuario }}</h6>
                                                    </td>

                                                    <td class="text-center">
                                                        <h6>{{ $d->fecha }}</h6>
                                                    </td>





                                                </tr>
                                            @endforeach

                                        </tbody>



                                    </table>


                                </div>


                            </div>
                        @endif
                    @endcan









                </div>







            </div>
        </div>
    </div>


</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show');
        });




    });
</script>
