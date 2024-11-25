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
                                <div class="col-xl-12">
                                    <div class="active_package">
                                        <h4>Package Information</h4>
                                        @if (!empty($membership?->package))
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
                                                                {{ date('d F, Y', strtotime($membership?->expire_date)) }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="alert alert-danger text-center"><a href="{{ url('/') }}">You need to
                                                    register package first</a></div>
                                        @endif
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
