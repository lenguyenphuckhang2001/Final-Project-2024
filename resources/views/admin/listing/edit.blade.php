@extends('admin.layouts.main')

@section('contents')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.listing.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Edit Listing</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('admin.listing.index') }}">Listing</a></div>
                <div class="breadcrumb-item">Edit</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit</h4>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('admin.listing.update', $listing->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Image <span class="text-danger">*</span></label>
                                            <div id="image-preview" class="image-preview image-listing-preview">
                                                <label for="image-upload" id="image-label">Choose File</label>
                                                <input type="file" name="image" id="image-upload" />
                                                <input type="hidden" name="previous_image" id="image-upload"
                                                    value="{{ $listing->image }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Thumbnail <span class="text-danger">*</span></label>
                                            <div id="image-preview-2" class="image-preview thumbnail-preview">
                                                <label for="image-upload-2" id="image-label-2">Choose File</label>
                                                <input type="file" id="image-upload-2" name="thumbnail" />
                                                <input type="hidden" name="previous_thumbnail" id="image-upload"
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
                                            <input type="hidden" name="previous_attachment" id="image-upload"
                                                value="{{ $listing->file }}" />
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
                                            <textarea name="description" class="summernote" cols="30" rows="10">{!! $listing->description !!}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Map Embed Code <span class="text-danger">(Default Size Map:
                                                    1000x400)</span></label>
                                            <textarea name="map_embed_code" class="form-control" cols="30" rows="10"
                                                placeholder="Import code <iframe> here">{!! $listing->map_embed_code !!}</textarea>
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
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Status</label>
                                            <select name="status" id="status" class="form-control">
                                                <option @selected($listing->status === 1) value="1">Active</option>
                                                <option @selected($listing->status === 0) value="0">Hide</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Is Featured</label>
                                            <select name="is_featured" id="is_featured" class="form-control">
                                                <option @selected($listing->is_featured === 0) value="0">No</option>
                                                <option @selected($listing->is_featured === 1) value="1">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Is Verified</label>
                                            <select name="is_verified" id="is_verified" class="form-control">
                                                <option @selected($listing->is_verified === 0) value="0">No</option>
                                                <option @selected($listing->is_verified === 1) value="1">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Edit</button>
                                </div>
                            </form>
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
        // Chuyển đổi mảng PHP $listingFacilities thành chuỗi JSON và lưu vào biến JavaScript
        var listingFacilities = {!! json_encode($listingFacilities) !!};

        // Khởi tạo Select2 cho các phần tử có class 'select2'
        // Thiết lập giá trị của dropdown bằng các facility_id từ biến listingFacilities
        // Kích hoạt sự kiện 'change' để cập nhật giao diện hoặc thực hiện hành động khác
        $('.select2').select2().val(listingFacilities).trigger("change");

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
