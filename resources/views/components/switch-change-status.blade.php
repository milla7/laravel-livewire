<div>
    <input wire:click="$dispatch('changeStatus', {'id': {{ $row->id }}, 'status': '{{ ($row->status == 'A' ? 'I': 'A') }}', 'key': '{{$key}}' })"  type="checkbox" id="switch{{$key}}" 
    @if ($row->status == "A")
    checked
    @endif
    data-switch="success" />
    <label for="switch{{$key}}" 
    data-on-label="Yes" data-off-label="No"></label>





    @push('scripts')
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
    @endpush
</div>
