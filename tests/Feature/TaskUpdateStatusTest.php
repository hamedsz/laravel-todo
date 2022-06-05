<?php

namespace TodoApp\Tests\Feature;

use TodoApp\app\Models\Notification;
use TodoApp\app\Models\Task;
use TodoApp\Tests\TestCase;

class TaskUpdateStatusTest extends TestCase
{
    public function testTaskUpdateStatus(){
        $this->auth();
        $task = $this->createFakeTask();

        $response = $this->json('PUT', '/api/v1/todo/tasks/'. $task->id . '/update-status', [
            'status' => Task::STATUS_TASK_CLOSE
        ]);

        $response->assertStatus(204);

        $task = Task::find($task->id);
        $this->assertEquals($task->status, Task::STATUS_TASK_CLOSE);
    }

    public function testTaskUpdateStatusValidation(){
        $this->auth();
        $task = $this->createFakeTask();

        $response = $this->json('PUT', '/api/v1/todo/tasks/'. $task->id . '/update-status', [
            'status' => 'aa'
        ]);
        $response->assertStatus(422);

        $response = $this->json('PUT', '/api/v1/todo/tasks/'. $task->id . '/update-status');
        $response->assertStatus(422);
    }

    public function testTaskUpdateStatusGeneratesNotification(){
        $this->auth();
        $task = $this->createFakeTask();

        $response = $this->json('PUT', '/api/v1/todo/tasks/'. $task->id . '/update-status', [
            'status' => Task::STATUS_TASK_CLOSE
        ]);
        $response->assertStatus(204);

        $notification = $task->notifications()->first();
        $this->assertNotNull($notification, 'Notification is not generated.');

        $this->assertEquals($notification->message, 'Task is closed');
    }
}
