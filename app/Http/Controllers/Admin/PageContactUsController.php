<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ContactUsUpdateRequest;
use App\Models\ContactUs;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageContactUsController extends Controller
{
    function index(): View
    {
        $contactUs = ContactUs::first();
        return view('admin.pages.contact-us.index', compact('contactUs'));
    }

    function update(ContactUsUpdateRequest $request): RedirectResponse
    {
        ContactUs::updateOrCreate(
            ['id' => 1],
            [
                'phonenumber_one' => $request->phonenumber_one,
                'phonenumber_two' => $request->phonenumber_two,
                'email_one' => $request->email_one,
                'email_two' => $request->email_two,
                'address' => $request->address,
                'map_embed_code' => $request->map_embed_code,
            ]
        );

        toastr()->success('Contact us updated successfully');

        return redirect()->back();
    }
}
