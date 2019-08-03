<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JoinGameRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'required|exists:games',
            'name' => 'required|max:20|notInGame',           
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Please enter a game code!',
            'code.exists' => 'Game not found - please check the code!',
            'name.required' => 'Please enter your name!',
            'name.max' => 'Name must be less than 20 characters!',
            'name.not_in_game' => 'A player in the game already has this name!',
        ];
    }
}
