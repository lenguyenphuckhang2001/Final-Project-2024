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
                                                Settings</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="profile-tab4" data-toggle="tab" href="#profile4"
                                                role="tab" aria-controls="profile" aria-selected="false">Pusher
                                                Settings</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="contact-tab4" data-toggle="tab" href="#contact4"
                                                role="tab" aria-controls="contact" aria-selected="false">Contact</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-12 col-sm-12 col-md-10">
                                    <div class="tab-content no-padding" id="myTab2Content">
                                        @include('admin.settings.sections.general-settings')
                                        @include('admin.settings.sections.pusher-settings')
                                        <div class="tab-pane fade" id="contact4" role="tabpanel"
                                            aria-labelledby="contact-tab4">
                                            Vestibulum imperdiet odio sed neque ultricies, ut dapibus mi maximus. Proin
                                            ligula massa, gravida in lacinia efficitur, hendrerit eget mauris. Pellentesque
                                            fermentum, sem interdum molestie finibus, nulla diam varius leo, nec varius
                                            lectus elit id dolor. Nam malesuada orci non ornare vulputate. Ut ut
                                            sollicitudin magna. Vestibulum eget ligula ut ipsum venenatis ultrices. Proin
                                            bibendum bibendum augue ut luctus.
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
    <script></script>
@endpush
