@extends('admin.layouts.main')

@section('contents')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.facility.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Edit Facility</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('admin.facility.index') }}">Facility</a></div>
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
                            <form action="{{ route('admin.facility.update', $facility->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="">Icon <span class="text-danger">*</span></label>
                                    <div name='icon' role="iconpicker" data-align="center"
                                        data-unselected-class="primary" data-icon="{{ $facility->icon }}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ $facility->name }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Status</label>
                                            <select name="status" id="" class="form-control">
                                                <option @selected($facility->status === 1) value="1">Active</option>
                                                <option @selected($facility->status === 0) value="0">Hide</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Edit</button>
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
