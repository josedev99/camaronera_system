<div>

<div class="connect-sorting">
    <div class="connect-sorting-content">
        <div class="card simple-title-task ui-sortable-handle">
            <div class="card-body">
                @if($total > 0)
                <div class="table-responsive tblscroll" style="max-height: 650; overflow: hidden">
                    <table class="table table-bordered table-striped mt-1">
                        <thead style=" background: #f37f23">
                            <tr>
                                <th width="10%"></th>
                                <th  width="14%" class="table-th text-left">Descripcion</th>
                                <th  width="16%" class="table-th text-center">Precio</th>
                                <th width="14%" class="table-th text-center">Cant</th>
                                <th  class="table-th text-center">Importe</th>
                                <th  class="table-th text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart as $item)
                            <tr>
                                <td class="text-center table-th">
                                
                                    @if(count($item->attributes) > 0)
                                    <span>
                                        <img src="{{asset('storage/products/'.$item->attributes[0])}}" alt="imagen" height="90" width="90" class="rounded">
                                    </span>
                                    @endif 
                                </td>

                                <td class=""><h6>{{$item->name}}</h6></td> 

                                <td class="text-center table-th">
                                    <input type="number" id="p{{$item->id}}"
                                    wire:change="updateQty({{$item->id}}, $('#r' + {{$item->id}}).val(), $('#p' + {{$item->id}}).val())"
                                    style="font-size: 1rem!important"
                                    class="form-control text-center"
                                    value="{{number_format($item->price,2)}}">
                                    </td>

                                <td class="text-center">
                                    <input type="number" id="r{{$item->id}}"
                                    wire:change="updateQty({{$item->id}}, $('#r' + {{$item->id}}).val(), $('#p' + {{$item->id}}).val())"
                                    style="font-size: 1rem!important"
                                    class="form-control text-center"
                                    value="{{$item->quantity}}">
                                   
                                </td> 
                                <td class="text-center table-th">
                                    <h6>
                                        ${{number_format($item->price * $item->quantity, 2)}}
                                    </h6>
                                </td>
                                <td class="text-center table-th">
                                    <button class="btn btn-dark mbmobile" onclick="Confirm('{{$item->id}}', 'removeItem', 'Confirmas eleminar el regsitro?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <button class="btn btn-dark mbmobile" wire:click.prevent="decreaseQty({{$item->id}})">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    
                                    <button class="btn btn-dark mbmobile" wire:click.prevent="increaseQty({{$item->id}})">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    
                                </td>
                                
                                
                            </tr>
                            @endforeach
                       
                        </tbody>
                    </table>
                    
                </div>
                @else
                <h5 class="text-center text-muted">
                    Agregar productos a la compra.
                </h5>
                @endif

                
                <div wire:loading.inline wire:target="saveSale">
                    <h4 class="text-danger text-center">
                        Guardando Venta...
                    </h4>
                </div>

            </div>
        </div>
    </div>
</div>

</div>