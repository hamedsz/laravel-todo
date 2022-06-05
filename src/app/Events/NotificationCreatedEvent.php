<?php

namespace TodoApp\app\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use TodoApp\app\Models\Notification;
use TodoApp\app\Models\Task;

class NotificationCreatedEvent
{
    use Dispatchable, SerializesModels;

    public $notification;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }
}
