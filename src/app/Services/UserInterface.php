<?php

namespace TodoApp\app\Services;

use TodoApp\app\Models\User;

interface UserInterface
{
    public function findByEmail(string $email, bool $kill=true) : ?User;
    public function login(string $email, $password) : array;
    public function getToken(User $user) : string;
    public function make(array $data) : User;
    public function signup(string $email, string $password, array $data=[]) : array;
    public function authResponse(User $user);
}
