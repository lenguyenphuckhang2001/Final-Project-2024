<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginOAuthController extends Controller
{
    function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        // Kiểm tra xem người dùng đã tồn tại chưa
        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            Auth::login($user, true);
        } else {
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => bcrypt(\Str::random(24)),
                'avatar' => $googleUser->getAvatar(),
            ]);
            Auth::login($user, true);
        }

        return redirect()->intended('/');  // Chuyển hướng đến trang chính
    }

    function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    function handleFacebookCallback()
    {
        $facebookUser = Socialite::driver('facebook')->user();

        $user = User::where('email', $facebookUser->getEmail())->first();

        if ($user) {
            Auth::login($user, true);
        } else {
            $user = User::create([
                'name' => $facebookUser->getName(),
                'email' => $facebookUser->getEmail(),
                'password' => bcrypt(\Str::random(24)),
                'avatar' => $facebookUser->getAvatar()
            ]);
            Auth::login($user, true);
        }

        return redirect()->intended('/');
    }
}
