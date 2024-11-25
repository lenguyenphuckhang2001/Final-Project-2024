<section id="wsus__categoryes">
    <div class="wsus__categorye_overlay">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 m-auto">
                    <div class="wsus__heading_area">
                        <h2>Categories</h2>
                        <p>We organize content into sections like destinations, accommodations, activities, travel guides, and tips, making it easier for you to find relevant information</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($homeCategory as $category)
                    <div class="col-xl-4 col-sm-6">
                        <a href="{{ route('listings', ['category' => $category->slug]) }}" class="wsus__category_single">
                            <div class="wsus__category_img">
                                <img src="{{ asset($category->background_image) }}" alt="img"
                                    class="img-fluid w-100">
                            </div>
                            <div class="wsus__category_text">
                                <div class="wsus__category_text_center">
                                    <i class="{{ $category->icon }}"></i>
                                    <p>{{ $category->name }}</p>
                                    <span class="category-listing">{{ $category->listings_count }} listing</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
