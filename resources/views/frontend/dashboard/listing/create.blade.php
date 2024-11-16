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
                            <h4>Create Listing</h4>
                            <form action="{{ route('user.listing.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="my_listing_single">
                                            <label for="" class="d-flex justify-content-center">Image</label>
                                            <div id="image-preview" class="profile_pic_upload">
                                                <img id="image-label" class="img-fluid w-100" src="" alt="image"
                                                    style="display: none;" />
                                                <input type="file" name="image" id="image-upload" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="my_listing_single">
                                            <label for="" class="d-flex justify-content-center">Thumbnail</label>
                                            <div id="image-preview-2" class="profile_pic_upload">
                                                <img id="image-label-2" class="img-fluid w-100" alt="thumbnail image"
                                                    src="" style="display: none;" />
                                                <input type="file" id="image-upload-2" name="thumbnail" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="my_listing_single">
                                            <label for="">Title <span class="text-danger">*</span></label>
                                            <div class="input_area">
                                                <input type="text" class="form-control" name="title" required>
                                                {{-- Thêm vào trường hidden và nhập giá trị đã khởi tạo rules ở đây với value phải bằng 0 --}}
                                                <input type="hidden" name="listing" value=0>
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
                                                            <option value="{{ $category->id }}">{{ $category->name }}
                                                            </option>
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
                                                            <option value="{{ $location->id }}">{{ $location->name }}
                                                            </option>
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
                                                <input type="email" name="email" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="my_listing_single">
                                            <label for="">Phone Number <span class="text-danger">*</span></label>
                                            <div class="input_area">
                                                <input type="text" name="phonenumber" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="my_listing_single">
                                            <label for="">Address <span class="text-danger">*</span></label>
                                            <div class="input_area">
                                                <input type="text" name="address" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="my_listing_single">
                                            <label for="">Website</label>
                                            <div class="input_area">
                                                <input type="text" name="website">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="my_listing_single">
                                            <label for="">Facebook URL</label>
                                            <div class="input_area">
                                                <input type="text" name="fb_url">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="my_listing_single">
                                            <label for="">X URL</label>
                                            <div class="input_area">
                                                <input type="text" name="x_url">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="my_listing_single">
                                            <label for="">LinkedIn URL</label>
                                            <div class="input_area">
                                                <input type="text" name="linked_url">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="my_listing_single">
                                            <label for="">Instagram URL</label>
                                            <div class="input_area">
                                                <input type="text" name="insta_url">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="my_listing_single">
                                            <label>File</label>
                                            <div class="input_area input_area_2">
                                                <input type="file" name="attachment" id="inputGroupFile04"
                                                    aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        @if ($membership->package->limit_facilities === -1)
                                            <label>Facilities <span class="text-danger">(Unlimited)</span></label>
                                        @else
                                            <label>Facilities <span class="text-danger">(Maximum
                                                    Facility -
                                                    {{ $membership->package->limit_facilities }})</span></label>
                                        @endif
                                        <div class="row">
                                            @foreach ($facilities as $facility)
                                                <div class="col-xl-6 col-xxl-4 col-md-6">
                                                    <div class="facilities_check_area">
                                                        <div class="wsus__pro_check">
                                                            <div class="form-check">
                                                                <!-- Liên kết checkbox với facility id -->
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="{{ $facility->id }}"
                                                                    id="flexCheck{{ $facility->id }}" name="facilities[]">
                                                                <label class="form-check-label"
                                                                    for="flexCheck{{ $facility->id }}">
                                                                    {{ $facility->name }}
                                                                    <!-- Hiển thị tên của facility -->
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
                                            <textarea name="description" id="summernote" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="my_listing_single">
                                            <label>Map Embed Code <span class="text-danger">*</span></label>
                                            <div class="input_area input_area_2">
                                                <textarea name="map_embed_code" cols="30" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="my_listing_single">
                                            <label for="">Seo Title</label>
                                            <div class="input_area input_area_2">
                                                <input name="seo_title" type="text">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="my_listing_single">
                                            <label for="">Seo Description</label>
                                            <div class="input_area input_area_2">
                                                <textarea name="seo_description" cols="30" rows="10"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="my_listing_single">
                                            <label for="">Status <span class="text-danger">*</span></label>
                                            <div class="input_area">
                                                <div class="wsus__search_area">
                                                    <select name="status" id="status" class="select_2">
                                                        <option value="1">Active</option>
                                                        <option value="0">Hide</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="my_listing_single">
                                            <label for="">Is Featured <span class="text-danger">*</span></label>
                                            <div class="input_area">
                                                <div class="wsus__search_area">
                                                    <select name="is_featured" id="is_featured" class="select_2">
                                                        <option value="0">No</option>
                                                        <option value="1">Yes</option>
                                                    </select>
                                                </div>
                                            </div>
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
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 300,
            });
        });
    </script>
@endpush
