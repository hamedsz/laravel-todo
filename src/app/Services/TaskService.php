<?php

namespace TodoApp\app\Services;

use TodoApp\app\Builders\TaskBuilder;

class TaskService implements TaskInterface
{
    public function builder(){
        return TaskBuilder::make();
    }
}
