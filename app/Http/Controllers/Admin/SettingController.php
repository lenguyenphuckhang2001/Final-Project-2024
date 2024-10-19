<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\SettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    function index(): View
    {
        return view('admin.settings.index');
    }

    function updateGeneralSettings(Request $request): RedirectResponse
    {
        $handledValidate = $request->validate([
            'site_name' => ['required', 'max:255'],
            'site_email' => ['required', 'email', 'max:255'],
            'site_phonenumber' => ['required', 'max:255'],
            'site_default-currency' => ['required', 'max:3'],
            'site_currency_icon' => ['required'],
            'site_currenct_position' => ['required', 'in:right,left']
        ]);

        foreach ($handledValidate as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $settingsService = app(SettingsService::class);
        $settingsService->clearCachedSettings();

        toastr()->success('Updated General Settings Successfully');

        return redirect()->back();
    }
}
