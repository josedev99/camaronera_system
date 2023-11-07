@include('common/modalHead')

<div class="row">

    <div class="col-sm-12">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Nombre</span>
            </div>
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="nombre">
        </div>
        @error('name') <span class="text-danger er">{{$message}}</span> @enderror

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">NIT</span>
            </div>
            <input type="text" wire:model.lazy="nit" class="form-control" placeholder="NIT">
        </div>
        @error('nit') <span class="text-danger er">{{$message}}</span> @enderror

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Contacto</span>
            </div>
            <input type="text" wire:model.lazy="contact" class="form-control" placeholder="Contacto">
        </div>
        @error('contact') <span class="text-danger er">{{$message}}</span> @enderror

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Telefono</span>
            </div>
            <input type="text" wire:model.lazy="phone" class="form-control" placeholder="Tel: 2021-2023">
        </div>
        @error('phone') <span class="text-danger er">{{$message}}</span> @enderror

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Email</span>
            </div>
            <input type="text" wire:model.lazy="email" class="form-control" placeholder="Correo">
        </div>
        @error('email') <span class="text-danger er">{{$message}}</span> @enderror

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Direccion</span>
            </div>
            <input type="text" wire:model.lazy="address" class="form-control" placeholder="San Salvador">
        </div>
        @error('address') <span class="text-danger er">{{$message}}</span> @enderror

    </div>

    
</div>

@include('common/modalFooter')