<div>
    <a href="javascript:void(0);" class="action-icon"
        wire:click="$dispatch('changeStatus', {'id': {{ $row->id }}, 'status': 'T', 'key': '{{$key}}' })">
        <i class="mdi mdi-delete"></i>
    </a>


    <script>
        document.addEventListener('livewire:initialized', () => {
               
            @this.on('changeStatus', (data) => {
                event.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to change status this record!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#556ee6',
                    cancelButtonColor: '#f46a6a',
                    confirmButtonText: 'Yes, change it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call('changeStatusConfirm', data);
                    }else{

                        if(data.status != 'T'){
                            e = document.getElementById('switch'+data.key);
                            if(e.checked){
                                e.checked = false;
                            }else{
                                e.checked = true;
                            }
                        }

                    }
                });
                
            });
                
        });
    </script>

</div>