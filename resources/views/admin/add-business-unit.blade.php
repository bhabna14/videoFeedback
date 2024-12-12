@extends('layouts.app')

@section('styles')
    <!-- Internal Select2 css -->
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">ADD BUSINESS UNIT OF {{ $businessName }}</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb d-flex justify-content-between align-items-center">
                <li class="breadcrumb-item tx-15"><a href="{{ url('admin/manage-product') }}"
                        class="btn btn-warning text-dark">Manage Business Unit</a></li>
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active tx-15" aria-current="page">Unit</li>
            </ol>
        </div>
    </div>
    <!-- /breadcrumb -->

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session()->has('success'))
        <div class="alert alert-success" id="Message">
            {{ session()->get('success') }}
        </div>
    @endif

    @if ($errors->has('danger'))
        <div class="alert alert-danger" id="Message">
            {{ $errors->first('danger') }}
        </div>
    @endif

    <form action="{{ route('admin.save-business-unit') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
          
        
            <!-- Business Unit Name -->
            <div class="col-md-4 mb-3">
                <label for="business_unit_name" class="form-label">Business Unit Name</label>
                <input type="text" name="business_unit_name" class="form-control" id="business_unit_name" placeholder="Enter Unit Name" required>
            </div>
        
            <!-- Business Logo -->
            <div class="col-md-4 mb-3">
                <label for="business_logo" class="form-label">Business Logo</label>
                <input type="file" name="business_logo" class="form-control" id="business_logo" required>
            </div>
        
            <!-- Mobile Number -->
            <div class="col-md-4 mb-3">
                <label for="mobile_number" class="form-label">Mobile Number</label>
                <input type="number" name="mobile_number" class="form-control" id="mobile_number" placeholder="Enter mobile number">
            </div>
        
            <!-- WhatsApp Number -->
            <div class="col-md-4 mb-3">
                <label for="whatsapp_number" class="form-label">WhatsApp Number</label>
                <input type="number" name="whatsapp_number" class="form-control" id="whatsapp_number" placeholder="Enter WhatsApp number">
            </div>

            <div class="col-md-4 mb-3">
                <label for="user_name" class="form-label">User Name</label>
                <input type="text" name="user_name" class="form-control" id="user_name" placeholder="Enter User Name">
            </div>

            <div class="col-md-4 mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="text" name="password" class="form-control" id="password" placeholder="Enter Password">
            </div>
        
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>ADDRESS DETAILS</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Locality -->
                            <div class="col-md-4 mb-3">
                                <label for="locality" class="form-label">Locality</label>
                                <input type="text" name="locality" class="form-control" id="locality" placeholder="Enter locality">
                            </div>
    
                            <!-- Pincode -->
                            <div class="col-md-4 mb-3">
                                <label for="pincode" class="form-label">Pincode</label>
                                <input type="number" name="pincode" class="form-control" id="pincode" placeholder="Enter pincode">
                            </div>
    
                            <!-- City -->
                            <div class="col-md-4 mb-3">
                                <label for="city" class="form-label">City</label>
                                <input type="text" name="city" class="form-control" id="city" placeholder="Enter city">
                            </div>
    
                            <!-- Town -->
                            <div class="col-md-4 mb-3">
                                <label for="town" class="form-label">Town</label>
                                <input type="text" name="town" class="form-control" id="town" placeholder="Enter town">
                            </div>
    
                            <!-- State -->
                            <div class="col-md-4 mb-3">
                                <label for="state" class="form-label">State</label>
                                <input type="text" name="state" class="form-control" id="state" placeholder="Enter state">
                            </div>
    
                            <!-- Country -->
                            <div class="col-md-4 mb-3">
                                <label for="country" class="form-label">Country</label>
                                <input type="text" name="country" class="form-control" id="country" placeholder="Enter country">
                            </div>
    
                            <!-- Full Address -->
                            <div class="col-md-12 mb-3">
                                <label for="full_address" class="form-label">Full Address</label>
                                <textarea name="full_address" class="form-control" id="full_address" rows="3" placeholder="Enter full address"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <!-- Submit Button -->
            <div class="col-12 mt-4">
                <button type="submit" class="btn btn-primary w-100">Submit</button>
            </div>
        </div>
        
    </form>
@endsection

@section('modal')
@endsection

@section('scripts')
    <!-- Form-layouts js -->
    <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2(); // Initialize Select2 for dropdowns
        });
    </script>
@endsection
