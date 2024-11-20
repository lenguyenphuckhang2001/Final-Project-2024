<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HeroUpdateRequest;
use App\Models\Hero;
use App\Traits\FileHandlingTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeHeroController extends Controller
{
    use FileHandlingTrait;

    public function __construct()
    {
        $this->middleware(['permission:home index'])->only(['index']);
        $this->middleware(['permission:home update'])->only(['update']);
    }

    function index(): View
    {
        $hero = Hero::first();
        return view('admin.hero.index', compact('hero'));
    }

    function update(HeroUpdateRequest $request): RedirectResponse
    {
        $backgroundImagePath = $this->imageUpload($request, "background", $request->previous_background);

        Hero::updateOrCreate(
            ['id' => 1],
            [
                "background" => !empty($backgroundImagePath) ? $backgroundImagePath : $request->previous_background,
                "title" => $request->title,
                "sub_title" => $request->sub_title
            ]
        );

        toastr()->success("Hero section has been updated successfully");

        return redirect()->back();
    }
}
