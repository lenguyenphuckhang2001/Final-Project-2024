@extends('admin.layouts.main')

@section('contents')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.category.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Edit Category</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('admin.category.index') }}">Category</a></div>
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
                            <form action="{{ route('admin.category.update', $category->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="">Background Image </label>
                                            <div id="image-preview" class="image-preview background-image-edit">
                                                <label for="image-upload" id="image-label">Choose File</label>
                                                <input type="file" name="background_image" id="image-upload" />
                                                <input type="hidden" name="previous_background_image"
                                                    value="{{ $category->background_image }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Icon Image</label>
                                            <div id="image-preview-2" class="image-preview icon-image">
                                                <label for="image-upload-2" id="image-label-2">Choose File</label>
                                                <input type="file" name="icon_image" id="image-upload-2" />
                                                <input type="hidden" name="previous_icon"
                                                    value="{{ $category->icon_image }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Icon Filter<span class="text-danger">*</span></label>
                                            <div name='icon' role="iconpicker" data-align="left"
                                                data-unselected-class="primary" data-icon="{{ $category->icon }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ $category->name }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Display in Home Page?</label>
                                            <select name="display_at_home" id="" class="form-control">
                                                <option @selected($category->display_at_home === 0) value="0">No</option>
                                                <option @selected($category->display_at_home === 1) value="1">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Status</label>
                                            <select name="status" id="" class="form-control">
                                                <option @selected($category->status === 1) value="1">Active</option>
                                                <option @selected($category->status === 0) value="0">Hide</option>
                                            </select>
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
            $('.background-image-edit').css({
                'background-image': 'url({{ asset($category->background_image) }})',
                'background-position': 'center center',
                'background-repeat': 'no-repeat',
                'background-size': 'cover'
            })

            $('.icon-image').css({
                'background-image': 'url({{ asset(@$category->icon_image) }})',
                'background-position': 'center center',
                'background-repeat': 'no-repeat',
                'background-size': 'cover'
            })
        })
    </script>
@endpush
