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
            'description' => 'hi',
            'labels' => [
                'hamed',
                'sz'
            ]
        ];

        $response = $this->json('POST', '/api/v1/todo/tasks/', $data);
        $response->assertStatus(204);


        $task = Task::query()->first();
        $this->assertNotNull($task);

        $this->assertEquals($task->title, $data['title']);
        $this->assertEquals($task->description, $data['description']);
        $this->assertEquals($task->labels()->count(), count($data['labels']));
        $this->assertEquals($task->labels[0]->label, 'hamed');
        $this->assertEquals($task->labels[1]->label, 'sz');
    }

    public function testCreateTaskValidations(){
        $this->auth();

        //required title
        $response = $this->json('POST', '/api/v1/todo/tasks/', [
            'description' => 'hi',
            'labels' => [
                'hamed',
                'sz'
            ]
        ]);
        $response->assertStatus(422);


        //title type
        $response = $this->json('POST', '/api/v1/todo/tasks/', [
            'title' => 11,
            'description' => 'hi',
            'labels' => [
                'hamed',
                'sz'
            ]
        ]);
        $response->assertStatus(422);

        //desc type
        $response = $this->json('POST', '/api/v1/todo/tasks/', [
            'title' => 'aaaa',
            'description' => 111,
            'labels' => [
                'hamed',
                'sz'
            ]
        ]);
        $response->assertStatus(422);

        //labels type
        $response = $this->json('POST', '/api/v1/todo/tasks/', [
            'title' => 'aaaa',
            'description' => 111,
            'labels' => 'aaaa'
        ]);
        $response->assertStatus(422);
    }
}
