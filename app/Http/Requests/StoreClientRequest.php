<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
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
            'name' => 'required|string|max:100',
            'id_number' => 'required|string|max:15',
            'dob' => 'required|date',
            'ec_number' => 'string',
            'home_address' => 'string',
            'work_address' => 'string',
            'type' => 'required|string',
        ];
    }
}
