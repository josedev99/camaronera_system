<div class="row sales layout-top-spacing">
    <div class="col-lg-12 col-12 col-sm-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4><b>{{ $componentName }} | {{ $pageTitle }}</b></h4>


                    </div>
                </div> 

                @can('category_create')
                    <div class="col-sm-12 col-md-12 d-flex justify-content-end">
                        <a href="javascript:void(0)"  class="btn btn-success btn-sm font-weight-bold mb-2" data-toggle="modal"
                            data-target="#theModal">Agregar</a>

                    </div>
                @endcan


                @can('category_search')
                    @include('common.searchbox')
                @endcan
            </div>



            <div class="widget-content widget-content-area">
                @cannot(['category_edit', 'category_destroy', 'category_search', 'category_create'])
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
                <div class="table-responsive">

                    <table class="table table-bordered table-hover mb-4">
                        <thead style=" background: #f37f23">
                            <tr>
                                <th class="table-th text-center">Nombre</th>
                                <th class="table-th text-center">DUI</th>
                                <th class="table-th text-center">TELEFONO</th>
                                <th class="table-th text-center">EMAIL</th>
                                <th class="table-th text-center">DIRECCION</th>
                                @if (auth()->user()->can('category_edit') ||
                                        auth()->user()->can('category_destroy'))
                                    <th class="table-th text-center">Acciones</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr>
                                    <td class="text-center">{{ $customer->name }}</td>
                                    <td class="text-center">{{ $customer->nit}}</td>
                                    <td class="text-center">{{ $customer->phone }}</td>
                                    <td class="text-center">{{ $customer->email }}</td>
                                    <td class="text-center">{{ $customer->address }}</td>

                                    @if (auth()->user()->can('category_edit') ||
                                            auth()->user()->can('category_destroy'))
                                        <td class="text-center">
                                            @can('category_edit')
                                                <a href="javascript:void(0)" wire:click="Edit({{ $customer->id }})"
                                                    style="border: none !important" class="btn btn-outline-info btn-sm" title="Editar"><i
                                                        class="fas fa-edit mt-1"></i></a>
                                            @endcan


                                            @can('category_destroy')
                                                @if ($customer->sales->count() < 1)
                                                    <a href="javascript:void(0)" onclick="Confirm('{{ $customer->id }}')"
                                                        style="border: none !important" class="btn btn-outline-danger btn-sm" title="Eliminar"><i
                                                            class="fas fa-trash mt-1"></i></a>
                                                @endif
                                            @endcan

                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $customers->links() }}

                </div>



            </div>
        </div>
    </div>

    @include('livewire.customers.form')
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show');
        });
        window.livewire.on('customer-add', msg => {
            $('#theModal').modal('hide');
            noty(msg);
        });

        window.livewire.on('customer-update', msg => {
            $('#theModal').modal('hide');
            noty(msg);
        });
        window.livewire.on('customer-delete', msg => {
            noty(msg, 2);
        });



    });

    @can('category_destroy')

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
    @endcan
</script>
