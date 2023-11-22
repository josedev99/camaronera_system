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
                                    <button type="button" onclick="edit({{$row['id']}})" style="border: none !important" title="Editar producto" class="btn btn-outline-info btn-sm">
                                        <i class="fas fa-edit text-info" style="font-size: 18px"></i>
                                    </button>
                                    <button style="border: none !important" class="btn btn-outline-danger btn-sm" title="Eliminar producto" onclick="confirmDelete({{$row['id']}})">
                                        <i class="fas fa-trash text-danger" style="font-size: 18px"></i>
                                    </button>
                                </td>
                                    <!-- <td class="text-center p-1">
                                        <a href="#" class="btn btn-primary btn-sm font-weight-bold"><i
                                                class="fas fa-edit"></i> Editar</a>
                                        <a href="#" class="btn btn-danger btn-sm font-weight-bold"><i
                                                class="fas fa-trash"></i> Eliminar</a>
                                    </td> -->
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
        Livewire.emit('resetFormulario')
    }

    document.addEventListener('livewire:load', () => {
        Livewire.on('msg', (res) => {
            Swal.fire({
                title: "Exito",
                text: res,
                icon: "success"
            });
            $("#addEditProducts").modal('hide');
            window.location.href = window.location.origin + '/products';
        })
        Livewire.on('showModalEditar', (res)=>{
            $("#addEditProducts").modal('show');
        })
        Livewire.on('udp', (res)=>{
            Swal.fire({
                title: "Exito",
                text: res,
                icon: "success"
            });
            $("#addEditCompra").modal('hide');
            window.location.href = window.location.origin + '/products';
        })
    })
    document.addEventListener('livewire:load', ()=>{
        Livewire.on('eliminado', (res)=>{
            Swal.fire({
                title: "Exito",
                text: res,
                icon: "success"
            });
            window.location.href = window.location.origin + '/products';
        })
    })
    function confirmDelete(id){
        window.confirm('¿Desea eliminar esta compra?') ? Livewire.emit('destroy', id) : null;
        return false;
        //No funciona esto de abajo
        Swal.fire({
            title: "Desea eliminar la compra?",
            text: "Esta acción eliminara la compra de forma permanente!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si",
            cancelButtonText: "No",
            }).then((result) => {
            if (result.isConfirmed) {
                // Check for any errors
                console.log(result);
                Swal.fire({
                title: "Deleted!",
                text: "Your file has been deleted.",
                icon: "success"
                });
                Livewire.emit('destroy',id);
            }
            });
    }

    function edit(id){
        console.log(id)
        Livewire.emit('edit',id);
    }
</script>