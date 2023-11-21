<!-- Modal -->
<div class="modal fade" id="reporteriaCompra" data-backdrop="static" wire:ignore.self data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header py-1" style="background: #4cb050">
                <h5 class="modal-title text-white" id="labelModalCompra">Generar reporte en pdf</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-sm-12 col-md-6">
                                    <label for="">Desde</label>
                                    <input type="date" wire:model.lazy="desde" class="form-control">
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label for="">Hasta</label>
                                    <input type="date" wire:model.lazy="hasta" class="form-control">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer p-1 d-flex justify-content-end">
                        <button type="button" wire:click="generarPDF" class="btn btn-outline-secondary btn-sm"><i class="fas fa-pdf"></i> Generar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>