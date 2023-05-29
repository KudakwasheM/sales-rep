<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{
    public static $wrap = false;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'battery_type' => $this->battery_type,
            'installments' => $this->installments,
            'paid_installments' => $this->paid_installments,
            'deposit' => $this->deposit,
            'battery_number' => $this->battery_number,
            'balance' => $this->balance,
            'client_id' => $this->client_id,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
