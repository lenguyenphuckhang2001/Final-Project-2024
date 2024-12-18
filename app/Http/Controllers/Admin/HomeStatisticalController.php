<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StatisticalUpdateRequest;
use App\Models\Statistical;
use App\Traits\FileHandlingTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeStatisticalController extends Controller
{
    use FileHandlingTrait;

    public function __construct()
    {
        $this->middleware(['permission:home index'])->only(['index', 'update']);
    }

    function index(): View
    {
        $statistical = Statistical::first();
        return view('admin.statistical.index', compact('statistical'));
    }

    function update(StatisticalUpdateRequest $request): RedirectResponse
    {
        $imageBackgroundPath = $this->imageUpload($request, 'background', $request->previous_background);

        Statistical::updateOrCreate(
            ['id' => 1],
            [
                'background' => !empty($imageBackgroundPath) ? $imageBackgroundPath : $request->previous_background,

                'title_first' => $request->title_first,
                'number_first' => $request->number_first,

                'title_second' => $request->title_second,
                'number_second' => $request->number_second,

                'title_third' => $request->title_third,
                'number_third' => $request->number_third,

                'title_fourth' => $request->title_fourth,
                'number_fourth' => $request->number_fourth,
            ]
        );

        toastr()->success('Statistical updated successfully');

        return redirect()->back();
    }
}
