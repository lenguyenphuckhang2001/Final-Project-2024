<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\SettingsService;
use App\Traits\FileHandlingTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\View\View;

class SettingController extends Controller
{
    use FileHandlingTrait;

    public function __construct()
    {
        $this->middleware(['permission:general setting update']);
    }

    function index(): View
    {
        return view('admin.settings.index');
    }

    function updateGeneralSettings(Request $request): RedirectResponse
    {
        $handledValidate = $request->validate([
            'website_name' => ['required', 'max:255'],
            'site_name' => ['required', 'max:255'],
            'site_email' => ['required', 'email', 'max:255'],
            'site_phonenumber' => ['required', 'max:255'],
            'site_timezone' => ['required', 'max:255'],
            'site_default_currency' => ['required', 'max:3'],
            'site_currency_icon' => ['required'],
            'site_currency_position' => ['required', 'in:right,left']
        ]);

        foreach ($handledValidate as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $settingsForService = app(SettingsService::class);
        $settingsForService->clearCachedSettings();

        toastr()->success('Updated General Settings Successfully');
        //Sử dụng phương thức để gọi tới artisan để run command
        Artisan::call('config:cache');

        return redirect()->back();
    }

    function updatePusherSettings(Request $request): RedirectResponse
    {
        $handledValidate = $request->validate([
            'pusher_app_id' => ['required'],
            'pusher_key' => ['required'],
            'pusher_secret' => ['required'],
            'pusher_cluster' => ['required'],
        ]);

        foreach ($handledValidate as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $settingsForService = app(SettingsService::class);
        $settingsForService->clearCachedSettings();

        toastr()->success('Updated Pusher Settings Successfully');
        //Sử dụng phương thức để gọi tới artisan để run command
        Artisan::call('config:cache');

        return redirect()->back();
    }

    function updateFaviconLogoSettings(Request $request): RedirectResponse
    {
        $request->validate([
            'favicon_image' => ['required', 'image', 'max:8192'],
            'logo_image' => ['required', 'image', 'max:8192'],
        ]);

        $newFaviconImage = $this->imageUpload($request, 'favicon_image', $request->previous_favicon);
        $newLogoImage = $this->imageUpload($request, 'logo_image', $request->previous_icon);


        Setting::updateOrCreate(
            ['key' => 'favicon_image'],
            ['value' => !empty($newFaviconImage) ? $newFaviconImage : $request->previous_favicon]
        );

        Setting::updateOrCreate(
            ['key' => 'logo_image'],
            ['value' => !empty($newLogoImage) ? $newLogoImage : $request->previous_icon]
        );

        $settingsForService = app(SettingsService::class);
        $settingsForService->clearCachedSettings();

        toastr()->success('Updated Logo and Favicon Settings Successfully');
        //Sử dụng phương thức để gọi tới artisan để run command
        Artisan::call('config:cache');

        return redirect()->back();
    }

    function breadcrumbBackgroundSettings(Request $request): RedirectResponse
    {
        $request->validate([
            'bkg_listing_page' => ['required', 'image', 'max:10240'],
            'bkg_listing_categories' => ['required', 'image', 'max:10240'],
            'bkg_about_us' => ['required', 'image', 'max:10240'],
            'bkg_blog' => ['required', 'image', 'max:10240'],
            'bkg_contact_us' => ['required', 'image', 'max:10240'],
            'bkg_term_condition' => ['required', 'image', 'max:10240'],
            'bkg_privacy_policy' => ['required', 'image', 'max:10240'],
        ]);

        $newListingPath = $this->imageUpload($request, 'bkg_listing_page', $request->previous_listing_page);
        $newListingCategoriesPath = $this->imageUpload($request, 'bkg_listing_categories', $request->previous_listing_categories);
        $newAboutUsPath = $this->imageUpload($request, 'bkg_about_us', $request->previous_about_us);
        $newBlogPath = $this->imageUpload($request, 'bkg_blog', $request->previous_bkg_blog);
        $newContactPath = $this->imageUpload($request, 'bkg_contact_us', $request->previous_contact_us);
        $newTermConditionPath = $this->imageUpload($request, 'bkg_term_condition', $request->previous_term_condition);
        $newPrivacyPolicyPath = $this->imageUpload($request, 'bkg_privacy_policy', $request->previous_privacy_policy);

        Setting::updateOrCreate(
            ['key' => 'bkg_listing_page'],
            ['value' => !empty($newListingPath) ? $newListingPath : $request->previous_listing_page]
        );

        Setting::updateOrCreate(
            ['key' => 'bkg_listing_categories'],
            ['value' => !empty($newListingCategoriesPath) ? $newListingCategoriesPath : $request->previous_listing_categories]
        );

        Setting::updateOrCreate(
            ['key' => 'bkg_about_us'],
            ['value' => !empty($newAboutUsPath) ? $newAboutUsPath : $request->previous_about_us]
        );

        Setting::updateOrCreate(
            ['key' => 'bkg_blog'],
            ['value' => !empty($newBlogPath) ? $newBlogPath : $request->previous_bkg_blog]
        );

        Setting::updateOrCreate(
            ['key' => 'bkg_contact_us'],
            ['value' => !empty($newContactPath) ? $newContactPath : $request->previous_contact_us]
        );

        Setting::updateOrCreate(
            ['key' => 'bkg_term_condition'],
            ['value' => !empty($newTermConditionPath) ? $newTermConditionPath : $request->previous_term_condition]
        );

        Setting::updateOrCreate(
            ['key' => 'bkg_privacy_policy'],
            ['value' => !empty($newPrivacyPolicyPath) ? $newPrivacyPolicyPath : $request->previous_privacy_policy]
        );

        $settingsForService = app(SettingsService::class);
        $settingsForService->clearCachedSettings();

        toastr()->success('Update color for website successfully');
        Artisan::call('config:cache');

        return redirect()->back();
    }
}
