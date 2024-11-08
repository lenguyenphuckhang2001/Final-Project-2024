@extends('admin.layouts.main')

@section('contents')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.dashboard.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Hero Section</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Hero Section</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Update Hero Section</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.hero-section.update') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group d-flex flex-column ">
                                    <label for="">Background Image</label>
                                    <div id="image-preview" class="image-preview" style="width: 100%; height: 60vh">
                                        <label for="background-upload" id="image-label">Choose File</label>
                                        <input type="file" name="background" id="image-upload" />
                                        <input type="hidden" name="old_background" value="{{ @$hero->background }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Hero Title</label>
                                    <input type="text" class="form-control" name="title" value="{{ @$hero->title }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Hero Subtitle</label>
                                    <input type="text" class="form-control" name="sub_title"
                                        value="{{ @$hero->sub_title }}">
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
            $('.image-preview').css({
                'background-image': 'url({{ asset(@$hero->background) }})',
                'background-position': 'center center',
                'background-repeat': 'no-repeat',
                'background-size': 'cover'
            })
        })
    </script>
@endpush
