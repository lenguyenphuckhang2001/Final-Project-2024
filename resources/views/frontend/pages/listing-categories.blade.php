@extends('frontend.layouts.main')

@section('contents')
    <div id="breadcrumb_part" style="background: url({{ config('settings.bkg_listing_categories') }})">
        <div class="bread_overlay">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 text-center text-white">
                        <h4>List Categories</h4>
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"> Home </a></li>
                                <li class="breadcrumb-item active" aria-current="page">List Categories</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section id="wsus__categoryes">
        <div class="wsus__categorye_overlay">
            <div class="container">
                <div class="row">
                    @foreach ($categoriesListing as $categoryListing)
                        <div class="col-xl-4 col-sm-6">
                            <a href="{{ route('listings', ['category' => $categoryListing->slug]) }}" class="wsus__category_single">
                                <div class="wsus__category_img">
                                    <img src="{{ asset($categoryListing->background_image) }}" alt="img" class="img-fluid w-100">
                                </div>
                                <div class="wsus__category_text">
                                    <div class="wsus__category_text_center">
                                        <i class="{{ $categoryListing->icon }}"></i>
                                        <p>{{ $categoryListing->name }}</p>
                                        <span class="category-listing">{{ $categoryListing->listings_count }} listing</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="col-12">
                    <div id="pagination" class="d-flex justify-content-center">
                        @if ($categoriesListing->hasPages())
                            {{ $categoriesListing->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
