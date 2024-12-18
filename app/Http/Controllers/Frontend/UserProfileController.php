<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\UserUpdateProfileRequest;
use App\Traits\FileHandlingTrait;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Redirect;

class UserProfileController extends Controller
{
    use FileHandlingTrait;

    function index(): View
    {
        $user = Auth::user();
        return view('frontend.dashboard.profile.index', compact('user'));
    }

    function updateInfo(UserUpdateProfileRequest $request): RedirectResponse
    {
        $newAvatarPath = $this->imageUpload($request, 'avatar', $request->previous_avatar);

        $user = Auth::user();
        $user->avatar = !empty($newAvatarPath) ? $newAvatarPath : $request->previous_avatar;
        $user->name = $request->name;
        $user->phonenumber = $request->phonenumber;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->website = $request->website;
        $user->about = $request->about;
        $user->fb_url = $request->fb_url;
        $user->x_url = $request->x_url;
        $user->linked_url = $request->linked_url;
        $user->insta_url = $request->insta_url;
        $user->save();

        toastr()->success('User information updated successfully');

        return redirect()->back();
    }

    function changePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'min:6', 'confirmed']
        ]);

        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();
        toastr()->success('Updated password successfully');

        return redirect()->back();
    }

    function changeBanner(Request $request): RedirectResponse
    {
        $request->validate([
            'banner' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
        ]);

        $newBannerPath = $this->imageUpload($request, 'banner', $request->previous_banner);

        $user = Auth::user();
        $user->banner = !empty($newBannerPath) ? $newBannerPath : $request->previous_banner;
        $user->save();

        toastr()->success('Banner Image updated successfully');
        return redirect()->back();
    }
}
