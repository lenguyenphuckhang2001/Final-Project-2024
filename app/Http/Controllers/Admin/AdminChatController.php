<?php

namespace App\Http\Controllers\Admin;

use App\Events\LiveMessage;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class AdminChatController extends Controller
{
    function index(): View
    {
        $receiverId = auth()->user()->id;

        $senders = Chat::with(['senderInfo', 'listingInfo'])
            ->select('sender_id', 'listing_id')
            ->where('receiver_id', $receiverId)
            ->where('sender_id', '!=', $receiverId)
            ->groupBy('sender_id', 'listing_id')
            ->get();

        return view('admin.message.index', compact('senders'));
    }

    function storeMessages(Request $request)
    {
        $receiverId = auth()->user()->id; // Id của người dùng hiện tại, giả sử là Khang
        $senderId = $request->sender_id; // Id của người nhận, giả sử là Hương
        $listingId = $request->listing_id; // Id danh sách cụ thể là 1 căn nhà

        $messages = Chat::with('senderInfo')
            ->whereIn('receiver_id', [$senderId, $receiverId]) //Kiểm tra receiver_id(người nhận) có phải là Khang hoặc Hương không. Điều này cho phép lấy các tin nhắn mà người nhận là 1 trong 2
            ->whereIn('sender_id', [$senderId, $receiverId]) // Kiểm tra sender_id(người gửi) có phải là 1 trong 2 hay không. Điều này cũng tương tự như trên đó là cho phép lấy tất cả tin nhắn từ người gửi là Khang hoặc Hương
            ->where('listing_id', $listingId) //Giới hạn truy vấn tin nhắn chỉ trong một danh sách cụ thể mà cả hai đang trao đổi.
            ->orderBy('created_at', 'asc') //Sắp xếp tin nhắn từ cũ đến mới nhất theo thời gian
            ->get();

        return response($messages);
    }

    function newMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => ['required', 'integer'],
            'listing_id' => ['required', 'integer'],
            'message' => ['required', 'string', 'max:500']
        ]);

        $chat = new Chat();
        $chat->listing_id = $request->listing_id;
        $chat->sender_id = auth()->user()->id;
        $chat->receiver_id = $request->receiver_id;
        $chat->message = $request->message  ;
        $chat->save();

        broadcast(new LiveMessage($chat->message, $chat->sender_id, $chat->receiver_id));

        return response(['status' => 'success', 'message' => 'Sent Successfully']);
    }
}
