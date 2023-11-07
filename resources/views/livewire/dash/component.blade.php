<div>
    
<div class="row sales layout-top-spacing">
    <div class="col-lg-12 col-12 col-sm-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4><b>Dashboard</b></h4>


                    </div>
                </div>
                
            </div>



            <div class="widget-content widget-content-area">
                <div class="row">
                    {{-- Grafica 1 --}}
                    <div class="col-lg-6 col-sm-12 col-md-6 pt-2 ">
                        <div class="card">
                            <h4 class="p-3 text-center text-theme-1 fond-bold">Productos Mas Comprados</h4>
                            
                            <canvas id="myChart2" class="container"></canvas>
                              
                        </div>
                        
                    </div>
                     {{-- Grafica 2 --}}

                    <div class="col-lg-6 col-sm-12 col-md-6 pt-2 ">
                        <div class="card">
                            <h4 class="p-3 text-center text-theme-1 fond-bold">Productos Mas Vendidos</h4>
                            
                            <canvas id="myChart4" class="container"></canvas>
                              
                        </div>
                        
                    </div>
                    
                </div> 

                <div class="row pt-2">
                    {{-- Grafica 3 --}}
                    <div class="col">
                        <div class="card">
                            <h4 class="p-3 text-center text-theme-1 fond-bold">Compras Y Egresos Semanales</h4>
                            <canvas id="myChart" class="container"></canvas>
                        </div>
                    </div>
                </div>

                <div class="row pt-2">
                    {{-- Grafica 3 --}}
                    <div class="col">
                        <div class="card">
                            <h4 class="p-3 text-center text-theme-1 fond-bold">Compras Y Egresos Anuales
                                {{ date('Y') }}</h4>
                                <canvas id="myChart3" class="container"></canvas>
                        </div>
                    </div>
                </div>

                
                



            </div>
        </div>
    </div>
    @include('livewire.dash.scripts')


</div>
</div>

