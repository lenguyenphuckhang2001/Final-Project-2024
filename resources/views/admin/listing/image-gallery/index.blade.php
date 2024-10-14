@extends('admin.layouts.main')

@section('contents')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.listing.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Listing | Image Gallery</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('admin.listing.index') }}">Listing</a></div>
                <div class="breadcrumb-item">Image Gallery</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Image Gallery | Title Listing: <span class="text-danger">{{ $titleListing->title }}</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.image-gallery.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="">Image <span class="text-primary">(Multiple photos can be
                                            uploaded)</span></label>

                                    <input type="file" class="form-control" name="images[]" multiple />
                                    <!--Sử dụng request() helper để lấy giá trị listing_id từ yêu cầu -->
                                    <input type="hidden" value="{{ request()->id }}" name="listing_id">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Upload Image</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>All Images</h4>
                        </div>
                        <div class="card-body">
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
                                                    <img width="150px" src="{{ asset($image->image) }}" alt="">
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.image-gallery.destroy', $image->id) }}"
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
@endpush
