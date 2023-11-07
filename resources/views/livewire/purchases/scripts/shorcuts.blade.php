<script>

var listener = new window.keypress.Listener();
listener.simple_combo("f6", function(){
    livewire.emit('saveSale');
});

listener.simple_combo("f2", function(){
    document.getElementById('cash').value='';
     document.getElementById('hiddenTotal').value='';
     document.getElementById('cash').focus();
     
     
});

listener.simple_combo("f4", function(){
    var total = parseFloat(document.getElementById('hiddenTotal').value);
    if(total > 0){
        Confirm(0, 'clearCart', 'Segur@ de eleminar el carrrito?')
    }
    else {
        noty('Agrega Productos a la Venta')
    }
});


</script>