<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densityDpi=device-dpi" />
    <title>App</title>
    <link rel="icon" type="image/png" href="images/favicon.png">
    <!------------CSS Libraries------------>
    <link rel="stylesheet" href="{{ asset('frontend/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/venobox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/summernote.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <!--------------CSS Custom--------------->


    <!--------------CSS Link--------------->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">


    @stack('styles')

    <script script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        var PUSHER_APP_KEY = "{{ config('settings.pusher_key') }}"
        var PUSHER_APP_CLUSTER = "{{ config('settings.pusher_cluster') }}"
        var USER_PROFILE = {
            id: "{{ auth()->user()?->id }}",
            name: "{{ auth()->user()?->name }}",
            avatar: "{{ auth()->user()?->avatar }}"
        }
    </script>

    @vite(['resources/js/app.js', 'resources/js/frontend-chanel.js'])
</head>

<body>
    <!--------------Nav Bar----------------->
    @include('frontend.partials.navbar')

    <!--------------Content----------------->
    @yield('contents')

    <!--------------Footer------------------>
    @include('frontend.partials.footer')

    <!------Popup Show listing Detail------->
    <section id="wsus__map_popup">
        <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="btn-close popup_close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="far fa-times"></i></button>
                    <div class="modal-body modal-listing-content">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--------------Scroll Btn-------------->
    <div class="scroll_btn">
        <i class="fas fa-chevron-up"></i>
    </div>

    <!-----------JavaScript Libraries------->
    <script src="{{ asset('frontend/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/js/Font-Awesome.js') }}"></script>
    <script src="{{ asset('frontend/js/slick.min.js') }}"></script>
    <script src="{{ asset('frontend/js/venobox.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.countup.min.js') }}"></script>
    <script src="{{ asset('frontend/js/select2.min.js') }}"></script>
    <script src="{{ asset('frontend/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('frontend/js/summernote.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>

    <!-----------JavaScript Custom------->
    <script src="{{ asset('admin/assets/modules/upload-preview/assets/js/jquery.uploadPreview.min.js') }}"></script>


    <!-----------JavaScript Link----------->
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $.uploadPreview({
            input_field: "#image-upload", // Default: .image-upload
            preview_box: "#image-preview", // Default: .image-preview
            label_field: "#image-label", // Default: .image-label
            label_default: "Choose File", // Default: Choose File
            label_selected: "Change File", // Default: Change File
            no_label: false, // Default: false
            success_callback: null // Default: null
        });

        $.uploadPreview({
            input_field: "#image-upload-2", // Default: .image-upload-2
            preview_box: "#image-preview-2", // Default: .image-preview-2
            label_field: "#image-label-2", // Default: .image-label-2
            label_default: "Choose File", // Default: Choose File
            label_selected: "Change File", // Default: Change File
            no_label: false, // Default: false
            success_callback: null // Default: null
        });

        //Sweet alert custom JS
        $('body').on('click', '.delete-item', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');
            console.log(url);
            Swal.fire({
                title: "Delete this item",
                text: "Are you sure to delete it?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes"
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        method: 'DELETE',
                        url: url,
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire({
                                    title: "Deleted",
                                    text: response.message,
                                    icon: "success"
                                });
                                window.location.reload();
                            } else if (response.status === 'error') {
                                Swal.fire({
                                    title: "Error",
                                    text: response.message,
                                    icon: "error"
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                }
            });
        })


        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error('{{ $error }}')
            @endforeach
        @endif
    </script>

    <script>
        function showListingPopup(id) {
            $.ajax({
                method: 'GET',
                url: '{{ route('listing-modal', ':id') }}'.replace(':id', id),
                data: {},
                beforeSend: function() {
                    $('.modal-listing-content').html(`<div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>`)
                },
                success: function(response) {
                    $('.modal-listing-content').html(response);
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            })
        }
    </script>
    @stack('scripts')
</body>

</html>
