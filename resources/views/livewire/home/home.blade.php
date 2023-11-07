<div>

    <div class="row sales layout-top-spacing">
        <div class="col-lg-12 col-12 col-sm-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4><b>Home</b></h4>


                        </div>
                    </div>

                </div>



                <div class="widget-content widget-content-area">


                    <div class="row">
                        <div class="col-12 d-flex justify-content-center">
                            <h3><b>Bienvenidos al sistema de control de inventarios</b></h4>
                        </div>
                        <div class="col-12 d-flex justify-content-center">
                            <div id="clockdate">
                                <div class="clockdate-wrapper">
                                    <div id="clock"></div>
                                    <div id="date"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-center">
                            <img src="{{ asset('assets/img/empresa.png') }}" width="300px;" height="">
                        </div>
                    </div>


















                </div>
            </div>
        </div>
        @include('livewire.home.script')
        @include('livewire.home.table')


    </div>
</div>
