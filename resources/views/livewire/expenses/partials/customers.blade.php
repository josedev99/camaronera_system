<div class="row mt-3">
    <div class="col-sm-12">
        <div class="connect-sorting">
            <h5 class="text-center">CLIENTES</h5>
            
            <div class="connect-sorting-content mt-4">
                <div class="card simple-title-task ui-sortable-handle">
                    <div class="card-body">
                        <div class="row">
                            <div class="col"> 
                                <div class="form-group">
                                    <label class="text-dark">Cliente:</label>
                                    <select class="form-control" wire:model="customer_id">
                                    <option value="Elegir" disabled>Elegir</option>
                                    @foreach ($customers as $customer)
                                    <option value="{{$customer->id}}" >{{$customer->name}}</option>
                                    @endforeach 
                                    </select>
                                   
                                    @error('customer_id') <span class="text-danger er">{{$message}}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col"> 
                                <div class="form-group">
                                    <label class="text-dark">Metodo de pago:</label>
                                    <select class="form-control" wire:model="pay">
                                    <option value="Elegir" disabled>Elegir</option>
                                    <option value="CONTADO">CONTADO</option>
                                    <option value="CREDITO">CREDITO</option>
                                    </select>
                                   
                                    @error('pay') <span class="text-danger er">{{$message}}</span> @enderror
                                </div>
                            </div>
                        </div>

                        

                        <div class="row justify-content-between">
                            <div class="col-sm-12 col-md-12 col-lg-6">
                                @if ($total > 0)
                                    <button onclick="Confirm('', 'clearCart', 'Seguro de eleminar el carrito?')"
                                        class="btn btn-dark mtmobile">
                                        Cancelar
                                    </button>
                                @endif
                            </div>

                            <div class="col-sm-12 col-md-12 col-lg-6">
                                @if ($pay != 'Elegir' && $total > 0 && $customer_id != 'Elegir')
                                    <button wire:click.prevent="saveSale" class="btn btn-dark btn-md btn-block">
                                        GUARDAR
                                    </button>
                                @endif
                            </div>

                        </div>

                       

                        

                        


                    </div>



                </div>
            </div>
        </div>
    </div>
</div>