@extends('frontend.layouts.main')

@section('contents')
    <section id="dashboard">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    @include('frontend.dashboard.sidebar')
                </div>
                <div class="col-lg-9">
                    <div class="dashboard_content">
                        <div class="my_listing">
                            <a href="{{ route('user.listing.index') }}" class="mb-4">
                                <button type="button" class="btn btn-outline-dark">
                                    <i class="fas fa-chevron-left"></i>
                                    Back
                                </button>
                            </a>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="mb-0">Table Schedule of Title: {{ $titleListing->title }}</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('user.schedule.create', $listingId) }}" class="read_btn">Create</a>
                                </div>
                            </div>
                            {{ $dataTable->table() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
