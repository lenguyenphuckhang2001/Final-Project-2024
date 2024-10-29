@extends('frontend.layouts.main')

@section('contents')
    <!--------------Payment Section---------------->
    <section id="wsus__custom_page">
        <div class="wsus__package_overlay">
            <div class="container">
                <div class="text-center">
                    <i class="fas fa-times" style="font-size: 150px; color: rgb(183, 2, 2)"></i>
                    <div class="m-3 ">
                        <h1>Purchase Has Been Failed</h1>
                        <p style="font-size:20px; margin-top:10px;">Try again or back to home page</p>
                        @if ($errors->any())
                            <div class="alert alert-danger mt-2">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <a href="{{ url('/') }}" class="btn btn-danger  mt-4">
                        <i class="fas fa-home"></i> Return
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
