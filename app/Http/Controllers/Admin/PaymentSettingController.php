<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentSetting;
use App\Services\PaymentSettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentSettingController extends Controller
{
    function index(): View
    {
        return view('admin.payment-settings.index');
    }

    function updatePaypal(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'paypal_status' => ['required', 'in:active,hide'],
            'paypal_mode' => ['required', 'in:sandbox,live'],
            'paypal_country' => ['required'],
            'paypal_currency' => ['required'],
            'paypal_currency_rate' => ['required'],
            'paypal_client_id' => ['required'],
            'paypal_secret_key' => ['required'],
            'paypal_app_key' => ['required']
        ]);

        foreach ($validatedData as $key => $value) {
            PaymentSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $paymentSettingsService = app(PaymentSettingsService::class);
        $paymentSettingsService->clearCachedSettings();

        toastr()->success('Updated payment paypal successfully');

        return redirect()->back();
    }
}
