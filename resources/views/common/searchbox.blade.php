<div class="row justify-content-between">
    <div class="col-lg-4 col-md-4 col-sm-8 ml-3">
        <div class="input-group mb-4">
            
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
    </div>
</div>