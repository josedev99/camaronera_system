<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css"
    href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/bootstrap-extended.min.css">
<link rel="stylesheet" type="text/css"
    href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/fonts/simple-line-icons/style.min.css">
<link rel="stylesheet" type="text/css"
    href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/colors.min.css">
<link rel="stylesheet" type="text/css"
    href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/bootstrap.min.css">
<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">


<!-- Highcharts JS -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
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
                    <div class="grey-bg container-fluid">
                        <section id="stats-subtitle">
                            <div class="row">
                                <div class="col-xl-6 col-md-12">
                                    <div class="card overflow-hidden">
                                        <div class="card-content">
                                            <div class="card-body cleartfix">
                                                <div class="media align-items-stretch">
                                                    <div class="align-self-center">
                                                        <i class="icon-user primary font-large-2 mr-2"></i>
                                                    </div>
                                                    <div class="media-body">
                                                        <h3>EMPLEADOS</h3>
                                                        <span>Registrados en el sistema</span>
                                                    </div>
                                                    <div class="align-self-center">
                                                        <h1>{{ $empleado }}</h1>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-md-12">
                                    <div class="card">
                                        <div class="card-content">
                                            <div class="card-body cleartfix">
                                                <div class="media align-items-stretch">
                                                    <div class="align-self-center">
                                                        <i class="icon-bag warning font-large-2 mr-2"></i>
                                                    </div>
                                                    <div class="media-body">
                                                        <h3>PRODUCTOS</h3>
                                                        <span>Registrados en el sistema</span>
                                                    </div>
                                                    <div class="align-self-center">
                                                    <h1>{{ $totalProductos }}</h1>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

                <div class="widget-content widget-content-area">
                    <div class="row">
                        {{-- Grafica 1 --}}
                        <div class="col-lg-6 col-sm-12 col-md-6 pt-2 ">
                            <div class="card">
                                <!--   <h4 class="p-3 text-center text-theme-1 fond-bold">Productos Mas Comprados</h4> -->
                                <div id="grafico1">
                                </div>
                            </div>

                        </div>
                        {{-- Grafica 2 --}}

                        <div class="col-lg-6 col-sm-12 col-md-6 pt-2 ">
                            <div class="card">
                                <div id="grafico2">
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="row pt-2">
                        {{-- Grafica 3 --}}
                        <div class="col">
                            <div class="card">
                                <!-- <canvas id="myChart" class="container"></canvas> -->
                                <div id="grafico3">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('livewire.dash.scripts')
    </div>
</div>