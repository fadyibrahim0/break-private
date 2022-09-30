<?php

namespace App\Events;

use App\Models\BreakModel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BreakRequestHandled implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $break;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($break)
    {
        $this->break = $break;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('supervisors.' . $this->break->employee->supervisor_id);
    }

    public function broadcastWith()
    {
        return [
            "requestId" => $this->break->id,
            "pendingRequests" => BreakModel::getPendingRequestsCount($this->break->employee->supervisor_id),
        ];
    }
}
