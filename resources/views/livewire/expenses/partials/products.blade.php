<div class="row mt-3">
    <div class="col-sm-12">
        <div class="connect-sorting">
            <h5 class="text-center mb-">PRODUCTOS</h5>
            
            <div class="connect-sorting-content mt-4">
                <div class="card simple-title-task ui-sortable-handle">
                    <div class="card-body">
                        <div class="input-group input-group-md mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text input-gp"> <i class="fas fa-search"></i></span>
                            </div>
                            <input class="form-control" type="text" wire:model.lazy ="search" placeholder="Buscar">
                            <div class="input-group-append">
                                <select class="input-group-text" wire:model="pagination">
                                    <option value="Elegir" disabled>Elegir</option>
                                    <option value="3">3</option>
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                    
                                </select>
                            </div>
                            
                        </div>

                        <div class="table-responsive">
                            
                            <table class="table table-bordered table-hover mb-4">
                                <thead style=" background: #f37f23">
                                    <tr>
                                        <th class="table-th text-center">Producto</th>
                                        <th class="table-th text-center">Acciones</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td class="text-center">{{ $product->name }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-dark mbmobile" wire:click.prevent="AddProduct({{$product->id}})">
                                                    <i class="fas fa-plus"></i>
                                                </button>
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
</div>
