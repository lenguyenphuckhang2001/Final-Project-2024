<section id="wsus__location">
    <div class="wsus__location_overlay">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 m-auto">
                    <div class="wsus__heading_area">
                        <h2>Our location </h2>
                        <p>Our popular locations will be here for you to choose the best and most wonderful places for
                            yourself</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <div class="wsus__location_filter">
                        <button class="active" data-filter="*">All City</button>
                        @foreach ($ourLocation as $location)
                            <button data-filter=".{{ $location->slug }}">{{ $location->name }}</button>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row grid">
                @foreach ($ourLocation as $location)
                    @foreach ($location->listings as $listing)
                        <div class="col-xl-3 col-sm-6 col-lg-4 {{ $location->slug }}">
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
                @endforeach
            </div>
        </div>
    </div>
</section>
