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
    <!----------------Banner---------------->
    @include('frontend.home.sections.hero')

    <!---------------Category--------------->
    @include('frontend.home.sections.categories-icon')

    <!---------------Features--------------->
    @include('frontend.home.sections.features')

    <!---------------Counter---------------->
    {{-- @include('frontend.home.sections.counter') --}}

    <!-------------Out Category------------->
    @include('frontend.home.sections.categories')

    <!-------------Out Location------------->
    @include('frontend.home.sections.location')

    <!-----------Featured Listing----------->
    @include('frontend.home.sections.featured-listing')

    <!-------------Our Package-------------->
    @include('frontend.home.sections.packages')

    <!-------------Testimonial-------------->
    {{-- @include('frontend.home.sections.testimonial') --}}

    <!----------------Blog------------------>
    {{-- @include('frontend.home.sections.blog') --}}
@endsection
