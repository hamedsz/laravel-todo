<?php

namespace TodoApp\app\Services;

use TodoApp\app\Builders\TaskBuilder;
use TodoApp\app\Builders\TaskBuilderInterface;
use TodoApp\app\Models\Label;
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

    public function addLabels(Task $task, array $labels){
        foreach ($labels as $item){
            $label = Label::add($item);
            $task->labels()->sync($label->id, false);
        }
    }

    public function create(array $data, User $user) : Task{
        $task = new Task($data);
        $task->user_id = $user->id;
        $task->save();
        $this->addLabels($task, $data['labels']);

        return $task;
    }

    public function update(int $taskId, array $data, User $user){
        $task = $this->find($taskId, $user);
        $task->fill($data);
        $task->save();
    }

    public function updateStatus(int $taskId, string $status, User $user){
        $task = $this->find($taskId, $user);
        $task->status = $status;
        $task->save();
    }
}
