<script>
try{
    onScan.attachTo(document, {
   suffixKeyCodes: [13],
   onScan: function(barcode) { // Alternative to document.addEventListener('scan')
        console.log(barcode);
        window.livewire.emit('scan-code', barcode);
    },
    onScanError: function(e){ // output all potentially relevant key events - great for debugging!
        console.log(e);
    }
});
console.log('Scan FUll');
}
catch(e){
    console.log('Error lec', e)
}
</script>