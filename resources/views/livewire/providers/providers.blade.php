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
                        <a href="javascript:void(0)" class="btn btn-primary btn-rounded mb-2" data-toggle="modal"
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
                        <thead style=" background: #BDBDBD">
                            <tr>
                                <th class="table-th text-center">Nombre</th>
                                <th class="table-th text-center">NIT</th>
                                <th class="table-th text-center">CONTACTO</th>
                                <th class="table-th text-center">TELEFONO</th>
                                <th class="table-th text-center">EMAIL</th>
                                <th width="14%" class="table-th text-center">DIRECCION</th>
                                @if (auth()->user()->can('category_edit') ||
                                        auth()->user()->can('category_destroy'))
                                    <th class="table-th text-center">Acciones</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($providers as $provider)
                                <tr>
                                    <td class="text-center">{{ $provider->name }}</td>
                                    <td class="text-center">{{ $provider->nit}}</td>
                                    <td class="text-center">{{ $provider->contact }}</td>
                                    <td class="text-center">{{ $provider->phone }}</td>
                                    <td class="text-center">{{ $provider->email }}</td>
                                    <td class="text-center">{{ $provider->address }}</td>

                                    @if (auth()->user()->can('category_edit') ||
                                            auth()->user()->can('category_destroy'))
                                        <td class="text-center">
                                            @can('category_edit')
                                                <a href="javascript:void(0)" wire:click="Edit({{ $provider->id }})"
                                                    class="btn btn-dark mtmobile m-1" title="Editar"><i
                                                        class="fas fa-edit mt-1"></i></a>
                                            @endcan


                                            @can('category_destroy')
                                                @if ($provider->purchases->count() < 1)
                                                    <a href="javascript:void(0)" onclick="Confirm('{{ $provider->id }}')"
                                                        class="btn btn-dark m-1" title="Eliminar"><i
                                                            class="fas fa-trash mt-1"></i></a>
                                                @endif
                                            @endcan

                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $providers->links() }}

                </div>



            </div>
        </div>
    </div>

    @include('livewire.providers.form')
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show');
        });
        window.livewire.on('provider-add', msg => {
            $('#theModal').modal('hide');
            noty(msg);
        });

        window.livewire.on('provider-update', msg => {
            $('#theModal').modal('hide');
            noty(msg);
        });
        window.livewire.on('provider-delete', msg => {
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
