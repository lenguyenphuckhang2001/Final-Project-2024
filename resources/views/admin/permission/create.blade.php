@extends('admin.layouts.main')

@section('contents')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.permission.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Create Permissions</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('admin.permission.index') }}">Permissions</a></div>
                <div class="breadcrumb-item">Create Permissions</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Create Permissions</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.permission.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Add Role <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        @foreach ($userPermissions as $group => $userPermission)
                                            <div class="form-group">
                                                <div class="section-title" style="text-transform: capitalize">Permissions {{ $group }}</div>
                                                <div class="row mt-3">
                                                    @foreach ($userPermission as $itemPermission)
                                                    <div class="col-md-3 mb-3">
                                                        <label class="custom-switch">
                                                            <input type="checkbox" name="permissions[]"
                                                                class="custom-switch-input" value="{{ $itemPermission->name }}">
                                                            <span class="custom-switch-indicator"></span>
                                                            <span class="custom-switch-description" style="text-transform: capitalize">{{ $itemPermission->name }}</span>
                                                        </label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
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

@push('scripts')
    <script></script>
@endpush
