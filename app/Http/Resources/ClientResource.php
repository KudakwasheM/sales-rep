<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            'name' => $this->name,
            'id_number' => $this->id_number,
            'dob' => $this->dob,
            'ec_number' => $this->ec_number,
            'type' => $this->type,
            'battery_number' => $this->battery_number,
            'docs' => $this->docs,
            'created_by' => $this->created_by
        ];
    }
}