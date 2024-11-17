@extends('admin.layouts.main')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Contact Us</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Contact Us</div>
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
                            <form action="{{ route('admin.contact-us.update') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Phone Number 1 <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="phonenumber_one"
                                                value="{{ $contactUs?->phonenumber_one }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Email 1 <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="email_one"
                                                value="{{ $contactUs?->email_one }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Phone Number 2</label>
                                            <input type="text" class="form-control" name="phonenumber_two"
                                                value="{{ $contactUs?->phonenumber_two }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Email 2</label>
                                            <input type="text" class="form-control" name="email_two"
                                                value="{{ $contactUs?->email_two }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Address <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="address"
                                                value="{{ $contactUs?->address }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Map Embed Code (<span
                                                    class="text-danger">2000x500</span>)</label>
                                            <textarea name="map_embed_code" class="codeeditor" cols="30" rows="20">{{ $contactUs?->map_embed_code }}</textarea>
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

