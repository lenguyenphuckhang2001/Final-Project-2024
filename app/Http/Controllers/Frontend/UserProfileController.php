<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\UserUpdateProfileRequest;
use App\Traits\FileUploadTrait;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Redirect;

class UserProfileController extends Controller
{
    use FileUploadTrait;

    function index(): View
    {
        $user = Auth::user();
        return view('frontend.dashboard.profile.index', compact('user'));
    }

    function updateInfo(UserUpdateProfileRequest $request): RedirectResponse
    {
        $avatarPath = $this->uploadImage($request, 'avatar', $request->old_avatar);

        $user = Auth::user();
        $user->avatar = !empty($avatarPath) ? $avatarPath : $request->old_avatar;
        $user->name = $request->name;
        $user->phonenumber = $request->phonenumber;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->website = $request->website;
        $user->about = $request->about;
        $user->x_url = $request->fb_url;
        $user->x_url = $request->x_url;
        $user->linked_url = $request->linked_url;
        $user->insta_url = $request->insta_url;
        $user->save();

        toastr()->success('Updated information successfully');

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

        $bannerPath = $this->uploadImage($request, 'banner', $request->old_banner);

        $user = Auth::user();
        $user->banner = !empty($bannerPath) ? $bannerPath : $request->old_banner;
        $user->save();

        toastr()->success('Updated banner image successfully');
        return redirect()->back();
    }
}
