<?php

namespace TodoApp\app\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use TodoApp\app\Models\Task;
use TodoApp\app\Models\User;

class TaskPolicy
{
    use HandlesAuthorization;

    public function show(User $user, Task $task){
        return $task->user_id === $user->id;
    }
}
