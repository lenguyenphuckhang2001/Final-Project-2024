<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AboutUsUpdateRequest;
use App\Models\AboutUs;
use App\Traits\FileHandlingTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageAboutUsController extends Controller
{
    use FileHandlingTrait;

    public function __construct()
    {
        $this->middleware(['permission:package update'])->only(['index', 'update']);
    }

    function index(): View
    {
        $aboutUs = AboutUs::first();
        return view('admin.pages.about-us.index', compact('aboutUs'));
    }

    function update(AboutUsUpdateRequest $request): RedirectResponse
    {
        $newSmallImage = $this->imageUpload($request, 'image_small', $request->previous_small_image);
        $newImageVideo = $this->imageUpload($request, 'image_video', $request->previous_image_video);

        AboutUs::updateOrCreate(
            ['id' => 1],
            [
                'image_small' => !empty($newSmallImage) ? $newSmallImage : $request->previous_small_image,
                'image_video' => !empty($newImageVideo) ? $newImageVideo : $request->previous_image_video,
                'title' => $request->title,
                'content' => $request->content,
                'video_url' => $request->video_url
            ]
        );

        toastr()->success('About us page updated successfully');

        return redirect()->back();
    }
}
