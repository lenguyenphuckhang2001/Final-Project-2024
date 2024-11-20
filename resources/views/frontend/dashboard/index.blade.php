@extends('frontend.layouts.main')

@push('styles')
    <style>
        .table-responsive {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            border-collapse: collapse;
        }

        .table thead th {
            background-color: #f8f9fa;
            color: #495057;
            display: flex;
            justify-content: flex-end;
        }

        .table tbody tr:nth-child(odd) {
            background-color: #f2f2f2;
        }

        .table tbody tr td {
            padding: 1rem;
            vertical-align: middle;
        }

        .active_left {
            font-weight: bold;
            background-color: #007bff;
            color: white;
        }

        .package_right {
            text-align: right;
        }
    </style>
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
                        <div class="manage_dasboard">
                            <div class="row">
                                <div class="col-xl-6 col-12 col-sm-6 col-lg-6 col-xxl-3">
                                    <div class="manage_dashboard_single">
                                        <i class="far fa-star"></i>
                                        <h3>116</h3>
                                        <p>Total Reviews</p>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-12 col-sm-6 col-lg-6 col-xxl-3">
                                    <div class="manage_dashboard_single orange">
                                        <i class="fas fa-list-ul"></i>
                                        <h3>21</h3>
                                        <p>active listing</p>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-12 col-sm-6 col-lg-6 col-xxl-3">
                                    <div class="manage_dashboard_single green">
                                        <i class="far fa-heart"></i>
                                        <h3>35</h3>
                                        <p>wishlist</p>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-12 col-sm-6 col-lg-6 col-xxl-3">
                                    <div class="manage_dashboard_single red">
                                        <i class="fal fa-comment-alt-dots"></i>
                                        <h3>120</h3>
                                        <p>message</p>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="active_package">
                                        <h4>Package Information</h4>
                                        <div class="table-responsive">
                                            <table class="table dashboard_table">
                                                <tbody>
                                                    <tr>
                                                        <td class="active_left">Package</td>
                                                        <td class="package_right">{{ $membership?->package->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="active_left">Price</td>
                                                        <td class="package_right">
                                                            {{ positionCurrency($membership?->package->price) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="active_left">Maximum Listing</td>
                                                        <td class="package_right">
                                                            {{ $membership?->package->limit_listing === -1 ? 'Unlimited' : $membership?->package->limit_listing }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="active_left">Maximum Facilities</td>
                                                        <td class="package_right">
                                                            {{ $membership?->package->limit_facilities === -1 ? 'Unlimited' : $membership?->package->limit_facilities }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="active_left">Maximum Photo</td>
                                                        <td class="package_right">
                                                            {{ $membership?->package->limit_photos === -1 ? 'Unlimited' : $membership?->package->limit_photos }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="active_left">Maximum Video</td>
                                                        <td class="package_right">
                                                            {{ $membership?->package->limit_video === -1 ? 'Unlimited' : $membership?->package->limit_video }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="active_left">Featured Listing Available</td>
                                                        <td class="package_right">
                                                            {{ $membership?->package->limit_featured_listing === -1 ? 'Unlimited' : $membership?->package->limit_featured_listing }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="active_left">Purchase</td>
                                                        <td class="package_right">
                                                            {{ date('d F, Y', strtotime($membership?->purchase_date)) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="active_left">Expired</td>
                                                        <td class="package_right">
                                                            {{ date('d F, Y', strtotime($membership?->expire_date)) }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
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
