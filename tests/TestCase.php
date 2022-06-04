<?php

namespace TodoApp\Tests;


use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
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
}
