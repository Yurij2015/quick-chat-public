<?php

namespace App\Events;

use App\Http\Resources\MessageResource;
use App\Models\Message;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public array $message;

    public function __construct(Message $message)
    {
        $message->load('sender');
        $this->message = new MessageResource($message)->resolve();
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.'.$this->message['receiver_id']),
        ];
    }

    public function broadcastWith(): array
    {
        return ['message' => $this->message];
    }
}
