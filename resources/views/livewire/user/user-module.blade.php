<div>
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                        <li class="breadcrumb-item active">Customers</li>
                    </ol>
                </div>
                <h4 class="page-title">Customers</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-2 d-flex justify-content-between align-items-center">
                        <h4 class="header-title">Customers</h4>
                        <div>
                            <a class="btn btn-primary mb-2" wire:click="openModal('create')">
                                <i class="mdi mdi-plus-circle me-2"></i> Add Customers
                            </a>
                        </div>


                    </div>

                    <div class="d-flex  flex-wrap justify-content-between">

                        <div class="" id="products-datatable_length">
                            <label class="form-label">Display </label>
                            <select class="form-select form-select-sm " wire:model.live="perPage">
                                <option vale="5">5</option>
                                <option vale="10">10</option>
                                <option vale="15">15</option>
                                <option vale="25">25</option>
                                <option vale="50">50</option>
                                <option vale="100">100</option>                                
                            </select>
                            
                        </div>


                        <form id="products-datatable_filter" class="dataTables_filter">
                            <label>Search:
                                <input type="search" class="form-control form-control-sm" placeholder=""
                                    aria-controls="products-datatable" wire:model.live.debounce.300ms="search">
                            </label>
                        </form>

                    </div>


                    <div class="table-responsive">
                        <table class="table table-centered table-striped dt-responsive nowrap w-100 mb-0"
                            id="products-datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Customer</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th style="width: 95px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($objs as $key => $row)
                                <tr wire:key="user--{{ $row->id }}">
                                    <td>
                                        {{ $key + 1 }}
                                    </td>

                                    <td>
                                        {{ $row->name }}
                                    </td>

                                    <td>
                                        {{ $row->email }}
                                    </td>

                                    <td>
                                        <span class="">

                                            <x-switch-change-status :row="$row" :key="$key" />

                                        </span>
                                    </td>

                                    <td>
                                        <x-edit-button-modal :id="$row->id"/>

                                        
                                        <x-delete-button-status :row="$row" :key="$key" />

                                    </td>
                                </tr>

                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-2">
                        {{ $objs->links() }}
                    </div>




                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>


    <x-modal>
        <x-slot name="title">
            {{ ucfirst($action) }} {{$view_title}}
        </x-slot>

        <x-slot name="content">
            <div class="mb-3">
                <label for="example-input-normal" class="form-label">Name</label>
                <input type="text" id="example-input-normal" name="example-input-normal"
                    class="form-control @error('obj.name') is-invalid @enderror" wire:model="obj.name">
                @error('obj.name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="example-input-normal" class="form-label">Email</label>
                <input type="text" id="example-input-normal" name="example-input-normal"
                    class="form-control @error('obj.email') is-invalid @enderror" wire:model="obj.email">
                @error('obj.email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="example-input-normal" class="form-label">Password</label>
                <input type="password" id="example-input-normal" name="example-input-normal"
                    class="form-control @error('obj.password') is-invalid @enderror" wire:model="obj.password">
                @error('obj.password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror

        </x-slot>

        <x-slot name="footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" wire:click="{{$action}}">
                {{ ucfirst($action) }}
            </button>
        </x-slot>
    </x-modal>


    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('showModal', (event) => {
                $('.modal').modal('show');
            });

            @this.on('closeModal', (event) => {
                $('.modal').modal('hide');
            });

            @this.on('showSuccess', (event) => {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Your record has been saved.'
                });
            });
            @this.on('testing', (event) => {
                console.log(event);
            });
            
        });
    </script>
    @endpush
</div>