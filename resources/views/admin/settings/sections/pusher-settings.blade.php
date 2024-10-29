<div class="tab-pane fade" id="profile4" role="tabpanel" aria-labelledby="profile-tab4">
    <div class="card border">
        <div class="card-body">
            <form action="{{ route('admin.pusher-settings.update') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Pusher App Id</label>
                            <input type="text" class="form-control" name="pusher_app_id"
                                value={{ config('settings.pusher_app_id') }}>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Pusher App Key</label>
                            <input type="text" class="form-control" name="pusher_app_key"
                                value={{ config('settings.pusher_app_key') }}>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Pusher App Secrect</label>
                            <input type="text" class="form-control" name="pusher_app_secret"
                                value={{ config('settings.pusher_app_secret') }}>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Pusher App Cluster</label>
                            <input type="text" class="form-control" name="pusher_app_cluster"
                                value={{ config('settings.pusher_app_cluster') }}>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>
