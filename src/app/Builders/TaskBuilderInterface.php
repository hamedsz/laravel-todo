<?php

namespace TodoApp\app\Builders;

interface TaskBuilderInterface
{
    public function user($user=null) : TaskBuilderInterface;
    public function labels($labels=null) : TaskBuilderInterface;
}
