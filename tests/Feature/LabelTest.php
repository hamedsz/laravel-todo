<?php

class LabelTest extends \TodoApp\Tests\TestCase
{

    public function testHamed()
    {
        $response = $this->get('/api/v1/todo/test');

        $response->assertStatus(200);
    }
}
