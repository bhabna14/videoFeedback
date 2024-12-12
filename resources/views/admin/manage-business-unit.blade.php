@extends('layouts.app')

@section('styles')
    <!-- Data table css -->
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatable/css/buttons.bootstrap5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/datatable/responsive.bootstrap5.css') }}" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- INTERNAL Select2 css -->
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
@endsection


@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">MANAGE BUSINESS UNIT</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb d-flex justify-content-between align-items-center">
                <a href="{{ route('addBusinessUnit') }}" class="breadcrumb-item tx-15 btn btn-warning">ADD BUSINESS UNIT</a>
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Manage Locality</li>
            </ol>
        </div>
    </div>
    <!-- /breadcrumb -->


    @if (session('success'))
        <div id = 'Message' class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('danger'))
        <div id = 'Message' class="alert alert-danger">
            {{ session('danger') }}
        </div>
    @endif
    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-body">

                    <div class="table-responsive  export-table">

                        <table id="file-datatable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">SlNo</th>
                                    <th class="border-bottom-0">User Name</th>
                                    <th class="border-bottom-0">Business Unit Name</th>
                                    <th class="border-bottom-0">Business Logo</th>
                                    <th class="border-bottom-0">Address</th>
                                    <th class="border-bottom-0">Status</th>
                                    <th class="border-bottom-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($businessUnits as $index => $unit)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $unit->user_name }}</td>
                                        <td>{{ $unit->business_unit_name }}</td>
                                        <td>
                                            <a href="{{ asset('storage/' . $unit->business_logo) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $unit->business_logo) }}" alt="Logo" width="50">
                                            </a>
                                        </td>
                                        
                                        <td>
                                            <button class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#addressModal{{ $unit->id }}">
                                                View Address
                                            </button>
                                        </td>
                                        <td>{{ $unit->status }}</td>
                                        <td>
                                            <form action="{{ route('admin.deleteBusinessUnit', $unit->id) }}" method="POST" id="deleteForm{{ $unit->id }}">
                                                @csrf
                                                <button type="button" class="btn btn-md btn-danger" onclick="confirmDelete({{ $unit->id }})">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                                <a href="{{ url('admin/edit-business-unit', $unit->id) }}" class="btn btn-md btn-primary">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Modal for Address Details -->
                                    <div class="modal fade" id="addressModal{{ $unit->id }}" tabindex="-1"
                                        aria-labelledby="addressModalLabel{{ $unit->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title" id="addressModalLabel{{ $unit->id }}">
                                                        <i class="fas fa-map-marker-alt"></i> Business Unit Address
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="p-3">
                                                        <p class="mb-2"><strong class="text-secondary">Full Address:</strong> 
                                                            <span class="text-dark">{{ $unit->full_address }}</span>
                                                        </p>
                                                        <p class="mb-2"><strong class="text-secondary">Locality:</strong> 
                                                            <span class="text-dark">{{ $unit->locality }}</span>
                                                        </p>
                                                        <p class="mb-2"><strong class="text-secondary">City:</strong> 
                                                            <span class="text-dark">{{ $unit->city }}</span>
                                                        </p>
                                                        <p class="mb-2"><strong class="text-secondary">State:</strong> 
                                                            <span class="text-dark">{{ $unit->state }}</span>
                                                        </p>
                                                        <p class="mb-2"><strong class="text-secondary">Country:</strong> 
                                                            <span class="text-dark">{{ $unit->country }}</span>
                                                        </p>
                                                        <p><strong class="text-secondary">Pincode:</strong> 
                                                            <span class="text-dark">{{ $unit->pincode }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="modal-footer bg-light">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        Close
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                @endforeach
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->
@endsection

@section('scripts')
    <!-- Internal Data tables -->
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/table-data.js') }}"></script>

    <!-- INTERNAL Select2 js -->
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        setTimeout(function() {
            document.getElementById('Message').style.display = 'none';
        }, 3000);
    </script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDelete(unitId) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form if the user confirms
                document.getElementById('deleteForm' + unitId).submit();
            }
        });
    }
</script>
@endsection
