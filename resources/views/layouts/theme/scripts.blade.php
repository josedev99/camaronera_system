
<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="{{asset('assets/js/libs/jquery-3.1.1.min.js')}}"></script>
<script src="{{asset('bootstrap/js/popper.min.js')}}"></script>
<script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('assets/js/app.js')}}"></script>
<script>
    $(document).ready(function() {
        App.init();
    });

    
</script>
<script src="{{asset('assets/js/custom.js')}}"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->

<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS --> 

<script src="{{asset('js/chart.js')}}"></script>
 <script src="{{asset('plugins/sweetalerts/sweetalert2.min.js')}}"></script>
  <script src="{{asset('plugins/notification/snackbar/snackbar.min.js')}}"></script>
   <script src="{{asset('plugins/nicescroll/nicescroll.min.js')}}"></script>
   <script src="{{asset('plugins/currency/currency.js')}}"></script>
   <script src="{{asset('assets/js/iconos.js')}}"></script>
   <script src="{{asset('plugins/flatpickr/flatpickr.js')}}"></script>
   
   


    
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->


<script>




function noty(msg, option = 1){
    Snackbar.show({
        text: msg.toUpperCase(),
        actionText: 'CERRAR',
        actionTextColor: '#fff',
        backgroundColor: option == 1 ? '#3b3f5c' : '#e7515a',
        pos: 'top-right',

    });
}

flatpickr(".flatpickr", {
      minDate: '1920-01-01',  
      locale: {
        firstDayOfWeek: 1,
        weekdays: {
          shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
          longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],         
        }, 
        months: {
          shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Оct', 'Nov', 'Dic'],
          longhand: ['Enero', 'Febreo', 'Мarzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        },
      },
    });



</script>

@livewireScripts


        
        
        
        
        
        
        
        
        