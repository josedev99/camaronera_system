<div class="row sales layout-top-spacing">
    <div class="col-lg-12 col-12 col-sm-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4><b>{{ $componentName }} | {{ $pageTitle }}</b></h4>


                    </div>
                </div>
                @can('denomination_create')
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <a href="javascript:void(0)" class="btn btn-primary btn-rounded mb-2" data-toggle="modal"
                            data-target="#theModal">Agregar</a>

                    </div>
                @endcan

                @can('denomination_search')
                    @include('common.searchbox')
                @endcan
            </div>



            <div class="widget-content widget-content-area">
                @cannot(['denomination_edit', 'denomination_destroy', 'denomination_search', 'denomination_create'])
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
                                <th class="table-th text-center">Valor</th>
                                <th class="table-th text-center">Imagen</th>
                                @if (auth()->user()->can('denomination_edit') ||
                                        auth()->user()->can('denomination_destroy'))
                                    <th class="table-th text-center">Acciones</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($denominations as $denomination)
                                <tr>
                                    <td class="text-center">{{ $denomination->type }}</td>
                                    <td class="text-center">{{ $denomination->value }}</td>
                                    <td class="text-center"><span>
                                            <img src="{{ asset('storage/denominations/' . $denomination->image) }}"
                                                alt="Ejemplo" height="70" width="80" class="rounded">
                                        </span></td>

                                    @if (auth()->user()->can('denomination_edit') ||
                                            auth()->user()->can('denomination_destroy'))
                                        <td class="text-center">
                                            @can('denomination_edit')
                                                <a href="javascript:void(0)" wire:click="Edit({{ $denomination->id }})"
                                                    class="btn btn-dark mtmobile" title="Editar"><i
                                                        class="fas fa-edit mt-1"></i></a>
                                            @endcan
                                            @can('denomination_destroy')
                                                <a href="javascript:void(0)" onclick="Confirm('{{ $denomination->id }}')"
                                                    class="btn btn-dark" title="Eliminar"><i
                                                        class="fas fa-trash mt-1"></i></a>
                                            @endcan


                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $denominations->links() }}

                </div>



            </div>
        </div>
    </div>

    @include('livewire.denominations.form')
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show');
        });
        window.livewire.on('denomination-add', msg => {
            $('#theModal').modal('hide');
        });

        window.livewire.on('denomination-update', msg => {
            $('#theModal').modal('hide');
        });



    });

    @can('denomination_destroy')

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
