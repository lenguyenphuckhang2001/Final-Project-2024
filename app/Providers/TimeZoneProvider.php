<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;

class TimeZoneProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $timezone = Setting::where('key', 'site_timezone')->first();
        config()->set('app.timezone', $timezone->value);
    }
}
