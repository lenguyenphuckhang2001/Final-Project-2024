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
                                    @for ($i = 1; $i < 6; $i++)
                                        @if ($i <= $listing->evaluates_avg_rating)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                    <b>{{ intval($listing->evaluates_avg_rating) }}</b>
                                    <span>({{ count($listing->evaluates) }} reviews)</span>
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
                            @if (count($evaluates) > 0)
                                @foreach ($evaluates as $evaluate)
                                    <div class="wsus__single_comment">
                                        <div class="wsus__single_comment_img">
                                            <img src="{{ asset($evaluate->user->avatar) }}" alt="comment"
                                                class="img-fluid w-100">
                                        </div>
                                        <div class="wsus__single_comment_text">
                                            <h5>{{ $evaluate->user->name }}
                                                <span>
                                                    @for ($i = 1; $i < 6; $i++)
                                                        @if ($i <= $evaluate->rating)
                                                            <i class="fas fa-star"></i>
                                                        @else
                                                            <i class="far fa-star"></i>
                                                        @endif
                                                    @endfor
                                                </span>
                                            </h5>
                                            <span>Comment at: {{ date('d/m/Y'), strtotime($evaluate->created_at) }}</span>
                                            <p>{{ $evaluate->review }}.</p>
                                        </div>
                                    </div>
                                @endforeach
                                <div id="pagination" class="d-flex justify-content-center">
                                    @if ($evaluates->hasPages())
                                        {{ $evaluates->links() }}
                                    @endif
                                </div>
                            @else
                                <div class="alert alert-info mt-4">
                                    <p>There are currently no comments on this article.</p>
                                </div>
                            @endif
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
                                    <a href="callto:{{ $listing->phonenumber }}"><i class="fal fa-phone-alt"></i>
                                        {{ $listing->phonenumber }}</a>
                                    <a href="mailto:{{ $listing->email }}"><i class="fal fa-envelope"></i>
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
                                    <h5>Contact With Us</h5>
                                    <form action="{{ route('listing-report') }}" method="POST">
                                        @csrf
                                        <input type="text" name="name" placeholder="Name"
                                            value="{{ auth()->user()?->name }}">
                                        <input type="email" name="email" placeholder="Email"
                                            value="{{ auth()->user()?->email }}">
                                        <textarea cols="3" rows="5" name="message" placeholder="Message"></textarea>
                                        <input type="hidden" name="listing_id" value={{ $listing->id }}>
                                        <button type="submit" class="">Send</button>
                                    </form>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="listing_det_side_contact">
                                    <h5>Message Us</h5>
                                    <button type="submit" class="read_btn" data-bs-toggle="modal"
                                        data-bs-target="#modalPopup">
                                        Message
                                    </button>
                                    <div class="alert alert-info mt-3 text-center d-none continue-send">
                                        <a href="{{ route('user.messages.index') }}">
                                            Continue messages is here
                                        </a>
                                    </div>
                                </div>
                            </div>

                            @if (count($similarListing) > 0)
                                <div class="col-12">
                                    <div class="listing_det_side_list">
                                        <h5>Popuplar</h5>
                                        @foreach ($similarListing as $similar)
                                            <a href="{{ route('listing.detail', $similar->slug) }}"
                                                class="sidebar_blog_single">
                                                <div class="sidebar_blog_img">
                                                    <img src="{{ asset($similar->image) }}" alt="{{ $similar->title }}"
                                                        class="imgofluid w-100">
                                                </div>
                                                <div class="sidebar_blog_text">
                                                    <h5>{{ cutString($similar->title) }}</h5>
                                                    <p>
                                                        <span>
                                                            {{ date('d/m/Y', strtotime($similar->created_at)) }}
                                                        </span>
                                                        {{ $similar->evaluates_count }} Comment
                                                    </p>
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

    <!------Popup Show listing Detail------->
    <section id="wsus__map_popup">
        <div class="modal fade" id="modalPopup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="btn-close popup_close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="far fa-times"></i></button>
                    <div class="modal-body modal-listing-content listing_det_side_contact"
                        style="box-shadow: none; margin-bottom: 0">
                        <div class="mb-4">
                            <h5 class="mb-2">Message</h5>
                            <p>Tell with us about your problem or question here</p>
                        </div>
                        <form action="" method="POST" class="message-form">
                            @csrf
                            <input type="hidden" name="receiver_id" value="{{ $listing->user_id }}">
                            <input type="hidden" name="listing_id" value="{{ $listing->id }}">
                            <textarea cols="100" rows="5" name="message" placeholder="Message"></textarea>
                            <button type="submit" class="send-btn">Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $('.message-form').on('submit', function(e) {
            e.preventDefault();
            // serialize(): Chuyển đổi tất cả các trường của form thành một chuỗi URL-encoded. Ví dụ: user_id=1&message=hello
            let formData = $(this).serialize();
            $.ajax({
                method: 'POST',
                url: '{{ route('user.send-message') }}',
                data: formData,
                beforeSend: function() {
                    //Add loading boostrap when user sent message
                    $('.send-btn')
                        .html(
                            `<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>Sending...`
                        )
                    //When user is sending prevent click using disabled
                    $('.send-btn').prop('disabled', true);
                },
                success: function(response) {
                    if (response.status === 'success') {
                        toastr.success(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    if (xhr.responseJSON.message) {
                        toastr.error(xhr.responseJSON.message);
                    }
                },
                complete: function() {
                    //After completed sent show this
                    $('.send-btn').html(`Sent`);
                    //When sending success disabled is remove using false
                    $('.send-btn').prop('disabled', false);
                    //Use trigger to reset message in form
                    $('.message-form').trigger('reset');
                    //Use model('hide') to hide popup when user sent
                    $('#modalPopup').modal('hide');
                    //Show this alert to notify user want to message or not
                    $('.continue-send').removeClass('d-none');
                }
            })
        })
    </script>
@endpush
