@extends('admin.layouts.main')

@section('contents')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.feedback.index') }}" class="btn btn-icon">
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
            <h1>Edit Feedback</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard.index') }}">Dashboard</a>
                </div>
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.feedback.index') }}">Feedback</a>
                </div>
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
                            <form action="{{ route('admin.feedback.update', $feedback->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Avatar <span class="text-danger">*</span></label>
                                            <div id="avatar-preview" class="image-preview avatar-image-preview">
                                                <label for="avatar-upload" id="avatar-label">Choose File</label>
                                                <input type="file" name="avatar" id="avatar-upload" />
                                                <input type="hidden" name="previous_avatar"
                                                    value="{{ $feedback->avatar }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ $feedback->name }}" />
                                        </div>
                                        <div class="form-group">
                                            <label>Position <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="position"
                                                value="{{ $feedback->position }}" />
                                        </div>
                                        <div class="form-group">
                                            <label>Rating <span class="text-danger">*</span></label>
                                            <select name="rating" class="form-control">
                                                <option @selected($feedback->rating === 1) value="1">
                                                    &#9733; 1
                                                </option>
                                                <option @selected($feedback->rating === 2) value="2">
                                                    &#9733;&#9733; 2
                                                </option>
                                                <option @selected($feedback->rating === 3) value="3">
                                                    &#9733;&#9733;&#9733; 3
                                                </option>
                                                <option @selected($feedback->rating === 4) value="4">
                                                    &#9733;&#9733;&#9733;&#9733; 4
                                                </option>
                                                <option @selected($feedback->rating === 5) value="5">
                                                    &#9733;&#9733;&#9733;&#9733;&#9733; 5
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Comment <span class="text-danger">*</span></label>
                                            <textarea name="comment" class="form-control" rows="3">{{ $feedback->comment }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select name="status" class="form-control">
                                                <option @selected($feedback->status === 1) value="1">Active</option>
                                                <option @selected($feedback->status === 0) value="0">Hide</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group text-right">
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
            $('.avatar-image-preview').css({
                'background-image': 'url({{ asset($feedback->avatar) }})',
                'background-position': 'center center',
                'background-size': 'cover'
            })
        })
        $.uploadPreview({
            input_field: "#avatar-upload",
            preview_box: "#avatar-preview",
            label_field: "#avatar-label",
            label_default: "Choose File",
            label_selected: "Change File",
            no_label: false,
            success_callback: null
        });
    </script>
@endpush
