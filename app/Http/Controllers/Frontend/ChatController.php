<?php

namespace App\Http\Controllers\Frontend;

use App\Events\LiveMessage;
use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ChatController extends Controller
{
    function index(): View
    {
        $senderId = auth()->user()->id;

        $receivers = Chat::with(['receiverInfo', 'listingInfo']) //Sử dụng receiverInfo và lítingInfo dùng để giảm thông tin liên quan đến profile(id) của người nhận (receiver)
            ->select('receiver_id', 'listing_id') //Chỉ lấy receiver_id và listing_id từ bảng Chat để giảm bớt lượng dữ liệu không cần thiết.
            ->where('sender_id', $senderId) //Đảm bảo chỉ có sender_id là ID của người gửi hiện tại. Điều này nhằm lọc ra tất cả các tin nhắn đã gửi của người dùng hiện tại
            ->where('receiver_id', '!=', $senderId) //Điều kiện này sẽ không lấy những cuộc trò chuyện mà gửi cũng là người nhận
            ->selectRaw('MAX(created_at) as chat_latest_message') //selectRaw cho phép sử dụng SQL thô, bao gồm các phép toán, hàm tổng hợp (như MAX(), COUNT(), v.v.) mà select không làm được. MAX ở đây là lấy thời gian tạo mới nhất và gán giá trị vào để sử dụng
            ->groupBy('receiver_id', 'listing_id') //Nhóm các bản ghi theo receiver_id và listing_id giúp loại bỏ các bản ghi trùng lặp chỉ giữ lại 1 bản nhất cho receiver. Ví dụ, người nhận chỉ xuất hiện một lần trong kết quả chatbox.
            ->orderByDesc('chat_latest_message')
            ->get()
            ->map(function ($receiver) use ($senderId) {
                $receiver->unreadMessage = Chat::where([
                    'sender_id' => $receiver->receiver_id,
                    'receiver_id' => $senderId,
                    'listing_id' => $receiver->listing_id,
                    'seen' => 0,
                ])->exists();
                /** Giải thích hàm map
                 * Sử dụng hàm map để tập hợp mới các phần tử đã được biến đổi mà không thay đổi trực tiếp từ ban đầu. Nghĩa là mình
                 * không muốn chỉ duyệt qua các phần tử receiver mà còn muốn gán thêm thuộc tính unreadMessage vào cho từng phần tử receiver
                 * Gọi tới use ($senderId) vì khi $senderId được khai báo bên ngoài (anonymous function) nên để sử dụng biến bên ngoài phải
                 * gọi tới hàm use để sử dụng chúng vì mỗi hàm trong PHP đều có scope riêng biệt
                 * $receiver->unreadMessage: Gọi tới hàm này để biến đổi các phần tử $receiver với việc sử dụng unreadMessage để query các phần
                 * tử với seen sẽ bằng 0
                 * Hàm exist() là hàm boolean sẽ kiểm tra xem có tin nhắn nào từ người gửi (sender_id) là $receiver->receiver_id gửi đến người dùng hiện tại
                 * (receiver_id là auth()->user()->id) trong cùng một listing mà chưa được đọc (seen là 0) hay không. Nếu đúng đúng là true ngược lại false
                 */
                return $receiver;
            });

        return view('frontend.dashboard.message.index', compact('receivers'));
    }

    function newMessage(Request $request): Response
    {
        $request->validate([
            'listing_id' => ['required', 'integer'],
            'receiver_id' => ['required', 'integer'],
            'message' => ['required', 'string', 'max:500'],
        ]);

        $chat = new Chat();
        $chat->listing_id = $request->listing_id;
        $chat->sender_id = auth()->user()->id;
        $chat->receiver_id = $request->receiver_id;
        $chat->message = $request->message;
        $chat->save();

        broadcast(new LiveMessage($chat->message, $chat->receiver_id, $chat->listing_id));

        return response(['status' => 'success', 'message' => 'Sent Successfully']);
    }
    function storeMessages(Request $request)
    {
        $senderId = auth()->user()->id; // Id của người dùng hiện tại, giả sử là Khang
        $receiverId = $request->receiver_id; // Id của người nhận, giả sử là Hương
        $listingId = $request->listing_id; // Id danh sách cụ thể là 1 căn nhà

        $messages = Chat::with('senderInfo')->whereIn('receiver_id', [$senderId, $receiverId]) //Kiểm tra receiver_id(người nhận) có phải là Khang hoặc Hương không. Điều này cho phép lấy các tin nhắn mà người nhận là 1 trong 2
            ->whereIn('sender_id', [$senderId, $receiverId]) // Kiểm tra sender_id(người gửi) có phải là 1 trong 2 hay không. Điều này cũng tương tự như trên đó là cho phép lấy tất cả tin nhắn từ người gửi là Khang hoặc Hương
            ->where('listing_id', $listingId) //Giới hạn truy vấn tin nhắn chỉ trong một danh sách cụ thể mà cả hai đang trao đổi.
            ->orderBy('created_at', 'asc') //Sắp xếp tin nhắn từ cũ đến mới nhất theo thời gian
            ->get();

        /**
         * * Hàm này sẽ query các điều kiện cần của việc click vào box tin nhắn để seen, query đến các dữ liệu cần thiết
         * * sender_id => $receiverId : Với người sender_id ở đây là người nhận vì tin nhắn phải được gửi đi từ người khác để
         * trạng thái có thể cập nhật là 0 đồng nghĩa với việc user hiện tại với vai trò là người nhận nên giá trị là $receiverId.
         * * receiver_id => $senderId : Tương tự với trên thì người nhận sẽ là user hiện tại đăng nhập để nhận tin nhắn nên sẽ là receiver_id
         * * listing_id => $listingId: Với điều kiện listing dùng để query các dữ liệu có listing_id để tránh việc các tin nhắn đều bị
         * seen hoặc unseen trong trường hợp cùng 1 seender và 1 receiver
         * * seeen => 0 là điều kiện sau khi đã tổng hợp hết sẽ đặt giá trị là 0
         * * Hàm update dùng để cập nhật giá trị là seen sau khi đã thỏa mãn các điều kiện trên và khi người dùng click vào sẽ thay đổi là 1
         */
        Chat::where([
            'sender_id' => $receiverId,
            'receiver_id' => $senderId,
            'listing_id' => $listingId,
            'seen' => 0
        ])->update(['seen' => 1]);

        return response($messages);
    }
}
