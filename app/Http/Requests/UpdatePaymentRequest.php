<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentRequest extends FormRequest
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
            'type' => 'string',
            'paid_amount' => 'numeric',
            'amount' => 'numeric',
            'reference' => 'string',
            'client_id' => 'string',
            'plan_id' => 'string',
            'created_by' => 'string'
        ];
    }
}
