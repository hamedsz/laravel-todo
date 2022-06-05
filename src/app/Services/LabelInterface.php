<?php

namespace TodoApp\app\Services;

use TodoApp\app\Builders\LabelBuilderInterface;
use TodoApp\app\Models\Label;
use TodoApp\app\Models\User;

interface LabelInterface
{
    public function builder() : LabelBuilderInterface;
    public function create(string $label, User $user) : Label;
}
