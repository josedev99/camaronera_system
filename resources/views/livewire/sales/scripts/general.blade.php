<script>
    $('.tblscroll').niceScroll({
            cursorcolor: "#515355",
            cursorwidth: "30px",
             background: "rgba(20,20,20,0.3)",
             cursorborder: "0px",
             cursorborderradius: "3px",
        }); 
       

        function Confirm(id, eventName, text){
        swal({
            title: 'Confirmar',
            text: text,
            type: 'warning',
            showCancelButton: true,
            cancelButtonText: 'CERRAR',
            cancelButtonColor: '#fff',
            confirmButtonColor: '#3b3f5c',
            confirmButtonText: 'ACEPTAR',
        }).then(function(result){
            if (result.value){
                window.livewire.emit(eventName, id);
                swal.close();
            }
        });
    }
        

</script>