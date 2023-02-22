<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'type' => $this->type,
            'amount' => $this->amount,
            'reference' => $this->reference,
            'client_id' => $this->client_id,
            'plan_id' => $this->plan_id,
            'created_by' => $this->created_by
        ];
    }
}
