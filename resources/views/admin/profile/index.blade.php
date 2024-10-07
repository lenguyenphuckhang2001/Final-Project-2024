@extends('admin.layouts.main')

@section('contents')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="features-posts.html" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Profile</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Posts</a></div>
                <div class="breadcrumb-item">Create New Post</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Update Profile</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Avatar</label>
                                            <div id="avatar-preview" class="image-preview">
                                                <label for="avatar-upload" id="avatar-label">Choose File</label>
                                                <input type="file" name="avatar" id="avatar-upload" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Banner</label>
                                            <div id="banner-preview" class="image-preview">
                                                <label for="banner-upload" id="banner-label">Choose File</label>
                                                <input type="file" name="banner" id="banner-upload" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Full Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="fullname"
                                                placeholder="Enter your name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Phone Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="phonenumber"
                                                placeholder="Enter your phone number" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Email <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="email"
                                                placeholder="Enter your email" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Address <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="address"
                                                placeholder="Enter your address" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Website</label>
                                            <input type="text" class="form-control" name="website"
                                                placeholder="Enter your url website">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">About <span class="text-danger">*</span></label>
                                            <textarea name="about" id="about" class="form-control" cols="30" rows="10" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12 pb-3">
                                        <h5>Social Link</h5>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Facebook</label>
                                            <input type="text" class="form-control" name="fb-url"
                                                placeholder="Enter your url facebook ">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">X</label>
                                            <input type="text" class="form-control" name="x-url"
                                                placeholder="Enter your url X ">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">LinkedIn</label>
                                            <input type="text" class="form-control" name="linked-url"
                                                placeholder="Enter your url linkedin">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Instagram</label>
                                            <input type="text" class="form-control" name="insta-url"
                                                placeholder="Enter your url instagram">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
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
        $.uploadPreview({
            input_field: "#avatar-upload", // Default: .avatar-upload
            preview_box: "#avatar-preview", // Default: .avatar-preview
            label_field: "#avatar-label", // Default: .avatar-label
            label_default: "Choose File", // Default: Choose File
            label_selected: "Change File", // Default: Change File
            no_label: false, // Default: false
            success_callback: null // Default: null
        });

        $.uploadPreview({
            input_field: "#banner-upload",
            preview_box: "#banner-preview",
            label_field: "#banner-label",
            label_default: "Choose File",
            label_selected: "Change File",
            no_label: false,
            success_callback: null
        });
    </script>
@endpush
