@extends('admin.layouts.main')

@section('contents')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.features.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Edit Feature Section</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.features.index') }}">Features</a></div>
                <div class="breadcrumb-item">Edit</div>
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
                            <form action="{{ route('admin.features.update', $feature->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-xl-4 col-md-6">
                                        <div class="form-group">
                                            <label>Icon <span class="text-danger">*</span></label>
                                            <div name='icon' role="iconpicker" data-align="center"
                                                data-unselected-class="primary" data-icon="{{ $feature->icon }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-8 col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Title <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="title"
                                                        value={{ $feature->title }}>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Description <span class="text-danger">*</span></label>
                                                    <textarea name="description" class="form-control" cols="30" rows="30">{{ $feature->description }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Status</label>
                                                    <select name="status" class="form-control">
                                                        <option @selected($feature->status === 1) value="1">Active</option>
                                                        <option @selected($feature->status === 0) value="0">Hide</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group float-right">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
