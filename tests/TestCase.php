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
        $this->loginWithFakeUser();
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

    protected $user;


    protected function loginWithFakeUser()
    {
        if (!$this->user){
            $user = new User();
            $user->id = 1;
            $user->name = 'hamed';
            $user->email = 'hamed@mail.com';
            $user->password = bcrypt('password');
            $user->save();
            $this->user = $user;
        }

        $this->be($this->user);
    }
}
