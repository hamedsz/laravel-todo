<?php

namespace TodoApp\app\Services;

use TodoApp\app\Builders\TaskBuilder;
use TodoApp\app\Builders\TaskBuilderInterface;
use TodoApp\app\Models\Task;
use TodoApp\app\Models\User;

class TaskService implements TaskInterface
{
    public function builder() : TaskBuilderInterface{
        return TaskBuilder::make();
    }

    public function find($id, User $user, $includeRelations=true) : Task{
        $task = Task::findOrFail($id);

        if ($user->cannot('show', $task)){
            abort(403);
        }

        if ($includeRelations){
            $task->load('labels');
        }

        return $task;
    }
}
