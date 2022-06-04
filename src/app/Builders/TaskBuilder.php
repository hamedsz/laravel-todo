<?php

namespace TodoApp\app\Builders;


use TodoApp\app\Models\Task;

class TaskBuilder extends BaseBuilder
{
    public function __construct()
    {
        $this->model = Task::query();
    }

    public function user($user=null){
        if ($user){
            $this->model->where('user_id', $user);
        }

        return $this;
    }
}
