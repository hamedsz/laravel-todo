<?php

namespace TodoApp\app\Listeners;

use Illuminate\Support\Facades\Mail;
use TodoApp\app\Events\NotificationCreatedEvent;
use TodoApp\app\Mail\TaskClosed;

class NotificationCreatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(NotificationCreatedEvent $event)
    {
        Mail::to($event->notification->user->email)->send(new TaskClosed());
    }
}
