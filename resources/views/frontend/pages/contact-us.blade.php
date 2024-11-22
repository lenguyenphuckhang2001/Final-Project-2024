@extends('frontend.layouts.main')

@section('contents')
    <div id="breadcrumb_part" style="background: url({{ config('settings.bkg_contact_us') }})">
        <div class="bread_overlay">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 text-center text-white">
                        <h4>Contact us</h4>
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"> Home </a></li>
                                <li class="breadcrumb-item active" aria-current="page">Contact </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section id="get_in_touch">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="contact_box">
                        <div class="contact_box_icon">
                            <i class="fal fa-phone-square-alt"></i>
                        </div>
                        <div class="contact_box_text">
                            <a href="callto: {{ $contactUs?->phonenumber_one }}">{{ $contactUs?->phonenumber_one }}</a>
                            <a href="callto: {{ $contactUs?->phonenumber_two }}">{{ $contactUs?->phonenumber_two }}</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="contact_box">
                        <div class="contact_box_icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact_box_text">
                            <a href="mailto: {{ $contactUs?->email_one }}">{{ $contactUs?->email_one }}</a>
                            <a href="mailto: {{ $contactUs?->email_two }}">{{ $contactUs?->email_two }}</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="contact_box">
                        <div class="contact_box_icon">
                            <i class="fal fa-map-marker-alt"></i>
                        </div>
                        <div class="contact_box_text">
                            <p>{{ $contactUs?->address }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h2>Message Me</h2>
                    <form action="{{ route('contact-us.send') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="contact_input">
                                    <input type="text" name="name" placeholder="Name">
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="contact_input">
                                    <input type="email" name="email" placeholder="Email">
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="contact_input">
                                    <input type="text" name="subject" placeholder="Subject">
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="contact_input">
                                    <textarea cols="3" rows="5" name="message" placeholder="Message"></textarea>
                                    <button class="read_btn" type="submit">Send Message</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="contact_map">
                        {!! $contactUs?->map_embed_code !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
