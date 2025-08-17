<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChangeStatusOrderEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $orderStatus;
    public $id;
    /**
     * Create a new event instance.
     */
    public function __construct($orderStatus, $id)
    {
        $this->orderStatus = $orderStatus;
        $this->id = $id;
    }

    public function broadcastOn()
    {
        return ['order-channel'];
    }

    public function broadcastAs()
    {
        return 'orderstatus-event';
    }
}
