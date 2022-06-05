<?php

namespace TodoApp\app\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'todo_tasks';

    protected $fillable = [
        'title',
        'description'
    ];

    const STATUS_TASK_OPEN = 'open';
    const STATUS_TASK_CLOSE = 'close';

    public function labels(){
        return $this->belongsToMany(Label::class, 'todo_label_task', 'task_id', 'label_id');
    }

    public function user(){
        return $this->belongsTo(Task::class);
    }

    public function notifications(){
        return $this->morphMany(Notification::class, 'notificationable');
    }
}
