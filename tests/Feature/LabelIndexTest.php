<?php

namespace TodoApp\Tests\Feature;

use Illuminate\Support\Str;
use TodoApp\app\Models\Label;
use TodoApp\Tests\TestCase;

class LabelTest extends TestCase
{
    const PAGE_COUNT = 25;

    private function addLabel(){
        return Label::add(Str::random(10), $this->user);
    }
    private function addLabels($num){
        $labels = collect();
        for ($i=0; $i<$num; $i++){
            $labels->add($this->addLabel());
        }
        return $labels;
    }

    public function testWithNoData(){
        $this->auth();
        $response = $this->json('GET', '/api/v1/todo/labels');

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

    public function testWithOnePageData(){
        $this->auth();

        $label = $this->addLabel();

        $response = $this->json('GET', '/api/v1/todo/labels');

        $response
            ->assertStatus(200)
            ->assertJson([
                "current_page" => 1,
                'from' => 1,
                'last_page' => 1,
                'per_page' => self::PAGE_COUNT,
                'to' => 1,
                'total' => 1,
                'data' => [
                    $label->toArray()
                ]
            ]);
    }

    public function testWithMultiplePageData(){
        $this->auth();
        $labels = $this->addLabels(30);
        $response = $this->json('GET', '/api/v1/todo/labels', [
            'page' => 1
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                "current_page" => 1,
                'from' => 1,
                'last_page' => 2,
                'per_page' => self::PAGE_COUNT,
                'to' => self::PAGE_COUNT,
                'total' => $labels->count(),
                'data' => $labels->take(25)->toArray()
            ]);
    }

    public function testWithMultiplePageDataPageTwo(){
        $this->auth();
        $labels = $this->addLabels(30);
        $response = $this->json('GET', '/api/v1/todo/labels', [
            'page' => 2
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                "current_page" => 2,
                'from' => 26,
                'last_page' => 2,
                'per_page' => self::PAGE_COUNT,
                'to' => 30,
                'total' => $labels->count(),
                'data' => $labels->skip(25)->take(5)->values()->toArray()
            ]);
    }

    public function testContainsTotalTasks(){
        $this->auth();

        $label = $this->addLabel();

        $response = $this->json('GET', '/api/v1/todo/labels');

        $response
            ->assertStatus(200)
            ->assertJson([
                "current_page" => 1,
                'from' => 1,
                'last_page' => 1,
                'per_page' => self::PAGE_COUNT,
                'to' => 1,
                'total' => 1,
                'data' => [
                    [
                        'tasks_count' => 0
                    ]
                ]
            ]);
    }

    public function testContainsTotalTasksWithOneTask(){
        $this->auth();

        $label = $this->addLabel();
        $task = $this->createFakeTask();
        $task->labels()->sync($label->id);


        $response = $this->json('GET', '/api/v1/todo/labels');

        $response
            ->assertStatus(200)
            ->assertJson([
                "current_page" => 1,
                'from' => 1,
                'last_page' => 1,
                'per_page' => self::PAGE_COUNT,
                'to' => 1,
                'total' => 1,
                'data' => [
                    [
                        'tasks_count' => 1
                    ]
                ]
            ]);
    }

    public function testContainsTotalTasksNotContainsOtherUserTasks(){
        $this->auth();

        $label = $this->addLabel();

        $user = $this->createFakeUser();
        $task = $this->createFakeTask($user->id);
        $task->labels()->sync($label->id);


        $response = $this->json('GET', '/api/v1/todo/labels');

        $response
            ->assertStatus(200)
            ->assertJson([
                "current_page" => 1,
                'from' => 1,
                'last_page' => 1,
                'per_page' => self::PAGE_COUNT,
                'to' => 1,
                'total' => 1,
                'data' => [
                    [
                        'tasks_count' => 0
                    ]
                ]
            ]);
    }
}
