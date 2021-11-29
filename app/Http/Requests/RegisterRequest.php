<?php

namespace App\Http\Requests;

use Anik\Form\FormRequest;

class RegisterRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
            'email' => 'required|unique:users|email|max:255',
            'password' => 'required|max:100',
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'mobile_number' => 'required|max:20',
            'gender' => 'required|in:male,female',
            'birthday' => ''
        ];
    }
}
