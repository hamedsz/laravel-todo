<?php

namespace TodoApp\app\Services;

use TodoApp\app\Builders\LabelBuilder;
use TodoApp\app\Builders\LabelBuilderInterface;
use TodoApp\app\Models\Label;
use TodoApp\app\Models\User;

class LabelService implements LabelInterface
{
    public function builder() : LabelBuilderInterface{
        return  LabelBuilder::make();
    }

    public function create(string $label, User $user) : Label{
        return Label::add($label, $user);
    }
}
