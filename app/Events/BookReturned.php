<?php

namespace App\Events;

use App\Models\Borrow;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class BookReturned
{
    use Dispatchable, InteractsWithSockets, SerializesModels;



    /**
     * the Borrow that was returned
     */
    public Borrow $borrow;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Borrow $borrow)
    {
        $this->borrow = $borrow;
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
