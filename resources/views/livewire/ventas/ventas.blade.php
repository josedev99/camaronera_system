<div class="row sales layout-top-spacing">
    <div class="col-lg-12 col-12 col-sm-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4><b>{{ $componentName }} | {{ $pageTitle }}</b></h4>


                    </div>
                </div>


                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <a href="javascript:void(0)" class="btn btn-success btn-sm font-weight-bold mb-2" data-toggle="modal"
                        data-target="#theModal">Agregar</a>

                </div>




                @include('common.searchbox')

            </div>



            <div class="widget-content widget-content-area">

                <div class="table-responsive">
 
                    <table class="table table-bordered table-hover mb-4">
                        <thead style=" background: #f37f23">
                            <tr>
                                <th class="table-th text-center">ID</th>
                                <th class="table-th text-center">Factura</th>
                                <th class="table-th text-center">Libras</th>
                                <th class="table-th text-center">Total V</th>
                                <th class="table-th text-center">Estado</th>
                                <th class="table-th text-center">Acciones</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $i)
                                <tr>
                                    <td class="text-center">{{ $i->id }}</td>
                                    <td class="text-center">{{ $i->invoice }}</td>
                                    <td class="text-center">{{ $i->items }} LB</td>
                                    <td class="text-center">$ {{ number_format($i->total,2)}}</td>
                                    @if($i->status == 'PAID')
                                    <td class="text-center"><span  class="badge bg-success">Pagado</span ></td>
                                    @elseif($i->status == 'PENDING')
                                    <td class="text-center"><span  class="badge bg-warning text-dark">Pendiente</span ></td>
                                    
                                    @endif


                                    <td class="text-center p-1">

                                        <a href="javascript:void(0)" wire:click="Show({{ $i->id }})"
                                            class="btn btn-primary btn-sm font-weight-bold" title="Show"><i
                                                class="fas fa-eye mt-1"></i></a>
                                        <a href="javascript:void(0)" wire:click="Edit({{ $i->id }})"
                                            class="btn btn-primary btn-sm font-weight-bold" title="Editar"><i
                                                class="fas fa-edit mt-1"></i></a>






                                        <a href="javascript:void(0)" onclick="Confirm('{{ $i->id }}')"
                                            class="btn btn-danger btn-sm font-weight-bold" title="Eliminar"><i class="fas fa-trash mt-1"></i></a>


                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if(count($data))
                    {{ $data->links() }}
                    @endif

                </div>



            </div>
        </div>
    </div>

    @include('livewire.ventas.form')
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show');
        });
        window.livewire.on('category-add', msg => {
            $('#theModal').modal('hide');
            noty(msg);
        });

        window.livewire.on('category-update', msg => {
            $('#theModal').modal('hide');
        });

        window.livewire.on('category-delete', msg => {
            noty(msg, 2)
        });

        



    });



    function Confirm(id) {
        swal({
            title: 'Confirmar',
            text: 'Confirmas eliminar el registro?',
            type: 'warning',
            showCancelButton: true,
            cancelButtonText: 'CERRAR',
            cancelButtonColor: '#fff',
            confirmButtonColor: '#3b3f5c',
            confirmButtonText: 'ACEPTAR',
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('deleterow', id);
                swal.close();
            }
        });
    }
</script>
