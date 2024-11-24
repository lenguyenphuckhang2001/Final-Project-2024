@extends('frontend.layouts.main')

@section('contents')
    <div id="breadcrumb_part" style="background: url({{ $userProfile->banner }})">
        <div class="bread_overlay">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 text-center text-white">
                        <h4>Profile</h4>
                        <nav style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript;"> Home </a></li>
                                <li class="breadcrumb-item active" aria-current="page"> Personal Profile </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section id="wsus__agent_profile">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="wsus__profile_header">
                        <img src="{{ asset($userProfile->avatar) }}" alt="avatar" class="img-fluid">
                        <div class="wsus__profile_text">
                            <h4>{{ $userProfile->name }}</h4>
                            <a href="mailto:{{ $userProfile->email }}"><i class="fal fa-envelope-open"></i>
                                {{ $userProfile->email }}</a>
                            <a href="callto:{{ $userProfile->phonenumber }}"><i class="fas fa-phone-alt"></i>
                                {{ $userProfile->phonenumber }}</a>
                            <p><i class="fal fa-map-marker-alt"></i> {{ $userProfile->address }}</p>
                            @if ($userProfile->website)
                                <p><i class="fal fa-globe"></i> {{ $userProfile->website }}</p>
                            @endif
                            <span>{{ $userProfile->about }}</span>
                            <ul class="wsus__agent_link">
                                @if ($userProfile->fb_url)
                                    <li><a href="{{ $userProfile->fb_url }}" style="background: #30559e"><i
                                                class="fab fa-facebook-f"></i></a></li>
                                @endif
                                @if ($userProfile->x_url)
                                    <li><a href="{{ $userProfile->x_url }}" style="background: #000000"><i
                                                class="fa-brands fa-x-twitter"></i></a></li>
                                @endif
                                @if ($userProfile->linked_url)
                                    <li><a href="{{ $userProfile->linked_url }}" style="background: #0082be"><i
                                                class="fab fa-linkedin-in"></i></a>
                                    </li>
                                @endif
                                @if ($userProfile->insta_url)
                                    <li><a href="{{ $userProfile->insta_url }}" style="background: #c93971"><i
                                                class="fab fa-instagram"></i>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @if(count($listingsPersonal) > 0)
                <div class="row grid">
                    @foreach ($listingsPersonal as $listing)
                        <div class="col-xl-3 col-sm-6 col-lg-4 {{ $listing->location->slug }}">
                            {{-- Thêm phần onclick để click vào toàn bộ thẻ mà không làm lỗi CSS.
                                window.location.href = 'URL' dùng để hướng người dùng tới URL mới và sử dụng
                                event.stopProppagation sẽ ngăn sự kiện click của chúng lan truyền lên div cha.
                                Điều này giúp tránh việc toàn bộ div bị click và dẫn đến trang chi tiết  --}}
                            <div class="wsus__featured_single"
                                onclick="window.location.href='{{ route('listing.detail', $listing->slug) }}'">
                                <div class="wsus__featured_single_img">
                                    <img src="{{ asset($listing->image) }}" alt="{{ $listing->title }}"
                                        class="img-fluid w-100">
                                    <a href="#" class="love" onclick="event.stopPropagation();"><i
                                            class="fas fa-heart"></i></a>
                                    <a href="{{ route('listings', ['category' => $listing->category->name]) }}"
                                        class="small_text">{{ $listing->category->name }}</a>
                                </div>
                                <a class="map"
                                    onclick="event.stopPropagation(); showListingPopup('{{ $listing->id }}')"
                                    data-bs-toggle="modal" data-bs-target="#exampleModal2" href="#">
                                    <i class="fas fa-info"></i>
                                </a>
                                <div class="wsus__featured_single_text">
                                    <p class="list_rating">
                                        @for ($i = 1; $i < 6; $i++)
                                            @if ($i <= intval($listing->evaluates_avg_rating))
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                        <span>({{ $listing->evaluates_count }} review)</span>
                                    </p>
                                    <a href="{{ route('listing.detail', $listing->slug) }}">
                                        {{ cutString($listing->title, 20) }}
                                    </a>
                                    <p class="address">{{ $listing->location->name }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-12">
                        <div id="pagination" class="d-flex justify-content-center">
                            @if ($listingsPersonal->hasPages())
                                {{ $listingsPersonal->withQueryString()->links() }}
                            @endif
                        </div>
                    </div>
                </div>
                @else
                <div class="row">
                    <span style="text-align: center; font-size:20px; font-weight:bold">No listing available</span>
                </div>
                @endif
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://kit.fontawesome.com/ba25ab417c.js" crossorigin="anonymous"></script>
@endpush
