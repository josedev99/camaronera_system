  </div>
      <div class="modal-footer">
        <button type="button" wire:click.prevent="resetIU()" class="btn btn-dark close-tbn text-info" data-dismiss="modal">CERRAR</button>

        @if($selected_id < 1)
         <button type="button" wire:click.prevent="Store()" class="btn btn-dark close-modal">GUARDAR</button>
        @else
        <button type="button" wire:click.prevent="Update()" class="btn btn-dark close-modal">ACTUALIZAR</button>
        @endif
        
      </div>
    </div>
  </div>
</div>