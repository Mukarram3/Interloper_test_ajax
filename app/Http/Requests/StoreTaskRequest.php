<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules() : array
    {
        return [
            'title' => ['required'],
            'description' => ['required'],
            'due_date' => ['required'],
            'priority' => ['required'],
        ];
    }

    public function messages(){
        return [
            'title.required' => 'Task unique name is required',
            'description.required' => 'Description is required',
            'due_date.required' => 'Task Due date is required',
            'priority.required' => 'Task Priority is required'
        ];
    }
}
