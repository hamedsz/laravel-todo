<?php

namespace TodoApp\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddLabelTaskRequest extends FormRequest
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
            'labels' => ['required', 'array'],
            'labels.*' => ['required', 'exists:todo_labels,id'],
        ];
    }
}
