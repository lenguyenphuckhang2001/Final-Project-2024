<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LiveMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $receiverId;
    public $listingId;

    /**
     * Create a new event instance.
     */
    public function __construct($message, $receiverId, $listingId)
    {
        $this->message = $message;
        $this->receiverId = $receiverId;
        $this->listingId = $listingId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat-messages.' . $this->receiverId),
        ];
    }

    function broadcastWith(): array
    {
        $user = auth()->user();
        if ($user) {
            return [
                'message' => $this->message,
                'receiver_id' => $this->receiverId,
                'listing_id' => $this->listingId,
                'user' => $user->only(['id', 'name', 'avatar'])
            ];
        }

        // Trả về một mảng rỗng nếu không có người dùng hợp lệ
        return [];
    }
}
