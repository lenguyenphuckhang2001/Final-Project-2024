@extends('frontend.layouts.main')

@section('contents')
    <!----------------Banner---------------->
    @include('frontend.home.sections.hero')

    <!---------------Category--------------->
    @include('frontend.home.sections.categories-icon')

    <!---------------Features--------------->
    @include('frontend.home.sections.features')

    <!-------------Out Category------------->
    @include('frontend.home.sections.categories')

    <!-------------Out Location------------->
    @include('frontend.home.sections.location')

    <!-----------Featured Listing----------->
    @include('frontend.home.sections.featured-listing')

    <!-------------Our Package-------------->
    @include('frontend.home.sections.packages')

    <!-------------Feedback-------------->
    @include('frontend.home.sections.feedback')

    <!----------------Blog------------------>
    @include('frontend.home.sections.blog')
@endsection
