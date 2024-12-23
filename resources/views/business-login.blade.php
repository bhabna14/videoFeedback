@extends('layouts.custom-app')

    @section('styles')

    @endsection

    @section('class')

        <div class="bg-primary">

    @endsection

    @section('content')

    <div class="page-single">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-6 col-md-8 col-sm-8 col-xs-10 card-sigin-main py-45 justify-content-center mx-auto">
                    <div class="card-sigin mt-5 mt-md-0">
                        <!-- Demo content -->
                        <div class="main-card-signin d-md-flex">
                            <div class="wd-100p">
                                <div class="d-flex mb-4">
                                    <a href="{{url('index')}}">
                                        <img src="{{asset('assets/img/brand/favicon.png')}}" class="sign-favicon ht-40" alt="logo">
                                    </a>
                                </div>
                                <div class="">
                                    <div class="main-signup-header">
                                        <h2 class="text-dark">Login Your Business Unit</h2>
                                        
                                        <!-- Display Success Message -->
                                        @if(session('success'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                {{ session('success') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        @endif
    
                                        <!-- Display Error Messages -->
                                        @if(session('error'))
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                {{ session('error') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        @endif
    
                                        <!-- Display Validation Errors -->
                                        @if($errors->any())
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <ul>
                                                    @foreach($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        @endif
    
                                        <form action="{{ url('/admin/dash-board') }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label>User Name</label>
                                                <input class="form-control" placeholder="Enter User Name" type="text" name="user_name" required>
                                            </div>
                                        
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input class="form-control" placeholder="Enter your password" type="password" name="password" required>
                                            </div>
                                        
                                            <button type="submit" class="btn btn-primary btn-block">Log In</button>
                                        </form>
                                        
                                        <div class="main-signup-footer mt-3 text-center">
                                            <p>Don't have an account? <a href="{{url('/')}}">Sign Up</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    @endsection

    @section('scripts')

    @endsection
