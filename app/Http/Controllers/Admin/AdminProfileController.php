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
        $avatarPath = $this->uploadImage($request, 'avatar');
        $bannerPath = $this->uploadImage($request, 'banner');

        $user = Auth::user();
        $user->avatar = !empty($avatarPath) ? $avatarPath : '';
        $user->banner = !empty($bannerPath) ? $bannerPath : '';
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

        return redirect()->back();
    }
}
