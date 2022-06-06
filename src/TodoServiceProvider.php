<?php

namespace TodoApp;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use TodoApp\app\Events\NotificationCreatedEvent;
use TodoApp\app\Http\Middleware\Authentication;
use TodoApp\app\Listeners\NotificationCreatedListener;
use TodoApp\app\Models\Task;
use TodoApp\app\Policies\TaskPolicy;
use TodoApp\app\Services\LabelInterface;
use TodoApp\app\Services\LabelService;
use TodoApp\app\Services\TaskInterface;
use TodoApp\app\Services\TaskService;
use TodoApp\app\Services\UserInterface;
use TodoApp\app\Services\UserService;

class TodoServiceProvider extends ServiceProvider
{
    public function boot(){
        $this->loadRoutesFrom(__DIR__.'/routes/api.php');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadFactoriesFrom(__DIR__.'/database/factories');
        $this->loadViewsFrom(__DIR__. '/resources/views', 'todo');

        app('router')->aliasMiddleware('todo-auth', Authentication::class);

        Gate::policy(Task::class, TaskPolicy::class);

        $this->app->bind(TaskInterface::class, TaskService::class);
        $this->app->bind(LabelInterface::class, LabelService::class);
        $this->app->bind(UserInterface::class, UserService::class);

        Event::listen(NotificationCreatedEvent::class, NotificationCreatedListener::class);
    }
}
