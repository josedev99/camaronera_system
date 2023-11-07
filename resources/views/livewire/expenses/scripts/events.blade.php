<script>
    document.addEventListener('DOMContentLoaded', function(){
        window.livewire.on('scan-ok', Msg => {
            noty(Msg)
        });

        window.livewire.on('scan-notfound', Msg => {
            noty(Msg,2)
        });
        
        window.livewire.on('purchase-ok', Msg => {
            noty(Msg)
        });

        window.livewire.on('no-stock', Msg => {
            noty(Msg,2)
        });
        window.livewire.on('sale-error', Msg => {
            noty(Msg)
        });
        window.livewire.on('print-ticket', saleId => {
           window.open("print://" + saleId, '_blank')
        });

        window.livewire.on('modal-show', msg => {
            $('#theModal').modal('show');
        });
        window.livewire.on('product-update', Msg => {
            $('#theModal').modal('hide');
            noty(Msg);
        });

        
        


        
    });

   
</script>