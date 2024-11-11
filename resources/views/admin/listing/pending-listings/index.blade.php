@extends('admin.layouts.main')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Pending Listing</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Pending Listings</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>All Pending Listings</h4>
                        </div>
                        <div class="card-body">
                            {{ $dataTable->table() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    <script>
        // Khi DOM sẵn sàng (toàn bộ trang đã tải xong)
        $(document).ready(function() {
            // Gán sự kiện 'change' cho bất kỳ phần tử nào có class '.select-pending' nằm trong 'body'
            $('body').on('change', '.select-pending', function(e) {

                // Lấy giá trị của thuộc tính data-id của thẻ 'select'
                let id = $(this).data('id');

                // Lấy giá trị hiện tại của thẻ 'select' (giá trị người dùng chọn)
                let value = $(this).val();

                // Gửi một yêu cầu AJAX (phương thức POST) để cập nhật dữ liệu
                $.ajax({
                    method: 'POST', // Phương thức gửi yêu cầu HTTP là POST
                    url: "{{ route('admin.pending.update') }}", // URL đến route 'admin.pending.update' trong Laravel

                    // Dữ liệu gửi kèm với yêu cầu AJAX
                    data: {
                        _token: "{{ csrf_token() }}", // Token CSRF để bảo mật (tránh các cuộc tấn công CSRF)
                        id: id, // ID của item (lấy từ data-id của thẻ 'select')
                        value: value // Giá trị mới của item (lấy từ thẻ 'select')
                    },

                    // Nếu yêu cầu thành công, hàm này sẽ được gọi
                    success: function(response) {
                        // Kiểm tra trạng thái trả về từ server
                        if (response.status === 'success') {
                            // Nếu thành công, hiển thị thông báo thành công với toastr
                            toastr.success(response.message)
                        } else {
                            // Nếu thất bại, hiển thị thông báo lỗi với toastr
                            toastr.error(response.message)
                        }
                    },

                    // Nếu có lỗi xảy ra trong quá trình gửi AJAX, hàm này sẽ được gọi
                    error: function(error) {
                        // In thông tin lỗi ra console để tiện debug
                        console.log(error);
                    }
                })
            })
        })
    </script>
@endpush
