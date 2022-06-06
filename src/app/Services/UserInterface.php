<?php

namespace TodoApp\app\Services;

use TodoApp\app\Models\User;

interface UserInterface
{
    public function findByEmail(string $email) : User;
    public function login(string $email, $password) : array;
    public function getToken(User $user) : string;
}
