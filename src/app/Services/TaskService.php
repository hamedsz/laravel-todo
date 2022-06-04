<?php

namespace TodoApp\app\Services;

use TodoApp\app\Builders\TaskBuilder;
use TodoApp\app\Builders\TaskBuilderInterface;

class TaskService implements TaskInterface
{
    public function builder() : TaskBuilderInterface{
        return TaskBuilder::make();
    }
}
