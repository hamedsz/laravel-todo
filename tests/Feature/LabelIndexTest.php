<?php

namespace TodoApp\Tests\Feature;

use Illuminate\Support\Str;
use TodoApp\app\Models\Label;

class LabelTest extends \TodoApp\Tests\TestCase
{
    const PAGE_COUNT = 25;

    private function addLabel(){
        return Label::add(Str::random(10), $this->user);
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
}
