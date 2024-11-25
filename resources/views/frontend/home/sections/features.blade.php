<section id="wsus__features">
    <div class="container">
        <div class="row">
            <div class="col-xl-5 m-auto">
                <div class="wsus__heading_area">
                    <h2>Features</h2>
                    <p>We are helps you to explore destinations, plan trips, and book services like flights, accommodations, and activities</p>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($homeFeatures as $feature)
                <div class="col-xl-4 col-md-6">
                    <div class="wsus__feature_single">
                        <div class="icon">
                            <i class="{{ $feature->icon }}"></i>
                        </div>
                        <h5>{{ $feature->title }}</h5>
                        <p>{{ $feature->description }}</p>
                        <span>{{ ++$loop->index }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
