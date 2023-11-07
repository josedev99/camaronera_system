@include('common/modalHead')

<div class="row">

    <div class="col-sm-12">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Nombre</span>
            </div>
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="Ej: Admin">
        </div>
        @error('name') <span class="text-danger er">{{$message}}</span> @enderror

    </div>

  
</div>

@include('common/modalFooter')