<?php

namespace TodoApp\app\Models;

use Illuminate\Database\Eloquent\Model;
use TodoApp\app\Events\NotificationCreatedEvent;

class Notification extends Model
{
    protected $table = 'todo_notifications';

    protected $dispatchesEvents = [
        'created' => NotificationCreatedEvent::class
    ];

    public static function generate($notifable , $message){
        $notif = new Notification();
        $notif->notificationable_id = $notifable->id;
        $notif->notificationable_type = get_class($notifable);
        $notif->message = $message;
        $notif->save();
    }
}
