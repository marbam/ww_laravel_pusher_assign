<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewGameRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'required|unique:games|max:20'
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Please enter a game code!',
            'code.unique' => 'This code is already in use, please enter another!',
            'code.max' => 'Please enter fewer than 20 characters!'
        ];
    }
}
