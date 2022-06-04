<?php

namespace TodoApp;

use Illuminate\Support\ServiceProvider;
use TodoApp\app\Http\Middleware\Authentication;
use TodoApp\app\Services\TaskInterface;
use TodoApp\app\Services\TaskService;

class TodoServiceProvider extends ServiceProvider
{
    public function boot(){
        $this->loadRoutesFrom(__DIR__.'/routes/api.php');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadFactoriesFrom(__DIR__.'/database/factories');
        app('router')->aliasMiddleware('todo-auth', Authentication::class);

        $this->app->bind(TaskInterface::class, TaskService::class);
    }
}