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

    public function testCanUserAccessOtherUsersTasks(){
        $this->auth();

        $otherUser = $this->createFakeUser();
        $otherUserTask = $this->createFakeTask($otherUser->id);

        $response = $this->json('GET', '/api/v1/todo/tasks/'. $otherUserTask->id);

        $response->assertStatus(403);
    }

    public function testNotFoundTask(){
        $this->auth();

        $response = $this->json('GET', '/api/v1/todo/tasks/'. 22);

        $response->assertStatus(404);
    }
}
