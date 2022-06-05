<?php

namespace TodoApp\Tests\Feature;

use TodoApp\app\Models\Label;
use TodoApp\Tests\TestCase;

class LabelCreateTest extends TestCase
{
    public function testCreate(){
        $this->auth();

        $data = [
            'label' => 'hello'
        ];

        $response = $this->json('POST', '/api/v1/todo/labels', $data);
        $response->assertStatus(204);

        $label = Label::query()->first();
        $this->assertNotNull($label);

        $this->assertEquals($label->label, $data['label']);
    }

    public function testCreateValidations(){
        $this->auth();

        $response = $this->json('POST', '/api/v1/todo/labels', [
            'label' => 111
        ]);
        $response->assertStatus(422);

        $response = $this->json('POST', '/api/v1/todo/labels', []);
        $response->assertStatus(422);
    }
}
