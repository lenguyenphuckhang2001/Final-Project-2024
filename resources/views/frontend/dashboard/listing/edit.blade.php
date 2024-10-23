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
                            <h4>Edit Listing</h4>
                            <form action="{{ route('user.listing.update', $listing->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="my_listing_single">
                                            <label for="" class="d-flex justify-content-center">Image</label>
                                            <div id="image-preview"
                                                class="profile_pic_upload image-preview image-listing-preview">
                                                <img id="image-label" class="img-fluid w-100" alt="Image Preview"
                                                    src="{{ $listing->image }}" />
                                                <input type="file" name="image" id="image-upload" />
                                                <input type="hidden" name="old_image" id="image-upload"
                                                    value="{{ $listing->image }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="my_listing_single">
                                            <label for="" class="d-flex justify-content-center">Thumbnail</label>
                                            <div id="image-preview-2"
                                                class="profile_pic_upload image-preview thumbnail-preview">
                                                <img id="image-label-2" class="img-fluid w-100" alt="Image Preview"
                                                    src="{{ $listing->thumbnail }}" />
                                                <input type="file" id="image-upload-2" name="thumbnail" />
                                                <input type="hidden" name="old_thumbnail" id="image-upload"
                                                    value="{{ $listing->thumbnail }}" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Title <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="title"
                                                value="{{ $listing->title }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Category <span class="text-danger">*</span></label>
                                            <select name="category" class="form-control" required>
                                                <option value="" selected disabled>Select</option>
                                                $@foreach ($categories as $category)
                                                    <option @selected($category->id === $listing->category_id) value="{{ $category->id }}">
                                                        {{ $category->name }}</option>
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
                                                    <option @selected($location->id === $listing->location_id) value="{{ $location->id }}">
                                                        {{ $location->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" name="email"
                                                value="{{ $listing->email }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Phone Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="phonenumber"
                                                value="{{ $listing->phonenumber }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Address <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="address"
                                                value="{{ $listing->address }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Website</label>
                                            <input type="text" class="form-control" name="website"
                                                value="{{ $listing->website }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Facebook URL</label>
                                            <input type="text" class="form-control" name="fb_url"
                                                value="{{ $listing->fb_url }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">X URL</label>
                                            <input type="text" class="form-control" name="x_url"
                                                value="{{ $listing->x_url }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">LinkedIn URL</label>
                                            <input type="text" class="form-control" name="linked_url"
                                                value="{{ $listing->linked_url }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Instagram URL</label>
                                            <input type="text" class="form-control" name="insta_url"
                                                value="{{ $listing->insta_url }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">File
                                                @if (!empty($listing->file))
                                                    <span class="text-danger">
                                                        (File already exists)
                                                    </span>
                                                @endif
                                            </label>
                                            <input type="file" class="form-control" name="attachment">
                                            <input type="hidden" name="old_attachment" id="image-upload"
                                                value="{{ $listing->file }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Amenities
                                                @if (count($amenities) > $subscription->package->limit_amenities)
                                                    <span class="text-danger">(Your maximum amenities is
                                                        {{ $subscription->package->limit_amenities }})
                                                    </span>
                                                @endif
                                            </label>
                                            <select class="form-control select2" multiple="" name="amenities[]">
                                                $@foreach ($amenities as $amenity)
                                                    <option value="{{ $amenity->id }}">{{ $amenity->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Description <span class="text-danger">*</span></label>
                                            <textarea name="description" class="summernote" cols="30" rows="10" required>{!! $listing->description !!}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Map Embed Code <span class="text-danger">*</span></label>
                                            <textarea name="map_embed_code" class="form-control" cols="30" rows="10">{!! $listing->map_embed_code !!}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Seo Title</label>
                                            <input name="seo_title" type="text" class="form-control"
                                                value="{{ $listing->seo_title }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Seo Description</label>
                                            <textarea name="seo_description" class="form-control" cols="30" rows="10"> {!! $listing->seo_description !!}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Status</label>
                                            <select name="status" id="status" class="form-control">
                                                <option @selected($listing->status === 1) value="1">Active</option>
                                                <option @selected($listing->status === 0) value="0">Hide</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Is Featured</label>
                                            <select name="is_featured" id="is_featured" class="form-control">
                                                <option @selected($listing->is_featured === 0) value="0">No</option>
                                                <option @selected($listing->is_featured === 1) value="1">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="read_btn">Edit</button>
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

        // Chuyển đổi mảng PHP $listingAmenities thành chuỗi JSON và lưu vào biến JavaScript
        var listingAmenities = {!! json_encode($listingAmenities) !!};

        // Khởi tạo Select2 cho các phần tử có class 'select2'
        // Thiết lập giá trị của dropdown bằng các amenity_id từ biến listingAmenities
        // Kích hoạt sự kiện 'change' để cập nhật giao diện hoặc thực hiện hành động khác
        $('.select2').select2().val(listingAmenities).trigger("change");

        $(document).ready(function() {
            $('.image-listing-preview').css({
                'background-image': 'url({{ asset($listing->image) }})',
                'background-position': 'center center',
                'background-size': 'cover'
            })

            $('.thumbnail-preview').css({
                'background-image': 'url({{ asset($listing->thumbnail) }})',
                'background-position': 'center center',
                'background-size': 'cover'
            });
        })
    </script>
@endpush
