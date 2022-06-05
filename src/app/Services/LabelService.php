<?php

namespace TodoApp\app\Services;

use TodoApp\app\Builders\LabelBuilder;
use TodoApp\app\Builders\LabelBuilderInterface;

class LabelService implements LabelInterface
{
    public function builder() : LabelBuilderInterface{
        return  LabelBuilder::make();
    }
}
