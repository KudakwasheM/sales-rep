<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlanRequest extends FormRequest
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
            'amount' => 'numeric',
            'battery_type' => 'string',
            'installments' => 'numeric',
            'paid_installments' => 'numeric',
            'deposit' => 'numeric',
            'balance' => 'numeric',
            'client_id' => 'numeric'
        ];
    }
}
