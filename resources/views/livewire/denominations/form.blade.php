@include('common/modalHead')

<div class="row">

    <div class="col-sm-12">
        <div class="input-group mb-3">
            
            <span class="input-group-text" id="basic-addon1">Tipo</span>
            
           <select class="custom-select" wire:model="type">
           <option value="no" selected>Elegir</option>
           <option value="BILLETE">BILLETE</option>
           <option value="MONEDA">MONEDA</option>
           <option value="OTRO">OTRO</option>
            </select>
        </div>
        @error('type') <span class="text-danger er">{{$message}}</span> @enderror

    </div>

     <div class="col-sm-12">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Valor</span>
            </div>
            <input type="text" wire:model.lazy="value" class="form-control" placeholder="Ej: 25">
        </div>
        @error('value') <span class="text-danger er">{{$message}}</span> @enderror

    </div>

    <div class="col-sm-12">
        <div class="form-group custom-file">
            <input type="file" class="custom-file-input form-control" wire:model="image" accept="image/x-png, image/gif, image/jpeg, image/jpg">
            <label class="custom-file-label">Imagen {{$image}}</label>
            @error('image') <span class="text-danger er">{{$message}}</span>@enderror
        </div>
    </div>
</div>

@include('common/modalFooter')