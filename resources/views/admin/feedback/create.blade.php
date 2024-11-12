@extends('admin.layouts.main')

@section('contents')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.feedback.index') }}" class="btn btn-icon">
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
            <h1>Create Feedback</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard.index') }}">Dashboard</a>
                </div>
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.feedback.index') }}">Feedback</a>
                </div>
                <div class="breadcrumb-item">Create</div>
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
                            <form action="{{ route('admin.feedback.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Avatar <span class="text-danger">*</span></label>
                                            <div id="avatar-preview" class="image-preview">
                                                <label for="avatar-upload" id="avatar-label">Choose File</label>
                                                <input type="file" name="avatar" id="avatar-upload" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name" />
                                        </div>
                                        <div class="form-group">
                                            <label>Position <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="position" />
                                        </div>
                                        <div class="form-group">
                                            <label>Rating <span class="text-danger">*</span></label>
                                            <select name="rating" class="form-control">
                                                <option value="1">&#9733; 1</option>
                                                <option value="2">&#9733;&#9733; 2</option>
                                                <option value="3">&#9733;&#9733;&#9733; 3</option>
                                                <option value="4">&#9733;&#9733;&#9733;&#9733; 4</option>
                                                <option value="5">&#9733;&#9733;&#9733;&#9733;&#9733; 5</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Comment <span class="text-danger">*</span></label>
                                            <textarea name="comment" class="form-control" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select name="status" class="form-control">
                                                <option value="1">Active</option>
                                                <option value="0">Hide</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group text-right">
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
    <script>
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
