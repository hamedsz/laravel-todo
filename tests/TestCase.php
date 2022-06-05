<?php

namespace TodoApp\Tests;


use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use TodoApp\app\Models\Task;
use TodoApp\app\Models\User;
use TodoApp\TodoServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            TodoServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // perform environment setup
    }

    protected function createFakeUser() : User{
        $user = factory(User::class)->make();
        $user->save();
        return $user;
    }

    protected $user;

    protected function auth(User $user=null){
        if (!$user){
            if (!$this->user){
                $user = $this->createFakeUser();
                $this->user = $user;
            }
            else{
                $user = $this->user;
            }
        }

        $this->defaultHeaders = [
            'Authorization' => 'Bearer '. $user->getAuthToken()
        ];
    }



    protected function createFakeTask($userId=null)
    {
        $task = factory(Task::class)->make();
        $task->user_id = $userId ?? $this->user->id;
        $task->save();

        return $task;
    }

    protected function createFakeTasks($num, $userId=null)
    {
        $tasks = collect();
        for ($i = 0; $i < $num; $i++) {
            $task = $this->createFakeTask($userId);
            $tasks->add($task);
        }
        return $tasks;
    }
    public function testBasic(){
        $this->assertTrue(true);
    }
}
