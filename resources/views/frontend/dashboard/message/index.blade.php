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
                        <div class="dashboard_message_area">
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="tf__message_list">
                                        <div class="nav flex-column nav-pills tf__massager_option" id="v-pills-tab"
                                            role="tablist" aria-orientation="vertical">
                                            @foreach ($receivers as $receiver)
                                                <div class="nav-link profile-box" id="v-pills-home-tab"
                                                    data-bs-toggle="pill" data-bs-target="#v-pills-home" role="tab"
                                                    aria-controls="v-pills-home" aria-selected="true"
                                                    data-listing-id="{{ $receiver->listingInfo->id }}"
                                                    data-receiver-id="{{ $receiver->receiverInfo->id }}">
                                                    <div class="tf__single_massage d-flex">
                                                        <div class="tf__single_massage_img">
                                                            <img src="{{ $receiver->listingInfo->image }}" alt="person"
                                                                class="img-fluid w-100 profile-image">
                                                        </div>
                                                        <div class="tf__single_massage_text">
                                                            <h4 class="profile-title">
                                                                {{ cutString($receiver->listingInfo->title, 16) }}</h4>
                                                            <p><i class="fas fa-house-user" style="color: #22d5e2;"></i>
                                                                {{ $receiver->receiverInfo->name }}
                                                            </p>
                                                            <span class="tf__massage_time">30 min</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-8">
                                    <div class="tab-content" id="v-pills-tabContent">
                                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                                            aria-labelledby="v-pills-home-tab" tabindex="0">
                                            <div class="tf___single_chat">
                                                <div class="tf__single_chat_top">
                                                    <div class="img">
                                                        <img id="box-image" src="" alt="person"
                                                            class="img-fluid w-100">
                                                    </div>
                                                    <div class="text">
                                                        <h4 id="box-title">Charlene Reed</h4>
                                                        {{-- <p>active</p> --}}
                                                    </div>
                                                </div>

                                                <div class="tf__single_chat_body chatbox_field">
                                                    {{-- <div class="tf__chating">
                                                        <div class="tf__chating_img">
                                                            <img src="images/massage-4.png" alt="person"
                                                                class="img-fluid w-100">
                                                        </div>
                                                        <div class="tf__chating_text">
                                                            <p>Cum id mundi admodum menandri, eum errem is any one
                                                                aperiri at. Ut quas facilis qui</p>
                                                            <span>15 Jun, 2023, 05:26 AM</span>
                                                        </div>
                                                    </div> --}}
                                                    {{-- <div class="tf__chating tf_chat_right">
                                                        <div class="tf__chating_text">
                                                            <p>I message you in this portion.</p>
                                                            <span>16 Junly, 2024, 03:22 PM</span>
                                                        </div>
                                                        <div class="tf__chating_img">
                                                            <img src="images/massage-8.png" alt="person"
                                                                class="img-fluid w-100">
                                                        </div>
                                                    </div> --}}

                                                </div>
                                                <form class="tf__single_chat_bottom">
                                                    <input type="text" placeholder="Message...">
                                                    <button class="tf__massage_btn">
                                                        <i class="fas fa-paper-plane"></i>
                                                    </button>
                                                </form>
                                            </div>
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

@push('scripts')
    <script>
        function updateProfileChat(data) {
            let profileImage = data.find('.profile-image').attr('src');
            let profileTitle = data.find('.profile-title').text();
            $('#box-image').attr('src', profileImage);
            $('#box-title').text(profileTitle);
        }

        function datetimeFormat(dateTimeString) {
            const format = {
                year: 'numeric',
                month: 'short',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
            }
            const datetimeFormatted = new Intl.DateTimeFormat('en-US', format).format(new Date(dateTimeString));
            return datetimeFormatted;
        }

        $(document).ready(function() {
            const baseURI = "{{ asset('/') }}";
            $('.profile-box').on('click', function() {
                updateProfileChat($(this));

                const chatboxFeild = $('.chatbox_field');
                chatboxFeild.html("");

                let listingId = $(this).data('listing-id');
                let receiverId = $(this).data('receiver-id')

                $.ajax({
                    method: 'GET',
                    url: '{{ route('user.store-messages') }}',
                    data: {
                        'listing_id': listingId,
                        'receiver_id': receiverId
                    },
                    beforeSend: function() {

                    },
                    success: function(response) {
                        $.each(response, function(index, value) {
                            console.log(value)
                            let textMessage =
                                `<div class="tf__chating tf_chat_right">
                                    <div class="tf__chating_text">
                                        <p>${value.message}</p>
                                        <span>${datetimeFormat(value.created_at)}</span>
                                    </div>
                                    <div class="tf__chating_img">
                                        <img src="${baseURI + value.sender_info.avatar}" alt="person" class="img-fluid w-100">
                                    </div>
                                </div>`
                            chatboxFeild.append(textMessage);
                        })
                    },
                    error: function(xhr, status, error) {

                    },
                    complete: function() {

                    }
                })
            })
        })
    </script>
@endpush
