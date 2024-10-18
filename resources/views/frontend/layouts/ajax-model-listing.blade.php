<div class="row">
    <div class="col-12 col-xl-12 col-md-12">
        <div class="map_popup_content">
            <div class="img">
                <img src="{{ asset($listing->image) }}" alt="images" class="img-fluid w-100">
            </div>
            <div class="map_popup_text">
                @if ($listing->is_featured)
                    <span><i class="far fa-star"></i> Featured</span>
                @endif
                @if ($listing->is_verified)
                    <span class="red"><i class="far fa-check"></i> verified</span>
                @endif
                <h5>{{ $listing->title }}</h5>
                <a class="call" href="Callto:{{ $listing->phonenumber }}"><i class="fal fa-phone-alt"></i>
                    {{ $listing->phonenumber }}</a>
                <a class="mail" href="Mailto:{{ $listing->email }}"><i class="fal fa-envelope"></i>
                    {{ $listing->email }}</a></a>
                {{-- Hàm strip_tags sử dụng để loại bỏ các thẻ HTML và chỉ hiển thị text --}}
                <p>{{ cutString(strip_tags($listing->description), 200) }}</p>
                <a class="read_btn" href="{{ route('listing.detail', $listing->slug) }}">Read More</a>
            </div>
        </div>
        @if ($listing->map_embed_code)
            <div class="col-12 col-xl-12 col-md-12">
                <div class="map_popup_content_map">
                    {!! $listing->map_embed_code !!}
                </div>
            </div>
        @endif
    </div>
</div>
