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
            ->groupBy('receiver_id', 'listing_id') //Nhóm các bản ghi theo receiver_id và listing_id giúp loại bỏ các bản ghi trùng lặp chỉ giữ lại 1 bản nhất cho receiver. Ví dụ, người nhận chỉ xuất hiện một lần trong kết quả chatbox.
            ->get();

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

        broadcast(new LiveMessage($chat->message, $chat->sender_id, $chat->receiver_id));

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
        return response($messages);
    }
}
