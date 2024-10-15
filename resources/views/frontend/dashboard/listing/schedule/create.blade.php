@extends('frontend.layouts.main')

@push('styles')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
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
                        <div class="my_listing">
                            <h4 class="mb-0">Create Schedule</h4>
                            <div class="card-body">
                                <form action="{{ route('user.schedule.store', $listingId) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Day <span class='text-danger'>*</span></label>
                                                <select name="day" id="" class="form-control select2" required>
                                                    <option value="0">Select</option>
                                                    @foreach (config('schedule.days') as $day)
                                                        <option value="{{ $day }}">{{ $day }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Start Time <span class='text-danger'>*</span></label>
                                                <input type="text" class="form-control timepicker" name="start_time">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">End Time <span class='text-danger'>*</span></label>
                                                <input type="text" class="form-control timepicker" name="end_time">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Status <span class='text-danger'>*</span></label>
                                                <select name="status" id="" class="form-control">
                                                    <option value="1">Active</option>
                                                    <option value="0">Hide</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="read_btn mt-4">Create</button>
                                    </div>
                                </form>
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
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
    <script>
        $('.timepicker').timepicker({
            timeFormat: 'h:mm p',
            interval: 60,
            minTime: '10',
            maxTime: '6:00pm',
            defaultTime: '11',
            startTime: '10:00',
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });
    </script>
@endpush
