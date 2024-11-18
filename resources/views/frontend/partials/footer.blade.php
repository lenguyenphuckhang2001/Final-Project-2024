@php
    $contact = \App\Models\ContactUs::first();
@endphp

<footer>
    <div class="container">
        <div class="row text-white">
            <div class="col-xl-5 col-sm-12 col-md-6 col-lg-6">
                <div class="footer_text">
                    <a class="navbar-brand" href="index.html" style="padding-bottom: 50px ;">
                        <img src="https://bus2alps.com/wp-content/uploads/2022/06/bus2alpslogo.svg" alt="Icon web">
                    </a>
                    <ul class="footer_icon">
                        <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fab fa-google-plus-g"></i></a></li>
                        <li><a href="#"><i class="fab fa-linkedin"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-2 col-sm-6 col-md-6 col-lg-6">
                <div class="footer_text">
                    <h3>My Account</h3>
                    <ul class="footer_link">
                        @foreach (Menu::getByName('Footer Column First')  as $footer)
                        <li><a href="{{ $footer['link'] }}"><i class="far fa-chevron-double-right"></i> {{ $footer['label'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-xl-2 col-sm-6 col-md-3 col-lg-6">
                <div class="footer_text">
                    <h3>My Account</h3>
                    <ul class="footer_link">
                        @foreach (Menu::getByName('Footer Column Second')  as $footer)
                        <li><a href="{{ $footer['link'] }}"><i class="far fa-chevron-double-right"></i> {{ $footer['label'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-md-6 col-lg-6">
                <div class="footer_text footer_contact">
                    <h3>Contact with Us</h3>
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
                    <p>&#64; 2021 <a href="#">DB.Card</a> All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </div>
</footer>
