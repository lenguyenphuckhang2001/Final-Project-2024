@extends('admin.layouts.main')

@section('contents')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.packages.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Create Package</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('admin.packages.index') }}">Packages</a></div>
                <div class="breadcrumb-item">Create</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Create New Package</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.packages.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Type Package <span class="text-danger">*</span></label>
                                            <select name="type" id="" class="form-control" required>
                                                <option value="free">Free</option>
                                                <option value="premium">Paid</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Name of Package<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name"
                                                placeholder="Name packages" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Price (USD)<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="price" placeholder="0"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Limit Days<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="limit_days"
                                                placeholder="Unlimited days use (-1)" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Limit of Listing<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="limit_listing"
                                                placeholder="Unlimited listing use (-1)" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Limit of Photos<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="limit_photos"
                                                placeholder="Unlimited photos use (-1)" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Limit of Video<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="limit_video"
                                                placeholder="Unlimited videos use (-1)" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Limit of Facilities<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="limit_facilities"
                                                placeholder="Unlimited facilities use (-1)"required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Limit of Featured Listing<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="limit_featured_listing"
                                                placeholder="Unlimited featured listing use (-1)" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Display this in Home Page?</label>
                                            <select name="display_at_home" id="" class="form-control">
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Status</label>
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
