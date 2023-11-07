@include('common/modalHead')

<div class="row">

    

    <div class="col-sm-12 col-md-8">
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="nombre">
            @error('name') <span class="text-danger er">{{$message}}</span> @enderror
        </div>
    </div>

   

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Telefono</label>
            <input type="text" wire:model.lazy="phone" class="form-control" placeholder="Ej: 1232131">
            @error('phone') <span class="text-danger er">{{$message}}</span> @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Correo</label>
            <input type="text" wire:model.lazy="email" class="form-control" placeholder="Ej: usuario@gmail.com">
            @error('email') <span class="text-danger er">{{$message}}</span> @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Contraseña</label>
            <input type="text" wire:model.lazy="password" class="form-control" placeholder="Ej: l0g4r!tm0">
            @error('password') <span class="text-danger er">{{$message}}</span> @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Estado</label>
            <select class="form-control" wire:model.lazy="status">
           
            <option value="ACTIVE">ACTIVADO</option>
            <option value="LOCKED">DESACTIVADO</option>
           
            </select> 
           
            @error('status') <span class="text-danger er">{{$message}}</span> @enderror
        </div>
        
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Asignar Rol</label>
            <select class="form-control" wire:model.lazy="profile">
            
            @foreach ($roles as $rol)
            <option value="{{$rol->name}}" >{{$rol->name}}</option>
            @endforeach
            </select>
           
            @error('profile') <span class="text-danger er">{{$message}}</span> @enderror
        </div>
        
    </div>
    

    <div class="col-sm-12 col-md-12 mb-2">
        <div class="form-group custom-file">
            
            <input type="file" wire:model="image" class="custom-file-input" placeholder="Seleciconar">
            <label class="custom-file-label">Imagen {{$image}}</label>
            @error('image') <span class="text-danger er">{{$message}}</span> @enderror
        </div>
    </div>

    
</div>

@include('common/modalFooter')