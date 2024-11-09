<section id="wsus__package">
    <div class="wsus__package_overlay">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 m-auto">
                    <div class="wsus__heading_area">
                        <h2>Packages</h2>
                        <p>Lorem ipsum dolor sit amet, qui assum oblique praesent te. Quo ei erant essent scaevola
                            estut clita dolorem ei est mazim fuisset scribentur.</p>
                    </div>
                </div>
            </div>
            <div class="procing_area">
                <div class="row">
                    @foreach ($packages as $package)
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

                                @if ($package->limit_facilities === -1)
                                    <p>Unlimited Facilities Available</p>
                                @else
                                    <p>{{ $package->limit_facilities }} Facilities can available</p>
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

                                <a href="{{ route('checkout.index', $package->id) }}">Purchase</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
