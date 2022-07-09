<?php

namespace App\Events;

use App\Models\ParentCh;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EmployeeChatListener implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $employee_id;
    public $parent;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message, $employee_id, $parent)
    {
        $this->message = $message;
        $this->parent = $parent;
        $this->employee_id = $employee_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('employeeChatListener.' . $this->employee_id);
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->message,
            'parent_id' => $this->parent->id,
            'fatherName' => $this->parent->fatherName,
            'fatherLastName' => $this->parent->fatherLastName,
            'motherName' => $this->parent->motherName
        ];
    }
}
