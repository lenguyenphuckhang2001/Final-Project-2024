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
                            <a href="{{ route('user.order.index') }}" class="mb-4">
                                <button type="button" class="btn btn-outline-dark">
                                    <i class="fas fa-chevron-left"></i>
                                    Back
                                </button>
                            </a>
                            <h4 class="mb-5">Order Detail</h4>
                            <div class="section-body">
                                <div class="invoice">
                                    <div class="invoice-print" id="invoice-print">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="invoice-title">
                                                    <h2>Invoice Package</h2>
                                                    <div class="invoice-number">Order {{ $order->order_id }}</div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <address>
                                                            <strong>Billed To:</strong><br>
                                                            {{ $order->user->name }}<br>
                                                            {{ $order->user->email }}<br>
                                                            {{ $order->user->phonenumber }}<br>
                                                            {{ $order->user->address }}
                                                        </address>
                                                    </div>
                                                    <div class="col-md-6 text-md-end">
                                                        <address>
                                                            <strong>Payment Method:</strong><br>
                                                            {{ $order->payment_method }}<br>
                                                            {{ $order->payment_status }}
                                                        </address>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <address>
                                                            <strong>Transaction ID</strong><br>
                                                            {{ $order->transaction_id }}
                                                        </address>
                                                    </div>
                                                    <div class="col-md-6 text-md-end">
                                                        <address>
                                                            <strong>Order Date:</strong><br>
                                                            {{ date('F d, Y', strtotime($order->purchase_date)) }}<br><br>
                                                        </address>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-12">
                                                <div class="section-title">Order Summary</div>
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-hover table-md">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Packages</th>
                                                                <th class="text-center">Price ({{ $order->base_currency }})
                                                                </th>
                                                                <th class="text-end">Totals</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1</td>
                                                                <td>{{ $order->package->name }}</td>
                                                                <td class="text-center">{{ $order->base_amount }}</td>
                                                                <td class="text-end">{{ $order->paid_amount }}
                                                                    {{ $order->paid_currency }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="row mt-4">
                                                    <div class="col-lg-12 text-end">
                                                        <hr class="mt-2 mb-2">
                                                        <div class="invoice-detail-item">
                                                            <div class="invoice-detail-name">Total</div>
                                                            <div class="invoice-detail-value invoice-detail-value-lg">
                                                                {{ $order->paid_amount }} {{ $order->paid_currency }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="text-end">
                                        <button class="btn btn-warning btn-icon icon-left"
                                            onclick="printPageArea('invoice-print')">
                                            <i class="fas fa-print"></i> Print
                                        </button>
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

@push('scripts')
    <script>
        // Hàm printPageArea dùng để in một phần cụ thể của trang
        function printPageArea(areaId) {
            // Lấy nội dung HTML của phần tử có ID là areaId và lưu vào biến printContent
            var printContent = document.getElementById(areaId).innerHTML;
            // Lưu toàn bộ nội dung hiện tại của trang (phần body) vào biến originalContent
            var originalContent = document.body.innerHTML;
            // Thay thế toàn bộ nội dung của trang bằng nội dung của phần tử cần in
            document.body.innerHTML = printContent;
            // Gọi chức năng in của trình duyệt, hiển thị hộp thoại in
            window.print();
            // Khôi phục lại nội dung ban đầu của trang sau khi in xong
            document.body.innerHTML = originalContent;
        }
    </script>
@endpush
