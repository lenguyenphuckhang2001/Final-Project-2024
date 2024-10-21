@extends('frontend.layouts.main')

@section('contents')
    <!--------------Payment Section---------------->
    <section id="wsus__custom_page">
        <div class="wsus__package_overlay">
            <div class="container">
                <div class="text-center">
                    <i class="fas fa-check" style="font-size: 150px; color: rgb(36, 203, 36)"></i>
                    <div class="m-3 p-0">
                        <h1>Purchase Has Been Successful</h1>
                        <p style="font-size:20px; margin-top:10px;">Thank you for purchasing our products.</p>
                    </div>
                    <a href="{{ url('/') }}" class="btn btn-success">
                        <i class="fas fa-home"></i> Return
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
