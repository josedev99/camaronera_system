<div>
    <style> </style>
    <div class="row layout-top-spacing">

        <div class="col-sm-12 col-md-8">



            @include('livewire.expenses.partials.details')

        </div>
        <div class="col-sm-12 col-md-4">


            @include('livewire.expenses.partials.total')
            @include('livewire.expenses.partials.products')
            @include('livewire.expenses.partials.customers')

        </div>
    </div>
    
</div>


@include('livewire.expenses.scripts.events')
@include('livewire.expenses.scripts.scan')
@include('livewire.expenses.scripts.general')
@include('livewire.expenses.scripts.shorcuts')

<script></script>
