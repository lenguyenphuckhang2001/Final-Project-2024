<?php

namespace App\Http\Controllers;

use App\Events\CreateOrder;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Session;
// Import the class namespaces first, before using it directly
use Srmklive\PayPal\Services\PayPal as PayPalClient;
//Use session stripe lib
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class PaymentController extends Controller
{
    function paymentSuccess(): View
    {
        return view('frontend.pages.payment.payment-success');
    }

    function paymentCancel(): View
    {
        return view('frontend.pages.payment.payment-cancel');
    }

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


        // Kiểm tra xem 'id' trong biến $response có tồn tại và không phải là null
        if (isset($response['id']) && $response['id'] !== null) {
            // Nếu 'id' hợp lệ, lặp qua từng liên kết trong $response['links']
            foreach ($response['links'] as $link) {
                // Kiểm tra xem loại liên kết (rel) có phải là 'approve' không
                if ($link['rel'] === 'approve') {
                    // Nếu có, chuyển hướng người dùng đến URL để phê duyệt thanh toán
                    return redirect()->away($link['href']);
                }
            }
        } else {
            logger($response); // Ghi lại thông tin lỗi
            return redirect()->route('payment.cancel')->withErrors(['error' => $response['error']['message']]);
        }
    }

    function paypalSuccess(Request $request)
    {
        //Lấy cấu hình PayPal
        $config = $this->paypalConfig();

        // Tạo một instance của PayPalClient với cấu hình đã lấy
        $provider = new PayPalClient($config);

        /* Gọi phương thức getAccessToken để lấy Access Token từ PayPal
        Access Token sẽ được sử dụng để xác thực các yêu cầu API */
        $provider->getAccessToken();

        /* Gọi phương thức capturePaymentOrder để bắt thanh toán cho đơn hàng
        Tham số $request->token là token của đơn hàng đã được tạo trước đó
        Phương thức này sẽ thực hiện việc bắt thanh toán và trả về kết quả */
        $response = $provider->capturePaymentOrder($request->token);

        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            //Hàm capture nhằm chỉ dẫn đến các giá trị cần thiết của paymentInfo cần lấy mà không cần phải viết dài dòng
            $capture = $response['purchase_units'][0]['payments']['captures'][0];
            //Lấy các giá trị từ hàm listener để gán vào đây để có thể dễ dàng quản lý chúng
            $paymentInfo = [
                'transaction_id' => $capture['id'],
                'payment_status' => $capture['status'],
                'payment_method' => 'paypal',
                'paid_amount' => $capture['amount']['value'],
                'paid_currency' => $capture['amount']['currency_code'],
            ];

            //Sau khi đã xác định các phương thức hợp lệ khởi tạo dispatch dùng để xử lý các hoạt động riêng biệt nhằm tránh gây ra sự quá tải đối với web
            CreateOrder::dispatch($paymentInfo);
            return redirect()->route('payment.success');
        };
    }

    function paypalCancel()
    {
        return redirect()->route('payment.cancel');
    }

    /* Stripe Payment */
    function stripePay()
    {
        //Set API cho key
        Stripe::setApiKey(config('payment.stripe_secret_key'));

        //Bởi vì stripe tính từ cent nên 100cent sẽ quy đổi thành 1$ vậy nên phải *100
        $totalPayableAmount = round($this->payableAmount() * config('payment.stripe_currency_rate')) * 100;

        $response = StripeSession::create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => config('payment.stripe_currency'),
                        'product_data' => [
                            'name' => 'Package'
                        ],
                        'unit_amount' => $totalPayableAmount
                    ],
                    'quantity' => 1
                ]
            ],
            'mode' => 'payment',
            'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('stripe.cancel'),
        ]);

        return redirect()->away($response->url);
    }

    function stripeSuccess(Request $request)
    {
        $sessionId = $request->session_id;

        Stripe::setApiKey(config('payment.stripe_secret_key'));

        $response = StripeSession::retrieve($sessionId);

        if ($response->payment_status === 'paid') {
            $paymentInfo = [
                'transaction_id' => $response->payment_intent,
                'payment_status' => 'completed',
                'payment_method' => 'stripe',
                'paid_amount' => $response->amount_total,
                'paid_currency' => $response->currency,
            ];

            CreateOrder::dispatch($paymentInfo);

            return redirect()->route('payment.success');
        } else {
            return redirect()->route('payment.cancel');
        }
    }

    function stripeCancel()
    {
        return redirect()->route('payment.cancel');
    }
}
