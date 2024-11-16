@extends('frontend.layouts.main')

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
                                                    src="{{ asset($listing->image) }}" />
                                                <input type="file" name="image" id="image-upload" />
                                                <input type="hidden" name="previous_image" id="image-upload"
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
                                                    src="{{ asset($listing->thumbnail) }}" />
                                                <input type="file" id="image-upload-2" name="thumbnail" />
                                                <input type="hidden" name="previous_thumbnail" id="image-upload"
                                                    value="{{ $listing->thumbnail }}" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="my_listing_single">
                                            <label for="">Title <span class="text-danger">*</span></label>
                                            <div class="input_area">
                                                <input type="text" name="title" value="{{ $listing->title }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="my_listing_single">
                                            <label for="">Category <span class="text-danger">*</span></label>
                                            <div class="input_area">
                                                <div class="wsus__search_area">
                                                    <select name="category" class="select_2" required>
                                                        $@foreach ($categories as $category)
                                                            <option @selected($category->id === $listing->category_id)
                                                                value="{{ $category->id }}">
                                                                {{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="my_listing_single">
                                            <label for="">Location <span class="text-danger">*</span></label>
                                            <div class="input_area">
                                                <div class="wsus__search_area">
                                                    <select name="location" class="select_2" required>
                                                        $@foreach ($locations as $location)
                                                            <option @selected($location->id === $listing->location_id)
                                                                value="{{ $location->id }}">
                                                                {{ $location->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="my_listing_single">
                                            <label for="">Email <span class="text-danger">*</span></label>
                                            <div class="input_area">
                                                <input type="email" name="email" value="{{ $listing->email }}"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="my_listing_single">
                                            <label for="">Phone Number <span class="text-danger">*</span></label>
                                            <div class="input_area">
                                                <input type="text" name="phonenumber"
                                                    value="{{ $listing->phonenumber }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="my_listing_single">
                                            <label for="">Address <span class="text-danger">*</span></label>
                                            <div class="input_area">
                                                <input type="text" name="address" value="{{ $listing->address }}"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="my_listing_single">
                                            <label for="">Website</label>
                                            <div class="input_area">
                                                <input type="text" name="website" value="{{ $listing->website }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="my_listing_single">
                                            <label for="">Facebook URL</label>
                                            <div class="input_area">
                                                <input type="text" name="fb_url" value="{{ $listing->fb_url }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="my_listing_single">
                                            <label for="">X URL</label>
                                            <div class="input_area">
                                                <input type="text" name="x_url" value="{{ $listing->x_url }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="my_listing_single">
                                            <label for="">LinkedIn URL</label>
                                            <div class="input_area">
                                                <input type="text" name="linked_url"
                                                    value="{{ $listing->linked_url }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="my_listing_single">
                                            <div class="input_area">
                                                <label for="">Instagram URL</label>
                                                <input type="text" name="insta_url"
                                                    value="{{ $listing->insta_url }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="my_listing_single">
                                            <label for="">File
                                                @if (!empty($listing->file))
                                                    <span class="text-danger">
                                                        (File already exists)
                                                    </span>
                                                @endif
                                            </label>
                                            <div class="input_area input_area_2">
                                                <input type="file" name="attachment" id="inputGroupFile04"
                                                    aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                                                <input type="hidden" name="previous_attachment" id="image-upload"
                                                    value="{{ $listing->file }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        @if ($membership->package->limit_facilities === -1)
                                            <label>Facilities <span class="text-danger">(Unlimited)</span></label>
                                        @else
                                            <label>Facilities <span class="text-danger">(Maximum Facility -
                                                    {{ $membership->package->limit_facilities }})</span></label>
                                        @endif
                                        <div class="row">
                                            @foreach ($facilities as $facility)
                                                <div class="col-xl-6 col-xxl-4 col-md-6">
                                                    <div class="facilities_check_area">
                                                        <div class="wsus__pro_check">
                                                            <div class="form-check">
                                                                <!-- Đánh dấu checkbox nếu facility đã có trong $listingFacilities -->
                                                                <input class="form-check-input select-facilities"
                                                                    type="checkbox" value="{{ $facility->id }}"
                                                                    id="flexCheck{{ $facility->id }}" name="facilities[]"
                                                                    {{ in_array($facility->id, $listingFacilities) ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="flexCheck{{ $facility->id }}">
                                                                    {{ $facility->name }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <i class="{{ $facility->icon }}"></i>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="my_listing_single">
                                            <label>Description <span class="text-danger">*</span></label>
                                            <textarea name="description" id="summernote" required>{!! $listing->description !!}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="my_listing_single">
                                            <label>Map Embed Code <span class="text-danger">*</span></label>
                                            <div class="input_area input_area_2">
                                                <textarea name="map_embed_code" cols="30" rows="10">{!! $listing->map_embed_code !!}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="my_listing_single">
                                            <label for="">Seo Title</label>
                                            <div class="input_area input_area_2">
                                                <input name="seo_title" type="text"
                                                    value="{{ $listing->seo_title }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="my_listing_single">
                                            <label for="">Seo Description</label>
                                            <div class="input_area input_area_2">
                                                <textarea name="seo_description" class="form-control" cols="30" rows="10"> {!! $listing->seo_description !!}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="my_listing_single">
                                            <label for="">Status</label>
                                            <div class="input_area">
                                                <div class="wsus__search_area">
                                                    <select name="status" id="status" class="select_2">
                                                        <option @selected($listing->status === 1) value="1">Active
                                                        </option>
                                                        <option @selected($listing->status === 0) value="0">Hide
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="my_listing_single">
                                            <label for="">Is Featured</label>
                                            <div class="input_area">
                                                <div class="wsus__search_area">
                                                    <select name="is_featured" id="is_featured" class="select_2">
                                                        <option @selected($listing->is_featured === 0) value="0">No</option>
                                                        <option @selected($listing->is_featured === 1) value="1">Yes
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
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
    <script>
        /**
         * Chuyển đổi mảng PHP $listingFacilities thành chuỗi JSON và lưu vào biến JavaScript. Sau đó sẽ in kết quả
         * này trực tiếp vào mã JavaScript để sử dụng biến listingFacilities với giá trị của nó từ phía server.
         * Ví dụ nếu biến PHP có giá trị là ['wifi', 'park'] thì listingFactilities sẽ là một mảng JSON ["wifi", "park"]
         *
         * $('.select-facilities') chọn phần tử HTML có class là .select-facilities
         * .val(listingFacilities) sẽ gán giá trị của listingFacilities cho dropdown
         * hàm trigger('change') kích hoạt sự kiện change để cập nhật giao diện cho người dùng
         */
        var listingFacilities = {!! json_encode($listingFacilities) !!};
        $('.select-facilities').val(listingFacilities).trigger("change");

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

            $('#summernote').summernote({
                height: 300,
            });
        })
    </script>
@endpush
