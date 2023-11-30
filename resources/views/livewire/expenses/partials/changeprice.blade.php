<div wire:ignore.self class="modal fade" tabindex="-1" role="dialog" id="theModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white ">Los nuevos precios de compra superan los de venta</h5>
                <h6 class="text-center text-warnig" wire:loading>Porfavor espere.</h6>
            </div>
            <div class="modal-body">
                <div class="row container">
                    @if($newpp != [])
                    <table class="table table-bordered table-hover mb-4">
                        <thead style=" background: #f37f23">
                            <tr>
                                <th class="table-th text-center">Producto</th>
                                <th class="table-th text-center">Precio de compra</th>
                                <th class="table-th text-center">Precio de venta</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 1; $i <= count($newpp); $i++, $a++)
                                <tr>
                                    <td class="text-center">{{ $newpp[$a]['name'] }}</td>
                                    <td class="text-center">{{ $newpp[$a]['pricenew'] }}</td>
                                    <td class="text-center">
                                        <input autocomplete="off" type="number" class="form-control" wire:model="newpp.{{ $a }}.priceold" />
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
