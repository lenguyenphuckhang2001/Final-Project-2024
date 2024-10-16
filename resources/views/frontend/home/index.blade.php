@extends('frontend.layouts.main')

@section('contents')
    <!----------------Banner---------------->
    @include('frontend.home.sections.banner')

    <!---------------Category--------------->
    @include('frontend.home.sections.category-slider')

    <!---------------Features--------------->
    {{-- @include('frontend.home.sections.features') --}}

    <!---------------Counter---------------->
    {{-- @include('frontend.home.sections.counter') --}}

    <!-------------Out Category------------->
    @include('frontend.home.sections.our-category')

    <!-------------Out Location------------->
    {{-- @include('frontend.home.sections.our-location') --}}

    <!-----------Featured Listing----------->
    {{-- @include('frontend.home.sections.featured-listing') --}}

    <!-------------Our Package-------------->
    @include('frontend.home.sections.our-package')

    <!-------------Testimonial-------------->
    {{-- @include('frontend.home.sections.testimonial') --}}

    <!----------------Blog------------------>
    {{-- @include('frontend.home.sections.blog') --}}
@endsection
