 
 <ul class="navbar-item flex-row search-ul">
                @can('sale_scan')
                <li class="nav-item align-self-center search-animated">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search toggle-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <form class="form-inline search-full form-inline search" role="search">
                        <div class="search-bar">
                            <input id="code" type="text" wire:keydown.enter.prevent="$emit('scan-code', $('#code').val())" class="form-control search-form-control  ml-lg-auto" placeholder="Search...">
                        </div>
                    </form> 
                </li>
                @endcan
            </ul>
            
@can('sale_scan')
<script>
document.addEventListener('DOMContentLoaded', function(){
        window.livewire.on('scan-code', action => {
            $('#code').val('');
  });
        


        
});
</script>
@endcan
