<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\ContactUsEmail;
use App\Models\AboutUs;
use App\Models\Category;
use App\Models\ContactUs;
use App\Models\Feature;
use App\Models\PrivacyPolicy;
use App\Models\Statistical;
use App\Models\TermAndConditions;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class GuestPagesController extends Controller
{
    function aboutUsIndex(): View
    {
        $aboutUs = AboutUs::first();
        $statistical = Statistical::first();
        $homeFeatures = Feature::where('status', 1)->take(3)->get();

        $homeCategory = Category::withCount(['listings' => function ($query) {
            $query->where('is_accepted', 1);
        }])->where(['display_at_home' => 1, 'status' => 1])
            ->take(9)
            ->get();

        return view('frontend.pages.about-us', compact('aboutUs', 'statistical', 'homeFeatures', 'homeCategory'));
    }

    function contactUsIndex(): View
    {
        $contactUs = ContactUs::first();
        return view('frontend.pages.contact-us', compact('contactUs'));
    }

    function sendContactEmail(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'lowercase', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required']
        ]);

        Mail::to(config('settings.site_email'))->send(new ContactUsEmail($request->name, $request->subject, $request->message));

        toastr()->success('Send email message successfully');

        return redirect()->back();
    }


    function privacyPolicyIndex(): View
    {
        $privacyPolicy = PrivacyPolicy::first();
        return view('frontend.pages.privacy-policy', compact('privacyPolicy'));
    }

    function termAndConditionIndex(): View
    {
        $termsConditions = TermAndConditions::first();
        return view('frontend.pages.terms_and_conditions', compact('termsConditions'));
    }

}