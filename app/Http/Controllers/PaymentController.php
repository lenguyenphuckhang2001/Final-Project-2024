<?php

namespace App\Http\Controllers;

use App\Events\CreateOrder;
use App\Models\Package;
use Illuminate\Http\Request;
use Session;
// Import the class namespaces first, before using it directly
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaymentController extends Controller
{
    //Khởi tại phương thức id của package
    function payableAmount(): int
    {
        //Khởi tạo phương thức với việc get session của package là selected_package_id
        $packageId = Session::get('selected_package_id');
        $package = Package::findOrFail($packageId);
        //Gán giá trị là giá để biết được giá trị của package
        return $package->price;
    }

    function payPalConfig(): array
    {
        return [
            'mode'    => config('payment.paypal_mode'), // Can only be 'sandbox' Or 'live'. If empty or invalid, 'live' will be used.
            'sandbox' => [
                'client_id'         => config('payment.paypal_client_id'),
                'client_secret'     => config('payment.paypal_secret_key'),
                'app_id'            => 'APP-80W284485P519543T',
            ],
            'live' => [
                'client_id'         => config('payment.paypal_client_id'),
                'client_secret'     => config('payment.paypal_secret_key'),
                'app_id'            => config('payment.paypal_app_key'),
            ],

            'payment_action' => env('PAYPAL_PAYMENT_ACTION', 'Sale'), // Can only be 'Sale', 'Authorization' or 'Order'
            'currency'       => config('payment.paypal_currency'),
            'notify_url'     => env('PAYPAL_NOTIFY_URL', ''), // Change this accordingly for your application.
            'locale'         => env('PAYPAL_LOCALE', 'en_US'), // force gateway language  i.e. it_IT, es_ES, en_US ... (for express checkout only)
            'validate_ssl'   => env('PAYPAL_VALIDATE_SSL', true), // Validate SSL when creating api client.
        ];
    }

    function paypalPay()
    {
        $config = $this->payPalConfig();

        $provider = new PayPalClient($config);
        $provider->getAccessToken();

        //Làm tròn số thập phân * với tỷ giá hiện tại của mệnh giá đã set
        $totalPayableAmount = round($this->payableAmount() * config('payment.paypal_currency_rate'));

        $response = $provider->createOrder([
            //intent xác định ý định của giao dịch, ở đây là "CAPTURE", nghĩa là   muốn thanh toán và trừ tiền ngay khi đơn hàng được tạo.
            'intent' => "CAPTURE",
            'application_context' => [
                'return_url' => route('paypal.success'),
                'cancel_url' => route('paypal.cancel')
            ],
            'purchase_units' => [
                [
                    'amount' => [
                        //Mã tiền tệ của giao dịch, được lấy từ cấu hình của hệ thống (config('payment.paypal_currency'))
                        'currency_code' => config('payment.paypal_currency'),
                        'value' => $totalPayableAmount
                    ]
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] !== null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        } else {
        }
    }

    function paypalSuccess(Request $request)
    {
        $config = $this->paypalConfig();
        $provider = new PayPalClient($config);
        $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request->token);

        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            $capture = $response['purchase_units'][0]['payments']['captures'][0];
            $paymentInfo = [
                'transaction_id' => $capture['id'],
                'payment_status' => $capture['status'],
                'payment_method' => 'paypal',
                'paid_amount' => $capture['amount']['value'],
                'paid_currency' => $capture['amount']['currency_code'],
            ];

            CreateOrder::dispatch($paymentInfo);
        };
    }

    function paypalCancel()
    {
        //
    }
}
