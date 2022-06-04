<?php

namespace TodoApp\app\Services;

use TodoApp\app\Builders\TaskBuilderInterface;

interface TaskInterface
{
    public function builder() : TaskBuilderInterface;
}
