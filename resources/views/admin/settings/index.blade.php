@extends('admin.layouts.main')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Settings</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Settings</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Settings</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-2">
                                    <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="home-tab4" data-toggle="tab" href="#home4"
                                                role="tab" aria-controls="home" aria-selected="true">General
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="profile-tab4" data-toggle="tab" href="#profile4"
                                                role="tab" aria-controls="profile" aria-selected="false">Pusher Message
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="contact-tab4" data-toggle="tab" href="#contact4"
                                                role="tab" aria-controls="contact" aria-selected="false">Favicon and
                                                Logo
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="pallete-tab4" data-toggle="tab" href="#pallete4"
                                                role="tab" aria-controls="contact" aria-selected="false">Breadcrumb
                                                Background Pages
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-12 col-sm-12 col-md-10">
                                    <div class="tab-content no-padding" id="myTab2Content">
                                        @include('admin.settings.sections.general-settings')
                                        @include('admin.settings.sections.pusher-settings')
                                        @include('admin.settings.sections.favicon-and-logo-settings')
                                        @include('admin.settings.sections.breadcrumb-background-settings')
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
        $(document).ready(function() {
            $('.favicon-setting').css({
                'background-image': 'url({{ asset(config('settings.favicon_image')) }})',
                'background-position': 'center center',
                'background-repeat': 'no-repeat',
                'background-size': 'cover'
            })

            $('.logo-setting').css({
                'background-image': 'url({{ asset(config('settings.logo_image')) }})',
                'background-position': 'center center',
                'background-repeat': 'no-repeat',
                'background-size': 'cover'
            })

            // Breadcrumb Background

            $('.listing-img').css({
                'background-image': 'url({{ asset(config('settings.bkg_listing_page')) }})',
                'background-position': 'center center',
                'background-repeat': 'no-repeat',
                'background-size': 'cover'
            })

            $('.listing-categories-img').css({
                'background-image': 'url({{ asset(config('settings.bkg_listing_categories')) }})',
                'background-position': 'center center',
                'background-repeat': 'no-repeat',
                'background-size': 'cover'
            })

            $('.about-us-img').css({
                'background-image': 'url({{ asset(config('settings.bkg_about_us')) }})',
                'background-position': 'center center',
                'background-repeat': 'no-repeat',
                'background-size': 'cover'
            })

            $('.blog-page-img').css({
                'background-image': 'url({{ asset(config('settings.bkg_blog')) }})',
                'background-position': 'center center',
                'background-repeat': 'no-repeat',
                'background-size': 'cover'
            })

            $('.contact-us-img').css({
                'background-image': 'url({{ asset(config('settings.bkg_contact_us')) }})',
                'background-position': 'center center',
                'background-repeat': 'no-repeat',
                'background-size': 'cover'
            })

            $('.term-condition-img').css({
                'background-image': 'url({{ asset(config('settings.bkg_term_condition')) }})',
                'background-position': 'center center',
                'background-repeat': 'no-repeat',
                'background-size': 'cover'
            })

            $('.privacy-policy-img').css({
                'background-image': 'url({{ asset(config('settings.bkg_privacy_policy')) }})',
                'background-position': 'center center',
                'background-repeat': 'no-repeat',
                'background-size': 'cover'
            })

            $(".colorpickerinput").colorpicker({
                format: 'hex',
                component: '.input-group-append',
            });
        })

        $.uploadPreview({
            input_field: "#image-upload-3", // Default: .image-upload
            preview_box: "#image-preview-3", // Default: .image-preview
            label_field: "#image-label-3", // Default: .image-label
            label_default: "Choose File", // Default: Choose File
            label_selected: "Change File", // Default: Change File
            no_label: false, // Default: false
            success_callback: null // Default: null
        });

        $.uploadPreview({
            input_field: "#image-upload-4", // Default: .image-upload
            preview_box: "#image-preview-4", // Default: .image-preview
            label_field: "#image-label-4", // Default: .image-label
            label_default: "Choose File", // Default: Choose File
            label_selected: "Change File", // Default: Change File
            no_label: false, // Default: false
            success_callback: null // Default: null
        });

        $.uploadPreview({
            input_field: "#image-upload-5", // Default: .image-upload
            preview_box: "#image-preview-5", // Default: .image-preview
            label_field: "#image-label-5", // Default: .image-label
            label_default: "Choose File", // Default: Choose File
            label_selected: "Change File", // Default: Change File
            no_label: false, // Default: false
            success_callback: null // Default: null
        });

        $.uploadPreview({
            input_field: "#image-upload-6", // Default: .image-upload
            preview_box: "#image-preview-6", // Default: .image-preview
            label_field: "#image-label-6", // Default: .image-label
            label_default: "Choose File", // Default: Choose File
            label_selected: "Change File", // Default: Change File
            no_label: false, // Default: false
            success_callback: null // Default: null
        });

        $.uploadPreview({
            input_field: "#image-upload-7", // Default: .image-upload
            preview_box: "#image-preview-7", // Default: .image-preview
            label_field: "#image-label-7", // Default: .image-label
            label_default: "Choose File", // Default: Choose File
            label_selected: "Change File", // Default: Change File
            no_label: false, // Default: false
            success_callback: null // Default: null
        });

        $.uploadPreview({
            input_field: "#image-upload-8", // Default: .image-upload
            preview_box: "#image-preview-8", // Default: .image-preview
            label_field: "#image-label-8", // Default: .image-label
            label_default: "Choose File", // Default: Choose File
            label_selected: "Change File", // Default: Change File
            no_label: false, // Default: false
            success_callback: null // Default: null
        });
        $.uploadPreview({
            input_field: "#image-upload-9", // Default: .image-upload
            preview_box: "#image-preview-9", // Default: .image-preview
            label_field: "#image-label-9", // Default: .image-label
            label_default: "Choose File", // Default: Choose File
            label_selected: "Change File", // Default: Change File
            no_label: false, // Default: false
            success_callback: null // Default: null
        });
    </script>
@endpush
