@extends('admin.layouts.main')

@section('contents')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Orders Detail</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('admin.orders.index') }}">Orders</a></div>
                <div class="breadcrumb-item">Order Detail</div>
            </div>
        </div>

        <section class="section">
            <div class="section-header">
                <h1>Invoice</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Invoice</div>
                </div>
            </div>

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
                                    <div class="col-md-6 ">
                                        <address>
                                            <strong>Billed To:</strong><br>
                                            {{ $order->user->name }}<br>
                                            {{ $order->user->email }}<br>
                                            {{ $order->user->phonenumber }}<br>
                                            {{ $order->user->address }}
                                        </address>
                                    </div>
                                    <div class="col-md-6 text-md-right">
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
                                    <div class="col-md-6 text-md-right">
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
                                {{-- <p class="section-lead">All items here cannot be deleted.</p> --}}
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover table-md">
                                        <tr>
                                            <th data-width="40">ID</th>
                                            <th>Packages</th>
                                            <th class="text-center">Price ({{ $order->base_currency }})</th>
                                            <th class="text-right">Totals</th>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>{{ $order->package->name }}</td>
                                            <td class="text-center">{{ $order->base_amount }}</td>
                                            <td class="text-right">{{ $order->paid_amount }} {{ $order->paid_currency }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-lg-12 text-right">
                                        <hr class="mt-2 mb-2">
                                        <div class="invoice-detail-item">
                                            <div class="invoice-detail-name">Total</div>
                                            <div class="invoice-detail-value invoice-detail-value-lg">
                                                {{ $order->paid_amount }} {{ $order->paid_currency }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="text-md-right">
                        <div class="float-lg-left mb-lg-0 mb-3 d-print-none">
                            <form action={{ route('admin.orders.update', $order->id) }} method="POST">
                                @csrf
                                @method('PUT')
                                <div class="d-flex">
                                    <div class="col-md-10">
                                        <select name="payment_status" class="form-control flex-grow-1 mr-2">
                                            <option @selected($order->payment_status === 'pending') value="pending">Pending</option>
                                            <option @selected($order->payment_status === 'completed') value="completed">Completed</option>
                                            <option @selected($order->payment_status === 'failed') value="failed">Failed</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                        <button class="btn btn-warning btn-icon icon-left" onclick="printPageArea('invoice-print')"><i
                                class="fas fa-print"></i> Print</button>
                    </div>
                </div>
            </div>
        </section>
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
