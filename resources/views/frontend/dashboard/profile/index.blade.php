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
                        <div class="my_listing">
                            <h4>Information Update</h4>
                            <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-xl-8 col-md-12">
                                        <div class="row">
                                            <div class="col-xl-6 col-md-6">
                                                <div class="my_listing_single">
                                                    <label>Name<span class="text-danger">*</span></label>
                                                    <div class="input_area">
                                                        <input type="text" name="name" value="{{ $user->name }}"
                                                            placeholder="Enter name here" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-md-6">
                                                <div class="my_listing_single">
                                                    <label>Phone Number<span class="text-danger">*</span></label>
                                                    <div class="input_area">
                                                        <input type="text" name="phonenumber"
                                                            value="{{ $user->phonenumber }}"
                                                            placeholder="Enter phone number here" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="my_listing_single">
                                                    <label>Email<span class="text-danger">*</span></label>
                                                    <div class="input_area">
                                                        <input type="email" name="email" value="{{ $user->email }}"
                                                            placeholder="Enter email here" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="my_listing_single">
                                                    <label>Address<span class="text-danger">*</span></label>
                                                    <div class="input_area">
                                                        <input type="text" name="address" value="{{ $user->address }}"
                                                            placeholder="Enter address here" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="my_listing_single">
                                                    <label>Website</label>
                                                    <div class="input_area">
                                                        <input type="text" name="website" value="{{ $user->website }}"
                                                            placeholder="Enter URL here">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="my_listing_single">
                                                    <label>About Me</label>
                                                    <div class="input_area">
                                                        <textarea name="about" cols="3" rows="3" placeholder="Your Text">{!! $user->about !!}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-md-6">
                                                <div class="my_listing_single">
                                                    <label>Facebook URL</label>
                                                    <div class="input_area">
                                                        <input type="text" name='fb_url' value="{{ $user->fb_url }}"
                                                            placeholder="Enter URL here">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-md-6">
                                                <div class="my_listing_single">
                                                    <label>X URL</label>
                                                    <div class="input_area">
                                                        <input type="text" name='x_url' value="{{ $user->x_url }}"
                                                            placeholder="Enter URL here">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-md-6">
                                                <div class="my_listing_single">
                                                    <label>LinkedIn URL</label>
                                                    <div class="input_area">
                                                        <input type="text" name='linked_url'
                                                            value="{{ $user->linked_url }}" placeholder="Enter URL here">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-md-6">
                                                <div class="my_listing_single">
                                                    <label>Instagram URL</label>
                                                    <div class="input_area">
                                                        <input type="text" name='insta_url'
                                                            value="{{ $user->insta_url }}" placeholder="Enter URL here">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-md-5">
                                        <div class="my_listing_single">
                                            <label for="" class="d-flex justify-content-center">Avatar</label>
                                            <div class="profile_pic_upload">
                                                <img src="{{ asset($user->avatar) }}" alt="img"
                                                    class="imf-fluid w-100">
                                                <input type="file" name="avatar">
                                                <input type="hidden" name="old_avatar" value="{{ $user->avatar }}">
                                            </div>
                                        </div>
                                        <div class="my_listing_single">
                                            <label for="" class="d-flex justify-content-center">Banner</label>
                                            <div class="profile_pic_upload">
                                                <img src="{{ asset($user->banner) }}" alt="img"
                                                    class="imf-fluid w-100">
                                                <input type="file" name="banner">
                                                <input type="hidden" name="old_banner" value="{{ $user->banner }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="read_btn">Update</button>
                                </div>
                            </form>
                        </div>
                        <div class="my_listing list_mar">
                            <h4>Change Password</h4>
                            <form action="{{ route('user.profile-change-password.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-xl-4 col-md-6">
                                        <div class="my_listing_single">
                                            <label>Current Password</label>
                                            <div class="input_area">
                                                <input type="password" name="current_password"
                                                    placeholder="Current Password">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-md-6">
                                        <div class="my_listing_single">
                                            <label>New Password</label>
                                            <div class="input_area">
                                                <input type="password" name="password" placeholder="New Password">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="my_listing_single">
                                            <label>Confirm Password</label>
                                            <div class="input_area">
                                                <input type="password" name="password_confirmation"
                                                    placeholder="Confirm Password">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="read_btn">Change Password</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="my_listing list_mar">
                            <form>
                                <h4>Profile Banner Image</h4>
                                <div class="row">
                                    <div class="col-xl-6 col-md-8 col-lg-6">
                                        <div class="profile_pic_upload banner_pic_upload">
                                            <img src="images/login_breadcrumb.jpg" alt="img"
                                                class="imf-fluid w-100">
                                            <input type="file">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="read_btn">upload</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection