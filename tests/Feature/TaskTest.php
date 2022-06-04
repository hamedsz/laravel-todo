<?php

use TodoApp\app\Models\Task;

class TaskTest extends \TodoApp\Tests\TestCase
{

    const PAGE_COUNT = 25;

    public function setUp(): void
    {
        parent::setUp();
    }

    private function getListTasksResponse()
    {
        return $this->get('/api/v1/todo/tasks');
    }

    public function testIndexTasksWithNoData()
    {
        $this->auth();

        $response = $this->getListTasksResponse();

        $response
            ->assertStatus(200)
            ->assertJson([
                "current_page" => 1,
                'from' => null,
                'last_page' => 1,
                'per_page' => self::PAGE_COUNT,
                'to' => null,
                'total' => 0,
                'data' => []
            ]);
    }

    private function createFakeTask($userId=null)
    {
        $task = new Task();
        $task->title = 'abcd';
        $task->description = 'abcdefg';
        $task->status = Task::STATUS_TASK_OPEN;
        $task->user_id = $userId ?? $this->user->id;
        $task->save();

        return $task;
    }

    private function createFakeTasks($num, $userId=null)
    {
        $tasks = collect();
        for ($i = 0; $i < $num; $i++) {
            $task = $this->createFakeTask($userId);
            $tasks->add($task);
        }
        return $tasks;
    }

    public function testIndexTasksWithOnePageData()
    {
        $this->auth();
        $tasks = $this->createFakeTasks(1);
        $response = $this->getListTasksResponse();

        $response
            ->assertStatus(200)
            ->assertJson([
                "current_page" => 1,
                'from' => 1,
                'last_page' => 1,
                'per_page' => self::PAGE_COUNT,
                'to' => 1,
                'total' => $tasks->count(),
                'data' => $tasks->toArray()
            ]);
    }

    public function testIndexTasksWithMultiplePageData()
    {
        $this->auth();
        $tasks = $this->createFakeTasks(30);
        $response = $this->getListTasksResponse();

        $response
            ->assertStatus(200)
            ->assertJson([
                "current_page" => 1,
                'from' => 1,
                'last_page' => 2,
                'per_page' => self::PAGE_COUNT,
                'to' => self::PAGE_COUNT,
                'total' => $tasks->count(),
                'data' => $tasks->take(25)->toArray()
            ]);
    }

    public function testIndexTasksWithMultiplePageDataSecondPage()
    {
        $this->auth();
        $tasks = $this->createFakeTasks(30);

        $response = $this->json('GET', '/api/v1/todo/tasks', [
            'page' => 2
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                "current_page" => 2,
                'from' => 26,
                'last_page' => 2,
                'per_page' => self::PAGE_COUNT,
                'to' => $tasks->count(),
                'total' => $tasks->count(),
                'data' => $tasks->skip(25)->take(5)->values()->toArray()
            ]);
    }

    public function testIndexTasksOnlyAuthenticatedUserTasks(){
        $user1 = $this->createFakeUser();
        $user2 = $this->createFakeUser();

        $user1Tasks = $this->createFakeTasks(5 , $user1->id);
        $user2Tasks = $this->createFakeTasks(10 , $user2->id);

        $this->auth($user1);
        $response = $this->getListTasksResponse();

        $response
            ->assertStatus(200)
            ->assertJson([
                "current_page" => 1,
                'from' => 1,
                'last_page' => 1,
                'per_page' => self::PAGE_COUNT,
                'to' => 5,
                'total' => $user1Tasks->count(),
                'data' => $user1Tasks->toArray()
            ]);
    }
}
