@include('common/modalHead')

@if ($show == false)
    <div class="row">
        <div class="col-sm-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Factura #</span>
                </div>
                <input type="text" wire:model.lazy="invoice" class="form-control" placeholder="1209-8">
            </div>
            @error('invoice')
                <span class="text-danger er">{{ $message }}</span>
            @enderror

        </div>
        <div class="col-sm-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Tipo F.</span>
                </div>
                <select class="form-control" wire:model="type_invoice">
                    <option value="Elegir" disabled>Elegir</option>
                    <option value="Factura CF">Factura CF</option>
                    <option value="Factura CCF">Factura CCF</option>
                </select>
                @error('type_invoice')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror
            </div>


        </div>


        <div class="col-sm-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Libras</span>
                </div>
                <input type="number" wire:model.lazy="items" class="form-control" placeholder="20 LB">
            </div>
            @error('items')
                <span class="text-danger er">{{ $message }}</span>
            @enderror

        </div>

        <div class="col-sm-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Total</span>
                </div>
                <input type="number" wire:model.lazy="total" class="form-control" placeholder="$100">
            </div>
            @error('total')
                <span class="text-danger er">{{ $message }}</span>
            @enderror

        </div>

        <div class="col-sm-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Cliente</span>
                </div>
                <input type="text" wire:model.lazy="customer" class="form-control" placeholder="Jose Lopez">
            </div>
            @error('customer')
                <span class="text-danger er">{{ $message }}</span>
            @enderror

        </div>

        <div class="col-sm-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Gramos</span>
                </div>
                <input type="number" wire:model.lazy="grams" class="form-control" placeholder="10.5">
            </div>
            @error('grams')
                <span class="text-danger er">{{ $message }}</span>
            @enderror

        </div>

        <div class="col-sm-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Estanque</span>
                </div>
                <select class="form-control" wire:model="pond">
                    <option value="Elegir" disabled>Elegir</option>
                    <option value="Estanque 1">Estanque 1</option>
                    <option value="Estanque 2">Estanque 2</option>
                </select>
                @error('pond')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror
            </div>

        </div>
        @if ($selected_id == false)
            <div class="col-sm-12">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Metodo Pago</span>
                    </div>
                    <select class="form-control" wire:model="pay">
                        <option value="Elegir" disabled>Elegir</option>
                        <option value="CONTADO">CONTADO</option>
                        <option value="CREDITO">CREDITO</option>
                    </select>
                    @error('pay')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>


            </div>
        @endif

        <div class="col-sm-12">
            <div class="form-group custom-file">
                <input type="file" class="custom-file-input form-control" wire:model="image"
                    accept="image/x-png, image/gif, image/jpeg, image/jpg">
                <label class="custom-file-label">Foto factura {{ $image }}</label>
                @error('image')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror
            </div>


        </div>
    </div>
@else
    <div class="row">
        <div class="col-12">
            <h5><b>Factura:</b> {{ $show->invoice }}.</h5>
        </div>
        <div class="col-12">
            <h5><b>Tipo de Factura:</b> {{ $show->type_invoice }}.</h5>
        </div>
        <div class="col-12">
            <h5><b>Cliente:</b> {{ $show->customer }}.</h5>
        </div>
        <div class="col-12">
            <h5><b>{{ $show->pond }}.</b> </h5>
        </div>
        <div class="col-12">
            <h5><b>Tamaño:</b> {{ $show->grams }} g.</h5>
        </div>
        <div class="col-12">
            <h5><b>Libras V:</b> {{ $show->items }} LB.</h5>
        </div>
        <div class="col-12">
            <h5><b>Total:</b> ${{ number_format($show->total, 2) }}</h5>
        </div>
        <div class="col-12">
            <h5><b>Metodo:</b>
                @if ($show->pay == 'CONTADO')
                    <span class="badge bg-success">CONTADO</span>
                @elseif($show->pay == 'CREDITO')
                    <span class="badge bg-warning text-dark">CREDITO</span>
                @endif
            </h5>
        </div>
        <div class="col-12">
            <h5><b>Estado:</b>
                @if ($show->status == 'PAID')
                    <span class="badge bg-success">Pagado</span>
                @elseif($show->status == 'PENDING')
                    <span class="badge bg-warning text-dark">Pendiente</span>
                @endif
            </h5>
        </div>

        <div class="col-12">
            <h5><b>Fecha:</b> {{ \Carbon\Carbon::parse($show->created_at)->format('d-m-Y H:i:s') }}</h5>
        </div>

        <div class="col-12 text-center">
            @if($show->image != null)
            <span>
                <img src="{{asset('storage/invoices/'.$show->image)}}" alt="Ejemplo" height="200" width="200" class="rounded">
            </span>
            @endif
            
        </div>


    </div>
@endif

@include('common/modalFooter')
