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
}
