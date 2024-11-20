@extends('admin.layouts.error')

@section('error-content')
    <section class="section">
        <div class="container mt-5">
            <div class="page-error">
                <div class="page-inner">
                    <h1>403</h1>
                    <div class="page-description">
                        {{ $exception->getMessage() }}
                    </div>
                    <div class="page-search">
                        <div class="mt-3">
                            <a href="{{ route('admin.dashboard.index') }}" class="btn btn-primary">Back to Dashboard</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
