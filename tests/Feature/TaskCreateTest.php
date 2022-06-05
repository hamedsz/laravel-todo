<?php

namespace TodoApp\Tests\Feature;

use TodoApp\app\Models\Task;
use TodoApp\Tests\TestCase;

class TaskCreateTest extends TestCase
{
    public function testCreateTask(){
        $this->auth();

        $data = [
            'title' => 'hello',
            'description' => 'hi'
        ];

        $response = $this->json('POST', '/api/v1/todo/tasks/', $data);
        $response->assertStatus(204);


        $task = Task::query()->first();
        $this->assertNotNull($task);

        $this->assertEquals($task->title, $data['title']);
        $this->assertEquals($task->description, $data['description']);
    }

    public function testCreateTaskValidations(){
        $this->auth();

        //required title
        $response = $this->json('POST', '/api/v1/todo/tasks/', [
            'description' => 'hi',
        ]);
        $response->assertStatus(422);

        //title type
        $response = $this->json('POST', '/api/v1/todo/tasks/', [
            'title' => 11,
            'description' => 'hi'
        ]);
        $response->assertStatus(422);

        //desc type
        $response = $this->json('POST', '/api/v1/todo/tasks/', [
            'title' => 'aaaa',
            'description' => 111,
        ]);
        $response->assertStatus(422);
    }
}
