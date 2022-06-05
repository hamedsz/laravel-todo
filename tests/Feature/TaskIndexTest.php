<?php

namespace TodoApp\Tests\Feature;

use TodoApp\Tests\TestCase;

class IndexTaskTest extends TestCase
{
    const PAGE_COUNT = 25;

    private function getListTasksResponse()
    {
        return $this->get('/api/v1/todo/tasks');
    }

    public function testWithNoData()
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

    public function testWithOnePageData()
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

    public function testWithMultiplePageData()
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

    public function testWithMultiplePageDataSecondPage()
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

    public function testOnlyAuthenticatedUserTasks(){
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

    public function testFilterByLabel(){
        $this->auth();
        $tasks = $this->createFakeTasks(5);

        $label = \TodoApp\app\Models\Label::add('test', $this->user->id);
        $tasks[0]->labels()->sync([$label->id], false);

        $response = $this->json('GET', '/api/v1/todo/tasks', [
            'labels' => [
                $label->id
            ]
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                "current_page" => 1,
                'from' => 1,
                'last_page' => 1,
                'per_page' => self::PAGE_COUNT,
                'to' => 1,
                'total' => 1,
                'data' => [$tasks[0]->toArray()]
            ]);
    }

    public function testParameterValidations(){
        $this->auth();

        $response = $this->json('GET', '/api/v1/todo/tasks', [
            'page' => 'a'
        ]);

        $response->assertStatus(422);

        $response = $this->json('GET', '/api/v1/todo/tasks', [
            'include_labels' => 'aaa'
        ]);
        $response->assertStatus(422);

        $response = $this->json('GET', '/api/v1/todo/tasks', [
            'labels' => 'aaa'
        ]);
        $response->assertStatus(422);

        $response = $this->json('GET', '/api/v1/todo/tasks', [
            'labels' => [
                'aaa'
            ]
        ]);
        $response->assertStatus(422);
    }

    public function testIncludeLabels(){
        $this->auth();
        $tasks = $this->createFakeTasks(5);

        $label = \TodoApp\app\Models\Label::add('test', $this->user->id);
        $tasks[0]->labels()->sync([$label->id], false);
        $tasks[0]->load('labels');

        $response = $this->json('GET', '/api/v1/todo/tasks', [
            'include_labels' => true
        ]);


        $response
            ->assertStatus(200)
            ->assertJson([
                "current_page" => 1,
                'from' => 1,
                'last_page' => 1,
                'per_page' => self::PAGE_COUNT,
                'to' => 5,
                'total' => 5,
                'data' => $tasks->toArray()
            ]);
    }
}
