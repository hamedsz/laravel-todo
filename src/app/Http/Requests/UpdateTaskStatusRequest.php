<?php

namespace TodoApp\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use TodoApp\app\Models\Task;

class UpdateTaskStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => ['required' , 'in:'. Task::STATUS_TASK_OPEN. ','. Task::STATUS_TASK_CLOSE]
        ];
    }
}
