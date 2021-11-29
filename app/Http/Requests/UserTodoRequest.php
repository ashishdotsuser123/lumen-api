<?php

namespace App\Http\Requests;

use Anik\Form\FormRequest;

class UserTodoRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
            'user_category_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'todo_date' => 'required',
            'status' => 'required'
        ];
    }
}
