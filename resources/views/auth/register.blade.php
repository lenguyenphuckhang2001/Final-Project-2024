@extends('frontend.layouts.main')

@section('contents')
    <section class="wsus__login_page">
        <div class="container">
            <div class="row">
                <div class="col-xxl-5 col-xl-6 col-md-9 col-lg-7 m-auto">
                    <div class="wsus__login_area">
                        <h2>Sign Up</h2>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="wsus__login_imput">
                                        <label>Name</label>
                                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Name"
                                            required autofocus autocomplete="name">
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="wsus__login_imput">
                                        <label>Email</label>
                                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email"
                                            required autocomplete="username">
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="wsus__login_imput">
                                        <label>Password</label>
                                        <input type="password" name="password" placeholder="Password" required>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="wsus__login_imput">
                                        <label>Confirm Password</label>
                                        <input type="password" name="password_confirmation" placeholder="Confirm Password"
                                            required>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="wsus__login_imput">
                                        <button type="submit" class="common_btn">Sign Up</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <p class="create_account">Already have an account? <a href="{{ route('login') }}">Sign In</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
