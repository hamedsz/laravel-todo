<?php

namespace TodoApp\app\Http\Controllers;

use Illuminate\Http\Request;
use TodoApp\app\Services\UserInterface;

class AuthController
{
    private $service;

    public function __construct(UserInterface $service)
    {
        $this->service = $service;
    }

    public function login(Request $request){
        $login = $this->service->login($request->email, $request->password);

        return response()->json($login);
    }
}
