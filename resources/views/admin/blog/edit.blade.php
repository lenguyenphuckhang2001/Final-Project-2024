@extends('admin.layouts.main')

@section('contents')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.blog.index') }}" class="btn btn-icon">
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
            <h1>Edit Blog</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard.index') }}">Dashboard</a>
                </div>
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.blog.index') }}">Blogs</a>
                </div>
                <div class="breadcrumb-item">Edit Blog</div>
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
                            <form action="{{ route('admin.blog.update', $blog->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Thumbnail</label>
                                            <div id="image-preview-2" class="image-preview thumbnail-image">
                                                <label for="image-upload-2" id="image-label-2">Choose File</label>
                                                <input type="file" name="thumbnail" id="image-upload-2" />
                                                <input type="hidden" name="previous_thumbnail"
                                                    value="{{ $blog->thumbnail }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- Image Upload -->
                                        <div class="form-group">
                                            <label for="">Image</label>
                                            <div id="image-preview" class="image-preview blog-image">
                                                <label for="image-upload" id="image-label">Choose File</label>
                                                <input type="file" name="image" id="image-upload" />
                                                <input type="hidden" name="previous_image" value="{{ $blog->image }}">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Topic Selection -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Topics <span class="text-danger">*</span></label>
                                            <select name="topic" class="form-control" required>
                                                <option value="" selected disabled>Select</option>
                                                @foreach ($topics as $topic)
                                                    <option @selected($blog->topic_id === $topic->id) value="{{ $topic->id }}">
                                                        {{ $topic->topic }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Title Input -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Title <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="title"
                                                value="{{ $blog->title }}">
                                        </div>
                                    </div>

                                    <!-- Content -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Content <span class="text-danger">*</span></label>
                                            <textarea name="content" class="summernote" cols="30" rows="10">{{ $blog->content }}</textarea>
                                        </div>
                                    </div>

                                    <!-- Status -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select name="status" class="form-control">
                                                <option @selected($blog->status === 1) value="1">Active</option>
                                                <option @selected($blog->status === 0) value="0">Hide</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="col-md-12 text-right">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
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
            $('.thumbnail-image').css({
                'background-image': 'url({{ asset($blog->thumbnail) }})',
                'background-position': 'center center',
                'background-repeat': 'no-repeat',
                'background-size': 'cover'
            })

            $('.blog-image').css({
                'background-image': 'url({{ asset($blog->image) }})',
                'background-position': 'center center',
                'background-repeat': 'no-repeat',
                'background-size': 'cover'
            })
        })
    </script>
@endpush
