<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ProfileUpdateUserRequest;
use App\Traits\FileUploadTrait;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FrontendProfileController extends Controller
{
    use FileUploadTrait;

    function index(): View
    {
        $user = Auth::user();
        return view('frontend.dashboard.profile.index', compact('user'));
    }

    function updateInfo(ProfileUpdateUserRequest $request): RedirectResponse
    {
        $avatarPath = $this->uploadImage($request, 'avatar', $request->old_avatar);
        $bannerPath = $this->uploadImage($request, 'banner', $request->old_banner);

        $user = Auth::user();
        $user->avatar = !empty($avatarPath) ? $avatarPath : $request->old_avatar;
        $user->banner = !empty($bannerPath) ? $bannerPath : $request->old_banner;
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
}