<?php

namespace TodoApp\app\Http\Controllers;

use Illuminate\Http\Request;
use TodoApp\app\Http\Requests\IndexTaskRequest;
use TodoApp\app\Services\TaskInterface;

class TaskController
{
    private $service;

    public function __construct(TaskInterface $service)
    {
        $this->service = $service;
    }


    public function index(IndexTaskRequest $request){
        $builder = $this
            ->service
            ->builder()
            ->user(auth()->user()->id)
            ->includeLabels($request->include_labels)
            ->labels($request->labels)
            ->page($request->page);

        return response()->json(
            $builder->get()
        );
    }

    public function show($id){
        $task = $this->service->find($id);

        return response()->json($task);
    }
}
