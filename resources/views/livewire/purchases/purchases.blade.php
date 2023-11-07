<div>
    <style> </style>
    <div class="row layout-top-spacing">

        <div class="col-sm-12 col-md-8">



            @include('livewire.purchases.partials.details')

        </div>
        <div class="col-sm-12 col-md-4">


            @include('livewire.purchases.partials.total')
            @include('livewire.purchases.partials.products')
            @include('livewire.purchases.partials.providers')

        </div>
    </div>
    @include('livewire.purchases.partials.changeprice')
</div>


@include('livewire.purchases.scripts.events')
@include('livewire.purchases.scripts.scan')
@include('livewire.purchases.scripts.general')
@include('livewire.purchases.scripts.shorcuts')

<script></script>
