@extends('admin.layouts.main')

@section('contents')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.listing.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Listing | Video Gallery</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('admin.listing.index') }}">Listing</a></div>
                <div class="breadcrumb-item">Video Gallery</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Video Gallery | Title Listing: <span class="text-danger">{{ $titleListing->title }}</span>
                            </h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.video-gallery.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="">Video URL <span class="text-primary">(Just Support Youtube
                                            URL)</span></label>
                                    <input type="text" class="form-control" name="video_url">
                                    <!--Sử dụng request() helper để lấy giá trị listing_id từ yêu cầu -->
                                    <input type="hidden" name="listing_id" value="{{ request()->id }}">

                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Upload Video</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>All Videos</h4>
                        </div>
                        <div class="card-body">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-md">
                                        <tr>
                                            <th>#</th>
                                            <th>Video</th>
                                            <th>URL</th>
                                            <th>Action</th>
                                        </tr>

                                        @foreach ($videos as $video)
                                            <tr>
                                                <th scope='row'>{{ ++$loop->index }}</th>
                                                <td>
                                                    <img width="150px" src="{{ getURL($video->video_url) }}"
                                                        alt="video">
                                                </td>
                                                <td>
                                                    <a href="{{ $video->video_url }}"
                                                        target="_blank">{{ $video->video_url }}</a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.video-gallery.destroy', $video->id) }}"
                                                        class="delete-item btn btn-lg btn-danger"><i
                                                            class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </table>
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
@endpush
