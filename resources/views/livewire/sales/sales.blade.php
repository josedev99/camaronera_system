<div>
<style> </style>
   <div class="row layout-top-spacing">
   
    <div class="col-sm-12 col-md-8">
     @cannot(['sale_product', 'sale_scan', 'sale_create'])
        <div class="alert alert-danger mb-2" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
        <strong>Atencion!</strong> Comunicarse con el Administrador para tener los todos los permisos de esta seccion</button>
        </div>
      @endcannot
        
        @can('sale_product')
        @include('livewire.sales.partials.details')
        @endcan
    </div>
    <div class="col-sm-12 col-md-4">
   
        @can('sale_create')
        @include('livewire.sales.partials.total')
        @include('livewire.sales.partials.denominations')
        @endcan
    </div>
    </div>
</div>


 @include('livewire.sales.scripts.events')
 @include('livewire.sales.scripts.scan')
@include('livewire.sales.scripts.general')
@include('livewire.sales.scripts.shorcuts')

<script>


</script>
