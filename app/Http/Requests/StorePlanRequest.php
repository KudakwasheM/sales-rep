<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlanRequest extends FormRequest
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
            'amount' => 'required',
            'battery_type' => 'required|string',
            'installments' => 'required|numeric',
            'paid_installments' => 'required|numeric',
            'deposit' => 'required',
            'balance' => 'required',
            'client_id' => 'required'
        ];
    }
}
