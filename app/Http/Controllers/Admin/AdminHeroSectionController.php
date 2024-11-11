<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HeroSectionUpdateRequest;
use App\Models\Hero;
use App\Traits\FileHandlingTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Auth;

class AdminHeroSectionController extends Controller
{
    use FileHandlingTrait;

    function index(): View
    {
        $hero = Hero::first();
        return view('admin.hero.index', compact('hero'));
    }

    function update(HeroSectionUpdateRequest $request): RedirectResponse
    {
        $backgroundImagePath = $this->imageUpload($request, "background", $request->old_background);

        Hero::updateOrCreate(
            ['id' => 1],
            [
                "background" => !empty($backgroundImagePath) ? $backgroundImagePath : $request->old_background,
                "title" => $request->title,
                "sub_title" => $request->sub_title
            ]
        );

        toastr()->success("Hero section has been updated successfully");

        return redirect()->back();
    }
}
