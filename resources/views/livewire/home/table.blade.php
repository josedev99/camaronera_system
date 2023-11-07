<div wire:ignore.self class="modal fade" tabindex="-1" role="dialog" id="theModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white "><b> Los siguientes productos estan escaseando</b> </h5>
                <h6 class="text-center text-warnig" wire:loading>Porfavor espere.</h6>
            </div>
            <div class="modal-body">
                <div class="table-responsive mt-2">
                    <table class="table table-bordered">

                        <thead>
                            <tr>
                                <th class="text-center">Producto</th>
                                <th class="text-center">Stock</th>
                                <th class="text-center">Limite</th>
                                

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $l)
                                <tr>
                                    <td class="text-center">
                                        <strong>{{ $l->name }}</strong>

                                    </td>
                                    <td class="text-center">
                                        {{ $l->stock}}



                                    </td>
                                    <td class="text-center">
                                        {{ $l->alerts }}

                                    </td>

                                    




                                </tr>
                            @endforeach
                        </tbody>
                    </table>


                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark close-tbn text-info"
                    data-dismiss="modal">CERRAR</button>

            

            </div>
        </div>
    </div>
</div>
