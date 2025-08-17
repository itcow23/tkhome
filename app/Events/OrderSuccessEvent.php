<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderSuccessEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $orderCount;
    /**
     * Create a new event instance.
     */
    public function __construct($order,  $orderCount)
    {
        $this->order = $order;
        $this->orderCount = $orderCount;
    }

    public function broadcastOn()
    {
        return ['order-channel'];
    }

    public function broadcastAs()
    {
        return 'ordersucess-event';
    }
}
