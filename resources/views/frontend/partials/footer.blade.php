@php
    $contact = \App\Models\ContactUs::first();
@endphp

<footer>
    <div class="container">
        <div class="row text-white">
            <div class="col-xl-6">
                <div class="footer_text">
                    <a class="navbar-brand" href="{{ url('/') }}" style="padding-bottom: 50px ;">
                        <img src={{ asset(config('settings.logo_image')) }} style="width: 400px !important;"
                            alt="logo web">
                    </a>
                    <ul class="footer_icon">
                        <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fab fa-google-plus-g"></i></a></li>
                        <li><a href="#"><i class="fab fa-linkedin"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-2">
                <div class="footer_text">
                    <ul class="footer_link">
                        @foreach (Menu::getByName('Footer Column First') as $footer)
                            <li><a href="{{ $footer['link'] }}"><i class="far fa-chevron-double-right"></i>
                                    {{ $footer['label'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-xl-2">
                <div class="footer_text">
                    <ul class="footer_link">
                        @foreach (Menu::getByName('Footer Column Second') as $footer)
                            <li><a href="{{ $footer['link'] }}"><i class="far fa-chevron-double-right"></i>
                                    {{ $footer['label'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-xl-2">
                <div class="footer_text footer_contact">
                    <ul class="footer_link">
                        <li>
                            <p>
                                <i class="far fa-map-marker-alt"></i>
                                {{ $contact?->address }}
                            </p>
                        </li>
                        <li>
                            <a href="#">
                                <a href="mailto:{{ $contact?->email_one }}">
                                    <i class="fal fa-envelope"></i>
                                    {{ $contact?->email_one }}
                                </a>
                            </a>
                        </li>
                        @if ($contact?->email_two)
                            <li>
                                <a href="#">
                                    <a href="mailto:{{ $contact?->email_two }}">
                                        <i class="fal fa-envelope"></i>
                                        {{ $contact?->email_two }}
                                    </a>
                                </a>
                            </li>
                        @endif
                        <li>
                            <a href="#">
                                <a href="callto:{{ $contact?->phonenumber_one }}">
                                    <i class="fal fa-phone-alt"></i>
                                    {{ $contact?->phonenumber_one }}
                                </a>
                            </a>
                        </li>
                        @if ($contact?->phonenumber_two)
                            <li>
                                <a href="#">
                                    <a href="callto:{{ $contact?->phonenumber_two }}">
                                        <i class="fal fa-phone-alt"></i>
                                        {{ $contact?->phonenumber_two }}
                                    </a>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer_bottom">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-md-6">
                    <p>&#64; 2024 <a href="#">Phuc Khang</a> All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </div>
</footer>
