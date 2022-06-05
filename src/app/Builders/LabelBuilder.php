<?php

namespace TodoApp\app\Builders;


use TodoApp\app\Models\Label;

class LabelBuilder extends BaseBuilder implements LabelBuilderInterface
{
    public function __construct()
    {
        $this->model = Label::query();
    }
}
