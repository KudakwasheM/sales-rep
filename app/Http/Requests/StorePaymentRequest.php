<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
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
            'type' => 'required|string',
            'paid_amount' => 'required|numeric',
            'amount' => 'numeric',
            'reference' => 'required|string',
            'client_id' => 'required|string',
            'created_by' => 'string',
            'plan_id' => 'required',
        ];
    }
}
