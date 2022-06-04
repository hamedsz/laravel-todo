<?php

namespace TodoApp\app\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'todo_tasks';

    const STATUS_TASK_OPEN = 'open';
    const STATUS_TASK_CLOSE = 'close';

    public function labels(){
        return $this->belongsToMany(Label::class, 'todo_label_task', 'task_id', 'label_id');
    }
}
