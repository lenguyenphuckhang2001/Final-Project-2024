<?php

namespace App\Listeners;

use App\Events\CreateOrder;
use App\Models\Order;
use App\Models\Package;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Session;

class CreateOrderListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CreateOrder $event): void
    {
        //Tạo một event giúp xử lý các dữ liệu dựa trên listener của order paypal ở đây là khởi tạo các giá trị để lưu vào DB
        $package = Package::find(Session::get('selected_package_id'));
        $order = new Order();
        $order->order_id = uniqid(); //Tạo một uniqid để tránh không trùng lặp id
        $order->transaction_id = $event->paymentInfo['transaction_id'];
        $order->user_id = auth()->user()->id;
        $order->package_id = $package->id;
        $order->payment_method = $event->paymentInfo['payment_method'];
        $order->payment_status = $event->paymentInfo['payment_status'];
        $order->base_amount = $package->price;
        $order->base_currency = config('settings.site_default_currency');
        $order->paid_amount = $event->paymentInfo['paid_amount'];
        $order->paid_currency = $event->paymentInfo['paid_currency'];
        $order->purchase_date = now();
        $order->save();


        /**
         * Xử lý hàm event với subscription với mục đích là nếu chưa có thì sẽ khởi tạo hoặc update
         *
         * Đầu tiên sẽ tìm tới liệu có ID hay không nếu có thì sẽ khởi tạo tiếp theo
         * Sau đó dựa theo các biến nối vào cái giá trị và điền chúng thích hợp với các giá trị thích hợp
         */
        Subscription::updateOrCreate(
            [
                'user_id' => auth()->user()->id
            ],
            [
                'package_id' => $package->id,
                'order_id' => $order->id, // ID ở đây không phải là $order->id.unique mà là row.id của order trong bảng order
                'purchase_date' => $order->purchase_date,
                /**
                 * Hàm Carbon::parse() được dùng để phân tích chuỗi ngày và chuyển đổi nó thành một đối tượng Carbon
                 *
                 * Khi chuyển đổi ngày mua hàng từ chuỗi sang đối tượng Carbon, bạn có thể dễ dàng thực hiện các thao tác với ngày,
                 * chẳng hạn như thêm ngày vào ngày mua, tính ngày hết hạn (expire date), hoặc làm bất kỳ thao tác nào liên quan đến
                 * ngày tháng một cách chính xác và tiện lợi.
                 */
                'expire_date' => $package->limit_days == -1 ? null : Carbon::parse($order->purchase_date)->addDay($package->limit_days),
                'status' => 1,
            ]
        );

        //Sau khi đã khởi tạo hoàn thành thực hiện việc xóa đi session của người dùng 
        Session::forget('selected_package_id');
    }
}
