<?php

namespace TodoApp\app\Models;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    protected $table = 'todo_labels';
    protected $fillable = [
        'label'
    ];

    public function users(){
        return $this->belongsToMany(User::class, 'todo_label_user', 'label_id', 'user_id');
    }

    public static function add($label, $userId){
        $label = Label::query()->where('label', $label)
            ->firstOrCreate([
                'label' => $label
            ],[
                'label' => $label
            ]);

        $label->users()->sync($userId, false);

        return $label;
    }
}
