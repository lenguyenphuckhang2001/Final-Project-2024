<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfileEditRequest;
use App\Models\User;
use App\Traits\FileUploadTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Auth;


class AdminProfileController extends Controller
{
    use FileUploadTrait;

    function index(): View
    {
        $user = Auth::user();
        return view('admin.profile.index', compact('user'));
    }

    function update(ProfileEditRequest $request): RedirectResponse
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
