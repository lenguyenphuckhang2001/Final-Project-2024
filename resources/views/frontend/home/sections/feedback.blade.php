<section id="wsus__testimonial">
    <div class="wsus__test_overlay">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 m-auto">
                    <div class="wsus__heading_area">
                        <h2>Feedbacks</h2>
                        <p>Lorem ipsum dolor sit amet, qui assum oblique praesent te. Quo ei erant essent scaevola
                            estut clita dolorem ei est mazim fuisset scribentur.</p>
                    </div>
                </div>
            </div>
            <div class="row testi_slider">
                @foreach ($feedbacks as $feedback)
                    <div class="col-xl-6">
                        <div class="wsus__single_clients">
                            <div class="text">
                                <img src="{{ asset($feedback->avatar) }}" alt="clients" class="img-fluid">
                                <p class="c_name">{{ $feedback->name }}
                                    <span class="c_det">{{ $feedback->position }}</span>
                                </p>
                            </div>
                            <p class="descrption">{{ $feedback->comment }}</p>
                            <p class="rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $feedback->rating)
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
