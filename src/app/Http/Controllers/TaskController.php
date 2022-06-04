<?php

namespace TodoApp\app\Http\Controllers;

use Illuminate\Http\Request;
use TodoApp\app\Services\TaskInterface;

class TaskController
{
    private $service;

    public function __construct(TaskInterface $service)
    {
        $this->service = $service;
    }


    public function index(Request $request){
        $builder = $this
            ->service
            ->builder()
            ->user(auth()->user()->id)
            ->labels($request->labels)
            ->page($request->page);

        return response()->json(
            $builder->get()
        );
    }
}
