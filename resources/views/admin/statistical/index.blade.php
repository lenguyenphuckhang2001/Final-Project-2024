@extends('admin.layouts.main')

@section('contents')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.category.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Statistical</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Statistical</div>
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
                            <form action="{{ route('admin.statistical.update', 1) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Background Image </label>
                                            <div id="image-preview" class="image-preview" style="width: 100%;">
                                                <label for="image-upload" id="image-label">Choose File</label>
                                                <input type="file" name="background" id="image-upload" />
                                                <input type="hidden" name="previous_background"
                                                    value="{{ @$statistical->background }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xg-6 col-md-6">
                                        <div class="form-group">
                                            <label>Title 1</label>
                                            <input type="text" class="form-control" name="title_first"
                                                value="{{ @$statistical->title_first }}">
                                        </div>
                                    </div>
                                    <div class="col-xg-6 col-md-6">
                                        <div class="form-group">
                                            <label>Statiscal 1</label>
                                            <input type="text" class="form-control" name="number_first"
                                                value="{{ @$statistical->number_first }}">
                                        </div>
                                    </div>

                                    <div class="col-xg-6 col-md-6">
                                        <div class="form-group">
                                            <label>Title 2</label>
                                            <input type="text" class="form-control" name="title_second"
                                                value="{{ @$statistical->title_second }}">
                                        </div>
                                    </div>
                                    <div class="col-xg-6 col-md-6">
                                        <div class="form-group">
                                            <label>Statiscal 2</label>
                                            <input type="text" class="form-control" name="number_second"
                                                value="{{ @$statistical->number_second }}">
                                        </div>
                                    </div>

                                    <div class="col-xg-6 col-md-6">
                                        <div class="form-group">
                                            <label>Title 3</label>
                                            <input type="text" class="form-control" name="title_third"
                                                value="{{ @$statistical->title_third }}">
                                        </div>
                                    </div>
                                    <div class="col-xg-6 col-md-6">
                                        <div class="form-group">
                                            <label>Statiscal 3</label>
                                            <input type="text" class="form-control" name="number_third"
                                                value="{{ @$statistical->number_third }}">
                                        </div>
                                    </div>


                                    <div class="col-xg-6 col-md-6">
                                        <div class="form-group">
                                            <label>Title 4</label>
                                            <input type="text" class="form-control" name="title_fourth"
                                                value="{{ @$statistical->title_fourth }}">
                                        </div>
                                    </div>
                                    <div class="col-xg-6 col-md-6">
                                        <div class="form-group">
                                            <label>Statiscal 4</label>
                                            <input type="text" class="form-control" name="number_fourth"
                                                value="{{ @$statistical->number_fourth }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group float-right">
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
                'background-image': 'url({{ asset(@$statistical->background) }})',
                'background-position': 'center center',
                'background-repeat': 'no-repeat',
                'background-size': 'cover'
            })
        })
    </script>
@endpush
