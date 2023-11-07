<div wire:ignore.self class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" id="theModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white ">Revision de los precios de venta</h5>
                <h6 class="text-center text-warnig" wire:loading>Porfavor espere.</h6>
            </div>
            <div class="modal-body">
                <div class="row container">
                    @if($newpp != [])
                    <table class="table table-bordered table-hover mb-4">
                        <thead style=" background: #BDBDBD">
                            <tr>
                                <th class="table-th text-center">Producto</th>
                                <th class="table-th text-center">Precio de compra</th>
                                <th class="table-th text-center">Precio de venta</th>
                                <th class="table-th text-center">Precio de promedio</th>
                                <th class="table-th text-center">Precio sugerido</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 1; $i <= count($newpp); $i++, $a++)
                                <tr>
                                    <td class="text-center">{{ $newpp[$a]['name'] }}</td>
                                    <td class="text-center">${{ number_format($newpp[$a]['pricenew'],2) }}</td>
                                    <td class="text-center">${{ number_format($newpp[$a]['price'],2) }}</td>
                                    <td class="text-center">${{ number_format($newpp[$a]['promedio'],2) }}</td>
                                    <td class="text-center">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                    
                                                <span class="input-group-text input-gp"> $</span>
                                            </div>
                                            <input autocomplete="off" type="number" class="form-control" wire:model="newpp.{{ $a }}.priceold" />
                                            </div>
                                        
                                    </td>
                                    
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                    

                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark close-tbn text-info"
                    data-dismiss="modal">CERRAR</button>

                
                    <button type="button" class="btn btn-dark close-modal" wire:click.prevent="UpdatePrice()">ACTUALIZAR</button>
                
            </div>
        </div>
    </div>
</div>
