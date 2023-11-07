<div class="row sales layout-top-spacing">
    <div class="col-lg-12 col-12 col-sm-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4><b>{{ $componentName }} | {{ $pageTitle }}</b></h4>


                    </div>
                </div>
                @can('product_create')
                    <div class="col-sm-12 col-md-12 d-flex justify-content-end">
                        <a href="javascript:void(0)" class="btn btn-primary btn-rounded mb-2" data-toggle="modal"
                            data-target="#theModal">Agregar</a>

                    </div>
                @endcan
                @can('product_search')
                    @include('common.searchbox')
                @endcan
            </div>


            <div class="widget-content widget-content-area">
                @cannot(['product_edit', 'product_destroy', 'product_search', 'product_create'])
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
                                <th class="table-th text-center">Producto</th>
                                <th class="table-th text-center">Barcode</th>
                                <th class="table-th text-center">Categoria</th>
                                <th class="table-th text-center">Precio</th>
                                <th class="table-th text-center">Stock</th>
                                <th class="table-th text-center">INV.MIN</th>
                                <th class="table-th text-center">Imagen</th>
                                @if (auth()->user()->can('product_edit') ||
                                        auth()->user()->can('product_destroy'))
                                    <th class="table-th text-center">Acciones</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td class="text-center">{{ $product->name }}</td>
                                    <td class="text-center">{{ $product->barcode }}</td>
                                    <td class="text-center">{{ $product->category }}</td>
                                    <td class="text-center">$ {{ number_format($product->pricev, 2) }}</td>
                                    <td class="text-center">{{ $product->stock }}</td>
                                    <td class="text-center">{{ $product->alerts }}</td>
                                    <td class="text-center"><span>
                                            <img src="{{ asset('storage/products/' . $product->image) }}" alt="Ejemplo"
                                                height="70" width="80" class="rounded">
                                        </span></td>

                                    @if (auth()->user()->can('product_edit') ||
                                            auth()->user()->can('product_destroy'))
                                        <td class="text-center">
                                            @can('product_edit')
                                                <a href="javascript:void(0)" wire:click="Edit({{ $product->id }})"
                                                    class="btn btn-dark mtmobile" title="Editar"><i
                                                        class="fas fa-edit mt-1"></i></a>
                                            @endcan

                                            @can('product_destroy')
                                                @if ($product->sales->count() < 1)
                                                    <a href="javascript:void(0)" onclick="Confirm('{{ $product->id }}')"
                                                        class="btn btn-dark" title="Eliminar"><i
                                                            class="fas fa-trash mt-1"></i></a>
                                                @endif
                                            @endcan


                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $products->links() }}

                </div>



            </div>
        </div>
    </div>

    @include('livewire.products.form')
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show');
        });
        window.livewire.on('product-add', msg => {
            $('#theModal').modal('hide');
        });

        window.livewire.on('product-update', msg => {
            $('#theModal').modal('hide');
        });

        window.livewire.on('modal-show', msg => {
            $('#theModal1').modal('show');
        });
        window.livewire.on('modal-hide', msg => {
            $('#theModal1').modal('hide');
        });
        window.livewire.on('hidden.bs.modal', msg => {
            $('.er').css('display', 'none');
        });



    });

    @can('product_destroy')

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
