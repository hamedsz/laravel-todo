<?php

namespace TodoApp\app\Models;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    protected $table = 'todo_labels';
    protected $fillable = [
        'label'
    ];

    protected $appends = [
        'tasks_count'
    ];

    public function users(){
        return $this->belongsToMany(User::class, 'todo_label_user', 'label_id', 'user_id');
    }

    public static function add($label, $userId) : Label{
        /** @var Label $label */
        $label = Label::query()->where('label', $label)
            ->firstOrCreate([
                'label' => $label
            ],[
                'label' => $label
            ]);

        $label->users()->sync($userId, false);

        return $label;
    }

    public function tasks(){
        return $this->belongsToMany(Task::class, 'todo_label_task');
    }

    public function getTasksCountAttribute(){
        $tasks = $this->tasks();

        if (auth()->user()){
            $tasks->where('user_id', auth()->user()->id);
        }

        return $tasks->count();
    }
}
