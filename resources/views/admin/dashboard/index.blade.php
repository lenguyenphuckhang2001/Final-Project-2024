@extends('admin.layouts.main')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
        <div class="row">
            <div class="d-flex justify-content-center align-items-center w-100">
                <h1>Welcome back! {{ auth()->user()->name }}</h1>
            </div>
        </div>
    </section>
@endsection
