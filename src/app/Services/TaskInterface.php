<?php

namespace TodoApp\app\Services;

use TodoApp\app\Builders\TaskBuilderInterface;
use TodoApp\app\Models\Task;

interface TaskInterface
{
    public function builder() : TaskBuilderInterface;
    public function find($id, $includeRelations=true) : Task;
}
