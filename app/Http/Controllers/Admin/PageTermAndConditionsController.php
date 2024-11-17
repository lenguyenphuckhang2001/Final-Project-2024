<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TermAndConditions;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageTermAndConditionsController extends Controller
{
    function index(): View
    {
        $termsConditions = TermAndConditions::first();
        return view('admin.pages.terms-and-conditions.index', compact('termsConditions'));
    }

    function update(Request $request): RedirectResponse
    {

        $request->validate([
            'content' => ['required']
        ]);

        TermAndConditions::updateOrCreate(
            ['id' => 1],
            [
                'content' => $request->content
            ]
        );

        toastr()->success('Terms and Conditions updated sucessfully');

        return redirect()->back();
    }
}
