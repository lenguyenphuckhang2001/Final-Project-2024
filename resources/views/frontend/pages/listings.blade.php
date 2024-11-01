@extends('frontend.layouts.main')

@push('styles')
    <style>
        .wsus__featured_single {
            cursor: pointer;
        }

        .wsus__featured_single:hover {
            background-color: #f5f4f4;
        }
    </style>
@endpush

@section('contents')
    <!-------------Breadcrumb-------------->
    <div id="breadcrumb_part">
        <div class="bread_overlay">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 text-center text-white">
                        <h4>listing</h4>
                        <nav style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"> Home </a></li>
                                <li class="breadcrumb-item active" aria-current="page"> listing </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-------------Listings-------------->
    <section id="listing_grid" class="grid_view">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <form action="{{ route('listings') }}" method="GET">
                        <div class="listing_grid_sidbar">
                            <div class="sidebar_line">
                                <input type="text" name="search" placeholder="Search" value="{{ request()->search }}">
                            </div>
                            <div class="sidebar_line_select">
                                <select class="select_2" name="category">
                                    <option value="">Categories</option>
                                    @foreach ($categories as $category)
                                        <option @selected($category->slug == request()->category) value="{{ $category->slug }}">
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="sidebar_line_select">
                                <select class="select_2" name="location">
                                    <option value="">Locations</option>
                                    @foreach ($locations as $location)
                                        <option @selected($location->slug == request()->location) value="{{ $location->slug }}">
                                            {{ $location->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="wsus__pro_check">
                                @foreach ($facilities as $facility)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="{{ $facility->slug }}"
                                            name="facility[]" id="flexCheckIndeterminate-{{ $facility->id }}"
                                            @checked(in_array($facility->slug, request()->has('facility') && is_array(request()->facility) ? request()->facility : []))>
                                        <label class="form-check-label" for="flexCheckIndeterminate-{{ $facility->id }}">
                                            {{ $facility->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <button class="read_btn" type="submit">Search</button>
                        </div>
                    </form>
                </div>

                <div class="col-lg-9">
                    <div class="row">
                        @foreach ($listings as $listing)
                            <div class="col-xl-4 col-sm-6">
                                {{-- Thêm phần onclick để click vào toàn bộ thẻ mà không làm lỗi CSS.
                                window.location.href = 'URL' dùng để hướng người dùng tới URL mới và sử dụng
                                event.stopProppagation sẽ ngăn sự kiện click của chúng lan truyền lên div cha.
                                Điều này giúp tránh việc toàn bộ div bị click và dẫn đến trang chi tiết  --}}
                                <div class="wsus__featured_single"
                                    onclick="window.location.href='{{ route('listing.detail', $listing->slug) }}'">
                                    <div class="wsus__featured_single_img">
                                        <img src="{{ asset($listing->image) }}" alt="{{ $listing->title }}"
                                            class="img-fluid w-100">
                                        <a href="#" class="love" onclick="event.stopPropagation();">
                                            <i class="fas fa-heart"></i>
                                        </a>
                                        <a href="{{ route('listings', ['category' => $listing->category->name]) }}"
                                            class="small_text">{{ $listing->category->name }}
                                        </a>
                                    </div>
                                    <a class="map"
                                        onclick="event.stopPropagation(); showListingPopup('{{ $listing->id }}')"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal2" href="#"><i
                                            class="fas fa-info"></i>
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
                                            {{ cutString($listing->title) }}
                                        </a>
                                        <p class="address">{{ $listing->location->name }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-12">
                            <div id="pagination" class="d-flex justify-content-center">
                                @if ($listings->hasPages())
                                    {{ $listings->links() }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
