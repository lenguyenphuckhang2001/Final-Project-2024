<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class ProviderController extends Controller
{
    function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    function handleCallback($provider)
    {
        try {
            $userSocialite = Socialite::driver($provider)->user();

            $existingUser = User::where('email', $userSocialite->getEmail())->first();
            if ($existingUser) {
                if (!$existingUser->provider || !$existingUser->provider_id) {
                    $existingUser->update([
                        'provider' => $provider,
                        'provider_id' => $userSocialite->getId(),
                        'provider_token' => $userSocialite->token,
                    ]);
                }

                Auth::login($existingUser);
                return redirect()->route('user.dashboard');
            }

            // Tìm user qua provider và provider_id
            $user = User::where([
                'provider' => $provider,
                'provider_id' => $userSocialite->getId(),
            ])->first();

            if (!$user) {
                // Tạo user mới
                $user = User::create([
                    'name' => $userSocialite->getName(),
                    'email' => $userSocialite->getEmail(),
                    'password' => bcrypt(\Str::random(24)),
                    'provider' => $provider,
                    'provider_id' => $userSocialite->getId(),
                    'provider_token' => $userSocialite->token,
                ]);
            }

            Auth::login($user);
            
            return redirect()->route('user.dashboard');
        } catch (\Exception $e) {
            \Log::error('OAuth Error: ' . $e->getMessage());
            return redirect()->route('login');
        }
    }
}
