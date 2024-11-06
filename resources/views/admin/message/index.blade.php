@extends('admin.layouts.main')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Message</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Message</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card" style="height: 70vh">
                        <div class="card-body">
                            <ul class="list-unstyled list-unstyled-border">
                                @foreach ($senders as $sender)
                                    <li class="media profile-box" style="cursor: pointer"
                                        data-sender-id="{{ $sender->senderInfo->id }}"
                                        data-listing-id="{{ $sender->listingInfo->id }}">
                                        <img alt="image" class="mr-3 rounded-circle profile-image" width="50"
                                            height="50" src="{{ asset($sender->senderInfo->avatar) }}"
                                            style="object-fit: cover">
                                        <div class="media-body">
                                            <div class="mt-0 mb-1 font-weight-bold profile-title">
                                                {{ $sender->senderInfo->name }}
                                                <a target="_blank" class="text-info"
                                                    href="{{ route('listing.detail', $sender->listingInfo->slug) }}">
                                                    ({{ $sender->listingInfo->title }})
                                                </a>
                                            </div>
                                            <div class="text-success text-small font-600-bold"><i class="fas fa-circle"></i>
                                                Online</div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-8">
                    <div class="card chat-box d-none" id="mychatbox" style="height: 70vh">
                        <div class="card-header">
                            <img alt="image" class="mr-3 rounded-circle" width="50" height="50" id="box-image"
                                src="" style="object-fit: cover" alt="img">
                            <h4 id="box-title">Title</h4>
                        </div>
                        <div class="card-body chat-content">
                            
                        </div>
                        <div class="card-footer chat-form">
                            <form id="chat-form" class="form-chatbox">
                                @csrf
                                <input type="hidden" id="receiver_id" name="receiver_id" value="">
                                <input type="hidden" id="listing_id" name="listing_id" value="">
                                <input type="text" class="form-control" id="message" name="message"
                                    placeholder="Message...">
                                <button class="btn btn-primary">
                                    <i class="far fa-paper-plane"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        const baseURI = "{{ asset('/') }}";
        const chatboxField = $('.chat-content');
        const loadingData =
            `<div class="d-flex justify-content-center align-items-center h-100">
                <div class="spinner-border text-info" style="width: 3.5rem; height: 3.5rem; font-size: 35px" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>`

        function updateProfileChat(data) {
            /**
             * let profileImage = data.find('.profile-image').attr('src')
             * Tìm phần tử có class .profile-image trong data.
             * .attr('src') lấy giá trị thuộc tính src (đường dẫn của ảnh) từ phần tử đó và gán vào biến profileImage.

             * let profileTitle = data.find('.profile-title').text();
             * Lấy nội dung văn bản từ .profile-title trong data và lấy văn bản bên trong của class đó

             * $('#box-image').attr('src', profileImage);
             * Dòng này cập nhật ảnh hồ sơ trong phần tử có ID là #box-image bằng cách đặt thuộc tính src của nó thành giá trị của profileImage.

             * $('#box-title').text(profileTitle);
             * Tương tự như trên lấy cập nhật tên ID #box-title và cập nhật chúng bằng phần tử profileTitle và gán chúng vào phần tử #box-title
             */
            let profileImage = data.find('.profile-image').attr('src');
            let profileTitle = data.find('.profile-title').text();
            $('#box-image').attr('src', profileImage);
            $('#box-title').text(profileTitle);

            /**
             * let receiverId = data.data('sender-id'): Hàm này lấy dữ liệu data xong tìm data có id là data-sender-id match với receiverId
             * let listingId = data.data('listing-id'): Hàm này cũng tìm dữ liệu đã được truyền vào xong truyền vào listingId với data từ data-listing-id
             * $('#receiver_id').val(receiverId): Dòng này gán giá trị cho input có ID là receiver_id từ receiverId
             * $('#listing_id').val(listingId): Dòng này cũng gán giá trị cho #listing_id từ listingId
             */
            let listingId = data.data('listing-id');
            let receiverId = data.data('sender-id');
            $('#listing_id').val(listingId);
            $('#receiver_id').val(receiverId);
        }


        function datetimeFormat(dateTimeString) {
            /*Sử dụng biến format để định dạng ngày giờ */
            const format = {
                year: 'numeric', // Hiển thị 4 số cho năm. VD: 2024
                month: 'short', // Hiển thị tháng với 3 chữ. VD: Feb
                day: '2-digit', // Hiển thị ngày với 2 số và tương tự
                hour: '2-digit',
                minute: '2-digit',
            }
            /**
             * new Date(dateTimeString): Chuyển chuỗi dateTimeString thành một đối tượng Date

             * new Intl.DateTimeFormat('en-US', format)
             * Tạo 1 đối tượng DateTimeFormat theo ngôn ngữ 'en-US'(tiếng Anh - Mỹ) và định dạng được xác định ở format

             * format(new Date(dateTimeString)
             * Định dạng đối tượng Date thành chuỗi ngày giờ theo kiểu en-US
             */
            const datetimeFormatted = new Intl.DateTimeFormat('en-US', format).format(new Date(dateTimeString));
            return datetimeFormatted; // Hàm sẽ trả về như vậy Nov 03, 2024, 02:30 PM
        }

        /* Khởi tạo hàm scrollBottom để mỗi lần xuất hiện tin nhắn sẽ lăn đến tin nhắn mới nhất */
        function scrollBottomMsg() {
            chatboxField.scrollTop(chatboxField.prop("scrollHeight"))
        }

        /* Bắt sự kiện click trên phần tử có class profile-box */
        $('.profile-box').on('click', function() {
            $('.chat-box').removeClass('d-none');
            updateProfileChat($(this));

            /* Làm sạch form input trước khi thêm tin nhắn mới */
            chatboxField.html("");

            /* Sử dụng $(this) để gọi data từ biến này của người dùng nhập sau đó gán vào giá trị khởi tạo */
            let listingId = $(this).data('listing-id');
            let senderId = $(this).data('sender-id');

            $.ajax({
                method: 'GET',
                url: '{{ route('admin.store-messages') }}',
                data: {
                    'listing_id': listingId, // Dữ liệu gửi lên máy chủ với trường listing_id
                    'sender_id': senderId
                },
                beforeSend: function() {
                    chatboxField.html(loadingData)
                },
                success: function(response) {
                    chatboxField.html("")
                    /**
                     * Lặp qua từng tin nhắn trong response với hàm function(index, value)
                     * index(i) là chỉ số phần tử hiện tại trong mảng hoặc đối tượng đang được lặp. Trong trường hợp này là response sẽ lặp qua các tin nhắn
                     * value(msg) là giá trị phần tử trong response. Trường hợp này sẽ là đối tượng của 1 tin nhắn(msg)
                     */
                    $.each(response, function(i, msg) {
                        let textMessage =
                            `<div class="chat-item ${msg.sender_info.id == USER_PROFILE.id ? 'chat-right' : 'chat-left'}">
                                <img class='chat-profile' src="${baseURI + msg.sender_info.avatar}" width="50" height="50" style="object-fit:cover">
                                <div class="chat-details">
                                    <div class="chat-text">${msg.message}</div>
                                    <div class="chat-time">${datetimeFormat(msg.created_at)}</div>
                                </div>
                            </div>`
                        chatboxField.append(textMessage);
                    })
                    scrollBottomMsg()
                },
                error: function(xhr, status, error) {
                    console.log(error)
                },
                complete: function() {

                }
            })
        })

        /* Gửi tin nhắn  */
        $('.form-chatbox').on('submit', function(e) {
            /*Ngăn chặn hành vi mặc định của sự kiện submit, điều này ngăn chặn biểu mẫu được gửi theo cách truyền thống (reload trang). */
            e.preventDefault();

            /* serialize(): Chuyển đổi tất cả các trường của form thành một chuỗi URL-encoded. Ví dụ: user_id=1&message=hello */
            let formMessageData = $(this).serialize();

            /* Lấy trường có Id message gán vào giá trị */
            let messageBoxData = $('#message').val();

            /* Giá trị này sử dụng khi người dùng gửi thì không cho gửi cho đến khi gửi hoàn tất*/
            var preventSendingMulti = false;

            /*Nếu người dùng đang gửi hoặc form trống thì sẽ trả về là undefined */
            if (preventSendingMulti || messageBoxData === "") {
                return;
            }

            /**
             * let textMessage: Gán các giá trị vào biến textMessage và đặt bên ngoài nhằm tối ưu khi gửi tin nhắn cho người dùng,
             * trong trường hợp này người dùng không phải đợi khi hoàn thành mới có thể đọc được tin nhắn đã gửi

             * USER_PROFILE lấy data từ biến global variables được khởi tạo ở main.blade
             */
            let textMessage =
                `<div class="chat-item chat-right" style="">
                    <img class="chat-profile" src="${USER_PROFILE.avatar}" width="50" height="50" style="object-fit:cover">
                    <div class="chat-details">
                        <div class="chat-text">${messageBoxData}</div>
                        <div class="sending-msg">Sending...</div>
                    </div>
                </div>`
            chatboxField.append(textMessage);
            scrollBottomMsg()

            $('.form-chatbox').trigger('reset');

            $.ajax({
                method: 'POST',
                url: '{{ route('admin.new-message') }}',
                data: formMessageData,
                beforeSend: function() {
                    preventSendingMulti = true;
                },
                success: function(response) {
                    if (response.status === 'success') {
                        $('.sending-msg').remove()
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    if (xhr.responseJSON.message) {
                        toastr.error(xhr.responseJSON.message);
                    }
                },
                complete: function() {
                    preventSendingMulti = false;
                }
            })
        })
    </script>
@endpush
