<?php

namespace TodoApp\app\Services;

use TodoApp\app\Builders\TaskBuilderInterface;
use TodoApp\app\Models\Task;
use TodoApp\app\Models\User;

interface TaskInterface
{
    public function builder() : TaskBuilderInterface;
    public function find($id, User $user, $includeRelations=true) : Task;
}
