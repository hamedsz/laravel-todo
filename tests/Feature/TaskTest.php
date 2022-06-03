<?php

use TodoApp\app\Models\Task;

class TaskTest extends \TodoApp\Tests\TestCase
{

    const PAGE_COUNT = 25;

    public function setUp(): void
    {
        parent::setUp();
        $this->loginWithFakeUser();
    }

    private function getListTasksResponse(){
        return $this->get('/api/v1/todo/tasks');
    }

    public function testIndexTasksStatus()
    {
        $response = $this->getListTasksResponse();
        $response->assertStatus(200);
    }

    public function testIndexTasksWithNoData(){
        $response = $this->getListTasksResponse();
        $response->assertJson([
            'items' => [],
            'total_count' => 0,
            'page_count' => self::PAGE_COUNT,
        ]);
    }

    private function createFakeTask(){
        $task = new Task();
        $task->title = 'abcd';
        $task->description = 'abcdefg';
        $task->status = Task::STATUS_TASK_OPEN;
        $this->user->tasks()->save($task);

        return $task;
    }

    private function createFakeTasks($num){
        $tasks = collect();
        for ($i=0; $i< $num; $i++){
            $task = $this->createFakeTask();
            $tasks->add($task);
        }
        return $tasks;
    }

    public function testIndexTasksWithOnePageData(){
        $tasks = $this->createFakeTasks(1);

        $response = $this->getListTasksResponse();
        $response->assertJson([
            'items' => $tasks->toArray(),
            'total_count' => $tasks->count(),
            'page_count' => self::PAGE_COUNT,
        ]);
    }

    public function testIndexTasksWithMultiplePageData(){
        $tasks = $this->createFakeTasks(30);

        $response = $this->getListTasksResponse();

        $response->assertJson([
            'items' => $tasks->take(self::PAGE_COUNT)->toArray(),
            'total_count' => $tasks->count(),
            'page_count' => self::PAGE_COUNT,
        ]);
    }

    public function testIndexTasksWithMultiplePageDataSecondPage(){
        $tasks = $this->createFakeTasks(30);

        $response = $this->call('GET', '/api/v1/todo/tasks',[
            'page' => 2
        ]);

        $items = $tasks
            ->skip(25)
            ->take(5)
            ->toArray();

        $response->assertJson([
            'items' => $items,
            'total_count' => $tasks->count(),
            'page_count' => self::PAGE_COUNT,
        ]);
    }
}
