@extends('admin.layouts.main')

@section('contents')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.blog.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Create Blog</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('admin.blog.index') }}">Blogs</a></div>
                <div class="breadcrumb-item">Create Blog</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Create</h4>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <!-- Image Upload -->
                                        <div class="form-group">
                                            <label for="">Image</label>
                                            <div id="image-preview" class="image-preview">
                                                <label for="image-upload" id="image-label">Choose File</label>
                                                <input type="file" name="image" id="image-upload" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <!-- Topic Selection -->
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Topics <span class="text-danger">*</span></label>
                                                    <select name="topic" class="form-control" required>
                                                        <option value="" selected disabled>Select</option>
                                                        $@foreach ($topics as $topic)
                                                            <option value="{{ $topic->id }}">{{ $topic->topic }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- Title Input -->
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="">Title <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="title">
                                                    <input type="hidden" name="author">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Content <span class="text-danger">*</span></label>
                                            <textarea name="content" class="summernote" cols="30" rows="10"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Status </label>
                                            <select name="status" id="" class="form-control">
                                                <option value="1">Active</option>
                                                <option value="0">Hide</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Create</button>
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
    <script></script>
@endpush