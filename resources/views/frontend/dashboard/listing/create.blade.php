@extends('frontend.layouts.main')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
    <style>
        /* Dashboard Section */
        #dashboard {
            padding: 40px 0;
            background-color: #f8f9fa;
            /* Light background for the entire dashboard */
        }

        /* Individual Listing Items */
        .my_listing_single {
            margin-bottom: 30px;
            /* Space between each listing item */
            text-align: center;
            /* Center align labels and images */
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

        /* Text Danger Styles */
        .text-danger {
            font-weight: bold;
            /* Make required field indicator bold */
            color: #dc3545;
            /* Bootstrap danger color */
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
                        <div class="my_listing">
                            <a href="{{ route('user.listing.index') }}" class="mb-4">
                                <button type="button" class="btn btn-outline-dark">
                                    <i class="fas fa-chevron-left"></i>
                                    Back
                                </button>
                            </a>
                            <h4>Create Listing</h4>
                            <form action="{{ route('user.listing.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="my_listing_single">
                                            <label for="image-upload" class="d-flex justify-content-center">Image</label>
                                            <div id="image-preview" class="profile_pic_upload image-preview">
                                                <img id="image-label" class="img-fluid w-100" src="" alt="image"
                                                    style="display: none;" />
                                                <input type="file" name="image" id="image-upload" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="my_listing_single">
                                            <label for="" class="d-flex justify-content-center">Thumbnail</label>
                                            <div id="image-preview-2" class="profile_pic_upload image-preview">
                                                <img id="image-label-2" class="img-fluid w-100" alt="thumbnail image"
                                                    src="" style="display: none;" />
                                                <input type="file" id="image-upload-2" name="thumbnail" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Title <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="title" required>
                                            {{-- Thêm vào trường hidden và nhập giá trị đã khởi tạo rules ở đây với value phải bằng 0 --}}
                                            <input type="hidden" name="listing" value=0>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Category <span class="text-danger">*</span></label>
                                            <select name="category" class="form-control" required>
                                                <option value="" selected disabled>Select</option>
                                                $@foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Location <span class="text-danger">*</span></label>
                                            <select name="location" class="form-control" required>
                                                <option value="" selected disabled>Select</option>
                                                $@foreach ($locations as $location)
                                                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" name="email" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Phone Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="phonenumber" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Address <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="address" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Website</label>
                                            <input type="text" class="form-control" name="website">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Facebook URL</label>
                                            <input type="text" class="form-control" name="fb_url">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">X URL</label>
                                            <input type="text" class="form-control" name="x_url">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">LinkedIn URL</label>
                                            <input type="text" class="form-control" name="linked_url">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Instagram URL</label>
                                            <input type="text" class="form-control" name="insta_url">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">File</label>
                                            <input type="file" class="form-control" name="attachment">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Facilities</label>
                                            <select class="form-control select2" multiple="" name="facilities[]">
                                                $@foreach ($facilities as $facility)
                                                    <option value="{{ $facility->id }}">{{ $facility->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Description <span class="text-danger">*</span></label>
                                            <textarea name="description" class="summernote" cols="30" rows="10" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Map Embed Code <span class="text-danger">*</span></label>
                                            <textarea name="map_embed_code" class="form-control" cols="30" rows="10"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Seo Title</label>
                                            <input name="seo_title" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Seo Description</label>
                                            <textarea name="seo_description" class="form-control" cols="30" rows="10"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Status <span class="text-danger">*</span></label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="1">Active</option>
                                                <option value="0">Hide</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Is Featured <span class="text-danger">*</span></label>
                                            <select name="is_featured" id="is_featured" class="form-control">
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-5">
                                    <button type="submit" class="read_btn">Create</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote();
        });

        $('.select2').select2();
    </script>
@endpush
