@extends('admin.layouts.main')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Update About Us</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Update</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Update</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.about-us.update') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Small Image </label>
                                            <div id="image-preview" class="image-preview small-img">
                                                <label for="image-upload" id="image-label">Choose File</label>
                                                <input type="file" name="image_small" id="image-upload" />
                                                <input type="hidden" name="previous_small_image"
                                                    value="{{ $aboutUs?->image_small }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Image Cover Video</label>
                                                    <div id="image-preview-2" class="image-preview video-img">
                                                        <label for="image-upload-2" id="image-label-2">Choose File</label>
                                                        <input type="file" name="image_video" id="image-upload-2" />
                                                        <input type="hidden" name="previous_image_video"
                                                            value="{{ $aboutUs?->image_video }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Youtube Video URL <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="video_url"
                                                        value="{{ $aboutUs?->video_url }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Title <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="title"
                                                value="{{ $aboutUs?->title }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Content <span class="text-danger">*</span></label>
                                            <textarea name="content" class="summernote" cols="30" rows="10">{{ $aboutUs?->content }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Save</button>
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
            $('.small-img').css({
                'background-image': 'url({{ asset($aboutUs?->image_small) }})',
                'background-position': 'center center',
                'background-repeat': 'no-repeat',
                'background-size': 'cover'
            })

            $('.video-img').css({
                'background-image': 'url({{ asset($aboutUs?->image_video) }})',
                'background-position': 'center center',
                'background-repeat': 'no-repeat',
                'background-size': 'cover'
            })
        })
    </script>
@endpush
