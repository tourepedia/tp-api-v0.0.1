<?php
namespace App\Events;

use App\Events\Event;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\PrivateChannel;
use App\Models\Task;
use Illuminate\Contracts\Queue\ShouldQueue;

class TaskAssignmentEvent extends Event implements ShouldBroadcast, ShouldQueue
{
    public $task;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($task)
    {
        $this->task = $task;
    }


    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        // return new PrivateChannel("task.{$this->task->id}");
        return ['my-channel'];
    }
}
