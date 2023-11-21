@include('common/modalHead')

@if ($save != false)
    <div class="row">
        <div class="col-12">
            <h5><b>Factura:</b> {{ $save->invoice }}.</h5>
        </div>
        <div class="col-12">
            <h5><b>Tipo de Factura:</b> {{ $save->type_invoice }}.</h5>
        </div>
        <div class="col-12">
            <h5><b>Cliente:</b> {{ $save->customer }}.</h5>
        </div>
        <div class="col-12">
            <h5><b>{{ $save->pond }}.</b> </h5>
        </div>
        <div class="col-12">
            <h5><b>Tamaño:</b> {{ $save->grams }} g.</h5>
        </div>
        <div class="col-12">
            <h5><b>Libras V:</b> {{ $save->items }} LB.</h5>
        </div>
        <div class="col-12">
            <h5><b>Total:</b> ${{ number_format($save->total, 2) }}</h5>
        </div>
        <div class="col-12">
            <h5><b>Metodo:</b>
                @if ($save->pay == 'CONTADO')
                    <span class="badge bg-success">CONTADO</span>
                @elseif($save->pay == 'CREDITO')
                    <span class="badge bg-warning text-dark">CREDITO</span>
                @endif
            </h5>
        </div>
        <div class="col-12">
            <h5><b>Estado:</b>
                @if ($save->status == 'PAID')
                    <span class="badge bg-success">Pagado</span>
                @elseif($save->status == 'PENDING')
                    <span class="badge bg-warning text-dark">Pendiente</span>
                @endif
            </h5>
        </div>
        <div class="col-12">
            <h5><b>Fecha:</b> {{ \Carbon\Carbon::parse($save->created_at)->format('d-m-Y H:i:s') }}</h5>
            <input type="hidden" wire:model="id_sale" value="{{$save->id}}">
        </div>
        @if(isset($abonado->saldo))
        <div class="col-12">
            <h5><b>Total Abonado:</b> ${{ number_format($abonado->saldo, 2) }}</h5>
        </div>
        @endif
        

        <div class="col-12 text-center">
            @if ($save->image != null)
                <span>
                    <img src="{{ asset('storage/invoices/' . $save->image) }}" alt="Ejemplo" height="200"
                        width="200" class="rounded">
                </span>
            @endif

        </div>


    </div>


@endif
<div class="row">
    <div class="col-sm-12">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Factura #</span>
            </div>
            <input type="text" wire:model.debounce.500ms="invoice" class="form-control" placeholder="1209-8">
        </div>
        @error('invoice')
            <span class="text-danger er">{{ $message }}</span>
        @enderror

    </div>

    <div class="col-sm-12">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Abonar $</span>
            </div>
            <input type="number" wire:model.lazy="abono" class="form-control" placeholder="10.5">
        </div>
        @error('abono')
            <span class="text-danger er">{{ $message }}</span>
        @enderror

    </div>



</div>

@include('common/modalFooter')
