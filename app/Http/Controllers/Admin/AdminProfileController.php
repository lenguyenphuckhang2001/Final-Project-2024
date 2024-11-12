<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfileEditRequest;
use App\Traits\FileHandlingTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Auth;


class AdminProfileController extends Controller
{
    use FileHandlingTrait;

    function index(): View
    {
        $user = Auth::user();
        return view('admin.profile.index', compact('user'));
    }

    function update(ProfileEditRequest $request): RedirectResponse
    {
        $newAvatarPath = $this->imageUpload($request, 'avatar', $request->previous_avatar);
        $newBannerPath = $this->imageUpload($request, 'banner', $request->previous_banner);

        $user = Auth::user();
        $user->avatar = !empty($newAvatarPath) ? $newAvatarPath : $request->previous_avatar;
        $user->banner = !empty($newBannerPath) ? $newBannerPath : $request->previous_banner;
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

        toastr()->success('Updated information successfully');

        return redirect()->back();
    }

    function changePassword(Request $request): RedirectResponse
    {

        $request->validate([
            'password' => [
                'required',
                'min:6',
                // 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/',//Required at least 1 character uppercase and 1 number
                'confirmed'
            ]
        ]);

        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();

        toastr()->success('Updated password successfully');

        return redirect()->back();
    }
}
