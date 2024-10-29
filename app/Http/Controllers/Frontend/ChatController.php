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
        return view('frontend.dashboard.message.index');
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
