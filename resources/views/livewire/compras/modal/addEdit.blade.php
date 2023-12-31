<!-- Modal -->
<div class="modal fade" id="addEditCompra" data-backdrop="static" wire:ignore.self data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header py-1" style="background: #4cb050">
                <h5 class="modal-title text-white" id="labelModalCompra" wire:ignore></h5>
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
                                    <label for="proveedor">Nombre proveedor</label>
                                    <input type="text" id="proveedor" wire:model.lazy="proveedor" class="form-control">
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label for="descripcion">Descripción</label>
                                    <input type="text" id="descripcion" wire:model.lazy="descripcion" class="form-control">
                                </div>
                                <div class="form-group col-sm-12 col-md-2">
                                    <label for="monto">Precio Unitario</label>
                                    <input type="number" id="precioUnit" wire:model="precioUnit" step=".01" min="0" class="form-control">
                                </div>
                                <div class="form-group col-sm-12 col-md-2">
                                    <label for="monto">Cantidad</label>
                                    <input type="number" id="cantidad" wire:model="cantidad" step="1" min="1" class="form-control">
                                </div>
                                <div class="form-group col-sm-12 col-md-2">
                                    <label for="monto">Monto</label>
                                    <input readonly type="text" id="monto" wire:model.lazy="monto" step=".01" min="0" class="form-control">
                                </div>
                                <div class="form-group col-sm-12 col-md-3">
                                    <label for="tipo_pago">Tipo pago</label>
                                    <select name="" class="form-control" wire:model.lazy="tipo_pago" id="tipo_pago">
                                        <option value="">Seleccionar</option>
                                        <option value="Efectivo">Efectivo</option>
                                        <option value="Cheque">Cheque</option>
                                        <option value="Transferencia">Transferencia</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-12 col-md-3">
                                    <label for="producto">Producto</label>
                                    <select name="producto" id="producto" wire:model.lazy="producto_id" class="form-control select2">
                                        <option value="">Seleccionar</option>
                                       @foreach($products as $row)
                                            <option value="{{$row['id']}}">{{$row['nombre']}}</option>
                                       @endforeach
                                    </select>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="card-footer p-1 d-flex justify-content-end">
                        <button type="submit" class="btn btn-outline-secondary btn-sm"><i class="fas fa-save"></i> Registrar</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>