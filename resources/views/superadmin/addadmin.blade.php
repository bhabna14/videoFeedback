@extends('superadmin.layouts.app')

    @section('styles')

		<!--- Internal Select2 css-->
		<link href="{{asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">

    @endsection

    @section('content')

					<!-- breadcrumb -->
					<div class="breadcrumb-header justify-content-between">
						<div class="left-content">
						  <span class="main-content-title mg-b-0 mg-b-lg-1">MANAGE ADMIN</span>
						</div>
						<div class="justify-content-center mt-2">
							<ol class="breadcrumb">
                            <a href="{{url('superadmin/businesslist')}}" class="btn btn-primary btn-style">Admin List</a>

								<li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
								<li class="breadcrumb-item active" aria-current="page">MANAGE ADMIN</li>
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
                   <!-- Display Success or Error Messages -->
                   @if(session('success'))
                   <div class="alert alert-success alert-dismissible fade show" role="alert">
                       {{ session('success') }}
                       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                   </div>
               @endif

               @if(session('error'))
                   <div class="alert alert-danger alert-dismissible fade show" role="alert">
                       {{ session('error') }}
                       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                   </div>
               @endif

               <form action="{{ url('/save-business-register') }}" method="post" enctype="multipart/form-data">
                   @csrf
                   <div class="form-group">
                       <label>Registered Business Name</label>
                       <input class="form-control" placeholder="Enter your business name" type="text" name="business_name" required>
                   </div>

                   <div class="form-group">
                       <label>Mobile Number</label>
                       <input class="form-control" placeholder="Enter your mobile number" type="text" name="mobile_number" required>
                   </div>

                   <div class="form-group">
                       <label>Email</label>
                       <input class="form-control" placeholder="Enter your email" type="email" name="email" required>
                   </div>
                   <div class="form-group">
                       <label>User Name</label>
                       <input class="form-control" placeholder="Enter your user name" type="text" name="user_name" required>
                   </div>
                   <div class="form-group">
                       <label>Password</label>
                       <input class="form-control" placeholder="Enter your password" type="password" name="password" required>
                   </div>

                   <button type="submit" class="btn btn-primary btn-block">Create Account</button>
               </form>

                    

                         
							
					</div>
					

                    
					

                    @endsection

                    @section('modal')
                  

                    @endsection

    @section('scripts')

		<!-- Form-layouts js -->
		<script src="{{asset('assets/js/form-layouts.js')}}"></script>

		<!--Internal  Select2 js -->
		<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>

        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
<script>

        $(document).ready(function() {
            $("#addInput").click(function() {
                $("#show_item").append(` <div class="row input-wrapper">
                                                    <div class="col-md-6" >
                                                        <div class="form-group">
                                                            <label for="exampleInputPassword1">Children name</label>
                                                            <input type="text" class="form-control" name="childrenname[]" id="exampleInputPassword1" placeholder="Enter Children name">
                                                        </div>
                                                        
                                                    </div>
                                                

                                                    <div class="col-md-6">
                                                        <div class="form-group mt-4">
                                                            <button class="btn btn-danger removeInput" id="addInput">Remove</button>
                                                        </div>
                                                        
                                                    </div>
                                                </div>`);
            });

            $(document).on('click', '.removeInput', function() {
                $(this).closest('.input-wrapper').remove(); // Use closest() to find the closest parent div with class input-wrapper and remove it
            });
        });


        $(document).ready(function() {
            $("#adddoc").click(function() {
                $("#show_doc_item").append(` <div class="row input-wrapper_doc">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Select ID Proof</label>
                                                            <select name="idproof[]" class="form-control" id="">
                                                                <option value="adhar">Adhar Card</option>
                                                                <option value="voter">Voter Card</option>
                                                                <option value="pan">Pan Card</option>
                                                                <option value="DL">DL</option>
                                                                <option value="health card">Health Card</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="exampleInputPassword1">Number</label>
                                                            <input type="text" name="idnumber[]" class="form-control" id="exampleInputPassword1" placeholder="Enter Number">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="exampleInputPassword1">Upload Document</label>
                                                            <input type="file" name="uploadoc[]" class="form-control" id="exampleInputPassword1" placeholder="">
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="col-md-6">
                                                            <div class="form-group">
                                                                <button class="btn btn-danger remove_doc" >Remove</button>
                                                            </div>
                                                            
                                                    </div>
                                                </div>`);
            });

            $(document).on('click', '.remove_doc', function() {
                $(this).closest('.input-wrapper_doc').remove(); // Use closest() to find the closest parent div with class input-wrapper and remove it
            });
        });
</script>


    @endsection
