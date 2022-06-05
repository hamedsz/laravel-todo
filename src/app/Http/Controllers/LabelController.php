<?php

namespace TodoApp\app\Http\Controllers;

use Illuminate\Http\Request;
use TodoApp\app\Http\Requests\CreateLabelRequest;
use TodoApp\app\Services\LabelInterface;

class LabelController
{
    private $service;

    public function __construct(LabelInterface $service)
    {
        $this->service = $service;
    }

    public function index(Request $request){
        $builder = $this->service
            ->builder()
            ->page($request->page);

        return response()->json(
            $builder->get()
        );
    }

    public function store(CreateLabelRequest $request){
        $this->service
            ->create($request->label, auth()->user());

        return response()->noContent();
    }
}
