<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\SettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\View\View;

class SettingController extends Controller
{
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

        $settingsService = app(SettingsService::class);
        $settingsService->clearCachedSettings();

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

        $settingsService = app(SettingsService::class);
        $settingsService->clearCachedSettings();

        toastr()->success('Updated Pusher Settings Successfully');
        //Sử dụng phương thức để gọi tới artisan để run command
        Artisan::call('config:cache');
        return redirect()->back();
    }
}
