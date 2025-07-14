<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\User;

class ChatEventClass implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $user_id;

    public function __construct($message, $user_id)
    {
        $this->message = $message;
        $this->user_id = $user_id;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.global'),
        ];
    }

    public function broadcastWith()
    {
        $user = User::find($this->user_id);
        return [
            'user_id' => $this->user_id,
            'username' => $user->first_name . ' ' . $user->last_name,
            'message' => $this->message,
            'timestamp' => now()->format('H:i A'),
            'avatar' => ucfirst($user->first_name[0]),
        ];
    }

}
