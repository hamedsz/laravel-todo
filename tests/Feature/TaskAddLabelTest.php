<?php

namespace TodoApp\Tests\Feature;

use TodoApp\app\Models\Task;
use TodoApp\Tests\TestCase;

class TaskAddLabelTest extends TestCase
{
    public function testTaskAddLabel(){
        $this->auth();
        $task = $this->createFakeTask();

        $response = $this->json('PUT', '/api/v1/todo/tasks/'. $task->id . '/add-label', [
            'labels' => [
                'china',
                'usa'
            ]
        ]);

        $response->assertStatus(204);

        $this->assertEquals($task->labels()->count(), 2);
        $this->assertEquals($task->labels[0]->label, 'china');
        $this->assertEquals($task->labels[1]->label, 'usa');
    }

    public function testTaskAddLabelValidations(){
        $this->auth();
        $task = $this->createFakeTask();

        $response = $this->json('PUT', '/api/v1/todo/tasks/'. $task->id . '/add-label', [
            'labels' => 'aa'
        ]);
        $response->assertStatus(422);

        $response = $this->json('PUT', '/api/v1/todo/tasks/'. $task->id . '/add-label');
        $response->assertStatus(422);
    }
}
