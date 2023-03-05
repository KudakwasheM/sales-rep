<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'string|max:55',
            'username' => 'string',
            'ec_number' => 'string',
            'email' => 'email',
            'phone' => 'string',
            'role_id' => 'numeric',
            'password' => ['confirmed', Password::min(8)->letters()->symbols()],
        ];
    }
}
