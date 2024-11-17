<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrivacyPolicy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PagePrivacyPolicyController extends Controller
{
    function index(): View
    {
        $privacyPolicy = PrivacyPolicy::first();
        return view('admin.pages.privacy-policy.index', compact('privacyPolicy'));
    }

    function update(Request $request): RedirectResponse
    {
        $request->validate([
            'content' => ['required']
        ]);

        PrivacyPolicy::updateOrCreate(
            ['id' => 1],
            [
                'content' => $request->content
            ]
        );

        toastr()->success('Privacy policy updated sucessfully');

        return redirect()->back();
    }
}
