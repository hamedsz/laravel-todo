<?php

namespace TodoApp\app\Builders;


use Illuminate\Database\Query\Builder;
use TodoApp\app\Models\Task;

class TaskBuilder extends BaseBuilder implements TaskBuilderInterface
{
    public function __construct()
    {
        $this->model = Task::query();
    }

    public function user($user=null) : TaskBuilderInterface{
        if ($user){
            $this->model->where('user_id', $user);
        }

        return $this;
    }

    public function labels($labels=null) : TaskBuilderInterface{
        if ($labels){
            $this->model->whereHas('labels', function ($builder) use ($labels){
                $builder->whereIn('label_id', $labels);
            });
        }

        return $this;
    }
}
