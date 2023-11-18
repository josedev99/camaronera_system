@include('livewire.compras.modal.addEdit')
<div>
    <div class="row sales layout-top-spacing">
        <div class="col-lg-12 col-12 col-sm-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header p-1">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4 class="p-0 mb-2"><b>Gestionar compras</b></h4>
                        </div>
                    </div>
                    <button onclick="openModal()" class="btn btn-outline-success btn-sm">Nueva compra</button>
                </div>
                <div class="widget-content widget-content-area">
                    <table class="table table-bordered table-hover mb-4">
                        <thead style=" background: #f37f23">
                            <tr>
                                <th class="text-center text-white p-1">#</th>
                                <th class="text-center text-white p-1">Proveedor</th>
                                <th class="text-center text-white p-1">Descripción</th>
                                <th class="text-center text-white p-1">Monto</th>
                                <th class="text-center text-white p-1">Tipo pago</th>
                                <th class="text-center text-white p-1">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($registros as $row)
                            <tr>
                                <td class="text-center p-1">{{$row['id']}}</td>
                                <td class="text-center p-1">{{$row['nombre_proveedor']}}</td>
                                <td class="text-center p-1">{{$row['descripcion']}}</td>
                                <td class="text-center p-1">{{$row['monto']}}</td>
                                <td class="text-center p-1">{{$row['tipo_pago']}}</td>
                                <td class="text-center p-1">
                                    <i title="Editar compra" class="fas fa-edit text-info" style="font-size: 18px"></i>
                                    <i title="Eliminar compra" class="fas fa-trash text-danger" style="font-size: 18px"></i>
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

<script>
    //Abrir modal
    function openModal(){
        $("#addEditCompra").modal('show');
    }
    /* document.addEventListener('livewire:load', function () {
        setInterval(function () {
            @this.call('cargarRegistros'); // Llama al método cargarRegistros cada 10 segundos
        }, 10000);
    }); */
    document.addEventListener('livewire:load', ()=>{
        Livewire.on('msg', (res)=>{
            Swal.fire({
                title: "Exito",
                text: res,
                icon: "success"
            });
            $("#addEditCompra").modal('hide');
        })
    })
</script>
    
    