<?php

namespace TodoApp\app\Models;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    protected $table = 'todo_labels';
    protected $fillable = [
        'label'
    ];

    public static function add($label){
        $label = Label::query()->where('label', $label)
            ->firstOrCreate([
                'label' => $label
            ],[
                'label' => $label
            ]);

        return $label;
    }
}
