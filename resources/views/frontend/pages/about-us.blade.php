@extends('frontend.layouts.main')

@section('contents')
    <div id="breadcrumb_part" style="background: url({{ config('settings.bkg_about_us') }})">
        <div class="bread_overlay">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 text-center text-white">
                        <h4>About Us</h4>
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"> Home </a></li>
                                <li class="breadcrumb-item active" aria-current="page"> About Us</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- About Us Section --}}
    <section id="about_page">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-xl-6 col-lg-6">
                    <div class="about_text">
                        <h4>{{ $aboutUs?->title }}</h4>
                        {!! $aboutUs?->content !!}
                    </div>
                </div>
                <div class="col-xl-5 col-lg-6">
                    <div class="about_img">
                        <img src="{{ asset($aboutUs?->image_video) }}" alt="image video" class="img-fluid w-100"
                            style="height:500px !important;object-fit:cover;">
                        <a class="venobox" data-autoplay="true" data-vbtype="video" href="{{ $aboutUs?->video_url }}">
                            <i class="fas fa-play"></i>
                        </a>
                        <div class="img_2">
                            <img src="{{ asset($aboutUs?->image_small) }}" alt="image about" class="img-fluid w-100">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!---------------Features--------------->
    @include('frontend.home.sections.features')

    {{-- Statistical Section --}}
    <section id="wsus__counter" style="background-image: url({{ asset(@$statistical->background) }});">
        <div class="wsus__counter_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-6 col-md-3">
                        <div class="wsus__counter_single">
                            <span class="counter">{{ @$statistical->number_first }}</span>
                            <p>{{ @$statistical->title_first }}</p>
                        </div>
                    </div>
                    <div class="col-xl-3 col-6 col-md-3">
                        <div class="wsus__counter_single">
                            <span class="counter">{{ @$statistical->number_second }}</span>
                            <p>{{ @$statistical->title_second }}</p>
                        </div>
                    </div>
                    <div class="col-xl-3 col-6 col-md-3">
                        <div class="wsus__counter_single">
                            <span class="counter">{{ @$statistical->number_third }}</span>
                            <p>{{ @$statistical->title_third }}</p>
                        </div>
                    </div>
                    <div class="col-xl-3 col-6 col-md-3">
                        <div class="wsus__counter_single">
                            <span class="counter">{{ @$statistical->number_fourth }}</span>
                            <p>{{ @$statistical->title_fourth }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-------------Out Category------------->
    @include('frontend.home.sections.categories')
@endsection
