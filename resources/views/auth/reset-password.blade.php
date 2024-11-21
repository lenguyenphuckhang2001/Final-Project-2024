@extends('frontend.layouts.main')

@push('styles')
    <style>
        input[readonly] {
            background-color: #f0f0f0 !important;
            /* Màu xám nhạt */
            color: #6c757d !important;
            /* Màu chữ xám */
            cursor: not-allowed !important;
            /* Hiệu ứng chuột khi hover */
            border: 1px solid #ddd !important;
            /* Viền mờ */
        }
    </style>
@endpush
@section('contents')
    <section class="wsus__login_page">
        <div class="container">
            <div class="row">
                <div class="col-xxl-5 col-xl-6 col-md-9 col-lg-7 m-auto">
                    <div class="wsus__login_area">
                        <p>Reset your password</p>
                        <form method="POST" action="{{ route('password.store') }}">
                            @csrf
                            <!-- Password Reset Token -->
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="col-xl-12">
                                        <div class="wsus__login_imput">
                                            <label>Email</label>
                                            <input type="email" name="email" value="{{ old('email', $request->email) }}"
                                                placeholder="Email" readonly required>
                                        </div>
                                    </div>
                                    <div class="wsus__login_imput">
                                        <label>Password</label>
                                        <input type="password" name="password" placeholder="Password" required
                                            autocomplete="new-password">
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="wsus__login_imput">
                                        <label>Confirm Password</label>
                                        <input type="password" name="password_confirmation" placeholder="Confirm Password"
                                            required autocomplete="new-password">
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="wsus__login_imput">
                                        <button type="submit" class="common_btn">Reset Password</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
