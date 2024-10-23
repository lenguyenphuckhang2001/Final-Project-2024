@extends('frontend.layouts.main')

@push('styles')
    <style>
        /* Dashboard Section */
        #dashboard {
            padding: 40px 0;
            background-color: #f8f9fa;
            /* Light background for the entire dashboard */
        }

        /* Form Group Styles */
        .form-group {
            margin-bottom: 25px;
            /* Space between form groups */
        }

        /* Label Styles */
        label {
            font-weight: 600;
            /* Bold font for labels */
            color: #343a40;
            /* Darker color for better contrast */
        }

        /* Text Input Styles */
        .form-control {
            border-radius: 8px;
            /* Rounded corners */
            border: 1px solid #ced4da;
            /* Border color */
            transition: border-color 0.2s, box-shadow 0.2s;
            /* Smooth transition for focus */
        }

        .form-control:focus {
            border-color: #007bff;
            /* Change border color on focus */
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.25);
            /* Add shadow on focus */
        }

        /* Textarea Styles */
        textarea.form-control {
            border-radius: 8px;
            /* Rounded corners */
        }

        /* Select Styles */
        select.form-control {
            border-radius: 8px;
            /* Rounded corners */
            appearance: none;
            /* Remove default styling */
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="%23000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>') no-repeat;
            /* Add custom arrow */
            background-position: right 10px center;
            /* Position the arrow */
            background-size: 12px;
            /* Size of the arrow */
            padding-right: 30px;
            /* Space for the arrow */
        }

        /* Button Styles */
        .read_btn {
            background: linear-gradient(90deg, #007bff, #0056b3);
            /* Gradient background */
            color: #ffffff;
            /* White text color */
            padding: 12px 20px;
            /* Padding for the button */
            border: none;
            /* Remove border */
            border-radius: 8px;
            /* Rounded corners */
            font-size: 18px;
            /* Increased font size */
            font-weight: bold;
            /* Bold font weight */
            cursor: pointer;
            /* Change cursor on hover */
            transition: background 0.3s, transform 0.2s;
            /* Smooth transitions */
            display: block;
            /* Block display for centering */
            width: 100%;
            /* Full width for the button */
        }

        .read_btn:hover {
            background: linear-gradient(90deg, #0056b3, #003f7f);
            /* Darker gradient on hover */
            transform: translateY(-2px);
            /* Lift effect on hover */
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .col-md-6 {
                margin-bottom: 20px;
                /* Reduce space for smaller screens */
            }
        }
    </style>
@endpush

@section('contents')
    <section id="dashboard">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    @include('frontend.dashboard.sidebar')
                </div>
                <div class="col-lg-9">
                    <div class="dashboard_content">
                        <div class="my_listing mb-3">
                            <a href="{{ route('user.listing.index') }}" class="mb-4">
                                <button type="button" class="btn btn-outline-dark">
                                    <i class="fas fa-chevron-left"></i>
                                    Back
                                </button>
                            </a>
                            <h4>Image Gallery | ({{ $titleListing->title }})</h4>
                            <div class="card-body">
                                <form action="{{ route('user.image-gallery.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="" class="mb-2">Image <span class="text-primary">(Can uploads
                                                multiple images)</span></label>
                                        <input type="file" class="form-control" name="images[]" multiple />
                                        <!--Sử dụng request() helper để lấy giá trị listing_id từ yêu cầu -->
                                        <input type="hidden" value="{{ request()->id }}" name="listing_id">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="read_btn">Upload Image</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="my_listing">
                            <h4>All Image Gallery</h4>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-md">
                                        <tr>
                                            <th>#</th>
                                            <th>Image</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($images as $image)
                                            <tr>
                                                <th scope='row'>{{ ++$loop->index }}</th>
                                                <td>
                                                    <img style='width: 150px !important' src="{{ asset($image->image) }}"
                                                        alt="">
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('user.image-gallery.destroy', $image->id) }}"
                                                        class="delete-item btn btn-lg btn-danger"><i
                                                            class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.summernote').summernote();
        });

        $('.select2').select2();
    </script>
@endpush
