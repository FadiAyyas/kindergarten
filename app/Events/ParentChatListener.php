<?php

namespace App\Events;

use App\Models\Employee;
use App\Models\ParentCh;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ParentChatListener implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $parent_id;
    public $employee;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message, $parent_id, $employee)
    {
        $this->message = $message;
        $this->employee = $employee;
        $this->parent_id = $parent_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('parentChatListener.' . $this->parent_id);
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->message,
            'employee_id' => $this->employee->id,
            'employee_firstName' => $this->employee->firstName,
            'employee_lastName' => $this->employee->lastName,
        ];
    }
}
