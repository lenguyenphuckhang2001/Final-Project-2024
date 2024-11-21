<div class="tab-pane fade" id="contact4" role="tabpanel" aria-labelledby="contact-tab4">
    <div class="card border">
        <div class="card-body">
            <form action="{{ route('admin.favicon-and-logo-settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Favicon Webstie </label>
                            <div id="image-preview" class="image-preview favicon-setting">
                                <label for="image-upload" id="image-label">Choose File</label>
                                <input type="file" name="favicon_image" id="image-upload" />
                                <input type="hidden" name="previous_favicon" value="{{ config('settings.favicon_image') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Icon Webstie</label>
                            <div id="image-preview-2" class="image-preview logo-setting">
                                <label for="image-upload-2" id="image-label-2">Choose File</label>
                                <input type="file" name="logo_image" id="image-upload-2" />
                                <input type="hidden" name="previous_icon" value="{{ config('settings.logo_image') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
