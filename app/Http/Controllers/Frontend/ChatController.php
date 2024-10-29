<?php

namespace App\Http\Controllers\Frontend;

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

        $receivers = Chat::with(['receiverProfile', 'listingInfo']) //Sử dụng receiverProfile và lítingProfile dùng để giảm thông tin liên quan đến profile(id) của người nhận (receiver)
            ->select('receiver_id', 'listing_id') //Chỉ lấy receiver_id và listing_id từ bảng Chat để giảm bớt lượng dữ liệu không cần thiết.
            ->where('sender_id', $senderId) //Đảm bảo chỉ có sender_id là ID của người gửi hiện tại. Điều này nhằm lọc ra tất cả các tin nhắn đã gửi của người dùng hiện tại
            ->where('receiver_id', '!=', $senderId) //Điều kiện này sẽ không lấy những cuộc trò chuyện mà gửi cũng là người nhận
            ->groupBy('receiver_id', 'listing_id') //Nhóm các bản ghi theo receiver_id và listing_id giúp loại bỏ các bản ghi trùng lặp chỉ giữ lại 1 bản nhất cho receiver. Ví dụ, người nhận chỉ xuất hiện một lần trong kết quả chatbox.
            ->get();

        return view('frontend.dashboard.message.index', compact('receivers'));
    }

    function sendMessage(Request $request): Response
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

        return response(['status' => 'success', 'message' => 'Sent Successfully']);
    }
}
