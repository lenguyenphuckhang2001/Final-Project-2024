@extends('frontend.layouts.main')

@push('styles')
@endpush

@section('contents')
    <section id="dashboard">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    @include('frontend.dashboard.sidebar')
                </div>
                <div class="col-lg-9">
                    <div class="dashboard_content">
                        <div class="my_listing p_xm_0">
                            <div class="row">
                                <div class="col-xxl-6 col-xl-6">
                                    <div class="visitor_rev_area">
                                        <h4>Your Evaluate Listing</h4>
                                        @foreach ($evaluatesPersonal as $evaluate)
                                            <div class="visitor_rev_single mb-2">
                                                <div class="visitor_rev_img">
                                                    <img src="{{ asset($evaluate->listing->image) }}" alt="image listing"
                                                        class="img-fluid w-100">
                                                </div>
                                                <div class="visitor_rev_text">
                                                    <a class="title"
                                                        href="{{ route('listing.detail', $evaluate->listing->slug) }}">
                                                        {{ cutString($evaluate->listing->title, 15) }}
                                                        <span>{{ date('d M Y', strtotime($evaluate->created_at)) }}</span>
                                                    </a>
                                                    <p>
                                                        @for ($i = 1; $i < 6; $i++)
                                                            @if ($i <= $evaluate->rating)
                                                                <i class="fas fa-star"></i>
                                                            @else
                                                                <i class="far fa-star"></i>
                                                            @endif
                                                        @endfor
                                                    </p>
                                                    <span class="small_text">{{ $evaluate->review }}</span>
                                                    <ul>
                                                        <li>
                                                            <a href="{{ route('user.evaluate.destroy', $evaluate->id) }}" class="delete-item"><i
                                                                    class="fal fa-trash-alt" aria-hidden="true"></i>
                                                                delete</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="col-12">
                                        <div id="pagination" class="d-flex justify-content-center">
                                            @if ($evaluatesPersonal->hasPages())
                                                {{ $evaluatesPersonal->links() }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-xl-6">
                                    <div class="visitor_rev_area">
                                        <h4>User Evaluate Your Listing</h4>
                                        @foreach ($evaluatesDashboard as $evaluateDashboard)
                                            <div class="visitor_rev_single mb-2">
                                                <div class="visitor_rev_img">
                                                    <img src="{{ asset($evaluateDashboard->listing->image) }}"
                                                        alt="image listing" class="img-fluid w-100 h-100">
                                                </div>
                                                <div class="visitor_rev_text">
                                                    <a class="title"
                                                        href="{{ route('listing.detail', $evaluateDashboard->listing->slug) }}">
                                                        {{ cutString($evaluateDashboard->listing->title, 15) }}
                                                        <span>{{ date('d M Y', strtotime($evaluateDashboard->created_at)) }}</span>
                                                    </a>
                                                    <p>
                                                        @for ($i = 1; $i < 6; $i++)
                                                            @if ($i <= $evaluateDashboard->rating)
                                                                <i class="fas fa-star"></i>
                                                            @else
                                                                <i class="far fa-star"></i>
                                                            @endif
                                                        @endfor
                                                    </p>
                                                    <span class="small_text">{{ $evaluateDashboard->review }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="col-12">
                                        <div id="pagination" class="d-flex justify-content-center">
                                            @if ($evaluatesDashboard->hasPages())
                                                {{ $evaluatesDashboard->links() }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
