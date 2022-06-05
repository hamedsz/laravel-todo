<?php

namespace TodoApp\app\Services;

use TodoApp\app\Builders\LabelBuilderInterface;

interface LabelInterface
{
    public function builder() : LabelBuilderInterface;
}
