<?php

namespace TodoApp\app\Services;

use TodoApp\app\Builders\TaskBuilder;
use TodoApp\app\Builders\TaskBuilderInterface;
use TodoApp\app\Models\Task;

class TaskService implements TaskInterface
{
    public function builder() : TaskBuilderInterface{
        return TaskBuilder::make();
    }

    public function find($id, $includeRelations=true) : Task{
        $task = Task::findOrFail($id);

        if ($includeRelations){
            $task->load('labels');
        }

        return $task;
    }
}
