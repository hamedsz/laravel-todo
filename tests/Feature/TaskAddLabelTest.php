<?php

namespace TodoApp\Tests\Feature;

use TodoApp\app\Models\Label;
use TodoApp\Tests\TestCase;

class TaskAddLabelTest extends TestCase
{
    public function testTaskAddLabel(){
        $this->auth();
        $task = $this->createFakeTask();

        $label1 = Label::add('china', $this->user->id);
        $label2 = Label::add('usa', $this->user->id);

        $response = $this->json('PUT', '/api/v1/todo/tasks/'. $task->id . '/add-label', [
            'labels' => [
                $label1->id,
                $label2->id
            ]
        ]);

        $response->assertStatus(204);

        $this->assertEquals($task->labels()->count(), 2);
        $this->assertEquals($task->labels[0]->label, 'china');
        $this->assertEquals($task->labels[1]->label, 'usa');
    }

    public function testTaskAddLabelValidations(){
        $this->auth();
        $task = $this->createFakeTask();

        $response = $this->json('PUT', '/api/v1/todo/tasks/'. $task->id . '/add-label', [
            'labels' => 'aa'
        ]);
        $response->assertStatus(422);

        $response = $this->json('PUT', '/api/v1/todo/tasks/'. $task->id . '/add-label');
        $response->assertStatus(422);
    }
}
