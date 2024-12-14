@extends('layouts.app')

@section('styles')
    <!-- INTERNAL Select2 css -->
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- INTERNAL Data table css -->
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatable/css/buttons.bootstrap5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/datatable/responsive.bootstrap5.css') }}" rel="stylesheet" />

    <style>
        .social-media-icon {
            font-size: 24px;
            margin-right: 10px;
        }

        .social-media-icon.youtube {
            color: #FF0000;
        }

        .social-media-icon.twitter {
            color: #1DA1F2;
        }

        .social-media-icon.facebook {
            color: #3b5998;
        }

        .social-media-icon.instagram {
            color: #E4405F;
        }

        .social-media-icon.whatsapp {
            color: #25D366;
        }

        .social-media-icon.linkedin {
            color: #0077b5;
        }

        .social-media-icon.default {
            color: #6c757d;
        }
    </style>
@endsection

@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">DASHBOARD</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sales</li>
            </ol>
        </div>
    </div>
    <!-- /breadcrumb -->

    <!-- row -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-9 col-lg-7 col-md-6 col-sm-12">
                                    <div class="text-justified align-items-center">
                                        <h3 class="text-dark font-weight-semibold mb-2 mt-0">Hi, Welcome Back <span
                                                class="text-primary">{{ $businessName }}</span></h3>
                                        <p class="text-dark tx-14 mb-3 lh-3">You have used 85% of free plan storage. Please
                                            upgrade your plan to get unlimited storage.</p>
                                        <button class="btn btn-primary shadow">Upgrade Now</button>
                                    </div>
                                </div>
                                <div
                                    class="col-xl-3 col-lg-5 col-md-6 col-sm-12 d-flex align-items-center justify-content-center">
                                    <div class="chart-circle float-md-end mt-4 mt-md-0" data-value="0.85" data-thickness="8"
                                        data-color="">
                                        <canvas width="100" height="100"></canvas>
                                        <div class="chart-circle-value circle-style">
                                            <div class="tx-18 font-weight-semibold">85%</div>
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
    <!-- row closed -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif


    <!-- row  -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="card-title mb-0">Feedback Video Report</h4>
                </div>

                <form method="GET" class="p-4">
                    @csrf
                    <div class="row g-3">

                        <!-- Business Unit Name -->
                        <div class="col-md-3">
                            <label for="business_unit_id" class="form-label">Business Unit Name</label>
                            <select name="business_unit_id" id="business_unit_id" class="form-control">
                                <option value="All">All</option>
                                @foreach ($businessUnits as $unit)
                                    <option value="{{ $unit->business_unit_id }}"
                                        @if (request('business_unit_id') == $unit->business_unit_id) selected @endif>
                                        {{ $unit->business_unit_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- From Date -->
                        <div class="col-md-3">
                            <label for="from_date" class="form-label">From Date</label>
                            <input type="date" name="from_date" id="from_date" class="form-control"
                                value="{{ request('from_date') }}">
                        </div>

                        <!-- To Date -->
                        <div class="col-md-3">
                            <label for="to_date" class="form-label">To Date</label>
                            <input type="date" name="to_date" id="to_date" class="form-control"
                                value="{{ request('to_date') }}">
                        </div>

                        <!-- Submit Button -->
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                Search
                            </button>
                        </div>
                    </div>
                </form>

                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center mb-0" id="example1">
                            <thead class="table-primary">
                                <tr>
                                    <th class="text-center">Sl No.</th>
                                    <th>Business Unit Name</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Video</th>
                                    <th>Rating</th>
                                    <th>Comments</th>
                                    <th>Social Media</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($feedback_video as $index => $video)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $video->businessUnit->business_unit_name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($video->date)->format('d-m-Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($video->time)->format('h:i A') }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-warning" data-toggle="modal"
                                                data-target="#videoModal"
                                                onclick="openVideoModal('{{ asset('storage/' . $video->feedback_video) }}')">
                                                View Video
                                            </button>
                                        </td>

                                        <td>
                                            <!-- Like and Dislike Buttons -->
                                            <form action="{{ route('admin.saveRating', $video->id) }}" method="POST"
                                                id="ratingForm{{ $video->id }}">
                                                @csrf
                                                <button type="submit" name="rating" value="like"
                                                    class="btn btn-sm {{ $video->rating == 'like' ? 'btn-success' : 'btn-light' }}"
                                                    id="likeBtn{{ $video->id }}">
                                                    <i class="fa fa-thumbs-up"></i>
                                                </button>
                                                <button type="submit" name="rating" value="dislike"
                                                    class="btn btn-sm {{ $video->rating == 'dislike' ? 'btn-danger' : 'btn-light' }}"
                                                    id="dislikeBtn{{ $video->id }}">
                                                    <i class="fa fa-thumbs-down"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <!-- Add Comment Button -->
                                            <button class="btn btn-sm btn-primary" data-toggle="modal"
                                                data-target="#commentModal{{ $video->id }}">
                                                <i class="fa fa-edit"></i>
                                            </button>

                                            <!-- Modal for adding comment -->
                                            <div class="modal fade" id="commentModal{{ $video->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="commentModalLabel{{ $video->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="commentModalLabel{{ $video->id }}">Add Comment for
                                                                Video</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Comment Form -->
                                                            <form action="{{ route('admin.saveComment', $video->id) }}"
                                                                method="POST" id="commentForm{{ $video->id }}">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <textarea name="comments" class="form-control" placeholder="Enter your comment" rows="4">{{ $video->comments }}</textarea>
                                                                </div>
                                                                <button type="submit" class="btn btn-success">Save
                                                                    Comment</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <!-- Social Media Modal Trigger -->
                                            <button class="btn btn-sm btn-info" data-toggle="modal"
                                                data-target="#socialMediaModal{{ $video->id }}">
                                                <i class="fa fa-share-alt"></i>
                                            </button>

                                            <!-- Social Media Modal -->
                                            <div class="modal fade" id="socialMediaModal{{ $video->id }}"
                                                tabindex="-1" role="dialog"
                                                aria-labelledby="socialMediaModalLabel{{ $video->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="socialMediaModalLabel{{ $video->id }}">Social Media
                                                                Links</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Container for Icons -->
                                                            <div class="d-flex flex-wrap justify-content-center">
                                                                @foreach ($video->businessUnit->socialMedia as $socialMedia)
                                                                    <a href="{{ $socialMedia->social_media_link }}"
                                                                        target="_blank" class="m-2">
                                                                        @switch(strtolower($socialMedia->social_media_name))
                                                                            @case('facebook')
                                                                                <i class="fab fa-facebook"
                                                                                    style="color: #3b5998; font-size: 36px;"></i>
                                                                            @break

                                                                            @case('instagram')
                                                                                <i class="fab fa-instagram"
                                                                                    style="color: #E4405F; font-size: 36px;"></i>
                                                                            @break

                                                                            @case('twitter')
                                                                                <img src="{{ asset('assets/img/brand/twitter.png') }}"
                                                                                    alt="Twitter"
                                                                                    class="img-fluid social-logo me-2"
                                                                                    style="width: 36px; height: 36px;">
                                                                            @break

                                                                            @case('linkedin')
                                                                                <i class="fab fa-linkedin"
                                                                                    style="color: #0077b5; font-size: 36px;"></i>
                                                                            @break

                                                                            @case('youtube')
                                                                                <i class="fab fa-youtube"
                                                                                    style="color: #FF0000; font-size: 36px;"></i>
                                                                            @break

                                                                            @case('website')
                                                                                <i class="fas fa-globe"
                                                                                    style="color: #0d6efd; font-size: 36px;"></i>
                                                                                <!-- Changed icon color to blue -->
                                                                            @break

                                                                            @case('whatsapp')
                                                                                <i class="fab fa-whatsapp"
                                                                                    style="color: #25D366; font-size: 36px;"></i>
                                                                                <!-- Changed icon color to WhatsApp green -->
                                                                            @break

                                                                            @default
                                                                                <i class="fas fa-globe"
                                                                                    style="color: #6c757d; font-size: 36px;"></i>
                                                                        @endswitch
                                                                    </a>
                                                                @endforeach

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </td>

                                        <td class="d-flex justify-content-start">
                                            <!-- Disable Video -->
                                            <form action="{{ route('admin.disableVideoFeedback', $video->id) }}"
                                                method="POST" id="disabledForm{{ $video->id }}">
                                                @csrf
                                                <button type="button" class="btn btn-md btn-dark mr-2"
                                                    onclick="confirmDisabled({{ $video->id }})">
                                                    <i class="fa fa-eye-slash"></i>
                                                </button>
                                            </form>

                                            <!-- Delete Video -->
                                            <form action="{{ route('admin.deleteVideoFeedback', $video->id) }}"
                                                method="POST" id="deleteForm{{ $video->id }}">
                                                @csrf
                                                <button type="button" class="btn btn-md btn-danger"
                                                    style="margin-left: 5px"
                                                    onclick="confirmDelete({{ $video->id }})">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">No feedback videos available</td>
                                        </tr>
                                    @endforelse
                                </tbody>

                            </table>

                            <!-- Modal for Video -->
                            <div class="modal fade" id="videoModal" tabindex="-1" role="dialog"
                                aria-labelledby="videoModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-sm" role="document">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h5 class="modal-title" id="videoModalLabel">Video</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <!-- Video Player -->
                                            <video id="videoPlayer" controls class="w-100">
                                                <source id="videoSource" src="" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
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
        <!-- Internal Chart.Bundle js-->
        <script src="{{ asset('assets/plugins/chartjs/Chart.bundle.min.js') }}"></script>

        <!-- Moment js -->
        <script src="{{ asset('assets/plugins/raphael/raphael.min.js') }}"></script>

        <!-- INTERNAL Apexchart js -->
        <script src="{{ asset('assets/js/apexcharts.js') }}"></script>

        <!--Internal Sparkline js -->
        <script src="{{ asset('assets/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>

        <!--Internal  index js -->
        <script src="{{ asset('assets/js/index.js') }}"></script>

        <!-- Chart-circle js -->
        <script src="{{ asset('assets/js/chart-circle.js') }}"></script>

        <!-- Internal Data tables -->
        <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>

        <!-- INTERNAL Select2 js -->
        <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('assets/js/select2.js') }}"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            function confirmDisabled(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to disable this video feedback!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, disable it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit the form to disable the video
                        document.getElementById('disabledForm' + id).submit();
                        Swal.fire('Disabled!', 'The video has been disabled.', 'success');
                    }
                });
            }

            function confirmDelete(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to permanently delete this video feedback!",
                    icon: 'danger',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit the form to delete the video
                        document.getElementById('deleteForm' + id).submit();
                        Swal.fire('Deleted!', 'The video has been deleted.', 'success');
                    }
                });
            }
        </script>


        <!-- JavaScript to handle the button highlighting -->
        <script>
            function highlightButton(videoId, ratingType) {
                // Clear all buttons for this video
                const likeBtn = document.getElementById('likeBtn' + videoId);
                const dislikeBtn = document.getElementById('dislikeBtn' + videoId);

                if (ratingType === 'like') {
                    likeBtn.classList.add('btn-success');
                    likeBtn.classList.remove('btn-light');
                    dislikeBtn.classList.add('btn-light');
                    dislikeBtn.classList.remove('btn-danger');
                } else {
                    dislikeBtn.classList.add('btn-danger');
                    dislikeBtn.classList.remove('btn-light');
                    likeBtn.classList.add('btn-light');
                    likeBtn.classList.remove('btn-success');
                }
            }
        </script>
        <script>
            setTimeout(function() {
                document.getElementById('Message').style.display = 'none';
            }, 3000);
            setTimeout(function() {
                document.getElementById('Messages').style.display = 'none';
            }, 3000);
        </script>

        <script>
            // Function to open the modal and set the video source
            function openVideoModal(videoUrl) {
                var videoPlayer = document.getElementById('videoPlayer');
                var videoSource = document.getElementById('videoSource');

                // Set the video source URL (ensure it's correct and accessible)
                videoSource.src = videoUrl;
                videoPlayer.load(); // Load the new video into the player

                // If the video doesn't load, show an error message
                videoPlayer.onerror = function() {
                    alert('Error loading video. Please try again.');
                };
            }
        </script>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            function saveRating(videoId, rating) {
                let likeBtn = document.getElementById(`likeBtn${videoId}`);
                let dislikeBtn = document.getElementById(`dislikeBtn${videoId}`);

                // Send AJAX request
                fetch(`{{ url('admin/saveRating') }}/${videoId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            rating: rating
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update button colors
                            if (rating === 'like') {
                                likeBtn.classList.add('btn-success');
                                likeBtn.classList.remove('btn-light');
                                dislikeBtn.classList.add('btn-light');
                                dislikeBtn.classList.remove('btn-danger');
                            } else {
                                dislikeBtn.classList.add('btn-danger');
                                dislikeBtn.classList.remove('btn-light');
                                likeBtn.classList.add('btn-light');
                                likeBtn.classList.remove('btn-success');
                            }
                        } else {
                            alert('Error saving rating. Please try again.');
                        }
                    });
            }

            function saveComment(videoId) {
                let commentInput = document.getElementById(`commentInput${videoId}`);
                let commentValue = commentInput.value;

                // Send AJAX request
                fetch(`{{ url('admin/saveComment') }}/${videoId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            comments: commentValue
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Comment saved successfully!');
                            commentInput.value = data.comment; // Update input with saved comment
                        } else {
                            alert('Error saving comment. Please try again.');
                        }
                    });
            }
        </script>

        <script>
            setTimeout(function() {
                var successMessage = document.getElementById('successMessage');
                if (successMessage) {
                    successMessage.style.display = 'none';
                }

                var errorMessage = document.getElementById('errorMessage');
                if (errorMessage) {
                    errorMessage.style.display = 'none';
                }
            }, 5000); // 5000ms = 5 seconds
        </script>

        <script>
            $(document).on('submit', '#commentForm{{ $video->id }}', function(e) {
                e.preventDefault(); // Prevent form submission
                var form = $(this);
                $.ajax({
                    type: 'POST',
                    url: form.attr('action'),
                    data: form.serialize(),
                    success: function(response) {
                        $('#commentModal{{ $video->id }}').modal('hide'); // Hide modal after saving
                        alert('Comment saved successfully!');
                        // Optionally, update the comment in the table or perform other actions
                    },
                    error: function(error) {
                        alert('Error saving comment. Please try again.');
                    }
                });
            });
        </script>
    @endsection
