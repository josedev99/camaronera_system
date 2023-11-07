<div class="row sales layout-top-spacing">
    <div class="col-lg-12 col-12 col-sm-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4><b>{{ $componentName }}</b></h4>


                    </div>
                </div>


            </div>


            <div class="widget-content widget-content-area">
                @can('assign_form')
                    <div class="form-inline">
                        <div class="form-group mr-5">
                            <select wire:model.prevent="role" class="form-control">
                                <option value="Elegir" selected>Seleccionar Role</option>
                                @foreach ($roles as $rol)
                                    <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button wire:click.prevent="SyncAll()" class="btn btn-dark mbmobile inblock mr-5">Sincronizar
                            todos</button>
                        <button onclick="Revocar()" class="btn btn-dark mbmobile  mr-5">Revocar todos</button>
                    </div>
                @endcan

                @cannot(['assign_form', 'assign_table'])
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


                <div class="row mt-3">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            @can('assign_table')
                                <table class="table table-bordered table-hover mb-4">
                                    <thead style=" background: #BDBDBD">
                                        <tr>
                                            <th class="table-th text-center">ID</th>
                                            <th class="table-th text-center">Permiso</th>
                                            <th class="table-th text-center">Roles con el Permiso</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($permissions as $permission)
                                            <tr>
                                                <td class="text-center">{{ $permission->id }}</td>
                                                <td class="text-center">
                                                    <div class="n-check">
                                                        <label class="new-control new-checkbox checkbox-primary">
                                                            <input type="checkbox"
                                                                wire:change="SyncPermiso($('#p' + {{ $permission->id }}).is(':checked'), '{{ $permission->name }}')"
                                                                id="p{{ $permission->id }}" value="{{ $permission->id }}"
                                                                class="new-control-input"
                                                                {{ $permission->checked == 1 ? 'checked' : '' }}>
                                                            <span class="new-control-indicator">
                                                                <h6>{{ $permission->name }}</h6>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </td>

                                                <td class="text-center">
                                                    <h6>

                                                        {{ \App\Models\User::permission($permission->name)->count() }}
                                                    </h6>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $permissions->links() }}

                            </div>
                        </div>
                    </div>
                @endcan



            </div>
        </div>
    </div>


</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('sync-error', msg => {
            noty(msg, 2);
        });
        window.livewire.on('permi', msg => {
            noty(msg);
        });
        window.livewire.on('syncall', msg => {
            noty(msg);
        });
        window.livewire.on('remove-all', msg => {
            noty(msg);
        });





    });

    function Revocar() {
        swal({
            title: 'Confirmar',
            text: 'Confirmas revocar todos los permisos?',
            type: 'warning',
            showCancelButton: true,
            cancelButtonText: 'CERRAR',
            cancelButtonColor: '#fff',
            confirmButtonColor: '#3b3f5c',
            confirmButtonText: 'ACEPTAR',
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('revokeall');
                swal.close();
            }
        });
    }
</script>
