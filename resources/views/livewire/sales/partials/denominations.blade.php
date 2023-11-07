<div class="row mt-3">
    <div class="col-sm-12">
        <div class="connect-sorting">
            <h5 class="text-center mb-">DENOMINACIONES</h5>
            <div class="container">
                <div class="row">
                    @foreach ($denominations as $d)
                        @if ($d->type == 'MONEDA')
                            <div class="col-sm mt-2">
                                <button class="btn btn-dark btn-block den"
                                    wire:click.prevent="ACash({{ '0.' . $d->value }})">
                                    {{ $d->value > 0 ? '$ 0.' . $d->value : 'EXACTO' }}
                                </button>
                            </div>
                        @else
                            <div class="col-sm mt-2">
                                <button class="btn btn-dark btn-block den"
                                    wire:click.prevent="ACash({{ $d->value }})">
                                    {{ $d->value > 0 ? '$ ' . number_format($d->value, 2, '.', '') : 'EXACTO' }}
                                </button>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="connect-sorting-content mt-4">
                <div class="card simple-title-task ui-sortable-handle">
                    <div class="card-body">
                        <div class="input-group input-group-md mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text input-gp hideonsm"
                                    style="background: #3B3F5C; color:#BDBDBD;">
                                    Efectivo F8
                                </span>
                            </div>
                            <input type="number" id="cash" wire:model="efectivo" wire:keydown.enter="savaSale"
                                class="form-control text-center" value="{{ $efectivo }}">
                            <div class="input-group-append">
                                <span class="input-group-text" wire:click="$set('efectivo', 0)"
                                    style="background: #3B3F5C; color:#BDBDBD;">
                                    <i class="fas fa-backspace fa-2x"></i>
                                </span>
                            </div>
                        </div>
                        <div class="d-flex">
                            <h4 class="text-muted">Cambio: $</h4>
                            <h4 class="text-muted">{{ number_format($change, 2) }}</h4>
                        </div>

                        <div class="row justify-content-between mt-5">
                            <div class="col-sm-12 col-md-12 col-lg-6">
                                @if ($total > 0)
                                    <button onclick="Confirm('', 'clearCart', 'Seguro de eleminar el carrito?')"
                                        class="btn btn-dark mtmobile">
                                        Cancelar F4
                                    </button>
                                @endif
                            </div>

                            <div class="col-sm-12 col-md-12 col-lg-6">
                                @if ($efectivo >= $total && $total > 0)
                                    <button wire:click.prevent="saveSale" class="btn btn-dark btn-md btn-block">
                                        GUARDAR F9
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
