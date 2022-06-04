<?php

namespace TodoApp\Tests\Feature;

use TodoApp\app\Models\Task;
use TodoApp\Tests\TestCase;

class TaskUpdateTest extends TestCase
{
    public function testUpdateTask(){
        $this->auth();
        $task = $this->createFakeTask();

        $newTaskData = [
            'title' => 'hamed',
            'description' => 'hamed',
        ];

        $response = $this->json('PUT', '/api/v1/todo/tasks/'. $task->id, $newTaskData);

        $response->assertStatus(204);

        $task = Task::find($task->id);
        $this->assertEquals($task->title, $newTaskData['title']);
        $this->assertEquals($task->description, $newTaskData['description']);
    }

    public function testUpdateTaskValidations(){
        $this->auth();
        $task = $this->createFakeTask();

        $response = $this->json('PUT', '/api/v1/todo/tasks/'. $task->id, [
            'title' => 111,
            'description' => 'hamed',
        ]);
        $response->assertStatus(422);

        $response = $this->json('PUT', '/api/v1/todo/tasks/'. $task->id, [
            'title' => '111',
            'description' => 111,
        ]);
        $response->assertStatus(422);

        $response = $this->json('PUT', '/api/v1/todo/tasks/'. $task->id, [
            'description' => 'aaa',
        ]);
        $response->assertStatus(422);
    }
}
