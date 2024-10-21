<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreateOrder
{
    /**
     * Dispatchable: Cho phép mình dispatch (gửi) sự kiện này từ bất kỳ đâu trong ứng dụng
     * InteractsWithSockets: Cung cấp các phương thức để tương tác với các socket, thường dùng trong các ứng dụng thời gian thực.
     * SerializesModels: Cho phép serialize (tuần tự hóa) các model khi sự kiện được gửi đi, điều này giúp lưu trữ các thông tin của model trong hàng đợi.
     */
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public array $paymentInfo;
    /**
     * Create a new event instance.
     *
     * Khi một instance của class CreateOrder được tạo, constructor sẽ nhận một mảng $paymentInfo làm tham số.
     * Hàm này sử dụng $this->paymentInfo để gán giá trị của tham số $paymentInfo cho thuộc tính paymentInfo của đối tượng hiện tại.
     */
    public function __construct(array $paymentInfo)
    {
        $this->paymentInfo = $paymentInfo;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * Phương thức này chỉ định các kênh mà sự kiện sẽ được phát sóng (broadcast) trên đó.
     *
     * Trong trường hợp này, sự kiện sẽ được phát sóng trên một PrivateChannel với tên 'channel-name'. Kênh riêng tư yêu cầu người dùng
     * phải xác thực trước khi nhận được thông tin từ sự kiện này, giúp bảo mật dữ liệu.
     *
     * Phương thức này trả về một mảng các kênh, và trong trường hợp này chỉ có một kênh duy nhất
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
