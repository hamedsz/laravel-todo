<?php

namespace TodoApp\app\Http\Controllers;

use Illuminate\Http\Request;
use TodoApp\app\Http\Requests\CreateTaskRequest;
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
        $task = $this->service->find(
            $id,
            auth()->user()
        );

        return response()->json($task);
    }

    public function store(CreateTaskRequest $request){
        $this->service->create(
            $request->all(),
            auth()->user()
        );

        return response()->noContent();
    }

    public function update(Request $request, $id){
        $this->service->update(
            $id,
            $request->all(),
            auth()->user()
        );

        return response()->noContent();
    }
}
