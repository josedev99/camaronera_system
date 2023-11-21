@include('livewire.products.form')
<div>
    <div class="row sales layout-top-spacing">
        <div class="col-lg-12 col-md-12 col-sm-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header p-1">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12 mt-3">
                            <h3 class="p-0 mb-2"><i class="fas fa-box h3"></i> Gestionar Productos</h3>
                        </div>
                    </div>
                    <button onclick="openModalP()" class="btn btn-success btn-sm font-weight-bold">
                        <i class="fas fa-plus-circle text-white"></i> Nuevo
                    </button>
                </div>
                <div class="widget-content widget-content-area">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-4">
                            <thead style="background: #f37f23">
                                <tr>
                                    <th class="text-center text-white p-1">#</th>
                                    <th class="text-center text-white p-1">Nombre</th>
                                    <th class="text-center text-white p-1">Descripción</th>
                                    <th class="text-center text-white p-1">Unidad de medida</th>
                                    <th class="text-center text-white p-1">Categoria</th>
                                    <th class="text-center text-white p-1">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($registros as $row)
                                <tr>
                                    <td class="text-center p-1">{{$row['id']}}</td>
                                    <td class="text-center p-1">{{$row['nombre']}}</td>
                                    <td class="text-center p-1">{{$row['descripcion']}}</td>
                                    <td class="text-center p-1">{{$row['unidad_medida']}}</td>
                                    <td class="text-center p-1">{{$row['category_id']}}</td>
                                    <td class="text-center p-1">
                                        <a href="#" class="btn btn-primary btn-sm font-weight-bold"><i
                                                class="fas fa-edit"></i> Editar</a>
                                        <a href="#" class="btn btn-danger btn-sm font-weight-bold"><i
                                                class="fas fa-trash"></i> Eliminar</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    //Abrir modal
    function openModalP() {
        $("#addEditProducts").modal('show');
    }

    document.addEventListener('livewire:load', () => {
        Livewire.on('msg', (res) => {
            Swal.fire({
                title: "Exito",
                text: res,
                icon: "success"
            });
            $("#addEditProducts").modal('hide');
        })
    })
</script>