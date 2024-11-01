@extends('frontend.layouts.main')

@section('contents')
    <!--------------Breadcrumb------------------->
    <div id="breadcrumb_part">
        <div class="bread_overlay">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 text-center text-white">
                        <h4>Purchase</h4>
                        <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}"> Home </a></li>
                                <li class="breadcrumb-item active" aria-current="page">Purchase Page</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--------------Payment Section---------------->
    <section id="wsus__custom_page">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="wsus__payment_area">
                        <div class="row">
                            @if (config('payment.paypal_status') === 'active')
                                <div class="col-lg-4 col-7 col-sm-5">
                                    <a class="wsus__single_payment" href="{{ route('paypal.payment') }}">
                                        <img src="{{ asset('images/3rd-payment/paypal.png') }}" alt="payment method"
                                            class="img-fluid w-100">
                                    </a>
                                </div>
                            @endif
                            @if (config('payment.stripe_status') === 'active')
                                <div class="col-lg-4 col-7 col-sm-5">
                                    <a class="wsus__single_payment" href="{{ route('stripe.payment') }}">
                                        <img src="{{ asset('images/3rd-payment/stripe.png') }}" alt="payment method"
                                            class="img-fluid w-100">
                                    </a>
                                </div>
                            @endif
                            {{--
                            <div class="col-lg-3 col-6 col-sm-4">
                                <a class="wsus__single_payment" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                    href="#">
                                    <img src="images/pay_3.jpg" alt="payment method" class="img-fluid w-100">
                                </a>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 col-lg-4">
                    <div class="member_price">
                        <h4>{{ $package->name }}</h4>
                        <h5>{{ positionCurrency($package->price) }}
                            @if ($package->limit_days == -1)
                                <span>/<i class="fas fa-infinity"></i></span>
                            @else
                                <span>/{{ $package->limit_days }} Days</span>
                            @endif
                        </h5>

                        @if ($package->limit_listing === -1)
                            <p>Unlimited Listings Post</p>
                        @else
                            <p>{{ $package->limit_listing }} Listing can post</p>
                        @endif

                        @if ($package->limit_amenities === -1)
                            <p>Unlimited Amenities Available</p>
                        @else
                            <p>{{ $package->limit_amenities }} Amenities can available</p>
                        @endif

                        @if ($package->limit_photos === -1)
                            <p>Unlimited Photos Upload</p>
                        @else
                            <p>{{ $package->limit_photos }} Photos can upload</p>
                        @endif

                        @if ($package->limit_video === -1)
                            <p>Unlimited Video Upload</p>
                        @else
                            <p>{{ $package->limit_video }} Video can upload</p>
                        @endif

                        @if ($package->limit_featured_listing === -1)
                            <p>Unlimited Featured of Listing </p>
                        @else
                            <p>{{ $package->limit_featured_listing }} Featured of listing</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
