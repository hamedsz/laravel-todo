<?php

namespace TodoApp\app\Services;

use TodoApp\app\Builders\TaskBuilderInterface;
use TodoApp\app\Models\Task;
use TodoApp\app\Models\User;

interface TaskInterface
{
    public function builder() : TaskBuilderInterface;
    public function find($id, User $user, $includeRelations=true) : Task;
    public function create(array $data, User $user) : Task;
    public function addLabels(Task $task, array $labels);
    public function update(int $taskId, array $data, User $user);
    public function updateStatus(int $taskId, string $status, User $user);
}
