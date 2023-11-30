<!-- Modal -->
<div class="modal fade" id="addEditProducts" data-backdrop="static" wire:ignore.self data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header py-1" style="background: #4cb050">
                <h5 class="modal-title text-white" id="labelModalCompra">Crear nuevo Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" wire:submit.prevent="processForm">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-sm-12 col-md-6">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" id="nombre" wire:model.lazy="nombre" class="form-control">
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label for="descripcion">Descripción</label>
                                    <input type="text" id="descripcion" wire:model.lazy="descripcion"
                                        class="form-control">
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label for="unidad_medida">Unidad de Medida</label>
                                    <input type="text" id="unidad_medida" wire:model.lazy="unidad_medida"
                                        class="form-control">
                                </div>
                                <div class="form-group col-sm-12 col-md-4">
                                    <label for="category_id">Categoria</label>
                                    <select name="" class="form-control" wire:model.lazy="category_id" id="category_id">
                                        <option value="none">Seleccionar</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer p-1 d-flex justify-content-end">
                            <button wire:click="saveProducto" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-save"></i> Guardar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>