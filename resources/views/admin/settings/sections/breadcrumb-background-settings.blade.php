<div class="tab-pane fade" id="pallete4" role="tabpanel" aria-labelledby="pallete-tab4">
    <div class="card border">
        <div class="card-body">
            <form action="{{ route('admin.breadcrumb-background-settings.update') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Background Listings Page</label>
                            <div id="image-preview-8" class="image-preview listing-img" style="width: 100%">
                                <label for="image-upload-8" id="image-label-8">Choose File</label>
                                <input type="file" name="bkg_listing_page" id="image-upload-8" />
                                <input type="hidden" name="previous_listing_page"
                                    value="{{ config('settings.bkg_listing_page') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Background Listing Categories</label>
                            <div id="image-preview-9" class="image-preview listing-categories-img" style="width: 100%">
                                <label for="image-upload-9" id="image-label-9">Choose File</label>
                                <input type="file" name="bkg_listing_categories" id="image-upload-9" />
                                <input type="hidden" name="previous_listing_categories"
                                    value="{{ config('settings.bkg_listing_categories') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Background About Us Page</label>
                            <div id="image-preview-3" class="image-preview about-us-img" style="width: 100%">
                                <label for="image-upload-3" id="image-label-3">Choose File</label>
                                <input type="file" name="bkg_about_us" id="image-upload-3" />
                                <input type="hidden" name="previous_about_us"
                                    value="{{ config('settings.bkg_about_us') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Background Blog Page</label>
                            <div id="image-preview-4" class="image-preview blog-page-img" style="width: 100%">
                                <label for="image-upload-4" id="image-label-4">Choose File</label>
                                <input type="file" name="bkg_blog" id="image-upload-4" />
                                <input type="hidden" name="previous_bkg_blog"
                                    value="{{ config('settings.bkg_blog') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Background Contact Us Page</label>
                            <div id="image-preview-5" class="image-preview contact-us-img" style="width: 100%">
                                <label for="image-upload-5" id="image-label-5">Choose File</label>
                                <input type="file" name="bkg_contact_us" id="image-upload-5" />
                                <input type="hidden" name="previous_contact_us"
                                    value="{{ config('settings.bkg_contact_us') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Background Term And Condition Page</label>
                            <div id="image-preview-6" class="image-preview term-condition-img" style="width: 100%">
                                <label for="image-upload-6" id="image-label-6">Choose File</label>
                                <input type="file" name="bkg_term_condition" id="image-upload-6" />
                                <input type="hidden" name="previous_term_condition"
                                    value="{{ config('settings.bkg_term_condition') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Background Privacy Policy Page</label>
                            <div id="image-preview-7" class="image-preview privacy-policy-img" style="width: 100%">
                                <label for="image-upload-7" id="image-label-7">Choose File</label>
                                <input type="file" name="bkg_privacy_policy" id="image-upload-7" />
                                <input type="hidden" name="previous_privacy_policy"
                                    value="{{ config('settings.bkg_privacy_policy') }}">
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
