<?php

namespace TodoApp\app\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'todo_users';

    public function tasks(){
        return $this->hasMany(Task::class, 'user_id');
    }

    public function getAuthToken(){
        return encrypt([
            'id' => $this->id
        ]);
    }

    public function labels(){
        return $this->belongsToMany(Label::class, 'todo_label_user', 'user_id', 'label_id');
    }
}
