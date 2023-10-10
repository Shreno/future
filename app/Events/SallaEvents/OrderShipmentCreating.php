<?php

namespace App\Events\SallaEvents;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OrderShipmentCreating
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $webHookPayloadObject;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($webHookPayloadObject)
    {
        $this->webHookPayloadObject = $webHookPayloadObject;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
