@extends('frontend.layouts.main')

@push('styles')
    <script src="https://kit.fontawesome.com/ba25ab417c.js" crossorigin="anonymous"></script>
@endpush
@section('contents')
    <!------------------------Breadcrumb---------------------->
    <div id="breadcrumb_part"
        style="
            background: url({{ $listing->thumbnail }});
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
    ">
        <div class="bread_overlay">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 text-center text-white">
                        <h4>{{ $listing->title }}</h4>
                        <nav style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}"> Home </a></li>
                                <li class="breadcrumb-item active" aria-current="page"> Listing Details </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!----------------------------Listing------------------------>
    <section id="listing_details">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-7">
                    <div class="listing_details_text">
                        <div class="listing_det_header">
                            <div class="listing_det_header_img">
                                <img src="{{ asset($listing->user->avatar) }}" alt="logo" class="img-fluid w-100">
                            </div>
                            <div class="listing_det_header_text">
                                <h6>{{ $listing->title }}</h6>
                                <p class="host_name">Hosted by
                                    <a href="agent_public_profile.html">{{ $listing->user->name }}</a>
                                </p>
                                <p class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <b>4.5</b>
                                    <span>(12 review)</span>
                                </p>
                                <ul>
                                    @if ($listing->is_verified)
                                        <li><a href="#"><i class="far fa-check"></i> Verified</a></li>
                                    @endif
                                    @if ($listing->is_featured)
                                        <li><a href="#"><i class="far fa-check"></i> Featured</a></li>
                                    @endif
                                    <li><a href="#"><i class="fal fa-heart"></i> Add to Favorite</a></li>
                                    <li><a href="#"><i class="fal fa-eye"></i> {{ $listing->views }}</a></li>
                                    {{-- javascript:; là một cú pháp trong HTML, thường được sử dụng trong thuộc tính href của
                                    thẻ <a>, để ngăn không cho đường dẫn điều hướng đến bất cứ đâu. --}}
                                    @if ($statusTime == 'open')
                                        <li><a href="javascript:;">Open</a></li>
                                    @elseif ($statusTime == 'close')
                                        <li><a href="javascript:;">Close</a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="listing_det_text">
                            <p>{!! $listing->description !!}</p>
                        </div>
                        <div class="listing_det_Photo">
                            <div class="row">
                                @foreach ($listing->gallery as $image)
                                    <div class="col-xl-3 col-sm-6">
                                        <a class="venobox" data-gall="gallery01" href="{{ asset($image->image) }}">
                                            <img src="{{ asset($image->image) }}" alt="gallery1" class="img-fluid w-100">
                                            <div class="photo_overlay">
                                                <i class="fal fa-plus"></i>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="listing_det_feature">
                            <div class="row">
                                @foreach ($listing->amenities as $amenity)
                                    <div class="col-xl-4 col-sm-6">
                                        <div class="listing_det_feature_single">
                                            <i class="{{ $amenity->amenity->icon }}"></i>
                                            <span>{{ $amenity->amenity->name }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="listing_det_video">
                            <div class="row">
                                @foreach ($listing->videos as $video)
                                    <div class="col-xl-4 col-sm-6">
                                        <div class="listing_det_video_img">
                                            <img src="{{ getURL($video->video_url) }}" alt="img"
                                                class="img-fluid w-100">
                                            <a class="venobox" data-autoplay="true" data-vbtype="video"
                                                href="{{ $video->video_url }}">
                                                <i class=" fas fa-play"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="listing_det_location">
                            @if ($listing->map_embed_code)
                                {!! $listing->map_embed_code !!}
                            @endif
                        </div>
                        <div class="wsus__listing_review">
                            <h3>Reviews Of {{ $listing->title }}</h3>
                            <div class="wsus__single_comment">
                                <div class="wsus__single_comment_img">
                                    <img src="images/user_large_img.jpg" alt="comment" class="img-fluid w-100">
                                </div>
                                <div class="wsus__single_comment_text">
                                    <h5>sumon ali<span>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                        </span></h5>
                                    <span>01-Dec-2021</span>
                                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ad maxime placeat
                                        ducimus.</p>
                                </div>
                            </div>
                            @auth
                                <form class="input_comment" action="{{ route('listing-evaluate.store') }}" method="POST">
                                    @csrf
                                    <h5>Evaluate Listing</h5>
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="wsus__select_rating">
                                                <select class="select_2" name="rating">
                                                    <option value="">Select Rating</option>
                                                    <option value="1"> &#11088; </option>
                                                    <option value="2"> &#11088; &#11088; </option>
                                                    <option value="3"> &#11088; &#11088; &#11088; </option>
                                                    <option value="4"> &#11088; &#11088; &#11088; &#11088;</option>
                                                    <option value="5"> &#11088; &#11088; &#11088; &#11088; &#11088;
                                                    </option>
                                                </select>
                                                <input type="hidden" name="listing_id" value="{{ $listing->id }}">
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="blog_single_input">
                                                <textarea cols="3" rows="5" placeholder="Comment" name="review"></textarea>
                                                <button type="submit" class="read_btn">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            @endauth
                            @guest
                                <div class="alert alert-warning">
                                    Please <a href="{{ route('login') }}">login</a> to comment this post
                                </div>
                            @endguest
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5">
                    <div class="listing_details_sidebar">
                        <div class="row">
                            <div class="col-12">
                                <div class="listing_det_side_address">
                                    <a href="callto:+96544444222221100"><i class="fal fa-phone-alt"></i>
                                        {{ $listing->phonenumber }}</a>
                                    <a href="mailto:example@gmail.com"><i class="fal fa-envelope"></i>
                                        {{ $listing->email }}</a>
                                    <p><i class="fal fa-map-marker-alt"></i>{{ $listing->address }},
                                        {{ $listing->location->name }}</p>
                                    @if ($listing->website)
                                        <p><i class="fal fa-globe"></i> {{ $listing->website }}</p>
                                    @endif

                                    <ul>
                                        @if ($listing->fb_url)
                                            <li>
                                                <a href="{{ $listing->fb_url }}"><i class="fab fa-facebook-f"></i></a>
                                            </li>
                                        @endif

                                        @if ($listing->x_url)
                                            <li>
                                                <a href="{{ $listing->x_url }}"><i
                                                        class="fa-brands fa-square-x-twitter"></i></a>
                                            </li>
                                        @endif

                                        @if ($listing->linked_url)
                                            <li>
                                                <a href="{{ $listing->linked_url }}"><i
                                                        class="fab fa-linkedin-in"></i></a>
                                            </li>
                                        @endif

                                        @if ($listing->insta_url)
                                            <li>
                                                <a href="{{ $listing->insta_url }}"><i
                                                        class="fa-brands fa-instagram"></i></a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            @if (count($listing->schedules) >= 1)
                                <div class="col-12">
                                    <div class="listing_det_side_open_hour">
                                        <h5>Opening Hours</h5>
                                        @foreach ($listing->schedules as $schedule)
                                            <p>{{ $schedule->day }} <span>{{ $schedule->start_time }} -
                                                    {{ $schedule->end_time }}</span></p>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <div class="col-12">
                                <div class="listing_det_side_contact">
                                    <h5>Quick contact</h5>
                                    <form>
                                        <form type="text" placeholder="Name*">
                                            <input type="email" placeholder="Email*">
                                            <input type="text" placeholder="Phone*">
                                            <input type="text" placeholder="Subject*">
                                            <textarea cols="3" rows="5" placeholder="Message*"></textarea>
                                            <button type="submit" class="read_btn">send</button>
                                        </form>
                                </div>
                            </div>
                            @if (count($similarListing) > 0)
                                <div class="col-12">
                                    <div class="listing_det_side_list">
                                        <h5>Similar Listing</h5>
                                        @foreach ($similarListing as $similar)
                                            <a href="{{ route('listing.detail', $similar->slug) }}"
                                                class="sidebar_blog_single">
                                                <div class="sidebar_blog_img">
                                                    <img src="{{ asset($similar->image) }}" alt="{{ $similar->title }}"
                                                        class="imgofluid w-100">
                                                </div>
                                                <div class="sidebar_blog_text">
                                                    <h5>{{ cutString($similar->title) }}</h5>
                                                    <p> <span>
                                                            {{ date('d/m/Y', strtotime($similar->created_at)) }}
                                                        </span> 2 Comment </p>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
