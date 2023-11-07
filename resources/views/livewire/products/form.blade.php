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
            <label>Barcode</label>
            <input type="text" wire:model.lazy="barcode" class="form-control" placeholder="Ej: 1232131">
            @error('barcode') <span class="text-danger er">{{$message}}</span> @enderror
        </div>
    </div>
   
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Precio</label>
            <input type="text" data-type="currency" wire:model.lazy="price" class="form-control" placeholder="Ej: 12.5">
            @error('price') <span class="text-danger er">{{$message}}</span> @enderror
        </div>
    </div>

    @if($selected_id == false)
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Stock</label>
            <input type="number" wire:model.lazy="stock" class="form-control" placeholder="Ej: 20" min="0">
            @error('stock') <span class="text-danger er">{{$message}}</span> @enderror
        </div>
    </div>
    @endif
    
    
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Inv. Min</label>
            <input type="number" wire:model.lazy="alerts" class="form-control" placeholder="Ej: 20">
            @error('alerts') <span class="text-danger er">{{$message}}</span> @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Porcentaje de ganancia %</label>
            <input type="number" wire:model.lazy="percentage" class="form-control" placeholder="Ej: 20">
            @error('percentage') <span class="text-danger er">{{$message}}</span> @enderror
        </div>
    </div>


    <div class="col-sm-12 col-md-4"> 
        <div class="form-group">
            <label>Categoria</label>
            <select class="form-control" wire:model="category_id">
            <option value="Elegir" disabled>Elegir</option>
            @foreach ($categories as $category)
            <option value="{{$category->id}}"  @if(false) selected @endif>{{$category->name}}</option>
            @endforeach 
            </select>
           
            @error('category_id') <span class="text-danger er">{{$message}}</span> @enderror
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