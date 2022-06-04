<?php

namespace TodoApp\Tests\Feature;

use TodoApp\Tests\TestCase;

class TaskShowTest extends TestCase
{
    public function testShowTask(){
        $this->auth();
        $task = $this->createFakeTask();
        $task->load('labels');

        $response = $this->json('GET', '/api/v1/todo/tasks/'. $task->id);

        $response->assertStatus(200)
            ->assertJson(
                $task->toArray()
            );
    }
}
